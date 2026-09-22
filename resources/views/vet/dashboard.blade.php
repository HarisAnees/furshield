@extends('vet.layouts.app')

@section('title', 'Clinical Overview')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
    <div>
        <h1 style="font-size: 1.85rem; font-weight: 800; color: #091a13; margin: 0 0 6px; letter-spacing: -0.02em;">
            Veterinary Clinical Overview
        </h1>
        <p style="color: #64748b; font-size: 0.95rem; margin: 0;">
            Welcome back, <strong>{{ $user->name }}</strong>. Managing practice at <strong>{{ $vet->clinic_name }}</strong>.
        </p>
    </div>
    <div style="display: flex; align-items: center; gap: 10px;">
        <span class="status-pill {{ $vet->is_available ? 'status-confirmed' : 'status-cancelled' }}">
            {{ $vet->is_available ? '● Available for Consults' : '○ Practice Offline' }}
        </span>
        <a href="{{ route('vet.profile') }}" class="btn-sm btn-outline">Edit Practice Profile ↗</a>
    </div>
</div>

<!-- 4 Top KPI Stat Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 18px; margin-bottom: 28px;">
    <div class="card-surface" style="margin-bottom: 0; padding: 20px;">
        <span style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; font-family: var(--font-mono, monospace);">Upcoming Bookings</span>
        <div style="font-size: 2.2rem; font-weight: 800; color: #091a13; margin-top: 8px;">{{ $stats['upcoming'] }}</div>
        <div style="font-size: 12px; color: #10b981; font-weight: 600; margin-top: 4px;">Awaiting & Confirmed</div>
    </div>
    <div class="card-surface" style="margin-bottom: 0; padding: 20px;">
        <span style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; font-family: var(--font-mono, monospace);">Active Patient Pets</span>
        <div style="font-size: 2.2rem; font-weight: 800; color: #091a13; margin-top: 8px;">{{ $stats['total_patients'] }}</div>
        <div style="font-size: 12px; color: #059669; font-weight: 600; margin-top: 4px;">Registered Companions</div>
    </div>
    <div class="card-surface" style="margin-bottom: 0; padding: 20px;">
        <span style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; font-family: var(--font-mono, monospace);">Completed Consults</span>
        <div style="font-size: 2.2rem; font-weight: 800; color: #091a13; margin-top: 8px;">{{ $stats['completed_today'] }}</div>
        <div style="font-size: 12px; color: #64748b; font-weight: 600; margin-top: 4px;">Documented Today</div>
    </div>
    <div class="card-surface" style="margin-bottom: 0; padding: 20px;">
        <span style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; font-family: var(--font-mono, monospace);">Clinical Specialization</span>
        <div style="font-size: 1.15rem; font-weight: 800; color: #091a13; margin-top: 10px; line-height: 1.3;">{{ $vet->specialization }}</div>
        <div style="font-size: 12px; color: #64748b; font-weight: 600; margin-top: 4px;">{{ $vet->experience_years }} Years Clinical Exp</div>
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
        <a href="{{ route('vet.appointments') }}" class="btn-sm btn-outline">View All ({{ $appointments->count() }})</a>
    </div>

    @if($appointments->isEmpty())
        <div style="text-align: center; padding: 36px 20px; color: #64748b;">
            <p style="margin: 0; font-size: 14px;">No appointments currently scheduled with your clinic.</p>
        </div>
    @else
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
                    @foreach($appointments->take(6) as $appt)
                        <tr>
                            <td>
                                <strong style="color: #091a13; font-size: 14px;">{{ $appt->pet?->name ?? 'Companion Pet' }}</strong>
                                <div style="font-size: 11px; color: #64748b;">
                                    {{ $appt->pet?->species ?? 'Canine' }} • {{ $appt->pet?->breed ?? 'Domestic' }}
                                </div>
                            </td>
                            <td>
                                <div>{{ $appt->user?->name ?? 'Sarah Johnson' }}</div>
                                <div style="font-size: 11px; color: #64748b;">{{ $appt->user?->phone ?? '+1 555-0144' }}</div>
                            </td>
                            <td>
                                <span style="font-weight: 600; color: #334155;">{{ $appt->reason ?? 'Routine Wellness Check' }}</span>
                                @if($appt->symptoms)
                                    <div style="font-size: 11px; color: #64748b; margin-top: 2px;">
                                        <em>Symptoms:</em> {{ Str::limit($appt->symptoms, 50) }}
                                    </div>
                                @endif
                            </td>
                            <td style="font-family: var(--font-mono, monospace); font-size: 12px; color: #475569;">
                                {{ $appt->starts_at ? \Carbon\Carbon::parse($appt->starts_at)->format('M d, Y • h:i A') : 'TBD' }}
                            </td>
                            <td>
                                <span class="status-pill status-{{ $appt->status }}">
                                    {{ ucfirst($appt->status) }}
                                </span>
                            </td>
                            <td style="text-align: right;">
                                <div style="display: inline-flex; gap: 6px; align-items: center;">
                                    @if($appt->status === 'pending')
                                        <form method="POST" action="{{ route('vet.appointments.status', $appt) }}" style="display: inline;">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="confirmed">
                                            <button type="submit" class="btn-sm btn-emerald" title="Confirm Booking">
                                                Approve
                                            </button>
                                        </form>
                                    @endif

                                    <button type="button" class="btn-sm btn-outline" onclick="openTreatmentModal('{{ $appt->id }}', '{{ addslashes($appt->pet?->name ?? 'Companion') }}', '{{ addslashes($appt->symptoms ?? '') }}', '{{ addslashes($appt->diagnosis ?? '') }}', '{{ addslashes($appt->medication ?? '') }}', '{{ addslashes($appt->follow_up_notes ?? '') }}')">
                                        Log Treatment ↗
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<!-- Recent Patient Health Records Timeline (SRS 1.6) -->
<div class="card-surface">
    <h2 style="font-size: 1.25rem; font-weight: 800; color: #091a13; margin: 0 0 16px;">
        Recent Clinical Health Passports & Treatments Logged
    </h2>

    @if($recentRecords->isEmpty())
        <p style="color: #64748b; font-size: 13.5px; margin: 0;">No health records recorded yet.</p>
    @else
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px;">
            @foreach($recentRecords as $rec)
                <div style="background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0; padding: 16px;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px;">
                        <strong style="color: #091a13; font-size: 14px;">{{ $rec->pet?->name ?? 'Companion' }}</strong>
                        <span style="font-size: 11px; font-family: var(--font-mono, monospace); color: #64748b;">
                            {{ \Carbon\Carbon::parse($rec->recorded_at)->format('M d, Y') }}
                        </span>
                    </div>
                    <div style="font-size: 13px; font-weight: 700; color: #059669; margin-bottom: 4px;">{{ $rec->title }}</div>
                    <p style="font-size: 12.5px; color: #475569; margin: 0 0 8px; line-height: 1.4;">{{ $rec->description }}</p>
                    @if($rec->medication)
                        <div style="font-size: 11.5px; background: #ecfdf5; border-radius: 6px; padding: 4px 8px; color: #064e3b; display: inline-block;">
                            <i class="fa-solid fa-pills" style="margin-right: 4px;"></i> <strong>Rx:</strong> {{ $rec->medication }}
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Modal for Logging Treatments (SRS 1.6: Symptoms, Diagnosis, Medications, Follow-up) -->
<div id="treatmentModal" class="shelter-modal-overlay" onclick="if(event.target===this) closeTreatmentModal()">
    <div class="shelter-modal-card">
        <form id="treatmentForm" method="POST" action="" class="shelter-modal-form">
            @csrf
            <div class="shelter-modal-header">
                <div class="shelter-modal-header-left">
                    <div class="shelter-modal-icon-badge"><i class="fa-solid fa-stethoscope"></i></div>
                    <div>
                        <h3 class="shelter-modal-title">Clinical Treatment: <span id="modalPetName" style="color: #059669;">Companion</span></h3>
                        <p class="shelter-modal-subtitle">Record clinical diagnosis, medication dosage, and follow-up notes.</p>
                    </div>
                </div>
                <button type="button" class="shelter-modal-close" onclick="closeTreatmentModal()" aria-label="Close modal"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <div class="shelter-modal-body">
                <div class="shelter-form-grid">
                    <div class="shelter-form-group">
                        <label class="shelter-form-label"><span>Observed Symptoms</span></label>
                        <input type="text" name="symptoms" id="modalSymptoms" class="shelter-input" placeholder="e.g. Mild lethargy, dry cough">
                    </div>
                    <div class="shelter-form-group">
                        <label class="shelter-form-label"><span>Clinical Diagnosis</span><span class="req">*</span></label>
                        <input type="text" name="diagnosis" id="modalDiagnosis" required class="shelter-input" placeholder="e.g. Dermatitis, Grade 1 gingivitis">
                    </div>
                </div>

                <div class="shelter-form-group">
                    <label class="shelter-form-label"><span>Prescribed Medication & Dosage</span></label>
                    <textarea name="medication" id="modalMedication" rows="2" class="shelter-textarea" placeholder="e.g. Amoxicillin 250mg 2x daily for 7 days"></textarea>
                </div>

                <div class="shelter-form-group" style="margin-bottom: 0;">
                    <label class="shelter-form-label"><span>Follow-up Actions & Patient Care Notes</span></label>
                    <textarea name="follow_up_notes" id="modalNotes" rows="2" class="shelter-textarea" placeholder="e.g. Schedule booster in 2 weeks. Keep hydration high."></textarea>
                </div>
            </div>

            <div class="shelter-modal-footer">
                <button type="button" onclick="closeTreatmentModal()" class="shelter-btn-cancel">Cancel</button>
                <button type="submit" class="shelter-btn-submit"><i class="fa-solid fa-file-medical" style="margin-right: 6px;"></i>Record to Passport</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
function openTreatmentModal(apptId, petName, symptoms, diagnosis, medication, notes) {
    document.getElementById('treatmentForm').action = '/vet/appointments/' + apptId + '/treatment';
    document.getElementById('modalPetName').textContent = petName;
    document.getElementById('modalSymptoms').value = symptoms || '';
    document.getElementById('modalDiagnosis').value = diagnosis || '';
    document.getElementById('modalMedication').value = medication || '';
    document.getElementById('modalNotes').value = notes || '';
    const modal = document.getElementById('treatmentModal');
    modal.style.display = 'flex';
    requestAnimationFrame(() => modal.classList.add('active'));
    document.body.style.overflow = 'hidden';
}
function closeTreatmentModal() {
    const modal = document.getElementById('treatmentModal');
    modal.classList.remove('active');
    setTimeout(() => {
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }, 150);
}
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeTreatmentModal();
});
</script>
@endsection
