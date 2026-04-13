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
            console.log('[Dark Mode] Manuelle Präferenz gefunden:', stored);
            return stored;
        }
        
        // System-Präferenz prüfen
        const systemPrefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        const systemTheme = systemPrefersDark ? 'dark' : 'light';
        console.log('[Dark Mode] System-Präferenz:', systemTheme);
        
        return systemTheme;
    }
    
    /**
     * Theme anwenden
     * @param {string} theme - 'dark', 'light' oder 'auto' (System-Präferenz)
     * @param {boolean} isManual - Ob es eine manuelle Wahl ist (speichern in localStorage)
     */
    function applyTheme(theme, isManual) {
        const html = document.documentElement;
        
        console.log('[Dark Mode] applyTheme:', theme, 'isManual:', isManual);
        
        if (isManual === false) {
            // System-Präferenz: Keine Klasse setzen, Media Query entscheidet
            html.classList.remove(DARK_CLASS);
            html.classList.remove('light-mode');
            console.log('[Dark Mode] Keine Klassen gesetzt - Media Query entscheidet');
        } else if (theme === 'dark') {
            html.classList.add(DARK_CLASS);
            html.classList.remove('light-mode');
            console.log('[Dark Mode] Klasse gesetzt: dark-mode');
        } else {
            html.classList.remove(DARK_CLASS);
            html.classList.add('light-mode');
            console.log('[Dark Mode] Klasse gesetzt: light-mode');
        }
        
        // Button-Status aktualisieren
        updateToggleButton(theme);
    }
    
    /**
     * Theme umschalten
     */
    function toggleTheme(e) {
        if (e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        const current = document.documentElement.classList.contains(DARK_CLASS) ? 'dark' : 'light';
        const newTheme = current === 'dark' ? 'light' : 'dark';
        
        localStorage.setItem(STORAGE_KEY, newTheme);
        applyTheme(newTheme, true); // isManual = true
        
        return false;
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
     * Toggle-Buttons initialisieren mit Event-Delegation
     */
    function initToggleButtons() {
        // Event-Delegation am document-Level für bessere Browser-Kompatibilität
        document.addEventListener('click', function(e) {
            // Prüfen ob das geklickte Element oder ein Parent der Toggle-Button ist
            const button = e.target.closest('.dark-mode-toggle');
            if (button) {
                toggleTheme(e);
            }
        }, true); // useCapture = true für bessere Kompatibilität
    }
    
    /**
     * System-Präferenz-Änderungen überwachen
     */
    function watchSystemPreference() {
        if (!window.matchMedia) return;
        
        const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
        
        // Nur reagieren wenn keine manuelle Präferenz gesetzt wurde
        const handleChange = function(e) {
            if (!localStorage.getItem(STORAGE_KEY)) {
                applyTheme(e.matches ? 'dark' : 'light', false); // isManual = false
            }
        };
        
        // Moderne Browser
        if (mediaQuery.addEventListener) {
            mediaQuery.addEventListener('change', handleChange);
        } else if (mediaQuery.addListener) {
            // Fallback für ältere Browser
            mediaQuery.addListener(handleChange);
        }
    }
    
    /**
     * Initialisierung
     */
    function init() {
        // Theme sofort anwenden (vor Page-Load für kein Flackern)
        const theme = getPreferredTheme();
        const hasManualPreference = localStorage.getItem(STORAGE_KEY) !== null;
        applyTheme(theme, hasManualPreference);
        
        // Nach DOM-Load Buttons initialisieren
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
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
