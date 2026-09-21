@extends('frontend.layouts.app')

@section('title', 'Contact & Emergency Hospital Dispatch — FurShield')

@section('content')
<div class="container section">

    <!-- 1. Editorial Header -->
    <div class="section-head reveal">
        <div class="section-label">Direct Communication & Emergency Dispatch</div>
        <h1>Get in <em>Touch</em></h1>
        <p>Our veterinary clinical support, emergency triage unit, and shelter coordinators are standing by.</p>
    </div>

    <!-- 2. Responsive Contact & Emergency Grid -->
    <div class="fe-contact-grid reveal delay-1">
        
        <!-- Left: Direct Info Cards & 24/7 Emergency Card -->
        <div style="display: flex; flex-direction: column; gap: 18px;">
            
            <!-- Dedicated 24/7 Emergency Hospital Dispatch Card -->
            <div class="fe-contact-emergency-card">
                <div class="fe-contact-emergency-badge">
                    <span>🚨</span>
                    <span>24/7 Emergency Dispatch</span>
                </div>
                <h3 style="font-size: 1.25rem; margin-bottom: 6px; color: #ffffff;">Immediate Clinical Triage</h3>
                <p style="font-size: 0.9rem; line-height: 1.5; margin: 0; color: #d1fae5;">
                    For critical trauma, poison ingestion, breathing distress, or acute injuries. Our on-duty veterinarians are reachable around the clock.
                </p>
                <div style="display: flex; flex-wrap: wrap; gap: 10px; align-items: center; margin-top: 14px;">
                    <a href="tel:+15550199738" class="fe-contact-emergency-phone">
                        <span>📞 Call Emergency: +1 (555) 0199-PETS</span>
                    </a>
                    <a href="tel:+923001234567" class="fe-contact-emergency-phone" style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.25);">
                        <span>Lahore Dispatch: +92 300 1234567</span>
                    </a>
                </div>
            </div>

            <div class="card card-padded">
                <div class="meta-label" style="margin-bottom: 8px;">Physical Care Center</div>
                <h3 style="font-size: 1.15rem; margin-bottom: 4px;">Lahore Clinical Campus</h3>
                <p style="font-size: 0.9rem; line-height: 1.5; margin: 0;">
                    123 Pet Lane, Lahore, Punjab 54000, Pakistan
                </p>
            </div>

            <div class="card card-padded">
                <div class="meta-label" style="margin-bottom: 8px;">Electronic Mail</div>
                <h3 style="font-size: 1.15rem; margin-bottom: 4px;">Support & Guidance</h3>
                <a href="mailto:support@furshield.com" style="color: var(--emerald-dark); font-weight: 600; font-size: 0.95rem;">
                    support@furshield.com ↗
                </a>
            </div>
        </div>

        <!-- Right: Working Contact Form -->
        <div class="card card-padded" style="background: var(--white);">
            <div class="meta-label" style="margin-bottom: 16px;">Send a Direct Message</div>
            
            <form action="{{ route('contact.submit') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label">Your Name *</label>
                    <input type="text" name="name" required placeholder="Sarah Johnson" value="Sarah Johnson" class="form-control">
                </div>

                <div class="form-group">
                    <label class="form-label">Email Address *</label>
                    <input type="email" name="email" required placeholder="sarah@example.com" value="sarah@example.com" class="form-control">
                </div>

                <div class="form-group">
                    <label class="form-label">Your Message or Inquiry *</label>
                    <textarea name="message" rows="4" required placeholder="How can our clinical or adoption team assist you today?" class="form-control"></textarea>
                </div>

                <button type="submit" class="btn btn-primary btn-block" style="margin-top: 8px;">
                    <span>Transmit Message</span>
                    <span class="btn-arrow">↗</span>
                </button>
            </form>
        </div>

    </div>

    <!-- 3. Google Maps Campus Location (SRS Page 10 & 11) -->
    <div class="card card-padded reveal delay-2" style="margin-top: 36px; padding: 16px; overflow: hidden; border-radius: 24px; background: var(--white); box-shadow: 0 8px 30px rgba(0,0,0,0.04);">
        <div style="padding: 8px 12px 14px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
            <div>
                <span class="meta-label">Campus Geolocation Services</span>
                <h3 style="font-size: 1.15rem; margin: 4px 0 0; color: #091a13;">FurShield Clinical Center & Shelter Sanctuary</h3>
            </div>
            <span style="font-size: 12px; color: var(--emerald-dark); font-weight: 700; background: #ecfdf5; border: 1px solid rgba(16,185,129,0.3); padding: 4px 12px; border-radius: 9999px;">
                📍 Interactive Google Map
            </span>
        </div>
        <div style="width: 100%; height: clamp(240px, 45vh, 360px); border-radius: 16px; overflow: hidden; border: 1px solid #e2e8f0;">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d108862.90693514757!2d74.22591605!3d31.5203696!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39190483e58107d9%3A0xc23e4b78997c4e51!2sLahore%2C%20Punjab!5e0!3m2!1sen!2s!4v1710000000000!5m2!1sen!2s" 
                width="100%" 
                height="100%" 
                style="border: 0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>

</div>
@endsection
