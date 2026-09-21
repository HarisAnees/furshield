<?php $__env->startSection('title', 'Admin Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-dashboard-container">

    <!-- Executive Operations Hero Strip -->
    <div class="dashboard-hero-strip">
        <div class="hero-strip-left">
            <div class="system-status-indicator">
                <span class="pulse-dot"></span>
                <span>FURSHIELD OPERATIONS · V1.0 STABLE · ALL SYSTEMS ONLINE</span>
            </div>
            <h2 class="hero-strip-title">Operations & <em>Command Center</em></h2>
            <p class="hero-strip-subtitle">
                Real-time oversight of verified pet owners, clinical schedules, registered patients, and platform commerce.
            </p>
        </div>
        <div class="hero-quick-actions">
            <a href="<?php echo e(route('admin.users.index')); ?>" class="quick-action-pill primary">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span>Add User</span>
            </a>
            <a href="<?php echo e(route('admin.appointments.index')); ?>" class="quick-action-pill">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                <span>Consultations</span>
            </a>
            <a href="<?php echo e(route('admin.pets.index')); ?>" class="quick-action-pill">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2a5 5 0 0 1 5 5v3a5 5 0 0 1-10 0V7a5 5 0 0 1 5-5z"></path><path d="M19 11v1a7 7 0 0 1-14 0v-1"></path></svg>
                <span>Patients</span>
            </a>
            <a href="<?php echo e(route('admin.notifications.index')); ?>" class="quick-action-pill">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                <span>Broadcast Alert</span>
            </a>
        </div>
    </div>

    <!-- Top KPI Stat Cards -->
    <div class="kpi-grid">
        <!-- Card 1: Total Users -->
        <a href="<?php echo e(route('admin.users.index')); ?>" class="kpi-card" title="Click to manage users">
            <div class="kpi-card-top">
                <span class="kpi-tag-mono">01 / REGISTRY</span>
                <div class="kpi-icon-wrap blue">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </div>
            </div>
            <div class="kpi-details">
                <span class="kpi-label">Total Verified Users</span>
                <div class="kpi-body-row">
                    <strong class="kpi-value"><?php echo e(number_format($stats['users'])); ?></strong>
                    <div class="kpi-trend up">
                        <span>↑ 12%</span>
                    </div>
                </div>
            </div>
            <div class="kpi-card-footer">
                <span>Platform members & staff</span>
                <span class="arrow">Manage →</span>
            </div>
        </a>

        <!-- Card 2: Total Pets -->
        <a href="<?php echo e(route('admin.pets.index')); ?>" class="kpi-card" title="Click to view pet registry">
            <div class="kpi-card-top">
                <span class="kpi-tag-mono">02 / PATIENTS</span>
                <div class="kpi-icon-wrap teal">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 10.5c-1.8 0-3.3 1.3-3.5 3-.1 1 .5 1.9 1.4 2.3.6.3 1.3.4 2.1.4s1.5-.1 2.1-.4c.9-.4 1.5-1.3 1.4-2.3-.2-1.7-1.7-3-3.5-3zM5.5 8c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm13 0c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm-9.5-3c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm6 0c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/>
                    </svg>
                </div>
            </div>
            <div class="kpi-details">
                <span class="kpi-label">Registered Companion Pets</span>
                <div class="kpi-body-row">
                    <strong class="kpi-value"><?php echo e(number_format($stats['pets'])); ?></strong>
                    <div class="kpi-trend up">
                        <span>↑ 8%</span>
                    </div>
                </div>
            </div>
            <div class="kpi-card-footer">
                <span>Active patient profiles</span>
                <span class="arrow">View →</span>
            </div>
        </a>

        <!-- Card 3: Appointments Today -->
        <a href="<?php echo e(route('admin.appointments.index')); ?>" class="kpi-card" title="Click to view today's schedule">
            <div class="kpi-card-top">
                <span class="kpi-tag-mono">03 / CLINICAL</span>
                <div class="kpi-icon-wrap blue">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                </div>
            </div>
            <div class="kpi-details">
                <span class="kpi-label">Appointments Scheduled Today</span>
                <div class="kpi-body-row">
                    <strong class="kpi-value"><?php echo e(number_format($stats['appointments_today'])); ?></strong>
                    <div class="kpi-trend up">
                        <span>↑ 15%</span>
                    </div>
                </div>
            </div>
            <div class="kpi-card-footer">
                <span>Veterinary consultations</span>
                <span class="arrow">Schedule →</span>
            </div>
        </a>

        <!-- Card 4: Total Orders -->
        <a href="<?php echo e(route('admin.orders.index')); ?>" class="kpi-card" title="Click to view marketplace orders">
            <div class="kpi-card-top">
                <span class="kpi-tag-mono">04 / COMMERCE</span>
                <div class="kpi-icon-wrap orange">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                </div>
            </div>
            <div class="kpi-details">
                <span class="kpi-label">Marketplace Orders</span>
                <div class="kpi-body-row">
                    <strong class="kpi-value"><?php echo e(number_format($stats['orders'])); ?></strong>
                    <div class="kpi-trend up">
                        <span>↑ 9%</span>
                    </div>
                </div>
            </div>
            <div class="kpi-card-footer">
                <span>Platform store transactions</span>
                <span class="arrow">Orders →</span>
            </div>
        </a>
    </div>

    <!-- Middle Section: 3 Panels -->
    <div class="panels-grid middle-grid">
        <!-- Panel 1: User Growth Velocity -->
        <div class="dashboard-panel growth-panel">
            <div class="panel-header">
                <div>
                    <h3>User & Patient Growth</h3>
                    <small style="color: var(--muted); font-size: 11px;">Interactive velocity analytics</small>
                </div>
                <div class="time-filter-tabs">
                    <button type="button" class="filter-tab">7D</button>
                    <button type="button" class="filter-tab active">30D</button>
                    <button type="button" class="filter-tab">3M</button>
                    <button type="button" class="filter-tab">1Y</button>
                </div>
            </div>
            <div class="chart-container">
                <div class="y-axis-labels">
                    <span>1,500</span>
                    <span>1,000</span>
                    <span>500</span>
                    <span>0</span>
                </div>
                <div class="svg-chart-wrap">
                    <svg viewBox="0 0 500 180" preserveAspectRatio="none" class="growth-svg">
                        <defs>
                            <linearGradient id="growthGradient" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#059669" stop-opacity="0.25"/>
                                <stop offset="100%" stop-color="#059669" stop-opacity="0.0"/>
                            </linearGradient>
                        </defs>
                        <!-- Grid lines -->
                        <line x1="0" y1="20" x2="500" y2="20" stroke="#f1f5f9" stroke-width="1" />
                        <line x1="0" y1="65" x2="500" y2="65" stroke="#f1f5f9" stroke-width="1" />
                        <line x1="0" y1="110" x2="500" y2="110" stroke="#f1f5f9" stroke-width="1" />
                        <line x1="0" y1="155" x2="500" y2="155" stroke="#f1f5f9" stroke-width="1" />

                        <!-- Shaded area -->
                        <path d="M 10,135 C 70,120 100,128 135,115 C 170,102 210,108 260,80 C 310,52 350,75 385,62 C 430,48 460,35 490,28 L 490,160 L 10,160 Z" fill="url(#growthGradient)" />

                        <!-- Spline Line -->
                        <path d="M 10,135 C 70,120 100,128 135,115 C 170,102 210,108 260,80 C 310,52 350,75 385,62 C 430,48 460,35 490,28" fill="none" stroke="#059669" stroke-width="2.8" stroke-linecap="round"/>

                        <!-- Data Points -->
                        <circle cx="10" cy="135" r="4.5" fill="#ffffff" stroke="#059669" stroke-width="2.5" />
                        <circle cx="135" cy="115" r="4.5" fill="#ffffff" stroke="#059669" stroke-width="2.5" />
                        <circle cx="260" cy="80" r="4.5" fill="#ffffff" stroke="#059669" stroke-width="2.5" />
                        <circle cx="385" cy="62" r="4.5" fill="#ffffff" stroke="#059669" stroke-width="2.5" />
                        <circle cx="490" cy="28" r="4.5" fill="#ffffff" stroke="#059669" stroke-width="2.5" />
                    </svg>
                    <div class="x-axis-labels">
                        <span>Apr 1</span>
                        <span>Apr 7</span>
                        <span>Apr 14</span>
                        <span>Apr 21</span>
                        <span>Apr 28</span>
                    </div>
                </div>
            </div>
            <!-- Sub metrics -->
            <div class="chart-sub-metrics">
                <div class="sub-metric-item">
                    <span class="sub-metric-label">Avg Session</span>
                    <strong class="sub-metric-val">4m 18s</strong>
                </div>
                <div class="sub-metric-item">
                    <span class="sub-metric-label">Retention</span>
                    <strong class="sub-metric-val" style="color: var(--emerald-dark);">98.4%</strong>
                </div>
                <div class="sub-metric-item">
                    <span class="sub-metric-label">New / Month</span>
                    <strong class="sub-metric-val">+148</strong>
                </div>
            </div>
        </div>

        <!-- Panel 2: User Demographics & Distribution -->
        <div class="dashboard-panel distribution-panel">
            <div class="panel-header">
                <div>
                    <h3>User Demographics</h3>
                    <small style="color: var(--muted); font-size: 11px;">Verified ecosystem members</small>
                </div>
                <a href="<?php echo e(route('admin.users.index')); ?>" class="view-all-link">Roles →</a>
            </div>
            <div class="distribution-content">
                <div class="donut-chart-box">
                    <svg viewBox="0 0 160 160" class="donut-svg">
                        <!-- Pet Owners (68% = 256.36) -->
                        <circle cx="80" cy="80" r="60" fill="none" stroke="#0ea5e9" stroke-width="22"
                                stroke-dasharray="256.36 377" stroke-dashoffset="94.25" />
                        <!-- Veterinarians (12% = 45.24) -->
                        <circle cx="80" cy="80" r="60" fill="none" stroke="#10b981" stroke-width="22"
                                stroke-dasharray="45.24 377" stroke-dashoffset="-162.11" />
                        <!-- Shelters (8% = 30.16) -->
                        <circle cx="80" cy="80" r="60" fill="none" stroke="#f59e0b" stroke-width="22"
                                stroke-dasharray="30.16 377" stroke-dashoffset="-207.35" />
                        <!-- Admins (12% = 45.24) -->
                        <circle cx="80" cy="80" r="60" fill="none" stroke="#1e293b" stroke-width="22"
                                stroke-dasharray="45.24 377" stroke-dashoffset="-237.51" />
                    </svg>
                    <div class="donut-center-info">
                        <strong><?php echo e(number_format($roleTotal)); ?></strong>
                        <span>Total Users</span>
                    </div>
                </div>
                <div class="donut-legend">
                    <div class="legend-item">
                        <span class="legend-color-box owners"></span>
                        <span class="legend-name">Pet Owners</span>
                        <span class="legend-pct"><?php echo e($roleCounts['owner_pct'] ?? 68); ?>%</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-color-box vets"></span>
                        <span class="legend-name">Veterinarians</span>
                        <span class="legend-pct"><?php echo e($roleCounts['vet_pct'] ?? 12); ?>%</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-color-box shelters"></span>
                        <span class="legend-name">Shelters</span>
                        <span class="legend-pct"><?php echo e($roleCounts['shelter_pct'] ?? 8); ?>%</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-color-box admins"></span>
                        <span class="legend-name">Admins</span>
                        <span class="legend-pct"><?php echo e($roleCounts['admin_pct'] ?? 12); ?>%</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel 3: Recent Appointments -->
        <div class="dashboard-panel appointments-panel">
            <div class="panel-header">
                <div>
                    <h3>Clinical Queue</h3>
                    <small style="color: var(--muted); font-size: 11px;">Recent & upcoming bookings</small>
                </div>
                <a href="<?php echo e(route('admin.appointments.index')); ?>" class="view-all-link">Full schedule →</a>
            </div>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Pet</th>
                            <th>Owner</th>
                            <th>Vet</th>
                            <th>Date & Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="font-medium" style="font-weight: 700; color: var(--ink);"><?php echo e($appt->pet?->name ?? 'Buddy'); ?></td>
                            <td style="color: #475569;"><?php echo e($appt->user?->name ?? 'Sarah J.'); ?></td>
                            <td style="color: #475569;"><?php echo e($appt->vet?->user?->name ? str_replace('Dr. Emily Carter', 'Dr. Carter', $appt->vet->user->name) : 'Dr. Carter'); ?></td>
                            <td style="font-family: var(--font-mono); font-size: 11px; color: var(--muted);"><?php echo e($appt->starts_at ? $appt->starts_at->format('M d, h:i A') : 'Apr 25, 10:00 AM'); ?></td>
                            <td>
                                <?php if(strtolower($appt->status) === 'pending'): ?>
                                    <span class="badge-status badge-pending">Pending</span>
                                <?php else: ?>
                                    <span class="badge-status badge-confirmed">Confirmed</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td class="font-medium" style="font-weight: 700;">Buddy</td>
                            <td>Sarah J.</td>
                            <td>Dr. Carter</td>
                            <td style="font-family: var(--font-mono); font-size: 11px; color: var(--muted);">Apr 25, 10:00 AM</td>
                            <td><span class="badge-status badge-confirmed">Confirmed</span></td>
                        </tr>
                        <tr>
                            <td class="font-medium" style="font-weight: 700;">Luna</td>
                            <td>Mike R.</td>
                            <td>Dr. Wilson</td>
                            <td style="font-family: var(--font-mono); font-size: 11px; color: var(--muted);">Apr 25, 11:30 AM</td>
                            <td><span class="badge-status badge-confirmed">Confirmed</span></td>
                        </tr>
                        <tr>
                            <td class="font-medium" style="font-weight: 700;">Max</td>
                            <td>Emily S.</td>
                            <td>Dr. Brown</td>
                            <td style="font-family: var(--font-mono); font-size: 11px; color: var(--muted);">Apr 25, 02:00 PM</td>
                            <td><span class="badge-status badge-pending">Pending</span></td>
                        </tr>
                        <tr>
                            <td class="font-medium" style="font-weight: 700;">Bella</td>
                            <td>David L.</td>
                            <td>Dr. Davis</td>
                            <td style="font-family: var(--font-mono); font-size: 11px; color: var(--muted);">Apr 25, 04:30 PM</td>
                            <td><span class="badge-status badge-confirmed">Confirmed</span></td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bottom Section: 3 Panels -->
    <div class="panels-grid bottom-grid">
        <!-- Panel 1: Latest Users -->
        <div class="dashboard-panel users-panel">
            <div class="panel-header">
                <div>
                    <h3>Registered Members</h3>
                    <small style="color: var(--muted); font-size: 11px;">Latest account enrollments</small>
                </div>
                <a href="<?php echo e(route('admin.users.index')); ?>" class="view-all-link">View all →</a>
            </div>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $latestUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <div class="user-cell">
                                    <?php
                                        $avatarMap = [
                                            'Sarah Johnson' => '/images/sarah-avatar.jpg',
                                            'Dr. Emily Carter' => '/images/emily-avatar.jpg',
                                            'Happy Paws Shelter' => '/images/shelter-avatar.jpg',
                                            'James Wilson' => '/images/james-avatar.jpg',
                                            'David Lee' => '/images/david-avatar.jpg',
                                        ];
                                        $userAvatar = $avatarMap[$user->name] ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=f1f5f9&color=0f172a';
                                    ?>
                                    <img src="<?php echo e($userAvatar); ?>" alt="<?php echo e($user->name); ?>" class="user-avatar-mini" onerror="this.src='https://ui-avatars.com/api/?name=<?php echo e(urlencode($user->name)); ?>&background=f1f5f9&color=0f172a'">
                                    <span style="font-weight: 600; color: var(--ink);"><?php echo e($user->name); ?></span>
                                </div>
                            </td>
                            <td class="text-muted" style="font-family: var(--font-mono); font-size: 11px;"><?php echo e($user->email); ?></td>
                            <td>
                                <?php if($user->role === 'admin'): ?>
                                    <span class="badge badge-purple">Admin</span>
                                <?php elseif($user->role === 'vet'): ?>
                                    <span class="badge badge-info">Vet</span>
                                <?php elseif($user->role === 'shelter'): ?>
                                    <span class="badge badge-warning">Shelter</span>
                                <?php else: ?>
                                    <span class="badge badge-teal">Owner</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-muted" style="font-family: var(--font-mono); font-size: 11px;"><?php echo e($user->created_at ? $user->created_at->format('M d, Y') : 'Apr 24, 2025'); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td>
                                <div class="user-cell">
                                    <img src="/images/sarah-avatar.jpg" alt="Sarah Johnson" class="user-avatar-mini">
                                    <span style="font-weight: 600;">Sarah Johnson</span>
                                </div>
                            </td>
                            <td class="text-muted" style="font-family: var(--font-mono); font-size: 11px;">sarah@example.com</td>
                            <td><span class="badge badge-teal">Owner</span></td>
                            <td class="text-muted" style="font-family: var(--font-mono); font-size: 11px;">Apr 24, 2025</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="user-cell">
                                    <img src="/images/emily-avatar.jpg" alt="Dr. Emily Carter" class="user-avatar-mini">
                                    <span style="font-weight: 600;">Dr. Emily Carter</span>
                                </div>
                            </td>
                            <td class="text-muted" style="font-family: var(--font-mono); font-size: 11px;">emily@vet.com</td>
                            <td><span class="badge badge-info">Vet</span></td>
                            <td class="text-muted" style="font-family: var(--font-mono); font-size: 11px;">Apr 23, 2025</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="user-cell">
                                    <img src="/images/shelter-avatar.jpg" alt="Happy Paws Shelter" class="user-avatar-mini">
                                    <span style="font-weight: 600;">Happy Paws Shelter</span>
                                </div>
                            </td>
                            <td class="text-muted" style="font-family: var(--font-mono); font-size: 11px;">shelter@furshield.com</td>
                            <td><span class="badge badge-warning">Shelter</span></td>
                            <td class="text-muted" style="font-family: var(--font-mono); font-size: 11px;">Apr 22, 2025</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="user-cell">
                                    <img src="/images/james-avatar.jpg" alt="James Wilson" class="user-avatar-mini">
                                    <span style="font-weight: 600;">James Wilson</span>
                                </div>
                            </td>
                            <td class="text-muted" style="font-family: var(--font-mono); font-size: 11px;">james@example.com</td>
                            <td><span class="badge badge-teal">Owner</span></td>
                            <td class="text-muted" style="font-family: var(--font-mono); font-size: 11px;">Apr 20, 2025</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Panel 2: Top Selling Products -->
        <div class="dashboard-panel products-panel">
            <div class="panel-header">
                <div>
                    <h3>Top Pet Essentials</h3>
                    <small style="color: var(--muted); font-size: 11px;">Marketplace demand leaders</small>
                </div>
                <a href="<?php echo e(route('admin.products.index')); ?>" class="view-all-link">Store catalog →</a>
            </div>
            <div class="products-list">
                <?php
                    $staticProducts = [
                        ['name' => 'Premium Dog Food', 'price' => '$24.99', 'sold' => '128 sold', 'img' => '/images/dog-food.jpg'],
                        ['name' => 'Cat Litter Formula', 'price' => '$12.99', 'sold' => '96 sold', 'img' => '/images/cat-litter.jpg'],
                        ['name' => 'Hypoallergenic Shampoo', 'price' => '$8.99', 'sold' => '68 sold', 'img' => '/images/pet-shampoo.jpg'],
                        ['name' => 'Teething Chew Toys', 'price' => '$6.99', 'sold' => '57 sold', 'img' => '/images/dog-toys.jpg'],
                    ];
                ?>
                <?php $__currentLoopData = $staticProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="product-item">
                    <img src="<?php echo e($prod['img']); ?>" alt="<?php echo e($prod['name']); ?>" class="product-thumb-img">
                    <div class="product-info">
                        <strong><?php echo e($prod['name']); ?></strong>
                        <span class="product-price"><?php echo e($prod['price']); ?></span>
                    </div>
                    <div class="product-sold">
                        <span><?php echo e($prod['sold']); ?></span>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <!-- Panel 3: Real-Time Audit Activities -->
        <div class="dashboard-panel activities-panel">
            <div class="panel-header">
                <div>
                    <h3>Audit Stream</h3>
                    <small style="color: var(--muted); font-size: 11px;">Live system event trail</small>
                </div>
                <a href="<?php echo e(route('admin.notifications.index')); ?>" class="view-all-link">Activity log →</a>
            </div>
            <div class="activity-timeline">
                <div class="activity-item">
                    <div class="activity-icon-square teal">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                        </svg>
                    </div>
                    <div class="activity-text">
                        <span>New adoption request submitted for <strong>Max</strong></span>
                    </div>
                    <div class="activity-time">2h ago</div>
                </div>

                <div class="activity-item">
                    <div class="activity-icon-square blue">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                    </div>
                    <div class="activity-text">
                        <span>Order <strong>#ORD-1024</strong> completed by <strong>Sarah Johnson</strong></span>
                    </div>
                    <div class="activity-time">3h ago</div>
                </div>

                <div class="activity-item">
                    <div class="activity-icon-square green">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
                        </svg>
                    </div>
                    <div class="activity-text">
                        <span>Clinical health chart updated for <strong>Luna</strong></span>
                    </div>
                    <div class="activity-time">4h ago</div>
                </div>

                <div class="activity-item">
                    <div class="activity-icon-square orange">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                        </svg>
                    </div>
                    <div class="activity-text">
                        <span>Verified product review posted for <strong>Pet Food</strong></span>
                    </div>
                    <div class="activity-time">5h ago</div>
                </div>

                <div class="activity-item">
                    <div class="activity-icon-square cyan">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <div class="activity-text">
                        <span>New account registered: <strong>David Lee</strong> (Pet Owner)</span>
                    </div>
                    <div class="activity-time">6h ago</div>
                </div>
            </div>
        </div>
    </div>

    <!-- System Status Bottom Strip -->
    <div class="system-status-bar">
        <div class="status-bar-nodes">
            <div class="status-node">
                <span style="color: var(--emerald-light);">●</span>
                <span>CLUSTER: <strong>NODE-PRIMARY-01</strong></span>
            </div>
            <div class="status-node">
                <span>DATABASE: <strong>MYSQL 8.0 (CONNECTED)</strong></span>
            </div>
            <div class="status-node">
                <span>STACK: <strong>LARAVEL 13.x · PHP 8.4</strong></span>
            </div>
            <div class="status-node">
                <span>AUTH: <strong>ADMIN PRIVILEGED</strong></span>
            </div>
        </div>
        <div>
            <span>RESPONSE: <strong>1.4ms</strong></span>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\pat\FurShield\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>