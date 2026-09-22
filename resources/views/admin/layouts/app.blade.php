<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FurShield Admin — @yield('title', 'Admin Dashboard')</title>

    <!-- Google Fonts: Manrope, DM Mono, Playfair Display -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&family=Manrope:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@1,400;1,600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/admin/admin.css?v=2.6">
    <style>
        .flash-alert {
            padding: 14px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .flash-alert.success {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
        }
        .flash-alert.error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }
        .flash-close-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 18px;
            color: inherit;
            opacity: 0.7;
            line-height: 1;
        }
        .flash-close-btn:hover {
            opacity: 1;
        }
    </style>
</head>
<body class="admin-body">
<div class="grain" aria-hidden="true"></div>

<div class="admin-shell">
    <!-- Minimalist Dark Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-top">
            <a class="brand-lockup" href="{{ route('admin.dashboard') }}">
                <div class="brand-icon-shield">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="paw-icon">
                        <circle cx="12" cy="12" r="11" fill="#047857" stroke="#10b981" stroke-width="1.8"/>
                        <ellipse cx="12" cy="15" rx="3.2" ry="2.6" fill="#ffffff"/>
                        <circle cx="8" cy="10" r="1.6" fill="#ffffff"/>
                        <circle cx="10.8" cy="8" r="1.6" fill="#ffffff"/>
                        <circle cx="13.2" cy="8" r="1.6" fill="#ffffff"/>
                        <circle cx="16" cy="10" r="1.6" fill="#ffffff"/>
                    </svg>
                </div>
                <div class="brand-text">
                    <strong>FurShield</strong>
                    <small>System Administration</small>
                </div>
            </a>
            <button class="sidebar-close" id="sidebarClose" aria-label="Close navigation">&times;</button>
        </div>

        <nav class="nav-list" aria-label="Admin Navigation">
            <a class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <span class="nav-icon">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                </span>
                <span>Dashboard</span>
            </a>
            <a class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                <span class="nav-icon">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                </span>
                <span>Users</span>
            </a>
            <a class="nav-item {{ request()->routeIs('admin.pets.*') ? 'active' : '' }}" href="{{ route('admin.pets.index') }}">
                <span class="nav-icon">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a4 4 0 0 1 4 4v1a4 4 0 0 1-8 0V6a4 4 0 0 1 4-4z"></path><path d="M6 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"></path></svg>
                </span>
                <span>Pets</span>
            </a>
            <a class="nav-item {{ request()->routeIs('admin.appointments.*') ? 'active' : '' }}" href="{{ route('admin.appointments.index') }}">
                <span class="nav-icon">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                </span>
                <span>Appointments</span>
            </a>
            <a class="nav-item {{ request()->routeIs('admin.health-records.*') ? 'active' : '' }}" href="{{ route('admin.health-records.index') }}">
                <span class="nav-icon">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                </span>
                <span>Health Records</span>
            </a>
            <a class="nav-item {{ request()->routeIs('admin.adoptions.*') ? 'active' : '' }}" href="{{ route('admin.adoptions.index') }}">
                <span class="nav-icon">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                </span>
                <span>Adoptions</span>
            </a>
            <a class="nav-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                <span class="nav-icon">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                </span>
                <span>Products</span>
            </a>
            <a class="nav-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                <span class="nav-icon">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                </span>
                <span>Orders</span>
            </a>
            <a class="nav-item {{ request()->routeIs('admin.content.*') ? 'active' : '' }}" href="{{ route('admin.content.index') }}">
                <span class="nav-icon">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                </span>
                <span>Content</span>
            </a>
            <a class="nav-item {{ request()->routeIs('admin.notifications.*') ? 'active' : '' }}" href="{{ route('admin.notifications.index') }}">
                <span class="nav-icon">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                </span>
                <span>Notifications</span>
            </a>
            <a class="nav-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}">
                <span class="nav-icon">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                </span>
                <span>Reports</span>
            </a>
            <a class="nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">
                <span class="nav-icon">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                </span>
                <span>Settings</span>
            </a>
        </nav>

        <div class="sidebar-bottom">
            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                @csrf
                <button class="logout-btn" type="submit">
                    <span>↪</span>
                    <span>Sign Out</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="main-area">
        <!-- Top View Switcher -->
        <div class="top-nav-switcher">
            <div class="switcher-pill">
                <span class="switcher-label">VIEW MODE:</span>
                <a href="{{ route('home') }}" class="switcher-btn">
                    ● Website
                </a>
                <a href="{{ route('admin.dashboard') }}" class="switcher-btn active">
                    <span class="dot-status"></span> Admin Dashboard
                </a>
            </div>
        </div>

        <header class="topbar">
            <button class="menu-toggle" id="menuToggle" aria-label="Open navigation">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>
            
            <div class="page-title-block">
                <h1>@yield('page_title', 'Admin Dashboard')</h1>
                <p>@yield('page_subtitle', "System status and management metrics across FurShield.")</p>
            </div>

            <div class="topbar-right">
                <div class="date-display">
                    <span>{{ now()->format('M d, Y') }}</span>
                </div>
                <div class="admin-profile">
                    <img src="/images/admin-avatar.jpg" alt="Admin" class="avatar-circle" onerror="this.src='https://ui-avatars.com/api/?name=Admin&background=059669&color=fff'">
                    <div class="admin-info">
                        <strong>{{ auth()->user()?->name ?? 'Administrator' }}</strong>
                        <small>System Admin</small>
                    </div>
                </div>
            </div>
        </header>

        <main class="content">
            @if (session('success'))
            <div class="flash-alert success">
                <div>✓ {{ session('success') }}</div>
                <button type="button" class="flash-close-btn" onclick="this.parentElement.remove()" aria-label="Close alert">&times;</button>
            </div>
            @endif

            @if (session('error'))
            <div class="flash-alert error">
                <div>⚠️ {{ session('error') }}</div>
                <button type="button" class="flash-close-btn" onclick="this.parentElement.remove()" aria-label="Close alert">&times;</button>
            </div>
            @endif

            @if ($errors->any())
            <div class="flash-alert error">
                <div>⚠️ {{ $errors->first() }}</div>
                <button type="button" class="flash-close-btn" onclick="this.parentElement.remove()" aria-label="Close alert">&times;</button>
            </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<div class="mobile-overlay" id="mobileOverlay"></div>
<script src="/admin/admin.js?v=2.6"></script>
</body>
</html>
