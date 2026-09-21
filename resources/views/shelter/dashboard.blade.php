@extends('shelter.layouts.app')

@section('title', 'Rescue & Shelter Overview')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
    <div>
        <h1 style="font-size: 1.85rem; font-weight: 800; color: #091a13; margin: 0 0 6px; letter-spacing: -0.02em;">
            Shelter Sanctuary Operations
        </h1>
        <p style="color: #64748b; font-size: 0.95rem; margin: 0;">
            Organization: <strong>{{ $shelter->organization_name }}</strong> • Supporting verified pet rehoming & daily welfare.
        </p>
    </div>
    <div style="display: flex; align-items: center; gap: 10px;">
        <button type="button" class="btn-sm btn-emerald" onclick="openNewListingModal()">
            + Add Adoptable Animal
        </button>
        <a href="{{ route('shelter.care-logs') }}" class="btn-sm btn-outline">Log Daily Care ↗</a>
    </div>
</div>

<!-- 4 KPI Metrics -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 18px; margin-bottom: 28px;">
    <div class="card-surface" style="margin-bottom: 0; padding: 20px;">
        <span style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; font-family: var(--font-mono, monospace);">Total Rescues</span>
        <div style="font-size: 2.2rem; font-weight: 800; color: #091a13; margin-top: 8px;">{{ $stats['total_rescues'] }}</div>
        <div style="font-size: 12px; color: #10b981; font-weight: 600; margin-top: 4px;">Sheltered Animals</div>
    </div>
    <div class="card-surface" style="margin-bottom: 0; padding: 20px;">
        <span style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; font-family: var(--font-mono, monospace);">Available for Adoption</span>
        <div style="font-size: 2.2rem; font-weight: 800; color: #091a13; margin-top: 8px;">{{ $stats['available'] }}</div>
        <div style="font-size: 12px; color: #059669; font-weight: 600; margin-top: 4px;">Active in Public Gallery</div>
    </div>
    <div class="card-surface" style="margin-bottom: 0; padding: 20px;">
        <span style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; font-family: var(--font-mono, monospace);">Adoption Applications</span>
        <div style="font-size: 2.2rem; font-weight: 800; color: #091a13; margin-top: 8px;">{{ $stats['pending_applications'] }}</div>
        <div style="font-size: 12px; color: #d97706; font-weight: 600; margin-top: 4px;">Pending Review</div>
    </div>
    <div class="card-surface" style="margin-bottom: 0; padding: 20px;">
        <span style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; font-family: var(--font-mono, monospace);">Recent Care Logs</span>
        <div style="font-size: 2.2rem; font-weight: 800; color: #091a13; margin-top: 8px;">{{ $stats['care_logs_count'] }}</div>
        <div style="font-size: 12px; color: #64748b; font-weight: 600; margin-top: 4px;">Feeding / Grooming / Meds</div>
    </div>
</div>

<!-- Adoptable Animal Listings Table (SRS 1.6) -->
<div class="card-surface">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px;">
        <div>
            <h2 style="font-size: 1.25rem; font-weight: 800; color: #091a13; margin: 0 0 4px;">
                Adoptable Rescue Animals in Sanctuary
            </h2>
            <p style="font-size: 13px; color: #64748b; margin: 0;">
                Profiles published here appear in the FurShield public adoption portal.
            </p>
        </div>
        <a href="{{ route('shelter.listings') }}" class="btn-sm btn-outline">View All ({{ $listings->count() }})</a>
    </div>

    <div style="overflow-x: auto;">
        <table class="action-table">
            <thead>
                <tr>
                    <th>Animal Companion</th>
                    <th>Species & Breed</th>
                    <th>Age & Sex</th>
                    <th>Clinical Status</th>
                    <th>Adoption Status</th>
                    <th style="text-align: right;">Inquiries</th>
                </tr>
            </thead>
            <tbody>
                @foreach($listings->take(6) as $listing)
                    <tr>
                        <td>
                            <strong style="color: #091a13; font-size: 14px;">{{ $listing->pet_name }}</strong>
                            <div style="font-size: 11px; color: #64748b;">ID: #{{ $listing->id }}</div>
                        </td>
                        <td>
                            <span style="font-weight: 600; color: #334155;">{{ $listing->species }}</span>
                            <div style="font-size: 11px; color: #64748b;">{{ $listing->breed }}</div>
                        </td>
                        <td>
                            <div>{{ $listing->age_text }}</div>
                            <div style="font-size: 11px; color: #64748b;">{{ $listing->sex }}</div>
                        </td>
                        <td>
                            <span style="font-size: 12px; color: #059669; font-weight: 600;">{{ Str::limit($listing->health_summary, 40) }}</span>
                        </td>
                        <td>
                            <span class="status-pill status-{{ $listing->status }}">
                                {{ ucfirst($listing->status) }}
                            </span>
                        </td>
                        <td style="text-align: right;">
                            <a href="{{ route('shelter.applications') }}" class="btn-sm btn-outline">
                                {{ $listing->interests->count() }} Inquiries
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Recent Daily Care Logs (Feeding, Grooming, Medical Attention) (SRS 1.6) -->
<div class="card-surface">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
        <h2 style="font-size: 1.25rem; font-weight: 800; color: #091a13; margin: 0;">
            Daily Animal Welfare Care Activity Logs
        </h2>
        <a href="{{ route('shelter.care-logs') }}" class="btn-sm btn-emerald">+ Record New Log</a>
    </div>

    @if($recentCareLogs->isEmpty())
        <p style="color: #64748b; font-size: 13.5px; margin: 0;">No care logs recorded yet.</p>
    @else
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px;">
            @foreach($recentCareLogs as $log)
                <div style="background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0; padding: 16px;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                        <span class="status-pill" style="background: #ecfdf5; color: #064e3b;">
                            {{ ucfirst($log->category) }}
                        </span>
                        <span style="font-size: 11px; font-family: var(--font-mono, monospace); color: #64748b;">
                            {{ \Carbon\Carbon::parse($log->logged_at)->diffForHumans() }}
                        </span>
                    </div>
                    <strong style="color: #091a13; font-size: 13.5px; display: block; margin-bottom: 4px;">
                        Patient: {{ $log->listing?->pet_name ?? 'Companion' }}
                    </strong>
                    <p style="font-size: 12.5px; color: #475569; margin: 0; line-height: 1.4;">{{ $log->notes }}</p>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Add Adoptable Animal Modal (SRS 1.6) -->
<div id="newListingModal" class="shelter-modal-overlay" onclick="if(event.target===this) closeNewListingModal()">
    <div class="shelter-modal-card">
        <div class="shelter-modal-header">
            <div class="shelter-modal-header-left">
                <div class="shelter-modal-icon-badge">🐾</div>
                <div>
                    <h3 class="shelter-modal-title">List New Adoptable Companion</h3>
                    <p class="shelter-modal-subtitle">Publish an animal profile to the sanctuary adoption gallery.</p>
                </div>
            </div>
            <button type="button" class="shelter-modal-close" onclick="closeNewListingModal()" aria-label="Close modal">✕</button>
        </div>

        <form method="POST" action="{{ route('shelter.listings.store') }}">
            @csrf
            <div class="shelter-modal-body">
                <div class="shelter-form-grid">
                    <div class="shelter-form-group">
                        <label class="shelter-form-label"><span>Pet Name</span><span class="req">*</span></label>
                        <input type="text" name="pet_name" required class="shelter-input" placeholder="e.g. Charlie">
                    </div>
                    <div class="shelter-form-group">
                        <label class="shelter-form-label"><span>Species</span><span class="req">*</span></label>
                        <input type="text" name="species" required class="shelter-input" placeholder="e.g. Dog, Cat, Bird">
                    </div>
                </div>

                <div class="shelter-form-grid">
                    <div class="shelter-form-group">
                        <label class="shelter-form-label"><span>Breed</span><span class="req">*</span></label>
                        <input type="text" name="breed" required class="shelter-input" placeholder="e.g. Golden Retriever">
                    </div>
                    <div class="shelter-form-group">
                        <label class="shelter-form-label"><span>Age Representation</span><span class="req">*</span></label>
                        <input type="text" name="age_text" required class="shelter-input" placeholder="e.g. 2 Years">
                    </div>
                </div>

                <div class="shelter-form-group">
                    <label class="shelter-form-label"><span>Gender / Sex</span><span class="req">*</span></label>
                    <select name="sex" class="shelter-select">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Unknown">Unknown</option>
                    </select>
                </div>

                <div class="shelter-form-group">
                    <label class="shelter-form-label"><span>Health & Vaccination Status</span></label>
                    <input type="text" name="health_summary" class="shelter-input" placeholder="e.g. Fully vaccinated, dewormed, neutered">
                </div>

                <div class="shelter-form-group" style="margin-bottom: 0;">
                    <label class="shelter-form-label"><span>Care Routine & Temperament</span></label>
                    <textarea name="care_summary" rows="3" class="shelter-textarea" placeholder="e.g. Gentle with children, needs 30min daily walk, fond of squeaky toys..."></textarea>
                </div>
            </div>

            <div class="shelter-modal-footer">
                <button type="button" onclick="closeNewListingModal()" class="shelter-btn-cancel">Cancel</button>
                <button type="submit" class="shelter-btn-submit">Publish to Adoption Gallery ✓</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
function openNewListingModal() {
    const modal = document.getElementById('newListingModal');
    modal.style.display = 'flex';
    requestAnimationFrame(() => {
        modal.classList.add('active');
    });
    document.body.style.overflow = 'hidden';
}
function closeNewListingModal() {
    const modal = document.getElementById('newListingModal');
    modal.classList.remove('active');
    setTimeout(() => {
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }, 150);
}
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeNewListingModal();
});
</script>
@endsection
