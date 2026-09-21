@extends('admin.layouts.app')

@section('title', 'Appointments')
@section('page_title', 'Veterinary Appointments')
@section('page_subtitle', 'Schedule, track, and manage consultations between pet owners and veterinarians.')

@section('content')
<div class="crud-toolbar">
    <div class="filter-pills">
        <a href="{{ route('admin.appointments.index') }}" class="filter-pill-link {{ !request('status') ? 'active' : '' }}">
            All ({{ $statusCounts['all'] }})
        </a>
        <a href="{{ route('admin.appointments.index', ['status' => 'scheduled']) }}" class="filter-pill-link {{ request('status') === 'scheduled' ? 'active' : '' }}">
            Scheduled ({{ $statusCounts['scheduled'] }})
        </a>
        <a href="{{ route('admin.appointments.index', ['status' => 'confirmed']) }}" class="filter-pill-link {{ request('status') === 'confirmed' ? 'active' : '' }}">
            Confirmed ({{ $statusCounts['confirmed'] }})
        </a>
        <a href="{{ route('admin.appointments.index', ['status' => 'completed']) }}" class="filter-pill-link {{ request('status') === 'completed' ? 'active' : '' }}">
            Completed ({{ $statusCounts['completed'] }})
        </a>
        <a href="{{ route('admin.appointments.index', ['status' => 'cancelled']) }}" class="filter-pill-link {{ request('status') === 'cancelled' ? 'active' : '' }}">
            Cancelled ({{ $statusCounts['cancelled'] }})
        </a>
    </div>

    <div class="toolbar-actions">
        <form method="GET" action="{{ route('admin.appointments.index') }}" class="toolbar-search">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <input type="text" name="search" class="form-control" placeholder="Search pet, owner, or reason..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-secondary btn-sm">Search</button>
            @if(request('search'))
                <a href="{{ route('admin.appointments.index', request()->only('status')) }}" class="btn btn-outline btn-sm">Clear</a>
            @endif
        </form>

        <button type="button" class="btn btn-primary" onclick="openModal('createAppointmentModal')">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Book Appointment
        </button>
    </div>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Date & Time</th>
                    <th>Pet</th>
                    <th>Owner</th>
                    <th>Veterinarian</th>
                    <th>Reason / Purpose</th>
                    <th>Status</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($appointments as $apt)
                    <tr>
                        <td>
                            <strong style="display: block; font-size: 13px; color: #0f172a;">
                                {{ \Carbon\Carbon::parse($apt->starts_at)->format('M d, Y') }}
                            </strong>
                            <small style="color: #64748b; font-weight: 600;">
                                {{ \Carbon\Carbon::parse($apt->starts_at)->format('h:i A') }}
                            </small>
                        </td>
                        <td>
                            <div class="user-info-cell">
                                <span style="font-size: 16px;">🐾</span>
                                <div>
                                    <strong style="color: #0f172a;">{{ $apt->pet->name ?? 'Unknown Pet' }}</strong>
                                    <small style="display: block; color: #64748b;">{{ $apt->pet->species ?? '' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-size: 12.5px; font-weight: 600; color: #0f172a;">
                                {{ $apt->user->name ?? 'Guest User' }}
                            </div>
                            <small style="color: #64748b;">{{ $apt->user->email ?? '' }}</small>
                        </td>
                        <td>
                            <div style="font-size: 12.5px; font-weight: 600; color: #0f172a;">
                                {{ $apt->vet->user->name ?? 'Dr. Specialist' }}
                            </div>
                            <small style="color: #0d9488;">{{ $apt->vet->specialization ?? 'General Vet' }}</small>
                        </td>
                        <td style="max-width: 200px;">
                            <span style="font-size: 12px; color: #334155;">{{ $apt->reason }}</span>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.appointments.status', $apt) }}" style="display: inline-block;">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="form-select" style="padding: 3px 8px; font-size: 11px; font-weight: 600; width: auto; height: auto; border-radius: 20px;
                                    @if($apt->status === 'completed') background: #dcfce7; color: #15803d; border-color: #86efac;
                                    @elseif($apt->status === 'confirmed') background: #ccfbf1; color: #0f766e; border-color: #99f6e4;
                                    @elseif($apt->status === 'cancelled') background: #fee2e2; color: #b91c1c; border-color: #fecaca;
                                    @else background: #fef3c7; color: #b45309; border-color: #fde68a; @endif">
                                    <option value="scheduled" {{ $apt->status === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                    <option value="confirmed" {{ $apt->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="completed" {{ $apt->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $apt->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </form>
                        </td>
                        <td style="text-align: right;">
                            <form method="POST" action="{{ route('admin.appointments.destroy', $apt) }}" onsubmit="return confirm('Delete this appointment record?');" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Record">Remove</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <span class="empty-state-icon">📅</span>
                                <h4>No appointments found</h4>
                                <p>There are no veterinary appointments matching your current filter.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($appointments->hasPages())
        <div style="padding: 16px 20px; border-top: 1px solid var(--border);">
            {{ $appointments->links() }}
        </div>
    @endif
</div>

<!-- Create Appointment Modal -->
<div class="modal-overlay" id="createAppointmentModal">
    <div class="modal-box">
        <div class="modal-header">
            <div>
                <span class="modal-tag">Clinical Schedule</span>
                <h3>Schedule New Appointment</h3>
            </div>
            <button type="button" class="modal-close-btn" onclick="closeModal('createAppointmentModal')" aria-label="Close modal">&times;</button>
        </div>
        <form method="POST" action="{{ route('admin.appointments.store') }}">
            @csrf
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Pet Owner *</label>
                        <select name="user_id" id="apt_user_select" class="form-select" required onchange="filterPetsByOwner(this.value)">
                            <option value="">Select owner...</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Patient (Pet) *</label>
                        <select name="pet_id" id="apt_pet_select" class="form-select" required>
                            <option value="">Select pet...</option>
                            @foreach($pets as $pet)
                                <option value="{{ $pet->id }}" data-owner="{{ $pet->user_id }}">{{ $pet->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Assigned Veterinarian *</label>
                    <select name="vet_id" class="form-select" required>
                        @foreach($vets as $vet)
                            <option value="{{ $vet->id }}">{{ $vet->user->name ?? 'Dr. Emily Carter' }} ({{ $vet->specialization ?? 'General Vet' }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Date & Time *</label>
                        <input type="datetime-local" name="starts_at" class="form-control" required value="{{ date('Y-m-d\TH:i', strtotime('+1 day 10:00')) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Initial Status *</label>
                        <select name="status" class="form-select" required>
                            <option value="scheduled">Scheduled</option>
                            <option value="confirmed" selected>Confirmed</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Reason / Consultation Type *</label>
                    <input type="text" name="reason" class="form-control" required placeholder="e.g. Annual Vaccination & Health Checkup">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('createAppointmentModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Book Appointment</button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal(id) { document.getElementById(id).classList.add('active'); }
function closeModal(id) { document.getElementById(id).classList.remove('active'); }
function filterPetsByOwner(ownerId) {
    const petSelect = document.getElementById('apt_pet_select');
    const options = petSelect.querySelectorAll('option');
    options.forEach(opt => {
        if (!opt.value) return;
        if (!ownerId || opt.getAttribute('data-owner') == ownerId) {
            opt.style.display = '';
        } else {
            opt.style.display = 'none';
        }
    });
}
document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) overlay.classList.remove('active');
    });
});
</script>
@endsection
