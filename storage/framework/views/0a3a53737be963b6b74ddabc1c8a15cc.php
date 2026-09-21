<?php $__env->startSection('title', 'Clinical Overview'); ?>

<?php $__env->startSection('content'); ?>
<div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
    <div>
        <h1 style="font-size: 1.85rem; font-weight: 800; color: #091a13; margin: 0 0 6px; letter-spacing: -0.02em;">
            Veterinary Clinical Overview
        </h1>
        <p style="color: #64748b; font-size: 0.95rem; margin: 0;">
            Welcome back, <strong><?php echo e($user->name); ?></strong>. Managing practice at <strong><?php echo e($vet->clinic_name); ?></strong>.
        </p>
    </div>
    <div style="display: flex; align-items: center; gap: 10px;">
        <span class="status-pill <?php echo e($vet->is_available ? 'status-confirmed' : 'status-cancelled'); ?>">
            <?php echo e($vet->is_available ? '● Available for Consults' : '○ Practice Offline'); ?>

        </span>
        <a href="<?php echo e(route('vet.profile')); ?>" class="btn-sm btn-outline">Edit Practice Profile ↗</a>
    </div>
</div>

<!-- 4 Top KPI Stat Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 18px; margin-bottom: 28px;">
    <div class="card-surface" style="margin-bottom: 0; padding: 20px;">
        <span style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; font-family: var(--font-mono, monospace);">Upcoming Bookings</span>
        <div style="font-size: 2.2rem; font-weight: 800; color: #091a13; margin-top: 8px;"><?php echo e($stats['upcoming']); ?></div>
        <div style="font-size: 12px; color: #10b981; font-weight: 600; margin-top: 4px;">Awaiting & Confirmed</div>
    </div>
    <div class="card-surface" style="margin-bottom: 0; padding: 20px;">
        <span style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; font-family: var(--font-mono, monospace);">Active Patient Pets</span>
        <div style="font-size: 2.2rem; font-weight: 800; color: #091a13; margin-top: 8px;"><?php echo e($stats['total_patients']); ?></div>
        <div style="font-size: 12px; color: #059669; font-weight: 600; margin-top: 4px;">Registered Companions</div>
    </div>
    <div class="card-surface" style="margin-bottom: 0; padding: 20px;">
        <span style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; font-family: var(--font-mono, monospace);">Completed Consults</span>
        <div style="font-size: 2.2rem; font-weight: 800; color: #091a13; margin-top: 8px;"><?php echo e($stats['completed_today']); ?></div>
        <div style="font-size: 12px; color: #64748b; font-weight: 600; margin-top: 4px;">Documented Today</div>
    </div>
    <div class="card-surface" style="margin-bottom: 0; padding: 20px;">
        <span style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; font-family: var(--font-mono, monospace);">Clinical Specialization</span>
        <div style="font-size: 1.15rem; font-weight: 800; color: #091a13; margin-top: 10px; line-height: 1.3;"><?php echo e($vet->specialization); ?></div>
        <div style="font-size: 12px; color: #64748b; font-weight: 600; margin-top: 4px;"><?php echo e($vet->experience_years); ?> Years Clinical Exp</div>
    </div>
</div>

<!-- Patient Appointments Table (SRS 1.6) -->
<div class="card-surface">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px;">
        <div>
            <h2 style="font-size: 1.25rem; font-weight: 800; color: #091a13; margin: 0 0 4px;">
                Scheduled Consultations & Patient Treatments
            </h2>
            <p style="font-size: 13px; color: #64748b; margin: 0;">
                Review upcoming bookings, log diagnosis & prescriptions, and update booking status.
            </p>
        </div>
        <a href="<?php echo e(route('vet.appointments')); ?>" class="btn-sm btn-outline">View All (<?php echo e($appointments->count()); ?>)</a>
    </div>

    <?php if($appointments->isEmpty()): ?>
        <div style="text-align: center; padding: 36px 20px; color: #64748b;">
            <p style="margin: 0; font-size: 14px;">No appointments currently scheduled with your clinic.</p>
        </div>
    <?php else: ?>
        <div style="overflow-x: auto;">
            <table class="action-table">
                <thead>
                    <tr>
                        <th>Patient Companion</th>
                        <th>Owner Guardian</th>
                        <th>Consultation Reason</th>
                        <th>Scheduled Time</th>
                        <th>Status</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $appointments->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <strong style="color: #091a13; font-size: 14px;"><?php echo e($appt->pet?->name ?? 'Companion Pet'); ?></strong>
                                <div style="font-size: 11px; color: #64748b;">
                                    <?php echo e($appt->pet?->species ?? 'Canine'); ?> • <?php echo e($appt->pet?->breed ?? 'Domestic'); ?>

                                </div>
                            </td>
                            <td>
                                <div><?php echo e($appt->user?->name ?? 'Sarah Johnson'); ?></div>
                                <div style="font-size: 11px; color: #64748b;"><?php echo e($appt->user?->phone ?? '+1 555-0144'); ?></div>
                            </td>
                            <td>
                                <span style="font-weight: 600; color: #334155;"><?php echo e($appt->reason ?? 'Routine Wellness Check'); ?></span>
                                <?php if($appt->symptoms): ?>
                                    <div style="font-size: 11px; color: #64748b; margin-top: 2px;">
                                        <em>Symptoms:</em> <?php echo e(Str::limit($appt->symptoms, 50)); ?>

                                    </div>
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
                                            <button type="submit" class="btn-sm btn-emerald" title="Confirm Booking">
                                                Approve
                                            </button>
                                        </form>
                                    <?php endif; ?>

                                    <button type="button" class="btn-sm btn-outline" onclick="openTreatmentModal('<?php echo e($appt->id); ?>', '<?php echo e(addslashes($appt->pet?->name ?? 'Companion')); ?>', '<?php echo e(addslashes($appt->symptoms ?? '')); ?>', '<?php echo e(addslashes($appt->diagnosis ?? '')); ?>', '<?php echo e(addslashes($appt->medication ?? '')); ?>', '<?php echo e(addslashes($appt->follow_up_notes ?? '')); ?>')">
                                        Log Treatment ↗
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<!-- Recent Patient Health Records Timeline (SRS 1.6) -->
<div class="card-surface">
    <h2 style="font-size: 1.25rem; font-weight: 800; color: #091a13; margin: 0 0 16px;">
        Recent Clinical Health Passports & Treatments Logged
    </h2>

    <?php if($recentRecords->isEmpty()): ?>
        <p style="color: #64748b; font-size: 13.5px; margin: 0;">No health records recorded yet.</p>
    <?php else: ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px;">
            <?php $__currentLoopData = $recentRecords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div style="background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0; padding: 16px;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px;">
                        <strong style="color: #091a13; font-size: 14px;"><?php echo e($rec->pet?->name ?? 'Companion'); ?></strong>
                        <span style="font-size: 11px; font-family: var(--font-mono, monospace); color: #64748b;">
                            <?php echo e(\Carbon\Carbon::parse($rec->recorded_at)->format('M d, Y')); ?>

                        </span>
                    </div>
                    <div style="font-size: 13px; font-weight: 700; color: #059669; margin-bottom: 4px;"><?php echo e($rec->title); ?></div>
                    <p style="font-size: 12.5px; color: #475569; margin: 0 0 8px; line-height: 1.4;"><?php echo e($rec->description); ?></p>
                    <?php if($rec->medication): ?>
                        <div style="font-size: 11.5px; background: #ecfdf5; border-radius: 6px; padding: 4px 8px; color: #064e3b; display: inline-block;">
                            💊 <strong>Rx:</strong> <?php echo e($rec->medication); ?>

                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
</div>

<!-- Modal for Logging Treatments (SRS 1.6: Symptoms, Diagnosis, Medications, Follow-up) -->
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
                <input type="text" name="symptoms" id="modalSymptoms" class="owner-form-input" placeholder="e.g. Mild lethargy, dry cough, sensitive paw" style="width: 100%;">
            </div>

            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Clinical Diagnosis <span style="color: #ef4444;">*</span></label>
                <input type="text" name="diagnosis" id="modalDiagnosis" required class="owner-form-input" placeholder="e.g. Seasonal allergic dermatitis, Grade 1 gingivitis" style="width: 100%;">
            </div>

            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Prescribed Medication & Dosage</label>
                <textarea name="medication" id="modalMedication" rows="2" class="owner-form-input" placeholder="e.g. Amoxicillin 250mg 2x daily for 7 days; Ear drops 3 drops each ear" style="width: 100%;"></textarea>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Follow-up Actions & Patient Care Notes</label>
                <textarea name="follow_up_notes" id="modalNotes" rows="3" class="owner-form-input" placeholder="e.g. Schedule booster vaccination in 2 weeks. Keep hydration high." style="width: 100%;"></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="closeTreatmentModal()" class="btn-sm btn-outline">Cancel</button>
                <button type="submit" class="btn-sm btn-emerald">Save & Record to Passport ✓</button>
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

<?php echo $__env->make('vet.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\pat\FurShield\resources\views/vet/dashboard.blade.php ENDPATH**/ ?>