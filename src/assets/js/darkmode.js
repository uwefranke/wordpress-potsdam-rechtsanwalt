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
        const html = document.documentElement;
        
        if (theme === 'dark') {
            html.classList.add(DARK_CLASS);
            html.classList.remove('light-mode');
        } else {
            html.classList.remove(DARK_CLASS);
            html.classList.add('light-mode');
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
        applyTheme(newTheme);
        
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
                applyTheme(e.matches ? 'dark' : 'light');
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
        applyTheme(theme);
        
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
