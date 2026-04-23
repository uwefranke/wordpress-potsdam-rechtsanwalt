# Accessibility-Checkliste für Content-Überprüfung

Diese Checkliste hilft Ihnen, die Barrierefreiheit Ihrer WordPress-Inhalte zu überprüfen und zu optimieren.

## 🎯 Wie verwenden?

1. Gehen Sie Punkt für Punkt durch
2. Haken Sie erledigte Aufgaben ab
3. Notieren Sie sich gefundene Probleme
4. Beheben Sie nach Priorität (🔴 Hoch → 🟢 Niedrig)

---

## 🔴 PRIORITÄT HOCH (Sofort erledigen)

### 1. Alt-Texte für Bilder

**Warum wichtig?** Screen Reader benötigen Alt-Texte, um Bilder zu beschreiben.

#### Hero-Bild (Startseite)
- [ ] Hero-Bild hat beschreibenden Alt-Text
  - **Ort:** Design → Customizer → Hero-Bereich
  - **Beispiel:** `alt="Blick auf Potsdamer Nikolaikirche und Skyline bei Sonnenuntergang"`
  - **Nicht:** `alt="Bild"` oder `alt="hero-image"`

#### Team-Fotos
- [ ] Alle Team-Fotos haben Alt-Texte
  - **Ort:** Medien → Medienübersicht
  - **Beispiel:** `alt="Rechtsanwalt Max Müller, Fachanwalt für Mietrecht"`
  - **Nicht:** `alt="team-member"` oder `alt="Foto"`

#### Rechtsgebiete-Icons (Falls händisch hochgeladen)
- [ ] Dekorative Icons sind korrekt markiert
  - **Beispiel:** `alt=""` (leer) für rein dekorative Icons
  - **Hinweis:** Die Theme-Icons sind bereits korrekt implementiert

#### Alle anderen Bilder
- [ ] Jedes Bild auf jeder Seite überprüft
  - **Methode:** Medien → Medienübersicht → Jedes Bild einzeln öffnen
  - **Feld:** "Alternativtext" ausfüllen

**🔍 Schnelltest:**
```
1. WordPress → Medien → Medienübersicht
2. Jeden Eintrag öffnen
3. Feld "Alternativtext" prüfen
4. Wenn leer oder "Bild" → Beschreibenden Text hinzufügen
```

**Faustregel:**
- ✅ **Inhaltliches Bild**: Beschreibt, was zu sehen ist
- ✅ **Link-Bild**: Beschreibt, wohin der Link führt
- ✅ **Dekoratives Bild**: Leer lassen (`alt=""`)

---

### 2. Impressum & Datenschutz überprüfen

**Warum wichtig?** Diese Seiten werden oft besucht und müssen barrierefrei sein.

#### Impressum
- [ ] Überschriften-Hierarchie korrekt
  - **Seitentitel:** H1
  - **Abschnitte:** H2 (Angaben gemäß § 5 TMG, Kontakt, etc.)
  - **Unterabschnitte:** H3 (falls vorhanden)
- [ ] Keine H-Ebenen übersprungen
- [ ] Kontaktdaten als Text (nicht nur als Bild)
- [ ] E-Mail-Adresse als Link mit korrektem `mailto:`
- [ ] Telefonnummer als Link mit `tel:`

**🔍 Test:**
```
1. Seite "Impressum" öffnen
2. Text Editor → Überschriften-Ansicht prüfen
3. Sollte sein: H1 → H2 → H3 (keine Sprünge!)
```

#### Datenschutz
- [ ] Überschriften-Hierarchie korrekt (H1 → H2 → H3)
- [ ] Abschnitte logisch strukturiert
- [ ] Cookie-Hinweis vorhanden
- [ ] Links zu externen Diensten vorhanden

---

### 3. Kontaktformular testen

**Warum wichtig?** Formulare müssen per Tastatur bedienbar sein.

- [ ] Mit **Tab-Taste** durch Formular navigierbar
- [ ] Jedes Feld hat ein sichtbares Label
- [ ] Pflichtfelder haben visuellen Indikator (*)
- [ ] Absende-Button mit **Enter** aktivierbar
- [ ] Fehlermeldungen werden angezeigt
- [ ] Erfolgsmeldung wird angezeigt

**🔍 Test:**
```
1. Kontaktformular öffnen
2. Nur Tastatur verwenden (keine Maus!)
3. Tab → Durch Felder navigieren
4. Enter → Formular absenden
5. Prüfen: Fehlermeldungen sichtbar?
```

---

## 🟡 PRIORITÄT MITTEL (Bei Gelegenheit)

### 4. Link-Texte optimieren

**Warum wichtig?** "Hier klicken" sagt Screen-Reader-Nutzern nicht, wohin der Link führt.

- [ ] Alle Links beschreiben ihr Ziel
- [ ] Keine "Hier klicken" oder "Mehr" Links ohne Kontext
- [ ] Externe Links ggf. mit Hinweis "(öffnet in neuem Tab)"

**Beispiele:**

| ❌ Schlecht | ✅ Gut |
|-------------|--------|
| `<a href="/mietrecht">Mehr</a>` | `<a href="/mietrecht">Mehr über Mietrecht erfahren</a>` |
| `<a href="/kontakt">Hier</a>` | `<a href="/kontakt">Kontaktformular öffnen</a>` |
| `<a href="/download">Download</a>` | `<a href="/download">Broschüre Mietrecht herunterladen (PDF, 2 MB)</a>` |

**🔍 Durchsuchen:**
```
1. Jede Seite einzeln öffnen
2. Strg+F → "mehr" suchen
3. Strg+F → "hier" suchen
4. Strg+F → "klicken" suchen
5. Gefundene Links überarbeiten
```

**Checkliste pro Seite:**
- [ ] Startseite
- [ ] Rechtsgebiete (Übersichtsseite)
- [ ] Einzelne Rechtsgebiete-Seiten
  - [ ] Mietrecht
  - [ ] Immobilienrecht
  - [ ] Baurecht
  - [ ] BU / Erwerbsminderungsrente
  - [ ] Weitere...
- [ ] Team / Über uns
- [ ] Kontakt
- [ ] Blog-Posts überprüfen

---

### 5. Überschriften-Hierarchie auf allen Seiten

**Warum wichtig?** Screen Reader nutzen Überschriften zur Navigation.

**Regel:** Niemals H-Ebenen überspringen (H1 → H3 ist falsch!)

**✅ Richtig:**
```
H1 - Seitentitel
  H2 - Hauptabschnitt 1
    H3 - Unterabschnitt 1.1
    H3 - Unterabschnitt 1.2
  H2 - Hauptabschnitt 2
    H3 - Unterabschnitt 2.1
```

**❌ Falsch:**
```
H1 - Seitentitel
  H3 - Abschnitt 1 ← H2 übersprungen!
  H2 - Abschnitt 2 ← Falsche Reihenfolge!
```

**Zu prüfende Seiten:**
- [ ] Startseite
- [ ] Rechtsgebiete-Seiten (alle)
- [ ] Team / Über uns
- [ ] Kontakt
- [ ] Impressum (bereits geprüft ✓)
- [ ] Datenschutz (bereits geprüft ✓)
- [ ] Blog-Posts (Stichproben)

**🔍 Prüfmethode (einfach):**
```
1. Seite im Editor öffnen
2. Text markieren
3. Überschrift-Dropdown öffnen
4. Prüfen: H1 → H2 → H3 logisch?
```

**🔍 Prüfmethode (Browser):**
```
1. Seite öffnen
2. F12 → DevTools
3. Console eingeben:
   document.querySelectorAll('h1,h2,h3,h4,h5,h6')
4. Reihenfolge prüfen
```

---

### 6. Tabellen überprüfen (falls vorhanden)

**Warum wichtig?** Tabellen ohne Header-Zeilen sind für Screen Reader unverständlich.

- [ ] Alle Tabellen haben `<th>` Header
- [ ] Komplexe Tabellen haben Caption/Beschreibung
- [ ] Tabellen sind responsiv (scrollen auf Mobile)

**✅ Richtig (WordPress Gutenberg):**
```
1. Tabellen-Block einfügen
2. Erste Zeile als "Kopfzeile" markieren
3. Optional: Titel hinzufügen
```

**Seiten mit Tabellen:**
- [ ] _________________ (Seite identifizieren)
- [ ] _________________ (Seite identifizieren)

---

## 🟢 PRIORITÄT NIEDRIG (Nice-to-have)

### 7. Fachbegriffe erklären

**Warum wichtig?** Juristische Begriffe sind nicht allen Nutzern geläufig.

**Beispiele:**

| Begriff | Umsetzung |
|---------|-----------|
| BU | `<abbr title="Berufsunfähigkeitsversicherung">BU</abbr>` |
| WEG | `<abbr title="Wohnungseigentümergemeinschaft">WEG</abbr>` |
| § 577a BGB | `<abbr title="Bürgerliches Gesetzbuch">BGB</abbr>` |

- [ ] Wichtigste Abkürzungen mit `<abbr>` ausgezeichnet
- [ ] Glossar-Seite erstellt (optional)
- [ ] Erste Erwähnung von Fachbegriffen erklärt

**Häufige juristische Abkürzungen:**
- BU (Berufsunfähigkeitsversicherung)
- WEG (Wohnungseigentümergemeinschaft)
- AG (Amtsgericht)
- LG (Landgericht)
- BGH (Bundesgerichtshof)
- BGB (Bürgerliches Gesetzbuch)
- StGB (Strafgesetzbuch)
- ZPO (Zivilprozessordnung)

---

### 8. Video-Inhalte (falls vorhanden)

**Warum wichtig?** Videos müssen für gehörlose Nutzer zugänglich sein.

- [ ] Alle Videos haben Untertitel
- [ ] YouTube-Videos: "CC" Button aktivierbar
- [ ] Transkript als Text vorhanden (optional)
- [ ] Videos sind tastatursteuerbar (Play/Pause)

**Seiten mit Videos:**
- [ ] _________________ (Seite identifizieren)
- [ ] _________________ (Seite identifizieren)

---

### 9. PDF-Dokumente

**Warum wichtig?** PDFs müssen barrierefrei sein.

- [ ] PDFs sind durchsuchbar (kein gescanntes Bild)
- [ ] PDFs haben Lesezeichen/Gliederung
- [ ] Alternative als HTML-Version vorhanden
- [ ] Dateigröße im Link angegeben

**Beispiel:**
```
❌ [Broschüre](download.pdf)
✅ [Broschüre Mietrecht herunterladen (PDF, 2 MB)](download.pdf)
```

**Vorhandene PDFs:**
- [ ] _________________ (Datei identifizieren)
- [ ] _________________ (Datei identifizieren)

---

## 🧪 Technische Tests

### Test 1: Tastatur-Navigation (5 Minuten)

**Ziel:** Alle Funktionen ohne Maus bedienbar?

1. **Startseite öffnen**
   - [ ] Tab drücken → "Zum Hauptinhalt springen" erscheint
   - [ ] Weiter tabben → Menü-Items sichtbar fokussiert
   - [ ] Tab zu Service Cards → Gold-Outline sichtbar
   - [ ] Enter auf Card → Link öffnet

2. **Menü testen**
   - [ ] Tab zum Menü
   - [ ] Pfeiltasten → Durch Menü navigieren (falls Dropdown)
   - [ ] Enter → Seite öffnen

3. **Kontaktformular testen**
   - [ ] Tab durch alle Felder
   - [ ] Jedes Feld fokussierbar
   - [ ] Enter auf Button → Formular sendet

4. **Footer testen**
   - [ ] Tab zu Footer-Links
   - [ ] Alle Links erreichbar

**Ergebnis:**
- [ ] ✅ Alle Bereiche mit Tastatur erreichbar
- [ ] ⚠️ Probleme gefunden (notieren): _________________

---

### Test 2: Lighthouse Accessibility Score (5 Minuten)

**Ziel:** Technische Accessibility-Probleme finden

**Anleitung:**
```
1. Chrome öffnen
2. Startseite öffnen
3. F12 → DevTools
4. Tab "Lighthouse" auswählen
5. Nur "Accessibility" anhaken
6. "Generate report" klicken
7. Warten...
```

**Bewertung:**
- [ ] Score 90-100: ✅ Sehr gut
- [ ] Score 80-89: 🟡 Gut, kleine Verbesserungen möglich
- [ ] Score unter 80: 🔴 Verbesserungen nötig

**Gefundene Probleme:**
```
Problem 1: _________________
Problem 2: _________________
Problem 3: _________________
```

**Zu testende Seiten:**
- [ ] Startseite - Score: _____
- [ ] Impressum - Score: _____
- [ ] Datenschutz - Score: _____
- [ ] Kontakt - Score: _____
- [ ] Rechtsgebiet (Beispiel) - Score: _____

---

### Test 3: Screen Reader (Optional, 10 Minuten)

**Ziel:** Erleben, wie Screen Reader die Seite vorlesen

**Windows (NVDA - Kostenlos):**
```
1. NVDA herunterladen: https://www.nvaccess.org/
2. Installieren und starten
3. Website öffnen
4. H-Taste drücken → Durch Überschriften navigieren
5. Tab-Taste → Durch Links navigieren
6. Strg → Vorlesen stoppen
```

**Test-Fragen:**
- [ ] Werden alle Überschriften vorgelesen?
- [ ] Sind Links verständlich ohne Kontext?
- [ ] Werden Bilder beschrieben (Alt-Texte)?
- [ ] Ist die Navigation logisch?

---

## 📊 Fortschritts-Tracking

### Übersicht

| Bereich | Status | Notizen |
|---------|--------|---------|
| **Alt-Texte** | ⬜ Offen / 🟡 In Arbeit / ✅ Fertig | |
| **Impressum/Datenschutz** | ⬜ Offen / 🟡 In Arbeit / ✅ Fertig | |
| **Kontaktformular** | ⬜ Offen / 🟡 In Arbeit / ✅ Fertig | |
| **Link-Texte** | ⬜ Offen / 🟡 In Arbeit / ✅ Fertig | |
| **Überschriften** | ⬜ Offen / 🟡 In Arbeit / ✅ Fertig | |
| **Tabellen** | ⬜ Offen / 🟡 In Arbeit / ✅ Fertig | |
| **Fachbegriffe** | ⬜ Offen / 🟡 In Arbeit / ✅ Fertig | |
| **Videos** | ⬜ Offen / 🟡 In Arbeit / ✅ Fertig | |
| **PDFs** | ⬜ Offen / 🟡 In Arbeit / ✅ Fertig | |

### Zeit-Schätzung

| Aufgabe | Geschätzte Zeit |
|---------|-----------------|
| Alt-Texte (alle Bilder) | 30-60 Minuten |
| Impressum/Datenschutz | 15 Minuten |
| Kontaktformular-Test | 5 Minuten |
| Link-Texte optimieren | 20-40 Minuten |
| Überschriften prüfen | 30 Minuten |
| Tabellen | 10 Minuten |
| Fachbegriffe | 20 Minuten |
| Videos | 15 Minuten pro Video |
| PDFs | 30 Minuten pro PDF |
| **GESAMT (Minimum)** | **2-3 Stunden** |

---

## 🎯 Empfohlene Reihenfolge

### Session 1 (60 Minuten) - Das Wichtigste
1. **Alt-Texte für Hero-Bild** (5 Min)
2. **Alt-Texte für Team-Fotos** (10 Min)
3. **Impressum: Überschriften prüfen** (10 Min)
4. **Datenschutz: Überschriften prüfen** (10 Min)
5. **Kontaktformular testen** (5 Min)
6. **Lighthouse-Test durchführen** (10 Min)
7. **Tastatur-Navigation testen** (10 Min)

### Session 2 (60 Minuten) - Optimierungen
1. **Link-Texte auf Startseite** (15 Min)
2. **Link-Texte auf Rechtsgebiete-Seiten** (20 Min)
3. **Überschriften auf Startseite** (10 Min)
4. **Überschriften auf Rechtsgebiete-Seiten** (15 Min)

### Session 3 (30 Minuten) - Nice-to-have
1. **Fachbegriffe mit abbr** (15 Min)
2. **Tabellen prüfen** (10 Min)
3. **PDF-Links optimieren** (5 Min)

---

## 📝 Notizen & Gefundene Probleme

### Probleme (zum Beheben)

**Problem 1:**
- **Seite:** _________________
- **Beschreibung:** _________________
- **Priorität:** 🔴 / 🟡 / 🟢
- **Status:** ⬜ Offen / 🟡 In Arbeit / ✅ Behoben

**Problem 2:**
- **Seite:** _________________
- **Beschreibung:** _________________
- **Priorität:** 🔴 / 🟡 / 🟢
- **Status:** ⬜ Offen / 🟡 In Arbeit / ✅ Behoben

**Problem 3:**
- **Seite:** _________________
- **Beschreibung:** _________________
- **Priorität:** 🔴 / 🟡 / 🟢
- **Status:** ⬜ Offen / 🟡 In Arbeit / ✅ Behoben

---

## ✅ Fertigstellung

Wenn alle Checkboxen abgehakt sind:

- [ ] Alle 🔴 Priorität Hoch Aufgaben erledigt
- [ ] Alle 🟡 Priorität Mittel Aufgaben erledigt (optional)
- [ ] Alle 🟢 Priorität Niedrig Aufgaben erledigt (optional)
- [ ] Lighthouse Score über 90 auf allen Hauptseiten
- [ ] Tastatur-Navigation funktioniert überall
- [ ] Keine offenen Probleme mehr

**🎉 Glückwunsch! Ihre Website ist barrierefrei!**

---

## 📚 Weitere Ressourcen

- **Theme-Dokumentation:** [ACCESSIBILITY.md](ACCESSIBILITY.md)
- **WCAG 2.1 Richtlinien:** https://www.w3.org/TR/WCAG21/
- **BIK BITV-Test:** https://www.bitvtest.de/
- **Aktion Mensch:** https://www.einfach-fuer-alle.de/

---

**Version:** 1.0 (23. April 2026)  
**Für Theme:** Potsdam Rechtsanwalt v2.1.5+
