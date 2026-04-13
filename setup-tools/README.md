# Setup-Tools

Dieser Ordner enthält **einmalige Setup-Scripts**, die NICHT im Theme-Update-ZIP enthalten sind.

## ⚠️ Sicherheitshinweis

Diese Scripts dürfen **NIEMALS** auf einem produktiven Server liegen bleiben!

## 📁 Dateien

### setup-pages.php

**Zweck:** Erstellt automatisch alle Seiten, Menüs und Inhalte beim ersten Theme-Setup.

**Verwendung:**
1. Nur bei **Neuinstallation** verwenden
2. Datei manuell auf Server hochladen (nicht über Theme-Update!)
3. Im Browser aufrufen: `https://deine-domain.de/wp-content/themes/potsdam-rechtsanwalt/setup-pages.php`
4. Nach Verwendung **SOFORT LÖSCHEN**!

**Warum nicht im Theme?**
- Sicherheitsrisiko (direkter PHP-Zugriff ohne WordPress-Security)
- Überschreibt existierende Seiten
- Nur für erste Installation gedacht

## 🚫 .gitignore

Der `setup-tools/` Ordner wird automatisch vom GitHub Actions Build ausgeschlossen.

Nur Entwickler haben Zugriff auf diese Dateien über das Git-Repository.

---

**Erstellt:** Version 1.2.0  
**Zweck:** Entwickler-Tools, nicht für Produktion
