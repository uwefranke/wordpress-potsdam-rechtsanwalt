# Quick Start - GitHub Workflow

## Automatisches Theme-Release erstellen

### 1. Änderungen vorbereiten

```bash
# Dateien hinzufügen
git add .

# Committen
git commit -m "Theme-Updates für Version 1.0.0"

# Pushen
git push origin main
```

### 2. CHANGELOG aktualisieren

Bearbeite `CHANGELOG.md` und füge deine Änderungen hinzu.

### 3. Release-Tag erstellen

```bash
# Tag erstellen
git tag -a v1.0.0 -m "Release Version 1.0.0"

# Tag pushen (löst automatischen Workflow aus!)
git push origin v1.0.0
```

### 4. Warten (1-2 Minuten)

GitHub Actions erstellt automatisch:
- ✅ ZIP-Paket des Themes
- ✅ SHA-256 Prüfsumme
- ✅ GitHub Release mit Download-Links

### 5. Theme herunterladen

1. Gehe zu: https://github.com/DEIN-USERNAME/potsdam-rechtsanwalt/releases
2. Finde deine Version (z.B. v1.0.0)
3. Lade `potsdam-rechtsanwalt-theme-v1.0.0.zip` herunter

### 6. In WordPress installieren

1. WordPress Dashboard → **Design** → **Themes** → **Installieren**
2. **Theme hochladen** klicken
3. ZIP-Datei auswählen
4. **Installieren** klicken
5. **Aktivieren**

---

## Workflow-Status ansehen

**GitHub → Actions Tab**

Dort siehst du:
- ✅ Erfolgreich gelaufene Workflows (grün)
- ❌ Fehlgeschlagene Workflows (rot)
- 🟡 Laufende Workflows (gelb)

---

## Versionsnummern

Nutze **Semantic Versioning**:

- `v1.0.0` → Erste stabile Version
- `v1.1.0` → Neues Feature hinzugefügt
- `v1.0.1` → Bugfix

---

## Weitere Infos

Siehe [.github/WORKFLOW-GUIDE.md](.github/WORKFLOW-GUIDE.md) für Details.
