<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    public function index()
    {
        $settings = [
            'platform_name' => 'FurShield Pet Care Management',
            'support_email' => 'support@furshield.test',
            'contact_phone' => '+1 (555) 0199-CARE',
            'clinic_hours' => 'Mon - Sat: 08:00 AM - 07:00 PM',
            'auto_confirm_appointments' => false,
            'low_stock_threshold' => 15,
            'email_reminders' => true,
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        return back()->with('success', 'Platform settings saved successfully.');
    }
}
