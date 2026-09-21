@extends('frontend.layouts.app')

@section('title', 'About FurShield — A Better Way to Care for Pets')

@section('content')
<div class="container section">

    <!-- 1. Editorial Header / Hero -->
    <div class="fe-hero-shell reveal" style="margin-bottom: 72px;">
        <div class="fe-hero-content">
            <div class="kicker">About FurShield</div>
            <h1 class="fe-hero-title">
                A better way to<br>
                <em>care for pets.</em>
            </h1>
            <p class="fe-hero-desc">
                FurShield connects pet owners, veterinarians, and animal shelters in a single, coherent ecosystem. We believe that dependable veterinary records, ethical adoption, and high-standard pet nutrition should be accessible to all.
            </p>
            <div class="fe-hero-actions">
                <a href="#mission" class="btn btn-primary">
                    <span>Our Mission</span>
                    <span class="btn-arrow">↓</span>
                </a>
                <a href="{{ route('contact') }}" class="btn btn-secondary">
                    <span>Get in Touch</span>
                </a>
            </div>
        </div>

        <!-- Swiper Cards Effect Deck (White, Black, Green Theme) -->
        <div class="about-swiper-card-wrap">
            <div class="about-circles-bg" aria-hidden="true">
                <span></span><span></span><span></span><span></span><span></span>
                <span></span><span></span><span></span><span></span><span></span>
            </div>

            <div class="swiper about-hero-swiper">
                <div class="swiper-wrapper">
                    <!-- Slide 1 -->
                    <div class="swiper-slide">
                        <img src="/images/about-hero.jpg" alt="Compassionate Care" />
                        <div class="about-slide-overlay">
                            <span class="about-slide-score">9.9</span>
                            <h2>Compassionate Care</h2>
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="swiper-slide">
                        <img src="/images/story-cat.jpg" alt="Shelter Adoption" />
                        <div class="about-slide-overlay">
                            <span class="about-slide-score">9.8</span>
                            <h2>Shelter Rescue</h2>
                        </div>
                    </div>

                    <!-- Slide 3 -->
                    <div class="swiper-slide">
                        <img src="/images/vet-hero.jpg" alt="Clinical Precision" />
                        <div class="about-slide-overlay">
                            <span class="about-slide-score">9.9</span>
                            <h2>Clinical Precision</h2>
                        </div>
                    </div>

                    <!-- Slide 4 -->
                    <div class="swiper-slide">
                        <img src="/images/hero-companion.jpg" alt="Lifelong Companionship" />
                        <div class="about-slide-overlay">
                            <span class="about-slide-score">9.7</span>
                            <h2>Lifelong Bond</h2>
                        </div>
                    </div>

                    <!-- Slide 5 -->
                    <div class="swiper-slide">
                        <img src="/images/care-tips.jpg" alt="Proactive Wellness" />
                        <div class="about-slide-overlay">
                            <span class="about-slide-score">9.8</span>
                            <h2>Proactive Wellness</h2>
                        </div>
                    </div>

                    <!-- Slide 6 -->
                    <div class="swiper-slide">
                        <img src="/images/bella.jpg" alt="Ethical Adoption" />
                        <div class="about-slide-overlay">
                            <span class="about-slide-score">9.9</span>
                            <h2>Forever Homes</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Core Pillars / Values -->
    <div style="margin-bottom: 80px;" class="reveal delay-1">
        <div class="section-head">
            <div class="section-label">01 — Foundational Pillars</div>
            <h2>Built on responsibility, trust, and prevention.</h2>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px;">
            <!-- Pillar 1 -->
            <div class="card card-padded">
                <div class="meta-label" style="color: var(--emerald); margin-bottom: 12px;">01 / CLINICAL QUALITY</div>
                <h3 style="font-size: 1.25rem; margin-bottom: 8px;">Better Care</h3>
                <p style="font-size: 0.92rem; line-height: 1.6;">Preventive wellness protocols, timely vaccination schedules, and structured health tracking.</p>
            </div>

            <!-- Pillar 2 -->
            <div class="card card-padded">
                <div class="meta-label" style="color: var(--emerald); margin-bottom: 12px;">02 / PROFESSIONAL NETWORK</div>
                <h3 style="font-size: 1.25rem; margin-bottom: 8px;">Trusted Vets</h3>
                <p style="font-size: 0.92rem; line-height: 1.6;">Direct consultation and appointment booking with experienced veterinary clinicians.</p>
            </div>

            <!-- Pillar 3 -->
            <div class="card card-padded">
                <div class="meta-label" style="color: var(--emerald); margin-bottom: 12px;">03 / ETHICAL ADOPTION</div>
                <h3 style="font-size: 1.25rem; margin-bottom: 8px;">Shelter Support</h3>
                <p style="font-size: 0.92rem; line-height: 1.6;">Partnering directly with rescue organizations to give shelter animals loving, permanent homes.</p>
            </div>

            <!-- Pillar 4 -->
            <div class="card card-padded">
                <div class="meta-label" style="color: var(--emerald); margin-bottom: 12px;">04 / COMMUNITY</div>
                <h3 style="font-size: 1.25rem; margin-bottom: 8px;">Shared Stewardship</h3>
                <p style="font-size: 0.92rem; line-height: 1.6;">Empowering families with knowledge, reliable supplies, and clinical tools for healthier lives.</p>
            </div>
        </div>
    </div>

    <!-- 3. Our Story & Mission Section (Editorial Movie-Card Design) -->
    <div id="mission" class="about-movie-card reveal delay-2">
        <div class="movie-container">
            <a href="{{ route('adoption.index') }}">
                <img src="/images/story-cat.jpg" alt="FurShield Rescue Companion" class="movie-cover" />
            </a>

            <div class="movie-hero">
                <div class="movie-details">
                    <div class="section-label" style="color: #10b981; margin-bottom: 8px;">02 — Mission & Purpose</div>
                    <div class="movie-title1">
                        Every Paw Deserves <span class="movie-badge">Shield of Love</span>
                    </div>
                    <div class="movie-title2">Compassionate, verified lifelong animal care</div>
                    <div class="movie-rating-row">
                        <span class="movie-stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </span>
                        <span class="movie-likes">
                            <i class="fas fa-heart"></i> 100% Shelter Dedicated
                        </span>
                    </div>
                </div>
            </div>

            <div class="movie-description">
                <div class="movie-column1">
                    <span class="movie-tag">Prevention</span>
                    <span class="movie-tag">Clinical Care</span>
                    <span class="movie-tag">Adoption</span>
                    <span class="movie-tag">Nutrition</span>
                </div>

                <div class="movie-column2">
                    <p>
                        <strong>FurShield was established to eliminate fragmented care.</strong> By bridging owner pet profiles with clinical appointments, shelter listings, and dependable nutrition, we ensure every animal receives compassionate, documented attention throughout their life.
                    </p>
                    <p>
                        Whether you are registering your first puppy, scheduling senior cat diagnostics, or adopting a rescue companion, FurShield provides the quiet, dependable infrastructure you need.
                    </p>

                    <div class="movie-avatars-wrap">
                        <div class="movie-avatars">
                            <a href="{{ route('appointments.index') }}" data-tooltip="Dr. Sarah Jenkins (Senior Clinician)">
                                <img src="/images/vet-sarah.jpg" alt="Dr. Sarah Jenkins">
                            </a>
                            <a href="{{ route('appointments.index') }}" data-tooltip="Dr. Michael Chang (Surgery Specialist)">
                                <img src="/images/vet-michael.jpg" alt="Dr. Michael Chang">
                            </a>
                            <a href="{{ route('appointments.index') }}" data-tooltip="Dr. Emily Rodriguez (Behavioral Medicine)">
                                <img src="/images/vet-emily.jpg" alt="Dr. Emily Rodriguez">
                            </a>
                        </div>

                        <div class="movie-actions">
                            <a href="{{ route('appointments.index') }}" class="btn btn-primary btn-sm">
                                <span>Find a Veterinarian</span>
                                <span class="btn-arrow">↗</span>
                            </a>
                            <a href="{{ route('adoption.index') }}" class="btn btn-secondary btn-sm">
                                <span>Explore Adoption</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
