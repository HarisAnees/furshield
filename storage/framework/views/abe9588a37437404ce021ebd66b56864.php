<?php $__env->startSection('title', 'Daily Animal Care Logs'); ?>

<?php $__env->startSection('content'); ?>
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
    <div>
        <h1 style="font-size: 1.85rem; font-weight: 800; color: #091a13; margin: 0 0 6px; letter-spacing: -0.02em;">
            Daily Animal Welfare Care Logs
        </h1>
        <p style="color: #64748b; font-size: 0.95rem; margin: 0;">
            Track scheduled feeding, grooming routines, exercise, and medical attention logs for sanctuary animals.
        </p>
    </div>
    <div style="display: flex; gap: 10px;">
        <button type="button" class="btn-sm btn-emerald" onclick="openCareLogModal()">
            + Log Care Activity
        </button>
        <a href="<?php echo e(route('shelter.dashboard')); ?>" class="btn-sm btn-outline">← Back to Overview</a>
    </div>
</div>

<div class="card-surface">
    <?php if($logs->isEmpty()): ?>
        <div style="text-align: center; padding: 40px; color: #64748b;">
            <p>No care logs recorded yet. Click above to record a new care activity.</p>
        </div>
    <?php else: ?>
        <div style="overflow-x: auto;">
            <table class="action-table">
                <thead>
                    <tr>
                        <th>Time Logged</th>
                        <th>Sheltered Companion</th>
                        <th>Category</th>
                        <th>Care Notes & Observations</th>
                        <th>Staff Attendant</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td style="font-family: var(--font-mono, monospace); font-size: 12px; color: #475569;">
                                <?php echo e(\Carbon\Carbon::parse($log->logged_at)->format('M d, Y • h:i A')); ?>

                            </td>
                            <td>
                                <strong style="color: #091a13;"><?php echo e($log->listing?->pet_name ?? 'Sanctuary Companion'); ?></strong>
                                <div style="font-size: 11px; color: #64748b;"><?php echo e($log->listing?->species ?? 'Pet'); ?> • <?php echo e($log->listing?->breed ?? 'Domestic'); ?></div>
                            </td>
                            <td>
                                <span class="status-pill" style="background: #ecfdf5; color: #064e3b; text-transform: uppercase;">
                                    <?php echo e($log->category); ?>

                                </span>
                            </td>
                            <td style="font-size: 13px; color: #334155;">
                                <?php echo e($log->notes); ?>

                            </td>
                            <td style="font-size: 12px; color: #64748b;">
                                <?php echo e($log->creator?->name ?? 'Shelter Staff'); ?>

                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px;">
            <?php echo e($logs->links()); ?>

        </div>
    <?php endif; ?>
</div>

<!-- Modal for Recording Daily Care -->
<div id="careLogModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 1000; align-items: center; justify-content: center; padding: 16px;">
    <div style="background: #ffffff; border-radius: 20px; max-width: 520px; width: 100%; padding: 28px; box-shadow: 0 20px 40px rgba(0,0,0,0.3);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px;">
            <h3 style="font-size: 1.3rem; font-weight: 800; color: #091a13; margin: 0;">
                Record Daily Animal Care Activity
            </h3>
            <button type="button" onclick="closeCareLogModal()" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #64748b;">✕</button>
        </div>

        <form method="POST" action="<?php echo e(route('shelter.care-logs.store')); ?>">
            <?php echo csrf_field(); ?>
            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Select Animal Companion <span style="color: #ef4444;">*</span></label>
                <select name="adoption_listing_id" required class="owner-form-input" style="width: 100%;">
                    <?php $__currentLoopData = $listings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($item->id); ?>"><?php echo e($item->pet_name); ?> (<?php echo e($item->species); ?> - <?php echo e($item->breed); ?>)</option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Activity Category <span style="color: #ef4444;">*</span></label>
                <select name="category" required class="owner-form-input" style="width: 100%;">
                    <option value="feeding">Feeding (Dietary protocol, meal intake)</option>
                    <option value="grooming">Grooming (Brushing, bath, coat check)</option>
                    <option value="medical">Medical Attention (Medication, exam, vitals)</option>
                    <option value="exercise">Exercise & Enrichment (Play session, walk)</option>
                    <option value="general">General Observation</option>
                </select>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Notes & Care Observations <span style="color: #ef4444;">*</span></label>
                <textarea name="notes" rows="3" required class="owner-form-input" placeholder="e.g. Ate full morning kibble portion eagerly. Clean water refreshed." style="width: 100%;"></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="closeCareLogModal()" class="btn-sm btn-outline">Cancel</button>
                <button type="submit" class="btn-sm btn-emerald">Save Care Log ✓</button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
function openCareLogModal() {
    document.getElementById('careLogModal').style.display = 'flex';
}
function closeCareLogModal() {
    document.getElementById('careLogModal').style.display = 'none';
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('shelter.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\pat\FurShield\resources\views/shelter/care_logs.blade.php ENDPATH**/ ?>