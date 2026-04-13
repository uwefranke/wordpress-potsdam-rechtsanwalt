# Zeigt WordPress-Kategorien mit IDs an
$envFile = Join-Path $PSScriptRoot "..\config\.env"
$WP_URL = (Get-Content $envFile | Where-Object { $_ -like 'WP_URL=*' }) -replace 'WP_URL=',''
$WP_USER = (Get-Content $envFile | Where-Object { $_ -like 'WP_USER=*' }) -replace 'WP_USER=',''
$WP_PASSWORD = (Get-Content $envFile | Where-Object { $_ -like 'WP_APP_PASSWORD=*' }) -replace 'WP_APP_PASSWORD=',''

$auth = [Convert]::ToBase64String([Text.Encoding]::ASCII.GetBytes("${WP_USER}:${WP_PASSWORD}"))

Write-Host "`nWordPress Kategorien:" -ForegroundColor Cyan
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
