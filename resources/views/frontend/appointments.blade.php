@extends('frontend.layouts.app')

@section('title', 'Book a Veterinary Appointment — FurShield')

@section('content')
<div class="container section">

    <!-- 1. Editorial Header with Search Bar -->
    <div class="fe-hero-shell reveal" style="margin-bottom: 72px;">
        <div class="fe-hero-content">
            <div class="kicker">Veterinary Network</div>
            <h1 class="fe-hero-title">
                Book a veterinary<br>
                <em>consultation.</em>
            </h1>
            <p class="fe-hero-desc">
                Select your preferred veterinary clinician, date and time for a structured clinical checkup or preventive consultation.
            </p>

            <!-- Working Search Form -->
            <form action="{{ route('appointments.index') }}" method="GET" style="display: flex; gap: 8px; max-width: 480px; margin-top: 8px;">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Search vets by name, clinic, or location..." 
                       class="form-control" style="border-radius: var(--radius-pill); padding-left: 20px;" aria-label="Search veterinarians">
                <button type="submit" class="btn btn-primary btn-sm">
                    Search
                </button>
            </form>

            <!-- Auto-Suggest Vets by Condition & Specialty (SRS Page 8) -->
            <div style="margin-top: 14px; display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                <span style="font-size: 11px; font-weight: 700; color: rgba(255,255,255,0.6); text-transform: uppercase; letter-spacing: 0.05em; font-family: var(--font-mono);">Condition Suggest:</span>
                <a href="{{ route('appointments.index', ['condition' => 'General']) }}" style="font-size: 11.5px; padding: 4px 10px; border-radius: 9999px; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.18); color: #ffffff; text-decoration: none;">General Practice</a>
                <a href="{{ route('appointments.index', ['condition' => 'Feline']) }}" style="font-size: 11.5px; padding: 4px 10px; border-radius: 9999px; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.18); color: #ffffff; text-decoration: none;">Feline Medicine</a>
                <a href="{{ route('appointments.index', ['condition' => 'Diagnostics']) }}" style="font-size: 11.5px; padding: 4px 10px; border-radius: 9999px; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.18); color: #ffffff; text-decoration: none;">Internal Diagnostics</a>
                <a href="{{ route('appointments.index', ['condition' => 'Canine']) }}" style="font-size: 11.5px; padding: 4px 10px; border-radius: 9999px; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.18); color: #ffffff; text-decoration: none;">Canine Wellness</a>
                @if(request('search') || request('condition') || request('location'))
                    <a href="{{ route('appointments.index') }}" style="font-size: 11.5px; padding: 4px 10px; border-radius: 9999px; background: rgba(239,68,68,0.2); border: 1px solid rgba(239,68,68,0.4); color: #fca5a5; text-decoration: none;">✕ Clear</a>
                @endif
            </div>
        </div>

        <!-- 3D Swap Stacked Cards Deck (White, Black, Green Theme) -->
        <div class="appointments-stack-wrap">
            <div class="stack">
                <div class="card">
                    <img src="/images/vet-hero.jpg" alt="Clinical Consultations" />
                    <div class="stack-card-caption">
                        <span class="stack-caption-tag">Veterinary Network</span>
                        <h4>Clinical Consultations</h4>
                    </div>
                </div>
                <div class="card">
                    <img src="/images/vet-sarah.jpg" alt="Surgery & Diagnostics" />
                    <div class="stack-card-caption">
                        <span class="stack-caption-tag">Dr. Sarah Johnson</span>
                        <h4>Surgery & Diagnostics</h4>
                    </div>
                </div>
                <div class="card">
                    <img src="/images/vet-michael.jpg" alt="Dental & Oncology" />
                    <div class="stack-card-caption">
                        <span class="stack-caption-tag">Dr. Michael Chang</span>
                        <h4>Dental & Oncology</h4>
                    </div>
                </div>
                <div class="card">
                    <img src="/images/vet-emily.jpg" alt="Preventive Wellness" />
                    <div class="stack-card-caption">
                        <span class="stack-caption-tag">Dr. Emily Rodriguez</span>
                        <h4>Preventive Wellness</h4>
                    </div>
                </div>
                <div class="card">
                    <img src="/images/hero-companion.jpg" alt="Routine Vaccinations" />
                    <div class="stack-card-caption">
                        <span class="stack-caption-tag">Lifelong Care</span>
                        <h4>Routine Vaccinations</h4>
                    </div>
                </div>
                <div class="card">
                    <img src="/images/care-tips.jpg" alt="Post-Op & Nutrition" />
                    <div class="stack-card-caption">
                        <span class="stack-caption-tag">Clinical Stewardship</span>
                        <h4>Post-Op & Nutrition</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Featured Doctors Grid -->
    <div class="reveal delay-1">
        <div class="section-head-split">
            <div>
                <div class="section-label">01 — Available Practitioners</div>
                <h2>Featured Veterinary Clinicians</h2>
                <p>Consult certified practitioners for medical examinations, surgeries and health checks.</p>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 28px;">
            @php
                $defaultDoctors = [
                    [
                        'name' => 'Dr. Sarah Johnson',
                        'spec' => 'General Veterinarian',
                        'desc' => 'Certified veterinary surgeon specializing in clinical diagnostics, soft-tissue procedures and proactive wellness screenings.',
                        'rating' => '4.9',
                        'rev' => 124,
                        'img' => '/images/vet-sarah.jpg',
                        'fee' => 45,
                        'status' => 'Available Today',
                        'consults' => '3.1 K',
                    ],
                    [
                        'name' => 'Dr. Michael Carter',
                        'spec' => 'Pet Specialist',
                        'desc' => 'Feline and canine internal medicine consultant with an emphasis on nutritional guidance & geriatric care protocols.',
                        'rating' => '4.8',
                        'rev' => 98,
                        'img' => '/images/vet-michael.jpg',
                        'fee' => 60,
                        'status' => 'Available Today',
                        'consults' => '2.4 K',
                    ],
                    [
                        'name' => 'Dr. Emily Wilson',
                        'spec' => 'Surgery Specialist',
                        'desc' => 'Board-certified surgical clinician delivering advanced orthopedic solutions & continuous post-op recovery care.',
                        'rating' => '5.0',
                        'rev' => 115,
                        'img' => '/images/vet-emily.jpg',
                        'fee' => 55,
                        'status' => 'On Duty',
                        'consults' => '1.9 K',
                    ],
                ];
            @endphp

            @foreach($defaultDoctors as $idx => $doc)
                @php
                    $vetRecord = $vets[$idx] ?? $vets->first();
                    $vetId = $vetRecord ? $vetRecord->id : ($idx + 1);
                @endphp
                <div class="turbo-card-wrap">
                    <div class="turbo-card">
                        <div class="turbo-card-filter"></div>
                        <img src="{{ $doc['img'] }}" alt="{{ $doc['name'] }}" class="turbo-card-bg">

                        <!-- Status Pill -->
                        <div class="turbo-card-status">
                            <div class="turbo-card-status-dot online"></div>
                            <div class="turbo-card-status-text">{{ $doc['status'] }}</div>
                        </div>

                        <!-- Fee Badge -->
                        <div class="turbo-card-handle" title="Consultation Fee">
                            <span class="turbo-handle-fee">${{ $doc['fee'] }}/visit</span>
                        </div>

                        <!-- Content Deck -->
                        <div class="turbo-card-content">
                            <!-- Name + Verified -->
                            <div class="turbo-card-name-wrap">
                                <div class="turbo-card-name">{{ $doc['name'] }}</div>
                                <div class="turbo-card-verified" title="Certified Practitioner">
                                    <i class="fas fa-circle-check"></i>
                                </div>
                            </div>

                            <!-- Tags + Stats -->
                            <div class="turbo-card-tags">
                                <div class="turbo-card-tag">
                                    <div class="turbo-card-rating-text">{{ $doc['rating'] }}</div>
                                    <div class="turbo-card-rating-stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-stroke"></i>
                                    </div>
                                </div>
                                <div class="turbo-card-tag">
                                    <i class="fas fa-user-doctor"></i>
                                    <div class="turbo-card-rating-text">{{ $doc['consults'] }}</div>
                                </div>
                                <div class="turbo-card-tag">
                                    <span>{{ $doc['spec'] }}</span>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="turbo-card-description">
                                {{ $doc['desc'] }}
                            </div>

                            <!-- Contact / Booking Button -->
                            <div class="turbo-card-button" 
                                 role="button"
                                 tabindex="0"
                                 onclick="openBookModal({{ $vetId }}, '{{ addslashes($doc['name']) }}', '{{ addslashes($doc['spec']) }}', {{ $doc['fee'] }})">
                                <div class="turbo-card-button-text">Book Clinical Consult</div>
                                <div class="turbo-card-button-call">
                                    <i class="fas fa-calendar-check turbo-card-button-call-icon"></i>
                                </div>
                            </div>
                        </div>

                        <div class="turbo-card-fade"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>

<!-- Booking Modal (Preserved Functionality) -->
<div id="bookingModal" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(13, 15, 17, 0.65); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 20px;">
    <div class="card" style="max-width: 520px; width: 100%; max-height: 90vh; overflow-y: auto; box-shadow: var(--shadow-lg); background: var(--white); border-radius: var(--radius-lg);">
        <div style="padding: 24px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; background: var(--paper);">
            <div>
                <h3 style="font-size: 1.25rem; margin-bottom: 4px;">Book Appointment</h3>
                <p id="modalDocName" class="meta-label" style="color: var(--emerald); margin: 0;"></p>
            </div>
            <button type="button" onclick="closeBookModal()" style="background: none; border: none; font-size: 1.5rem; color: var(--muted); cursor: pointer;" aria-label="Close modal">&times;</button>
        </div>

        <form action="{{ route('appointments.book') }}" method="POST" style="padding: 24px;">
            @csrf
            <input type="hidden" name="vet_id" id="modalVetId">

            <div class="form-group">
                <label class="form-label">Select Your Pet *</label>
                @if($pets->count() > 0)
                    <select name="pet_id" required class="form-control">
                        @foreach($pets as $pet)
                            <option value="{{ $pet->id }}">{{ $pet->name }} ({{ ucfirst($pet->species) }})</option>
                        @endforeach
                    </select>
                @else
                    <div style="background: var(--warning-soft); padding: 12px; border-radius: var(--radius-sm); font-size: 0.88rem; color: #92400e; border: 1px solid #fde68a;">
                        No registered pets found. <a href="{{ route('pets.index') }}" style="color: var(--emerald); font-weight: 700; text-decoration: underline;">Add your pet profile first.</a>
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label class="form-label">Preferred Date & Time *</label>
                <input type="datetime-local" name="starts_at" required 
                       value="{{ date('Y-m-d\TH:i', strtotime('+1 day 10:00')) }}" 
                       class="form-control">
            </div>

            <div class="form-group">
                <label class="form-label">Reason for Consultation *</label>
                <textarea name="reason" rows="3" required class="form-control" placeholder="e.g. Routine vaccination, seasonal checkup, dietary advice..."></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px;">
                <button type="button" onclick="closeBookModal()" class="btn btn-secondary btn-sm">Cancel</button>
                <button type="submit" class="btn btn-primary btn-sm" {{ $pets->count() == 0 ? 'disabled' : '' }}>
                    Confirm Booking
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openBookModal(vetId, vetName, vetSpec, fee) {
    document.getElementById('modalVetId').value = vetId;
    document.getElementById('modalDocName').textContent = vetName + ' • ' + vetSpec;
    document.getElementById('bookingModal').style.display = 'flex';
}
function closeBookModal() {
    document.getElementById('bookingModal').style.display = 'none';
}
</script>
@endsection
