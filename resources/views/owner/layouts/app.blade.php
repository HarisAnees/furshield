<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FurShield — @yield('title', 'Pet Owner Dashboard')</title>

    <!-- Google Fonts: Manrope, DM Mono, Playfair Display -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&family=Manrope:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@1,400;1,600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/owner/owner.css">
</head>
<body class="owner-body">
<div class="grain" aria-hidden="true"></div>

<div class="owner-shell">

    <!-- Top View Switcher -->
    <div class="top-nav-switcher">
        <div class="switcher-pill">
            <span class="switcher-label">VIEW MODE:</span>
            <a href="{{ route('home') }}" class="switcher-btn">
                ● Website
            </a>
            <a href="{{ route('owner.dashboard') }}" class="switcher-btn active">
                <span class="dot-status"></span> Pet Owner Dashboard
            </a>
            <a href="{{ route('admin.dashboard') }}" class="switcher-btn">
                Admin Dashboard
            </a>
        </div>
    </div>

    <div class="layout-main-row">
        <!-- Minimal Sidebar -->
        <aside class="owner-sidebar" id="sidebar">
            <div>
                <div class="sidebar-top">
                    <a class="brand-lockup" href="{{ route('owner.dashboard') }}">
                        <div class="brand-icon-shield">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="paw-icon">
                                <circle cx="12" cy="12" r="11" fill="#ecfdf5" stroke="#10b981" stroke-width="1.8"/>
                                <ellipse cx="12" cy="15" rx="3.2" ry="2.6" fill="#059669"/>
                                <circle cx="8" cy="10" r="1.6" fill="#059669"/>
                                <circle cx="10.8" cy="8" r="1.6" fill="#059669"/>
                                <circle cx="13.2" cy="8" r="1.6" fill="#059669"/>
                                <circle cx="16" cy="10" r="1.6" fill="#059669"/>
                            </svg>
                        </div>
                        <div class="brand-text">
                            <strong>FurShield</strong>
                            <small>Owner Portal</small>
                        </div>
                    </a>
                </div>

                <nav class="owner-nav-list" aria-label="Owner navigation">
                    <a class="owner-nav-item {{ request()->routeIs('owner.dashboard') ? 'active' : '' }}" href="{{ route('owner.dashboard') }}">
                        <span class="nav-icon">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                        </span>
                        <span>Dashboard</span>
                    </a>
                    <a class="owner-nav-item {{ request()->routeIs('owner.pets*') ? 'active' : '' }}" href="{{ route('owner.pets') }}">
                        <span class="nav-icon">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a4 4 0 0 1 4 4v1a4 4 0 0 1-8 0V6a4 4 0 0 1 4-4z"></path><path d="M6 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"></path></svg>
                        </span>
                        <span>My Pets</span>
                    </a>
                    <a class="owner-nav-item {{ request()->routeIs('owner.appointments*') ? 'active' : '' }}" href="{{ route('owner.appointments') }}">
                        <span class="nav-icon">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        </span>
                        <span>Appointments</span>
                    </a>
                    <a class="owner-nav-item {{ request()->routeIs('owner.health-records*') ? 'active' : '' }}" href="{{ route('owner.health-records') }}">
                        <span class="nav-icon">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                        </span>
                        <span>Health Records</span>
                    </a>
                    <a class="owner-nav-item {{ request()->routeIs('owner.products*') ? 'active' : '' }}" href="{{ route('owner.products') }}">
                        <span class="nav-icon">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                        </span>
                        <span>Products</span>
                    </a>
                    <a class="owner-nav-item {{ request()->routeIs('owner.care-tips*') ? 'active' : '' }}" href="{{ route('owner.care-tips') }}">
                        <span class="nav-icon">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                        </span>
                        <span>Care & Tips</span>
                    </a>
                    <a class="owner-nav-item {{ request()->routeIs('owner.notifications*') ? 'active' : '' }}" href="{{ route('owner.notifications') }}">
                        <span class="nav-icon">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                        </span>
                        <span>Notifications</span>
                    </a>
                    <a class="owner-nav-item {{ request()->routeIs('owner.profile*') ? 'active' : '' }}" href="{{ route('owner.profile') }}">
                        <span class="nav-icon">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        </span>
                        <span>Profile</span>
                    </a>
                </nav>
            </div>

            <div class="sidebar-theme-toggle">
                <form method="POST" action="{{ route('logout') }}" style="width: 100%;">
                    @csrf
                    <button type="submit" class="owner-btn owner-btn-secondary" style="width: 100%; justify-content: center; font-size: 11.5px;">
                        Sign Out ↗
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="owner-main-area">
            <!-- Header Top Bar -->
            <header class="owner-topbar">
                <div class="search-input-wrap">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <input type="text" placeholder="Search pets, records, appointments..." aria-label="Search dashboard">
                </div>

                <div class="header-right-actions">
                    <a href="{{ route('owner.notifications') }}" class="action-icon-btn" title="Notifications" aria-label="Notifications">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg>
                        <span class="red-notification-dot"></span>
                    </a>
                    <a href="{{ route('owner.profile') }}" class="user-profile-header">
                        <img src="/images/sarah-avatar.jpg" alt="Sarah Johnson" class="avatar-circle">
                        <div class="user-header-text">
                            <strong>{{ auth()->user()->name ?? 'Sarah Johnson' }}</strong>
                            <small>{{ ucfirst(auth()->user()->role ?? 'Pet Owner') }}</small>
                        </div>
                    </a>
                </div>
            </header>

            <main class="owner-content">
                @if(session('success'))
                    <div class="owner-flash-alert success">
                        <span>✓ {{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div class="owner-flash-alert error">
                        <span>⚠ {{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</div>

<div class="image-label-badge">
    Pet Owner Portal • FurShield
</div>

<script>
function openOwnerModal(id) { 
    const el = document.getElementById(id);
    if (el) el.classList.add('active'); 
}
function closeOwnerModal(id) { 
    const el = document.getElementById(id);
    if (el) el.classList.remove('active'); 
}
</script>

</body>
</html>
