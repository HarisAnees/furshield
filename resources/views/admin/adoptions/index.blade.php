@extends('admin.layouts.app')

@section('title', 'Adoption Listings')
@section('page_title', 'Pet Adoption Management')
@section('page_subtitle', 'Manage shelter rescue profiles, incoming adoption applications, and placement statuses.')

@section('content')
<div class="crud-toolbar">
    <div class="filter-pills">
        <a href="{{ route('admin.adoptions.index') }}" class="filter-pill-link {{ !request('status') ? 'active' : '' }}">
            All Rescue Pets
        </a>
        <a href="{{ route('admin.adoptions.index', ['status' => 'available']) }}" class="filter-pill-link {{ request('status') === 'available' ? 'active' : '' }}">
            Available
        </a>
        <a href="{{ route('admin.adoptions.index', ['status' => 'pending']) }}" class="filter-pill-link {{ request('status') === 'pending' ? 'active' : '' }}">
            Pending
        </a>
        <a href="{{ route('admin.adoptions.index', ['status' => 'adopted']) }}" class="filter-pill-link {{ request('status') === 'adopted' ? 'active' : '' }}">
            Adopted
        </a>
    </div>

    <div class="toolbar-actions">
        <form method="GET" action="{{ route('admin.adoptions.index') }}" class="toolbar-search">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <input type="text" name="search" class="form-control" placeholder="Search rescue pet, breed..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-secondary btn-sm">Search</button>
            @if(request('search'))
                <a href="{{ route('admin.adoptions.index', request()->only('status')) }}" class="btn btn-outline btn-sm">Clear</a>
            @endif
        </form>

        <button type="button" class="btn btn-primary" onclick="openModal('createAdoptionModal')">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Add Rescue Pet
        </button>
    </div>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Rescue Pet</th>
                    <th>Shelter Partner</th>
                    <th>Species & Breed</th>
                    <th>Age & Sex</th>
                    <th>Health & Temperament</th>
                    <th>Status</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($listings as $item)
                    <tr>
                        <td>
                            <div class="user-info-cell">
                                <div class="user-avatar-sm" style="background: #ecfdf5; color: #059669; font-size: 14px;">
                                    <i class="fa-solid fa-shield-cat"></i>
                                </div>
                                <div class="user-info-meta">
                                    <strong style="color: #0f172a;">{{ $item->pet_name }}</strong>
                                    <small style="color: #64748b;">Listed {{ $item->created_at ? $item->created_at->diffForHumans() : 'recently' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 600; color: #0f172a; font-size: 12.5px;">
                                {{ $item->shelter->shelter_name ?? 'Happy Paws Rescue' }}
                            </div>
                            <small style="color: #64748b;">{{ $item->shelter->city ?? 'Local Shelter' }}</small>
                        </td>
                        <td>
                            <span class="badge badge-teal">{{ $item->species }}</span>
                            <div style="font-size: 11.5px; color: #475569; margin-top: 3px;">{{ $item->breed ?? 'Mixed' }}</div>
                        </td>
                        <td>
                            <div style="font-size: 12px; color: #334155; font-weight: 500;">
                                {{ $item->age_text ?? 'Young' }}
                            </div>
                            <small style="color: #64748b; text-transform: capitalize;">{{ $item->sex }}</small>
                        </td>
                        <td style="max-width: 240px;">
                            <span style="font-size: 11.5px; color: #475569; line-height: 1.3; display: block;">
                                {{ \Illuminate\Support\Str::limit($item->health_summary ?? 'Vaccinated, dewormed and neutered/spayed.', 70) }}
                            </span>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.adoptions.status', $item) }}">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="form-select" style="padding: 3px 8px; font-size: 11px; font-weight: 600; width: auto; border-radius: 20px;
                                    @if($item->status === 'available') background: #dcfce7; color: #15803d; border-color: #86efac;
                                    @elseif($item->status === 'pending') background: #fef3c7; color: #b45309; border-color: #fde68a;
                                    @else background: #e0f2fe; color: #0369a1; border-color: #bae6fd; @endif">
                                    <option value="available" {{ $item->status === 'available' ? 'selected' : '' }}>Available</option>
                                    <option value="pending" {{ $item->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="adopted" {{ $item->status === 'adopted' ? 'selected' : '' }}>Adopted</option>
                                </select>
                            </form>
                        </td>
                        <td style="text-align: right;">
                            <form method="POST" action="{{ route('admin.adoptions.destroy', $item) }}" onsubmit="return confirm('Remove {{ $item->pet_name }} from adoption list?');" style="display: inline;">
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
                                <span class="empty-state-icon"><i class="fa-solid fa-paw" style="color: #059669;"></i></span>
                                <h4>No adoption listings found</h4>
                                <p>Add shelter animals looking for a loving forever home.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($listings->hasPages())
        <div style="padding: 16px 20px; border-top: 1px solid var(--border);">
            {{ $listings->links() }}
        </div>
    @endif
</div>

<!-- Create Adoption Modal -->
<div class="modal-overlay" id="createAdoptionModal">
    <div class="modal-box">
        <div class="modal-header">
            <div>
                <span class="modal-tag">Rescue & Adoption</span>
                <h3>Add Rescue Pet for Adoption</h3>
            </div>
            <button type="button" class="modal-close-btn" onclick="closeModal('createAdoptionModal')" aria-label="Close modal">&times;</button>
        </div>
        <form method="POST" action="{{ route('admin.adoptions.store') }}">
            @csrf
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Pet Name *</label>
                        <input type="text" name="pet_name" class="form-control" required placeholder="e.g. Milo">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Shelter *</label>
                        <select name="shelter_id" class="form-select" required>
                            @foreach($shelters as $sh)
                                <option value="{{ $sh->id }}">{{ $sh->shelter_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Species *</label>
                        <select name="species" class="form-select" required>
                            <option value="Dog">Dog</option>
                            <option value="Cat">Cat</option>
                            <option value="Rabbit">Rabbit</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Breed</label>
                        <input type="text" name="breed" class="form-control" placeholder="e.g. Beagle / Hound Mix">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Age Description</label>
                        <input type="text" name="age_text" class="form-control" placeholder="e.g. 1.5 Years Old">
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
                <div class="form-group">
                    <label class="form-label">Status *</label>
                    <select name="status" class="form-select" required>
                        <option value="available" selected>Available for Adoption</option>
                        <option value="pending">Pending Application</option>
                        <option value="adopted">Adopted</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Health Summary & Temperament</label>
                    <textarea name="health_summary" class="form-textarea" placeholder="Fully vaccinated, good with kids, calm demeanor..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('createAdoptionModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Publish Rescue Pet</button>
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
