@extends('owner.layouts.app')

@section('title', 'My Pets')

@section('content')
<div class="owner-subpage-card">
    <div class="owner-subpage-header">
        <div class="owner-subpage-title">
            <span>🐾</span> My Beloved Pets ({{ $pets->count() }})
        </div>
        <button type="button" class="owner-btn owner-btn-primary" onclick="openOwnerModal('addPetModal')">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Add New Pet
        </button>
    </div>
    <div class="owner-subpage-body">
        <div class="owner-cards-grid">
            @forelse($pets as $pet)
                <div style="border: 1px solid var(--border); border-radius: 12px; padding: 18px; background: #ffffff; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                    <div style="display: flex; gap: 14px; margin-bottom: 14px;">
                        <div style="width: 70px; height: 70px; border-radius: 12px; overflow: hidden; background: #f1f5f9; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: 28px;">
                            @if(strtolower($pet->name) === 'buddy')
                                <img src="/images/buddy.jpg" alt="Buddy" style="width: 100%; height: 100%; object-fit: cover;">
                            @elseif(strtolower($pet->name) === 'luna')
                                <img src="/images/luna.jpg" alt="Luna" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                {{ strtolower($pet->species) === 'dog' ? '🐕' : (strtolower($pet->species) === 'cat' ? '🐈' : '🐾') }}
                            @endif
                        </div>
                        <div style="flex: 1;">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <strong style="font-size: 16px; color: #0f172a;">{{ $pet->name }}</strong>
                                <span style="background: #ecfdf5; color: #065f46; font-size: 10.5px; font-weight: 700; padding: 2px 8px; border-radius: 12px;">
                                    {{ $pet->species }}
                                </span>
                            </div>
                            <div style="font-size: 12px; color: #64748b; margin-top: 2px;">{{ $pet->breed ?? 'Mixed Breed' }}</div>
                            <div style="font-size: 11.5px; color: #10b981; font-weight: 600; margin-top: 4px;">
                                {{ $pet->sex ? ucfirst($pet->sex) : 'Unknown' }} · {{ $pet->weight_kg ? $pet->weight_kg . ' kg' : 'Normal weight' }}
                            </div>
                        </div>
                    </div>

                    <div style="background: #f8fafc; border-radius: 8px; padding: 10px 12px; font-size: 11.5px; color: #475569; margin-bottom: 14px;">
                        <div style="margin-bottom: 3px;"><strong>Microchip:</strong> <span style="font-family: monospace;">{{ $pet->microchip_number ?? 'Not registered' }}</span></div>
                        <div><strong>Age:</strong> {{ $pet->date_of_birth ? \Carbon\Carbon::parse($pet->date_of_birth)->age . ' years old' : 'Unknown' }}</div>
                        @if($pet->notes)
                            <div style="margin-top: 4px; color: #64748b;"><em>Note: {{ $pet->notes }}</em></div>
                        @endif
                    </div>

                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 10px; border-top: 1px solid #f1f5f9; padding-top: 12px; flex-wrap: wrap;">
                        <a href="{{ route('owner.appointments') }}" class="owner-btn owner-btn-secondary" style="font-size: 11px; padding: 5px 10px;">
                            Book Vet Visit
                        </a>
                        <form method="POST" action="{{ route('owner.pets.delete', $pet) }}" onsubmit="return confirm('Remove {{ $pet->name }} from your profile?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="owner-btn owner-btn-danger" style="font-size: 11px; padding: 5px 10px;">
                                Remove
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #64748b;">
                    <span style="font-size: 40px; display: block; margin-bottom: 10px;">🐾</span>
                    <h4>No pets added yet</h4>
                    <p style="font-size: 12.5px;">Click 'Add New Pet' to register your first furry companion!</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Add Pet Modal -->
<div class="owner-modal-overlay" id="addPetModal">
    <div class="owner-modal-box">
        <div class="owner-modal-header">
            <h3>Register New Pet</h3>
            <button class="owner-modal-close" onclick="closeOwnerModal('addPetModal')">&times;</button>
        </div>
        <form method="POST" action="{{ route('owner.pets.store') }}">
            @csrf
            <div class="owner-modal-body">
                <div style="margin-bottom: 12px;">
                    <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 4px;">Pet Name *</label>
                    <input type="text" name="name" required style="width: 100%; padding: 8px 12px; border: 1px solid var(--border); border-radius: 8px;" placeholder="e.g. Max">
                </div>
                <div class="owner-form-row">
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 4px;">Species *</label>
                        <select name="species" required style="width: 100%; padding: 8px 12px; border: 1px solid var(--border); border-radius: 8px;">
                            <option value="Dog">Dog</option>
                            <option value="Cat">Cat</option>
                            <option value="Bird">Bird</option>
                            <option value="Rabbit">Rabbit</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 4px;">Sex *</label>
                        <select name="sex" required style="width: 100%; padding: 8px 12px; border: 1px solid var(--border); border-radius: 8px;">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="unknown">Unknown</option>
                        </select>
                    </div>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 12px;">
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 4px;">Breed</label>
                        <input type="text" name="breed" style="width: 100%; padding: 8px 12px; border: 1px solid var(--border); border-radius: 8px;" placeholder="e.g. French Bulldog">
                    </div>
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 4px;">Weight (kg)</label>
                        <input type="number" step="0.1" name="weight_kg" style="width: 100%; padding: 8px 12px; border: 1px solid var(--border); border-radius: 8px;" placeholder="e.g. 12.4">
                    </div>
                </div>
                <div style="margin-bottom: 12px;">
                    <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 4px;">Microchip Number</label>
                    <input type="text" name="microchip_number" style="width: 100%; padding: 8px 12px; border: 1px solid var(--border); border-radius: 8px;" placeholder="Optional 15-digit code">
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 4px;">Notes / Allergies</label>
                    <textarea name="notes" style="width: 100%; padding: 8px 12px; border: 1px solid var(--border); border-radius: 8px; min-height: 70px;" placeholder="Any special needs or favorite habits..."></textarea>
                </div>
            </div>
            <div class="owner-modal-footer">
                <button type="button" class="owner-btn owner-btn-secondary" onclick="closeOwnerModal('addPetModal')">Cancel</button>
                <button type="submit" class="owner-btn owner-btn-primary">Save Pet</button>
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
