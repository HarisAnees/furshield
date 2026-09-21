<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>FurShield — <?php echo $__env->yieldContent('title', 'Veterinary Clinician Portal'); ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&family=Manrope:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@1,400;1,600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="/owner/owner.css">
    <style>
        .vet-badge {
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
        .status-confirmed { background: #d1fae5; color: #065f46; }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-completed { background: #e0e7ff; color: #3730a3; }
        .status-cancelled { background: #fee2e2; color: #991b1b; }
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
            <a href="<?php echo e(route('home')); ?>" class="switcher-btn">● Public Site</a>
            <span class="switcher-btn active" style="color: #10b981;">
                <span class="dot-status"></span> Licensed Clinician
            </span>
        </div>
    </div>

    <div class="layout-main-row">
        <!-- Sidebar -->
        <aside class="owner-sidebar" id="sidebar">
            <div>
                <div class="sidebar-top">
                    <a class="brand-lockup" href="<?php echo e(route('vet.dashboard')); ?>">
                        <div class="brand-icon-shield">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="paw-icon">
                                <circle cx="12" cy="12" r="11" fill="#ecfdf5" stroke="#10b981" stroke-width="1.8"/>
                                <path d="M12 7v10M7 12h10" stroke="#059669" stroke-width="2.5" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div class="brand-text">
                            <strong>FurShield</strong>
                            <small>Clinical Portal</small>
                        </div>
                    </a>
                </div>

                <nav class="owner-nav-list" aria-label="Veterinarian navigation">
                    <a class="owner-nav-item <?php echo e(request()->routeIs('vet.dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('vet.dashboard')); ?>">
                        <span class="nav-icon">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                        </span>
                        <span>Clinical Overview</span>
                    </a>
                    <a class="owner-nav-item <?php echo e(request()->routeIs('vet.appointments*') ? 'active' : ''); ?>" href="<?php echo e(route('vet.appointments')); ?>">
                        <span class="nav-icon">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        </span>
                        <span>Patient Bookings</span>
                    </a>
                    <a class="owner-nav-item <?php echo e(request()->routeIs('vet.profile*') ? 'active' : ''); ?>" href="<?php echo e(route('vet.profile')); ?>">
                        <span class="nav-icon">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        </span>
                        <span>Clinic & Availability</span>
                    </a>
                    <a class="owner-nav-item" href="<?php echo e(route('home')); ?>">
                        <span class="nav-icon">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        </span>
                        <span>Public Website ↗</span>
                    </a>
                </nav>
            </div>

            <div class="sidebar-theme-toggle">
                <form method="POST" action="<?php echo e(route('logout')); ?>" style="width: 100%;">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="owner-btn owner-btn-secondary" style="width: 100%; justify-content: center; font-size: 11.5px; color: #ef4444; border-color: rgba(239,68,68,0.3);">
                        Sign Out ⏻
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="owner-main-area">
            <header class="owner-topbar">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span class="vet-badge">
                        <span style="width: 8px; height: 8px; border-radius: 50%; background: #10b981; display: inline-block;"></span>
                        LICENSED VETERINARY CLINIC
                    </span>
                    <span style="font-size: 13px; color: #64748b; font-weight: 500;">
                        <?php echo e(Auth::user()->name); ?>

                    </span>
                </div>

                <div class="header-right-actions">
                    <form method="POST" action="<?php echo e(route('logout')); ?>" style="display: inline;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn-sm btn-outline" style="border-radius: 9999px;">
                            Sign Out
                        </button>
                    </form>
                </div>
            </header>

            <main class="owner-page-content">
                <?php if(session('success')): ?>
                    <div style="background: #ecfdf5; border: 1px solid #10b981; color: #064e3b; padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; font-size: 13.5px; display: flex; align-items: center; gap: 10px;">
                        <span style="font-weight: 800;">✓</span> <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>
                <?php if(session('error')): ?>
                    <div style="background: #fef2f2; border: 1px solid #ef4444; color: #991b1b; padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; font-size: 13.5px; display: flex; align-items: center; gap: 10px;">
                        <span style="font-weight: 800;">✕</span> <?php echo e(session('error')); ?>

                    </div>
                <?php endif; ?>

                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    </div>
</div>

<?php echo $__env->yieldContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\pat\FurShield\resources\views/vet/layouts/app.blade.php ENDPATH**/ ?>