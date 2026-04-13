# WordPress Theme Paket erstellen
# Dieses Skript erstellt eine installationsfaehige ZIP-Datei des Themes

Write-Host "=== WordPress Theme Paket-Erstellung ===" -ForegroundColor Cyan
Write-Host ""

# Variablen
$themeName = "potsdam-rechtsanwalt"
$themeDir = Join-Path $PSScriptRoot "src"
$outputDir = Split-Path $PSScriptRoot -Parent
$zipFileName = "$themeName-theme.zip"
$zipPath = Join-Path $outputDir $zipFileName

Write-Host "Theme-Quellverzeichnis: $themeDir" -ForegroundColor Yellow
Write-Host "Ausgabe-Verzeichnis: $outputDir" -ForegroundColor Yellow
Write-Host "ZIP-Dateiname: $zipFileName" -ForegroundColor Yellow
Write-Host ""

# Alte ZIP-Datei loeschen, falls vorhanden
if (Test-Path $zipPath) {
    Write-Host "Alte ZIP-Datei wird geloescht..." -ForegroundColor Gray
    Remove-Item $zipPath -Force
}

Write-Host "Erstelle temporaeres Verzeichnis..." -ForegroundColor Gray
$tempDir = Join-Path $env:TEMP "theme-package-temp"
$themeSubDir = Join-Path $tempDir $themeName
if (Test-Path $tempDir) {
    Remove-Item $tempDir -Recurse -Force
}
New-Item -ItemType Directory -Path $themeSubDir -Force | Out-Null

# Alle Theme-Dateien aus src/ kopieren
Write-Host "Kopiere Theme-Dateien aus src/..." -ForegroundColor Gray
Get-ChildItem -Path $themeDir | ForEach-Object {
    $destination = Join-Path $themeSubDir $_.Name
    if ($_.PSIsContainer) {
        Copy-Item -Path $_.FullName -Destination $destination -Recurse -Force
        Write-Host "  Ordner: $($_.Name)" -ForegroundColor DarkGray
    } else {
        Copy-Item -Path $_.FullName -Destination $destination -Force
        Write-Host "  Datei: $($_.Name)" -ForegroundColor DarkGray
    }
}

# ZIP-Datei erstellen
Write-Host ""
Write-Host "Erstelle ZIP-Archiv..." -ForegroundColor Green
Compress-Archive -Path $themeSubDir -DestinationPath $zipPath -CompressionLevel Optimal

# Temporaeres Verzeichnis loeschen
Write-Host "Raeume auf..." -ForegroundColor Gray
Remove-Item $tempDir -Recurse -Force

# Erfolgsmeldung
Write-Host ""
Write-Host "=== ERFOLGREICH ===" -ForegroundColor Green
Write-Host ""
Write-Host "Theme-Paket wurde erstellt:" -ForegroundColor White
Write-Host $zipPath -ForegroundColor Cyan
Write-Host ""

# Dateigroesse anzeigen
$fileInfo = Get-Item $zipPath
$fileSizeKB = [math]::Round($fileInfo.Length / 1KB, 2)
$fileSizeMB = [math]::Round($fileInfo.Length / 1MB, 2)

if ($fileSizeMB -gt 1) {
    Write-Host "Dateigroesse: $fileSizeMB MB" -ForegroundColor Yellow
} else {
    Write-Host "Dateigroesse: $fileSizeKB KB" -ForegroundColor Yellow
}

Write-Host ""
Write-Host "Installation in WordPress:" -ForegroundColor White
Write-Host "1. WordPress Dashboard oeffnen" -ForegroundColor Gray
Write-Host "2. Design -> Themes -> Installieren" -ForegroundColor Gray
Write-Host "3. 'Theme hochladen' klicken" -ForegroundColor Gray
Write-Host "4. ZIP-Datei auswaehlen und hochladen" -ForegroundColor Gray
Write-Host "5. Theme aktivieren" -ForegroundColor Gray
Write-Host ""

# Im Explorer oeffnen
Write-Host "Oeffne Explorer..." -ForegroundColor Gray
Start-Process "explorer.exe" -ArgumentList "/select,""$zipPath"""
