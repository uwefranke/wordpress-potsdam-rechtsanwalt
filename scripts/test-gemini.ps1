$envFile = Join-Path $PSScriptRoot "..\config\.env"
$key = (Get-Content $envFile | Where-Object { $_ -like 'GEMINI_API_KEY=*' }) -replace 'GEMINI_API_KEY=',''

Write-Host "Teste Gemini API Key..." -ForegroundColor Cyan

try {
    $response = Invoke-RestMethod -Uri "https://generativelanguage.googleapis.com/v1beta/models?key=$key"
    Write-Host "✅ API Key funktioniert!" -ForegroundColor Green
    Write-Host "`nVerfügbare Modelle:" -ForegroundColor Yellow
    $response.models | Where-Object { $_.name -like '*gemini*' } | Select-Object -First 5 name | ForEach-Object { Write-Host "  - $($_.name)" }
}
catch {
    Write-Host "❌ API Key funktioniert NICHT!" -ForegroundColor Red
    Write-Host "Fehler: $($_.Exception.Message)" -ForegroundColor Red
    if ($_.ErrorDetails.Message) {
        Write-Host "Details: $($_.ErrorDetails.Message)" -ForegroundColor Yellow
    }
}
