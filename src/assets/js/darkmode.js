/**
 * Dark Mode Toggle
 * Respektiert System-Präferenz und ermöglicht manuelles Umschalten
 */

(function() {
    'use strict';
    
    const STORAGE_KEY = 'potsdam-theme-mode';
    const DARK_CLASS = 'dark-mode';
    
    /**
     * Aktuelle Präferenz ermitteln
     * Reihenfolge: localStorage > System-Präferenz > Hell (Default)
     */
    function getPreferredTheme() {
        const stored = localStorage.getItem(STORAGE_KEY);
        if (stored) {
            return stored;
        }
        
        // System-Präferenz prüfen
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            return 'dark';
        }
        
        return 'light';
    }
    
    /**
     * Theme anwenden
     */
    function applyTheme(theme) {
        if (theme === 'dark') {
            document.documentElement.classList.add(DARK_CLASS);
        } else {
            document.documentElement.classList.remove(DARK_CLASS);
        }
        
        // Button-Status aktualisieren
        updateToggleButton(theme);
    }
    
    /**
     * Theme umschalten
     */
    function toggleTheme() {
        const current = document.documentElement.classList.contains(DARK_CLASS) ? 'dark' : 'light';
        const newTheme = current === 'dark' ? 'light' : 'dark';
        
        localStorage.setItem(STORAGE_KEY, newTheme);
        applyTheme(newTheme);
    }
    
    /**
     * Toggle-Button Status aktualisieren
     */
    function updateToggleButton(theme) {
        const buttons = document.querySelectorAll('.dark-mode-toggle');
        buttons.forEach(button => {
            const icon = button.querySelector('.toggle-icon');
            if (icon) {
                if (theme === 'dark') {
                    icon.textContent = '☀️'; // Sonne-Icon wenn Dark aktiv
                    button.setAttribute('aria-label', 'Zum hellen Modus wechseln');
                } else {
                    icon.textContent = '🌙'; // Mond-Icon wenn Hell aktiv
                    button.setAttribute('aria-label', 'Zum dunklen Modus wechseln');
                }
            }
        });
    }
    
    /**
     * Toggle-Buttons initialisieren
     */
    function initToggleButtons() {
        const buttons = document.querySelectorAll('.dark-mode-toggle');
        if (buttons.length === 0) {
            // Wenn Buttons noch nicht im DOM sind, nochmal versuchen
            setTimeout(initToggleButtons, 100);
            return;
        }
        
        buttons.forEach(button => {
            // Vorherige Listener entfernen (falls vorhanden) und neu setzen
            button.removeEventListener('click', toggleTheme);
            button.addEventListener('click', toggleTheme);
        });
    }
    
    /**
     * System-Präferenz-Änderungen überwachen
     */
    function watchSystemPreference() {
        if (!window.matchMedia) return;
        
        const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
        
        // Nur reagieren wenn keine manuelle Präferenz gesetzt wurde
        mediaQuery.addEventListener('change', (e) => {
            if (!localStorage.getItem(STORAGE_KEY)) {
                applyTheme(e.matches ? 'dark' : 'light');
            }
        });
    }
    
    /**
     * Initialisierung
     */
    function init() {
        // Theme sofort anwenden (vor Page-Load für kein Flackern)
        const theme = getPreferredTheme();
        applyTheme(theme);
        
        // Nach DOM-Load Buttons initialisieren
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => {
                initToggleButtons();
                watchSystemPreference();
            });
        } else {
            initToggleButtons();
            watchSystemPreference();
        }
    }
    
    // Sofort starten
    init();
})();
