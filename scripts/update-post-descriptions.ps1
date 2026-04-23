#requires -version 7.0

<#
.SYNOPSIS
    Meta-Descriptions aller WordPress-Seiten/Beiträge mit KI aktualisieren

.DESCRIPTION
    Durchläuft alle vorhandenen WordPress-Seiten und Beiträge und generiert automatisch
    SEO-optimierte Meta-Descriptions (150-160 Zeichen) mithilfe von Claude AI.
    Die Descriptions werden als Rank Math Custom Field gespeichert.

.PARAMETER PostType
    Art der Inhalte: 'posts', 'pages' oder 'both' (Standard: both)

.PARAMETER CategoryId
    Optional: Nur Beiträge einer bestimmten Kategorie aktualisieren (nur für posts)

.PARAMETER Status
    Optional: Nur Inhalte mit bestimmtem Status (publish, draft, etc.)
    Standard: publish

.PARAMETER ReplaceExisting
    Wenn gesetzt, werden vorhandene Descriptions ersetzt. Sonst nur leere aktualisieren.

.PARAMETER MaxItems
    Maximale Anzahl zu verarbeitender Inhalte (Standard: unbegrenzt)

.PARAMETER DryRun
    Testmodus - zeigt nur an, was gemacht würde, ohne zu ändern

.EXAMPLE
    .\update-post-descriptions.ps1 -PostType pages
    Aktualisiert Meta-Descriptions aller Seiten

.EXAMPLE
    .\update-post-descriptions.ps1 -PostType posts -CategoryId 14 -ReplaceExisting
    Ersetzt Descriptions aller Beiträge in Kategorie 14

.EXAMPLE
    .\update-post-descriptions.ps1 -MaxItems 5 -DryRun
    Testlauf für die ersten 5 Inhalte
#>

param(
    [ValidateSet('posts', 'pages', 'both')]
    [string]$PostType = "both",
    [int]$CategoryId,
    [string]$Status = "publish",
    [switch]$ReplaceExisting,
    [int]$MaxItems = 0,
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

function Test-CustomMetaReadEndpoint {
    try {
        $headers = Get-WordPressHeaders
        $url = "$($Config.WordPress.Url)/wp-json/potsdam/v1"
        $response = Invoke-RestMethod -Uri $url -Headers $headers -ErrorAction Stop

        if (-not $response.routes) {
            return $false
        }

        $routeKey = '/potsdam/v1/meta-description/(?P<id>\\d+)'
        if (-not $response.routes.$routeKey) {
            return $false
        }

        $methods = $response.routes.$routeKey.methods
        if (-not $methods) {
            return $false
        }

        return ($methods -contains 'GET')
    }
    catch {
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

function New-MetaDescription {
    param(
        [string]$Title,
        [string]$Content,
        [string]$PostType
    )
    
    $contentType = if ($PostType -eq "page") { "Seite" } else { "Artikel" }
    
    $prompt = @"
Erstelle eine SEO-optimierte Meta-Description für folgende WordPress-$contentType.

Titel: $Title

Anforderungen:
- EXAKT 150-160 Zeichen (nicht mehr, nicht weniger!)
- Klare Zusammenfassung des Inhalts
- Handlungsaufforderung integrieren
- Fokus: Rechtsanwalt Matthias Lange, Potsdam
- Keywords: Mietrecht, Immobilienrecht, Baurecht, BU-Versicherung
- Professionell und vertrauenswürdig
- NUR die Description ausgeben, keine Anführungszeichen oder Erklärungen

Beispiel (157 Zeichen):
"Rechtsanwalt Matthias Lange in Potsdam berät Sie kompetent bei Mietrecht, Immobilienrecht und Baurecht. Persönliche Beratung mit langjähriger Erfahrung."

$contentType-Anfang:
$($Content.Substring(0, [Math]::Min(800, $Content.Length)))
"@
    
    $description = Invoke-AIRequest `
        -SystemPrompt "Du bist ein SEO-Experte für Rechtsanwälte. Erstelle präzise Meta-Descriptions mit exakt 150-160 Zeichen." `
        -UserPrompt $prompt
    
    if ($description) {
        # Bereinigen
        $description = $description.Trim() -replace '^["'']|["'']$', '' -replace '\s+', ' '
        
        # Längen-Check
        $length = $description.Length
        Write-ColorOutput "   📏 Länge: $length Zeichen" -Color $(if ($length -ge 150 -and $length -le 160) { $Colors.Success } else { $Colors.Warning })
        
        # Wenn zu lang, kürzen
        if ($length -gt 160) {
            $description = $description.Substring(0, 157) + "..."
            Write-ColorOutput "   ✂️  Gekürzt auf 160 Zeichen" -Color $Colors.Warning
        }
        
        # Wenn zu kurz, warnen
        if ($length -lt 150) {
            Write-ColorOutput "   ⚠️  Kürzer als empfohlen (150 Zeichen)" -Color $Colors.Warning
        }
        
        return $description
    }
    
    return $null
}

function New-FocusKeyword {
    param(
        [string]$Title,
        [string]$Content,
        [string]$PostType
    )

    $contentType = if ($PostType -eq "page") { "Seite" } else { "Artikel" }

    $prompt = @"
Erstelle ein Fokus-Schluesselwort fuer Rank Math fuer folgende WordPress-$contentType.

Titel: $Title

Anforderungen:
- Nur EIN Fokus-Schluesselwort bzw. eine kurze Keyphrase
- 2 bis 5 Woerter
- Maximal 60 Zeichen
- Keine Satzzeichen am Ende
- Keine Erklaerung, nur die Keyphrase ausgeben
- Fokus auf Suchintention im juristischen Kontext in Potsdam

$contentType-Anfang:
$($Content.Substring(0, [Math]::Min(400, $Content.Length)))
"@

    $keyword = Invoke-AIRequest `
        -SystemPrompt "Du bist ein SEO-Experte fuer Rechtsanwaelte. Gib nur eine klare Fokus-Keyphrase aus." `
        -UserPrompt $prompt

    if ($keyword) {
        $keyword = $keyword.Trim() -replace '^"|"$', '' -replace '\s+', ' '
        $keyword = $keyword.TrimEnd('.', ',', ';', ':', '!', '?')

        if ($keyword.Length -gt 60) {
            $keyword = $keyword.Substring(0, 60).Trim()
        }

        if ([string]::IsNullOrWhiteSpace($keyword)) {
            return $null
        }

        return $keyword
    }

    return $null
}
#endregion

#region WordPress Functions
function Get-WordPressItems {
    param(
        [string]$Type,
        [int]$CategoryId,
        [string]$Status = "publish",
        [int]$MaxItems = 0
    )
    
    $headers = Get-WordPressHeaders
    $allItems = @()
    $page = 1
    $perPage = 100
    
    do {
        $url = "$($Config.WordPress.Url)/wp-json/wp/v2/$Type`?status=$Status&per_page=$perPage&page=$page"
        
        if ($CategoryId -and $Type -eq "posts") {
            $url += "&categories=$CategoryId"
        }
        
        try {
            $items = Invoke-RestMethod -Uri $url -Headers $headers -ErrorAction Stop
            
            if ($items) {
                $allItems += $items
                
                if ($MaxItems -gt 0 -and $allItems.Count -ge $MaxItems) {
                    $allItems = $allItems | Select-Object -First $MaxItems
                    break
                }
            }
            
            $page++
        }
        catch {
            break
        }
    } while ($items -and $items.Count -eq $perPage)
    
    return $allItems
}

function Get-PostMeta {
    param(
        [int]$PostId,
        [string]$PostType
    )
    
    try {
        $headers = Get-WordPressHeaders
        $url = "$($Config.WordPress.Url)/wp-json/potsdam/v1/meta-description/$PostId"
        $response = Invoke-RestMethod -Uri $url -Headers $headers -ErrorAction Stop
        
        $result = @{
            Description = $null
            FocusKeyword = $null
        }

        if ($response.success) {
            if ($response.description) {
                $result.Description = $response.description
            }

            if ($response.focus_keyword) {
                $result.FocusKeyword = $response.focus_keyword
            }
        }

        return $result
    }
    catch {
        return @{
            Description = $null
            FocusKeyword = $null
        }
    }
}

function Update-PostMetaDescription {
    param(
        [int]$PostId,
        [string]$PostType,
        [string]$Description,
        [string]$FocusKeyword
    )
    
    $headers = Get-WordPressHeaders
    
    # Nutze Custom REST API Endpoint für Rank Math Meta-Description
    $updateData = @{
        description = $Description
        focus_keyword = $FocusKeyword
        post_type = $PostType
    } | ConvertTo-Json
    
    $url = "$($Config.WordPress.Url)/wp-json/potsdam/v1/meta-description/$PostId"
    
    try {
        $response = Invoke-RestMethod -Uri $url -Method Post -Headers $headers -Body $updateData -ContentType "application/json" -ErrorAction Stop
        
        if ($response.success) {
            Write-ColorOutput "   ✅ Response: $($response.message) ($($response.description_length) Zeichen)" -Color $Colors.Debug

            $savedDescription = if ($response.description) { $response.description } else { "" }
            $savedKeyword = if ($response.focus_keyword) { $response.focus_keyword } else { "" }

            if ($savedDescription -ne $Description) {
                Write-ColorOutput "   ❌ Verifikation fehlgeschlagen: Description wurde nicht korrekt gespeichert" -Color $Colors.Error
                return $false
            }

            if (-not [string]::IsNullOrWhiteSpace($FocusKeyword) -and $savedKeyword -ne $FocusKeyword) {
                Write-ColorOutput "   ❌ Verifikation fehlgeschlagen: Fokus-Schluesselwort wurde nicht korrekt gespeichert" -Color $Colors.Error
                return $false
            }

            return $true
        }
        else {
            Write-ColorOutput "   ❌ API Response: success = false" -Color $Colors.Error
            return $false
        }
    }
    catch {
        $errorMsg = $_.Exception.Message
        
        # Parse JSON Error Response
        if ($_.ErrorDetails.Message) {
            try {
                $errorJson = $_.ErrorDetails.Message | ConvertFrom-Json
                $errorMsg = "$($errorJson.code): $($errorJson.message)"
            }
            catch {
                $errorMsg = $_.ErrorDetails.Message
            }
        }
        
        Write-ColorOutput "   ❌ API-Fehler: $errorMsg" -Color $Colors.Error
        return $false
    }
}
#endregion

#region Main Script
Write-ColorOutput ""
Write-ColorOutput "╔════════════════════════════════════════════════════════╗" -Color $Colors.Header
Write-ColorOutput "║  WordPress Meta-Description Updater (AI)              ║" -Color $Colors.Header
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

if (-not $ReplaceExisting) {
    Write-ColorOutput "🔎 Pruefe Meta-Leseendpoint fuer vorhandene Rank-Math-Werte..." -Color $Colors.Info
    if (-not (Test-CustomMetaReadEndpoint)) {
        Write-ColorOutput "❌ Der GET-Endpoint /wp-json/potsdam/v1/meta-description/{id} ist nicht verfuegbar." -Color $Colors.Error
        Write-ColorOutput "   Ohne diesen Endpoint kann das Skript bestehende Werte nicht erkennen." -Color $Colors.Error
        Write-ColorOutput "   Ergebnis waere: unnoetige Neugenerierung trotz fehlendem -ReplaceExisting." -Color $Colors.Error
        Write-ColorOutput "" 
        Write-ColorOutput "👉 Bitte zuerst das aktuelle Theme mit src/inc/rest-api-meta-description.php deployen." -Color $Colors.Warning
        exit 1
    }
    Write-ColorOutput "✅ Meta-Leseendpoint verfuegbar." -Color $Colors.Success
    Write-ColorOutput ""
}

# Items abrufen
$allItems = @()
$types = if ($PostType -eq "both") { @("posts", "pages") } else { @($PostType) }

foreach ($type in $types) {
    Write-ColorOutput "📥 Lade $type..." -Color $Colors.Info
    $items = Get-WordPressItems -Type $type -CategoryId $CategoryId -Status $Status -MaxItems $MaxItems
    
    if ($items) {
        $allItems += $items | ForEach-Object { 
            Add-Member -InputObject $_ -NotePropertyName "_type" -NotePropertyValue $type -PassThru
        }
        Write-ColorOutput "   ✅ $($items.Count) $type gefunden" -Color $Colors.Success
    }
}

if ($allItems.Count -eq 0) {
    Write-ColorOutput "⚠️  Keine Inhalte gefunden" -Color $Colors.Warning
    exit 0
}

Write-ColorOutput ""
Write-ColorOutput "📊 Gesamt: $($allItems.Count) Inhalte werden verarbeitet" -Color $Colors.Info
Write-ColorOutput ""
Write-ColorOutput "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -Color $Colors.Header
Write-ColorOutput ""

# Statistiken
$stats = @{
    Total = $allItems.Count
    Success = 0
    Failed = 0
    Skipped = 0
    AlreadyHas = 0
}

# Items verarbeiten
for ($i = 0; $i -lt $allItems.Count; $i++) {
    $item = $allItems[$i]
    $number = $i + 1
    $typeLabel = if ($item._type -eq "pages") { "Seite" } else { "Beitrag" }
    
    Write-ColorOutput "[$number/$($allItems.Count)] ${typeLabel}: $($item.title.rendered)" -Color $Colors.Info
    Write-ColorOutput "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -Color $Colors.Debug
    
    try {
        # Prüfe existierende Rank Math Felder
        $existingMeta = Get-PostMeta -PostId $item.id -PostType $item._type
        $existingDesc = $existingMeta.Description
        $existingFocusKeyword = $existingMeta.FocusKeyword

        if ($existingDesc -and $existingFocusKeyword -and -not $ReplaceExisting) {
            Write-ColorOutput "   ⏭️  Hat bereits Description und Fokus-Schluesselwort - uebersprungen" -Color $Colors.Warning
            Write-ColorOutput "      Description: '$existingDesc'" -Color $Colors.Debug
            Write-ColorOutput "      Fokus-Schluesselwort: '$existingFocusKeyword'" -Color $Colors.Debug
            $stats.AlreadyHas++
            Write-ColorOutput ""
            continue
        }

        if (($existingDesc -or $existingFocusKeyword) -and $ReplaceExisting) {
            Write-ColorOutput "   🔄 Ersetze existierende SEO-Felder..." -Color $Colors.Warning
        }
        
        # Content bereinigen (HTML entfernen)
        $cleanContent = $item.content.rendered -replace '<[^>]+>', ' ' -replace '\s+', ' '
        
        if ($cleanContent.Length -lt 50) {
            Write-ColorOutput "   ⚠️  Inhalt zu kurz für Description-Generierung" -Color $Colors.Warning
            $stats.Skipped++
            Write-ColorOutput ""
            continue
        }
        
        # Meta-Description generieren
        Write-ColorOutput "   📝 Generiere Meta-Description..." -Color $Colors.Info
        $newDescription = New-MetaDescription -Title $item.title.rendered -Content $cleanContent -PostType $item._type

        Write-ColorOutput "   🔑 Generiere Fokus-Schluesselwort..." -Color $Colors.Info
        $newFocusKeyword = New-FocusKeyword -Title $item.title.rendered -Content $cleanContent -PostType $item._type

        if (-not $newFocusKeyword) {
            $fallbackKeyword = ($item.title.rendered -replace '[^\p{L}\p{N}\s-]', '' -replace '\s+', ' ').Trim()
            if ($fallbackKeyword.Length -gt 60) {
                $fallbackKeyword = $fallbackKeyword.Substring(0, 60).Trim()
            }
            $newFocusKeyword = $fallbackKeyword
            Write-ColorOutput "   ⚠️  Fokus-Schluesselwort Fallback aus Titel verwendet" -Color $Colors.Warning
        }
        
        if ($newDescription) {
            Write-ColorOutput "   ✅ Description generiert:" -Color $Colors.Success
            Write-ColorOutput "      '$newDescription'" -Color $Colors.Success

            if ($newFocusKeyword) {
                Write-ColorOutput "   ✅ Fokus-Schluesselwort generiert:" -Color $Colors.Success
                Write-ColorOutput "      '$newFocusKeyword'" -Color $Colors.Success
            }
            
            # Im DryRun-Modus nur anzeigen
            if ($DryRun) {
                Write-ColorOutput "   💭 Wuerde Description und Fokus-Schluesselwort setzen (DRY RUN)" -Color $Colors.Warning
                $stats.Success++
            }
            else {
                # Description aktualisieren
                Write-ColorOutput "   💾 Aktualisiere Meta-Description und Fokus-Schluesselwort in WordPress..." -Color $Colors.Info
                $result = Update-PostMetaDescription -PostId $item.id -PostType $item._type -Description $newDescription -FocusKeyword $newFocusKeyword
                
                if ($result) {
                    Write-ColorOutput "   ✅ Meta-Description und Fokus-Schluesselwort erfolgreich gespeichert!" -Color $Colors.Success
                    $stats.Success++
                }
                else {
                    Write-ColorOutput "   ❌ Fehler beim Speichern der SEO-Felder" -Color $Colors.Error
                    $stats.Failed++
                }
            }
        }
        else {
            Write-ColorOutput "   ⚠️  Keine Description generiert" -Color $Colors.Warning
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
if ($stats.AlreadyHas -gt 0) {
    Write-ColorOutput "   ✔️  Bereits vorhanden: $($stats.AlreadyHas)" -Color $Colors.Info
}
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
    Write-ColorOutput ""
}
else {
    Write-ColorOutput "🎉 Meta-Description/Fokus-Schluesselwort Update abgeschlossen!" -Color $Colors.Success
    Write-ColorOutput ""
    Write-ColorOutput "📍 Nächste Schritte:" -Color $Colors.Info
    Write-ColorOutput "   1. Prüfe die Seiten im WordPress-Admin" -Color $Colors.Info
    Write-ColorOutput "   2. Öffne Rank Math → Edit Snippet bei jeder Seite" -Color $Colors.Info
    Write-ColorOutput "   3. Teste mit Lighthouse (Chrome DevTools)" -Color $Colors.Info
    Write-ColorOutput ""
}

#endregion
