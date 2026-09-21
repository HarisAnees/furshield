@extends('owner.layouts.app')

@section('title', 'Health Records — FurShield')

@section('content')
<div style="padding: 1.5rem 0;">

    <!-- Panel 12 Header Row -->
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 style="font-size: 2.25rem; font-weight: 800; color: #0f172a; margin-bottom: 0.25rem; letter-spacing: -0.02em;">
                Health Records
            </h1>
            <p style="color: #64748b; font-size: 1rem;">
                Track your pet's medical history and keep them healthy.
            </p>
        </div>

        <button type="button" onclick="alert('Record form dialog simulated.');" class="fe-btn-pill" style="padding: 0.75rem 1.6rem; font-size: 0.95rem;">
            + Add Record
        </button>
    </div>

    <!-- Panel 12: List of Health Record Rows matching screenshot -->
    <div class="fe-card" style="padding: 0; overflow: hidden;">
        @php
            $panelRows = [
                ['type' => 'Vaccination', 'title' => 'Rabies Vaccine', 'date' => 'Apr 15, 2025', 'icon' => '🐾', 'color' => '#0284c7', 'bg' => '#e0f2fe'],
                ['type' => 'General Checkup', 'title' => 'Routine Health Check', 'date' => 'Mar 10, 2025', 'icon' => '🩺', 'color' => '#059669', 'bg' => '#ecfdf5'],
                ['type' => 'Treatment', 'title' => 'Ear Infection', 'date' => 'Feb 20, 2025', 'icon' => '💊', 'color' => '#2563eb', 'bg' => '#dbeafe'],
                ['type' => 'Vaccination', 'title' => 'DHPP Vaccine', 'date' => 'Jan 12, 2025', 'icon' => '🐾', 'color' => '#0284c7', 'bg' => '#e0f2fe'],
            ];
        @endphp

        @foreach($panelRows as $row)
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 1.5rem 2rem; border-bottom: 1px solid #f1f5f9; gap: 1rem;">
                <div style="display: flex; align-items: center; gap: 1.25rem;">
                    <!-- Circular Icon -->
                    <div style="width: 48px; height: 48px; border-radius: 50%; background: {{ $row['bg'] }}; color: {{ $row['color'] }}; font-size: 1.35rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        {{ $row['icon'] }}
                    </div>

                    <div>
                        <strong style="display: block; font-size: 1.05rem; color: #0f172a; margin-bottom: 0.2rem;">
                            {{ $row['type'] }}
                        </strong>
                        <span style="font-size: 0.88rem; color: #64748b;">
                            {{ $row['title'] }} • {{ $row['date'] }}
                        </span>
                    </div>
                </div>

                <div style="display: flex; align-items: center; gap: 1.5rem;">
                    <!-- Completed Badge -->
                    <span class="fe-badge fe-badge-green" style="font-size: 0.82rem; padding: 0.35rem 0.85rem;">
                        Completed
                    </span>
                    <span style="color: #94a3b8; font-size: 1.1rem; cursor: pointer;">›</span>
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection
