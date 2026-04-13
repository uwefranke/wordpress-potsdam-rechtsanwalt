# SVG to PNG Converter for Site Icon
# Creates a 512x512 PNG from the SVG icon

param([int]$Size = 512)

$svgPath = "$PSScriptRoot\src\assets\images\site-icon.svg"
$pngPath = "$PSScriptRoot\src\assets\images\site-icon-$Size.png"

Write-Host "Converting SVG to PNG..." -ForegroundColor Cyan

# Method 1: Inkscape
$inkscape = Get-Command inkscape -ErrorAction SilentlyContinue
if ($inkscape) {
    & inkscape $svgPath --export-type=png --export-filename=$pngPath --export-width=$Size --export-height=$Size
    Write-Host "PNG created with Inkscape: $pngPath" -ForegroundColor Green
    exit 0
}

# Method 2: ImageMagick
$magick = Get-Command magick -ErrorAction SilentlyContinue
if ($magick) {
    & magick convert -background none -size "${Size}x${Size}" $svgPath $pngPath
    Write-Host "PNG created with ImageMagick: $pngPath" -ForegroundColor Green
    exit 0
}

Write-Host "No SVG converter found!" -ForegroundColor Red
Write-Host ""
Write-Host "Please install one of:" -ForegroundColor Yellow
Write-Host "  1. Inkscape: https://inkscape.org/release/" -ForegroundColor White
Write-Host "  2. ImageMagick: https://imagemagick.org/script/download.php" -ForegroundColor White
Write-Host ""
Write-Host "OR use online converter:" -ForegroundColor Yellow
Write-Host "  https://cloudconvert.com/svg-to-png" -ForegroundColor White
Write-Host "  Set size to 512x512 pixels" -ForegroundColor White
exit 1
