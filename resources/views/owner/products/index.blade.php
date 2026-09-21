@extends('owner.layouts.app')

@section('title', 'Pet Products & Pharmacy')

@section('content')
<!-- Store Catalog -->
<div class="owner-subpage-card">
    <div class="owner-subpage-header">
        <div class="owner-subpage-title">
            <span>🛍️</span> Recommended Food, Supplies & Pharmacy
        </div>
        <span style="font-size: 12px; color: #64748b;">{{ $products->count() }} Products Available</span>
    </div>
    <div class="owner-subpage-body">
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 20px;">
            @forelse($products as $prod)
                <div style="border: 1px solid var(--border); border-radius: 12px; overflow: hidden; background: #ffffff; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
                    <div style="height: 150px; background: #f8fafc; overflow: hidden; display: flex; align-items: center; justify-content: center; position: relative;">
                        @if(stripos($prod->name, 'food') !== false || stripos($prod->name, 'salmon') !== false)
                            <img src="/images/dog-food.jpg" alt="{{ $prod->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @elseif(stripos($prod->name, 'shampoo') !== false)
                            <img src="/images/pet-shampoo.jpg" alt="{{ $prod->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @elseif(stripos($prod->name, 'litter') !== false)
                            <img src="/images/cat-litter.jpg" alt="{{ $prod->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @elseif(stripos($prod->name, 'toy') !== false || stripos($prod->name, 'rope') !== false)
                            <img src="/images/dog-toys.jpg" alt="{{ $prod->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <span style="font-size: 48px;">📦</span>
                        @endif
                        <span style="position: absolute; top: 10px; right: 10px; background: rgba(255,255,255,0.9); font-size: 10px; font-weight: 700; padding: 2px 8px; border-radius: 12px; color: #0f172a;">
                            {{ $prod->category }}
                        </span>
                    </div>

                    <div style="padding: 16px; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <strong style="font-size: 14px; color: #0f172a; display: block; margin-bottom: 4px;">{{ $prod->name }}</strong>
                            <p style="font-size: 12px; color: #64748b; line-height: 1.35; margin-bottom: 12px;">
                                {{ \Illuminate\Support\Str::limit($prod->description, 60) }}
                            </p>
                        </div>

                        <div style="border-top: 1px solid #f1f5f9; padding-top: 12px; display: flex; align-items: center; justify-content: space-between;">
                            <div>
                                <span style="font-size: 11px; color: #64748b; display: block;">Price</span>
                                <strong style="font-size: 16px; color: #10b981;">${{ number_format($prod->price, 2) }}</strong>
                            </div>

                            <form method="POST" action="{{ route('owner.products.buy', $prod) }}">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="owner-btn owner-btn-primary" style="padding: 6px 14px; font-size: 11.5px;">
                                    Buy Now
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #64748b;">
                    <h4>No marketplace products available</h4>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- My Order History -->
<div class="owner-subpage-card">
    <div class="owner-subpage-header">
        <div class="owner-subpage-title">
            <span>📦</span> My Order History ({{ $myOrders->count() }})
        </div>
    </div>
    <div class="owner-subpage-body no-padding" style="padding: 0;">
        <div style="display: flex; flex-direction: column;">
            @forelse($myOrders as $ord)
                <div style="padding: 16px 24px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
                    <div>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <strong style="font-size: 13.5px; color: #0f172a; font-family: monospace;">#ORD-{{ str_pad($ord->id, 5, '0', STR_PAD_LEFT) }}</strong>
                            <span style="font-size: 11px; font-weight: 600; padding: 2px 8px; border-radius: 12px;
                                @if($ord->status === 'completed') background: #dcfce7; color: #15803d;
                                @elseif($ord->status === 'processing') background: #e0f2fe; color: #0369a1;
                                @else background: #fef3c7; color: #b45309; @endif">
                                {{ ucfirst($ord->status) }}
                            </span>
                        </div>
                        <div style="font-size: 12px; color: #475569; margin-top: 4px;">
                            @if($ord->items && $ord->items->count() > 0)
                                @foreach($ord->items as $it)
                                    <span>{{ $it->quantity }}x {{ $it->product_name }}</span>
                                @endforeach
                            @else
                                <span>{{ $ord->notes ?? 'Marketplace Item' }}</span>
                            @endif
                        </div>
                    </div>

                    <div style="text-align: right;">
                        <strong style="font-size: 14px; color: #0f172a; display: block;">${{ number_format($ord->subtotal ?? $ord->total_amount, 2) }}</strong>
                        <small style="color: #64748b;">{{ $ord->created_at ? $ord->created_at->format('M d, Y · h:i A') : 'Recently' }}</small>
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 30px; color: #64748b;">
                    <p style="font-size: 12px; margin: 0;">You have not placed any store orders yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
