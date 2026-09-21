@extends('frontend.layouts.app')

@section('title', 'Adopt a Pet, Change a Life — FurShield')

@section('content')
<div class="container section">

    <!-- 1. Editorial Hero -->
    <div class="fe-hero-shell reveal" style="margin-bottom: 72px;">
        <div class="fe-hero-content">
            <div class="kicker">Rescue & Rehoming</div>
            <h1 class="fe-hero-title">
                Adopt a friend,<br>
                <em>change a life.</em>
            </h1>
            <p class="fe-hero-desc">
                Provide a secure, permanent home to a rescue animal. Our shelter network connects vetted adopters with companions ready for a lifetime of loyalty.
            </p>
            <div class="fe-hero-actions">
                <a href="#adoptables" class="btn btn-primary">
                    <span>Browse Pets</span>
                    <span class="btn-arrow">↓</span>
                </a>
            </div>
        </div>

        <!-- Rescue Showcase Composite Hero Card (White, Black, Green Theme) -->
        <div class="adopt-storm-card-wrap">
            <div class="adopt-storm-card">
                <!-- Left Offset Panel with Wordmark -->
                <div class="adopt-storm-left">
                    <div class="adopt-storm-wordmark">FURSHIELD</div>
                </div>

                <!-- Right Overlapping Panel -->
                <div class="adopt-storm-right">
                    <!-- Breakout Focal Companion Image -->
                    <img src="/images/charlie.jpg" alt="Featured Rescue Companion" class="adopt-storm-focal" />

                    <div class="adopt-storm-info">
                        <h1>CHARLIE <span>Golden Retriever</span></h1>
                        <h2>Verified Rescue</h2>

                        <div class="adopt-storm-details">
                            <div class="adopt-storm-size">
                                <h4>COMPANION AGE</h4>
                                <div class="adopt-storm-pills">
                                    <span>P</span>
                                    <span class="active">Y</span>
                                    <span>A</span>
                                    <span>S</span>
                                </div>
                            </div>

                            <div class="adopt-storm-durability">
                                <div class="adopt-storm-gauge">
                                    <span>99%</span>
                                </div>
                                <h4>VETTED &amp;<br>VACCINATED</h4>
                            </div>
                        </div>

                        <div class="adopt-storm-actions">
                            <button type="button" onclick="openAdoptModal(1, 'Charlie')" class="adopt-storm-btn">
                                <span>Adopt Now</span>
                                <span class="btn-arrow">↗</span>
                            </button>
                            <button type="button" class="adopt-storm-fav" title="Save to favorites" aria-label="Favorite">
                                <i class="fas fa-heart"></i>
                            </button>
                            <a href="#adoptables" class="adopt-storm-link">All Pets</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Adoptable Pets Gallery -->
    <div id="adoptables" class="reveal delay-1">
        <div class="section-head-split">
            <div>
                <div class="section-label">01 — Available Companions</div>
                <h2>Featured Pets for Adoption</h2>
                <p>All companions are health-checked, vaccinated and monitored by partner shelters.</p>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(min(100%, 320px), 1fr)); gap: 24px;">
            @php
                $samplePets = [
                    ['name' => 'Charlie', 'sub' => '2 years • Dog', 'traits' => 'Loyal & Friendly', 'img' => '/images/charlie.jpg'],
                    ['name' => 'Bella', 'sub' => '1 year • Cat', 'traits' => 'Playful & Calm', 'img' => '/images/bella.jpg'],
                    ['name' => 'Rocky', 'sub' => '3 years • Dog', 'traits' => 'Gentle & Smart', 'img' => '/images/rocky.jpg'],
                ];
            @endphp

            @foreach($samplePets as $idx => $sample)
                @php
                    $listing = $adoptablePets[$idx] ?? $adoptablePets->first();
                    $listingId = $listing ? $listing->id : 1;
                @endphp
                <div class="card adoption-split-card">
                    <div class="card-text">
                        <div class="portada" style="background-image: url('{{ $sample['img'] }}');">
                            <span class="portada-badge">Available</span>
                        </div>

                        <div class="title-total">
                            <div>
                                <div class="title">{{ $sample['sub'] }}</div>
                                <h2>{{ $sample['name'] }}</h2>
                                <div class="desc">
                                    {{ $sample['traits'] }} • Fully vaccinated, socialized and ready for loving home placement.
                                </div>
                            </div>

                            <div>
                                <div class="actions">
                                    <button type="button" class="adopt-icon-btn" title="Add to Favorites" aria-label="Favorite"><i class="far fa-heart"></i></button>
                                    <button type="button" class="adopt-icon-btn" title="Shelter Inquiries" aria-label="Contact Shelter"><i class="far fa-envelope"></i></button>
                                    <button type="button" class="adopt-icon-btn" onclick="openAdoptModal({{ $listingId }}, '{{ $sample['name'] }}')" title="Adopt {{ $sample['name'] }}" aria-label="Adopt Companion"><i class="fas fa-paw"></i></button>
                                </div>

                                <button type="button" 
                                        onclick="openAdoptModal({{ $listingId }}, '{{ $sample['name'] }}')" 
                                        class="btn btn-primary btn-sm btn-block adopt-submit-btn">
                                    <span>Apply for Adoption</span>
                                    <span class="btn-arrow">↗</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>

<!-- Adoption Modal (Preserved Functionality) -->
<div id="adoptModal" class="fe-modal-overlay" onclick="if(event.target===this) closeAdoptModal()">
    <div class="fe-modal-card">
        <div class="fe-modal-header">
            <div>
                <h3 style="font-size: 1.25rem; margin: 0 0 4px 0;">Adoption Application</h3>
                <p id="modalAdoptName" class="meta-label" style="color: var(--emerald); margin: 0;"></p>
            </div>
            <button type="button" onclick="closeAdoptModal()" class="fe-modal-close" aria-label="Close modal">&times;</button>
        </div>

        <form id="adoptForm" action="" method="POST" class="fe-modal-form">
            @csrf
            <div class="fe-modal-body">
                <div class="form-group">
                    <label class="form-label">Full Name *</label>
                    <input type="text" name="applicant_name" required value="Sarah Johnson" class="form-control">
                </div>

                <div class="fe-modal-grid">
                    <div class="form-group">
                        <label class="form-label">Email Address *</label>
                        <input type="email" name="applicant_email" required value="sarah@example.com" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Phone Number *</label>
                        <input type="text" name="applicant_phone" required value="+1 (555) 019-2834" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Household & Experience Details</label>
                    <textarea name="notes" rows="3" class="form-control" placeholder="Describe your living environment, garden/yard, work schedule, and prior pet experience..."></textarea>
                </div>
            </div>

            <div class="fe-modal-footer">
                <button type="button" onclick="closeAdoptModal()" class="btn btn-secondary btn-sm">Cancel</button>
                <button type="submit" class="btn btn-primary btn-sm">Submit Application</button>
            </div>
        </form>
    </div>
</div>

<script>
function openAdoptModal(petId, petName) {
    document.getElementById('modalAdoptName').textContent = 'Applying to adopt ' + petName;
    document.getElementById('adoptForm').action = '/adoption/' + petId + '/apply';
    document.getElementById('adoptModal').style.display = 'flex';
}
function closeAdoptModal() {
    document.getElementById('adoptModal').style.display = 'none';
}
</script>
@endsection
