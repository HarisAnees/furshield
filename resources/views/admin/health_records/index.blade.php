@extends('admin.layouts.app')

@section('title', 'Health Records')
@section('page_title', 'Medical & Health Records')
@section('page_subtitle', 'Complete electronic veterinary health records, vaccination schedules, and prescription logs.')

@section('content')
<div class="crud-toolbar">
    <div class="filter-pills">
        <a href="{{ route('admin.health-records.index') }}" class="filter-pill-link {{ !request('type') ? 'active' : '' }}">
            All Records
        </a>
        <a href="{{ route('admin.health-records.index', ['type' => 'vaccination']) }}" class="filter-pill-link {{ request('type') === 'vaccination' ? 'active' : '' }}">
            💉 Vaccination
        </a>
        <a href="{{ route('admin.health-records.index', ['type' => 'checkup']) }}" class="filter-pill-link {{ request('type') === 'checkup' ? 'active' : '' }}">
            🩺 Exam / Checkup
        </a>
        <a href="{{ route('admin.health-records.index', ['type' => 'surgery']) }}" class="filter-pill-link {{ request('type') === 'surgery' ? 'active' : '' }}">
            🩹 Surgery
        </a>
        <a href="{{ route('admin.health-records.index', ['type' => 'prescription']) }}" class="filter-pill-link {{ request('type') === 'prescription' ? 'active' : '' }}">
            💊 Medication
        </a>
    </div>

    <div class="toolbar-actions">
        <form method="GET" action="{{ route('admin.health-records.index') }}" class="toolbar-search">
            @if(request('type'))
                <input type="hidden" name="type" value="{{ request('type') }}">
            @endif
            <input type="text" name="search" class="form-control" placeholder="Search record, pet, clinic..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-secondary btn-sm">Search</button>
            @if(request('search'))
                <a href="{{ route('admin.health-records.index', request()->only('type')) }}" class="btn btn-outline btn-sm">Clear</a>
            @endif
        </form>

        <button type="button" class="btn btn-primary" onclick="openModal('createHealthRecordModal')">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Add Health Record
        </button>
    </div>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Patient (Pet)</th>
                    <th>Type</th>
                    <th>Title & Notes</th>
                    <th>Vet / Clinic</th>
                    <th>Medications</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($records as $rec)
                    <tr>
                        <td style="white-space: nowrap;">
                            <strong style="color: #0f172a; font-size: 12.5px;">{{ \Carbon\Carbon::parse($rec->recorded_at)->format('M d, Y') }}</strong>
                        </td>
                        <td>
                            <div class="user-info-cell">
                                <span style="font-size: 16px;">🐾</span>
                                <div>
                                    <strong style="color: #0f172a;">{{ $rec->pet->name ?? 'Unknown Pet' }}</strong>
                                    <small style="display: block; color: #64748b;">Owner: {{ $rec->pet->user->name ?? '—' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if(strtolower($rec->record_type) === 'vaccination')
                                <span class="badge badge-teal"><span class="badge-dot"></span> Vaccination</span>
                            @elseif(strtolower($rec->record_type) === 'checkup')
                                <span class="badge badge-info"><span class="badge-dot"></span> Checkup</span>
                            @elseif(strtolower($rec->record_type) === 'surgery')
                                <span class="badge badge-danger"><span class="badge-dot"></span> Surgery</span>
                            @else
                                <span class="badge badge-purple"><span class="badge-dot"></span> {{ ucfirst($rec->record_type) }}</span>
                            @endif
                        </td>
                        <td style="max-width: 260px;">
                            <strong style="font-size: 12.5px; color: #0f172a; display: block;">{{ $rec->title }}</strong>
                            <p style="font-size: 11.5px; color: #64748b; margin: 2px 0 0; line-height: 1.3;">
                                {{ \Illuminate\Support\Str::limit($rec->description, 70) }}
                            </p>
                        </td>
                        <td>
                            <span style="font-size: 12px; color: #334155; font-weight: 500;">
                                {{ $rec->provider_name ?? 'FurShield Clinic' }}
                            </span>
                        </td>
                        <td style="max-width: 160px;">
                            @if($rec->medication)
                                <span style="font-size: 11.5px; color: #0f766e; background: #ecfdf5; padding: 2px 6px; border-radius: 4px; display: inline-block;">
                                    {{ \Illuminate\Support\Str::limit($rec->medication, 30) }}
                                </span>
                            @else
                                <span style="color: #94a3b8; font-size: 11.5px;">None</span>
                            @endif
                        </td>
                        <td style="text-align: right;">
                            <form method="POST" action="{{ route('admin.health-records.destroy', $rec) }}" onsubmit="return confirm('Delete this health record?');" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <span class="empty-state-icon">📋</span>
                                <h4>No medical records found</h4>
                                <p>Record vaccinations, physical examinations, and treatments for pets here.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($records->hasPages())
        <div style="padding: 16px 20px; border-top: 1px solid var(--border);">
            {{ $records->links() }}
        </div>
    @endif
</div>

<!-- Create Health Record Modal -->
<div class="modal-overlay" id="createHealthRecordModal">
    <div class="modal-box">
        <div class="modal-header">
            <div>
                <span class="modal-tag">Clinical History</span>
                <h3>Add Health Record</h3>
            </div>
            <button type="button" class="modal-close-btn" onclick="closeModal('createHealthRecordModal')" aria-label="Close modal">&times;</button>
        </div>
        <form method="POST" action="{{ route('admin.health-records.store') }}">
            @csrf
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Pet Patient *</label>
                        <select name="pet_id" class="form-select" required>
                            <option value="">Select pet...</option>
                            @foreach($pets as $p)
                                <option value="{{ $p->id }}">{{ $p->name }} (Owner: {{ $p->user->name ?? '—' }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Record Type *</label>
                        <select name="record_type" class="form-select" required>
                            <option value="vaccination">Vaccination</option>
                            <option value="checkup">Annual Checkup / Exam</option>
                            <option value="surgery">Surgery / Procedure</option>
                            <option value="prescription">Prescription Medication</option>
                            <option value="dental">Dental Cleaning</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Record Title *</label>
                    <input type="text" name="title" class="form-control" required placeholder="e.g. DHPP Booster & Rabies Shot">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Date Performed *</label>
                        <input type="date" name="recorded_at" class="form-control" required value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Clinic / Attending Vet</label>
                        <input type="text" name="provider_name" class="form-control" placeholder="e.g. Dr. Emily Carter">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Prescription / Medications</label>
                    <input type="text" name="medication" class="form-control" placeholder="e.g. Heartgard Plus chewable 1x/month">
                </div>
                <div class="form-group">
                    <label class="form-label">Detailed Clinical Notes & Diagnosis</label>
                    <textarea name="description" class="form-textarea" placeholder="Enter findings, physical vitals, temperature, weight notes..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('createHealthRecordModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Medical Record</button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal(id) { document.getElementById(id).classList.add('active'); }
function closeModal(id) { document.getElementById(id).classList.remove('active'); }
document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) overlay.classList.remove('active');
    });
});
</script>
@endsection
