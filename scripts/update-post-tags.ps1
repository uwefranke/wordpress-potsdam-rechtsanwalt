#requires -version 7.0

<#
.SYNOPSIS
    Tags aller WordPress-Beiträge mit KI aktualisieren

.DESCRIPTION
    Durchläuft alle vorhandenen WordPress-Beiträge und generiert automatisch
    passende SEO-optimierte Tags mithilfe von Claude AI.

.PARAMETER CategoryId
    Optional: Nur Beiträge einer bestimmten Kategorie aktualisieren

.PARAMETER Status
    Optional: Nur Beiträge mit bestimmtem Status (publish, draft, etc.)
    Standard: publish

.PARAMETER ReplaceExisting
    Wenn gesetzt, werden vorhandene Tags ersetzt. Sonst werden neue Tags hinzugefügt.

.PARAMETER MaxPosts
    Maximale Anzahl zu verarbeitender Beiträge (Standard: unbegrenzt)

.PARAMETER DryRun
    Testmodus - zeigt nur an, was gemacht würde, ohne zu ändern

.EXAMPLE
    .\update-post-tags.ps1 -Status publish
    Aktualisiert Tags aller veröffentlichten Beiträge

.EXAMPLE
    .\update-post-tags.ps1 -CategoryId 14 -ReplaceExisting
    Ersetzt Tags aller Beiträge in Kategorie 14

.EXAMPLE
    .\update-post-tags.ps1 -MaxPosts 10 -DryRun
    Testlauf für die ersten 10 Beiträge
#>

param(
    [int]$CategoryId,
    [string]$Status = "publish",
    [switch]$ReplaceExisting,
    [int]$MaxPosts = 0,
    [switch]$DryRun
)

#region Configuration
$ErrorActionPreference = "Stop"

# Farbschema
$Colors = @{
    Header = "Cyan"
    Success = "Green"
    Error = "Red"
    Warning = "Yellow"
    Info = "Blue"
    Debug = "Gray"
}

# Konfiguration aus .env laden
$envPath = Join-Path $PSScriptRoot "..\config\.env"
if (-not (Test-Path $envPath)) {
    Write-Host "❌ Fehler: .env Datei nicht gefunden in: $envPath" -ForegroundColor Red
    Write-Host "   Erstelle zuerst die .env Datei aus .env.example" -ForegroundColor Yellow
    exit 1
}

$Config = @{
    WordPress = @{}
    AI = @{}
    Content = @{}
}

Get-Content $envPath | ForEach-Object {
    if ($_ -match '^\s*([^#][^=]+)=(.*)$') {
        $key = $matches[1].Trim()
        $value = $matches[2].Trim()
        
        switch -Wildcard ($key) {
            "WP_*" { $Config.WordPress[$key.Replace('WP_', '')] = $value }
            "CLAUDE_*" { $Config.AI[$key.Replace('CLAUDE_', '')] = $value }
            "GEMINI_*" { $Config.AI[$key.Replace('GEMINI_', '')] = $value }
            "OPENAI_*" { $Config.AI[$key.Replace('OPENAI_', '')] = $value }
            "AI_*" { $Config.AI[$key.Replace('AI_', '')] = $value }
            "CONTENT_*" { $Config.Content[$key.Replace('CONTENT_', '')] = $value }
        }
    }
}

# Validierung
if (-not $Config.WordPress.Url) { throw "WP_URL nicht in .env definiert" }
if (-not $Config.WordPress.User) { throw "WP_USER nicht in .env definiert" }
if (-not $Config.WordPress.App_Password) { throw "WP_APP_PASSWORD nicht in .env definiert" }
if (-not $Config.AI.Provider) { throw "AI_PROVIDER nicht in .env definiert" }
if (-not $Config.Content.Tag_Count) { $Config.Content.Tag_Count = 5 }

#endregion

#region Helper Functions
function Write-ColorOutput {
    param(
        [string]$Message,
        [string]$Color = "White"
    )
    Write-Host $Message -ForegroundColor $Color
}

function Get-WordPressHeaders {
    $credentials = "$($Config.WordPress.User):$($Config.WordPress.App_Password)"
    $encodedCreds = [Convert]::ToBase64String([Text.Encoding]::ASCII.GetBytes($credentials))
    
    return @{
        "Authorization" = "Basic $encodedCreds"
        "Content-Type" = "application/json"
    }
}

function Test-WordPressConnection {
    try {
        $headers = Get-WordPressHeaders
        $response = Invoke-RestMethod -Uri "$($Config.WordPress.Url)/wp-json/wp/v2/users/me" -Headers $headers -ErrorAction Stop
        Write-ColorOutput "✅ WordPress-Verbindung erfolgreich! Angemeldet als: $($response.name)" -Color $Colors.Success
        return $true
    }
    catch {
        Write-ColorOutput "❌ WordPress-Verbindung fehlgeschlagen: $($_.Exception.Message)" -Color $Colors.Error
        return $false
    }
}
#endregion

#region AI Functions
function Invoke-AIRequest {
    param(
        [string]$SystemPrompt,
        [string]$UserPrompt
    )
    
    $provider = $Config.AI.Provider.ToLower()
    
    switch ($provider) {
        "claude" {
            $apiKey = $Config.AI.API_KEY
            $model = $Config.AI.MODEL
            
            $body = @{
                model = $model
                max_tokens = [int]$Config.AI.MAX_TOKENS
                temperature = [decimal]$Config.AI.TEMPERATURE
                system = $SystemPrompt
                messages = @(
                    @{
                        role = "user"
                        content = $UserPrompt
                    }
                )
            } | ConvertTo-Json -Depth 10
            
            $headers = @{
                "x-api-key" = $apiKey
                "anthropic-version" = "2023-06-01"
                "content-type" = "application/json"
            }
            
            $response = Invoke-RestMethod -Uri "https://api.anthropic.com/v1/messages" `
                -Method Post `
                -Headers $headers `
                -Body $body `
                -ErrorAction Stop
            
            return $response.content[0].text
        }
        "gemini" {
            $apiKey = $Config.AI.API_KEY
            $model = $Config.AI.MODEL
            
            $body = @{
                contents = @(
                    @{
                        parts = @(
                            @{ text = "$SystemPrompt`n`n$UserPrompt" }
                        )
                    }
                )
                generationConfig = @{
                    temperature = [decimal]$Config.AI.TEMPERATURE
                    maxOutputTokens = [int]$Config.AI.MAX_TOKENS
                }
            } | ConvertTo-Json -Depth 10
            
            $url = "https://generativelanguage.googleapis.com/v1beta/$model`:generateContent?key=$apiKey"
            $response = Invoke-RestMethod -Uri $url -Method Post -Body $body -ContentType "application/json" -ErrorAction Stop
            
            return $response.candidates[0].content.parts[0].text
        }
        "openai" {
            $apiKey = $Config.AI.API_KEY
            $model = $Config.AI.MODEL
            
            $body = @{
                model = $model
                max_tokens = [int]$Config.AI.MAX_TOKENS
                temperature = [decimal]$Config.AI.TEMPERATURE
                messages = @(
                    @{
                        role = "system"
                        content = $SystemPrompt
                    },
                    @{
                        role = "user"
                        content = $UserPrompt
                    }
                )
            } | ConvertTo-Json -Depth 10
            
            $headers = @{
                "Authorization" = "Bearer $apiKey"
                "Content-Type" = "application/json"
            }
            
            $response = Invoke-RestMethod -Uri "https://api.openai.com/v1/chat/completions" `
                -Method Post `
                -Headers $headers `
                -Body $body `
                -ErrorAction Stop
            
            return $response.choices[0].message.content
        }
        default {
            throw "Unbekannter AI Provider: $provider"
        }
    }
}

function New-PostTags {
    param(
        [string]$Title,
        [string]$Content
    )
    
    $prompt = @"
Erstelle $($Config.Content.Tag_Count) relevante WordPress-Tags (Schlagwörter) für folgenden Artikel.

Titel: $Title

Anforderungen:
- Fokus auf Mietrecht, Rechtsthemen, Potsdam
- Kurz und prägnant (1-3 Wörter pro Tag)
- SEO-optimiert für lokale Suche
- Keine Sonderzeichen oder Umlaute (nutze ae, oe, ue)
- Nur die Tags ausgeben, getrennt durch Komma

Beispiele: Mietrecht, Schimmelbefall, Mietminderung, Rechtsanwalt Potsdam, Mietvertrag

Artikel-Anfang:
$($Content.Substring(0, [Math]::Min(500, $Content.Length)))
"@
    
    $tagsString = Invoke-AIRequest -SystemPrompt "Du bist ein SEO-Experte für Rechtsthemen." -UserPrompt $prompt
    
    if ($tagsString) {
        # Split und bereinigen
        $tags = $tagsString -split ',' | ForEach-Object { 
            $_.Trim() -replace '[^a-zA-Z0-9äöüß\s-]', '' 
        } | Where-Object { $_ -and $_.Length -gt 2 } | Select-Object -First $Config.Content.Tag_Count
        
        return $tags
    }
    
    return @()
}
#endregion

#region WordPress Functions
function Get-WordPressTagId {
    param([string]$TagName)
    
    try {
        $headers = Get-WordPressHeaders
        
        # Prüfe ob Tag existiert
        $encodedName = [System.Web.HttpUtility]::UrlEncode($TagName)
        $searchUrl = "$($Config.WordPress.Url)/wp-json/wp/v2/tags?search=$encodedName"
        $existingTags = Invoke-RestMethod -Uri $searchUrl -Headers $headers -ErrorAction Stop
        
        # Wenn Tag existiert, gib ID zurück
        $exactMatch = $existingTags | Where-Object { $_.name -eq $TagName }
        if ($exactMatch) {
            return $exactMatch[0].id
        }
        
        # Tag existiert nicht, erstelle neu
        $newTagData = @{ name = $TagName } | ConvertTo-Json
        $createUrl = "$($Config.WordPress.Url)/wp-json/wp/v2/tags"
        $newTag = Invoke-RestMethod -Uri $createUrl -Method Post -Headers $headers -Body $newTagData -ErrorAction Stop
        
        return $newTag.id
    }
    catch {
        return $null
    }
}

function Get-WordPressPosts {
    param(
        [int]$CategoryId,
        [string]$Status = "publish",
        [int]$MaxPosts = 0
    )
    
    $headers = Get-WordPressHeaders
    $allPosts = @()
    $page = 1
    $perPage = 100
    
    do {
        $url = "$($Config.WordPress.Url)/wp-json/wp/v2/posts?status=$Status&per_page=$perPage&page=$page"
        
        if ($CategoryId) {
            $url += "&categories=$CategoryId"
        }
        
        try {
            $posts = Invoke-RestMethod -Uri $url -Headers $headers -ErrorAction Stop
            
            if ($posts) {
                $allPosts += $posts
                
                if ($MaxPosts -gt 0 -and $allPosts.Count -ge $MaxPosts) {
                    $allPosts = $allPosts | Select-Object -First $MaxPosts
                    break
                }
            }
            
            $page++
        }
        catch {
            break
        }
    } while ($posts -and $posts.Count -eq $perPage)
    
    return $allPosts
}

function Update-PostTags {
    param(
        [int]$PostId,
        [array]$NewTags,
        [array]$ExistingTagIds = @(),
        [switch]$Replace
    )
    
    # Tag-Namen in IDs konvertieren
    $newTagIds = @()
    foreach ($tagName in $NewTags) {
        $tagId = Get-WordPressTagId -TagName $tagName
        if ($tagId) {
            $newTagIds += $tagId
        }
    }
    
    # Tags kombinieren oder ersetzen
    if ($Replace) {
        $finalTagIds = $newTagIds
    } else {
        $finalTagIds = ($ExistingTagIds + $newTagIds) | Select-Object -Unique
    }
    
    if ($finalTagIds.Count -eq 0) {
        return $false
    }
    
    # Post aktualisieren
    $headers = Get-WordPressHeaders
    $updateData = @{ tags = $finalTagIds } | ConvertTo-Json
    $url = "$($Config.WordPress.Url)/wp-json/wp/v2/posts/$PostId"
    
    try {
        $response = Invoke-RestMethod -Uri $url -Method Post -Headers $headers -Body $updateData -ErrorAction Stop
        return $true
    }
    catch {
        return $false
    }
}
#endregion

#region Main Script
Write-ColorOutput ""
Write-ColorOutput "╔════════════════════════════════════════════════════════╗" -Color $Colors.Header
Write-ColorOutput "║  WordPress Tags Updater (AI)                          ║" -Color $Colors.Header
Write-ColorOutput "║  Rechtsanwalt Matthias Lange, Potsdam                  ║" -Color $Colors.Header
Write-ColorOutput "╚════════════════════════════════════════════════════════╝" -Color $Colors.Header
Write-ColorOutput ""

if ($DryRun) {
    Write-ColorOutput "⚠️  DRY RUN MODUS - Keine Änderungen werden gespeichert!" -Color $Colors.Warning
    Write-ColorOutput ""
}

# WordPress-Verbindung testen
Write-ColorOutput "🔌 Teste WordPress-Verbindung..." -Color $Colors.Info
if (-not (Test-WordPressConnection)) {
    exit 1
}
Write-ColorOutput ""

# Posts abrufen
Write-ColorOutput "📥 Lade Beiträge..." -Color $Colors.Info
$posts = Get-WordPressPosts -CategoryId $CategoryId -Status $Status -MaxPosts $MaxPosts

if ($posts.Count -eq 0) {
    Write-ColorOutput "⚠️  Keine Beiträge gefunden" -Color $Colors.Warning
    exit 0
}

Write-ColorOutput "   ✅ $($posts.Count) Beiträge gefunden" -Color $Colors.Success
Write-ColorOutput ""
Write-ColorOutput "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -Color $Colors.Header
Write-ColorOutput ""

# Statistiken
$stats = @{
    Total = $posts.Count
    Success = 0
    Failed = 0
    Skipped = 0
}

# Beiträge verarbeiten
for ($i = 0; $i -lt $posts.Count; $i++) {
    $post = $posts[$i]
    $number = $i + 1
    
    Write-ColorOutput "[$number/$($posts.Count)] $($post.title.rendered)" -Color $Colors.Info
    Write-ColorOutput "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -Color $Colors.Debug
    
    try {
        # Content bereinigen (HTML entfernen)
        $cleanContent = $post.content.rendered -replace '<[^>]+>', ' ' -replace '\s+', ' '
        
        # Tags generieren
        Write-ColorOutput "🏷️  Generiere Tags..." -Color $Colors.Info
        $newTags = New-PostTags -Title $post.title.rendered -Content $cleanContent
        
        if ($newTags -and $newTags.Count -gt 0) {
            Write-ColorOutput "   ✅ Tags generiert: $($newTags -join ', ')" -Color $Colors.Success
            
            # Im DryRun-Modus nur anzeigen
            if ($DryRun) {
                Write-ColorOutput "   💭 Würde Tags setzen (DRY RUN)" -Color $Colors.Warning
                $stats.Success++
            }
            else {
                # Tags aktualisieren
                Write-ColorOutput "   💾 Aktualisiere Tags in WordPress..." -Color $Colors.Info
                $result = Update-PostTags -PostId $post.id -NewTags $newTags -ExistingTagIds $post.tags -Replace:$ReplaceExisting
                
                if ($result) {
                    Write-ColorOutput "   ✅ Tags erfolgreich aktualisiert!" -Color $Colors.Success
                    $stats.Success++
                }
                else {
                    Write-ColorOutput "   ❌ Fehler beim Aktualisieren der Tags" -Color $Colors.Error
                    $stats.Failed++
                }
            }
        }
        else {
            Write-ColorOutput "   ⚠️  Keine Tags generiert" -Color $Colors.Warning
            $stats.Skipped++
        }
    }
    catch {
        Write-ColorOutput "   ❌ Fehler: $($_.Exception.Message)" -Color $Colors.Error
        $stats.Failed++
    }
    
    Write-ColorOutput ""
}

# Zusammenfassung
Write-ColorOutput "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -Color $Colors.Header
Write-ColorOutput ""
Write-ColorOutput "📊 Zusammenfassung:" -Color $Colors.Header
Write-ColorOutput "   ✅ Erfolgreich: $($stats.Success)" -Color $Colors.Success
if ($stats.Failed -gt 0) {
    Write-ColorOutput "   ❌ Fehlgeschlagen: $($stats.Failed)" -Color $Colors.Error
}
if ($stats.Skipped -gt 0) {
    Write-ColorOutput "   ⏭️  Übersprungen: $($stats.Skipped)" -Color $Colors.Warning
}
Write-ColorOutput "   📝 Gesamt: $($stats.Total)" -Color $Colors.Info
Write-ColorOutput ""

if ($DryRun) {
    Write-ColorOutput "💡 Führe das Skript ohne -DryRun aus, um die Änderungen zu übernehmen" -Color $Colors.Info
}
else {
    Write-ColorOutput "🎉 Tags-Update abgeschlossen!" -Color $Colors.Success
    Write-ColorOutput "   Prüfe die Beiträge: $($Config.WordPress.Url)/wp-admin/edit.php" -Color $Colors.Info
}

#endregion
