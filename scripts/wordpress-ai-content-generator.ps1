#Requires -Version 7.0
<#
.SYNOPSIS
    Automatische Content-Erstellung für WordPress mit OpenAI GPT-4
    
.DESCRIPTION
    Generiert Blog-Artikel über Rechtsthemen und veröffentlicht sie automatisch
    als Drafts in WordPress. Nutzt WordPress REST API + Application Passwords.
    
.AUTHOR
    Erstellt für Rechtsanwalt Matthias Lange, Potsdam
    
.VERSION
    1.0.0
    
.EXAMPLE
    .\wordpress-ai-content-generator.ps1
    
.EXAMPLE
    .\wordpress-ai-content-generator.ps1 -Topics "Mietminderung", "Eigenbedarfskündigung"
#>

[CmdletBinding()]
param(
    [Parameter(Mandatory = $false)]
    [string[]]$Topics = @(),
    
    [Parameter(Mandatory = $false)]
    [ValidateSet("draft", "publish")]
    [string]$Status = "draft",
    
    [Parameter(Mandatory = $false)]
    [switch]$Force
)

#region Environment Variables Loading
function Import-EnvironmentVariables {
    $envFile = Join-Path $PSScriptRoot "..\config\.env"
    
    if (-not (Test-Path $envFile)) {
        Write-ColorOutput "⚠️  .env Datei nicht gefunden!" -Color "Yellow"
        Write-ColorOutput "   Kopiere .env.example zu .env und trage deine Credentials ein" -Color "Gray"
        
        # .env.example anzeigen
        $exampleFile = Join-Path $PSScriptRoot "..\config\.env.example"
        if (Test-Path $exampleFile) {
            Write-Host "`nBeispiel (.env.example):" -ForegroundColor Cyan
            Get-Content $exampleFile | Write-Host -ForegroundColor Gray
        }
        
        throw ".env Datei fehlt - bitte erstellen!"
    }
    
    Get-Content $envFile | ForEach-Object {
        if ($_ -match '^([^#][^=]+)=(.+)$') {
            $key = $matches[1].Trim()
            $value = $matches[2].Trim()
            Set-Variable -Name $key -Value $value -Scope Script
        }
    }
}

# .env laden
try {
    Import-EnvironmentVariables
}
catch {
    Write-ColorOutput "❌ Fehler beim Laden der .env: $($_.Exception.Message)" -Color "Red"
    exit 1
}

#endregion

#region Configuration
$script:Config = @{
    # WordPress Settings (aus .env)
    WordPress = @{
        Url = $WP_URL
        User = $WP_USER
        AppPassword = $WP_APP_PASSWORD
        DefaultCategory = [int]$WP_DEFAULT_CATEGORY
    }
    
    # AI Settings (aus .env)
    AI = @{
        Provider = if ($AI_PROVIDER) { $AI_PROVIDER } else { "gemini" }
        Temperature = if ($AI_TEMPERATURE) { [double]$AI_TEMPERATURE } else { 0.7 }
        MaxTokens = if ($AI_MAX_TOKENS) { [int]$AI_MAX_TOKENS } else { 2500 }
    }
    
    # Provider-spezifische Settings
    Claude = @{
        ApiKey = $CLAUDE_API_KEY
        Model = if ($CLAUDE_MODEL) { $CLAUDE_MODEL } else { "claude-3-5-sonnet-20241022" }
    }
    
    Gemini = @{
        ApiKey = $GEMINI_API_KEY
        Model = if ($GEMINI_MODEL) { $GEMINI_MODEL } else { "gemini-2.0-flash" }
    }
    
    OpenAI = @{
        ApiKey = $OPENAI_API_KEY
        Model = if ($OPENAI_MODEL) { $OPENAI_MODEL } else { "gpt-3.5-turbo" }
    }
    
    # Content Settings (aus .env)
    Content = @{
        WordCount = [int]$CONTENT_WORD_COUNT
        Language = $CONTENT_LANGUAGE
        Style = "Professionell aber verständlich"
        TargetAudience = "Mandanten in Potsdam"
    }
}

# Farben für Output
$script:Colors = @{
    Info = "Cyan"
    Success = "Green"
    Warning = "Yellow"
    Error = "Red"
    Debug = "Gray"
}
#endregion

#region Helper Functions
function Write-ColorOutput {
    param(
        [string]$Message,
        [string]$Color = "White",
        [string]$Icon = ""
    )
    
    if ($Icon) {
        Write-Host "$Icon " -NoNewline -ForegroundColor $Color
    }
    Write-Host $Message -ForegroundColor $Color
}

function Test-Configuration {
    $errors = @()
    
    if ([string]::IsNullOrWhiteSpace($Config.WordPress.AppPassword)) {
        $errors += "WordPress Application Password fehlt!"
    }
    
    # Provider-spezifische Validierung
    switch ($Config.AI.Provider) {
        "claude" {
            if ([string]::IsNullOrWhiteSpace($Config.Claude.ApiKey)) {
                $errors += "Claude API Key fehlt! (Hole dir einen auf: https://console.anthropic.com/settings/keys)"
            }
        }
        "gemini" {
            if ([string]::IsNullOrWhiteSpace($Config.Gemini.ApiKey)) {
                $errors += "Gemini API Key fehlt! (Hole dir einen kostenlosen auf: https://aistudio.google.com/app/apikey)"
            }
        }
        "openai" {
            if ([string]::IsNullOrWhiteSpace($Config.OpenAI.ApiKey)) {
                $errors += "OpenAI API Key fehlt!"
            }
        }
        default {
            $errors += "Unbekannter AI_PROVIDER in .env: $($Config.AI.Provider) (wähle 'claude', 'gemini' oder 'openai')"
        }
    }
    
    if ($errors.Count -gt 0) {
        Write-ColorOutput "❌ Konfigurationsfehler:" -Color $Colors.Error
        $errors | ForEach-Object { Write-ColorOutput "   - $_" -Color $Colors.Warning }
        Write-Host "`nBitte .env Datei prüfen!" -ForegroundColor Yellow
        return $false
    }
    
    return $true
}

function Get-WordPressHeaders {
    $credentials = "$($Config.WordPress.User):$($Config.WordPress.AppPassword)"
    $base64 = [Convert]::ToBase64String([Text.Encoding]::ASCII.GetBytes($credentials))
    
    return @{
        "Authorization" = "Basic $base64"
        "Content-Type" = "application/json"
    }
}

function Test-WordPressConnection {
    try {
        $headers = Get-WordPressHeaders
        $response = Invoke-RestMethod -Uri "$($Config.WordPress.Url)/wp-json/wp/v2/users/me" `
            -Headers $headers -Method Get -ErrorAction Stop
        
        Write-ColorOutput "✅ WordPress-Verbindung erfolgreich! Angemeldet als: $($response.name)" -Color $Colors.Success
        return $true
    }
    catch {
        Write-ColorOutput "❌ WordPress-Verbindung fehlgeschlagen!" -Color $Colors.Error
        Write-ColorOutput "   Fehler: $($_.Exception.Message)" -Color $Colors.Debug
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
    
    switch ($Config.AI.Provider) {
        "claude" {
            return Invoke-ClaudeRequest -SystemPrompt $SystemPrompt -UserPrompt $UserPrompt
        }
        "gemini" {
            return Invoke-GeminiRequest -SystemPrompt $SystemPrompt -UserPrompt $UserPrompt
        }
        "openai" {
            return Invoke-OpenAIRequest -SystemPrompt $SystemPrompt -UserPrompt $UserPrompt
        }
        default {
            Write-ColorOutput "❌ Unbekannter AI Provider: $($Config.AI.Provider)" -Color $Colors.Error
            return $null
        }
    }
}

function Invoke-ClaudeRequest {
    param(
        [string]$SystemPrompt,
        [string]$UserPrompt
    )
    
    $body = @{
        model = $Config.Claude.Model
        max_tokens = $Config.AI.MaxTokens
        temperature = $Config.AI.Temperature
        system = $SystemPrompt
        messages = @(
            @{
                role = "user"
                content = $UserPrompt
            }
        )
    } | ConvertTo-Json -Depth 10
    
    try {
        $response = Invoke-RestMethod -Uri "https://api.anthropic.com/v1/messages" `
            -Method Post `
            -Headers @{
                "x-api-key" = $Config.Claude.ApiKey
                "anthropic-version" = "2023-06-01"
                "content-type" = "application/json"
            } `
            -Body $body `
            -ErrorAction Stop
        
        return $response.content[0].text
    }
    catch {
        $errorDetails = ""
        if ($_.ErrorDetails.Message) {
            $errorDetails = " | Details: $($_.ErrorDetails.Message)"
        }
        Write-ColorOutput "❌ Claude API Fehler: $($_.Exception.Message)$errorDetails" -Color $Colors.Error
        Write-ColorOutput "   Model: $($Config.Claude.Model)" -Color $Colors.Debug
        return $null
    }
}

function Invoke-GeminiRequest {
    param(
        [string]$SystemPrompt,
        [string]$UserPrompt
    )
    
    $combinedPrompt = "$SystemPrompt`n`n$UserPrompt"
    
    $body = @{
        contents = @(
            @{
                parts = @(
                    @{
                        text = $combinedPrompt
                    }
                )
            }
        )
        generationConfig = @{
            temperature = $Config.AI.Temperature
            maxOutputTokens = $Config.AI.MaxTokens
        }
    } | ConvertTo-Json -Depth 10
    
    try {
        $uri = "https://generativelanguage.googleapis.com/v1beta/$($Config.Gemini.Model):generateContent?key=$($Config.Gemini.ApiKey)"
        $response = Invoke-RestMethod -Uri $uri `
            -Method Post `
            -Headers @{
                "Content-Type" = "application/json"
            } `
            -Body $body `
            -ErrorAction Stop
        
        return $response.candidates[0].content.parts[0].text
    }
    catch {
        $errorDetails = ""
        if ($_.ErrorDetails.Message) {
            $errorDetails = " | Details: $($_.ErrorDetails.Message)"
        }
        Write-ColorOutput "❌ Gemini API Fehler: $($_.Exception.Message)$errorDetails" -Color $Colors.Error
        Write-ColorOutput "   Model: $($Config.Gemini.Model) | URI: $($uri.Replace($Config.Gemini.ApiKey, 'XXX'))" -Color $Colors.Debug
        return $null
    }
}

function Invoke-OpenAIRequest {
    param(
        [string]$SystemPrompt,
        [string]$UserPrompt
    )
    
    $body = @{
        model = $Config.OpenAI.Model
        messages = @(
            @{
                role = "system"
                content = $SystemPrompt
            }
            @{
                role = "user"
                content = $UserPrompt
            }
        )
        temperature = $Config.AI.Temperature
        max_tokens = $Config.AI.MaxTokens
    } | ConvertTo-Json -Depth 10
    
    try {
        $response = Invoke-RestMethod -Uri "https://api.openai.com/v1/chat/completions" `
            -Method Post `
            -Headers @{
                "Authorization" = "Bearer $($Config.OpenAI.ApiKey)"
                "Content-Type" = "application/json"
            } `
            -Body $body `
            -ErrorAction Stop
        
        return $response.choices[0].message.content
    }
    catch {
        Write-ColorOutput "❌ OpenAI API Fehler: $($_.Exception.Message)" -Color $Colors.Error
        return $null
    }
}

function New-BlogContent {
    param([string]$Topic)
    
    Write-ColorOutput "🤖 Generiere Content für: $Topic" -Color $Colors.Info
    
    $systemPrompt = @"
Du bist ein erfahrener Rechtsanwalts-Ghostwriter, spezialisiert auf Mietrecht und Immobilienrecht.
Deine Aufgabe ist es, SEO-optimierte, rechtlich fundierte Blog-Artikel zu schreiben.

Wichtige Anforderungen:
- Zielgruppe: Laien (Mandanten in Potsdam)
- Stil: Professionell aber verständlich, keine Fachsprache ohne Erklärung
- Rechtlich korrekt, aber keine Rechtsberatung im Text
- SEO-optimiert für lokale Suche (Potsdam, Brandenburg)
- Handlungsaufforderung: Kontakt für persönliche Beratung

Struktur:
1. Einleitung (Problem darstellen)
2. Hauptteil (Rechtslage erklären, Beispiele geben)
3. Praktische Tipps
4. Fazit mit Call-to-Action

Länge: Ca. $($Config.Content.WordCount) Wörter
Sprache: $($Config.Content.Language)
"@
    
    $userPrompt = @"
Schreibe einen informativen Blog-Artikel zum Thema: "$Topic"

Der Artikel soll:
- Verständlich für Nicht-Juristen sein
- Konkrete Beispiele enthalten
- Lokalen Bezug zu Potsdam haben (wo sinnvoll)
- Mit einem Disclaimer enden: "Dieser Artikel ersetzt keine Rechtsberatung. Für eine individuelle Beratung kontaktieren Sie uns gerne."

WICHTIG:
- Gib NUR das HTML aus, KEINE Code-Block-Marker wie ```html oder ```
- Beginne direkt mit dem ersten <h2> Tag
- Format: Reines HTML (mit <h2>, <h3>, <p>, <ul>, <li> Tags)
"@
    
    $content = Invoke-AIRequest -SystemPrompt $systemPrompt -UserPrompt $userPrompt
    
    if ($content) {
        # Entferne eventuelle Code-Block-Marker
        $content = $content -replace '^```html\s*', ''
        $content = $content -replace '```\s*$', ''
        $content = $content.Trim()
        
        Write-ColorOutput "   ✅ Content generiert ($($content.Length) Zeichen)" -Color $Colors.Success
    }
    
    return $content
}

function New-MetaDescription {
    param([string]$Content)
    
    $prompt = "Erstelle eine SEO-Meta-Description (max. 160 Zeichen) für folgenden Artikel. Fokus auf Potsdam, Mietrecht, Rechtsanwalt: `n`n$($Content.Substring(0, [Math]::Min(500, $Content.Length)))"
    
    $meta = Invoke-AIRequest -SystemPrompt "Du bist ein SEO-Experte." -UserPrompt $prompt
    
    if ($meta.Length -gt 160) {
        $meta = $meta.Substring(0, 157) + "..."
    }
    
    return $meta
}
#endregion

#region WordPress Functions
function Publish-WordPressPost {
    param(
        [string]$Title,
        [string]$Content,
        [string]$Excerpt = "",
        [int]$CategoryId,
        [string]$Status = "draft"
    )
    
    Write-ColorOutput "📤 Veröffentliche in WordPress..." -Color $Colors.Info
    
    $postData = @{
        title = $Title
        content = $Content
        excerpt = $Excerpt
        status = $Status
        categories = @($CategoryId)
    } | ConvertTo-Json
    
    try {
        $headers = Get-WordPressHeaders
        $response = Invoke-RestMethod -Uri "$($Config.WordPress.Url)/wp-json/wp/v2/posts" `
            -Method Post `
            -Headers $headers `
            -Body $postData `
            -ErrorAction Stop
        
        Write-ColorOutput "   ✅ Post erstellt!" -Color $Colors.Success
        Write-ColorOutput "   📝 ID: $($response.id)" -Color $Colors.Debug
        Write-ColorOutput "   🔗 Link: $($response.link)" -Color $Colors.Debug
        Write-ColorOutput "   📊 Status: $($response.status)" -Color $Colors.Debug
        
        return $response
    }
    catch {
        Write-ColorOutput "   ❌ Fehler beim Veröffentlichen: $($_.Exception.Message)" -Color $Colors.Error
        return $null
    }
}

function Get-WordPressCategories {
    try {
        $headers = Get-WordPressHeaders
        $categories = Invoke-RestMethod -Uri "$($Config.WordPress.Url)/wp-json/wp/v2/categories" `
            -Headers $headers -Method Get
        
        Write-ColorOutput "`n📁 Verfügbare Kategorien:" -Color $Colors.Info
        $categories | ForEach-Object {
            Write-ColorOutput "   - [$($_.id)] $($_.name) ($($_.count) Posts)" -Color $Colors.Debug
        }
        Write-Host ""
        
        return $categories
    }
    catch {
        Write-ColorOutput "❌ Kategorien konnten nicht abgerufen werden" -Color $Colors.Error
        return @()
    }
}
#endregion

#region Main Logic
function Start-ContentGeneration {
    param([string[]]$TopicList)
    
    Write-Host "`n╔════════════════════════════════════════════════════════╗" -ForegroundColor Cyan
    Write-Host "║  WordPress AI Content Generator                        ║" -ForegroundColor Cyan
    Write-Host "║  Rechtsanwalt Matthias Lange, Potsdam                  ║" -ForegroundColor Cyan
    Write-Host "╚════════════════════════════════════════════════════════╝`n" -ForegroundColor Cyan
    
    # Konfiguration prüfen
    if (-not (Test-Configuration)) {
        return
    }
    
    # WordPress-Verbindung testen
    Write-ColorOutput "🔌 Teste WordPress-Verbindung..." -Color $Colors.Info
    if (-not (Test-WordPressConnection)) {
        return
    }
    
    # Kategorien anzeigen (optional)
    if ($PSBoundParameters.ContainsKey('Verbose')) {
        Get-WordPressCategories | Out-Null
    }
    
    # Standard-Topics wenn keine angegeben
    if ($TopicList.Count -eq 0) {
        $TopicList = @(
            "Mietminderung bei Schimmel – Ihre Rechte als Mieter",
            "Kündigung der Mietwohnung – Fristen und Formvorschriften",
            "Betriebskostenabrechnung prüfen – Worauf Sie achten müssen",
            "Eigenbedarfskündigung – Wann ist sie rechtmäßig?",
            "Lärmbelästigung durch Nachbarn – Ihre rechtlichen Möglichkeiten"
        )
        
        Write-ColorOutput "ℹ️  Keine Topics angegeben - nutze Standard-Topics ($($TopicList.Count) Artikel)" -Color $Colors.Warning
    }
    
    # Fortschrittsanzeige
    $completed = 0
    $failed = 0
    $total = $TopicList.Count
    
    Write-Host "`n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Cyan
    
    foreach ($topic in $TopicList) {
        $current = $completed + $failed + 1
        Write-Host "`n[$current/$total] " -NoNewline -ForegroundColor Yellow
        Write-Host $topic -ForegroundColor White
        Write-Host "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Gray
        
        # Content generieren
        $content = New-BlogContent -Topic $topic
        
        if (-not $content) {
            Write-ColorOutput "⚠️  Überspringe wegen Fehler" -Color $Colors.Warning
            $failed++
            continue
        }
        
        # Meta-Description erstellen
        $meta = New-MetaDescription -Content $content
        
        # In WordPress veröffentlichen
        $post = Publish-WordPressPost `
            -Title $topic `
            -Content $content `
            -Excerpt $meta `
            -CategoryId $Config.WordPress.DefaultCategory `
            -Status $Status
        
        if ($post) {
            $completed++
        } else {
            $failed++
        }
        
        # Rate Limiting (OpenAI: max 3 requests/min mit free tier)
        if ($current -lt $total) {
            Write-ColorOutput "   ⏳ Warte 5 Sekunden (Rate Limiting)..." -Color $Colors.Debug
            Start-Sleep -Seconds 5
        }
    }
    
    # Zusammenfassung
    Write-Host "`n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" -ForegroundColor Cyan
    Write-Host "`n📊 Zusammenfassung:" -ForegroundColor Cyan
    Write-ColorOutput "   ✅ Erfolgreich: $completed" -Color $Colors.Success
    if ($failed -gt 0) {
        Write-ColorOutput "   ❌ Fehlgeschlagen: $failed" -Color $Colors.Error
    }
    Write-ColorOutput "   📝 Gesamt: $total" -Color $Colors.Info
    
    if ($completed -gt 0) {
        Write-Host "`n🎉 Alle Artikel wurden als $Status in WordPress erstellt!" -ForegroundColor Green
        Write-Host "   Gehe zu: $($Config.WordPress.Url)/wp-admin/edit.php`n" -ForegroundColor Gray
    }
}
#endregion

#region Script Execution
# Bei direkter Ausführung
if ($MyInvocation.InvocationName -ne '.') {
    Start-ContentGeneration -TopicList $Topics
}
#endregion
