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
<div id="careLogModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 1000; align-items: center; justify-content: center; padding: 16px;">
    <div style="background: #ffffff; border-radius: 20px; max-width: 520px; width: 100%; padding: 28px; box-shadow: 0 20px 40px rgba(0,0,0,0.3);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px;">
            <h3 style="font-size: 1.3rem; font-weight: 800; color: #091a13; margin: 0;">
                Record Daily Animal Care Activity
            </h3>
            <button type="button" onclick="closeCareLogModal()" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #64748b;">✕</button>
        </div>

        <form method="POST" action="{{ route('shelter.care-logs.store') }}">
            @csrf
            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Select Animal Companion <span style="color: #ef4444;">*</span></label>
                <select name="adoption_listing_id" required class="owner-form-input" style="width: 100%;">
                    @foreach($listings as $item)
                        <option value="{{ $item->id }}">{{ $item->pet_name }} ({{ $item->species }} - {{ $item->breed }})</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Activity Category <span style="color: #ef4444;">*</span></label>
                <select name="category" required class="owner-form-input" style="width: 100%;">
                    <option value="feeding">Feeding (Dietary protocol, meal intake)</option>
                    <option value="grooming">Grooming (Brushing, bath, coat check)</option>
                    <option value="medical">Medical Attention (Medication, exam, vitals)</option>
                    <option value="exercise">Exercise & Enrichment (Play session, walk)</option>
                    <option value="general">General Observation</option>
                </select>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Notes & Care Observations <span style="color: #ef4444;">*</span></label>
                <textarea name="notes" rows="3" required class="owner-form-input" placeholder="e.g. Ate full morning kibble portion eagerly. Clean water refreshed." style="width: 100%;"></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <button type="button" onclick="closeCareLogModal()" class="btn-sm btn-outline">Cancel</button>
                <button type="submit" class="btn-sm btn-emerald">Save Care Log ✓</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
function openCareLogModal() {
    document.getElementById('careLogModal').style.display = 'flex';
}
function closeCareLogModal() {
    document.getElementById('careLogModal').style.display = 'none';
}
</script>
@endsection
