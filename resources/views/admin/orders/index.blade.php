@extends('admin.layouts.app')

@section('title', 'Marketplace Orders')
@section('page_title', 'Customer Orders & Fulfillments')
@section('page_subtitle', 'Process pet supply deliveries, verify item lists, and manage order statuses.')

@section('content')
<div class="crud-toolbar">
    <div class="filter-pills">
        <a href="{{ route('admin.orders.index') }}" class="filter-pill-link {{ !request('status') ? 'active' : '' }}">
            All ({{ $statusCounts['all'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'requested']) }}" class="filter-pill-link {{ request('status') === 'requested' ? 'active' : '' }}">
            Requested ({{ $statusCounts['requested'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}" class="filter-pill-link {{ request('status') === 'processing' ? 'active' : '' }}">
            Processing ({{ $statusCounts['processing'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'completed']) }}" class="filter-pill-link {{ request('status') === 'completed' ? 'active' : '' }}">
            Completed ({{ $statusCounts['completed'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}" class="filter-pill-link {{ request('status') === 'cancelled' ? 'active' : '' }}">
            Cancelled ({{ $statusCounts['cancelled'] }})
        </a>
    </div>

    <div class="toolbar-actions">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="toolbar-search">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <input type="text" name="search" class="form-control" placeholder="Search customer, order notes..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-secondary btn-sm">Search</button>
            @if(request('search'))
                <a href="{{ route('admin.orders.index', request()->only('status')) }}" class="btn btn-outline btn-sm">Clear</a>
            @endif
        </form>
    </div>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Ordered At</th>
                    <th>Items</th>
                    <th>Total Amount</th>
                    <th>Fulfillment Status</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>
                            <strong style="font-size: 13px; color: #0f172a; font-family: monospace;">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</strong>
                        </td>
                        <td>
                            <div class="user-info-cell">
                                <div class="user-avatar-sm">
                                    {{ strtoupper(substr($order->user->name ?? 'U', 0, 2)) }}
                                </div>
                                <div class="user-info-meta">
                                    <strong>{{ $order->user->name ?? 'Guest Buyer' }}</strong>
                                    <small>{{ $order->user->email ?? 'No email' }}</small>
                                </div>
                            </div>
                        </td>
                        <td style="color: #64748b; font-size: 12px; white-space: nowrap;">
                            {{ $order->created_at ? $order->created_at->format('M d, Y · h:i A') : '—' }}
                        </td>
                        <td>
                            <div style="font-size: 12px; color: #334155;">
                                @if($order->items && $order->items->count() > 0)
                                    @foreach($order->items as $it)
                                        @php
                                            $lineTotal = (float)($it->line_total ?? (($it->unit_price ?? 0) * ($it->quantity ?? 1)));
                                        @endphp
                                        <div style="margin-bottom: 3px; display: flex; align-items: baseline; gap: 4px; flex-wrap: wrap;">
                                            <span style="font-weight: 700; color: #0f172a; font-family: var(--font-mono, monospace);">{{ $it->quantity }}x</span> 
                                            <span style="font-weight: 600; color: #1e293b;">{{ $it->product_name ?? 'Product' }}</span>
                                            <small style="color: #64748b; font-family: var(--font-mono, monospace);">(${{ number_format($it->unit_price, 2) }} &bull; <strong style="color: #059669;">${{ number_format($lineTotal, 2) }}</strong>)</small>
                                        </div>
                                    @endforeach
                                @else
                                    <span style="color: #94a3b8;">{{ $order->notes ?? 'Standard Package' }}</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            @php
                                $finalTotal = (float)($order->total_amount ?? $order->subtotal ?? 0);
                                if ($finalTotal <= 0 && $order->items && $order->items->count() > 0) {
                                    $finalTotal = (float)$order->items->sum(function($i){ return ($i->line_total ?: ($i->unit_price * $i->quantity)); });
                                }
                            @endphp
                            <strong style="font-size: 14px; color: #059669; font-weight: 800; font-family: var(--font-mono, monospace); display: inline-block; padding: 2px 8px; background: #ecfdf5; border-radius: 6px; border: 1px solid #a7f3d0;">
                                ${{ number_format($finalTotal, 2) }}
                            </strong>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="form-select" style="padding: 3px 8px; font-size: 11px; font-weight: 600; width: auto; border-radius: 20px;
                                    @if($order->status === 'completed') background: #dcfce7; color: #15803d; border-color: #86efac;
                                    @elseif($order->status === 'processing') background: #e0f2fe; color: #0369a1; border-color: #bae6fd;
                                    @elseif($order->status === 'cancelled') background: #fee2e2; color: #b91c1c; border-color: #fecaca;
                                    @else background: #fef3c7; color: #b45309; border-color: #fde68a; @endif">
                                    <option value="requested" {{ $order->status === 'requested' ? 'selected' : '' }}>⏳ Requested</option>
                                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>⚙️ Processing</option>
                                    <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>✅ Completed</option>
                                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                                </select>
                            </form>
                        </td>
                        <td style="text-align: right;">
                            <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" onsubmit="return confirm('Delete order #{{ $order->id }}?');" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <span class="empty-state-icon">🛒</span>
                                <h4>No orders found</h4>
                                <p>Customer orders from the marketplace will show up here in real time.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($orders->hasPages())
        <div style="padding: 16px 20px; border-top: 1px solid var(--border);">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
