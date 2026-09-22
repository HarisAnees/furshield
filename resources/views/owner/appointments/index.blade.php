@extends('owner.layouts.app')

@section('title', 'My Appointments')

@section('content')
<div class="owner-appointments-split">
    <!-- Appointments List -->
    <div class="owner-subpage-card">
        <div class="owner-subpage-header">
            <div class="owner-subpage-title">
                <i class="fa-solid fa-stethoscope" style="color: #10b981;"></i> My Consultations & Clinic Visits
            </div>
            <button type="button" class="owner-btn owner-btn-primary" onclick="openOwnerModal('bookAptModal')">
                <i class="fa-solid fa-plus"></i> Book Visit
            </button>
        </div>
        <div class="owner-subpage-body no-padding" style="padding: 0;">
            <div style="display: flex; flex-direction: column;">
                @forelse($appointments as $apt)
                    <div class="owner-appointment-item">
                        <div style="display: flex; align-items: center; gap: 14px;">
                            <div style="width: 46px; height: 46px; border-radius: 10px; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;">
                                <i class="fa-solid fa-paw"></i>
                            </div>
                            <div>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <strong style="font-size: 14px; color: #0f172a;">{{ $apt->pet->name ?? 'My Pet' }}</strong>
                                    <span style="font-size: 11px; font-weight: 600; padding: 2px 8px; border-radius: 12px;
                                        @if($apt->status === 'confirmed') background: #ccfbf1; color: #0f766e;
                                        @elseif($apt->status === 'completed') background: #dcfce7; color: #15803d;
                                        @elseif($apt->status === 'cancelled') background: #fee2e2; color: #b91c1c;
                                        @else background: #fef3c7; color: #b45309; @endif">
                                        {{ ucfirst($apt->status) }}
                                    </span>
                                </div>
                                <div style="font-size: 12.5px; color: #334155; margin-top: 3px;">
                                    {{ $apt->reason }}
                                </div>
                                <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">
                                    Doctor: <strong>{{ $apt->vet->user->name ?? 'Dr. Specialist' }}</strong> ({{ $apt->vet->specialization ?? 'General Vet' }})
                                </div>
                            </div>
                        </div>

                        <div style="text-align: right; flex-shrink: 0;">
                            <div style="font-size: 13px; font-weight: 700; color: #0f172a;">
                                {{ \Carbon\Carbon::parse($apt->starts_at)->format('M d, Y') }}
                            </div>
                            <div style="font-size: 12px; color: #10b981; font-weight: 600;">
                                {{ \Carbon\Carbon::parse($apt->starts_at)->format('h:i A') }}
                            </div>
                            @if(in_array($apt->status, ['scheduled', 'confirmed']))
                                <form method="POST" action="{{ route('owner.appointments.cancel', $apt) }}" onsubmit="return confirm('Cancel this appointment?');" style="margin-top: 6px;">
                                    @csrf
                                    <button type="submit" style="background: none; border: none; font-size: 11px; color: #ef4444; font-weight: 600; cursor: pointer; text-decoration: underline;">
                                        Cancel Visit
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 40px; color: #64748b;">
                        <div style="width: 48px; height: 48px; border-radius: 50%; background: #ecfdf5; color: #059669; display: inline-flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 10px;">
                            <i class="fa-solid fa-calendar-xmark"></i>
                        </div>
                        <h4>No appointments yet</h4>
                        <p style="font-size: 12px;">Need a checkup or vaccination? Book your appointment online.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Quick Booking Card -->
    <div class="owner-subpage-card">
        <div class="owner-subpage-header">
            <div class="owner-subpage-title">
                <i class="fa-solid fa-calendar-plus" style="color: #10b981;"></i> Schedule Appointment
            </div>
        </div>
        <div class="owner-subpage-body">
            <form method="POST" action="{{ route('owner.appointments.book') }}">
                @csrf
                <div style="margin-bottom: 14px;">
                    <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 4px;">Select Pet *</label>
                    <select name="pet_id" required style="width: 100%; padding: 8px 12px; border: 1px solid var(--border); border-radius: 8px;">
                        @foreach($pets as $pet)
                            <option value="{{ $pet->id }}">{{ $pet->name }} ({{ $pet->species }})</option>
                        @endforeach
                    </select>
                </div>
                <div style="margin-bottom: 14px;">
                    <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 4px;">Select Veterinarian *</label>
                    <select name="vet_id" required style="width: 100%; padding: 8px 12px; border: 1px solid var(--border); border-radius: 8px;">
                        @foreach($vets as $vet)
                            <option value="{{ $vet->id }}">{{ $vet->user->name ?? 'Dr. Emily Carter' }} — {{ $vet->specialization ?? 'General Vet' }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="margin-bottom: 14px;">
                    <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 4px;">Date & Time *</label>
                    <input type="datetime-local" name="starts_at" required style="width: 100%; padding: 8px 12px; border: 1px solid var(--border); border-radius: 8px;" value="{{ date('Y-m-d\TH:i', strtotime('+1 day 10:00')) }}">
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
        <form method="POST" action="{{ route('owner.appointments.book') }}">
            @csrf
            <div class="owner-modal-body">
                <div style="margin-bottom: 14px;">
                    <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 4px;">Select Pet *</label>
                    <select name="pet_id" required style="width: 100%; padding: 8px 12px; border: 1px solid var(--border); border-radius: 8px;">
                        @foreach($pets as $pet)
                            <option value="{{ $pet->id }}">{{ $pet->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="margin-bottom: 14px;">
                    <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 4px;">Select Doctor *</label>
                    <select name="vet_id" required style="width: 100%; padding: 8px 12px; border: 1px solid var(--border); border-radius: 8px;">
                        @foreach($vets as $vet)
                            <option value="{{ $vet->id }}">{{ $vet->user->name ?? 'Dr. Specialist' }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="margin-bottom: 14px;">
                    <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 4px;">Date & Time *</label>
                    <input type="datetime-local" name="starts_at" required style="width: 100%; padding: 8px 12px; border: 1px solid var(--border); border-radius: 8px;" value="{{ date('Y-m-d\TH:i', strtotime('+1 day 10:00')) }}">
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
@endsection
