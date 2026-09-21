@extends('frontend.layouts.app')

@section('title', 'Your Cart — FurShield')

@section('content')
<div class="container section">

    <!-- 1. Header -->
    <div class="section-head-split reveal">
        <div>
            <div class="section-label">Shopping Cart</div>
            <h1>Your <em>Bag</em></h1>
            <p>{{ count($cart) > 0 ? count($cart) . ' item(s) selected' : 'Review your selected pet care products' }}</p>
        </div>

        <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">
            <span>Continue Shopping</span>
            <span class="btn-arrow">→</span>
        </a>
    </div>

    @php
        $displayCart = $cart;
        if (empty($displayCart)) {
            $displayCart = [
                1 => ['id' => 1, 'name' => 'Premium Dog Food', 'price' => 24.99, 'quantity' => 1, 'image' => '/images/dog-food.jpg'],
                2 => ['id' => 2, 'name' => 'Cat Litter', 'price' => 12.99, 'quantity' => 1, 'image' => '/images/cat-litter.jpg'],
                3 => ['id' => 3, 'name' => 'Pet Shampoo', 'price' => 8.99, 'quantity' => 1, 'image' => '/images/pet-shampoo.jpg'],
            ];
        }

        $calcSubtotal = 0;
        foreach ($displayCart as $it) {
            $calcSubtotal += $it['price'] * $it['quantity'];
        }
    @endphp

    <div class="fe-cart-layout reveal delay-1">
        
        <!-- Cart Line Items List -->
        <div class="card" style="overflow: hidden;">
            @foreach($displayCart as $id => $item)
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 22px 28px; border-bottom: 1px solid var(--border); gap: 20px; flex-wrap: wrap;">
                    
                    <!-- Product Info & Thumb -->
                    <div style="display: flex; align-items: center; gap: 16px; min-width: 240px;">
                        <div style="width: 64px; height: 64px; border-radius: var(--radius-sm); border: 1px solid var(--border); background: var(--paper-subtle); display: flex; align-items: center; justify-content: center; padding: 6px; flex-shrink: 0;">
                            <img src="{{ $item['image'] ?? '/images/dog-food.jpg' }}" alt="{{ $item['name'] }}" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                        </div>
                        <div>
                            <h4 style="font-size: 1rem; font-weight: 700; margin-bottom: 2px;">
                                {{ $item['name'] }}
                            </h4>
                            <div class="meta-label" style="color: var(--emerald-dark); font-size: 13px;">
                                ${{ number_format($item['price'], 2) }}
                            </div>
                        </div>
                    </div>

                    <!-- Quantity Control Stepper -->
                    <div style="display: flex; align-items: center; gap: 8px; background: var(--paper); border: 1px solid var(--border); border-radius: var(--radius-pill); padding: 4px 12px;">
                        <form action="{{ route('cart.update') }}" method="POST" style="display: inline;">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $id }}">
                            <input type="hidden" name="action" value="decrease">
                            <button type="submit" style="background: none; border: none; font-size: 1rem; cursor: pointer; color: var(--muted); padding: 0 4px; font-weight: 700;" aria-label="Decrease quantity">
                                -
                            </button>
                        </form>
                        <span style="font-family: var(--font-mono); font-weight: 700; font-size: 0.92rem; min-width: 24px; text-align: center; color: var(--ink);">
                            {{ $item['quantity'] }}
                        </span>
                        <form action="{{ route('cart.update') }}" method="POST" style="display: inline;">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $id }}">
                            <input type="hidden" name="action" value="increase">
                            <button type="submit" style="background: none; border: none; font-size: 1rem; cursor: pointer; color: var(--muted); padding: 0 4px; font-weight: 700;" aria-label="Increase quantity">
                                +
                            </button>
                        </form>
                    </div>

                    <!-- Item Total Price -->
                    <div style="font-family: var(--font-mono); font-size: 1.15rem; font-weight: 700; color: var(--ink); min-width: 90px; text-align: right;">
                        ${{ number_format($item['price'] * $item['quantity'], 2) }}
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Order Summary Card -->
        <div class="card card-padded" style="background: var(--white); position: sticky; top: 100px;">
            <div class="meta-label" style="margin-bottom: 18px;">Summary</div>

            <div style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 20px; font-size: 0.95rem;">
                <div style="display: flex; justify-content: space-between; color: var(--muted);">
                    <span>Subtotal</span>
                    <strong style="color: var(--ink); font-family: var(--font-mono);">${{ number_format($calcSubtotal, 2) }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between; color: var(--muted);">
                    <span>Standard Shipping</span>
                    <strong style="color: var(--emerald); font-family: var(--font-mono);">Free</strong>
                </div>
            </div>

            <div style="border-top: 1px solid var(--border); padding-top: 16px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: baseline;">
                <span style="font-size: 1rem; font-weight: 700; color: var(--ink);">Total</span>
                <span style="font-size: 1.5rem; font-weight: 800; font-family: var(--font-mono); color: var(--ink);">
                    ${{ number_format($calcSubtotal, 2) }}
                </span>
            </div>

            <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-block">
                <span>Proceed to Checkout</span>
                <span class="btn-arrow">↗</span>
            </a>
        </div>

    </div>

</div>
@endsection
