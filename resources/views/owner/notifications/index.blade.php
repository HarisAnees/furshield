@extends('owner.layouts.app')

@section('title', 'Notifications')

@section('content')
<div class="owner-subpage-card" style="max-width: 800px;">
    <div class="owner-subpage-header">
        <div class="owner-subpage-title">
            <i class="fa-solid fa-bell" style="color: #10b981;"></i> Activity Alerts & Care Reminders
        </div>
    </div>
    <div class="owner-subpage-body no-padding" style="padding: 0;">
        <div style="display: flex; flex-direction: column;">
            <!-- Notification Item 1 -->
            <div class="owner-activity-row" style="display: flex; align-items: flex-start; gap: 14px; background: #f8fafc;">
                <div style="width: 38px; height: 38px; border-radius: 50%; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center; font-size: 15px; flex-shrink: 0;">
                    <i class="fa-solid fa-syringe"></i>
                </div>
                <div style="flex: 1; min-width: 0;">
                    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 6px;">
                        <strong style="font-size: 13.5px; color: #0f172a;">Vaccination Reminder: Buddy's Rabies Booster Due</strong>
                        <span style="font-size: 11px; color: #94a3b8;">Tomorrow</span>
                    </div>
                    <p style="font-size: 12.5px; color: #475569; margin: 4px 0 0; line-height: 1.4;">
                        Buddy is scheduled for his annual booster shot. Remember to bring previous vaccination certificates if visiting a new branch.
                    </p>
                </div>
            </div>

            <!-- Notification Item 2 -->
            <div class="owner-activity-row" style="display: flex; align-items: flex-start; gap: 14px;">
                <div style="width: 38px; height: 38px; border-radius: 50%; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 15px; flex-shrink: 0;">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
                <div style="flex: 1; min-width: 0;">
                    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 6px;">
                        <strong style="font-size: 13.5px; color: #0f172a;">Appointment Confirmed with Dr. Emily Carter</strong>
                        <span style="font-size: 11px; color: #94a3b8;">2 days ago</span>
                    </div>
                    <p style="font-size: 12.5px; color: #475569; margin: 4px 0 0; line-height: 1.4;">
                        Your appointment for Buddy has been approved by FurShield Clinic.
                    </p>
                </div>
            </div>

            <!-- Notification Item 3 -->
            <div class="owner-activity-row" style="display: flex; align-items: flex-start; gap: 14px;">
                <div style="width: 38px; height: 38px; border-radius: 50%; background: #fef3c7; color: #b45309; display: flex; align-items: center; justify-content: center; font-size: 15px; flex-shrink: 0;">
                    <i class="fa-solid fa-box-open"></i>
                </div>
                <div style="flex: 1; min-width: 0;">
                    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 6px;">
                        <strong style="font-size: 13.5px; color: #0f172a;">Marketplace Order Processed</strong>
                        <span style="font-size: 11px; color: #94a3b8;">3 days ago</span>
                    </div>
                    <p style="font-size: 12.5px; color: #475569; margin: 4px 0 0; line-height: 1.4;">
                        Your order for Premium Grain-Free Salmon Recipe has been packed and scheduled for delivery.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
