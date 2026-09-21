@extends('admin.layouts.app')

@section('title', 'Platform Settings')
@section('page_title', 'System Settings & Preferences')
@section('page_subtitle', 'Configure clinical operations, automated reminder schedules, and platform contact info.')

@section('content')
<div style="max-width: 800px;">
    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf
        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title">
                    <span>🏢</span> Clinic & Platform Information
                </h3>
            </div>
            <div class="admin-card-body">
                <div class="form-group">
                    <label class="form-label">Platform Name</label>
                    <input type="text" name="platform_name" class="form-control" value="{{ $settings['platform_name'] }}" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Support Email Address</label>
                        <input type="email" name="support_email" class="form-control" value="{{ $settings['support_email'] }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Emergency / Contact Phone</label>
                        <input type="text" name="contact_phone" class="form-control" value="{{ $settings['contact_phone'] }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Clinic Operating Hours</label>
                    <input type="text" name="clinic_hours" class="form-control" value="{{ $settings['clinic_hours'] }}" required>
                </div>
            </div>
        </div>

        <div class="admin-card">
            <div class="admin-card-header">
                <h3 class="admin-card-title">
                    <span>⚙️</span> Operational Rules & Automated Triggers
                </h3>
            </div>
            <div class="admin-card-body">
                <div class="form-group">
                    <label class="form-label">Marketplace Low Stock Threshold (Units)</label>
                    <input type="number" name="low_stock_threshold" class="form-control" value="{{ $settings['low_stock_threshold'] }}" style="max-width: 200px;">
                    <small style="color: #64748b; font-size: 11px;">Triggers warnings in the Products tab when inventory falls below this amount.</small>
                </div>
                <div class="form-group" style="margin-top: 16px;">
                    <label class="form-checkbox-label">
                        <input type="checkbox" name="auto_confirm_appointments" value="1" {{ $settings['auto_confirm_appointments'] ? 'checked' : '' }}>
                        <span><strong>Auto-confirm New Appointments:</strong> Instantly confirm owner bookings without manual approval.</span>
                    </label>
                </div>
                <div class="form-group">
                    <label class="form-checkbox-label">
                        <input type="checkbox" name="email_reminders" value="1" {{ $settings['email_reminders'] ? 'checked' : '' }}>
                        <span><strong>Automated Vaccination Reminders:</strong> Send notification alerts 3 days prior to due dates.</span>
                    </label>
                </div>
            </div>
            <div style="padding: 16px 20px; background: #f8fafc; border-top: 1px solid var(--border); display: flex; justify-content: flex-end;">
                <button type="submit" class="btn btn-primary">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                    Save Platform Settings
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
