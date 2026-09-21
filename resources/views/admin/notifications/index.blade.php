@extends('admin.layouts.app')

@section('title', 'Broadcast & Activity Notifications')
@section('page_title', 'System Notifications & Broadcasts')
@section('page_subtitle', 'Send platform-wide alerts to pet owners, track automated reminders, and review system audit events.')

@section('content')
<div class="admin-split-layout admin-notifications-layout">
    <!-- Send Broadcast Form -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">
                <span>📢</span> Send Broadcast Alert
            </h3>
        </div>
        <div class="admin-card-body">
            <form method="POST" action="{{ route('admin.notifications.store') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Alert Headline *</label>
                    <input type="text" name="title" class="form-control" required placeholder="e.g. Free Rabies Vaccination Camp This Saturday">
                </div>
                <div class="form-group">
                    <label class="form-label">Target Audience *</label>
                    <select name="target_audience" class="form-select" required>
                        <option value="all">All Platform Users ({{ $totalUsers }})</option>
                        <option value="owners">Pet Owners Only</option>
                        <option value="vets">Veterinarians Only</option>
                        <option value="shelters">Shelter Partners Only</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Notification Message *</label>
                    <textarea name="message" class="form-textarea" style="min-height: 110px;" required placeholder="Write clear message details for mobile push & web inboxes..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                    Dispatch Notification
                </button>
            </form>
        </div>
    </div>

    <!-- Notification Activity Log -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">
                <span>📜</span> Broadcast & System Activity Logs
            </h3>
            <span class="badge badge-teal">{{ $activities->total() }} Logged Events</span>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Activity / Event</th>
                        <th>Initiator</th>
                        <th>Audience / Context</th>
                        <th style="text-align: right;">Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activities as $act)
                        <tr>
                            <td>
                                <div style="font-weight: 600; color: #0f172a; font-size: 12.5px;">
                                    {{ $act->action }}
                                </div>
                                <small style="color: #64748b;">Subject: {{ $act->subject_type ?? 'System' }}</small>
                            </td>
                            <td>
                                <span style="font-size: 12px; color: #334155; font-weight: 500;">
                                    {{ $act->user->name ?? 'System Automated' }}
                                </span>
                            </td>
                            <td>
                                @if(is_array($act->metadata) && isset($act->metadata['target']))
                                    <span class="badge badge-info">Target: {{ ucfirst($act->metadata['target']) }}</span>
                                    <div style="font-size: 11px; color: #64748b; margin-top: 2px;">{{ \Illuminate\Support\Str::limit($act->metadata['message'] ?? '', 45) }}</div>
                                @else
                                    <span class="badge badge-gray">System Event</span>
                                @endif
                            </td>
                            <td style="text-align: right; color: #64748b; font-size: 11.5px; white-space: nowrap;">
                                {{ $act->created_at ? $act->created_at->diffForHumans() : 'Just now' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <div class="empty-state">
                                    <span class="empty-state-icon">🔔</span>
                                    <h4>No activity logs yet</h4>
                                    <p>Broadcasts and administrative events will be recorded here.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($activities->hasPages())
            <div style="padding: 16px 20px; border-top: 1px solid var(--border);">
                {{ $activities->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
