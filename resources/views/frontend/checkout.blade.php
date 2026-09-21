@extends('frontend.layouts.app')

@section('title', 'Order Checkout — FurShield')

@section('content')
<div class="container section">

    <!-- 1. Header & Stepper -->
    <div class="section-head reveal" style="margin-bottom: 36px;">
        <div class="section-label">Order Process</div>
        <h1>Order <em>Checkout</em></h1>
    </div>

    <!-- Stepper (Shipping -> Review -> Confirmation) -->
    <div class="reveal delay-1" style="display: flex; align-items: center; gap: 18px; margin-bottom: 48px; max-width: 540px;">
        <div style="display: flex; align-items: center; gap: 8px; color: var(--emerald); font-weight: 700; font-size: 13px; font-family: var(--font-mono);">
            <span style="width: 26px; height: 26px; border-radius: 50%; background: var(--emerald); color: var(--white); display: flex; align-items: center; justify-content: center; font-size: 11px;">1</span>
            SHIPPING
        </div>
        <div style="flex: 1; height: 1px; background: var(--border);"></div>
        <div style="display: flex; align-items: center; gap: 8px; color: var(--muted); font-weight: 600; font-size: 13px; font-family: var(--font-mono);">
            <span style="width: 26px; height: 26px; border-radius: 50%; background: var(--paper-subtle); border: 1px solid var(--border); color: var(--muted); display: flex; align-items: center; justify-content: center; font-size: 11px;">2</span>
            REVIEW
        </div>
        <div style="flex: 1; height: 1px; background: var(--border);"></div>
        <div style="display: flex; align-items: center; gap: 8px; color: var(--muted); font-weight: 600; font-size: 13px; font-family: var(--font-mono);">
            <span style="width: 26px; height: 26px; border-radius: 50%; background: var(--paper-subtle); border: 1px solid var(--border); color: var(--muted); display: flex; align-items: center; justify-content: center; font-size: 11px;">3</span>
            CONFIRM
        </div>
    </div>

    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        
        <div class="fe-checkout-layout reveal delay-2">
            
            <!-- Left Column: Shipping Address & Instructions -->
            <div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                    <h2 style="font-size: 1.4rem;">Delivery Destination</h2>
                    <span class="meta-label" style="color: var(--emerald);">Primary Address</span>
                </div>

                <!-- Selected Address Card -->
                <div class="card card-padded" style="border-color: var(--emerald-border); background: var(--emerald-soft); display: flex; gap: 16px; align-items: flex-start; margin-bottom: 24px;">
                    <div style="width: 18px; height: 18px; border-radius: 50%; border: 5px solid var(--emerald); background: var(--white); margin-top: 3px; flex-shrink: 0;"></div>
                    <div>
                        <strong style="display: block; font-size: 1.05rem; color: var(--ink); margin-bottom: 4px;">
                            Sarah Johnson
                        </strong>
                        <p style="color: var(--emerald-dark); font-size: 0.92rem; line-height: 1.5; margin: 0;">
                            123 Pet Lane, Lahore, Punjab 54000<br>
                            Pakistan • +92 300 1234567
                        </p>
                    </div>
                </div>

                <div class="card card-padded" style="background: var(--white);">
                    <div class="meta-label" style="margin-bottom: 10px;">Payment Method</div>
                    <div style="display: flex; align-items: center; gap: 10px; font-weight: 600; font-size: 0.95rem; color: var(--ink);">
                        <span>💵</span>
                        <span>Cash on Delivery / In-Clinic Settlement</span>
                    </div>
                    <p style="font-size: 0.85rem; color: var(--muted); margin-top: 6px;">
                        As per SRS specifications, online credit gateway processing is excluded. Payment will be completed upon receipt or during veterinary clinic visit.
                    </p>
                </div>

                <!-- Hidden inputs required by controller -->
                <input type="hidden" name="recipient_name" value="Sarah Johnson">
                <input type="hidden" name="phone" value="+92 300 1234567">
                <input type="hidden" name="delivery_address" value="123 Pet Lane, Lahore, Punjab 54000, Pakistan">
                <input type="hidden" name="payment_method" value="Cash on Delivery / In-Clinic">
            </div>

            <!-- Right Column: Order Summary -->
            <div class="card card-padded" style="background: var(--white); position: sticky; top: 100px;">
                <div class="meta-label" style="margin-bottom: 16px;">Order Summary</div>

                <div style="display: flex; gap: 14px; align-items: center; margin-bottom: 20px;">
                    <div style="width: 52px; height: 52px; border-radius: var(--radius-sm); border: 1px solid var(--border); background: var(--paper); display: flex; align-items: center; justify-content: center; padding: 4px;">
                        <img src="/images/dog-food.jpg" alt="Order product preview" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                    </div>
                    <div style="flex: 1;">
                        <h4 style="font-size: 0.95rem; font-weight: 700; margin-bottom: 2px;">Premium Dog Food</h4>
                        <div class="meta-label">$24.99 • Qty: 1</div>
                    </div>
                </div>

                <div style="border-top: 1px solid var(--border); padding-top: 16px; margin-bottom: 16px; display: flex; flex-direction: column; gap: 10px; font-size: 0.92rem;">
                    <div style="display: flex; justify-content: space-between; color: var(--muted);">
                        <span>Subtotal</span>
                        <strong style="color: var(--ink); font-family: var(--font-mono);">$24.99</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; color: var(--muted);">
                        <span>Delivery Fee</span>
                        <strong style="color: var(--emerald); font-family: var(--font-mono);">Free</strong>
                    </div>
                </div>

                <div style="border-top: 1px solid var(--border); padding-top: 16px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: baseline;">
                    <span style="font-size: 1rem; font-weight: 700; color: var(--ink);">Total Payable</span>
                    <span style="font-size: 1.45rem; font-weight: 800; font-family: var(--font-mono); color: var(--ink);">$24.99</span>
                </div>

                <button type="submit" class="btn btn-primary btn-block">
                    <span>Confirm & Place Order</span>
                    <span class="btn-arrow">↗</span>
                </button>
            </div>

        </div>
    </form>

</div>
@endsection
