<?php $__env->startSection('title', 'Rescue & Shelter Overview'); ?>

<?php $__env->startSection('content'); ?>
<div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
    <div>
        <h1 style="font-size: 1.85rem; font-weight: 800; color: #091a13; margin: 0 0 6px; letter-spacing: -0.02em;">
            Shelter Sanctuary Operations
        </h1>
        <p style="color: #64748b; font-size: 0.95rem; margin: 0;">
            Organization: <strong><?php echo e($shelter->organization_name); ?></strong> • Supporting verified pet rehoming & daily welfare.
        </p>
    </div>
    <div style="display: flex; align-items: center; gap: 10px;">
        <button type="button" class="btn-sm btn-emerald" onclick="openNewListingModal()">
            + Add Adoptable Animal
        </button>
        <a href="<?php echo e(route('shelter.care-logs')); ?>" class="btn-sm btn-outline">Log Daily Care ↗</a>
    </div>
</div>

<!-- 4 KPI Metrics -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 18px; margin-bottom: 28px;">
    <div class="card-surface" style="margin-bottom: 0; padding: 20px;">
        <span style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; font-family: var(--font-mono, monospace);">Total Rescues</span>
        <div style="font-size: 2.2rem; font-weight: 800; color: #091a13; margin-top: 8px;"><?php echo e($stats['total_rescues']); ?></div>
        <div style="font-size: 12px; color: #10b981; font-weight: 600; margin-top: 4px;">Sheltered Animals</div>
    </div>
    <div class="card-surface" style="margin-bottom: 0; padding: 20px;">
        <span style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; font-family: var(--font-mono, monospace);">Available for Adoption</span>
        <div style="font-size: 2.2rem; font-weight: 800; color: #091a13; margin-top: 8px;"><?php echo e($stats['available']); ?></div>
        <div style="font-size: 12px; color: #059669; font-weight: 600; margin-top: 4px;">Active in Public Gallery</div>
    </div>
    <div class="card-surface" style="margin-bottom: 0; padding: 20px;">
        <span style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; font-family: var(--font-mono, monospace);">Adoption Applications</span>
        <div style="font-size: 2.2rem; font-weight: 800; color: #091a13; margin-top: 8px;"><?php echo e($stats['pending_applications']); ?></div>
        <div style="font-size: 12px; color: #d97706; font-weight: 600; margin-top: 4px;">Pending Review</div>
    </div>
    <div class="card-surface" style="margin-bottom: 0; padding: 20px;">
        <span style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; font-family: var(--font-mono, monospace);">Recent Care Logs</span>
        <div style="font-size: 2.2rem; font-weight: 800; color: #091a13; margin-top: 8px;"><?php echo e($stats['care_logs_count']); ?></div>
        <div style="font-size: 12px; color: #64748b; font-weight: 600; margin-top: 4px;">Feeding / Grooming / Meds</div>
    </div>
</div>

<!-- Adoptable Animal Listings Table (SRS 1.6) -->
<div class="card-surface">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px;">
        <div>
            <h2 style="font-size: 1.25rem; font-weight: 800; color: #091a13; margin: 0 0 4px;">
                Adoptable Rescue Animals in Sanctuary
            </h2>
            <p style="font-size: 13px; color: #64748b; margin: 0;">
                Profiles published here appear in the FurShield public adoption portal.
            </p>
        </div>
        <a href="<?php echo e(route('shelter.listings')); ?>" class="btn-sm btn-outline">View All (<?php echo e($listings->count()); ?>)</a>
    </div>

    <div style="overflow-x: auto;">
        <table class="action-table">
            <thead>
                <tr>
                    <th>Animal Companion</th>
                    <th>Species & Breed</th>
                    <th>Age & Sex</th>
                    <th>Clinical Status</th>
                    <th>Adoption Status</th>
                    <th style="text-align: right;">Inquiries</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $listings->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $listing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <strong style="color: #091a13; font-size: 14px;"><?php echo e($listing->pet_name); ?></strong>
                            <div style="font-size: 11px; color: #64748b;">ID: #<?php echo e($listing->id); ?></div>
                        </td>
                        <td>
                            <span style="font-weight: 600; color: #334155;"><?php echo e($listing->species); ?></span>
                            <div style="font-size: 11px; color: #64748b;"><?php echo e($listing->breed); ?></div>
                        </td>
                        <td>
                            <div><?php echo e($listing->age_text); ?></div>
                            <div style="font-size: 11px; color: #64748b;"><?php echo e($listing->sex); ?></div>
                        </td>
                        <td>
                            <span style="font-size: 12px; color: #059669; font-weight: 600;"><?php echo e(Str::limit($listing->health_summary, 40)); ?></span>
                        </td>
                        <td>
                            <span class="status-pill status-<?php echo e($listing->status); ?>">
                                <?php echo e(ucfirst($listing->status)); ?>

                            </span>
                        </td>
                        <td style="text-align: right;">
                            <a href="<?php echo e(route('shelter.applications')); ?>" class="btn-sm btn-outline">
                                <?php echo e($listing->interests->count()); ?> Inquiries
                            </a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Recent Daily Care Logs (Feeding, Grooming, Medical Attention) (SRS 1.6) -->
<div class="card-surface">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
        <h2 style="font-size: 1.25rem; font-weight: 800; color: #091a13; margin: 0;">
            Daily Animal Welfare Care Activity Logs
        </h2>
        <a href="<?php echo e(route('shelter.care-logs')); ?>" class="btn-sm btn-emerald">+ Record New Log</a>
    </div>

    <?php if($recentCareLogs->isEmpty()): ?>
        <p style="color: #64748b; font-size: 13.5px; margin: 0;">No care logs recorded yet.</p>
    <?php else: ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px;">
            <?php $__currentLoopData = $recentCareLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div style="background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0; padding: 16px;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                        <span class="status-pill" style="background: #ecfdf5; color: #064e3b;">
                            <?php echo e(ucfirst($log->category)); ?>

                        </span>
                        <span style="font-size: 11px; font-family: var(--font-mono, monospace); color: #64748b;">
                            <?php echo e(\Carbon\Carbon::parse($log->logged_at)->diffForHumans()); ?>

                        </span>
                    </div>
                    <strong style="color: #091a13; font-size: 13.5px; display: block; margin-bottom: 4px;">
                        Patient: <?php echo e($log->listing?->pet_name ?? 'Companion'); ?>

                    </strong>
                    <p style="font-size: 12.5px; color: #475569; margin: 0; line-height: 1.4;"><?php echo e($log->notes); ?></p>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
</div>

<!-- Add Adoptable Animal Modal (SRS 1.6) -->
<div id="newListingModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 1000; align-items: center; justify-content: center; padding: 16px;">
    <div style="background: #ffffff; border-radius: 20px; max-width: 580px; width: 100%; padding: 28px; box-shadow: 0 20px 40px rgba(0,0,0,0.3); max-height: 90vh; overflow-y: auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px;">
            <h3 style="font-size: 1.3rem; font-weight: 800; color: #091a13; margin: 0;">
                List New Adoptable Companion
            </h3>
            <button type="button" onclick="closeNewListingModal()" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #64748b;">✕</button>
        </div>

        <form method="POST" action="<?php echo e(route('shelter.listings.store')); ?>">
            <?php echo csrf_field(); ?>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px;">
                <div>
                    <label style="display: block; font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Pet Name <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="pet_name" required class="owner-form-input" placeholder="e.g. Charlie" style="width: 100%;">
                </div>
                <div>
                    <label style="display: block; font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Species <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="species" required class="owner-form-input" placeholder="e.g. Dog, Cat, Bird" style="width: 100%;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px;">
                <div>
                    <label style="display: block; font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Breed <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="breed" required class="owner-form-input" placeholder="e.g. Golden Retriever" style="width: 100%;">
                </div>
                <div>
                    <label style="display: block; font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Age Representation <span style="color: #ef4444;">*</span></label>
                    <input type="text" name="age_text" required class="owner-form-input" placeholder="e.g. 2 Years" style="width: 100%;">
                </div>
            </div>

            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Gender / Sex <span style="color: #ef4444;">*</span></label>
                <select name="sex" class="owner-form-input" style="width: 100%;">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Unknown">Unknown</option>
                </select>
            </div>

            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Health & Vaccination Status</label>
                <input type="text" name="health_summary" class="owner-form-input" placeholder="e.g. Fully vaccinated, dewormed, neutered" style="width: 100%;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Care Routine & Temperament</label>
                <textarea name="care_summary" rows="3" class="owner-form-input" placeholder="e.g. Gentle with children, needs 30min daily walk, fond of squeaky toys..." style="width: 100%;"></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="closeNewListingModal()" class="btn-sm btn-outline">Cancel</button>
                <button type="submit" class="btn-sm btn-emerald">Publish to Adoption Gallery ✓</button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
function openNewListingModal() {
    document.getElementById('newListingModal').style.display = 'flex';
}
function closeNewListingModal() {
    document.getElementById('newListingModal').style.display = 'none';
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('shelter.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\pat\FurShield\resources\views/shelter/dashboard.blade.php ENDPATH**/ ?>