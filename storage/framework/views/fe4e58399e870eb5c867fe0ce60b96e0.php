<?php $__env->startSection('title', 'Adopter Applications & Coordination'); ?>

<?php $__env->startSection('content'); ?>
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
    <div>
        <h1 style="font-size: 1.85rem; font-weight: 800; color: #091a13; margin: 0 0 6px; letter-spacing: -0.02em;">
            Adopter Coordination & Interest Applications
        </h1>
        <p style="color: #64748b; font-size: 0.95rem; margin: 0;">
            Review incoming adoption inquiries submitted by prospective pet owners and finalize adoption status.
        </p>
    </div>
    <a href="<?php echo e(route('shelter.dashboard')); ?>" class="btn-sm btn-outline">← Back to Overview</a>
</div>

<div class="card-surface">
    <?php if($applications->isEmpty()): ?>
        <div style="text-align: center; padding: 40px; color: #64748b;">
            <p>No adoption applications submitted yet.</p>
        </div>
    <?php else: ?>
        <div style="overflow-x: auto;">
            <table class="action-table">
                <thead>
                    <tr>
                        <th>Date Submitted</th>
                        <th>Applicant Details</th>
                        <th>Target Companion</th>
                        <th>Applicant Statement / Note</th>
                        <th>Status</th>
                        <th style="text-align: right;">Update Decision</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $applications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td style="font-family: var(--font-mono, monospace); font-size: 12px; color: #475569;">
                                <?php echo e(\Carbon\Carbon::parse($app->created_at)->format('M d, Y')); ?>

                            </td>
                            <td>
                                <strong style="color: #091a13;"><?php echo e($app->user?->name ?? 'Prospective Adopter'); ?></strong>
                                <div style="font-size: 11px; color: #64748b;"><?php echo e($app->user?->email ?? 'adopter@example.com'); ?></div>
                                <div style="font-size: 11px; color: #64748b;"><?php echo e($app->user?->phone ?? 'Contact available'); ?></div>
                            </td>
                            <td>
                                <strong style="color: #059669;"><?php echo e($app->listing?->pet_name ?? 'Sanctuary Animal'); ?></strong>
                                <div style="font-size: 11px; color: #64748b;"><?php echo e($app->listing?->species); ?> • <?php echo e($app->listing?->breed); ?></div>
                            </td>
                            <td style="font-size: 12.5px; color: #334155; max-width: 280px;">
                                "<?php echo e($app->message ?? 'I am very interested in providing a loving forever home.'); ?>"
                            </td>
                            <td>
                                <span class="status-pill status-<?php echo e($app->status); ?>">
                                    <?php echo e(ucfirst($app->status)); ?>

                                </span>
                            </td>
                            <td style="text-align: right;">
                                <form method="POST" action="<?php echo e(route('shelter.applications.status', $app)); ?>" style="display: inline-flex; gap: 6px; align-items: center;">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PATCH'); ?>
                                    <select name="status" class="owner-form-input" style="font-size: 12px; padding: 4px 8px; width: auto;">
                                        <option value="pending" <?php echo e($app->status === 'pending' ? 'selected' : ''); ?>>Pending</option>
                                        <option value="approved" <?php echo e($app->status === 'approved' ? 'selected' : ''); ?>>Approve</option>
                                        <option value="adopted" <?php echo e($app->status === 'adopted' ? 'selected' : ''); ?>>Finalize Adopted</option>
                                        <option value="rejected" <?php echo e($app->status === 'rejected' ? 'selected' : ''); ?>>Decline</option>
                                    </select>
                                    <button type="submit" class="btn-sm btn-emerald">Save</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px;">
            <?php echo e($applications->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('shelter.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\pat\FurShield\resources\views/shelter/applications.blade.php ENDPATH**/ ?>