<?php $__env->startSection('title', 'Patient Bookings & Appointments'); ?>

<?php $__env->startSection('content'); ?>
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
    <div>
        <h1 style="font-size: 1.85rem; font-weight: 800; color: #091a13; margin: 0 0 6px; letter-spacing: -0.02em;">
            Patient Bookings & Clinical Consultations
        </h1>
        <p style="color: #64748b; font-size: 0.95rem; margin: 0;">
            Manage incoming appointment requests, approve schedules, and document treatment observations.
        </p>
    </div>
    <a href="<?php echo e(route('vet.dashboard')); ?>" class="btn-sm btn-outline">← Back to Overview</a>
</div>

<div class="card-surface">
    <?php if($appointments->isEmpty()): ?>
        <div style="text-align: center; padding: 40px; color: #64748b;">
            <p>No appointments registered yet.</p>
        </div>
    <?php else: ?>
        <div style="overflow-x: auto;">
            <table class="action-table">
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Patient Companion</th>
                        <th>Guardian</th>
                        <th>Reason / Symptoms</th>
                        <th>Date & Time</th>
                        <th>Status</th>
                        <th style="text-align: right;">Manage</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td style="font-family: var(--font-mono, monospace); font-weight: 700; color: #64748b;">
                                #<?php echo e($appt->id); ?>

                            </td>
                            <td>
                                <strong style="color: #091a13;"><?php echo e($appt->pet?->name ?? 'Companion Pet'); ?></strong>
                                <div style="font-size: 11px; color: #64748b;"><?php echo e($appt->pet?->species ?? 'Pet'); ?> • <?php echo e($appt->pet?->breed ?? 'Domestic'); ?></div>
                            </td>
                            <td>
                                <div><?php echo e($appt->user?->name ?? 'Sarah Johnson'); ?></div>
                                <div style="font-size: 11px; color: #64748b;"><?php echo e($appt->user?->email ?? 'owner@example.com'); ?></div>
                            </td>
                            <td>
                                <div style="font-weight: 600; color: #1e293b;"><?php echo e($appt->reason ?? 'Clinical Consult'); ?></div>
                                <?php if($appt->symptoms): ?>
                                    <div style="font-size: 11px; color: #64748b;"><?php echo e(Str::limit($appt->symptoms, 45)); ?></div>
                                <?php endif; ?>
                            </td>
                            <td style="font-family: var(--font-mono, monospace); font-size: 12px; color: #475569;">
                                <?php echo e($appt->starts_at ? \Carbon\Carbon::parse($appt->starts_at)->format('M d, Y • h:i A') : 'TBD'); ?>

                            </td>
                            <td>
                                <span class="status-pill status-<?php echo e($appt->status); ?>">
                                    <?php echo e(ucfirst($appt->status)); ?>

                                </span>
                            </td>
                            <td style="text-align: right;">
                                <div style="display: inline-flex; gap: 6px; align-items: center;">
                                    <?php if($appt->status === 'pending'): ?>
                                        <form method="POST" action="<?php echo e(route('vet.appointments.status', $appt)); ?>" style="display: inline;">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PATCH'); ?>
                                            <input type="hidden" name="status" value="confirmed">
                                            <button type="submit" class="btn-sm btn-emerald">Approve</button>
                                        </form>
                                    <?php endif; ?>

                                    <?php if($appt->status !== 'completed' && $appt->status !== 'cancelled'): ?>
                                        <form method="POST" action="<?php echo e(route('vet.appointments.status', $appt)); ?>" style="display: inline;">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PATCH'); ?>
                                            <input type="hidden" name="status" value="cancelled">
                                            <button type="submit" class="btn-sm btn-danger" onclick="return confirm('Cancel this appointment?')">Cancel</button>
                                        </form>
                                    <?php endif; ?>

                                    <button type="button" class="btn-sm btn-outline" onclick="openTreatmentModal('<?php echo e($appt->id); ?>', '<?php echo e(addslashes($appt->pet?->name ?? 'Companion')); ?>', '<?php echo e(addslashes($appt->symptoms ?? '')); ?>', '<?php echo e(addslashes($appt->diagnosis ?? '')); ?>', '<?php echo e(addslashes($appt->medication ?? '')); ?>', '<?php echo e(addslashes($appt->follow_up_notes ?? '')); ?>')">
                                        Treatment Notes ↗
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px;">
            <?php echo e($appointments->links()); ?>

        </div>
    <?php endif; ?>
</div>

<!-- Treatment Notes Modal -->
<div id="treatmentModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 1000; align-items: center; justify-content: center; padding: 16px;">
    <div style="background: #ffffff; border-radius: 20px; max-width: 560px; width: 100%; padding: 28px; box-shadow: 0 20px 40px rgba(0,0,0,0.3); max-height: 90vh; overflow-y: auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px;">
            <h3 style="font-size: 1.3rem; font-weight: 800; color: #091a13; margin: 0;">
                Log Clinical Treatment for <span id="modalPetName" style="color: #10b981;">Companion</span>
            </h3>
            <button type="button" onclick="closeTreatmentModal()" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #64748b;">✕</button>
        </div>

        <form id="treatmentForm" method="POST" action="">
            <?php echo csrf_field(); ?>
            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Observed Symptoms</label>
                <input type="text" name="symptoms" id="modalSymptoms" class="owner-form-input" placeholder="e.g. Lethargy, cough, paw irritation" style="width: 100%;">
            </div>

            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Clinical Diagnosis <span style="color: #ef4444;">*</span></label>
                <input type="text" name="diagnosis" id="modalDiagnosis" required class="owner-form-input" placeholder="e.g. Mild respiratory infection" style="width: 100%;">
            </div>

            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Prescribed Medication & Dosage</label>
                <textarea name="medication" id="modalMedication" rows="2" class="owner-form-input" placeholder="e.g. Antibiotic syrup 5ml daily for 5 days" style="width: 100%;"></textarea>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Follow-up Actions & Care Advice</label>
                <textarea name="follow_up_notes" id="modalNotes" rows="3" class="owner-form-input" placeholder="e.g. Rest and review in 10 days." style="width: 100%;"></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="closeTreatmentModal()" class="btn-sm btn-outline">Cancel</button>
                <button type="submit" class="btn-sm btn-emerald">Save & Complete Treatment ✓</button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
function openTreatmentModal(apptId, petName, symptoms, diagnosis, medication, notes) {
    document.getElementById('treatmentForm').action = '/vet/appointments/' + apptId + '/treatment';
    document.getElementById('modalPetName').textContent = petName;
    document.getElementById('modalSymptoms').value = symptoms || '';
    document.getElementById('modalDiagnosis').value = diagnosis || '';
    document.getElementById('modalMedication').value = medication || '';
    document.getElementById('modalNotes').value = notes || '';
    document.getElementById('treatmentModal').style.display = 'flex';
}
function closeTreatmentModal() {
    document.getElementById('treatmentModal').style.display = 'none';
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('vet.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\pat\FurShield\resources\views/vet/appointments.blade.php ENDPATH**/ ?>