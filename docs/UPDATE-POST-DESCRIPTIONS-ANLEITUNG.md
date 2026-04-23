# Meta-Description Updater - Anleitung

## 📝 Übersicht

Das `update-post-descriptions.ps1` Skript generiert automatisch SEO-optimierte Meta-Descriptions (150-160 Zeichen) für alle WordPress-Seiten und Beiträge mithilfe von Claude AI.

Die Descriptions werden als **Rank Math Custom Field** (`rank_math_description`) gespeichert.

---

## ⚙️ Voraussetzungen

### 1. **PowerShell 7+**
```powershell
$PSVersionTable.PSVersion  # Mindestens 7.0
```

### 2. **.env Konfiguration**
Die Datei `config/.env` muss existieren mit:
```env
# WordPress
WP_URL=https://www.potsdam-rechtsanwalt.de
WP_USER=dein_username
WP_APP_PASSWORD=dein_app_password

# AI Provider
AI_PROVIDER=claude
CLAUDE_API_KEY=sk-ant-...
CLAUDE_MODEL=claude-3-5-sonnet-20241022
CLAUDE_MAX_TOKENS=1024
CLAUDE_TEMPERATURE=0.7
```

### 3. **Rank Math SEO Plugin**
- Rank Math muss installiert und aktiviert sein
- Das Plugin speichert Meta-Descriptions als Custom Fields

---

## 🚀 Verwendung

### Basis-Verwendung

```powershell
# Alle Seiten und Beiträge aktualisieren
.\scripts\update-post-descriptions.ps1

# Nur Seiten
.\scripts\update-post-descriptions.ps1 -PostType pages

# Nur Beiträge
.\scripts\update-post-descriptions.ps1 -PostType posts
```

### Erweiterte Optionen

```powershell
# Testlauf (keine Änderungen)
.\scripts\update-post-descriptions.ps1 -DryRun

# Nur erste 5 Seiten
.\scripts\update-post-descriptions.ps1 -PostType pages -MaxItems 5

# Vorhandene Descriptions ersetzen
.\scripts\update-post-descriptions.ps1 -ReplaceExisting

# Nur Beiträge einer Kategorie (ID 14)
.\scripts\update-post-descriptions.ps1 -PostType posts -CategoryId 14

# Kombination
.\scripts\update-post-descriptions.ps1 -PostType pages -MaxItems 10 -DryRun -ReplaceExisting
```

---

## 📋 Parameter

| Parameter | Typ | Standard | Beschreibung |
|-----------|-----|----------|--------------|
| `-PostType` | String | `both` | `posts`, `pages` oder `both` |
| `-CategoryId` | Int | - | Nur Beiträge dieser Kategorie (nur für posts) |
| `-Status` | String | `publish` | Post-Status (publish, draft, etc.) |
| `-ReplaceExisting` | Switch | Aus | Vorhandene Descriptions ersetzen |
| `-MaxItems` | Int | 0 | Max. Anzahl (0 = alle) |
| `-DryRun` | Switch | Aus | Testmodus ohne Änderungen |

---

## 🎯 Workflow

### 1. **Testlauf durchführen**
```powershell
.\scripts\update-post-descriptions.ps1 -PostType pages -MaxItems 3 -DryRun
```

**Output:**
```
╔════════════════════════════════════════════════════════╗
║  WordPress Meta-Description Updater (AI)              ║
║  Rechtsanwalt Matthias Lange, Potsdam                  ║
╚════════════════════════════════════════════════════════╝

⚠️  DRY RUN MODUS - Keine Änderungen werden gespeichert!

🔌 Teste WordPress-Verbindung...
✅ WordPress-Verbindung erfolgreich! Angemeldet als: uwefranke

📥 Lade pages...
   ✅ 3 pages gefunden

📊 Gesamt: 3 Inhalte werden verarbeitet

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

[1/3] Seite: Home
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   📝 Generiere Meta-Description...
   📏 Länge: 157 Zeichen
   ✅ Description generiert:
      'Rechtsanwalt Matthias Lange in Potsdam - Kompetente Rechtsberatung in Mietrecht, Immobilienrecht, Baurecht und Berufsunfähigkeitsversicherung.'
   💭 Würde Description setzen (DRY RUN)

[2/3] Seite: Impressum
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   ⏭️  Hat bereits Description (142 Zeichen) - übersprungen
      'Impressum der Kanzlei Rechtsanwalt Matthias Lange in Potsdam...'

[3/3] Seite: Datenschutz
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   📝 Generiere Meta-Description...
   📏 Länge: 153 Zeichen
   ✅ Description generiert:
      'Datenschutzerklärung der Kanzlei Matthias Lange in Potsdam. Erfahren Sie, wie wir Ihre persönlichen Daten schützen und verarbeiten.'
   💭 Würde Description setzen (DRY RUN)

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

📊 Zusammenfassung:
   ✅ Erfolgreich: 2
   ✔️  Bereits vorhanden: 1
   📝 Gesamt: 3

💡 Führe das Skript ohne -DryRun aus, um die Änderungen zu übernehmen
```

### 2. **Produktiv ausführen**
```powershell
.\scripts\update-post-descriptions.ps1 -PostType pages
```

### 3. **In WordPress prüfen**
```
WordPress → Seiten → [Seite öffnen]
→ Nach unten scrollen zur Rank Math Meta Box
→ "Edit Snippet" klicken
→ Meta-Description prüfen
```

### 4. **Mit Lighthouse testen**
```
1. Chrome öffnen
2. Seite öffnen
3. F12 → DevTools → Lighthouse
4. "Generate report"
5. Prüfen: "Document has a meta description" ✅
```

---

## 🎨 KI-Prompt-Details

Das Skript verwendet folgenden Prompt für jede Seite/Beitrag:

```
Erstelle eine SEO-optimierte Meta-Description für folgende WordPress-Seite/Artikel.

Anforderungen:
- EXAKT 150-160 Zeichen (nicht mehr, nicht weniger!)
- Klare Zusammenfassung des Inhalts
- Handlungsaufforderung integrieren
- Fokus: Rechtsanwalt Matthias Lange, Potsdam
- Keywords: Mietrecht, Immobilienrecht, Baurecht, BU-Versicherung
- Professionell und vertrauenswürdig
- NUR die Description ausgeben
```

**Beispiel-Output:**
```
Rechtsanwalt Matthias Lange in Potsdam berät Sie kompetent bei Mietrecht, Immobilienrecht und Baurecht. Persönliche Beratung mit langjähriger Erfahrung.
```
(157 Zeichen)

---

## 🔧 Technische Details

### WordPress REST API Endpoints
```http
GET  /wp-json/wp/v2/posts       # Beiträge abrufen
GET  /wp-json/wp/v2/pages       # Seiten abrufen
POST /wp-json/wp/v2/posts/{id}  # Beitrag aktualisieren
POST /wp-json/wp/v2/pages/{id}  # Seite aktualisieren
```

### Rank Math Custom Field
```json
{
  "meta": {
    "rank_math_description": "Ihre Meta-Description hier..."
  }
}
```

### Fallback-Mechanismus
1. **Primär:** Update via `meta.rank_math_description`
2. **Fallback:** Direktes Post-Meta Update via `/meta` Endpoint

---

## ❓ FAQ

### **Q: Werden vorhandene Descriptions überschrieben?**
**A:** Nein, außer Sie nutzen `-ReplaceExisting`. Standardmäßig werden nur leere Descriptions gefüllt.

### **Q: Funktioniert es mit anderen SEO-Plugins?**
**A:** Das Skript ist für Rank Math optimiert. Für Yoast SEO müssten Sie `rank_math_description` durch `_yoast_wpseo_metadesc` ersetzen.

### **Q: Was kostet die AI-Nutzung?**
**A:** Claude API kostet ~$3 pro 1 Million Input-Tokens. Bei 100 Seiten mit je 800 Zeichen = ~$0.03.

### **Q: Kann ich den Prompt anpassen?**
**A:** Ja, bearbeiten Sie die Funktion `New-MetaDescription` in Zeile 240-270 des Skripts.

### **Q: Warum 150-160 Zeichen?**
**A:** Google zeigt in den Suchergebnissen maximal 155-160 Zeichen an. Kürzere Descriptions werden nicht optimal genutzt.

---

## 🐛 Troubleshooting

### **Problem: "WordPress-Verbindung fehlgeschlagen"**
```powershell
# Prüfe .env Konfiguration
cat config\.env

# Teste WordPress-Login manuell
Invoke-RestMethod -Uri "https://www.potsdam-rechtsanwalt.de/wp-json/wp/v2/users/me" `
  -Headers @{ "Authorization" = "Basic [base64]" }
```

### **Problem: "rank_math_description konnte nicht gespeichert werden"**
- Prüfe ob Rank Math aktiviert ist
- Teste manuell in WordPress → Seite bearbeiten → Rank Math Meta Box
- Prüfe User-Berechtigungen (App-Password)

### **Problem: "AI-Anfrage fehlgeschlagen"**
```powershell
# Prüfe API-Key
echo $env:CLAUDE_API_KEY

# Teste API direkt
curl -X POST https://api.anthropic.com/v1/messages `
  -H "x-api-key: $env:CLAUDE_API_KEY" `
  -H "anthropic-version: 2023-06-01"
```

### **Problem: "Description zu lang/kurz"**
- Das Skript kürzt automatisch auf 160 Zeichen
- Bei zu kurzen Descriptions (< 150) wird eine Warnung ausgegeben
- Sie können den AI-Prompt anpassen für bessere Ergebnisse

---

## 📊 Best Practices

### 1. **Reihenfolge der Verarbeitung**
```powershell
# 1. Erst Testlauf
.\scripts\update-post-descriptions.ps1 -MaxItems 5 -DryRun

# 2. Wichtige Seiten zuerst
.\scripts\update-post-descriptions.ps1 -PostType pages

# 3. Blog-Beiträge
.\scripts\update-post-descriptions.ps1 -PostType posts

# 4. Nachkontrolle
.\scripts\update-post-descriptions.ps1 -DryRun  # Prüft welche bereits haben
```

### 2. **Batch-Verarbeitung**
```powershell
# Verarbeite in kleinen Batches (reduziert Fehlerrisiko)
.\scripts\update-post-descriptions.ps1 -MaxItems 10
.\scripts\update-post-descriptions.ps1 -MaxItems 10  # Nächste 10
```

### 3. **Manuelle Nachbearbeitung**
Nach dem Skript:
- Prüfe jede Description in Rank Math
- Optimiere für lokale Keywords (Potsdam)
- Füge spezifische Handlungsaufforderungen hinzu
- Teste mit Lighthouse

---

## 📝 Changelog

### Version 1.0 (23. April 2026)
- Initiale Version
- Support für Posts und Pages
- Rank Math Integration
- Claude AI Integration
- DryRun-Modus
- Automatische Längen-Validierung

---

## 🔗 Siehe auch

- [UPDATE-POST-TAGS-ANLEITUNG.md](UPDATE-POST-TAGS-ANLEITUNG.md) - Tags mit AI generieren
- [ACCESSIBILITY.md](ACCESSIBILITY.md) - SEO & Accessibility Best Practices
- [Rank Math Documentation](https://rankmath.com/kb/) - Rank Math Dokumentation

---

**Autor:** GitHub Copilot  
**Projekt:** Potsdam Rechtsanwalt v2.2.0  
**Datum:** 23. April 2026
