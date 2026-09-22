@extends('admin.layouts.app')

@section('title', 'Pets Management')
@section('page_title', 'Pets Directory')
@section('page_subtitle', 'Comprehensive registry of all pets, medical identifiers, and their registered owners.')

@section('content')
<div class="crud-toolbar">
    <div class="filter-pills">
        <a href="{{ route('admin.pets.index') }}" class="filter-pill-link {{ !request('species') ? 'active' : '' }}">
            All Pets
        </a>
        <a href="{{ route('admin.pets.index', ['species' => 'Dog']) }}" class="filter-pill-link {{ request('species') === 'Dog' ? 'active' : '' }}">
            <i class="fa-solid fa-dog" style="color: #059669; margin-right: 4px;"></i> Dogs
        </a>
        <a href="{{ route('admin.pets.index', ['species' => 'Cat']) }}" class="filter-pill-link {{ request('species') === 'Cat' ? 'active' : '' }}">
            <i class="fa-solid fa-cat" style="color: #059669; margin-right: 4px;"></i> Cats
        </a>
        <a href="{{ route('admin.pets.index', ['species' => 'Bird']) }}" class="filter-pill-link {{ request('species') === 'Bird' ? 'active' : '' }}">
            <i class="fa-solid fa-dove" style="color: #059669; margin-right: 4px;"></i> Birds
        </a>
    </div>

    <div class="toolbar-actions">
        <form method="GET" action="{{ route('admin.pets.index') }}" class="toolbar-search">
            @if(request('species'))
                <input type="hidden" name="species" value="{{ request('species') }}">
            @endif
            <input type="text" name="search" class="form-control" placeholder="Search pet, breed, microchip..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-secondary btn-sm">Search</button>
            @if(request('search'))
                <a href="{{ route('admin.pets.index', request()->only('species')) }}" class="btn btn-outline btn-sm">Clear</a>
            @endif
        </form>

        <button type="button" class="btn btn-primary" onclick="openModal('createPetModal')">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Add New Pet
        </button>
    </div>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Pet Name</th>
                    <th>Owner</th>
                    <th>Species & Breed</th>
                    <th>Sex</th>
                    <th>Weight</th>
                    <th>Microchip</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
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
                            if ($pSpecies === 'dog') $imgSrc = '/images/buddy.jpg';
                            elseif ($pSpecies === 'cat') $imgSrc = '/images/luna.jpg';
                        }
                    @endphp
                    <tr>
                        <td>
                            <div class="user-info-cell">
                                <div class="user-avatar-sm" style="overflow: hidden; background: #ecfdf5; color: #059669; font-size: 14px; border: 1px solid #e2e8f0;">
                                    @if($imgSrc)
                                        <img src="{{ $imgSrc }}" alt="{{ $pet->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <i class="fa-solid fa-shield-cat"></i>
                                    @endif
                                </div>
                                <div class="user-info-meta">
                                    <strong>{{ $pet->name }}</strong>
                                    <small>{{ $pet->date_of_birth ? \Carbon\Carbon::parse($pet->date_of_birth)->age . ' yrs old' : 'Age unknown' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-size: 12.5px; font-weight: 600; color: #0f172a;">
                                {{ $pet->user->name ?? 'Unassigned' }}
                            </div>
                            <small style="color: #64748b;">{{ $pet->user->email ?? '' }}</small>
                        </td>
                        <td>
                            <div><strong>{{ $pet->species }}</strong></div>
                            <small style="color: #64748b;">{{ $pet->breed ?? 'Mixed' }}</small>
                        </td>
                        <td>
                            <span class="badge" style="background: #f1f5f9; color: #334155; font-size: 11px;">
                                {{ ucfirst($pet->sex ?? 'unknown') }}
                            </span>
                        </td>
                        <td>{{ $pet->weight_kg ? $pet->weight_kg . ' kg' : '—' }}</td>
                        <td>
                            <span style="font-family: var(--font-mono); font-size: 11.5px; color: #475569;">
                                {{ $pet->microchip_number ?? 'Not registered' }}
                            </span>
                        </td>
                        <td style="text-align: right;">
                            <div class="action-btn-group" style="justify-content: flex-end;">
                                <button type="button" class="btn btn-secondary btn-sm" onclick="editPet({{ $pet->toJson() }})">
                                    Edit
                                </button>
                                <form method="POST" action="{{ route('admin.pets.destroy', $pet) }}" onsubmit="return confirm('Delete this pet record permanently?');" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <span class="empty-state-icon"><i class="fa-solid fa-paw" style="color: #059669;"></i></span>
                                <h4>No pets registered yet</h4>
                                <p>Add pet profiles to start tracking their medical histories and appointments.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($pets->hasPages())
        <div style="padding: 16px 20px; border-top: 1px solid var(--border);">
            {{ $pets->links() }}
        </div>
    @endif
</div>

<!-- Create Pet Modal -->
<div class="modal-overlay" id="createPetModal">
    <div class="modal-box">
        <div class="modal-header">
            <div>
                <span class="modal-tag">Patient Registry</span>
                <h3>Add New Pet</h3>
            </div>
            <button type="button" class="modal-close-btn" onclick="closeModal('createPetModal')" aria-label="Close modal">&times;</button>
        </div>
        <form method="POST" action="{{ route('admin.pets.store') }}">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Pet Owner *</label>
                    <select name="user_id" class="form-select" required>
                        <option value="">Select an owner...</option>
                        @foreach($owners as $owner)
                            <option value="{{ $owner->id }}">{{ $owner->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Pet Name *</label>
                        <input type="text" name="name" class="form-control" required placeholder="e.g. Buddy">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Species *</label>
                        <select name="species" class="form-select" required>
                            <option value="Dog">Dog</option>
                            <option value="Cat">Cat</option>
                            <option value="Bird">Bird</option>
                            <option value="Rabbit">Rabbit</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Breed</label>
                        <input type="text" name="breed" class="form-control" placeholder="e.g. Golden Retriever">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Sex *</label>
                        <select name="sex" class="form-select" required>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="unknown">Unknown</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Date of Birth</label>
                        <input type="date" name="date_of_birth" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Weight (kg)</label>
                        <input type="number" step="0.1" name="weight_kg" class="form-control" placeholder="e.g. 28.5">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Microchip ID</label>
                    <input type="text" name="microchip_number" class="form-control" placeholder="e.g. 985141002345678">
                </div>
                <div class="form-group">
                    <label class="form-label">Special Notes / Medical Allergies</label>
                    <textarea name="notes" class="form-textarea" placeholder="Friendly with other pets, allergic to chicken..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('createPetModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Pet</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Pet Modal -->
<div class="modal-overlay" id="editPetModal">
    <div class="modal-box">
        <div class="modal-header">
            <div>
                <span class="modal-tag">Patient Profile</span>
                <h3>Edit Pet Profile</h3>
            </div>
            <button type="button" class="modal-close-btn" onclick="closeModal('editPetModal')" aria-label="Close modal">&times;</button>
        </div>
        <form id="editPetForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Pet Owner *</label>
                    <select name="user_id" id="edit_pet_user_id" class="form-select" required>
                        @foreach($owners as $owner)
                            <option value="{{ $owner->id }}">{{ $owner->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Pet Name *</label>
                        <input type="text" name="name" id="edit_pet_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Species *</label>
                        <select name="species" id="edit_pet_species" class="form-select" required>
                            <option value="Dog">Dog</option>
                            <option value="Cat">Cat</option>
                            <option value="Bird">Bird</option>
                            <option value="Rabbit">Rabbit</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Breed</label>
                        <input type="text" name="breed" id="edit_pet_breed" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Sex *</label>
                        <select name="sex" id="edit_pet_sex" class="form-select" required>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="unknown">Unknown</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Date of Birth</label>
                        <input type="date" name="date_of_birth" id="edit_pet_dob" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Weight (kg)</label>
                        <input type="number" step="0.1" name="weight_kg" id="edit_pet_weight" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Microchip ID</label>
                    <input type="text" name="microchip_number" id="edit_pet_microchip" class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label">Special Notes / Medical Allergies</label>
                    <textarea name="notes" id="edit_pet_notes" class="form-textarea"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('editPetModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal(id) {
    document.getElementById(id).classList.add('active');
}
function closeModal(id) {
    document.getElementById(id).classList.remove('active');
}
function editPet(pet) {
    document.getElementById('editPetForm').action = '/admin/pets/' + pet.id;
    document.getElementById('edit_pet_user_id').value = pet.user_id;
    document.getElementById('edit_pet_name').value = pet.name || '';
    document.getElementById('edit_pet_species').value = pet.species || 'Dog';
    document.getElementById('edit_pet_breed').value = pet.breed || '';
    document.getElementById('edit_pet_sex').value = pet.sex || 'male';
    document.getElementById('edit_pet_dob').value = pet.date_of_birth ? pet.date_of_birth.substring(0, 10) : '';
    document.getElementById('edit_pet_weight').value = pet.weight_kg || '';
    document.getElementById('edit_pet_microchip').value = pet.microchip_number || '';
    document.getElementById('edit_pet_notes').value = pet.notes || '';
    openModal('editPetModal');
}
document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) overlay.classList.remove('active');
    });
});
</script>
@endsection
