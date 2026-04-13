# WordPress Post Tags Updater - Anleitung

## Überblick

Das Skript `update-post-tags.ps1` durchläuft alle vorhandenen WordPress-Beiträge und aktualisiert deren Tags (Schlagwörter) automatisch mittels KI-Analyse. Es nutzt Claude, Gemini oder OpenAI, um relevante, SEO-optimierte Keywords aus Titel und Inhalt der Artikel zu extrahieren.

**Hauptfunktionen:**
- ✅ Automatische Tag-Generierung für bestehende Beiträge
- ✅ Flexible Filterung nach Kategorie, Status oder Anzahl
- ✅ Wahlweise Hinzufügen oder Ersetzen von Tags
- ✅ DryRun-Modus zum sicheren Testen
- ✅ Fortschrittsanzeige und Statistiken

## Voraussetzungen

### 1. PowerShell 7+
```powershell
# Version prüfen
pwsh --version

# Falls nicht installiert: https://aka.ms/PSWindows
```

### 2. Konfiguration (config/.env)
Das Skript verwendet dieselbe `.env` Datei wie der AI Content Generator:

```ini
# WordPress Zugangsdaten
WP_URL=https://law.scriptbb.de
WP_USER=lawadmin
WP_APP_PASSWORD=xxxx yyyy zzzz aaaa bbbb cccc

# AI Provider (claude, gemini oder openai)
AI_PROVIDER=claude
CLAUDE_API_KEY=sk-ant-api03-...
CLAUDE_MODEL=claude-sonnet-4-6

# Content Settings
CONTENT_TAG_COUNT=5  # Anzahl Tags pro Beitrag (Standard: 5)
```

**Wichtig:** Application Password muss in WordPress erstellt sein:
- WordPress → Benutzer → Profil → "Application Passwords"
- Name: "AI Content Generator" → "Neues Anwendungspasswort hinzufügen"

## Parameter

### `-Status` (String)
**Standard:** `publish`  
Filtert Beiträge nach WordPress-Status.

**Mögliche Werte:**
- `publish` - Veröffentlichte Beiträge
- `draft` - Entwürfe
- `private` - Private Beiträge
- `pending` - Wartend auf Veröffentlichung
- `any` - Alle Status

**Beispiel:**
```powershell
.\update-post-tags.ps1 -Status draft
```

### `-CategoryId` (Integer)
**Optional**  
Nur Beiträge einer bestimmten Kategorie aktualisieren.

**Kategorie-IDs anzeigen:**
```powershell
.\show-categories.ps1
```

**Beispiel:**
```powershell
# Nur Beiträge in Kategorie "Mietrecht" (ID 14)
.\update-post-tags.ps1 -CategoryId 14
```

### `-ReplaceExisting` (Switch)
**Standard:** Aus (Tags werden hinzugefügt)  
Wenn aktiviert: Alte Tags werden komplett ersetzt durch KI-generierte Tags.

**Ohne Parameter:**
```powershell
.\update-post-tags.ps1
# Ergebnis: Alte Tags + neue KI-Tags
```

**Mit Parameter:**
```powershell
.\update-post-tags.ps1 -ReplaceExisting
# Ergebnis: Nur neue KI-Tags (alte werden gelöscht)
```

### `-MaxPosts` (Integer)
**Standard:** 0 (unbegrenzt)  
Begrenzt die Anzahl zu verarbeitender Beiträge.

**Beispiel:**
```powershell
# Nur die ersten 10 Beiträge
.\update-post-tags.ps1 -MaxPosts 10
```

### `-DryRun` (Switch)
**Standard:** Aus (Änderungen werden gespeichert)  
Testmodus - zeigt nur an, welche Tags generiert würden, ohne WordPress zu ändern.

**Beispiel:**
```powershell
.\update-post-tags.ps1 -MaxPosts 5 -DryRun
```

Ergebnis:
```
🏷️  Generiere Tags...
   ✅ Tags generiert: Mietrecht, Schimmel, Potsdam
   💭 Würde Tags setzen (DRY RUN)
```

## Verwendungsbeispiele

### 1. Erste Tests (empfohlen)
Testen Sie das Skript zunächst mit wenigen Beiträgen im DryRun-Modus:

```powershell
cd C:\Users\uwefr\OneDrive\Dokumente\web\potsdam-rechtsanwalt\scripts
pwsh
.\update-post-tags.ps1 -MaxPosts 5 -DryRun
```

### 2. Alle veröffentlichten Beiträge aktualisieren
Tags zu bestehenden Tags hinzufügen:

```powershell
.\update-post-tags.ps1 -Status publish
```

### 3. Alte Tags komplett ersetzen
Nur noch KI-generierte Tags verwenden:

```powershell
.\update-post-tags.ps1 -Status publish -ReplaceExisting
```

### 4. Bestimmte Kategorie aktualisieren
Nur Beiträge in "Mietrecht" (ID 14):

```powershell
.\update-post-tags.ps1 -CategoryId 14 -ReplaceExisting
```

### 5. Schrittweise Aktualisierung
Große Anzahl von Beiträgen in mehreren Durchläufen:

```powershell
# Schritt 1: Erste 20 Beiträge testen
.\update-post-tags.ps1 -MaxPosts 20

# Schritt 2: Weitere 50 Beiträge
.\update-post-tags.ps1 -MaxPosts 50

# Schritt 3: Alle restlichen
.\update-post-tags.ps1
```

### 6. Nur Entwürfe aktualisieren
Vor Veröffentlichung Tags hinzufügen:

```powershell
.\update-post-tags.ps1 -Status draft
```

## Ablauf

Das Skript durchläuft folgende Schritte:

1. **Verbindung testen**
   ```
   🔌 Teste WordPress-Verbindung...
   ✅ WordPress-Verbindung erfolgreich! Angemeldet als: lawadmin
   ```

2. **Beiträge abrufen**
   ```
   📥 Lade Beiträge...
   ✅ 61 Beiträge gefunden
   ```

3. **Jeden Beitrag verarbeiten**
   ```
   [1/61] Mietpreisbremse Höchstrichterlich geklärt!
   🏷️  Generiere Tags...
   ✅ Tags generiert: Mietpreisbremse, Mietrecht Potsdam, BVerfG, Mietspiegel, Wohnungsmiete
   💾 Aktualisiere Tags in WordPress...
   ✅ Tags erfolgreich aktualisiert!
   ```

4. **Zusammenfassung**
   ```
   📊 Zusammenfassung:
   ✅ Erfolgreich: 61
   📝 Gesamt: 61
   
   🎉 Tags-Update abgeschlossen!
   ```

## Tag-Generierung

### Wie funktioniert die KI-Analyse?

Die KI analysiert:
- **Titel des Beitrags**
- **Ersten 500 Zeichen des Inhalts**
- **Thematischer Kontext** (Rechtsthemen, Potsdam)

### Beispiel-Prompts

Für einen Artikel über "Mietminderung wegen Schimmel":

```
Erstelle 5 relevante WordPress-Tags für folgenden Artikel.

Titel: Mietminderung wegen Schimmelbefall

Anforderungen:
- Fokus auf Mietrecht, Rechtsthemen, Potsdam
- Kurz und prägnant (1-3 Wörter pro Tag)
- SEO-optimiert für lokale Suche
- Keine Sonderzeichen oder Umlaute (nutze ae, oe, ue)
- Nur die Tags ausgeben, getrennt durch Komma
```

**Ergebnis:**
```
Mietminderung, Schimmelbefall, Mietrecht Potsdam, Mangel Wohnung, Rechtsanwalt Potsdam
```

### Tag-Qualität

**Typische Tag-Kategorien:**
- 🏛️ **Rechtsgebiete:** Mietrecht, Immobilienrecht, Vertragsrecht
- 📍 **Lokal:** Potsdam, Brandenburg, Rechtsanwalt Potsdam
- 📋 **Themen:** Mietminderung, Kuendigung, Schoenheitsreparaturen
- ⚖️ **Rechtsbegriffe:** Eigenbedarf, Betriebskosten, Nebenkostenabrechnung

## Kosten

### Claude (empfohlen)
- **Modell:** claude-sonnet-4-6
- **Kosten pro Beitrag:** ~$0.001-0.002 (ca. 150-200 Tokens)
- **61 Beiträge:** ~$0.06-0.12

### Gemini
- **Modell:** gemini-2.0-flash
- **Kosten:** Kostenlos (mit Tageslimit)
- **Limit:** Ca. 50 Anfragen/Tag im kostenlosen Tier

### OpenAI
- **Modell:** gpt-3.5-turbo
- **Kosten pro Beitrag:** ~$0.002-0.003
- **61 Beiträge:** ~$0.12-0.18

## Fehlerbehebung

### Fehler: "Das Skript kann nicht ausgeführt werden"
```
#requires-Anweisung für Windows PowerShell 7.0 enthält
```

**Lösung:** PowerShell 7 verwenden:
```powershell
pwsh -Command "Set-Location 'C:\...\scripts'; .\update-post-tags.ps1"
```

### Fehler: "WordPress-Verbindung fehlgeschlagen"
```
❌ WordPress-Verbindung fehlgeschlagen: 401 Unauthorized
```

**Lösungen:**
1. Application Password prüfen (keine Leerzeichen in .env)
2. WordPress-URL korrekt (mit https:// oder http://)
3. Benutzername korrekt (Groß-/Kleinschreibung beachten)

### Fehler: "AI Provider [...] fehlgeschlagen"
```
❌ Fehler beim Generieren: 429 Too Many Requests
```

**Lösungen:**
- **OpenAI/Gemini:** Quota erschöpft → anderen Provider verwenden
- **Claude:** API-Key prüfen oder Credits aufladen

### Warnung: "Keine Tags generiert"
```
⚠️  Keine Tags generiert
```

**Ursachen:**
- Artikel zu kurz (weniger als 100 Zeichen)
- KI-Antwort unbrauchbar
- Netzwerkfehler

**Lösung:** Einzelnen Beitrag manuell prüfen und Tags setzen

### Tags erscheinen nicht in WordPress

**Prüfen:**
1. WordPress Admin → Beiträge → Beitrag öffnen
2. Rechte Seitenleiste → "Schlagwörter" Panel
3. Tags sollten dort sichtbar sein

**Falls nicht:**
- Skript mit `-ReplaceExisting` erneut ausführen
- WordPress-Cache leeren
- Browser-Cache leeren (Strg+F5)

## Best Practices

### 1. Immer zuerst DryRun
```powershell
.\update-post-tags.ps1 -MaxPosts 3 -DryRun
```
Erst nach Prüfung der generierten Tags echten Lauf starten.

### 2. Inkrementelle Updates
Bei vielen Beiträgen (>100) in Schritten vorgehen:
```powershell
.\update-post-tags.ps1 -MaxPosts 25
# Ergebnis prüfen, dann weiter:
.\update-post-tags.ps1 -MaxPosts 50
```

### 3. Tags kombinieren statt ersetzen
Erst ohne `-ReplaceExisting` ausführen, dann in WordPress manuell nicht relevante Tags entfernen.

### 4. Kategorie-spezifische Updates
```powershell
# Erst Mietrecht
.\update-post-tags.ps1 -CategoryId 14

# Dann Immobilienrecht
.\update-post-tags.ps1 -CategoryId 13
```

### 5. Regelmäßige Updates
Monatlich/Quartalsweise neue Beiträge aktualisieren:
```powershell
# Nur Beiträge der letzten 30 Tage
# (manuelles Filtern nach Datum in WordPress nötig)
```

## Backup & Rollback

### Vor dem ersten Lauf
**Empfehlung:** WordPress-Datenbank-Backup erstellen

**Synology NAS:**
1. Hyper Backup öffnen
2. Daten & Anwendungen → Backup erstellen
3. MySQL-Datenbank einschließen

**Alternativ:** Plugin "UpdraftPlus" verwenden

### Rollback
Falls Tags unerwünscht sind:

**Option 1:** Manuell in WordPress entfernen
```
Beiträge → Alle Beiträge → Bulk-Aktion → Tags entfernen
```

**Option 2:** Aus Backup wiederherstellen

**Option 3:** Skript mit leeren Tags ausführen (Custom-Anpassung nötig)

## Integration mit Content Generator

Beide Skripts teilen sich die `.env` Konfiguration und nutzen dieselben Funktionen:

### Workflow-Beispiel

1. **Neue Artikel generieren:**
   ```powershell
   .\wordpress-ai-content-generator.ps1 -Topic "Mietrecht Thema 1" -Status draft
   ```

2. **Artikel in WordPress prüfen und veröffentlichen**

3. **Tags aller veröffentlichten Artikel aktualisieren:**
   ```powershell
   .\update-post-tags.ps1 -Status publish
   ```

## Technische Details

### Verwendete WordPress REST API Endpoints

```
GET  /wp-json/wp/v2/users/me              # Verbindungstest
GET  /wp-json/wp/v2/posts?status=...      # Beiträge abrufen
GET  /wp-json/wp/v2/tags?search=...       # Tag suchen
POST /wp-json/wp/v2/tags                  # Tag erstellen
POST /wp-json/wp/v2/posts/{id}            # Post aktualisieren
```

### Tag-ID Konvertierung

WordPress erwartet Tag-IDs, nicht Tag-Namen:

```powershell
# Falsch:
$postData = @{ tags = @("Mietrecht", "Potsdam") }

# Richtig:
$postData = @{ tags = @(84, 85) }  # IDs der Tags
```

Das Skript übernimmt automatisch:
1. Tag-Name → Suche in WordPress
2. Falls vorhanden → ID verwenden
3. Falls nicht vorhanden → Tag erstellen → neue ID verwenden

### Paginierung

WordPress REST API liefert maximal 100 Beiträge pro Anfrage. Das Skript lädt automatisch alle Seiten:

```powershell
$page = 1
do {
    $posts = Invoke-RestMethod -Uri "$url?page=$page&per_page=100"
    $allPosts += $posts
    $page++
} while ($posts.Count -eq 100)
```

## Weiterführende Links

- [WordPress REST API Dokumentation](https://developer.wordpress.org/rest-api/)
- [Claude API Dokumentation](https://docs.anthropic.com/claude/reference)
- [PowerShell 7 Installation](https://aka.ms/PSWindows)

## Support

Bei Problemen:
1. Diese Anleitung durchlesen
2. `docs/TROUBLESHOOTING.md` prüfen
3. GitHub Issues: [Repository](https://github.com/uwefranke/wordpress-potsdam-rechtsanwalt)

---

**Version:** 1.0  
**Letzte Aktualisierung:** 14. April 2026  
**Kompatibilität:** WordPress 6.9+, PowerShell 7.0+
