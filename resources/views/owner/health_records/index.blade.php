@extends('owner.layouts.app')

@section('title', 'Health Records — FurShield')

@section('content')
<div style="padding: 1.5rem 0;">

    <!-- Panel 12 Header Row -->
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 class="owner-welcome-title">
                Health Records
            </h1>
            <p style="color: #64748b; font-size: 0.95rem; margin-top: 4px;">
                Track your pet's medical history and keep them healthy.
            </p>
        </div>

        <button type="button" onclick="alert('Record form dialog simulated.');" class="owner-btn owner-btn-primary">
            + Add Record
        </button>
    </div>

    <!-- Panel 12: List of Health Record Rows matching screenshot -->
    <div class="owner-subpage-card" style="padding: 0; overflow: hidden;">
        @php
            $panelRows = [
                ['type' => 'Vaccination', 'title' => 'Rabies Vaccine', 'date' => 'Apr 15, 2025', 'icon' => '🐾', 'color' => '#0284c7', 'bg' => '#e0f2fe'],
                ['type' => 'General Checkup', 'title' => 'Routine Health Check', 'date' => 'Mar 10, 2025', 'icon' => '🩺', 'color' => '#059669', 'bg' => '#ecfdf5'],
                ['type' => 'Treatment', 'title' => 'Ear Infection', 'date' => 'Feb 20, 2025', 'icon' => '💊', 'color' => '#2563eb', 'bg' => '#dbeafe'],
                ['type' => 'Vaccination', 'title' => 'DHPP Vaccine', 'date' => 'Jan 12, 2025', 'icon' => '🐾', 'color' => '#0284c7', 'bg' => '#e0f2fe'],
            ];
        @endphp

        @foreach($panelRows as $row)
            <div class="owner-activity-row">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <!-- Circular Icon -->
                    <div style="width: 44px; height: 44px; border-radius: 50%; background: {{ $row['bg'] }}; color: {{ $row['color'] }}; font-size: 1.25rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        {{ $row['icon'] }}
                    </div>

                    <div>
                        <strong style="display: block; font-size: 1rem; color: #0f172a; margin-bottom: 2px;">
                            {{ $row['type'] }}
                        </strong>
                        <span style="font-size: 0.84rem; color: #64748b;">
                            {{ $row['title'] }} • {{ $row['date'] }}
                        </span>
                    </div>
                </div>

                <div style="display: flex; align-items: center; gap: 1rem; flex-shrink: 0;">
                    <!-- Completed Badge -->
                    <span style="font-size: 0.78rem; font-weight: 700; padding: 4px 10px; border-radius: 9999px; background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0;">
                        Completed
                    </span>
                    <span style="color: #94a3b8; font-size: 1.1rem; cursor: pointer;">›</span>
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection
