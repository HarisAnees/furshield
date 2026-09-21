@extends('frontend.layouts.app')

@section('title', 'Healthy Pets, Happier Lives — FurShield')

@section('cinematic_loader')
<!-- 0. Cinematic Masked Video Hero Loader (8-10s Intro) -->
<div id="cinematicLoader" class="cinematic-loader-wrap flex__col" aria-label="FurShield Intro Animation">
    <nav class="cinematic-menu flex">
        <div class="cinematic-menu__left">
            <span class="brand-dot"></span>
            <span>FurShield · Intelligent Pet Care</span>
        </div>
        <div class="cinematic-menu__right">
            <div class="cinematic-timer-pill">
                <span>Auto-Enter:</span> <strong id="cinematicTimerCountdown">8s</strong>
            </div>
            <button id="cinematicSkipBtn" class="cinematic-skip-btn" type="button" aria-label="Skip Intro">
                <span>Enter Site</span>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
            </button>
        </div>
    </nav>

    <!-- Rapid typography intro wipe -->
    <section class="cinematic-intro flex">
        <span class="cinematic-intro-text" id="cinematicIntroText">Loading</span>
        <div class="cinematic-intro__emerald flex">
            <div>FURSHIELD · COMPANION CARE · VERIFIED VETS · HEALTH INTELLIGENCE</div>
        </div>
    </section>

    <!-- Center Masked Video & 3D Title -->
    <section class="cinematic-clip flex">
        <div class="cinematic-clip__inner flex__col">
            <h1 class="flex" id="cinematicMainTitle">Build their world</h1>
            <div class="cinematic-h1__stroke flex" id="cinematicStrokeTitle">Build their world</div>
            <p>FurShield Clinical Intelligence <span>·</span> Next-Gen Companion Care</p>
            <figure id="cinematicFigure">
                <video loop autoplay muted playsinline poster="https://images.unsplash.com/photo-1494253188410-ff0cdea5499e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1740&q=80">
                    <source src="https://www.paulrogerdev.fr/codepen/pexels-artem-podrez-4832087-1280x720-30fps.mp4" type="video/mp4">
                </video>
            </figure>
        </div>
        <div class="cinematic-clip__bg">
            <video loop autoplay muted playsinline poster="https://images.unsplash.com/photo-1494253188410-ff0cdea5499e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1740&q=80">
                <source src="https://www.paulrogerdev.fr/codepen/pexels-artem-podrez-4832087-1280x720-30fps.mp4" type="video/mp4">
            </video>
        </div>
    </section>

    <footer class="cinematic-credits flex">
        <div>Clinical Excellence & Compassion</div>
        <div>White · Black · Emerald Green</div>
    </footer>

    <div class="cinematic-cursor" id="cinematicCursor"></div>
    <div class="cinematic-noise"></div>
</div>

<!-- SVG Clip Path Definition for the Video Mask -->
<svg width="0" height="0" style="position: absolute; pointer-events: none;">
    <defs>
        <clipPath id="cinematicSvgClipPath" clipPathUnits="objectBoundingBox">
            <path d="M 0.22,0.02 C 0.52,0 0.72,0 0.82,0.02 C 0.96,0.05 1,0.22 1,0.40 C 1,0.65 0.96,0.92 0.82,0.98 C 0.72,1 0.32,1 0.18,0.98 C 0.04,0.92 0,0.65 0,0.40 C 0,0.22 0.04,0.05 0.22,0.02 Z" />
        </clipPath>
    </defs>
</svg>
@endsection

@section('content')

<!-- 1. Mugsy-Style Architectural Hero Section -->
<section class="fe-mugsy-hero-section reveal">
    <div class="fe-mugsy-hero-container">
        <header class="fe-mugsy-hero-header">
            <!-- Big Bold Editorial Wordmark -->
            <div class="fe-mugsy-wordmark font-anton">FURSHIELD</div>

            <!-- Elevated Inner Card with Nested Interlocking Curves -->
            <div class="fe-mugsy-inner-card">
                <!-- Upper Info Row -->
                <div class="fe-mugsy-card-row">
                    <div class="fe-mugsy-card-left">
                        <span class="fe-mugsy-kicker font-anton">PREMIER CARE</span>
                        <h1 class="fe-mugsy-headline">Healthy Pets, Happier Lives.</h1>
                        <p class="fe-mugsy-lead">
                            Engineered for companion wellness. Clinical precision, verified nutrition, lifetime adoption support, and certified veterinary specialists — built to move with you wherever the journey leads.
                        </p>
                    </div>

                    <div class="fe-mugsy-stat-card">
                        <div class="fe-mugsy-stat-flex">
                            <span class="fe-mugsy-stat-number font-anton">98%</span>
                            <div class="fe-mugsy-avatar-stack">
                                <img src="/images/sarah-avatar.jpg" alt="Pet Owner Sarah" />
                                <img src="/images/david-avatar.jpg" alt="Pet Owner David" />
                                <img src="/images/emily-avatar.jpg" alt="Dr. Emily" />
                            </div>
                        </div>
                        <p class="fe-mugsy-stat-text">Customer satisfaction rating across all orders & clinical visits</p>
                    </div>
                </div>

                <!-- Bottom Interlocking Notched Bar -->
                <div class="fe-mugsy-bottom-bar">
                    <!-- Left Tab: Expanding Pill CTA -->
                    <div class="fe-mugsy-tab-left">
                        <a href="{{ route('appointments.index') }}" class="fe-mugsy-btn">
                            <div class="fe-mugsy-btn-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                    <polyline points="12 5 19 12 12 19"></polyline>
                                </svg>
                            </div>
                            <span class="fe-mugsy-btn-text">Book Consultation</span>
                        </a>
                    </div>

                    <!-- Center Bridge Spacer -->
                    <div class="fe-mugsy-tab-center"></div>

                    <!-- Right Tab: Directional Buttons -->
                    <div class="fe-mugsy-tab-right">
                        <a href="{{ route('pets.index') }}" class="fe-mugsy-circle-btn" title="View Pet Profiles" aria-label="View Pet Profiles">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="19" y1="12" x2="5" y2="12"></line>
                                <polyline points="12 19 5 12 12 5"></polyline>
                            </svg>
                        </a>
                        <a href="{{ route('products.index') }}" class="fe-mugsy-circle-btn" title="Shop Pet Essentials" aria-label="Shop Pet Essentials">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Floating Companion Pet Visual Breaking Out of Container -->
            <img src="/images/hero-dog-2.png" alt="FurShield Verified Companion Dog" role="presentation" class="fe-mugsy-hero-pet" draggable="false" />
        </header>
    </div>
</section>

<!-- 2. Meaningful Continuous Ticker -->
<div class="fe-ticker" aria-hidden="true">
    <div class="fe-ticker-track">
        <span>Veterinary Care</span>
        <span>Pet Profiles</span>
        <span>Rescue Adoption</span>
        <span>Everyday Pet Essentials</span>
        <span>Nutrition & Wellness</span>
        <span>Health Records</span>
        <span>Veterinary Care</span>
        <span>Pet Profiles</span>
        <span>Rescue Adoption</span>
        <span>Everyday Pet Essentials</span>
        <span>Nutrition & Wellness</span>
        <span>Health Records</span>
    </div>
</div>

<!-- 3. Key Services (Structured Editorial Grid 01 - 04) -->
<section class="section">
    <div class="container">
        <div class="section-head reveal">
            <div class="section-label">01 — Services Overview</div>
            <h2>Structured care for every companion.</h2>
            <p>From scheduled health consultations to lifetime adoption, our workflows are designed around your pet's wellbeing.</p>
        </div>

        <div class="fe-services-grid reveal delay-1">
            <!-- 01: Veterinary Care -->
            <a href="{{ route('appointments.index') }}" class="fe-service-item">
                <div class="fe-service-num">01 / VET CARE</div>
                <div class="fe-service-info">
                    <h3 class="fe-service-title">Veterinary Care</h3>
                    <p class="fe-service-desc">Consultations, clinical treatments, preventive wellness and professional care scheduling.</p>
                </div>
                <div class="fe-service-arrow">
                    <span>Explore Care</span>
                    <span>→</span>
                </div>
            </a>

            <!-- 02: Pet Profiles -->
            <a href="{{ route('pets.index') }}" class="fe-service-item">
                <div class="fe-service-num">02 / PROFILES</div>
                <div class="fe-service-info">
                    <h3 class="fe-service-title">Pet Profiles</h3>
                    <p class="fe-service-desc">Complete medical history, dietary tracking, vaccination reminders and family sharing.</p>
                </div>
                <div class="fe-service-arrow">
                    <span>Manage Pets</span>
                    <span>→</span>
                </div>
            </a>

            <!-- 03: Adoption -->
            <a href="{{ route('adoption.index') }}" class="fe-service-item">
                <div class="fe-service-num">03 / ADOPTION</div>
                <div class="fe-service-info">
                    <h3 class="fe-service-title">Shelter Adoption</h3>
                    <p class="fe-service-desc">Direct partnership with verified shelters to connect loving owners with rescue animals.</p>
                </div>
                <div class="fe-service-arrow">
                    <span>View Adoptables</span>
                    <span>→</span>
                </div>
            </a>

            <!-- 04: Products -->
            <a href="{{ route('products.index') }}" class="fe-service-item">
                <div class="fe-service-num">04 / COMMERCE</div>
                <div class="fe-service-info">
                    <h3 class="fe-service-title">Pet Essentials</h3>
                    <p class="fe-service-desc">Nutritious formulas, safe grooming supplies, active play items and healthcare goods.</p>
                </div>
                <div class="fe-service-arrow">
                    <span>Browse Store</span>
                    <span>→</span>
                </div>
            </a>
        </div>
    </div>
</section>

<!-- 4. Featured Adoptable Pets -->
<section class="section" style="background: var(--white); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);">
    <div class="container">
        <div class="section-head-split reveal">
            <div>
                <div class="section-label">02 — Adoption Gallery</div>
                <h2>Featured Pets Seeking Homes</h2>
                <p>Rescued companions ready for adoption through verified shelters.</p>
            </div>
            <a href="{{ route('adoption.index') }}" class="btn btn-secondary btn-sm">
                <span>View All Adoptable Pets</span>
                <span class="btn-arrow">↗</span>
            </a>
        </div>

        <div class="fe-adopt-grid reveal delay-1">
            @forelse($adoptablePets as $index => $pet)
                @php
                    $petImgs = ['/images/charlie.jpg', '/images/bella.jpg', '/images/rocky.jpg'];
                    $img = $pet->image_path ?? $pet->photo_url ?? $petImgs[$index % count($petImgs)];
                @endphp
                <div class="card fe-notch-card">
                    <div class="card-inner" style="--clr: #ffffff;">
                        <div class="box">
                            <div class="imgBox">
                                <img src="{{ $img }}" alt="{{ $pet->pet_name }}">
                            </div>
                            <div class="icon">
                                <a href="{{ route('adoption.index') }}" class="iconBox" aria-label="Meet {{ $pet->pet_name }}" title="Meet {{ $pet->pet_name }}">
                                    <span class="material-symbols-outlined">arrow_outward</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="content">
                        <h3>{{ $pet->pet_name }}</h3>
                        <p>{{ $pet->health_summary ?? $pet->care_summary ?? 'Gentle companion ready for a loving home with complete clinical verification.' }}</p>
                        <ul>
                            <li style="--clr-tag: #ecfdf5;" class="tag-species">{{ ucfirst($pet->species ?? 'Companion') }}</li>
                            @if(!empty($pet->breed))
                                <li style="--clr-tag: #d1fae5;" class="tag-breed">{{ $pet->breed }}</li>
                            @endif
                            <li style="--clr-tag: #f4f4f5;" class="tag-age">{{ $pet->age_text ?? '2 Years' }}</li>
                            @if(!empty($pet->sex))
                                <li style="--clr-tag: #ecfdf5;" class="tag-sex">{{ ucfirst($pet->sex) }}</li>
                            @endif
                        </ul>
                    </div>
                </div>
            @empty
                <p style="color: var(--muted);">No adoptable pets currently listed.</p>
            @endforelse
        </div>
    </div>
</section>

<!-- 5. Popular Pet Essentials (Products with Magnetic Glow) -->
<section class="section">
    <div class="container magnetic-glow-demo magnetic-glow">
        <div class="section-head-split reveal">
            <div>
                <div class="section-label">03 — Store</div>
                <h2>Everyday Care Essentials</h2>
                <p>Formulated pet nutrition, grooming solutions and healthcare products.</p>
            </div>
            <div style="display: flex; align-items: center; gap: 16px; flex-wrap: wrap;">
                <!-- Effect Switcher Controls -->
                <div class="controls-container">
                    <div class="controls" role="tablist" aria-label="Glow effect controls">
                        <button type="button" class="control-btn active" data-effect="magnetic">Magnetic Glow</button>
                        <button type="button" class="control-btn" data-effect="outline">Outline Glow</button>
                        <button type="button" class="control-btn" data-effect="pulse">Pulse Glow</button>
                    </div>
                </div>
                <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">
                    <span>Explore Full Catalog</span>
                    <span class="btn-arrow">↗</span>
                </a>
            </div>
        </div>

        <div class="card-grid fe-store-glow-grid reveal delay-1">
            @foreach($products as $prod)
                @php
                    $name = strtolower($prod->name);
                    $img = '/images/dog-food.jpg';
                    $badge = 'Verified';
                    $rating = '4.9';
                    $reviews = '148';
                    if (str_contains($name, 'litter')) {
                        $img = '/images/cat-litter.jpg';
                        $badge = 'Eco Friendly';
                        $rating = '4.8';
                        $reviews = '96';
                    } elseif (str_contains($name, 'shampoo')) {
                        $img = '/images/pet-shampoo.jpg';
                        $badge = 'Hypoallergenic';
                        $rating = '4.9';
                        $reviews = '112';
                    } elseif (str_contains($name, 'toy') || str_contains($name, 'chew')) {
                        $img = '/images/dog-toys.jpg';
                        $badge = 'Durable';
                        $rating = '4.7';
                        $reviews = '84';
                    }
                    $originalPrice = $prod->price * 1.18;
                @endphp
                <div class="glow-card" data-glow-color="rgba(16, 185, 129, 0.45)">
                    <div class="glow-effect"></div>
                    <div class="card-content">
                        <div class="card-img">
                            <img src="{{ $img }}" alt="{{ $prod->name }}" loading="lazy">
                            <div class="card-badge">{{ $badge }}</div>
                        </div>
                        <div class="card-body">
                            <div class="card-tag">{{ ucfirst($prod->category ?? 'Care Essential') }}</div>
                            <h3 class="card-title">{{ $prod->name }}</h3>
                            <div class="card-rating">
                                <span class="stars">★★★★★</span>
                                <span class="rating-count">{{ $rating }} ({{ $reviews }})</span>
                            </div>
                            <p class="card-price">
                                <span class="price-original">${{ number_format($originalPrice, 2) }}</span>
                                ${{ number_format($prod->price, 2) }}
                            </p>
                            <form action="{{ route('cart.add', $prod) }}" method="POST" class="card-actions">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="card-btn primary">
                                    <span>Add to Cart</span>
                                    <span class="btn-arrow">↗</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- 6. Educational Guidance / Care Preview -->
<section class="section-sm" style="background: var(--white); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);">
    <div class="container">
        <div class="card card-padded" style="background: var(--paper); border: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; gap: 32px; flex-wrap: wrap;">
            <div>
                <div class="meta-label" style="color: var(--emerald);">Knowledge & Prevention</div>
                <h3 style="font-size: 1.6rem; margin-top: 6px; margin-bottom: 8px;">Explore expert tips on pet diet and clinical health.</h3>
                <p style="margin: 0; max-width: 580px;">Read certified guidance written to keep companions active, nourished, and happy at every age.</p>
            </div>
            <div>
                <a href="{{ route('care-tips.index') }}" class="btn btn-primary">
                    <span>Read Care Articles</span>
                    <span class="btn-arrow">↗</span>
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
