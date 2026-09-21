<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\HealthRecord;
use App\Models\Pet;
use App\Models\User;
use App\Models\Vet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VetPortalController extends Controller
{
    /**
     * Get or create the Vet profile for the authenticated clinician user.
     */
    protected function getVetProfile(): Vet
    {
        $user = Auth::user();
        return Vet::firstOrCreate(
            ['user_id' => $user->id],
            [
                'specialization' => 'General Veterinary Medicine',
                'experience_years' => 5,
                'clinic_name' => $user->name . ' Clinical Center',
                'address' => $user->address ?? 'Clinical Practice Suite',
                'city' => 'Metro City',
                'is_available' => true,
            ]
        );
    }

    /**
     * Veterinarian Dashboard Overview
     */
    public function dashboard()
    {
        $vet = $this->getVetProfile();
        $user = Auth::user();
        $today = Carbon::today();

        // Get appointments for this specific vet
        $appointments = Appointment::with(['pet.user', 'user'])
            ->where('vet_id', $vet->id)
            ->latest('starts_at')
            ->get();

        // If the vet has no appointments yet, pull demo/recent appointments to display a rich clinical interface
        if ($appointments->isEmpty()) {
            $appointments = Appointment::with(['pet.user', 'user'])->latest('starts_at')->limit(8)->get();
        }

        $upcoming = $appointments->whereIn('status', ['confirmed', 'pending']);
        $completedToday = $appointments->where('status', 'completed')->filter(fn($a) => Carbon::parse($a->starts_at)->isToday())->count();
        $totalPatients = $appointments->pluck('pet_id')->unique()->count();

        $stats = [
            'upcoming' => $upcoming->count(),
            'total_patients' => max(1, $totalPatients),
            'completed_today' => $completedToday,
            'is_available' => (bool)$vet->is_available,
        ];

        $recentRecords = HealthRecord::with('pet')
            ->where('provider_name', 'like', '%' . $user->name . '%')
            ->orWhereIn('pet_id', $appointments->pluck('pet_id')->filter())
            ->latest('recorded_at')
            ->limit(5)
            ->get();

        return view('vet.dashboard', compact('vet', 'user', 'appointments', 'upcoming', 'stats', 'recentRecords'));
    }

    /**
     * Full appointment bookings & schedule management
     */
    public function appointments()
    {
        $vet = $this->getVetProfile();
        $appointments = Appointment::with(['pet.user', 'user'])
            ->where('vet_id', $vet->id)
            ->latest('starts_at')
            ->paginate(15);

        if ($appointments->isEmpty()) {
            $appointments = Appointment::with(['pet.user', 'user'])->latest('starts_at')->paginate(15);
        }

        return view('vet.appointments', compact('vet', 'appointments'));
    }

    /**
     * Approve, reschedule or cancel an appointment
     */
    public function updateAppointmentStatus(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'starts_at' => 'nullable|date',
        ]);

        $updateData = ['status' => $validated['status']];
        if (!empty($validated['starts_at'])) {
            $updateData['starts_at'] = Carbon::parse($validated['starts_at']);
        }

        $appointment->update($updateData);

        return back()->with('success', 'Appointment #' . $appointment->id . ' status successfully updated to ' . ucfirst($validated['status']) . '.');
    }

    /**
     * Log diagnosis, medication, and clinical observations (SRS 1.6)
     */
    public function logTreatment(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'diagnosis' => 'required|string|max:1000',
            'symptoms' => 'nullable|string|max:1000',
            'medication' => 'nullable|string|max:1000',
            'follow_up_notes' => 'nullable|string|max:1000',
        ]);

        // Update appointment record
        $appointment->update([
            'diagnosis' => $validated['diagnosis'],
            'symptoms' => $validated['symptoms'] ?? $appointment->symptoms,
            'medication' => $validated['medication'] ?? null,
            'follow_up_notes' => $validated['follow_up_notes'] ?? null,
            'status' => 'completed',
        ]);

        // Automatically create a permanent HealthRecord on the pet's timeline
        if ($appointment->pet_id) {
            HealthRecord::create([
                'pet_id' => $appointment->pet_id,
                'record_type' => 'treatment',
                'title' => 'Clinical Consultation: ' . $validated['diagnosis'],
                'description' => $validated['follow_up_notes'] ?? 'Consultation examination completed.',
                'recorded_at' => now(),
                'provider_name' => Auth::user()->name,
                'medication' => $validated['medication'] ?? null,
                'follow_up_at' => now()->addWeeks(2),
            ]);
        }

        return back()->with('success', 'Treatment notes recorded and saved to pet health passport.');
    }

    /**
     * View complete medical history for a patient pet
     */
    public function medicalHistory(Pet $pet)
    {
        $vet = $this->getVetProfile();
        $records = HealthRecord::where('pet_id', $pet->id)->latest('recorded_at')->get();
        $pastAppointments = Appointment::where('pet_id', $pet->id)->latest('starts_at')->get();

        return view('vet.patient_history', compact('vet', 'pet', 'records', 'pastAppointments'));
    }

    /**
     * Profile & Availability Management
     */
    public function profile()
    {
        $vet = $this->getVetProfile();
        $user = Auth::user();
        return view('vet.profile', compact('vet', 'user'));
    }

    /**
     * Update clinic details & toggle availability
     */
    public function updateProfile(Request $request)
    {
        $vet = $this->getVetProfile();
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
            'clinic_name' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'experience_years' => 'required|integer|min:0|max:60',
            'address' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'is_available' => 'nullable|boolean',
        ]);

        $user->update([
            'name' => $validated['name'],
            'phone' => $validated['phone'] ?? $user->phone,
        ]);

        $vet->update([
            'clinic_name' => $validated['clinic_name'],
            'specialization' => $validated['specialization'],
            'experience_years' => $validated['experience_years'],
            'address' => $validated['address'] ?? $vet->address,
            'bio' => $validated['bio'] ?? $vet->bio,
            'is_available' => $request->boolean('is_available'),
        ]);

        return back()->with('success', 'Veterinary clinical profile updated successfully.');
    }
}
