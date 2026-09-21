@extends('shelter.layouts.app')

@section('title', 'Daily Animal Care Logs')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
    <div>
        <h1 style="font-size: 1.85rem; font-weight: 800; color: #091a13; margin: 0 0 6px; letter-spacing: -0.02em;">
            Daily Animal Welfare Care Logs
        </h1>
        <p style="color: #64748b; font-size: 0.95rem; margin: 0;">
            Track scheduled feeding, grooming routines, exercise, and medical attention logs for sanctuary animals.
        </p>
    </div>
    <div style="display: flex; gap: 10px;">
        <button type="button" class="btn-sm btn-emerald" onclick="openCareLogModal()">
            + Log Care Activity
        </button>
        <a href="{{ route('shelter.dashboard') }}" class="btn-sm btn-outline">← Back to Overview</a>
    </div>
</div>

<div class="card-surface">
    @if($logs->isEmpty())
        <div style="text-align: center; padding: 40px; color: #64748b;">
            <p>No care logs recorded yet. Click above to record a new care activity.</p>
        </div>
    @else
        <div style="overflow-x: auto;">
            <table class="action-table">
                <thead>
                    <tr>
                        <th>Time Logged</th>
                        <th>Sheltered Companion</th>
                        <th>Category</th>
                        <th>Care Notes & Observations</th>
                        <th>Staff Attendant</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                        <tr>
                            <td style="font-family: var(--font-mono, monospace); font-size: 12px; color: #475569;">
                                {{ \Carbon\Carbon::parse($log->logged_at)->format('M d, Y • h:i A') }}
                            </td>
                            <td>
                                <strong style="color: #091a13;">{{ $log->listing?->pet_name ?? 'Sanctuary Companion' }}</strong>
                                <div style="font-size: 11px; color: #64748b;">{{ $log->listing?->species ?? 'Pet' }} • {{ $log->listing?->breed ?? 'Domestic' }}</div>
                            </td>
                            <td>
                                <span class="status-pill" style="background: #ecfdf5; color: #064e3b; text-transform: uppercase;">
                                    {{ $log->category }}
                                </span>
                            </td>
                            <td style="font-size: 13px; color: #334155;">
                                {{ $log->notes }}
                            </td>
                            <td style="font-size: 12px; color: #64748b;">
                                {{ $log->creator?->name ?? 'Shelter Staff' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px;">
            {{ $logs->links() }}
        </div>
    @endif
</div>

<!-- Modal for Recording Daily Care -->
<div id="careLogModal" class="shelter-modal-overlay" onclick="if(event.target===this) closeCareLogModal()">
    <div class="shelter-modal-card">
        <div class="shelter-modal-header">
            <div class="shelter-modal-header-left">
                <div class="shelter-modal-icon-badge">📋</div>
                <div>
                    <h3 class="shelter-modal-title">Record Daily Care Activity</h3>
                    <p class="shelter-modal-subtitle">Log feeding, grooming, medical care, or observations.</p>
                </div>
            </div>
            <button type="button" class="shelter-modal-close" onclick="closeCareLogModal()" aria-label="Close modal">✕</button>
        </div>

        <form method="POST" action="{{ route('shelter.care-logs.store') }}">
            @csrf
            <div class="shelter-modal-body">
                <div class="shelter-form-group">
                    <label class="shelter-form-label"><span>Select Animal Companion</span><span class="req">*</span></label>
                    <select name="adoption_listing_id" required class="shelter-select">
                        @foreach($listings as $item)
                            <option value="{{ $item->id }}">{{ $item->pet_name }} ({{ $item->species }} - {{ $item->breed }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="shelter-form-group">
                    <label class="shelter-form-label"><span>Activity Category</span><span class="req">*</span></label>
                    <select name="category" required class="shelter-select">
                        <option value="feeding">Feeding (Dietary protocol, meal intake)</option>
                        <option value="grooming">Grooming (Brushing, bath, coat check)</option>
                        <option value="medical">Medical Attention (Medication, exam, vitals)</option>
                        <option value="exercise">Exercise & Enrichment (Play session, walk)</option>
                        <option value="general">General Observation</option>
                    </select>
                </div>

                <div class="shelter-form-group" style="margin-bottom: 0;">
                    <label class="shelter-form-label"><span>Notes & Care Observations</span><span class="req">*</span></label>
                    <textarea name="notes" rows="3" required class="shelter-textarea" placeholder="e.g. Ate full morning kibble portion eagerly. Clean water refreshed."></textarea>
                </div>
            </div>

            <div class="shelter-modal-footer">
                <button type="button" onclick="closeCareLogModal()" class="shelter-btn-cancel">Cancel</button>
                <button type="submit" class="shelter-btn-submit">Save Care Log ✓</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
function openCareLogModal() {
    const modal = document.getElementById('careLogModal');
    modal.style.display = 'flex';
    requestAnimationFrame(() => {
        modal.classList.add('active');
    });
    document.body.style.overflow = 'hidden';
}
function closeCareLogModal() {
    const modal = document.getElementById('careLogModal');
    modal.classList.remove('active');
    setTimeout(() => {
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }, 150);
}
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeCareLogModal();
});
</script>
@endsection
