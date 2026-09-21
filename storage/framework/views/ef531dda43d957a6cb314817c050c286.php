<?php $__env->startSection('title', 'My Appointments'); ?>

<?php $__env->startSection('content'); ?>
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px; align-items: start;">
    <!-- Appointments List -->
    <div class="owner-subpage-card">
        <div class="owner-subpage-header">
            <div class="owner-subpage-title">
                <span>🩺</span> My Consultations & Clinic Visits
            </div>
            <button type="button" class="owner-btn owner-btn-primary" onclick="openOwnerModal('bookAptModal')">
                + Book Visit
            </button>
        </div>
        <div class="owner-subpage-body no-padding" style="padding: 0;">
            <div style="display: flex; flex-direction: column;">
                <?php $__empty_1 = true; $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $apt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div style="padding: 18px 24px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; gap: 16px;">
                        <div style="display: flex; align-items: center; gap: 14px;">
                            <div style="width: 46px; height: 46px; border-radius: 10px; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0;">
                                🐾
                            </div>
                            <div>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <strong style="font-size: 14px; color: #0f172a;"><?php echo e($apt->pet->name ?? 'My Pet'); ?></strong>
                                    <span style="font-size: 11px; font-weight: 600; padding: 2px 8px; border-radius: 12px;
                                        <?php if($apt->status === 'confirmed'): ?> background: #ccfbf1; color: #0f766e;
                                        <?php elseif($apt->status === 'completed'): ?> background: #dcfce7; color: #15803d;
                                        <?php elseif($apt->status === 'cancelled'): ?> background: #fee2e2; color: #b91c1c;
                                        <?php else: ?> background: #fef3c7; color: #b45309; <?php endif; ?>">
                                        <?php echo e(ucfirst($apt->status)); ?>

                                    </span>
                                </div>
                                <div style="font-size: 12.5px; color: #334155; margin-top: 3px;">
                                    <?php echo e($apt->reason); ?>

                                </div>
                                <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">
                                    Doctor: <strong><?php echo e($apt->vet->user->name ?? 'Dr. Specialist'); ?></strong> (<?php echo e($apt->vet->specialization ?? 'General Vet'); ?>)
                                </div>
                            </div>
                        </div>

                        <div style="text-align: right; flex-shrink: 0;">
                            <div style="font-size: 13px; font-weight: 700; color: #0f172a;">
                                <?php echo e(\Carbon\Carbon::parse($apt->starts_at)->format('M d, Y')); ?>

                            </div>
                            <div style="font-size: 12px; color: #10b981; font-weight: 600;">
                                <?php echo e(\Carbon\Carbon::parse($apt->starts_at)->format('h:i A')); ?>

                            </div>
                            <?php if(in_array($apt->status, ['scheduled', 'confirmed'])): ?>
                                <form method="POST" action="<?php echo e(route('owner.appointments.cancel', $apt)); ?>" onsubmit="return confirm('Cancel this appointment?');" style="margin-top: 6px;">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" style="background: none; border: none; font-size: 11px; color: #ef4444; font-weight: 600; cursor: pointer; text-decoration: underline;">
                                        Cancel Visit
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div style="text-align: center; padding: 40px; color: #64748b;">
                        <span style="font-size: 36px; display: block; margin-bottom: 8px;">📅</span>
                        <h4>No appointments yet</h4>
                        <p style="font-size: 12px;">Need a checkup or vaccination? Book your appointment online.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Quick Booking Card -->
    <div class="owner-subpage-card">
        <div class="owner-subpage-header">
            <div class="owner-subpage-title">
                <span>➕</span> Schedule Appointment
            </div>
        </div>
        <div class="owner-subpage-body">
            <form method="POST" action="<?php echo e(route('owner.appointments.book')); ?>">
                <?php echo csrf_field(); ?>
                <div style="margin-bottom: 14px;">
                    <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 4px;">Select Pet *</label>
                    <select name="pet_id" required style="width: 100%; padding: 8px 12px; border: 1px solid var(--border); border-radius: 8px;">
                        <?php $__currentLoopData = $pets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($pet->id); ?>"><?php echo e($pet->name); ?> (<?php echo e($pet->species); ?>)</option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div style="margin-bottom: 14px;">
                    <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 4px;">Select Veterinarian *</label>
                    <select name="vet_id" required style="width: 100%; padding: 8px 12px; border: 1px solid var(--border); border-radius: 8px;">
                        <?php $__currentLoopData = $vets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($vet->id); ?>"><?php echo e($vet->user->name ?? 'Dr. Emily Carter'); ?> — <?php echo e($vet->specialization ?? 'General Vet'); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div style="margin-bottom: 14px;">
                    <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 4px;">Date & Time *</label>
                    <input type="datetime-local" name="starts_at" required style="width: 100%; padding: 8px 12px; border: 1px solid var(--border); border-radius: 8px;" value="<?php echo e(date('Y-m-d\TH:i', strtotime('+1 day 10:00'))); ?>">
                </div>
                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 4px;">Reason for Visit *</label>
                    <input type="text" name="reason" required placeholder="e.g. Annual Vaccination or Routine Checkup" style="width: 100%; padding: 8px 12px; border: 1px solid var(--border); border-radius: 8px;">
                </div>
                <button type="submit" class="owner-btn owner-btn-primary" style="width: 100%;">
                    Confirm Booking
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Modal Alternative for Mobile -->
<div class="owner-modal-overlay" id="bookAptModal">
    <div class="owner-modal-box">
        <div class="owner-modal-header">
            <h3>Schedule Clinic Visit</h3>
            <button class="owner-modal-close" onclick="closeOwnerModal('bookAptModal')">&times;</button>
        </div>
        <form method="POST" action="<?php echo e(route('owner.appointments.book')); ?>">
            <?php echo csrf_field(); ?>
            <div class="owner-modal-body">
                <div style="margin-bottom: 14px;">
                    <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 4px;">Select Pet *</label>
                    <select name="pet_id" required style="width: 100%; padding: 8px 12px; border: 1px solid var(--border); border-radius: 8px;">
                        <?php $__currentLoopData = $pets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($pet->id); ?>"><?php echo e($pet->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div style="margin-bottom: 14px;">
                    <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 4px;">Select Doctor *</label>
                    <select name="vet_id" required style="width: 100%; padding: 8px 12px; border: 1px solid var(--border); border-radius: 8px;">
                        <?php $__currentLoopData = $vets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($vet->id); ?>"><?php echo e($vet->user->name ?? 'Dr. Specialist'); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div style="margin-bottom: 14px;">
                    <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 4px;">Date & Time *</label>
                    <input type="datetime-local" name="starts_at" required style="width: 100%; padding: 8px 12px; border: 1px solid var(--border); border-radius: 8px;" value="<?php echo e(date('Y-m-d\TH:i', strtotime('+1 day 10:00'))); ?>">
                </div>
                <div style="margin-bottom: 14px;">
                    <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 4px;">Reason *</label>
                    <input type="text" name="reason" required placeholder="e.g. Physical examination" style="width: 100%; padding: 8px 12px; border: 1px solid var(--border); border-radius: 8px;">
                </div>
            </div>
            <div class="owner-modal-footer">
                <button type="button" class="owner-btn owner-btn-secondary" onclick="closeOwnerModal('bookAptModal')">Cancel</button>
                <button type="submit" class="owner-btn owner-btn-primary">Book Appointment</button>
            </div>
        </form>
    </div>
</div>

<script>
function openOwnerModal(id) { document.getElementById(id).classList.add('active'); }
function closeOwnerModal(id) { document.getElementById(id).classList.remove('active'); }
document.querySelectorAll('.owner-modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) overlay.classList.remove('active');
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('owner.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\pat\FurShield\resources\views/owner/appointments/index.blade.php ENDPATH**/ ?>