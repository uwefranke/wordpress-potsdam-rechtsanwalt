# Google Fonts Downloader für DSGVO-konforme lokale Nutzung
# Lädt Playfair Display und Open Sans als WOFF2-Dateien herunter

$fontsDir = "$PSScriptRoot\src\assets\fonts"

Write-Host "`nGoogle Fonts Downloader" -ForegroundColor Cyan
Write-Host "======================" -ForegroundColor Cyan
Write-Host "Lädt Playfair Display und Open Sans für DSGVO-konforme Nutzung`n" -ForegroundColor Gray

# Fonts von google-webfonts-helper API
$fonts = @{
    'open-sans' = @{
        variants = @(
            @{weight='300'; style='normal'; file='open-sans-v40-latin-300.woff2'},
            @{weight='400'; style='normal'; file='open-sans-v40-latin-regular.woff2'},
            @{weight='600'; style='normal'; file='open-sans-v40-latin-600.woff2'}
        )
    }
    'playfair-display' = @{
        variants = @(
            @{weight='400'; style='normal'; file='playfair-display-v36-latin-regular.woff2'},
            @{weight='600'; style='normal'; file='playfair-display-v36-latin-600.woff2'},
            @{weight='700'; style='normal'; file='playfair-display-v36-latin-700.woff2'}
        )
    }
}

# Basis-URLs
$baseUrl = "https://gwfh.mranftl.com/api/fonts"

foreach ($fontFamily in $fonts.Keys) {
    Write-Host "Font-Familie: $fontFamily" -ForegroundColor Yellow
    
    foreach ($variant in $fonts[$fontFamily].variants) {
        $fileName = $variant.file
        $outputPath = Join-Path $fontsDir $fileName
        
        # Vereinfachte Namen für fonts.css
        $simpleName = $fileName -replace '-v\d+.*?-', '-'
        $simpleName = $simpleName -replace '-(regular|normal)', ''
        $simpleOutputPath = Join-Path $fontsDir $simpleName
        
        $url = "$baseUrl/$fontFamily"
        
        Write-Host "  $($variant.weight) $($variant.style)..." -NoNewline
        
        try {
            # Hinweis: Die API liefert JSON mit Download-URLs
            # Für Demonstration verwenden wir direkte URLs von Google's CDN
            
            $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:121.0) Gecko/20100101 Firefox/121.0'
            
            # Direkte Google Fonts URLs (diese liefern WOFF2 für moderne Browser)
            if ($fontFamily -eq 'open-sans') {
                $googleUrl = "https://fonts.gstatic.com/s/opensans/v40/"
                switch ($variant.weight) {
                    '300' { $googleUrl += "memvYaGs126MiZpBA-UvWbX2vVnXBbObj2OVTS-mu0SC55I.woff2" }
                    '400' { $googleUrl += "memvYaGs126MiZpBA-UvWbX2vVnXBbObj2OVTSCmu0SC55I.woff2" }
                    '600' { $googleUrl += "memvYaGs126MiZpBA-UvWbX2vVnXBbObj2OVTSKmu0SC55I.woff2" }
                }
            }
            elseif ($fontFamily -eq 'playfair-display') {
                $googleUrl = "https://fonts.gstatic.com/s/playfairdisplay/v37/"
                switch ($variant.weight) {
                    '400' { $googleUrl += "nuFvD-vYSZviVYUb_rj3ij__anPXJzDwcbmjWBN2PKdFvUDQZNLo_U2r.woff2" }
                    '600' { $googleUrl += "nuFvD-vYSZviVYUb_rj3ij__anPXJzDwcbmjWBN2PKdFvXjQZNLo_U2r.woff2" }
                    '700' { $googleUrl += "nuFvD-vYSZviVYUb_rj3ij__anPXJzDwcbmjWBN2PKdFvXDQZNLo_U2r.woff2" }
                }
            }
            
            Invoke-WebRequest -Uri $googleUrl -OutFile $simpleOutputPath -UserAgent $userAgent -ErrorAction Stop | Out-Null
            Write-Host " OK ($([Math]::Round((Get-Item $simpleOutputPath).Length / 1KB, 1)) KB)" -ForegroundColor Green
        }
        catch {
            Write-Host " FEHLER: $($_.Exception.Message)" -ForegroundColor Red
        }
    }
    Write-Host ""
}

Write-Host "Fonts heruntergeladen nach: $fontsDir" -ForegroundColor Green
Write-Host "`nDie Fonts sind jetzt lokal verfügbar (DSGVO-konform)!" -ForegroundColor Cyan
Write-Host "Keine externe Verbindung zu Google mehr nötig.`n" -ForegroundColor Gray

