# AI Content Generator - Anleitung

Automatische WordPress-Artikel-Generierung mit Claude AI für Rechtsanwalt Matthias Lange, Potsdam.

---

## 📋 Übersicht

Das PowerShell-Script `scripts/wordpress-ai-content-generator.ps1` generiert automatisch SEO-optimierte Blog-Artikel zu mietrechtlichen Themen und veröffentlicht sie direkt in WordPress.

**Features:**
- ✅ Claude 4.6 Sonnet Integration (professionelle Rechtstexte)
- ✅ Automatisches WordPress-Publishing via REST API
- ✅ SEO-Meta-Descriptions
- ✅ Sichere Credential-Verwaltung (config/.env Datei)
- ✅ Batch-Processing (mehrere Artikel auf einmal)
- ✅ Draft-Modus (Artikel vor Veröffentlichung prüfen)

---

## 🚀 Installation & Setup

### 1. Voraussetzungen

**PowerShell 7.0+** (nicht Windows PowerShell 5.1!)

```powershell
# Installation via winget
winget install Microsoft.PowerShell

# Oder: Microsoft Store → "PowerShell"
```

### 2. API Keys beschaffen

#### WordPress Application Password

1. WordPress Admin → **Benutzer → Profil**
2. Scrolle zu **"Anwendungspasswörter"**
3. Name eingeben: `AI Content Generator`
4. **"Neues Passwort hinzufügen"** klicken
5. Passwort kopieren (Format: `xxxx xxxx xxxx xxxx`)

**Wichtig:** HTTPS muss aktiviert sein!

#### Claude API Key (Anthropic)

1. Gehe zu: https://console.anthropic.com
2. **Sign Up** → Account erstellen
3. **Settings → Billing:** Credits kaufen (mind. $5)
4. **Settings → API Keys:** https://console.anthropic.com/settings/keys
5. **"Create Key"** → Key kopieren (beginnt mit `sk-ant-...`)

**Kosten:** Ca. $0.01-0.02 pro Artikel (1000 Wörter)

### 3. Konfiguration

#### .env Datei erstellen

```powershell
# Im Projektordner
Copy-Item config\.env.example config\.env
notepad config\.env
```

#### config/.env ausfüllen

```ini
# WordPress Configuration
WP_URL=https://law.scriptbb.de
WP_USER=lawadmin
WP_APP_PASSWORD=xxxx xxxx xxxx xxxx    # Dein WordPress App Password
WP_DEFAULT_CATEGORY=14                   # WordPress Category ID (z.B. "Mietrecht")

# AI Provider Configuration
AI_PROVIDER=claude

# Claude/Anthropic
CLAUDE_API_KEY=sk-ant-...               # Dein Claude API Key
CLAUDE_MODEL=claude-sonnet-4-6          # Aktuelles Modell (April 2026)

# AI Settings
AI_TEMPERATURE=0.7                       # Kreativität (0.0-1.0)
AI_MAX_TOKENS=4096                       # Max. Artikellänge

# Content Settings
CONTENT_WORD_COUNT=1000                  # Ziel-Wortanzahl
CONTENT_LANGUAGE=Deutsch                 # Ausgabesprache
```

**Wichtig:** `config/.env` ist in `.gitignore` und wird NICHT ins Repository hochgeladen!

---

## 💡 Verwendung

### Basis-Befehle

```powershell
# PowerShell 7 öffnen (nicht Windows PowerShell!)
pwsh

# Ins Projektverzeichnis wechseln
cd C:\Users\uwefr\OneDrive\Dokumente\web\potsdam-rechtsanwalt

# Einzelner Artikel
.\scripts\wordpress-ai-content-generator.ps1 -Topics "Mietminderung bei Schimmel"

# 5 Standard-Artikel (siehe Script)
.\scripts\wordpress-ai-content-generator.ps1

# Mehrere Artikel mit eigenen Themen
.\scripts\wordpress-ai-content-generator.ps1 -Topics "Thema 1", "Thema 2", "Thema 3"

# Direkt veröffentlichen (statt Draft)
.\scripts\wordpress-ai-content-generator.ps1 -Status publish

# WordPress-Kategorien anzeigen
.\scripts\show-categories.ps1
```

### Standard-Themen im Script

Das Script enthält 5 vordefinierte Mietrecht-Themen:

1. Mietminderung bei Schimmelbefall
2. Kündigung wegen Zahlungsverzug
3. Nebenkostenabrechnung prüfen
4. Schönheitsreparaturen in der Mietwohnung
5. Mieterhöhung nach Modernisierung

**Anpassen:** Öffne Script, suche nach `$defaultTopics` (Zeile ~510)

---

## 📝 Workflow

### Typischer Ablauf

```powershell
# 1. 3 Artikel generieren (als Draft)
.\scripts\wordpress-ai-content-generator.ps1 -Topics "Thema A", "Thema B", "Thema C"

# 2. WordPress öffnen → Entwürfe prüfen
# https://law.scriptbb.de/wp-admin/edit.php?post_status=draft

# 3. Artikel bearbeiten/veröffentlichen
# Oder: Script mit -Status publish nochmal ausführen
```

### Output-Beispiel

```
╔════════════════════════════════════════════════════════╗
║  WordPress AI Content Generator                        ║
║  Rechtsanwalt Matthias Lange, Potsdam                  ║
╚════════════════════════════════════════════════════════╝

🔌 Teste WordPress-Verbindung...
✅ WordPress-Verbindung erfolgreich! Angemeldet als: lawadmin

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

[1/3] Mietminderung bei Schimmel
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
🤖 Generiere Content für: Mietminderung bei Schimmel
   ✅ Content generiert (7317 Zeichen)
📤 Veröffentliche in WordPress...
   ✅ Post erstellt!
   📝 ID: 475
   🔗 Link: https://law.scriptbb.de/?p=475
   📊 Status: draft

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

📊 Zusammenfassung:
   ✅ Erfolgreich: 3
   📝 Gesamt: 3

🎉 Alle Artikel wurden als draft in WordPress erstellt!
```

---

## ⚙️ Erweiterte Konfiguration

### AI-Provider wechseln

Das Script unterstützt 3 AI-Provider:

#### 1. Claude (Empfohlen für Rechtstexte)

```ini
AI_PROVIDER=claude
CLAUDE_API_KEY=sk-ant-...
CLAUDE_MODEL=claude-sonnet-4-6
```

**Vorteile:**
- Sehr gute Textqualität
- Präzise und professionell
- $5 Startguthaben
- ~$0.01-0.02 pro Artikel

#### 2. Google Gemini (Kostenlos)

```ini
AI_PROVIDER=gemini
GEMINI_API_KEY=AIza...
GEMINI_MODEL=models/gemini-2.0-flash
```

**Vorteile:**
- Komplett kostenlos
- 1500 Requests/Tag
- Keine Kreditkarte nötig

**Nachteile:**
- Qualität etwas niedriger
- Quota schnell aufgebraucht

#### 3. OpenAI (Premium)

```ini
AI_PROVIDER=openai
OPENAI_API_KEY=sk-...
OPENAI_MODEL=gpt-4
```

**Vorteile:**
- Sehr gute Qualität (GPT-4)
- Stabil und schnell

**Nachteile:**
- Teurer (~$0.03-0.05 pro Artikel)
- Kostenpflichtig (kein Free Tier)

### WordPress-Kategorie ändern

```powershell
# 1. Kategorie-IDs anzeigen
.\scripts\show-categories.ps1

# 2. In config/.env ändern
WP_DEFAULT_CATEGORY=14  # Deine gewünschte ID
```

### Artikellänge anpassen

```ini
# In config/.env
CONTENT_WORD_COUNT=1500    # Längere Artikel
AI_MAX_TOKENS=6000         # Mehr Tokens für längere Texte
```

**Hinweis:** Mehr Tokens = höhere Kosten

### Kreativität einstellen

```ini
# In config/.env
AI_TEMPERATURE=0.5   # Konservativ, faktisch (empfohlen für Recht)
AI_TEMPERATURE=0.7   # Balanced (Standard)
AI_TEMPERATURE=0.9   # Kreativ, variiert
```

---

## 🔒 Sicherheit

### Credentials schützen

✅ **`config/.env` ist in `.gitignore`** → wird nicht ins Git-Repository hochgeladen
✅ **Nie** API Keys oder Passwords direkt ins Script schreiben
✅ **Nie** `config/.env` öffentlich teilen (GitHub, Screenshots, etc.)

### API Keys rotieren

Alle 3-6 Monate neue Keys erstellen:

1. Neuen Key erstellen (WordPress/Claude)
2. In `config/.env` eintragen
3. Alten Key löschen

---

## 🐛 Troubleshooting

### Fehler: "PowerShell 5.1 nicht unterstützt"

**Problem:** Du nutzt Windows PowerShell 5.1
**Lösung:**

```powershell
winget install Microsoft.PowerShell
# Dann neues Terminal öffnen: "PowerShell" (nicht "Windows PowerShell")
```

### Fehler: "WordPress Application Password fehlt"

**Problem:** `config/.env` nicht korrekt konfiguriert
**Lösung:**

```powershell
# Prüfe .env Datei
Get-Content config\.env | Select-String "WP_APP_PASSWORD"

# Sollte aussehen: WP_APP_PASSWORD=xxxx xxxx xxxx xxxx
```

### Fehler: "Claude API - 404 Not Found"

**Problem:** Falscher Modellname
**Lösung:**

1. Gehe zu https://console.anthropic.com/settings/workspaces
2. Prüfe verfügbare Modelle unter "Model access"
3. Aktualisiere `CLAUDE_MODEL` in `config/.env`

```ini
# Beispiel (April 2026)
CLAUDE_MODEL=claude-sonnet-4-6
```

### Fehler: "Credit balance too low"

**Problem:** Kein Guthaben auf Claude-Account
**Lösung:**

1. https://console.anthropic.com/settings/billing
2. "Add credits" → Mind. $5
3. Ggf. neuen API Key erstellen

### Artikel beginnt mit "```html"

**Problem:** Schon behoben! Script entfernt Code-Block-Marker automatisch
**Falls doch:** Neueste Version des Scripts verwenden

### Artikel endet mitten im Wort

**Problem:** Token-Limit zu niedrig
**Lösung:**

```ini
# In config/.env
AI_MAX_TOKENS=4096   # Oder höher (6000, 8000)
```

**Hinweis:** Höhere Tokens = höhere Kosten

---

## 📊 Kosten-Übersicht

### Claude 4.6 Sonnet (Empfohlen)

- **Input:** $3 pro 1M Tokens
- **Output:** $15 pro 1M Tokens
- **Pro Artikel (1000 Wörter):** ~$0.01-0.02
- **100 Artikel:** ~$1-2
- **$5 Startguthaben:** ~300-500 Artikel

### Gemini 2.0 Flash (Kostenlos)

- **Free Tier:** 1500 Requests/Tag
- **Kosten:** $0
- **Limit:** Quota kann aufgebraucht sein

### OpenAI GPT-4

- **Input:** $5 pro 1M Tokens
- **Output:** $15 pro 1M Tokens
- **Pro Artikel:** ~$0.03-0.05
- **Teurer als Claude**

---

## 🎯 Best Practices

### Themen auswählen

**Gute Themen:**
- ✅ Spezifisch: "Mietminderung bei Schimmel" statt "Mietrecht"
- ✅ Praxisnah: Konkrete Probleme von Mandanten
- ✅ Lokal: Potsdam-Bezug wo möglich
- ✅ Aktuell: Gesetzesänderungen, Urteile

**Themen-Ideen:**
- Mietminderung (Schimmel, Baulärm, Heizung)
- Kündigungen (Eigenbedarf, Zahlungsverzug)
- Nebenkostenabrechnung
- Schönheitsreparaturen
- Mieterhöhung
- Untervermietung
- Kaution

### Artikel-Qualität sichern

1. **Immer als Draft erstellen** → Vor Veröffentlichung prüfen
2. **Disclaimer prüfen:** Sollte enthalten sein
3. **Rechtliche Korrektheit:** Artikel von Anwalt prüfen lassen
4. **SEO optimieren:** Titel, Meta-Description, Keywords
5. **Lokal anpassen:** Potsdam-Bezüge ggf. ergänzen

### Batch-Generierung

```powershell
# 10 Artikel für die Woche
.\scripts\wordpress-ai-content-generator.ps1 -Topics `
  "Thema 1", "Thema 2", "Thema 3", "Thema 4", "Thema 5", `
  "Thema 6", "Thema 7", "Thema 8", "Thema 9", "Thema 10"
```

**Vorteil:** Effizienter, alle auf einmal prüfen

### Content-Strategie

**Empfehlung:**
- 2-3 Artikel pro Woche generieren
- Jeden Montag neue Artikel erstellen
- Dienstag: Prüfen und veröffentlichen
- Mittwoch-Freitag: Social Media Promotion

**Automatisierung:** Windows Task Scheduler für wöchentliche Generierung

---

## 📁 Script-Struktur

```
scripts/
├── wordpress-ai-content-generator.ps1  # Hauptscript
├── show-categories.ps1                 # Kategorien anzeigen
└── test-gemini.ps1                     # Gemini API Tester

config/
├── .env                                # Credentials (nicht in Git!)
└── .env.example                        # Template
```

### Standard-Themen bearbeiten

Öffne `scripts/wordpress-ai-content-generator.ps1` und suche nach:

```powershell
$defaultTopics = @(
    "Mietminderung bei Schimmelbefall",
    "Kündigung wegen Zahlungsverzug",
    # ... deine Themen hier hinzufügen
)
```

---

## 🔄 Updates

### Script aktualisieren

Wenn das Script im Git-Repository aktualisiert wird:

```powershell
git pull origin main

# config/.env bleibt erhalten (ist in .gitignore)
# Ggf. neue Einstellungen aus config/.env.example übernehmen
```

---

## 📞 Support

**Bei Problemen:**

1. Diese Anleitung lesen (Troubleshooting)
2. Logs prüfen (Script gibt detaillierte Fehlermeldungen)
3. API-Status prüfen:
   - Claude: https://status.anthropic.com
   - WordPress: Server-Logs

**Dokumentation:**
- Claude API: https://docs.anthropic.com
- WordPress REST API: https://developer.wordpress.org/rest-api/

---

## ✅ Checkliste: Erstes Setup

- [ ] PowerShell 7 installiert
- [ ] WordPress Application Password erstellt
- [ ] Claude API Key beschafft ($5 Credits gekauft)
- [ ] `config/.env` Datei erstellt und ausgefüllt
- [ ] Test-Artikel generiert: `.\scripts\wordpress-ai-content-generator.ps1 -Topics "Test"`
- [ ] Artikel in WordPress geprüft
- [ ] Test-Artikel gelöscht
- [ ] Produktiv-Themen vorbereitet

---

**Viel Erfolg mit der automatischen Content-Erstellung!** 🚀

*Letzte Aktualisierung: 14. April 2026*
