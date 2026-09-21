<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FurShield — @yield('title', 'Animal Shelter Operations Portal')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&family=Manrope:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@1,400;1,600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/owner/owner.css">
    <style>
        .shelter-badge {
            background: #ecfdf5;
            color: #064e3b;
            border: 1px solid #a7f3d0;
            padding: 3px 10px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 700;
            font-family: var(--font-mono, monospace);
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .status-pill {
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            font-family: var(--font-mono, monospace);
        }
        .status-available { background: #d1fae5; color: #065f46; }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-adopted { background: #e0e7ff; color: #3730a3; }
        .action-table { width: 100%; border-collapse: collapse; font-size: 13px; }
        .action-table th { text-align: left; padding: 12px 14px; background: #f8fafc; color: #475569; font-weight: 700; border-bottom: 1px solid #e2e8f0; }
        .action-table td { padding: 14px; border-bottom: 1px solid #f1f5f9; color: #1e293b; vertical-align: middle; }
        .action-table tr:hover td { background: #f8fafc; }
        .btn-sm { padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 700; cursor: pointer; border: none; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; transition: all 0.2s; }
        .btn-emerald { background: #10b981; color: #040907; }
        .btn-emerald:hover { background: #059669; color: #ffffff; }
        .btn-outline { background: transparent; border: 1px solid #cbd5e1; color: #475569; }
        .btn-outline:hover { background: #f1f5f9; color: #0f172a; }
        .btn-danger { background: #fee2e2; color: #b91c1c; }
        .btn-danger:hover { background: #ef4444; color: #ffffff; }
        .card-surface { background: #ffffff; border-radius: 18px; border: 1px solid #e2e8f0; padding: 24px; box-shadow: 0 2px 12px rgba(0,0,0,0.03); margin-bottom: 24px; }
    </style>
</head>
<body class="owner-body">
<div class="grain" aria-hidden="true"></div>

<div class="owner-shell">
    <!-- Top View Switcher -->
    <div class="top-nav-switcher">
        <div class="switcher-pill">
            <span class="switcher-label">PORTAL:</span>
            <a href="{{ route('home') }}" class="switcher-btn">● Public Site</a>
            <span class="switcher-btn active" style="color: #10b981;">
                <span class="dot-status"></span> Animal Shelter Sanctuary
            </span>
        </div>
    </div>

    <div class="layout-main-row">
        <!-- Sidebar -->
        <aside class="owner-sidebar" id="sidebar">
            <div class="owner-sidebar-content-scroll">
                <div class="sidebar-top">
                    <a class="brand-lockup" href="{{ route('shelter.dashboard') }}">
                        <div class="brand-icon-shield">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="paw-icon">
                                <circle cx="12" cy="12" r="11" fill="#ecfdf5" stroke="#10b981" stroke-width="1.8"/>
                                <path d="M3 10l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" fill="#059669"/>
                            </svg>
                        </div>
                        <div class="brand-text">
                            <strong>FurShield</strong>
                            <small>Shelter Sanctuary</small>
                        </div>
                    </a>
                    <button type="button" class="owner-sidebar-close" id="ownerSidebarClose" aria-label="Close navigation">&times;</button>
                </div>

                <nav class="owner-nav-list" aria-label="Shelter navigation">
                    <a class="owner-nav-item {{ request()->routeIs('shelter.dashboard') ? 'active' : '' }}" href="{{ route('shelter.dashboard') }}">
                        <span class="nav-icon">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                        </span>
                        <span>Rescue Overview</span>
                    </a>
                    <a class="owner-nav-item {{ request()->routeIs('shelter.listings*') ? 'active' : '' }}" href="{{ route('shelter.listings') }}">
                        <span class="nav-icon">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a4 4 0 0 1 4 4v1a4 4 0 0 1-8 0V6a4 4 0 0 1 4-4z"></path><path d="M6 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"></path></svg>
                        </span>
                        <span>Adoptable Listings</span>
                    </a>
                    <a class="owner-nav-item {{ request()->routeIs('shelter.care-logs*') ? 'active' : '' }}" href="{{ route('shelter.care-logs') }}">
                        <span class="nav-icon">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                        </span>
                        <span>Daily Care Logs</span>
                    </a>
                    <a class="owner-nav-item {{ request()->routeIs('shelter.applications*') ? 'active' : '' }}" href="{{ route('shelter.applications') }}">
                        <span class="nav-icon">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        </span>
                        <span>Adopter Applications</span>
                    </a>
                    <a class="owner-nav-item" href="{{ route('home') }}">
                        <span class="nav-icon">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        </span>
                        <span>Public Website ↗</span>
                    </a>
                </nav>
            </div>

            <div class="sidebar-theme-toggle">
                <form method="POST" action="{{ route('logout') }}" style="width: 100%; margin: 0;">
                    @csrf
                    <button type="submit" class="owner-sidebar-signout-btn" title="Sign Out of Shelter Portal" aria-label="Sign Out">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        <span>Sign Out</span>
                        <span class="signout-arrow">↗</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="owner-main-area">
            <header class="owner-topbar">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <button type="button" class="owner-menu-toggle" id="ownerMenuToggle" aria-label="Open sidebar navigation">☰</button>
                    <span class="shelter-badge">
                        <span style="width: 8px; height: 8px; border-radius: 50%; background: #10b981; display: inline-block;"></span>
                        VERIFIED ANIMAL SHELTER
                    </span>
                    <span style="font-size: 13px; color: #64748b; font-weight: 500;">
                        {{ $shelter->organization_name ?? Auth::user()->name }}
                    </span>
                </div>

                <div class="header-right-actions">
                    <form method="POST" action="{{ route('logout') }}" class="owner-topbar-logout-form">
                        @csrf
                        <button type="submit" class="owner-topbar-signout-btn" title="Sign Out of Shelter Portal" aria-label="Sign Out">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                            <span class="owner-signout-label">Sign Out</span>
                        </button>
                    </form>
                </div>
            </header>

            <main class="owner-page-content">
                @if (session('success'))
                    <div style="background: #ecfdf5; border: 1px solid #10b981; color: #064e3b; padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; font-size: 13.5px; display: flex; align-items: center; gap: 10px;">
                        <span style="font-weight: 800;">✓</span> {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div style="background: #fef2f2; border: 1px solid #ef4444; color: #991b1b; padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; font-size: 13.5px; display: flex; align-items: center; gap: 10px;">
                        <span style="font-weight: 800;">✕</span> {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</div>

<div class="owner-mobile-overlay" id="ownerMobileOverlay"></div>
<script src="/owner/owner.js"></script>
@yield('scripts')
</body>
</html>
