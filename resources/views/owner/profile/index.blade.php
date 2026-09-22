@extends('owner.layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="owner-subpage-card" style="max-width: 680px;">
    <div class="owner-subpage-header">
        <div class="owner-subpage-title">
            <i class="fa-solid fa-user-shield" style="color: #10b981;"></i> Account & Profile Settings
        </div>
    </div>
    <div class="owner-subpage-body">
        <form method="POST" action="{{ route('owner.profile.update') }}">
            @csrf
            <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px; padding-bottom: 20px; border-bottom: 1px solid #f1f5f9;">
                <img src="/images/sarah-avatar.jpg" alt="Profile" style="width: 64px; height: 64px; border-radius: 50%; object-fit: cover; border: 2px solid #10b981;">
                <div>
                    <strong style="font-size: 16px; color: #0f172a; display: block;">{{ $owner->name }}</strong>
                    <span style="font-size: 12px; color: #64748b;">Member since {{ $owner->created_at ? $owner->created_at->format('F Y') : '2026' }}</span>
                </div>
            </div>

            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Full Name *</label>
                <input type="text" name="name" value="{{ $owner->name }}" required style="width: 100%; padding: 9px 12px; border: 1px solid var(--border); border-radius: 8px;">
            </div>

            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Email Address *</label>
                <input type="email" name="email" value="{{ $owner->email }}" required style="width: 100%; padding: 9px 12px; border: 1px solid var(--border); border-radius: 8px;">
            </div>

            <div style="margin-bottom: 14px;">
                <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Phone Number</label>
                <input type="text" name="phone" value="{{ $owner->phone }}" placeholder="+1 (555) 000-0000" style="width: 100%; padding: 9px 12px; border: 1px solid var(--border); border-radius: 8px;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 5px;">Home Address</label>
                <input type="text" name="address" value="{{ $owner->address }}" placeholder="742 Evergreen Terrace, Springfield" style="width: 100%; padding: 9px 12px; border: 1px solid var(--border); border-radius: 8px;">
            </div>

            <div style="display: flex; justify-content: flex-end;">
                <button type="submit" class="owner-btn owner-btn-primary">
                    Update Profile
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
