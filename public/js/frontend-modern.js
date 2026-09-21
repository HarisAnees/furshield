/**
 * FurShield — Modern Minimalist Editorial Frontend Behavior
 * Vanilla JS: Mobile Navigation, Scroll Reveals, Back to Top
 * Preserves 100% of Blade / Backend functionality
 */

document.addEventListener('DOMContentLoaded', () => {
    // 1. Navigation Sticky Scroll State
    const navbar = document.querySelector('.fe-navbar');
    if (navbar) {
        const handleScroll = () => {
            if (window.scrollY > 20) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        };
        window.addEventListener('scroll', handleScroll, { passive: true });
        handleScroll();
    }

    // 2. Mobile Menu Drawer
    const menuBtn = document.getElementById('feMenuBtn');
    const closeBtn = document.getElementById('feCloseMenu');
    const mobileMenu = document.getElementById('feMobileMenu');
    const backdrop = document.getElementById('feMobileBackdrop');

    const openMenu = () => {
        if (mobileMenu && backdrop) {
            mobileMenu.classList.add('open');
            backdrop.classList.add('open');
            document.body.style.overflow = 'hidden';
            if (menuBtn) menuBtn.setAttribute('aria-expanded', 'true');
        }
    };

    const closeMenu = () => {
        if (mobileMenu && backdrop) {
            mobileMenu.classList.remove('open');
            backdrop.classList.remove('open');
            document.body.style.overflow = '';
            if (menuBtn) menuBtn.setAttribute('aria-expanded', 'false');
        }
    };
    window.closeFurShieldMobileMenu = closeMenu;

    if (menuBtn) menuBtn.addEventListener('click', openMenu);
    if (closeBtn) closeBtn.addEventListener('click', closeMenu);
    if (backdrop) backdrop.addEventListener('click', closeMenu);

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && mobileMenu && mobileMenu.classList.contains('open')) {
            closeMenu();
        }
    });

    // 3. Scroll Reveal Observer (IntersectionObserver)
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const revealElements = document.querySelectorAll('.reveal');

    if (!prefersReducedMotion && 'IntersectionObserver' in window && revealElements.length > 0) {
        const revealObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('in-view');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -40px 0px'
        });

        revealElements.forEach(el => revealObserver.observe(el));
    } else {
        // If reduced motion is preferred or observer unsupported, show elements immediately
        revealElements.forEach(el => el.classList.add('in-view'));
    }

    // 4. Back to Top Button
    const backToTopBtn = document.getElementById('feBackTop');
    if (backToTopBtn) {
        backToTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // 5. Magnetic Glow Product Cards Interaction (Section 03 Store)
    const glowCards = document.querySelectorAll('.glow-card');
    const glowControls = document.querySelectorAll('.magnetic-glow-demo .control-btn');
    const demoContainers = document.querySelectorAll('.magnetic-glow-demo');

    glowCards.forEach((card) => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const xPercent = Math.max(0, Math.min(100, (x / rect.width) * 100));
            const yPercent = Math.max(0, Math.min(100, (y / rect.height) * 100));

            const glowEffect = card.querySelector('.glow-effect');
            if (glowEffect) {
                glowEffect.style.setProperty('--x', `${xPercent}%`);
                glowEffect.style.setProperty('--y', `${yPercent}%`);
            }
        });
    });

    glowControls.forEach((btn) => {
        btn.addEventListener('click', () => {
            glowControls.forEach((b) => b.classList.remove('active'));
            btn.classList.add('active');

            const effectType = btn.getAttribute('data-effect');
            demoContainers.forEach((container) => {
                container.classList.remove('magnetic-glow', 'outline-glow', 'pulse-glow');
                container.classList.add(`${effectType}-glow`);
            });
        });
    });

    // 6. Folding Pet Directory Cards (Interactive Drawer Toggle)
    const petFoldCards = document.querySelectorAll('.pet-fold-card');

    petFoldCards.forEach((card) => {
        const toggleBtn = card.querySelector('.fold-card-toggle');
        const petAvatar = card.querySelector('header figure img');
        const mainContent = card.querySelector('main');
        const toggleIcon = card.querySelector('.fold-card-toggle i');
        const toggleSpan = card.querySelector('.fold-card-toggle span');

        function toggleFold(e) {
            if (e) {
                e.preventDefault();
                e.stopPropagation();
            }
            if (!mainContent) return;

            const isVisible = mainContent.classList.contains('visible');
            if (isVisible) {
                mainContent.classList.remove('visible');
                card.classList.remove('expanded');
                if (toggleSpan) toggleSpan.textContent = 'More';
                if (toggleIcon) {
                    toggleIcon.classList.remove('fa-times');
                    toggleIcon.classList.add('fa-bars');
                }
            } else {
                // Ensure only one card expands at a time (accordion mode)
                petFoldCards.forEach((otherCard) => {
                    if (otherCard !== card && otherCard.classList.contains('expanded')) {
                        const otherMain = otherCard.querySelector('main');
                        const otherSpan = otherCard.querySelector('.fold-card-toggle span');
                        const otherIcon = otherCard.querySelector('.fold-card-toggle i');
                        otherCard.classList.remove('expanded');
                        if (otherMain) otherMain.classList.remove('visible');
                        if (otherSpan) otherSpan.textContent = 'More';
                        if (otherIcon) {
                            otherIcon.classList.remove('fa-times');
                            otherIcon.classList.add('fa-bars');
                        }
                    }
                });

                mainContent.classList.add('visible');
                card.classList.add('expanded');
                if (toggleSpan) toggleSpan.textContent = 'Less';
                if (toggleIcon) {
                    toggleIcon.classList.remove('fa-bars');
                    toggleIcon.classList.add('fa-times');
                }
            }

            if (typeof ScrollTrigger !== 'undefined') {
                setTimeout(() => ScrollTrigger.refresh(), 390);
            }
        }

        if (toggleBtn) {
            toggleBtn.addEventListener('click', toggleFold);
        }
        if (petAvatar) {
            petAvatar.addEventListener('click', toggleFold);
        }
    });

    // 7. Parallax Product Essentials Cards (Multi-plane depth effect)
    const parallaxCards = document.querySelectorAll('.fe-parallax-product-card');

    if (parallaxCards.length > 0) {
        parallaxCards.forEach((card) => {
            card.addEventListener('mousemove', (e) => {
                const rect = card.getBoundingClientRect();
                const xNorm = Math.max(-1, Math.min(1, ((e.clientX - rect.left) / rect.width - 0.5) * 2));
                const yNorm = Math.max(-1, Math.min(1, ((e.clientY - rect.top) / rect.height - 0.5) * 2));

                card.style.setProperty('--x', xNorm);
                card.style.setProperty('--y', yNorm);
            });

            card.addEventListener('mouseleave', () => {
                card.style.setProperty('--x', 0);
                card.style.setProperty('--y', 0);
            });
        });

        const handleOrientation = (e) => {
            const beta = e.beta || 0;
            const gamma = e.gamma || 0;
            const isLandscape = window.matchMedia('(orientation: landscape)').matches;
            const xVal = Math.max(-1, Math.min(1, isLandscape ? beta / 45 : gamma / 45));
            const yVal = Math.max(-1, Math.min(1, isLandscape ? Math.abs(gamma) / 45 : beta / 45));

            parallaxCards.forEach((card) => {
                card.style.setProperty('--x', xVal);
                card.style.setProperty('--y', yVal);
            });
        };

        if (window.DeviceOrientationEvent) {
            window.addEventListener('deviceorientation', handleOrientation);
        }
    }

    // 8. GSAP ScrollTrigger Movie Stacking Cards (/care-tips)
    if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
        gsap.registerPlugin(ScrollTrigger);

        const stackContainer = document.querySelector('.care-poster-stack');
        const careCards = gsap.utils.toArray('.care-poster-card-wrapper');

        if (stackContainer && careCards.length > 0) {
            let mm = gsap.matchMedia();

            // Desktop & Laptops: Smooth scrubbed stacking with progressive scale, dimming & lift
            mm.add("(min-width: 769px)", () => {
                careCards.forEach((card, index) => {
                    const cardInner = card.querySelector('.care-poster-card-contents');
                    card.style.zIndex = index + 1;

                    // As subsequent cards scroll up over this card, scale down and subtly dim
                    if (index < careCards.length - 1 && cardInner) {
                        const nextCard = careCards[index + 1];

                        gsap.to(cardInner, {
                            scale: Math.max(0.88, 0.94 - (index * 0.015)),
                            filter: 'brightness(0.72)',
                            y: -12,
                            ease: 'power1.out',
                            scrollTrigger: {
                                id: 'care-card-stack-' + index,
                                trigger: nextCard,
                                start: 'top 80%',
                                end: 'top 24%',
                                scrub: 0.35,
                                invalidateOnRefresh: true
                            }
                        });
                    }
                });
            });

            // Mobile viewports (<= 768px): clean sequential scroll reveal
            mm.add("(max-width: 768px)", () => {
                careCards.forEach((card, index) => {
                    const cardInner = card.querySelector('.care-poster-card-contents');
                    if (cardInner) {
                        gsap.fromTo(cardInner,
                            { y: 32, opacity: 0.88 },
                            {
                                y: 0,
                                opacity: 1,
                                duration: 0.55,
                                ease: 'power2.out',
                                scrollTrigger: {
                                    id: 'care-card-mob-' + index,
                                    trigger: card,
                                    start: 'top 88%',
                                    toggleActions: 'play none none reverse'
                                }
                            }
                        );
                    }
                });
            });

            // Refresh ScrollTrigger calculations after initial paint and asset loads
            window.addEventListener('load', () => {
                ScrollTrigger.refresh();
            });
            setTimeout(() => {
                ScrollTrigger.refresh();
            }, 250);
        }
    }

    // 9. 3D Swap Stacked Cards Hero (/appointments)
    const heroStack = document.querySelector('.appointments-stack-wrap .stack') || document.querySelector('.stack');
    if (heroStack) {
        const stackCards = Array.from(heroStack.children)
            .reverse()
            .filter((child) => child.classList.contains('card'));

        stackCards.forEach((card) => heroStack.appendChild(card));

        let isSwapping = false;

        const moveCard = () => {
            if (isSwapping) return;
            const lastCard = heroStack.lastElementChild;
            if (lastCard && lastCard.classList.contains('card')) {
                isSwapping = true;
                lastCard.classList.add('swap');

                setTimeout(() => {
                    lastCard.classList.remove('swap');
                    heroStack.insertBefore(lastCard, heroStack.firstElementChild);
                    isSwapping = false;
                }, 1200);
            }
        };

        let autoplayInterval = setInterval(moveCard, 4000);

        heroStack.addEventListener('click', (e) => {
            const card = e.target.closest('.card');
            if (card && card === heroStack.lastElementChild && !isSwapping) {
                clearInterval(autoplayInterval);
                moveCard();
                autoplayInterval = setInterval(moveCard, 4000);
            }
        });

        heroStack.addEventListener('mouseenter', () => {
            clearInterval(autoplayInterval);
        });

        heroStack.addEventListener('mouseleave', () => {
            clearInterval(autoplayInterval);
            autoplayInterval = setInterval(moveCard, 4000);
        });
    }

    // 10. Swiper Cards Hero (/about)
    const initAboutSwiper = () => {
        const aboutSwiperEl = document.querySelector('.about-hero-swiper');
        if (aboutSwiperEl && typeof Swiper !== 'undefined') {
            new Swiper(aboutSwiperEl, {
                effect: 'cards',
                cardsEffect: {
                    rotate: true,
                    perSlideRotate: 4,
                    perSlideOffset: 12,
                    slideShadows: true,
                },
                grabCursor: true,
                initialSlide: 2,
                speed: 600,
                loop: true,
                autoplay: {
                    delay: 3500,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                },
                mousewheel: {
                    invert: false,
                },
            });
        }
    };

    if (typeof Swiper !== 'undefined') {
        initAboutSwiper();
    } else {
        window.addEventListener('load', initAboutSwiper);
    }

    // 11. Cinematic Masked Video Hero Loader (Home Page 8-10s Intro)
    const initCinematicLoader = () => {
        const loader = document.getElementById('cinematicLoader');
        if (!loader) {
            document.body.classList.remove('cinematic-active');
            return;
        }

        // Ensure body is marked active and scroll locked
        document.body.classList.add('cinematic-active');
        document.body.style.overflow = 'hidden';

        // Play videos reliably
        const videos = loader.querySelectorAll('video');
        videos.forEach(vid => {
            vid.muted = true;
            vid.play().catch(() => {});
        });

        // Split text letters into spans for 3D kinetic stagger
        const splitText = (el) => {
            if (!el) return;
            const text = el.textContent.trim();
            el.innerHTML = '';
            for (let i = 0; i < text.length; i++) {
                const char = text[i];
                const span = document.createElement('span');
                span.innerHTML = char === ' ' ? '&nbsp;' : char;
                el.appendChild(span);
            }
        };

        const mainTitle = document.getElementById('cinematicMainTitle');
        const strokeTitle = document.getElementById('cinematicStrokeTitle');
        splitText(mainTitle);
        splitText(strokeTitle);

        // Magnetic Cursor Tracking
        const cursor = document.getElementById('cinematicCursor');
        const onMouseMove = (e) => {
            if (cursor && typeof gsap !== 'undefined') {
                gsap.to(cursor, {
                    x: e.clientX,
                    y: e.clientY,
                    duration: 0.12,
                    ease: 'power2.out'
                });
            }
        };
        window.addEventListener('mousemove', onMouseMove);

        // Rapid Font Cycling on "Loading" Text
        const introText = document.getElementById('cinematicIntroText');
        const introFonts = [
            'Alkatra', 'Bebas Neue', 'Jost', 'Lexend', 
            'Nova Oval', 'Oswald', 'PT Serif', 'Titillium Web', 'Poppins'
        ];
        let fontIndex = 0;
        let fontInterval = null;
        if (introText) {
            fontInterval = setInterval(() => {
                introText.style.fontFamily = `"${introFonts[fontIndex % introFonts.length]}", sans-serif`;
                fontIndex++;
            }, 80);
        }

        // Countdown timer: 8s to 0s
        let remainingSeconds = 8;
        const countdownEl = document.getElementById('cinematicTimerCountdown');
        const countdownInterval = setInterval(() => {
            remainingSeconds--;
            if (countdownEl) {
                countdownEl.textContent = `${Math.max(0, remainingSeconds)}s`;
            }
            if (remainingSeconds <= 0) {
                clearInterval(countdownInterval);
            }
        }, 1000);

        // Exit / Dismiss animation
        let isExiting = false;
        const dismissLoader = () => {
            if (isExiting) return;
            isExiting = true;
            clearInterval(fontInterval);
            clearInterval(countdownInterval);
            window.removeEventListener('mousemove', onMouseMove);

            // Cleanly restore body scroll and reveal site shell & navbar
            document.body.classList.remove('cinematic-active');
            document.body.style.overflow = '';

            if (typeof gsap !== 'undefined') {
                gsap.to(loader, {
                    opacity: 0,
                    scale: 1.05,
                    duration: 0.9,
                    ease: 'power2.inOut',
                    onComplete: () => {
                        loader.style.display = 'none';
                        loader.remove();
                        // Refresh ScrollTrigger after loader unmounts
                        if (typeof ScrollTrigger !== 'undefined') {
                            ScrollTrigger.refresh();
                        }
                    }
                });
            } else {
                loader.style.transition = 'opacity 0.6s ease';
                loader.style.opacity = '0';
                setTimeout(() => {
                    loader.remove();
                }, 650);
            }
        };

        // Skip Button Click Event
        const skipBtn = document.getElementById('cinematicSkipBtn');
        if (skipBtn) {
            skipBtn.addEventListener('click', (e) => {
                e.preventDefault();
                dismissLoader();
            });
        }

        // GSAP Choreography Timeline
        if (typeof gsap !== 'undefined') {
            const tl = gsap.timeline({ defaults: { ease: 'power3.out' } });

            // 1. Initial Loading text font morphing for 0.8s
            // 2. Emerald curtain wipes across Loading screen
            tl.to('.cinematic-intro__emerald', {
                clipPath: 'polygon(0 0, 100% 0, 100% 100%, 0 100%)',
                duration: 0.55,
                ease: 'power3.inOut',
                delay: 0.85
            })
            // Stop font cycle once curtain closes
            .add(() => {
                clearInterval(fontInterval);
            })
            // 3. Intro curtain sweeps up to reveal masked hero video
            .to('.cinematic-intro', {
                yPercent: -100,
                duration: 0.85,
                ease: 'power4.inOut'
            }, '+=0.2')
            // 4. Central Masked Video figure pops & scales smoothly
            .fromTo('#cinematicFigure', 
                { scale: 0.72, opacity: 0, rotate: -2 }, 
                { scale: 1, opacity: 1, rotate: 0, duration: 1.3, ease: 'expo.out' }, 
                '-=0.5'
            )
            // 5. Kinetic Typography letter stagger (sandwiching the video)
            .to(['#cinematicMainTitle span', '#cinematicStrokeTitle span'], {
                y: '0%',
                duration: 0.85,
                stagger: 0.032,
                ease: 'power3.out'
            }, '-=0.9')
            // 6. Subtitle and Ambient Background
            .fromTo('.cinematic-clip__inner p', 
                { opacity: 0, y: 15 }, 
                { opacity: 1, y: 0, duration: 0.7 }, 
                '-=0.4'
            )
            // 7. Subtle floating pulse of the central masked video figure
            .to('#cinematicFigure', {
                scale: 1.03,
                duration: 3.2,
                repeat: 1,
                yoyo: true,
                ease: 'sine.inOut'
            }, '+=0.1');

            // Auto dismiss at ~8.5s - 9.0s
            setTimeout(() => {
                dismissLoader();
            }, 8800);
        } else {
            // Fallback timeout without GSAP
            setTimeout(() => {
                dismissLoader();
            }, 8800);
        }
    };

    initCinematicLoader();

    // ==========================================================================
    // 17. Sticky Reveal Footer (Curtain Effect & Dynamic Height Sync)
    // ==========================================================================
    const initStickyFooter = () => {
        const footer = document.getElementById('feStickyFooter');
        if (!footer) return;

        const inner = footer.querySelector('.fe-sticky-footer-inner');
        const syncHeight = () => {
            if (!inner) return;
            const contentHeight = inner.scrollHeight;
            const minH = window.innerWidth < 768 ? 680 : 540;
            const targetHeight = Math.max(contentHeight, minH);
            footer.style.setProperty('--sticky-footer-height', `${targetHeight}px`);
        };

        syncHeight();
        window.addEventListener('resize', syncHeight);

        // IntersectionObserver for Animated Container Motion (Blur & Translate)
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        footer.classList.add('in-view');
                    }
                });
            }, {
                threshold: 0.05
            });
            observer.observe(footer);
        } else {
            footer.classList.add('in-view');
        }
    };

    initStickyFooter();

    // ==========================================================================
    // 18. Global Cart Authentication Interceptor & Modal
    // ==========================================================================
    window.openAuthCartModal = function(options) {
        const modal = document.getElementById('authRequiredCartModal');
        if (!modal) return;

        options = options || {};
        const mode = options.mode || 'view'; // 'view' or 'add'
        const customRedirect = options.redirect || (mode === 'view' ? (window.FurShieldCartUrl || '/cart') : window.location.href);
        const returnUrl = encodeURIComponent(customRedirect);

        const titleEl = document.getElementById('authModalTitle');
        const descEl = document.getElementById('authModalDesc');
        const badgeEl = document.getElementById('authModalBadgeText');
        const loginBtn = document.getElementById('authModalLoginBtn');
        const registerBtn = document.getElementById('authModalRegisterBtn');

        if (mode === 'add') {
            if (titleEl) titleEl.textContent = "Sign In to Add to Cart";
            if (descEl) descEl.textContent = "Please sign in to your FurShield account to add clinical pet care items to your shopping cart, access order tracking, and manage wellness deliveries.";
            if (badgeEl) badgeEl.textContent = "AUTHENTICATION REQUIRED";
        } else {
            if (titleEl) titleEl.textContent = "Sign In to Access Your Cart";
            if (descEl) descEl.textContent = "Please sign in to your FurShield account to access your companion's cart, review prescription refills, and proceed to clinical checkout.";
            if (badgeEl) badgeEl.textContent = "CART ACCESS REQUIRED";
        }

        if (loginBtn && window.FurShieldLoginUrl) {
            loginBtn.href = window.FurShieldLoginUrl + '?redirect=' + returnUrl;
        }
        if (registerBtn && window.FurShieldRegisterUrl) {
            registerBtn.href = window.FurShieldRegisterUrl + '?redirect=' + returnUrl;
        }

        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };

    window.closeAuthCartModal = function() {
        const modal = document.getElementById('authRequiredCartModal');
        if (!modal) return;
        modal.style.display = 'none';
        document.body.style.overflow = '';
    };

    // Intercept clicks on cart icons/links or add-to-cart buttons when user is logged out
    document.addEventListener('click', function(e) {
        const target = e.target;
        if (!target) return;

        const isLoggedOut = (window.FurShieldAuth === false || window.FurShieldAuth === 'false');
        if (!isLoggedOut) return;

        // 1. Add to Cart buttons
        const addToCartBtn = target.closest('.fe-parallax-cart-btn, .card-btn.primary, [data-action="add-to-cart"]');
        if (addToCartBtn) {
            e.preventDefault();
            e.stopPropagation();
            window.openAuthCartModal({ mode: 'add', redirect: window.location.href });
            return false;
        }

        // 2. Navbar Cart button, Mobile Drawer Cart link, or any link targeting cart
        const cartLink = target.closest('.fe-mugsy-cart-btn, .fe-mobile-cart-link, [data-auth-cart], a[href*="/cart"]');
        if (cartLink) {
            const href = cartLink.getAttribute('href') || '';
            // Do not intercept if it's a remove or quantity change form
            if (!href.includes('/cart/remove') && !href.includes('/cart/update')) {
                e.preventDefault();
                e.stopPropagation();

                // Close mobile drawer if currently open
                if (typeof window.closeFurShieldMobileMenu === 'function') {
                    window.closeFurShieldMobileMenu();
                }

                window.openAuthCartModal({
                    mode: 'view',
                    redirect: window.FurShieldCartUrl || '/cart'
                });
                return false;
            }
        }
    }, true);

    // Intercept form submissions targeting cart.add when logged out
    document.addEventListener('submit', function(e) {
        const form = e.target;
        if (form && (form.classList.contains('fe-parallax-cart-form') || form.classList.contains('card-actions') || (form.action && form.action.includes('/cart/add/')))) {
            if (window.FurShieldAuth === false || window.FurShieldAuth === 'false') {
                e.preventDefault();
                e.stopPropagation();
                window.openAuthCartModal({ mode: 'add', redirect: window.location.href });
                return false;
            }
        }
    }, true);

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('authRequiredCartModal');
            if (modal && modal.style.display === 'flex') {
                window.closeAuthCartModal();
            }
        }
    });
});
