@extends('frontend.layouts.app')

@section('title', $pet->name . ' — Pet Clinical Profile')

@section('content')
<div class="container section">

    <!-- 1. Header Card with Pet Summary -->
    <div class="card card-padded reveal" style="margin-bottom: 36px; display: flex; align-items: center; justify-content: space-between; gap: 24px; flex-wrap: wrap;">
        <div style="display: flex; align-items: center; gap: 24px;">
            <div style="width: 100px; height: 100px; border-radius: var(--radius-md); overflow: hidden; background: var(--paper-subtle); border: 1px solid var(--border); flex-shrink: 0;">
                @php
                    $img = '/images/buddy.jpg';
                    if (strtolower($pet->species) === 'cat') $img = '/images/luna.jpg';
                    if ($pet->photo_url) $img = $pet->photo_url;
                @endphp
                <img src="{{ $img }}" alt="{{ $pet->name }}" style="width: 100%; height: 100%; object-fit: cover;">
            </div>

            <div>
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 4px;">
                    <h1 style="font-size: 2rem; margin: 0;">{{ $pet->name }}</h1>
                    <span class="pet-card-badge" style="position: static; padding: 2px 10px;">Verified Healthy</span>
                </div>
                <div style="color: var(--muted); font-size: 0.95rem; margin-bottom: 4px;">
                    {{ $pet->breed ?? ucfirst($pet->species) }} • {{ ucfirst($pet->sex) }}
                </div>
                <div class="meta-label">
                    RECORD ID: FUR-{{ 10000 + $pet->id }}
                </div>
            </div>
        </div>

        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="{{ route('appointments.index') }}" class="btn btn-primary btn-sm">
                <span>Book Clinical Visit</span>
                <span class="btn-arrow">↗</span>
            </a>
            <a href="{{ route('pets.index') }}" class="btn btn-secondary btn-sm">
                <span>All Pets</span>
            </a>
        </div>
    </div>

    <!-- 2. Two-Column Layout (Details & Health History vs Quick Actions) -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 320px), 1fr)); gap: 24px; align-items: start;" class="reveal delay-1">
        
        <!-- Left: Details & History -->
        <div style="display: flex; flex-direction: column; gap: 28px;">
            <!-- Profile Details -->
            <div class="card card-padded">
                <div class="meta-label" style="margin-bottom: 12px;">Profile Information</div>
                <p style="margin-bottom: 24px; font-size: 0.98rem; line-height: 1.65;">
                    {{ $pet->notes ?? 'Documented companion profile with verified vaccination status and recorded veterinary visits.' }}
                </p>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 180px), 1fr)); gap: 14px;">
                    <div style="background: var(--paper); padding: 14px 18px; border-radius: var(--radius-sm); border: 1px solid var(--border);">
                        <span class="meta-label" style="font-size: 10px; display: block; margin-bottom: 2px;">Species / Breed</span>
                        <strong style="color: var(--ink); font-size: 0.95rem;">{{ $pet->breed ?? ucfirst($pet->species) }}</strong>
                    </div>

                    <div style="background: var(--paper); padding: 14px 18px; border-radius: var(--radius-sm); border: 1px solid var(--border);">
                        <span class="meta-label" style="font-size: 10px; display: block; margin-bottom: 2px;">Recorded Weight</span>
                        <strong style="color: var(--ink); font-size: 0.95rem;">{{ $pet->weight_kg ?? '32' }} kg</strong>
                    </div>

                    <div style="background: var(--paper); padding: 14px 18px; border-radius: var(--radius-sm); border: 1px solid var(--border);">
                        <span class="meta-label" style="font-size: 10px; display: block; margin-bottom: 2px;">Microchip Number</span>
                        <strong style="color: var(--ink); font-size: 0.95rem; font-family: var(--font-mono);">{{ $pet->microchip_number ?? '985141002384910' }}</strong>
                    </div>

                    <div style="background: var(--paper); padding: 14px 18px; border-radius: var(--radius-sm); border: 1px solid var(--border);">
                        <span class="meta-label" style="font-size: 10px; display: block; margin-bottom: 2px;">Care Plan</span>
                        <strong style="color: var(--emerald-dark); font-size: 0.95rem;">FurShield Standard</strong>
                    </div>
                </div>
            </div>

            <!-- Health History List -->
            <div class="card card-padded">
                <div class="meta-label" style="margin-bottom: 16px;">Medical Chronology</div>
                <h3 style="font-size: 1.25rem; margin-bottom: 16px;">Recorded Health Events</h3>

                <div style="display: flex; flex-direction: column; gap: 12px;">
                    @forelse($records as $rec)
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 14px 18px; background: var(--paper); border-radius: var(--radius-sm); border: 1px solid var(--border);">
                            <div>
                                <strong style="color: var(--ink); font-size: 0.95rem; display: block;">{{ $rec->title }}</strong>
                                <span class="meta-label" style="font-size: 11px;">{{ $rec->provider_name ?? 'Clinical Practitioner' }}</span>
                            </div>
                            <span class="pet-card-badge" style="position: static;">Documented</span>
                        </div>
                    @empty
                        <div style="padding: 16px; background: var(--paper); border-radius: var(--radius-sm); color: var(--muted); font-size: 0.9rem;">
                            No recent clinical interventions recorded on file.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right: Actions -->
        <div class="card card-padded" style="position: sticky; top: 100px;">
            <div class="meta-label" style="margin-bottom: 16px;">Actions</div>

            <div style="display: flex; flex-direction: column; gap: 10px;">
                <a href="{{ route('appointments.index') }}" class="btn btn-secondary btn-block" style="justify-content: flex-start;">
                    <span>📅 Schedule Examination</span>
                </a>
                <a href="{{ route('appointments.index') }}" class="btn btn-secondary btn-block" style="justify-content: flex-start;">
                    <span>🩺 Record Health Event</span>
                </a>
                <a href="{{ route('pets.index') }}" class="btn btn-secondary btn-block" style="justify-content: flex-start;">
                    <span>🔔 Manage Reminders</span>
                </a>
            </div>
        </div>

    </div>

</div>
@endsection
