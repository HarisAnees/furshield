@extends('admin.layouts.app')

@section('title', 'Analytics & Reports')
@section('page_title', 'Business Intelligence & Data Export')
@section('page_subtitle', 'System-wide analytics, key performance indicators, and one-click CSV report exports.')

@section('content')
<!-- KPI Summary Cards -->
<section class="kpi-grid">
    <div class="kpi-card">
        <div class="kpi-icon-wrap teal"><i class="fa-solid fa-users"></i></div>
        <div class="kpi-details">
            <span class="kpi-label">Total Users</span>
            <span class="kpi-value">{{ number_format($metrics['total_users']) }}</span>
        </div>
        <div class="kpi-trend up">↑ 12%</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon-wrap blue"><i class="fa-solid fa-paw"></i></div>
        <div class="kpi-details">
            <span class="kpi-label">Registered Pets</span>
            <span class="kpi-value">{{ number_format($metrics['total_pets']) }}</span>
        </div>
        <div class="kpi-trend up">↑ 8%</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon-wrap green"><i class="fa-solid fa-stethoscope"></i></div>
        <div class="kpi-details">
            <span class="kpi-label">Appointments</span>
            <span class="kpi-value">{{ number_format($metrics['total_appointments']) }}</span>
        </div>
        <div class="kpi-trend up">↑ 5%</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon-wrap orange"><i class="fa-solid fa-credit-card"></i></div>
        <div class="kpi-details">
            <span class="kpi-label">Marketplace Revenue</span>
            <span class="kpi-value">${{ number_format($metrics['total_revenue'], 2) }}</span>
        </div>
        <div class="kpi-trend up">↑ 15%</div>
    </div>
</section>

<!-- Export Reports Section -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px; margin-top: 20px;">
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">
                <i class="fa-solid fa-folder-open" style="color: #059669; margin-right: 6px;"></i> Users & Pet Owners Report
            </h3>
        </div>
        <div class="admin-card-body">
            <p style="font-size: 12.5px; color: #64748b; margin-bottom: 16px; line-height: 1.4;">
                Download complete directory of registered owners, vets, shelters, contact emails, and verification statuses.
            </p>
            <a href="{{ route('admin.reports.export', ['type' => 'users']) }}" class="btn btn-primary" style="width: 100%;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                Export Users CSV
            </a>
        </div>
    </div>

    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">
                <i class="fa-solid fa-calendar-days" style="color: #059669; margin-right: 6px;"></i> Appointments & Clinical Visits
            </h3>
        </div>
        <div class="admin-card-body">
            <p style="font-size: 12.5px; color: #64748b; margin-bottom: 16px; line-height: 1.4;">
                Full consultation logs including attending veterinarian names, appointment dates, medical reasons, and outcome states.
            </p>
            <a href="{{ route('admin.reports.export', ['type' => 'appointments']) }}" class="btn btn-secondary" style="width: 100%;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                Export Appointments CSV
            </a>
        </div>
    </div>

    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">
                <i class="fa-solid fa-bag-shopping" style="color: #059669; margin-right: 6px;"></i> Marketplace Orders & Sales
            </h3>
        </div>
        <div class="admin-card-body">
            <p style="font-size: 12.5px; color: #64748b; margin-bottom: 16px; line-height: 1.4;">
                Financial transaction ledger containing line item quantities, totals, buyer references, and fulfillment statuses.
            </p>
            <a href="{{ route('admin.reports.export', ['type' => 'orders']) }}" class="btn btn-secondary" style="width: 100%;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                Export Orders CSV
            </a>
        </div>
    </div>
</div>
@endsection
