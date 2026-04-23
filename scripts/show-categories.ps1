# Zeigt WordPress-Kategorien mit IDs an (mit Environment-Auswahl)
param(
    [ValidateSet('prod','test','dev')]
    [string]$Environment = 'prod'
)

$envFile = Join-Path $PSScriptRoot "..\config\.env"

function Get-EnvironmentWordPressValue {
    param(
        [string]$Key,
        [string]$Environment
    )
    $envLines = Get-Content $envFile
    $searchKey = "${Key}_$($Environment.ToUpper())="
    $line = $envLines | Where-Object { $_ -like "$searchKey*" }
    if (-not $line) {
        throw "Fehler: Die Variable '$searchKey' ist nicht in .env definiert!"
    }
    return ($line -replace "$searchKey",'')
}

try {
    $WP_URL = Get-EnvironmentWordPressValue 'WP_URL' $Environment
    $WP_USER = Get-EnvironmentWordPressValue 'WP_USER' $Environment
    $WP_PASSWORD = Get-EnvironmentWordPressValue 'WP_APP_PASSWORD' $Environment
} catch {
    Write-Host $_.Exception.Message -ForegroundColor Red
    exit 1
}

$auth = [Convert]::ToBase64String([Text.Encoding]::ASCII.GetBytes("${WP_USER}:${WP_PASSWORD}"))

Write-Host "`nWordPress Kategorien ($Environment):" -ForegroundColor Cyan
Write-Host "==========================================`n" -ForegroundColor Cyan

try {
    $categories = Invoke-RestMethod -Uri "${WP_URL}/wp-json/wp/v2/categories?per_page=100" `
        -Headers @{Authorization = "Basic $auth"}
    $categories | Select-Object @{N='ID';E={$_.id}}, @{N='Name';E={$_.name}}, @{N='Anzahl Posts';E={$_.count}} |
        Sort-Object Name |
        Format-Table -AutoSize
    Write-Host "`nTrage die gewünschte ID in .env ein:" -ForegroundColor Yellow
    Write-Host "WP_DEFAULT_CATEGORY=14" -ForegroundColor Gray
}
catch {
    Write-Host "Fehler: $($_.Exception.Message)" -ForegroundColor Red
}
