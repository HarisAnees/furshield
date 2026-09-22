@extends('vet.layouts.app')

@section('title', 'Patient Bookings & Appointments')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
    <div>
        <h1 style="font-size: 1.85rem; font-weight: 800; color: #091a13; margin: 0 0 6px; letter-spacing: -0.02em;">
            Patient Bookings & Clinical Consultations
        </h1>
        <p style="color: #64748b; font-size: 0.95rem; margin: 0;">
            Manage incoming appointment requests, approve schedules, and document treatment observations.
        </p>
    </div>
    <a href="{{ route('vet.dashboard') }}" class="btn-sm btn-outline">← Back to Overview</a>
</div>

<div class="card-surface">
    @if($appointments->isEmpty())
        <div style="text-align: center; padding: 40px; color: #64748b;">
            <p>No appointments registered yet.</p>
        </div>
    @else
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
                    @foreach($appointments as $appt)
                        <tr>
                            <td style="font-family: var(--font-mono, monospace); font-weight: 700; color: #64748b;">
                                #{{ $appt->id }}
                            </td>
                            <td>
                                <strong style="color: #091a13;">{{ $appt->pet?->name ?? 'Companion Pet' }}</strong>
                                <div style="font-size: 11px; color: #64748b;">{{ $appt->pet?->species ?? 'Pet' }} • {{ $appt->pet?->breed ?? 'Domestic' }}</div>
                            </td>
                            <td>
                                <div>{{ $appt->user?->name ?? 'Sarah Johnson' }}</div>
                                <div style="font-size: 11px; color: #64748b;">{{ $appt->user?->email ?? 'owner@example.com' }}</div>
                            </td>
                            <td>
                                <div style="font-weight: 600; color: #1e293b;">{{ $appt->reason ?? 'Clinical Consult' }}</div>
                                @if($appt->symptoms)
                                    <div style="font-size: 11px; color: #64748b;">{{ Str::limit($appt->symptoms, 45) }}</div>
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
                                            <button type="submit" class="btn-sm btn-emerald">Approve</button>
                                        </form>
                                    @endif

                                    @if($appt->status !== 'completed' && $appt->status !== 'cancelled')
                                        <form method="POST" action="{{ route('vet.appointments.status', $appt) }}" style="display: inline;">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="cancelled">
                                            <button type="submit" class="btn-sm btn-danger" onclick="return confirm('Cancel this appointment?')">Cancel</button>
                                        </form>
                                    @endif

                                    <button type="button" class="btn-sm btn-outline" onclick="openTreatmentModal('{{ $appt->id }}', '{{ addslashes($appt->pet?->name ?? 'Companion') }}', '{{ addslashes($appt->symptoms ?? '') }}', '{{ addslashes($appt->diagnosis ?? '') }}', '{{ addslashes($appt->medication ?? '') }}', '{{ addslashes($appt->follow_up_notes ?? '') }}')">
                                        Treatment Notes ↗
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px;">
            {{ $appointments->links() }}
        </div>
    @endif
</div>

<!-- Treatment Notes Modal -->
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
                        <input type="text" name="symptoms" id="modalSymptoms" class="shelter-input" placeholder="e.g. Lethargy, cough, paw irritation">
                    </div>
                    <div class="shelter-form-group">
                        <label class="shelter-form-label"><span>Clinical Diagnosis</span><span class="req">*</span></label>
                        <input type="text" name="diagnosis" id="modalDiagnosis" required class="shelter-input" placeholder="e.g. Mild respiratory infection">
                    </div>
                </div>

                <div class="shelter-form-group">
                    <label class="shelter-form-label"><span>Prescribed Medication & Dosage</span></label>
                    <textarea name="medication" id="modalMedication" rows="2" class="shelter-textarea" placeholder="e.g. Antibiotic syrup 5ml daily for 5 days"></textarea>
                </div>

                <div class="shelter-form-group" style="margin-bottom: 0;">
                    <label class="shelter-form-label"><span>Follow-up Actions & Care Advice</span></label>
                    <textarea name="follow_up_notes" id="modalNotes" rows="2" class="shelter-textarea" placeholder="e.g. Rest and review in 10 days."></textarea>
                </div>
            </div>

            <div class="shelter-modal-footer">
                <button type="button" onclick="closeTreatmentModal()" class="shelter-btn-cancel">Cancel</button>
                <button type="submit" class="shelter-btn-submit"><i class="fa-solid fa-check" style="margin-right: 6px;"></i>Save & Complete Treatment</button>
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
