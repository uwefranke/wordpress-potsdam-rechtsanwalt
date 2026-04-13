/**
 * Cookie Consent Banner
 * DSGVO-konform, einfach, Theme-Design
 */

(function() {
    'use strict';
    
    const CONSENT_COOKIE = 'potsdam-cookie-consent';
    const CONSENT_DURATION = 365; // Tage
    
    /**
     * Cookie setzen
     */
    function setCookie(name, value, days) {
        const date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        const expires = "expires=" + date.toUTCString();
        // Wichtig: Expliziten Path setzen und sicherstellen dass Cookie persistent ist
        document.cookie = name + "=" + value + ";" + expires + ";path=/;SameSite=Lax";
        
        // Debug: Prüfen ob Cookie gesetzt wurde
        console.log('[Cookie Consent] Cookie gesetzt:', name + '=' + value, 'Expires:', date.toUTCString());
        console.log('[Cookie Consent] Aktueller document.cookie:', document.cookie);
    }
    
    /**
     * Cookie auslesen
     */
    function getCookie(name) {
        const nameEQ = name + "=";
        const cookies = document.cookie.split(';');
        for (let i = 0; i < cookies.length; i++) {
            let c = cookies[i];
            while (c.charAt(0) === ' ') c = c.substring(1);
            if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }
    
    /**
     * Cookie-Banner anzeigen
     */
    function showCookieBanner(forceShow = false) {
        // Debug logging
        const currentCookie = getCookie(CONSENT_COOKIE);
        console.log('[Cookie Consent] showCookieBanner aufgerufen:', { forceShow, currentCookie, allCookies: document.cookie });
        
        // Prüfen ob bereits Zustimmung erteilt (außer wenn forceShow = true)
        if (!forceShow && currentCookie) {
            console.log('[Cookie Consent] Banner wird NICHT angezeigt (Cookie existiert)');
            return; // Banner nicht anzeigen
        }
        
        console.log('[Cookie Consent] Banner wird angezeigt');
        
        // Banner HTML erstellen
        const banner = document.createElement('div');
        banner.className = 'cookie-consent-banner';
        banner.innerHTML = `
            <div class="cookie-consent-content">
                <div class="cookie-consent-text">
                    <h3>🍪 Cookie-Hinweis</h3>
                    <p>
                        Diese Website verwendet ausschließlich <strong>technisch notwendige Cookies</strong> 
                        für die Kernfunktionen (Dark Mode, Session-Verwaltung). 
                        Es werden <strong>keine Tracking-Cookies</strong> gesetzt.
                    </p>
                    <p class="cookie-consent-small">
                        Weitere Informationen finden Sie in unserer 
                        <a href="/datenschutz">Datenschutzerklärung</a>.
                    </p>
                </div>
                <div class="cookie-consent-buttons">
                    <button class="cookie-btn cookie-btn-accept" id="cookieAccept">
                        ✓ Verstanden
                    </button>
                    <button class="cookie-btn cookie-btn-settings" id="cookieSettings">
                        Einstellungen
                    </button>
                </div>
            </div>
        `;
        
        document.body.appendChild(banner);
        
        // Event-Listener
        document.getElementById('cookieAccept').addEventListener('click', acceptCookies);
        document.getElementById('cookieSettings').addEventListener('click', showSettings);
        
        // Banner einblenden (Animation)
        setTimeout(() => banner.classList.add('show'), 100);
    }
    
    /**
     * Cookies akzeptieren
     */
    function acceptCookies() {
        console.log('[Cookie Consent] acceptCookies aufgerufen');
        setCookie(CONSENT_COOKIE, 'accepted', CONSENT_DURATION);
        hideBanner();
        console.log('[Cookie Consent] Banner versteckt, Cookie sollte gesetzt sein');
    }
    
    /**
     * Einstellungen anzeigen
     */
    function showSettings() {
        const banner = document.querySelector('.cookie-consent-banner');
        banner.innerHTML = `
            <div class="cookie-consent-content cookie-consent-settings">
                <div class="cookie-consent-text">
                    <h3>Cookie-Einstellungen</h3>
                    
                    <div class="cookie-category">
                        <div class="cookie-category-header">
                            <label>
                                <input type="checkbox" checked disabled>
                                <strong>Technisch notwendig</strong>
                                <span class="cookie-required">Erforderlich</span>
                            </label>
                        </div>
                        <p class="cookie-category-desc">
                            Diese Cookies sind für die Grundfunktionen der Website erforderlich:
                        </p>
                        <ul class="cookie-list">
                            <li><code>potsdam-theme-mode</code> - Dark Mode Einstellung (localStorage)</li>
                            <li><code>wordpress_*</code> - WordPress Session (nur wenn eingeloggt)</li>
                            <li><code>potsdam-cookie-consent</code> - Diese Cookie-Zustimmung</li>
                        </ul>
                    </div>
                    
                    <div class="cookie-category cookie-category-disabled">
                        <div class="cookie-category-header">
                            <label>
                                <input type="checkbox" disabled>
                                <strong>Analytics & Tracking</strong>
                                <span class="cookie-inactive">Nicht aktiv</span>
                            </label>
                        </div>
                        <p class="cookie-category-desc">
                            Diese Website verwendet <strong>keine</strong> Analytics- oder Tracking-Cookies.
                        </p>
                    </div>
                    
                    <p class="cookie-consent-small">
                        Weitere Details in der <a href="/datenschutz">Datenschutzerklärung</a>.
                    </p>
                </div>
                <div class="cookie-consent-buttons">
                    <button class="cookie-btn cookie-btn-accept" id="cookieAcceptSettings">
                        ✓ Speichern
                    </button>
                    <button class="cookie-btn cookie-btn-back" id="cookieBack">
                        ← Zurück
                    </button>
                </div>
            </div>
        `;
        
        document.getElementById('cookieAcceptSettings').addEventListener('click', acceptCookies);
        document.getElementById('cookieBack').addEventListener('click', () => {
            // Eventuell vorhandenes Banner entfernen
            const existingBanner = document.querySelector('.cookie-consent-banner');
            if (existingBanner) {
                existingBanner.remove();
            }
            // Banner erneut anzeigen mit forceShow, da wir aus den Einstellungen zurückkommen
            showCookieBanner(true);
        });
    }
    
    /**
     * Banner ausblenden
     */
    function hideBanner() {
        const banner = document.querySelector('.cookie-consent-banner');
        if (banner) {
            banner.classList.remove('show');
            setTimeout(() => banner.remove(), 300);
        }
    }
    
    // Banner beim Laden anzeigen
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', showCookieBanner);
    } else {
        showCookieBanner();
    }
    
    // Globale Funktion für manuelles Öffnen der Cookie-Einstellungen
    window.openCookieSettings = function() {
        // Eventuell vorhandenen Banner entfernen
        const existingBanner = document.querySelector('.cookie-consent-banner');
        if (existingBanner) {
            existingBanner.remove();
        }
        
        // Direkt Einstellungen anzeigen (forceShow = true, damit Banner auch bei bestehendem Cookie erscheint)
        showCookieBanner(true);
        setTimeout(() => {
            const settingsBtn = document.getElementById('cookieSettings');
            if (settingsBtn) {
                settingsBtn.click();
            }
        }, 200);
    };
    
    // Event-Listener für alle .open-cookie-settings Links
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('open-cookie-settings') || 
            e.target.closest('.open-cookie-settings')) {
            e.preventDefault();
            window.openCookieSettings();
        }
    }, true);
    
})();
