/**
 * Main JavaScript für Potsdam Rechtsanwalt Theme
 */

(function($) {
    'use strict';
    
    // DOM Ready
    $(document).ready(function() {
        
        // Mobile Navigation Toggle
        $('.menu-toggle').on('click', function() {
            var nav = $('.main-navigation');
            var isOpen = $(this).attr('aria-expanded') === 'true';
            
            $(this).attr('aria-expanded', !isOpen);
            nav.toggleClass('is-open');
            $('body').toggleClass('menu-open');
        });
        
        // Menü schließen beim Klick auf einen Link
        $('.main-navigation a').on('click', function() {
            if ($(window).width() <= 768) {
                $('.main-navigation').removeClass('is-open');
                $('.menu-toggle').attr('aria-expanded', 'false');
                $('body').removeClass('menu-open');
            }
        });
        
        // Menü schließen bei ESC-Taste
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && $('.main-navigation').hasClass('is-open')) {
                $('.main-navigation').removeClass('is-open');
                $('.menu-toggle').attr('aria-expanded', 'false');
                $('body').removeClass('menu-open');
            }
        });
        
        // Smooth Scrolling für Anker-Links
        $('a[href*="#"]').not('[href="#"]').not('[href="#0"]').click(function(event) {
            if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && 
                location.hostname === this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                
                if (target.length) {
                    event.preventDefault();
                    $('html, body').animate({
                        scrollTop: target.offset().top - 100
                    }, 800);
                }
            }
        });
        
        // Service Cards Hover-Effekt
        $('.service-card').hover(
            function() {
                $(this).addClass('hover');
            },
            function() {
                $(this).removeClass('hover');
            }
        );
        
        // Formular-Validierung
        $('.contact-form').on('submit', function(e) {
            var isValid = true;
            var form = $(this);
            
            // Pflichtfelder prüfen
            form.find('[required]').each(function() {
                if ($(this).val().trim() === '') {
                    isValid = false;
                    $(this).addClass('error');
                } else {
                    $(this).removeClass('error');
                }
            });
            
            // E-Mail-Format prüfen
            var emailInput = form.find('input[type="email"]');
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (emailInput.length && !emailPattern.test(emailInput.val())) {
                isValid = false;
                emailInput.addClass('error');
            }
            
            if (!isValid) {
                e.preventDefault();
                alert('Bitte füllen Sie alle Pflichtfelder korrekt aus.');
            }
        });
        
        // Fehler-Styling bei Eingabe entfernen
        $('.contact-form input, .contact-form textarea, .contact-form select').on('input change', function() {
            $(this).removeClass('error');
        });
        
        // Scroll to Top Button (angepasst für paginierte Seiten)
        var isPaged = $('body').hasClass('paged-view');
        var scrollTopButton;
        if (isPaged) {
            // Stil wie Dark-Mode-Toggle (runde Form, Icon, gleiche Klasse)
            scrollTopButton = '<button class="scroll-to-top scroll-to-top--toggle dark-mode-toggle" aria-label="Nach oben scrollen"><span class="toggle-icon">↑</span></button>';
        } else {
            scrollTopButton = '<button class="scroll-to-top" aria-label="Nach oben scrollen">↑</button>';
        }
        $('body').append(scrollTopButton);

        $(window).scroll(function() {
            if ($(this).scrollTop() > 300) {
                $('.scroll-to-top').fadeIn();
            } else {
                $('.scroll-to-top').fadeOut();
            }
        });

        $('.scroll-to-top').on('click', function() {
            $('html, body').animate({
                scrollTop: 0
            }, 600);
            return false;
        });
        
        // Hero Parallax-Effekt (leicht)
        $(window).scroll(function() {
            var scrolled = $(window).scrollTop();
            $('.hero-section').css('background-position', 'center ' + (scrolled * 0.5) + 'px');
        });
        
        // Animation bei Scroll (Service Cards)
        function checkServiceCards() {
            $('.service-card').each(function() {
                var elementTop = $(this).offset().top;
                var elementBottom = elementTop + $(this).outerHeight();
                var viewportTop = $(window).scrollTop();
                var viewportBottom = viewportTop + $(window).height();
                
                if (elementBottom > viewportTop && elementTop < viewportBottom) {
                    $(this).addClass('fade-in');
                }
            });
        }
        
        $(window).on('scroll resize', checkServiceCards);
        checkServiceCards(); // Initial check
        
    });
    
})(jQuery);
