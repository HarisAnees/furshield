@extends('frontend.layouts.app')

@section('title', 'Registered Pet Profiles — FurShield')

@section('content')
<div class="container section">

    <!-- 1. Header with Add Action -->
    <div class="section-head-split reveal">
        <div>
            <div class="section-label">Pet Directory</div>
            <h1>Registered <em>Companions</em></h1>
            <p>Manage health records, dietary protocols, reminders, and profile details for your pets.</p>
        </div>

        <button type="button" onclick="openAddPetModal()" class="btn btn-primary btn-sm">
            <span>+ Register New Pet</span>
        </button>
    </div>

    <!-- 2. Pets Grid -->
    <div class="pet-directory-grid reveal delay-1" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 28px; margin-bottom: 64px; align-items: start;">
        @forelse($pets as $index => $pet)
            @php
                $petImages = ['/images/buddy.jpg', '/images/luna.jpg', '/images/max.jpg'];
                $img = $petImages[$index % count($petImages)];
                if ($pet->photo_url) $img = $pet->photo_url;
                $ageText = '1 year';
                if ($pet->date_of_birth) {
                    $years = \Carbon\Carbon::parse($pet->date_of_birth)->age;
                    $ageText = $years > 0 ? "{$years} " . ($years === 1 ? 'year' : 'years') : "1 year";
                }
                $dobFormatted = $pet->date_of_birth 
                    ? \Carbon\Carbon::parse($pet->date_of_birth)->format('F d, Y') 
                    : $ageText . ' old';
            @endphp
            <div class="pet-fold-card">
                <header>
                    <div class="controls">
                        <div class="controls__back">
                            <span class="pet-id-pill">ID: FUR-{{ 1000 + $pet->id }}</span>
                        </div>
                        <div class="controls__forward">
                            <button type="button" class="fold-card-toggle" aria-label="Toggle details">
                                <i class="fas fa-bars"></i>
                                <span>More</span>
                            </button>
                        </div>
                    </div>

                    <figure>
                        <img src="{{ $img }}" alt="{{ $pet->name }}">
                    </figure>

                    <h1>
                        {{ $pet->name }}
                        <span class="verification" title="Verified Healthy">
                            <i class="fas fa-circle-check"></i>
                        </span>
                    </h1>

                    <h2>{{ $pet->breed ?? ucfirst($pet->species) }}</h2>
                    <p class="pet-dob">{{ $dobFormatted }}</p>
                    <p class="pronouns">
                        <span>{{ strtoupper($pet->sex ?? 'Companion') }}</span> &bull; 
                        <span>{{ ucfirst($pet->species) }}</span>
                    </p>
                </header>

                <main>
                    <blockquote>
                        <p>
                            {{ $pet->notes ?? 'Documented companion profile with verified vaccination status and recorded veterinary visits.' }}
                        </p>
                    </blockquote>

                    <div class="looking-for">
                        <div class="looking-for__icon">
                            <i class="fas fa-microchip"></i>
                        </div>
                        <div class="looking-for__description">
                            <div><strong>Chip:</strong> {{ $pet->microchip_number ?? 'FUR-CHIP-'.(1000 + $pet->id) }}</div>
                            <div><strong>Weight:</strong> {{ $pet->weight_kg ? $pet->weight_kg . ' kg' : 'Standard' }}</div>
                        </div>
                    </div>
                </main>

                <footer>
                    <div class="social">
                        <div class="social__icon">
                            <a href="{{ route('pets.show', $pet) }}" title="Clinical Records"><i class="fas fa-file-medical"></i></a>
                        </div>
                        <div class="social__icon">
                            <a href="{{ route('appointments.index') }}" title="Book Clinician"><i class="fas fa-calendar-plus"></i></a>
                        </div>
                        <div class="social__icon">
                            <a href="{{ route('care-tips.index') }}" title="Care Tips"><i class="fas fa-shield-heart"></i></a>
                        </div>
                        <div class="social__icon">
                            <a href="{{ route('pets.show', $pet) }}" title="Pet Profile"><i class="fas fa-paw"></i></a>
                        </div>
                    </div>

                    <a href="{{ route('pets.show', $pet) }}" class="btn-view-profile">
                        <span>View Pet Profile</span>
                        <span class="btn-arrow">→</span>
                    </a>
                </footer>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 64px 20px;" class="card">
                <div style="font-size: 2.5rem; margin-bottom: 12px;">🐾</div>
                <h3 style="font-size: 1.25rem; margin-bottom: 8px;">No Pets Registered Yet</h3>
                <p style="color: var(--muted); margin-bottom: 24px; max-width: 440px; margin-left: auto; margin-right: auto;">
                    Register your dog, cat or companion animal to document medical visits, track weights, and configure care reminders.
                </p>
                <button type="button" onclick="openAddPetModal()" class="btn btn-primary btn-sm">Register First Pet</button>
            </div>
        @endforelse
    </div>

    <!-- 3. Care Reminders Section -->
    <div class="card card-padded reveal delay-2">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <div>
                <div class="meta-label" style="margin-bottom: 4px;">Scheduled Protocols</div>
                <h2 style="font-size: 1.35rem;">Pet Care Reminders</h2>
            </div>
        </div>

        <div style="display: flex; flex-direction: column; gap: 12px;">
            <!-- Reminder 1 -->
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; background: var(--paper); border: 1px solid var(--border); border-radius: var(--radius-md);">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--emerald-soft); color: var(--emerald-dark); font-size: 1.1rem; display: flex; align-items: center; justify-content: center;">
                        🐾
                    </div>
                    <div>
                        <strong style="display: block; font-size: 0.95rem; margin-bottom: 2px;">Vaccination Protocol</strong>
                        <span class="meta-label" style="font-size: 11px;">Scheduled within 3 days</span>
                    </div>
                </div>
                <a href="{{ route('appointments.index') }}" class="btn btn-ghost btn-sm" style="font-weight: 600;">
                    Book Clinician →
                </a>
            </div>

            <!-- Reminder 2 -->
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; background: var(--paper); border: 1px solid var(--border); border-radius: var(--radius-md);">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: #e0f2fe; color: #0284c7; font-size: 1.1rem; display: flex; align-items: center; justify-content: center;">
                        ✂️
                    </div>
                    <div>
                        <strong style="display: block; font-size: 0.95rem; margin-bottom: 2px;">Grooming & Coat Check</strong>
                        <span class="meta-label" style="font-size: 11px;">Scheduled in 5 days</span>
                    </div>
                </div>
                <a href="{{ route('appointments.index') }}" class="btn btn-ghost btn-sm" style="font-weight: 600;">
                    Details →
                </a>
            </div>
        </div>
    </div>

</div>

<!-- Add Pet Modal (Preserved Functionality) -->
<div id="addPetModal" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(13, 15, 17, 0.65); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 20px;">
    <div class="card" style="max-width: 520px; width: 100%; max-height: 90vh; overflow-y: auto; box-shadow: var(--shadow-lg); background: var(--white); border-radius: var(--radius-lg);">
        <div style="padding: 24px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; background: var(--paper);">
            <h3 style="font-size: 1.25rem;">Register New Pet</h3>
            <button type="button" onclick="closeAddPetModal()" style="background: none; border: none; font-size: 1.5rem; color: var(--muted); cursor: pointer;" aria-label="Close modal">&times;</button>
        </div>

        <form action="{{ route('pets.store') }}" method="POST" style="padding: 24px;">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                <div class="form-group">
                    <label class="form-label">Pet Name *</label>
                    <input type="text" name="name" required placeholder="e.g. Buddy" class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label">Species *</label>
                    <select name="species" required class="form-control">
                        <option value="Dog">Dog</option>
                        <option value="Cat">Cat</option>
                        <option value="Bird">Bird</option>
                        <option value="Rabbit">Rabbit</option>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                <div class="form-group">
                    <label class="form-label">Breed</label>
                    <input type="text" name="breed" placeholder="e.g. Golden Retriever" class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label">Sex / Gender *</label>
                    <select name="sex" required class="form-control">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="unknown">Unknown</option>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                <div class="form-group">
                    <label class="form-label">Date of Birth</label>
                    <input type="date" name="date_of_birth" class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label">Weight (kg)</label>
                    <input type="number" step="0.1" name="weight_kg" placeholder="e.g. 28.5" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Health Notes & Characteristics</label>
                <textarea name="notes" rows="3" placeholder="Dietary restrictions, allergies, temperament..." class="form-control"></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px;">
                <button type="button" onclick="closeAddPetModal()" class="btn btn-secondary btn-sm">Cancel</button>
                <button type="submit" class="btn btn-primary btn-sm">Save Pet Profile</button>
            </div>
        </form>
    </div>
</div>

<script>
function openAddPetModal() {
    document.getElementById('addPetModal').style.display = 'flex';
}
function closeAddPetModal() {
    document.getElementById('addPetModal').style.display = 'none';
}
</script>
@endsection
