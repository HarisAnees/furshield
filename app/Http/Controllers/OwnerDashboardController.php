<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\HealthRecord;
use App\Models\Order;
use App\Models\Pet;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class OwnerDashboardController extends Controller
{
    public function __invoke()
    {
        $owner = Auth::user();

        // Retrieve pets belonging to this logged-in pet owner
        $pets = Pet::where('user_id', $owner->id)->get();

        // If the newly registered user has no pets yet, provide empty or first demo pet context
        if ($pets->isEmpty()) {
            // Optional: fallback to demo pets for viewing experience if brand new account with 0 pets
            $demoPets = Pet::whereIn('name', ['Buddy', 'Luna'])->get();
            $buddy = $demoPets->firstWhere('name', 'Buddy');
            $luna = $demoPets->firstWhere('name', 'Luna');
        } else {
            $buddy = $pets->firstWhere('name', 'Buddy') ?? $pets->first();
            $luna = $pets->firstWhere('name', 'Luna') ?? $pets->skip(1)->first();
        }

        $appointment = Appointment::with(['vet.user', 'pet'])
            ->where('user_id', $owner->id)
            ->whereIn('status', ['confirmed', 'pending'])
            ->latest('starts_at')
            ->first();

        // If user has no specific appointment, fallback to latest confirmed appointment
        if (!$appointment) {
            $appointment = Appointment::with(['vet.user', 'pet'])
                ->where('status', 'confirmed')
                ->latest('starts_at')
                ->first();
        }

        $petCount = $pets->count();
        $apptCount = Appointment::where('user_id', $owner->id)->whereIn('status', ['confirmed', 'pending'])->count();
        $orderCount = Order::where('user_id', $owner->id)->count();

        $stats = [
            'pets' => max(1, $petCount),
            'upcoming_appointments' => max(1, $apptCount),
            'health_records' => 5,
            'orders' => max(0, $orderCount),
        ];

        return view('owner.dashboard', compact('owner', 'pets', 'buddy', 'luna', 'appointment', 'stats'));
    }
}
