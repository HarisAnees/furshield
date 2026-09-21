<?php $__env->startSection('title', 'Pet Owner Dashboard — FurShield'); ?>

<?php $__env->startSection('content'); ?>
<div style="display: flex; flex-direction: column; gap: 32px;">

    <!-- 1. Editorial Welcome Header -->
    <div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 16px;">
        <div>
            <div style="font-family: var(--font-mono); font-size: 11px; text-transform: uppercase; letter-spacing: 0.12em; color: var(--muted); margin-bottom: 6px;">
                Pet Owner Dashboard / Overview
            </div>
            <h1 style="font-size: 2.2rem; font-weight: 800; letter-spacing: -0.03em; color: var(--ink);">
                Good Day, <em><?php echo e(auth()->user()->name ?? 'Sarah'); ?></em>
            </h1>
            <p style="color: var(--muted); font-size: 0.95rem; margin-top: 4px;">
                Here is the verified health status, appointments and care logs for your pets.
            </p>
        </div>

        <div style="display: flex; gap: 10px;">
            <a href="<?php echo e(route('owner.appointments')); ?>" class="owner-btn owner-btn-primary">
                <span>+ Book Vet Visit</span>
            </a>
            <a href="<?php echo e(route('owner.pets')); ?>" class="owner-btn owner-btn-secondary">
                <span>Manage Pets</span>
            </a>
        </div>
    </div>

    <!-- 2. Minimalist Stat Cards Grid -->
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
        
        <!-- Stat 1: Registered Pets -->
        <div class="owner-subpage-card" style="padding: 24px;">
            <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 12px;">
                <span style="font-family: var(--font-mono); font-size: 11px; text-transform: uppercase; letter-spacing: 0.1em; color: var(--muted);">
                    01 / My Pets
                </span>
                <span style="font-size: 14px;">🐾</span>
            </div>
            <div style="font-family: var(--font-mono); font-size: 2.6rem; font-weight: 800; color: var(--ink); line-height: 1; margin-bottom: 12px;">
                <?php echo e($stats['pets'] ?? 2); ?>

            </div>
            <a href="<?php echo e(route('owner.pets')); ?>" style="font-size: 12.5px; font-weight: 600; color: var(--emerald-dark); display: inline-flex; align-items: center; gap: 4px;">
                <span>View registered companions</span>
                <span>→</span>
            </a>
        </div>

        <!-- Stat 2: Upcoming Appointments -->
        <div class="owner-subpage-card" style="padding: 24px;">
            <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 12px;">
                <span style="font-family: var(--font-mono); font-size: 11px; text-transform: uppercase; letter-spacing: 0.1em; color: var(--muted);">
                    02 / Appointments
                </span>
                <span style="font-size: 14px;">📅</span>
            </div>
            <div style="font-family: var(--font-mono); font-size: 2.6rem; font-weight: 800; color: var(--ink); line-height: 1; margin-bottom: 12px;">
                <?php echo e($stats['upcoming_appointments'] ?? 1); ?>

            </div>
            <a href="<?php echo e(route('owner.appointments')); ?>" style="font-size: 12.5px; font-weight: 600; color: var(--emerald-dark); display: inline-flex; align-items: center; gap: 4px;">
                <span>Consultation schedule</span>
                <span>→</span>
            </a>
        </div>

        <!-- Stat 3: Care Protocols -->
        <div class="owner-subpage-card" style="padding: 24px;">
            <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 12px;">
                <span style="font-family: var(--font-mono); font-size: 11px; text-transform: uppercase; letter-spacing: 0.1em; color: var(--muted);">
                    03 / Reminders
                </span>
                <span style="font-size: 14px;">🔔</span>
            </div>
            <div style="font-family: var(--font-mono); font-size: 2.6rem; font-weight: 800; color: var(--ink); line-height: 1; margin-bottom: 12px;">
                3
            </div>
            <a href="<?php echo e(route('owner.pets')); ?>" style="font-size: 12.5px; font-weight: 600; color: var(--emerald-dark); display: inline-flex; align-items: center; gap: 4px;">
                <span>Pending vaccinations</span>
                <span>→</span>
            </a>
        </div>

    </div>

    <!-- 3. Lower Two-Column Section (Activity Feed + Ecosystem Guidance) -->
    <div style="display: grid; grid-template-columns: 1.35fr 0.65fr; gap: 24px; align-items: start;">
        
        <!-- Left: Recent Activity Feed -->
        <div class="owner-subpage-card">
            <div class="owner-subpage-header">
                <div class="owner-subpage-title">
                    Recent Care Activity
                </div>
                <span style="font-family: var(--font-mono); font-size: 11px; color: var(--muted);">RECORD LOG</span>
            </div>

            <div style="display: flex; flex-direction: column;">
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 18px 28px; border-bottom: 1px solid var(--border);">
                    <div style="display: flex; align-items: center; gap: 14px;">
                        <div style="width: 38px; height: 38px; border-radius: 50%; background: var(--paper-subtle); display: flex; align-items: center; justify-content: center; font-size: 16px;">
                            📅
                        </div>
                        <div>
                            <strong style="display: block; font-size: 13.5px; color: var(--ink); margin-bottom: 2px;">Appointment Confirmed</strong>
                            <span style="font-size: 12px; color: var(--muted);">Buddy • Routine Preventive Checkup</span>
                        </div>
                    </div>
                    <span style="font-family: var(--font-mono); font-size: 11px; color: var(--emerald-dark); font-weight: 600;">ACTIVE</span>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; padding: 18px 28px; border-bottom: 1px solid var(--border);">
                    <div style="display: flex; align-items: center; gap: 14px;">
                        <div style="width: 38px; height: 38px; border-radius: 50%; background: var(--paper-subtle); display: flex; align-items: center; justify-content: center; font-size: 16px;">
                            🩺
                        </div>
                        <div>
                            <strong style="display: block; font-size: 13.5px; color: var(--ink); margin-bottom: 2px;">Health Record Updated</strong>
                            <span style="font-size: 12px; color: var(--muted);">Luna • Annual Rabies Booster</span>
                        </div>
                    </div>
                    <span style="font-family: var(--font-mono); font-size: 11px; color: var(--muted);">DOCUMENTED</span>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; padding: 18px 28px;">
                    <div style="display: flex; align-items: center; gap: 14px;">
                        <div style="width: 38px; height: 38px; border-radius: 50%; background: var(--paper-subtle); display: flex; align-items: center; justify-content: center; font-size: 16px;">
                            📦
                        </div>
                        <div>
                            <strong style="display: block; font-size: 13.5px; color: var(--ink); margin-bottom: 2px;">Order Dispatched</strong>
                            <span style="font-size: 12px; color: var(--muted);">Premium Dog Food • Standard Delivery</span>
                        </div>
                    </div>
                    <span style="font-family: var(--font-mono); font-size: 11px; color: var(--emerald-dark); font-weight: 600;">DELIVERED</span>
                </div>
            </div>
        </div>

        <!-- Right: Ecosystem Summary Card -->
        <div class="owner-subpage-card" style="padding: 28px; background: var(--white); display: flex; flex-direction: column; justify-content: space-between; gap: 20px;">
            <div>
                <div style="font-family: var(--font-mono); font-size: 10px; text-transform: uppercase; letter-spacing: 0.12em; color: var(--emerald); margin-bottom: 8px;">
                    CLINICAL ARCHITECTURE
                </div>
                <h3 style="font-size: 1.25rem; font-weight: 800; letter-spacing: -0.02em; margin-bottom: 10px;">
                    Every Paw Deserves a <em>Shield of Love.</em>
                </h3>
                <p style="font-size: 0.9rem; color: var(--muted); line-height: 1.6;">
                    Connect with certified clinics, track electronic medical records, and order everyday nutrition formulated for your pets.
                </p>
            </div>

            <a href="<?php echo e(route('home')); ?>" class="owner-btn owner-btn-primary" style="justify-content: center; width: 100%;">
                <span>Visit Main Platform ↗</span>
            </a>
        </div>

    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('owner.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\pat\FurShield\resources\views/owner/dashboard.blade.php ENDPATH**/ ?>