@extends('frontend.layouts.app')

@section('title', 'Pet Care & Clinical Advice — FurShield')

@section('content')
<div class="container section">

    <!-- 1. Editorial Header -->
    <div class="section-head reveal" style="text-align: center; max-width: 640px; margin: 0 auto 48px;">
        <div class="section-label" style="justify-content: center;">Clinical Guides & Wellness</div>
        <h1>Pet Care & <em>Guidance</em></h1>
        <p>Proactive health advice, nutritional fundamentals and everyday routines verified by practitioners.</p>
    </div>

    <!-- 2. Category Filter Tabs -->
    <div class="reveal delay-1" style="display: flex; justify-content: center; gap: 8px; margin-bottom: 48px; flex-wrap: wrap;">
        @php
            $cats = ['All', 'Health', 'Nutrition', 'Training', 'Grooming'];
            $cur = request('category', 'all');
        @endphp
        @foreach($cats as $cat)
            @php
                $isActive = (strtolower($cur) === strtolower($cat));
                $url = (strtolower($cat) === 'all') ? route('care-tips.index') : route('care-tips.index', ['category' => strtolower($cat)]);
            @endphp
            <a href="{{ $url }}" 
               class="btn btn-sm {{ $isActive ? 'btn-primary' : 'btn-secondary' }}">
                {{ $cat }}
            </a>
        @endforeach
    </div>

    <!-- 3. GSAP ScrollTrigger Movie Stacking Cards -->
    <div class="care-poster-stack reveal delay-2">
        @php
            $panelArticles = [
                ['title' => '10 Essential Tips for a Healthy Dog', 'time' => '5 min read', 'img' => '/images/buddy.jpg', 'cat' => 'Health', 'genres' => ['Preventive', 'Canine', 'Wellness']],
                ['title' => 'Cat Nutrition Guide for a Longer Life', 'time' => '4 min read', 'img' => '/images/luna.jpg', 'cat' => 'Nutrition', 'genres' => ['Diet', 'Feline', 'Longevity']],
                ['title' => 'Grooming Tips for Happy Pets', 'time' => '6 min read', 'img' => '/images/max.jpg', 'cat' => 'Grooming', 'genres' => ['Coat Care', 'Hygiene', 'Routine']],
                ['title' => 'Common Pet Health Issues to Watch For', 'time' => '5 min read', 'img' => '/images/charlie.jpg', 'cat' => 'Health', 'genres' => ['Clinical', 'Symptoms', 'Checks']],
                ['title' => 'Training Your Puppy Basics', 'time' => '5 min read', 'img' => '/images/rocky.jpg', 'cat' => 'Training', 'genres' => ['Behavior', 'Obedience', 'Social']],
                ['title' => 'Seasonal Care Tips for Pets', 'time' => '3 min read', 'img' => '/images/bella.jpg', 'cat' => 'General', 'genres' => ['Weather', 'Safety', 'Hydration']],
            ];
            $curCat = strtolower(request('category', 'all'));
            if ($curCat !== 'all') {
                $panelArticles = array_values(array_filter($panelArticles, function($a) use ($curCat) {
                    return strtolower($a['cat']) === $curCat;
                }));
            }
        @endphp

        @foreach($panelArticles as $art)
            <div class="care-poster-card-wrapper">
                <div class="care-poster-card-contents"
                     role="button"
                     tabindex="0"
                     onclick="openArticleModal('{{ addslashes($art['title']) }}', '{{ addslashes($art['cat']) }}', '{{ $art['time'] }}')">
                    
                    <div class="care-poster-top-bar">
                        <div class="care-poster-badge">
                            <span class="care-badge-dot"></span>
                            <span>{{ strtoupper($art['cat']) }}</span>
                        </div>
                        <div class="care-poster-index-badge">
                            <span>GUIDE {{ sprintf('%02d', $loop->iteration) }} / {{ sprintf('%02d', count($panelArticles)) }}</span>
                        </div>
                    </div>

                    <img src="{{ $art['img'] }}" alt="{{ $art['title'] }}" class="care-poster-img" loading="lazy">

                    <div class="care-poster-description">
                        <div class="care-poster-meta-pill">
                            <span class="care-poster-verified-icon"><i class="fa-solid fa-shield-cat"></i></span>
                            <span>Practitioner Verified</span>
                            <span class="care-poster-meta-sep">•</span>
                            <span class="care-description__year">{{ $art['time'] }}</span>
                        </div>

                        <h3 class="care-description__title">
                            {{ $art['title'] }}
                        </h3>

                        <div class="care-description__genres">
                            @foreach($art['genres'] as $genre)
                                <span class="care-description__genre">{{ $genre }}</span>
                            @endforeach
                        </div>

                        <div class="care-poster-read-bar">
                            <span>Read Clinical Guide</span>
                            <span class="care-read-arrow">→</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="care-poster-spacer"></div>
    </div>

</div>

<!-- Reading Modal (Preserved Functionality) -->
<div id="careModal" class="fe-modal-overlay" onclick="if(event.target===this) closeArticleModal()">
    <div class="fe-modal-card">
        <div class="fe-modal-header">
            <div>
                <span id="careModalCat" class="meta-label" style="color: var(--emerald); margin-bottom: 6px; display: inline-block;">HEALTH</span>
                <h3 id="careModalTitle" style="font-size: 1.25rem; line-height: 1.3; margin: 0;"></h3>
            </div>
            <button type="button" onclick="closeArticleModal()" class="fe-modal-close" aria-label="Close article">&times;</button>
        </div>

        <div class="fe-modal-body" style="color: var(--ink); line-height: 1.7; font-size: 0.96rem;">
            <p style="margin-bottom: 14px;">
                Providing proactive, evidence-based care is the cornerstone of keeping pets lively and disease-free. Regular veterinary examinations, seasonal vaccinations, balanced hydration, and early symptom intervention yield long-lasting wellness.
            </p>
            <p>
                Our veterinary team continuously verifies all clinical guidelines to deliver the safest and most practical instructions for pet parents worldwide.
            </p>
        </div>

        <div class="fe-modal-footer">
            <button type="button" onclick="closeArticleModal()" class="btn btn-secondary btn-sm">Close</button>
        </div>
    </div>
</div>

<script>
function openArticleModal(title, cat, time) {
    document.getElementById('careModalTitle').textContent = title;
    document.getElementById('careModalCat').textContent = cat.toUpperCase() + ' • ' + time;
    document.getElementById('careModal').style.display = 'flex';
}
function closeArticleModal() {
    document.getElementById('careModal').style.display = 'none';
}
</script>
@endsection
