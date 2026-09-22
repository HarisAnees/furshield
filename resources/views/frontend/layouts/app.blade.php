<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FurShield — @yield('title', 'Pet Care & Clinical Intelligence')</title>

    <!-- FurShield Official Brand Favicons & App Icons -->
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <meta name="apple-mobile-web-app-title" content="FurShield">
    <link rel="manifest" href="/site.webmanifest">

    <!-- Google Fonts: Anton (Display), Manrope (Sans), DM Mono (Monospace), Playfair Display (Editorial Italic) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=DM+Mono:wght@400;500&family=Manrope:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@1,400;1,600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Alkatra&family=Bebas+Neue&family=Jost:ital,wght@1,600&family=Lexend:wght@700&family=Nova+Oval&family=Oswald:wght@500&family=PT+Serif:wght@700&family=Titillium+Web&family=Poppins:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Design System Stylesheet -->
    <link rel="stylesheet" href="/css/frontend-modern.css?v=2.6">

    <!-- Swiper Slider Bundle (Cards Effect) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
</head>
<body class="{{ request()->routeIs('home') ? 'cinematic-active' : '' }}">

@yield('cinematic_loader')

<div class="grain" aria-hidden="true"></div>

<div class="fe-site-shell">
    <!-- Top Portal Switcher Bar -->
    <div class="fe-portal-bar">
        <div class="fe-portal-bar-left">
            <span class="fe-portal-tag">FURSHIELD:</span>
            <a href="{{ route('home') }}" class="fe-portal-link {{ request()->routeIs('home') ? 'active' : '' }}">
                ● Public Site
            </a>
            @auth
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="fe-portal-link {{ request()->is('admin*') ? 'active' : '' }}" style="color: #10b981; font-weight: 700;">
                        <span class="fe-portal-label-full"><i class="fa-solid fa-shield-halved" style="margin-right: 4px;"></i> Platform Admin Panel</span>
                        <span class="fe-portal-label-short"><i class="fa-solid fa-shield-halved"></i> Admin</span>
                    </a>
                @elseif(Auth::user()->role === 'vet')
                    <a href="{{ route('vet.dashboard') }}" class="fe-portal-link {{ request()->is('vet*') ? 'active' : '' }}" style="color: #10b981; font-weight: 700;">
                        <span class="fe-portal-label-full"><i class="fa-solid fa-stethoscope" style="margin-right: 4px;"></i> Clinician Portal</span>
                        <span class="fe-portal-label-short"><i class="fa-solid fa-stethoscope"></i> Vet</span>
                    </a>
                @elseif(Auth::user()->role === 'shelter')
                    <a href="{{ route('shelter.dashboard') }}" class="fe-portal-link {{ request()->is('shelter*') ? 'active' : '' }}" style="color: #10b981; font-weight: 700;">
                        <span class="fe-portal-label-full"><i class="fa-solid fa-house-chimney-medical" style="margin-right: 4px;"></i> Shelter Portal</span>
                        <span class="fe-portal-label-short"><i class="fa-solid fa-house-chimney-medical"></i> Shelter</span>
                    </a>
                @else
                    <a href="{{ route('owner.dashboard') }}" class="fe-portal-link {{ request()->is('owner*') ? 'active' : '' }}" style="color: #10b981; font-weight: 700;">
                        <span class="fe-portal-label-full"><i class="fa-solid fa-paw" style="margin-right: 4px;"></i> Pet Owner Portal</span>
                        <span class="fe-portal-label-short"><i class="fa-solid fa-paw"></i> Owner</span>
                    </a>
                @endif
            @else
                <span class="fe-portal-link fe-portal-desc" style="color: rgba(255,255,255,0.55); pointer-events: none;">
                    Clinical Care • Vet Network • Shelter Adoption Sanctuary
                </span>
            @endauth
        </div>
        <div class="fe-portal-bar-right" style="display: flex; align-items: center; gap: 16px;">
            <a href="tel:+15550199738" class="fe-portal-emergency" title="24/7 Emergency Hospital Dispatch">
                <span class="fe-emergency-icon"><i class="fa-solid fa-truck-medical"></i></span>
                <span class="fe-emergency-label">Emergency Care:</span>
                <strong>+1 (555) 0199-PETS</strong>
            </a>
            @auth
                <div class="fe-portal-auth-status" style="display: flex; align-items: center; gap: 8px; font-size: 11px; font-family: var(--font-mono, monospace);">
                    <span class="fe-portal-role-badge">
                        {{ Auth::user()->role }}
                    </span>
                    <span class="fe-portal-username">{{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline; margin: 0; padding: 0;">
                        @csrf
                        <button type="submit" class="fe-portal-signout-btn">Sign Out</button>
                    </form>
                </div>
            @endauth
        </div>
    </div>

    <!-- Main Navigation (Mugsy Architectural Layout) -->
    <header class="fe-navbar-wrapper">
        <nav class="fe-mugsy-nav-shell" aria-label="Primary navigation">
            <!-- Left Brand Notch Tab -->
            <a href="{{ route('home') }}" class="fe-mugsy-brand" aria-label="FurShield Home">
                <div class="fe-mugsy-brand-badge">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <ellipse cx="12" cy="15" rx="3.5" ry="2.8" fill="#090909"/>
                        <circle cx="7.8" cy="9.8" r="1.8" fill="#090909"/>
                        <circle cx="10.8" cy="7.2" r="1.8" fill="#090909"/>
                        <circle cx="13.2" cy="7.2" r="1.8" fill="#090909"/>
                        <circle cx="16.2" cy="9.8" r="1.8" fill="#090909"/>
                    </svg>
                </div>
                <span class="fe-mugsy-brand-text font-anton">FURSHIELD</span>
            </a>

            <!-- Right Deck Tab -->
            <div class="fe-mugsy-nav-deck">
                <!-- Desktop Menu -->
                <ul class="fe-mugsy-nav-links" role="menubar">
                    <li role="none"><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}" role="menuitem">Home</a></li>
                    <li role="none"><a href="{{ route('pets.index') }}" class="{{ request()->routeIs('pets.*') ? 'active' : '' }}" role="menuitem">Pets</a></li>
                    <li role="none"><a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}" role="menuitem">Products</a></li>
                    <li role="none"><a href="{{ route('appointments.index') }}" class="{{ request()->routeIs('appointments.*') ? 'active' : '' }}" role="menuitem">Appointments</a></li>
                    <li role="none"><a href="{{ route('care-tips.index') }}" class="{{ request()->routeIs('care-tips.*') ? 'active' : '' }}" role="menuitem">Care Tips</a></li>
                    <li role="none"><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}" role="menuitem">About</a></li>
                    <li role="none"><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}" role="menuitem">Contact</a></li>
                </ul>

                <!-- Actions -->
                <div class="fe-mugsy-nav-actions">
                    <a href="{{ route('cart.index') }}" class="fe-mugsy-cart-btn" title="Shopping Cart" aria-label="Shopping Cart" data-auth-cart="view" onclick="if(!window.FurShieldAuth){event.preventDefault();event.stopPropagation();window.openAuthCartModal({mode:'view',redirect:'{{ route('cart.index') }}'});return false;}">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                        @php $cartCount = count(session('cart', [])); @endphp
                        @if($cartCount > 0)
                            <span class="fe-cart-badge">{{ $cartCount }}</span>
                        @endif
                    </a>

                    @auth
                        @php
                            $targetPortal = match(Auth::user()->role) {
                                'admin' => route('admin.dashboard'),
                                'vet' => route('vet.dashboard'),
                                'shelter' => route('shelter.dashboard'),
                                default => route('owner.dashboard'),
                            };
                            $targetLabel = match(Auth::user()->role) {
                                'admin' => 'Admin Panel',
                                'vet' => 'Clinician Portal',
                                'shelter' => 'Shelter Portal',
                                default => 'Pet Portal',
                            };
                        @endphp
                        <a href="{{ $targetPortal }}" class="fe-mugsy-btn fe-mugsy-nav-pill">
                            <div class="fe-mugsy-btn-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                    <polyline points="12 5 19 12 12 19"></polyline>
                                </svg>
                            </div>
                            <span class="fe-mugsy-btn-text">{{ $targetLabel }}</span>
                        </a>

                        <form action="{{ route('logout') }}" method="POST" class="fe-mugsy-logout-form" style="display: inline; margin: 0;">
                            @csrf
                            <button type="submit" class="fe-mugsy-logout-btn" title="Sign Out" aria-label="Sign Out">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="fe-mugsy-login-link">
                            <span>Sign In</span>
                        </a>

                        <a href="{{ route('register') }}" class="fe-mugsy-btn fe-mugsy-nav-pill">
                            <div class="fe-mugsy-btn-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                    <polyline points="12 5 19 12 12 19"></polyline>
                                </svg>
                            </div>
                            <span class="fe-mugsy-btn-text">Sign Up</span>
                        </a>
                    @endauth

                    <!-- Mobile Hamburger Button -->
                    <button type="button" class="fe-menu-btn" id="feMenuBtn" aria-label="Open mobile navigation" aria-expanded="false">
                        <span></span>
                        <span></span>
                    </button>
                </div>
            </div>
        </nav>
    </header>

    <!-- Mobile Navigation Drawer (Sleek Obsidian Forest & Emerald Glassmorphism) -->
    <div class="fe-mobile-menu-backdrop" id="feMobileBackdrop"></div>
    <aside class="fe-mobile-menu" id="feMobileMenu" aria-hidden="true" role="dialog" aria-modal="true" aria-label="Mobile Navigation">
        <div class="fe-mobile-menu-inner">
            <div class="fe-mobile-header">
                <div class="fe-mobile-brand">
                    <div class="fe-mugsy-brand-badge" style="width: 34px; height: 34px; border-radius: 8px;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <ellipse cx="12" cy="15" rx="3.5" ry="2.8" fill="#090909"/>
                            <circle cx="7.8" cy="9.8" r="1.8" fill="#090909"/>
                            <circle cx="10.8" cy="7.2" r="1.8" fill="#090909"/>
                            <circle cx="13.2" cy="7.2" r="1.8" fill="#090909"/>
                            <circle cx="16.2" cy="9.8" r="1.8" fill="#090909"/>
                        </svg>
                    </div>
                    <span class="fe-mugsy-brand-text font-anton" style="font-size: 1.35rem; color: #ffffff;">FURSHIELD</span>
                </div>
                <button type="button" class="fe-close-menu" id="feCloseMenu" aria-label="Close navigation">&times;</button>
            </div>

            <nav class="fe-mobile-nav" aria-label="Mobile navigation">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                    <span class="fe-mob-icon"><i class="fa-solid fa-house"></i></span>
                    <span>Home</span>
                </a>
                <a href="{{ route('pets.index') }}" class="{{ request()->routeIs('pets.*') ? 'active' : '' }}">
                    <span class="fe-mob-icon"><i class="fa-solid fa-paw"></i></span>
                    <span>Pets & Adoption</span>
                </a>
                <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
                    <span class="fe-mob-icon"><i class="fa-solid fa-bag-shopping"></i></span>
                    <span>Pet Pharmacy & Store</span>
                </a>
                <a href="{{ route('cart.index') }}" class="fe-mobile-cart-link {{ request()->routeIs('cart.*') ? 'active' : '' }}" data-auth-cart="view" onclick="if(!window.FurShieldAuth){event.preventDefault();event.stopPropagation();if(typeof window.closeFurShieldMobileMenu==='function')window.closeFurShieldMobileMenu();window.openAuthCartModal({mode:'view',redirect:'{{ route('cart.index') }}'});return false;}">
                    <span class="fe-mob-icon"><i class="fa-solid fa-cart-shopping"></i></span>
                    <span style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                        <span>Shopping Cart</span>
                        @if($cartCount > 0)
                            <span class="fe-cart-badge" style="position: static; transform: none; margin-left: 8px;">{{ $cartCount }}</span>
                        @endif
                    </span>
                </a>
                <a href="{{ route('appointments.index') }}" class="{{ request()->routeIs('appointments.*') ? 'active' : '' }}">
                    <span class="fe-mob-icon"><i class="fa-solid fa-stethoscope"></i></span>
                    <span>Book Clinician</span>
                </a>
                <a href="{{ route('care-tips.index') }}" class="{{ request()->routeIs('care-tips.*') ? 'active' : '' }}">
                    <span class="fe-mob-icon"><i class="fa-solid fa-lightbulb"></i></span>
                    <span>Care & Clinical Tips</span>
                </a>
                <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">
                    <span class="fe-mob-icon"><i class="fa-solid fa-shield-heart"></i></span>
                    <span>About Sanctuary</span>
                </a>
                <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">
                    <span class="fe-mob-icon"><i class="fa-solid fa-headset"></i></span>
                    <span>Emergency & Contact</span>
                </a>
            </nav>

            <div class="fe-mobile-footer">
                @auth
                    @php
                        $mPortal = match(Auth::user()->role) {
                            'admin' => route('admin.dashboard'),
                            'vet' => route('vet.dashboard'),
                            'shelter' => route('shelter.dashboard'),
                            default => route('owner.dashboard'),
                        };
                        $mLabel = match(Auth::user()->role) {
                            'admin' => 'Admin Panel',
                            'vet' => 'Clinician Portal',
                            'shelter' => 'Shelter Portal',
                            default => 'Pet Owner Portal',
                        };
                    @endphp
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <a href="{{ $mPortal }}" class="btn btn-emerald btn-block" style="display: flex; align-items: center; justify-content: center; gap: 8px; font-weight: 700; padding: 12px 18px; border-radius: 12px; font-size: 14px;">
                            <span>{{ $mLabel }}</span>
                            <span style="font-size: 11px; opacity: 0.8;">({{ Auth::user()->name }})</span>
                            <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 11px;"></i>
                        </a>
                        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" class="btn btn-block" style="background: rgba(239, 68, 68, 0.12); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.3); font-size: 13px; font-weight: 600; padding: 10px; border-radius: 12px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px;">
                                <i class="fa-solid fa-power-off"></i>
                                <span>Sign Out</span>
                            </button>
                        </form>
                    </div>
                @else
                    <div style="display: flex; gap: 10px;">
                        <a href="{{ route('login') }}" class="btn btn-sm" style="flex: 1; background: rgba(255, 255, 255, 0.08); color: #ffffff; border: 1px solid rgba(255, 255, 255, 0.18); text-align: center; text-decoration: none; padding: 12px 0; border-radius: 12px; font-weight: 700; font-size: 14px;">Sign In</a>
                        <a href="{{ route('register') }}" class="btn btn-emerald btn-sm" style="flex: 1; text-align: center; text-decoration: none; padding: 12px 0; border-radius: 12px; font-weight: 700; font-size: 14px; display: flex; align-items: center; justify-content: center; gap: 6px;">
                            <span>Sign Up</span>
                            <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 11px;"></i>
                        </a>
                    </div>
                @endauth

                <!-- Emergency Dispatch Link -->
                <a href="tel:+15550199738" class="fe-mobile-emergency-pill">
                    <span style="font-size: 14px;"><i class="fa-solid fa-truck-medical"></i></span>
                    <span>24/7 Emergency Care: <strong>+1 (555) 0199-PETS</strong></span>
                </a>
            </div>
        </div>
    </aside>

    <!-- Global Flash Alerts -->
    @if(session('success') || session('error') || session('info') || $errors->any())
        <div class="container" style="padding-top: 24px;">
            @if(session('success'))
                <div class="fe-alert fe-alert-success">
                    <div><i class="fa-solid fa-circle-check" style="margin-right: 6px;"></i>{{ session('success') }}</div>
                    <button type="button" class="fe-alert-close" onclick="this.parentElement.remove()" aria-label="Close alert">&times;</button>
                </div>
            @endif

            @if(session('error'))
                <div class="fe-alert fe-alert-danger">
                    <div><i class="fa-solid fa-triangle-exclamation" style="margin-right: 6px;"></i>{{ session('error') }}</div>
                    <button type="button" class="fe-alert-close" onclick="this.parentElement.remove()" aria-label="Close alert">&times;</button>
                </div>
            @endif

            @if($errors->any())
                <div class="fe-alert fe-alert-danger">
                    <div>
                        <strong>Please check the errors below:</strong>
                        <ul style="margin-top: 6px; padding-left: 20px;">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="fe-alert-close" onclick="this.parentElement.remove()" aria-label="Close alert">&times;</button>
                </div>
            @endif
        </div>
    @endif

    <!-- Main Page Content -->
    <main>
        @yield('content')
    </main>

    <!-- Bespoke Sticky Reveal Footer (Curtain Effect with Ambient Emerald Mesh) -->
    <footer class="fe-sticky-footer" id="feStickyFooter" style="clip-path: polygon(0% 0, 100% 0%, 100% 100%, 0 100%);">
        <div class="fe-sticky-footer-fixed">
            <div class="fe-sticky-footer-scroll">
                <div class="fe-sticky-footer-inner">
                    <!-- Abstract Ambient Radial Gradients (Mesh Backdrop) -->
                    <div aria-hidden="true" class="fe-sticky-ambient-mesh">
                        <div class="fe-ambient-radial fe-radial-1"></div>
                        <div class="fe-ambient-radial fe-radial-2"></div>
                        <div class="fe-ambient-radial fe-radial-3"></div>
                    </div>

                    <!-- Main Content Wrapper -->
                    <div class="fe-sticky-footer-content container">
                        <div class="fe-sticky-footer-main">
                            <!-- Brand Narrative, Socials & Newsletter -->
                            <div class="fe-sticky-animated fe-sticky-brand" style="--anim-delay: 0.1s;">
                                <div class="fe-footer-brand-header">
                                    <div class="fe-footer-logo-badge">
                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 28px; height: 28px;">
                                            <circle cx="12" cy="12" r="11" fill="#047857" stroke="#10b981" stroke-width="1.8"/>
                                            <ellipse cx="12" cy="15" rx="3.2" ry="2.6" fill="#ffffff"/>
                                            <circle cx="8" cy="10" r="1.6" fill="#ffffff"/>
                                            <circle cx="10.8" cy="8" r="1.6" fill="#ffffff"/>
                                            <circle cx="13.2" cy="8" r="1.6" fill="#ffffff"/>
                                            <circle cx="16" cy="10" r="1.6" fill="#ffffff"/>
                                        </svg>
                                    </div>
                                    <span class="fe-footer-brand-name">FurShield</span>
                                </div>

                                <p class="fe-footer-brand-desc">
                                    Every Paw Deserves a Shield of Love. Connecting owners, verified veterinarians, and animal rescue shelters into a unified health infrastructure.
                                </p>

                                <!-- Social Media Icon Buttons -->
                                <div class="fe-footer-social-row">
                                    <a href="https://www.facebook.com" target="_blank" rel="noopener noreferrer" class="fe-footer-social-btn" aria-label="Facebook" title="Facebook">
                                        <i class="fa-brands fa-facebook-f"></i>
                                    </a>
                                    <a href="https://www.instagram.com" target="_blank" rel="noopener noreferrer" class="fe-footer-social-btn" aria-label="Instagram" title="Instagram">
                                        <i class="fa-brands fa-instagram"></i>
                                    </a>
                                    <a href="https://www.youtube.com" target="_blank" rel="noopener noreferrer" class="fe-footer-social-btn" aria-label="YouTube" title="YouTube">
                                        <i class="fa-brands fa-youtube"></i>
                                    </a>
                                    <a href="https://www.linkedin.com/in/haris-anees-0b9925285" target="_blank" rel="noopener noreferrer" class="fe-footer-social-btn" aria-label="LinkedIn" title="LinkedIn">
                                        <i class="fa-brands fa-linkedin-in"></i>
                                    </a>
                                </div>

                                <!-- Real Working Newsletter Form -->
                                <form action="{{ route('contact.newsletter') }}" method="POST" class="fe-footer-newsletter-wrap">
                                    @csrf
                                    <input type="email" name="email" required placeholder="Enter your email for clinical alerts" class="fe-footer-input" aria-label="Email address for newsletter">
                                    <button type="submit" class="btn btn-emerald btn-sm">
                                        <span>Subscribe</span>
                                    </button>
                                </form>
                            </div>

                            <!-- Navigation Link Columns -->
                            <div class="fe-sticky-columns">
                                <div class="fe-sticky-animated fe-sticky-col" style="--anim-delay: 0.2s;">
                                    <h4 class="fe-sticky-col-title">Navigation</h4>
                                    <ul class="fe-sticky-col-links">
                                        <li><a href="{{ route('home') }}"><i class="fa fa-angle-right"></i> Home</a></li>
                                        <li><a href="{{ route('about') }}"><i class="fa fa-angle-right"></i> About FurShield</a></li>
                                        <li><a href="{{ route('appointments.index') }}"><i class="fa fa-angle-right"></i> Veterinary Services</a></li>
                                        <li><a href="{{ route('products.index') }}"><i class="fa fa-angle-right"></i> Pet Products</a></li>
                                        <li><a href="{{ route('care-tips.index') }}"><i class="fa fa-angle-right"></i> Care Tips</a></li>
                                    </ul>
                                </div>

                                <div class="fe-sticky-animated fe-sticky-col" style="--anim-delay: 0.3s;">
                                    <h4 class="fe-sticky-col-title">Pet Portals</h4>
                                    <ul class="fe-sticky-col-links">
                                        <li><a href="{{ route('pets.index') }}"><i class="fa fa-angle-right"></i> Pet Profiles</a></li>
                                        <li><a href="{{ route('adoption.index') }}"><i class="fa fa-angle-right"></i> Adoption Shelter</a></li>
                                        <li><a href="{{ route('owner.dashboard') }}"><i class="fa fa-angle-right"></i> Owner Dashboard</a></li>
                                        <li><a href="{{ route('login') }}"><i class="fa fa-angle-right"></i> Sign In / Register</a></li>
                                        <li><a href="{{ route('contact') }}"><i class="fa fa-angle-right"></i> Support & Help</a></li>
                                    </ul>
                                </div>

                                <div class="fe-sticky-animated fe-sticky-col" style="--anim-delay: 0.4s;">
                                    <h4 class="fe-sticky-col-title">Platform</h4>
                                    <ul class="fe-sticky-col-links">
                                        <li><a href="{{ route('contact') }}"><i class="fa fa-angle-right"></i> Contact Support</a></li>
                                        <li><a href="{{ route('about') }}"><i class="fa fa-angle-right"></i> Mission & Values</a></li>
                                        <li><a href="{{ route('products.index') }}"><i class="fa fa-angle-right"></i> Order Delivery</a></li>
                                        <li><a href="{{ route('cart.index') }}" data-auth-cart="view" onclick="if(!window.FurShieldAuth){event.preventDefault();event.stopPropagation();window.openAuthCartModal({mode:'view',redirect:'{{ route('cart.index') }}'});return false;}"><i class="fa fa-angle-right"></i> Cart & Checkout</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Footer Bottom Row -->
                        <div class="fe-sticky-animated fe-sticky-footer-bottom" style="--anim-delay: 0.5s;">
                            <div class="fe-footer-copy">
                                &copy; {{ date('Y') }} <strong>FurShield Inc.</strong> All rights reserved. Professional pet care infrastructure.
                            </div>
                            <div class="fe-footer-bottom-actions">
                                <span class="fe-footer-badge">Clinical Intelligence &bull; Verified Care</span>
                                <button type="button" class="fe-back-top" id="feBackTop" aria-label="Scroll back to top">
                                    <span>Back to top</span>
                                    <i class="fa fa-arrow-up"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>

<!-- Global Auth Required for Cart Modal -->
<div id="authRequiredCartModal" class="fe-modal-overlay" onclick="if(event.target===this) closeAuthCartModal()">
    <div class="fe-modal-card fe-auth-modal-card" role="dialog" aria-modal="true" aria-labelledby="authModalTitle">
        <div class="fe-auth-modal-banner">
            <div class="fe-auth-modal-icon-wrap">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg>
                <span class="fe-auth-modal-lock-badge" aria-hidden="true">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                </span>
            </div>
            <button type="button" onclick="closeAuthCartModal()" class="fe-modal-close fe-auth-modal-close" aria-label="Close modal">&times;</button>
        </div>

        <div class="fe-modal-body fe-auth-modal-body">
            <div class="fe-auth-modal-badge">
                <span class="care-badge-dot"></span>
                <span id="authModalBadgeText">AUTHENTICATION REQUIRED</span>
            </div>

            <h3 id="authModalTitle" class="fe-auth-modal-title">Sign In to Add to Cart</h3>
            
            <p id="authModalDesc" class="fe-auth-modal-desc">
                Please sign in to your FurShield account to add clinical pet care items to your shopping cart, access order tracking, and manage wellness deliveries.
            </p>

            <div class="fe-auth-modal-perks">
                <div class="fe-auth-perk-item">
                    <div class="fe-auth-perk-icon"><i class="fa-solid fa-check"></i></div>
                    <div class="fe-auth-perk-text">
                        <strong>Verified Clinical Essentials</strong>
                        <span>Veterinary-approved diets, supplements, and supplies</span>
                    </div>
                </div>
                <div class="fe-auth-perk-item">
                    <div class="fe-auth-perk-icon"><i class="fa-solid fa-check"></i></div>
                    <div class="fe-auth-perk-text">
                        <strong>Saved Pet Profiles & Addresses</strong>
                        <span>Fast, seamless checkout tailored to your companions</span>
                    </div>
                </div>
                <div class="fe-auth-perk-item">
                    <div class="fe-auth-perk-icon"><i class="fa-solid fa-check"></i></div>
                    <div class="fe-auth-perk-text">
                        <strong>Prescription & Order Tracking</strong>
                        <span>Instant digital invoices and shipment status alerts</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="fe-modal-footer fe-auth-modal-footer">
            <button type="button" onclick="closeAuthCartModal()" class="btn btn-secondary fe-auth-btn-ghost">Continue Browsing</button>
            <a id="authModalRegisterBtn" href="{{ route('register') }}" class="btn btn-secondary fe-auth-btn-register">Create Account</a>
            <a id="authModalLoginBtn" href="{{ route('login') }}" class="btn btn-primary fe-auth-btn-login">Sign In &rarr;</a>
        </div>
    </div>
</div>

<script>
    window.FurShieldAuth = @json(auth()->check());
    window.FurShieldLoginUrl = "{{ route('login') }}";
    window.FurShieldRegisterUrl = "{{ route('register') }}";
    window.FurShieldCartUrl = "{{ route('cart.index') }}";
</script>

<!-- GSAP & ScrollTrigger -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>

<!-- Swiper Slider JS (Cards Effect) -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- AI-Powered Pet Care Chatbot Widget (SRS Page 8: Optional Feature) -->
    <div id="aiChatWrapper">
        <!-- Floating Trigger Button -->
        <button type="button" id="aiChatTrigger" aria-label="Open AI Pet Care Chatbot" title="Ask FurShield AI Assistant">
            <span class="ai-bot-pulse"></span>
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2a7 7 0 0 0-7 7c0 2.38 1.19 4.47 3 5.74V17a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-2.26c1.81-1.27 3-3.36 3-5.74a7 7 0 0 0-7-7z" stroke="#040907" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M9 21h6" stroke="#040907" stroke-width="2" stroke-linecap="round"/>
                <circle cx="9" cy="9" r="1.2" fill="#040907"/>
                <circle cx="15" cy="9" r="1.2" fill="#040907"/>
            </svg>
            <span class="ai-chat-tooltip">Ask Pet AI</span>
        </button>

        <!-- Chat Window Modal -->
        <div id="aiChatBox" class="ai-chat-box" style="display: none;">
            <div class="ai-chat-header">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div class="ai-avatar-ring">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2a7 7 0 0 0-7 7c0 2.38 1.19 4.47 3 5.74V17a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-2.26c1.81-1.27 3-3.36 3-5.74a7 7 0 0 0-7-7z" stroke="#10b981" stroke-width="2"/>
                            <circle cx="9" cy="9" r="1" fill="#10b981"/>
                            <circle cx="15" cy="9" r="1" fill="#10b981"/>
                        </svg>
                    </div>
                    <div>
                        <strong style="color: #ffffff; font-size: 14px; display: block;">FurShield Clinical AI</strong>
                        <span style="color: #10b981; font-size: 11px; font-family: var(--font-mono); display: flex; align-items: center; gap: 4px;">
                            <span style="width: 6px; height: 6px; border-radius: 50%; background: #10b981; display: inline-block;"></span>
                            Online • Pet Care Assistant
                        </span>
                    </div>
                </div>
                <button type="button" id="aiChatClose" aria-label="Close Chat" style="background: none; border: none; color: #94a3b8; font-size: 15px; cursor: pointer; display: flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 6px; transition: color 0.2s;"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <!-- Messages Log -->
            <div class="ai-chat-body" id="aiChatMessages">
                <div class="ai-msg ai-msg-bot">
                    <p>Hello! I am your <strong>FurShield Pet Care AI</strong>. How can I assist your companion today? Ask me about feeding, vaccinations, toxic foods, or vet appointments.</p>
                </div>
            </div>

            <!-- Quick Suggestions -->
            <div class="ai-chips">
                <button type="button" class="ai-chip" onclick="askAiQuestion('What foods are toxic to dogs and cats?')"><i class="fa-solid fa-triangle-exclamation" style="color:#ef4444; margin-right:4px;"></i> Toxic Foods</button>
                <button type="button" class="ai-chip" onclick="askAiQuestion('When should I vaccinate my pet?')"><i class="fa-solid fa-syringe" style="color:#10b981; margin-right:4px;"></i> Vaccines</button>
                <button type="button" class="ai-chip" onclick="askAiQuestion('How much water does my pet need daily?')"><i class="fa-solid fa-droplet" style="color:#06b6d4; margin-right:4px;"></i> Hydration</button>
                <button type="button" class="ai-chip" onclick="askAiQuestion('How do I book a vet consultation?')"><i class="fa-solid fa-stethoscope" style="color:#10b981; margin-right:4px;"></i> Book Vet</button>
            </div>

            <!-- Input Bar -->
            <form id="aiChatForm" class="ai-chat-input-row" onsubmit="handleAiSubmit(event)">
                <input type="text" id="aiChatInput" placeholder="Ask any pet health or care question..." autocomplete="off">
                <button type="submit" aria-label="Send Message">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <style>
        #aiChatWrapper {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 9999;
        }
        #aiChatTrigger {
            width: 58px;
            height: 58px;
            border-radius: 50%;
            background: #10b981;
            border: 2px solid #ffffff;
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.45);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            position: relative;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }
        #aiChatTrigger:hover {
            transform: scale(1.08) translateY(-2px);
            box-shadow: 0 14px 30px rgba(16, 185, 129, 0.6);
        }
        .ai-bot-pulse {
            position: absolute;
            inset: -4px;
            border-radius: 50%;
            border: 2px solid #10b981;
            animation: aiPulse 2s infinite ease-out;
            opacity: 0.7;
        }
        @keyframes aiPulse {
            0% { transform: scale(1); opacity: 0.8; }
            100% { transform: scale(1.35); opacity: 0; }
        }
        .ai-chat-tooltip {
            position: absolute;
            right: 68px;
            background: #091a13;
            color: #ffffff;
            font-size: 11px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 6px;
            white-space: nowrap;
            pointer-events: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.25);
            border: 1px solid rgba(16, 185, 129, 0.3);
        }
        .ai-chat-box {
            position: absolute;
            bottom: 70px;
            right: 0;
            width: 360px;
            max-width: calc(100vw - 32px);
            height: 500px;
            max-height: calc(100vh - 120px);
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 20px 48px rgba(0,0,0,0.28);
            border: 1px solid #e2e8f0;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            animation: chatSlideUp 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        @keyframes chatSlideUp {
            from { opacity: 0; transform: translateY(20px) scale(0.96); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        .ai-chat-header {
            background: #091a13;
            padding: 14px 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .ai-avatar-ring {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .ai-chat-body {
            flex: 1;
            padding: 16px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 12px;
            background: #f8fafc;
        }
        .ai-msg {
            max-width: 85%;
            padding: 10px 14px;
            border-radius: 14px;
            font-size: 13px;
            line-height: 1.45;
        }
        .ai-msg-bot {
            align-self: flex-start;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            color: #0f172a;
            border-bottom-left-radius: 4px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.03);
        }
        .ai-msg-user {
            align-self: flex-end;
            background: #10b981;
            color: #040907;
            font-weight: 600;
            border-bottom-right-radius: 4px;
        }
        .ai-chips {
            display: flex;
            gap: 6px;
            padding: 8px 12px;
            background: #f1f5f9;
            overflow-x: auto;
            white-space: nowrap;
        }
        .ai-chip {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 600;
            color: #334155;
            cursor: pointer;
            transition: all 0.2s;
        }
        .ai-chip:hover {
            border-color: #10b981;
            color: #059669;
            background: #ecfdf5;
        }
        .ai-chat-input-row {
            display: flex;
            padding: 10px 12px;
            background: #ffffff;
            border-top: 1px solid #e2e8f0;
            gap: 8px;
        }
        .ai-chat-input-row input {
            flex: 1;
            border: 1px solid #cbd5e1;
            border-radius: 9999px;
            padding: 8px 14px;
            font-size: 12.5px;
            outline: none;
            font-family: inherit;
        }
        .ai-chat-input-row input:focus {
            border-color: #10b981;
        }
        .ai-chat-input-row button {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #10b981;
            color: #040907;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var trigger = document.getElementById('aiChatTrigger');
            var box = document.getElementById('aiChatBox');
            var close = document.getElementById('aiChatClose');
            if (trigger && box && close) {
                trigger.addEventListener('click', function() {
                    box.style.display = box.style.display === 'none' ? 'flex' : 'none';
                });
                close.addEventListener('click', function() {
                    box.style.display = 'none';
                });
            }
        });

        function askAiQuestion(q) {
            document.getElementById('aiChatInput').value = q;
            handleAiSubmit(new Event('submit'));
        }

        function handleAiSubmit(e) {
            e.preventDefault();
            var input = document.getElementById('aiChatInput');
            var text = input.value.trim();
            if (!text) return;

            var msgs = document.getElementById('aiChatMessages');
            
            // Add user bubble
            var userDiv = document.createElement('div');
            userDiv.className = 'ai-msg ai-msg-user';
            userDiv.textContent = text;
            msgs.appendChild(userDiv);
            input.value = '';
            msgs.scrollTop = msgs.scrollHeight;

            // Generate contextual AI response
            setTimeout(function() {
                var reply = generateAiReply(text.toLowerCase());
                var botDiv = document.createElement('div');
                botDiv.className = 'ai-msg ai-msg-bot';
                botDiv.innerHTML = reply;
                msgs.appendChild(botDiv);
                msgs.scrollTop = msgs.scrollHeight;
            }, 500);
        }

        function generateAiReply(lower) {
            if (lower.includes('toxic') || lower.includes('poison') || lower.includes('chocolate') || lower.includes('food')) {
                return "<i class=\"fa-solid fa-triangle-exclamation\" style=\"color:#ef4444; margin-right:4px;\"></i> <strong>High Toxicity Alert:</strong> Never feed pets chocolate, grapes/raisins, onions, garlic, macadamia nuts, or anything with <em>Xylitol</em> (artificial sweetener). If ingested, please contact our 24/7 Emergency Care immediately at <strong>+1 (555) 0199-PETS</strong>.";
            } else if (lower.includes('vaccin') || lower.includes('shot')) {
                return "<i class=\"fa-solid fa-syringe\" style=\"color:#10b981; margin-right:4px;\"></i> <strong>Core Vaccinations:</strong> Puppies & kittens typically begin core shots at 6-8 weeks, followed by boosters every 3-4 weeks until 16 weeks (DHPP/FVRCP & Rabies). You can track full milestones in your <strong><a href='/owner/health-records' style='color:#059669;'>Health Records</a></strong>!";
            } else if (lower.includes('water') || lower.includes('drink') || lower.includes('hydrate')) {
                return "<i class=\"fa-solid fa-droplet\" style=\"color:#06b6d4; margin-right:4px;\"></i> <strong>Hydration Guidelines:</strong> Dogs need approx 50-60ml of water per kg of body weight daily. Cats need 50ml per kg. Always ensure access to fresh, clean water!";
            } else if (lower.includes('vet') || lower.includes('book') || lower.includes('doctor') || lower.includes('appointment')) {
                return "<i class=\"fa-solid fa-stethoscope\" style=\"color:#10b981; margin-right:4px;\"></i> <strong>Consultation Booking:</strong> You can book certified veterinary specialists directly on our <strong><a href='/appointments' style='color:#059669;'>Appointments Page</a></strong>. Filter by condition or location to find the perfect clinician!";
            } else if (lower.includes('adopt') || lower.includes('shelter') || lower.includes('rescue')) {
                return "<i class=\"fa-solid fa-house-chimney-medical\" style=\"color:#10b981; margin-right:4px;\"></i> <strong>Adoption Sanctuary:</strong> Explore rescued pets awaiting forever homes in our <strong><a href='/adoption' style='color:#059669;'>Adoption Gallery</a></strong>! Submit an online application with one click.";
            } else {
                return "<i class=\"fa-solid fa-paw\" style=\"color:#10b981; margin-right:4px;\"></i> That is an important question regarding companion health. For clinical diagnosis or specific dietary protocol, we recommend booking a consult with one of our licensed veterinarians on the <a href='/appointments' style='color:#059669; font-weight:700;'>Appointments page</a>!";
            }
        }
    </script>

    <!-- Main Frontend Modern Interactive Engine (Navigation, Swiper, Drawer, Magnetic Effects) -->
    <script src="/js/frontend-modern.js?v=2.6"></script>
</body>
</html>
