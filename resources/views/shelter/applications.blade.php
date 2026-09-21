@extends('shelter.layouts.app')

@section('title', 'Adopter Applications & Coordination')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
    <div>
        <h1 style="font-size: 1.85rem; font-weight: 800; color: #091a13; margin: 0 0 6px; letter-spacing: -0.02em;">
            Adopter Coordination & Interest Applications
        </h1>
        <p style="color: #64748b; font-size: 0.95rem; margin: 0;">
            Review incoming adoption inquiries submitted by prospective pet owners and finalize adoption status.
        </p>
    </div>
    <a href="{{ route('shelter.dashboard') }}" class="btn-sm btn-outline">← Back to Overview</a>
</div>

<div class="card-surface">
    @if($applications->isEmpty())
        <div style="text-align: center; padding: 40px; color: #64748b;">
            <p>No adoption applications submitted yet.</p>
        </div>
    @else
        <div style="overflow-x: auto;">
            <table class="action-table">
                <thead>
                    <tr>
                        <th>Date Submitted</th>
                        <th>Applicant Details</th>
                        <th>Target Companion</th>
                        <th>Applicant Statement / Note</th>
                        <th>Status</th>
                        <th style="text-align: right;">Update Decision</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($applications as $app)
                        <tr>
                            <td style="font-family: var(--font-mono, monospace); font-size: 12px; color: #475569;">
                                {{ \Carbon\Carbon::parse($app->created_at)->format('M d, Y') }}
                            </td>
                            <td>
                                <strong style="color: #091a13;">{{ $app->user?->name ?? 'Prospective Adopter' }}</strong>
                                <div style="font-size: 11px; color: #64748b;">{{ $app->user?->email ?? 'adopter@example.com' }}</div>
                                <div style="font-size: 11px; color: #64748b;">{{ $app->user?->phone ?? 'Contact available' }}</div>
                            </td>
                            <td>
                                <strong style="color: #059669;">{{ $app->listing?->pet_name ?? 'Sanctuary Animal' }}</strong>
                                <div style="font-size: 11px; color: #64748b;">{{ $app->listing?->species }} • {{ $app->listing?->breed }}</div>
                            </td>
                            <td style="font-size: 12.5px; color: #334155; max-width: 280px;">
                                "{{ $app->message ?? 'I am very interested in providing a loving forever home.' }}"
                            </td>
                            <td>
                                <span class="status-pill status-{{ $app->status }}">
                                    {{ ucfirst($app->status) }}
                                </span>
                            </td>
                            <td style="text-align: right;">
                                <form method="POST" action="{{ route('shelter.applications.status', $app) }}" style="display: inline-flex; gap: 6px; align-items: center;">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="owner-form-input" style="font-size: 12px; padding: 4px 8px; width: auto;">
                                        <option value="pending" {{ $app->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ $app->status === 'approved' ? 'selected' : '' }}>Approve</option>
                                        <option value="adopted" {{ $app->status === 'adopted' ? 'selected' : '' }}>Finalize Adopted</option>
                                        <option value="rejected" {{ $app->status === 'rejected' ? 'selected' : '' }}>Decline</option>
                                    </select>
                                    <button type="submit" class="btn-sm btn-emerald">Save</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px;">
            {{ $applications->links() }}
        </div>
    @endif
</div>
@endsection
