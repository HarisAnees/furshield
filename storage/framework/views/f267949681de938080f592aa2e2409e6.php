<?php $__env->startSection('title', 'Adoptable Animal Listings'); ?>

<?php $__env->startSection('content'); ?>
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
    <div>
        <h1 style="font-size: 1.85rem; font-weight: 800; color: #091a13; margin: 0 0 6px; letter-spacing: -0.02em;">
            Adoptable Companions Roster
        </h1>
        <p style="color: #64748b; font-size: 0.95rem; margin: 0;">
            Manage rescue animal profiles displayed in the public FurShield adoption portal.
        </p>
    </div>
    <div style="display: flex; gap: 10px;">
        <a href="<?php echo e(route('shelter.dashboard')); ?>" class="btn-sm btn-outline">← Back to Overview</a>
    </div>
</div>

<div class="card-surface">
    <?php if($listings->isEmpty()): ?>
        <div style="text-align: center; padding: 40px; color: #64748b;">
            <p>No adoptable listings currently created.</p>
        </div>
    <?php else: ?>
        <div style="overflow-x: auto;">
            <table class="action-table">
                <thead>
                    <tr>
                        <th>Listing ID</th>
                        <th>Companion Name</th>
                        <th>Species & Breed</th>
                        <th>Age / Sex</th>
                        <th>Health Summary</th>
                        <th>Status</th>
                        <th style="text-align: right;">Applications</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $listings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td style="font-family: var(--font-mono, monospace); font-weight: 700; color: #64748b;">
                                #<?php echo e($item->id); ?>

                            </td>
                            <td>
                                <strong style="color: #091a13; font-size: 14px;"><?php echo e($item->pet_name); ?></strong>
                            </td>
                            <td>
                                <span style="font-weight: 600; color: #1e293b;"><?php echo e($item->species); ?></span>
                                <div style="font-size: 11px; color: #64748b;"><?php echo e($item->breed); ?></div>
                            </td>
                            <td>
                                <div><?php echo e($item->age_text); ?></div>
                                <div style="font-size: 11px; color: #64748b;"><?php echo e($item->sex); ?></div>
                            </td>
                            <td style="font-size: 12px; color: #059669; font-weight: 500;">
                                <?php echo e(Str::limit($item->health_summary, 45)); ?>

                            </td>
                            <td>
                                <span class="status-pill status-<?php echo e($item->status); ?>">
                                    <?php echo e(ucfirst($item->status)); ?>

                                </span>
                            </td>
                            <td style="text-align: right;">
                                <a href="<?php echo e(route('shelter.applications')); ?>" class="btn-sm btn-outline">
                                    <?php echo e($item->interests->count()); ?> Inquiries ↗
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px;">
            <?php echo e($listings->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('shelter.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\pat\FurShield\resources\views/shelter/listings.blade.php ENDPATH**/ ?>