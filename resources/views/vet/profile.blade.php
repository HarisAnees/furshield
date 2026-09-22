@extends('vet.layouts.app')

@section('title', 'Clinic Profile & Practice Settings')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
    <div>
        <h1 style="font-size: 1.85rem; font-weight: 800; color: #091a13; margin: 0 0 6px; letter-spacing: -0.02em;">
            Veterinary Practice & Availability
        </h1>
        <p style="color: #64748b; font-size: 0.95rem; margin: 0;">
            Update your clinic credentials, clinical specialization, experience, and consultation availability.
        </p>
    </div>
    <a href="{{ route('vet.dashboard') }}" class="btn-sm btn-outline">← Back to Overview</a>
</div>

<div class="card-surface" style="max-width: 720px;">
    <form method="POST" action="{{ route('vet.profile.update') }}">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
            <div>
                <label style="display: block; font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Clinician Full Name <span style="color: #ef4444;">*</span></label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="owner-form-input" style="width: 100%;">
            </div>
            <div>
                <label style="display: block; font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Phone Contact</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="owner-form-input" style="width: 100%;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 16px; margin-bottom: 16px;">
            <div>
                <label style="display: block; font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Clinic / Practice Name <span style="color: #ef4444;">*</span></label>
                <input type="text" name="clinic_name" value="{{ old('clinic_name', $vet->clinic_name) }}" required class="owner-form-input" style="width: 100%;">
            </div>
            <div>
                <label style="display: block; font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Experience (Years) <span style="color: #ef4444;">*</span></label>
                <input type="number" name="experience_years" value="{{ old('experience_years', $vet->experience_years) }}" min="0" max="60" required class="owner-form-input" style="width: 100%;">
            </div>
        </div>

        <div style="margin-bottom: 16px;">
            <label style="display: block; font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Clinical Specialization <span style="color: #ef4444;">*</span></label>
            <input type="text" name="specialization" value="{{ old('specialization', $vet->specialization) }}" placeholder="e.g. Feline Medicine, Canine Orthopedics, General Practice" required class="owner-form-input" style="width: 100%;">
        </div>

        <div style="margin-bottom: 16px;">
            <label style="display: block; font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Practice Clinic Address</label>
            <input type="text" name="address" value="{{ old('address', $vet->address) }}" placeholder="e.g. 100 Medical Center Way, Suite 400" class="owner-form-input" style="width: 100%;">
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-size: 12.5px; font-weight: 700; color: #334155; margin-bottom: 6px;">Doctor Biography & Clinical Focus</label>
            <textarea name="bio" rows="3" class="owner-form-input" placeholder="Brief statement about your clinical background and veterinary care philosophy..." style="width: 100%;">{{ old('bio', $vet->bio) }}</textarea>
        </div>

        <!-- Live Consultation Availability Toggle -->
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between;">
            <div>
                <strong style="display: block; font-size: 13.5px; color: #091a13;">Live Booking Availability</strong>
                <span style="font-size: 12px; color: #64748b;">Allow registered pet owners to book appointment consultations with your clinic.</span>
            </div>
            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                <input type="checkbox" name="is_available" value="1" {{ $vet->is_available ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: #10b981;">
                <span style="font-size: 13px; font-weight: 700; color: #059669;">Accepting Bookings</span>
            </label>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 10px;">
            <button type="submit" class="btn-sm btn-emerald" style="padding: 10px 20px;">
                <i class="fa-solid fa-check" style="margin-right: 6px;"></i> Save Profile Changes
            </button>
        </div>
    </form>
</div>
@endsection
