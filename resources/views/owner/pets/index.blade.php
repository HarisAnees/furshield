@extends('owner.layouts.app')

@section('title', 'My Pets')

@section('content')
<div class="owner-subpage-card">
    <div class="owner-subpage-header">
        <div class="owner-subpage-title">
            <i class="fa-solid fa-shield-heart" style="color: #10b981;"></i> My Registered Pets ({{ $pets->count() }})
        </div>
        <button type="button" class="owner-btn owner-btn-primary" onclick="openOwnerModal('addPetModal')">
            <i class="fa-solid fa-plus"></i>
            Add New Pet
        </button>
    </div>
    <div class="owner-subpage-body">
        <div class="owner-cards-grid">
            @forelse($pets as $pet)
                @php
                    $pName = strtolower(trim($pet->name));
                    $pSpecies = strtolower(trim($pet->species));
                    $imageMap = [
                        'buddy' => '/images/buddy.jpg',
                        'luna' => '/images/luna.jpg',
                        'max' => '/images/max.jpg',
                        'bella' => '/images/bella.jpg',
                        'charlie' => '/images/charlie.jpg',
                        'rocky' => '/images/rocky.jpg',
                    ];
                    $imgSrc = $imageMap[$pName] ?? null;
                    if (!$imgSrc) {
                        if ($pSpecies === 'dog') {
                            $imgSrc = '/images/buddy.jpg';
                        } elseif ($pSpecies === 'cat') {
                            $imgSrc = '/images/luna.jpg';
                        }
                    }
                @endphp
                <div style="border: 1px solid var(--border); border-radius: 14px; padding: 20px; background: #ffffff; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 1px 3px rgba(0,0,0,0.03); transition: transform 0.2s ease, box-shadow 0.2s ease;">
                    <div style="display: flex; gap: 16px; margin-bottom: 16px;">
                        <div style="width: 72px; height: 72px; border-radius: 12px; overflow: hidden; background: #f1f5f9; flex-shrink: 0; display: flex; align-items: center; justify-content: center; border: 1px solid #e2e8f0;">
                            @if($imgSrc)
                                <img src="{{ $imgSrc }}" alt="{{ $pet->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #ecfdf5; color: #059669;">
                                    <i class="fa-solid fa-shield-cat" style="font-size: 26px;"></i>
                                </div>
                            @endif
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <div style="display: flex; align-items: center; justify-content: space-between; gap: 8px;">
                                <strong style="font-size: 16px; color: #0f172a; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $pet->name }}</strong>
                                <span style="background: #ecfdf5; color: #065f46; font-size: 11px; font-weight: 700; padding: 3px 9px; border-radius: 9999px; white-space: nowrap; border: 1px solid rgba(16, 185, 129, 0.2);">
                                    {{ $pet->species }}
                                </span>
                            </div>
                            <div style="font-size: 12.5px; color: #64748b; margin-top: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $pet->breed ?? 'Domestic Mixed' }}</div>
                            <div style="font-size: 11.5px; color: #059669; font-weight: 600; margin-top: 4px; display: flex; align-items: center; gap: 6px;">
                                <span><i class="fa-solid fa-venus-mars" style="font-size: 11px;"></i> {{ $pet->sex ? ucfirst($pet->sex) : 'Unknown' }}</span>
                                <span>•</span>
                                <span><i class="fa-solid fa-weight-scale" style="font-size: 11px;"></i> {{ $pet->weight_kg ? $pet->weight_kg . ' kg' : 'Standard Weight' }}</span>
                            </div>
                        </div>
                    </div>

                    <div style="background: #f8fafc; border: 1px solid #f1f5f9; border-radius: 10px; padding: 12px 14px; font-size: 12px; color: #475569; margin-bottom: 16px;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                            <span style="color: #64748b;">Microchip:</span>
                            <span style="font-family: monospace; font-weight: 600; color: #0f172a;">{{ $pet->microchip_number ?? 'Not registered' }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                            <span style="color: #64748b;">Age:</span>
                            <span style="font-weight: 600; color: #0f172a;">{{ $pet->date_of_birth ? \Carbon\Carbon::parse($pet->date_of_birth)->age . ' years old' : 'Age recorded' }}</span>
                        </div>
                        @if($pet->notes)
                            <div style="margin-top: 6px; padding-top: 6px; border-top: 1px dashed #e2e8f0; color: #64748b; font-size: 11.5px;">
                                <i class="fa-solid fa-notes-medical" style="color: #059669; margin-right: 4px;"></i> {{ Str::limit($pet->notes, 60) }}
                            </div>
                        @endif
                    </div>

                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 10px; border-top: 1px solid #f1f5f9; padding-top: 14px; flex-wrap: wrap;">
                        <a href="{{ route('owner.appointments') }}" class="owner-btn owner-btn-secondary" style="font-size: 11.5px; padding: 6px 12px;">
                            <i class="fa-solid fa-calendar-check" style="color: #059669;"></i> Book Vet Visit
                        </a>
                        <form method="POST" action="{{ route('owner.pets.delete', $pet) }}" onsubmit="return confirm('Remove {{ $pet->name }} from Sarah\'s clinical profile?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="owner-btn owner-btn-danger" style="font-size: 11.5px; padding: 6px 12px;">
                                <i class="fa-solid fa-trash-can"></i> Remove
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 48px 24px; color: #64748b; background: #ffffff; border: 1px dashed #cbd5e1; border-radius: 16px;">
                    <div style="width: 56px; height: 56px; border-radius: 50%; background: #ecfdf5; color: #059669; display: inline-flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 14px;">
                        <i class="fa-solid fa-paw"></i>
                    </div>
                    <h4 style="font-size: 16px; font-weight: 700; color: #0f172a; margin-bottom: 6px;">No Registered Companions Yet</h4>
                    <p style="font-size: 13px; color: #64748b; max-width: 380px; margin: 0 auto 18px;">Register your pet to manage clinical appointments, vaccination schedules, and verified nutrition records.</p>
                    <button type="button" class="owner-btn owner-btn-primary" onclick="openOwnerModal('addPetModal')">
                        <i class="fa-solid fa-plus"></i> Register First Companion
                    </button>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Add Pet Modal (Fully Responsive for Mobile, Tablet, Desktop) -->
<div class="owner-modal-overlay" id="addPetModal">
    <div class="owner-modal-box">
        <div class="owner-modal-header">
            <div class="owner-modal-header-left">
                <div class="owner-modal-icon-badge">
                    <i class="fa-solid fa-paw"></i>
                </div>
                <div>
                    <h3 class="owner-modal-title">Register Companion</h3>
                    <p class="owner-modal-subtitle">Add companion profile to Sarah's clinical health records</p>
                </div>
            </div>
            <button class="owner-modal-close" onclick="closeOwnerModal('addPetModal')" aria-label="Close Modal">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <form method="POST" action="{{ route('owner.pets.store') }}">
            @csrf
            <div class="owner-modal-body">
                <div class="owner-form-row">
                    <div class="owner-form-group">
                        <label for="pet_name"><i class="fa-solid fa-tag" style="color: #059669;"></i> Pet Name *</label>
                        <input type="text" id="pet_name" name="name" required placeholder="e.g. Bella, Max, Oliver" autocomplete="off">
                    </div>
                    <div class="owner-form-group">
                        <label for="pet_species"><i class="fa-solid fa-dna" style="color: #059669;"></i> Species *</label>
                        <select id="pet_species" name="species" required>
                            <option value="Dog">Dog (Canine)</option>
                            <option value="Cat">Cat (Feline)</option>
                            <option value="Bird">Bird (Avian)</option>
                            <option value="Rabbit">Rabbit (Lagomorph)</option>
                            <option value="Other">Other Companion</option>
                        </select>
                    </div>
                </div>

                <div class="owner-form-row">
                    <div class="owner-form-group">
                        <label for="pet_breed"><i class="fa-solid fa-paw" style="color: #059669;"></i> Breed</label>
                        <input type="text" id="pet_breed" name="breed" placeholder="e.g. Golden Retriever, Siamese">
                    </div>
                    <div class="owner-form-group">
                        <label for="pet_sex"><i class="fa-solid fa-venus-mars" style="color: #059669;"></i> Biological Sex *</label>
                        <select id="pet_sex" name="sex" required>
                            <option value="male">Male (Neutered / Intact)</option>
                            <option value="female">Female (Spayed / Intact)</option>
                            <option value="unknown">Unknown</option>
                        </select>
                    </div>
                </div>

                <div class="owner-form-row">
                    <div class="owner-form-group">
                        <label for="pet_dob"><i class="fa-solid fa-calendar-days" style="color: #059669;"></i> Date of Birth</label>
                        <input type="date" id="pet_dob" name="date_of_birth">
                    </div>
                    <div class="owner-form-group">
                        <label for="pet_weight"><i class="fa-solid fa-weight-scale" style="color: #059669;"></i> Weight (kg)</label>
                        <input type="number" step="0.1" min="0.1" max="200" id="pet_weight" name="weight_kg" placeholder="e.g. 8.5">
                    </div>
                </div>

                <div class="owner-form-group">
                    <label for="pet_microchip"><i class="fa-solid fa-microchip" style="color: #059669;"></i> Microchip Identifier (Optional)</label>
                    <input type="text" id="pet_microchip" name="microchip_number" placeholder="Standard 15-digit ISO microchip code">
                </div>

                <div class="owner-form-group" style="margin-bottom: 0;">
                    <label for="pet_notes"><i class="fa-solid fa-notes-medical" style="color: #059669;"></i> Clinical Notes & Special Requirements</label>
                    <textarea id="pet_notes" name="notes" rows="3" placeholder="Document existing allergies, special dietary restrictions, behavioral notes..."></textarea>
                </div>
            </div>
            <div class="owner-modal-footer">
                <button type="button" class="owner-btn owner-btn-secondary" onclick="closeOwnerModal('addPetModal')">Cancel</button>
                <button type="submit" class="owner-btn owner-btn-primary">
                    <i class="fa-solid fa-shield-cat"></i> Register Companion
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openOwnerModal(id) { 
    const el = document.getElementById(id);
    if (el) {
        el.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}
function closeOwnerModal(id) { 
    const el = document.getElementById(id);
    if (el) {
        el.classList.remove('active');
        document.body.style.overflow = '';
    }
}
document.querySelectorAll('.owner-modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) {
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }
    });
});
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        document.querySelectorAll('.owner-modal-overlay.active').forEach(m => {
            m.classList.remove('active');
            document.body.style.overflow = '';
        });
    }
});
</script>
@endsection
