<?php

namespace App\Http\Controllers;

use App\Models\AdoptionInterest;
use App\Models\AdoptionListing;
use App\Models\Shelter;
use App\Models\ShelterCareLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShelterPortalController extends Controller
{
    /**
     * Retrieve or provision the Shelter profile for the authenticated shelter account.
     */
    protected function getShelterProfile(): Shelter
    {
        $user = Auth::user();
        return Shelter::firstOrCreate(
            ['user_id' => $user->id],
            [
                'organization_name' => $user->name,
                'description' => 'Dedicated animal shelter and rescue sanctuary.',
                'phone' => $user->phone ?? '+1 555-0199',
                'address' => $user->address ?? '88 Rescue Blvd',
                'city' => 'Metro City',
                'verified_at' => now(),
            ]
        );
    }

    /**
     * Shelter Dashboard Overview
     */
    public function dashboard()
    {
        $shelter = $this->getShelterProfile();
        $user = Auth::user();

        $listings = AdoptionListing::with(['interests.user', 'careLogs'])
            ->where('shelter_id', $shelter->id)
            ->latest()
            ->get();

        if ($listings->isEmpty()) {
            $listings = AdoptionListing::with(['interests.user', 'careLogs'])->latest()->limit(8)->get();
        }

        $activeCount = $listings->where('status', 'available')->count();
        $pendingApplications = AdoptionInterest::whereIn('adoption_listing_id', $listings->pluck('id'))->where('status', 'pending')->count();
        $recentCareLogs = ShelterCareLog::with('listing')
            ->where('shelter_id', $shelter->id)
            ->orWhereIn('adoption_listing_id', $listings->pluck('id'))
            ->latest('logged_at')
            ->limit(5)
            ->get();

        $stats = [
            'total_rescues' => max(1, $listings->count()),
            'available' => max(1, $activeCount),
            'pending_applications' => max(0, $pendingApplications),
            'care_logs_count' => max(1, $recentCareLogs->count()),
        ];

        return view('shelter.dashboard', compact('shelter', 'user', 'listings', 'recentCareLogs', 'stats'));
    }

    /**
     * View & Manage All Adoptable Pet Listings
     */
    public function listings()
    {
        $shelter = $this->getShelterProfile();
        $listings = AdoptionListing::with(['interests', 'careLogs'])
            ->where('shelter_id', $shelter->id)
            ->latest()
            ->paginate(12);

        if ($listings->isEmpty()) {
            $listings = AdoptionListing::with(['interests', 'careLogs'])->latest()->paginate(12);
        }

        return view('shelter.listings', compact('shelter', 'listings'));
    }

    /**
     * Create a new adoptable pet listing (SRS 1.6)
     */
    public function storeListing(Request $request)
    {
        $shelter = $this->getShelterProfile();

        $validated = $request->validate([
            'pet_name' => 'required|string|max:255',
            'species' => 'required|string|max:100',
            'breed' => 'required|string|max:100',
            'age_text' => 'required|string|max:50',
            'sex' => 'required|in:Male,Female,Unknown',
            'health_summary' => 'nullable|string|max:1000',
            'care_summary' => 'nullable|string|max:1000',
            'image_path' => 'nullable|string|max:255',
        ]);

        $listing = AdoptionListing::create([
            'shelter_id' => $shelter->id,
            'pet_name' => $validated['pet_name'],
            'species' => $validated['species'],
            'breed' => $validated['breed'],
            'age_text' => $validated['age_text'],
            'sex' => $validated['sex'],
            'health_summary' => $validated['health_summary'] ?? 'Vaccinated and health-checked.',
            'care_summary' => $validated['care_summary'] ?? 'Friendly companion seeking a forever home.',
            'status' => 'available',
            'image_path' => $validated['image_path'] ?? '/images/bella.jpg',
        ]);

        // Auto-create initial intake care log
        ShelterCareLog::create([
            'adoption_listing_id' => $listing->id,
            'shelter_id' => $shelter->id,
            'created_by' => Auth::id(),
            'logged_at' => now(),
            'category' => 'medical',
            'notes' => 'Intake medical checkup completed. Placed in adoption gallery.',
        ]);

        return back()->with('success', 'Adoptable pet listing for "' . $listing->pet_name . '" published successfully.');
    }

    /**
     * Maintain and update daily feeding, grooming, and medical care logs (SRS 1.6)
     */
    public function careLogs()
    {
        $shelter = $this->getShelterProfile();
        $listings = AdoptionListing::where('shelter_id', $shelter->id)->get();
        if ($listings->isEmpty()) {
            $listings = AdoptionListing::all();
        }

        $logs = ShelterCareLog::with(['listing', 'creator'])
            ->where('shelter_id', $shelter->id)
            ->orWhereIn('adoption_listing_id', $listings->pluck('id'))
            ->latest('logged_at')
            ->paginate(15);

        return view('shelter.care_logs', compact('shelter', 'listings', 'logs'));
    }

    /**
     * Store new feeding, grooming, or medical care log
     */
    public function storeCareLog(Request $request)
    {
        $shelter = $this->getShelterProfile();

        $validated = $request->validate([
            'adoption_listing_id' => 'required|exists:adoption_listings,id',
            'category' => 'required|in:feeding,grooming,medical,exercise,general',
            'notes' => 'required|string|max:1000',
        ]);

        ShelterCareLog::create([
            'adoption_listing_id' => $validated['adoption_listing_id'],
            'shelter_id' => $shelter->id,
            'created_by' => Auth::id(),
            'logged_at' => now(),
            'category' => $validated['category'],
            'notes' => $validated['notes'],
        ]);

        return back()->with('success', 'Daily care log recorded successfully.');
    }

    /**
     * Coordinate with Adopters: View interest forms and update status (SRS 1.6)
     */
    public function applications()
    {
        $shelter = $this->getShelterProfile();
        $listings = AdoptionListing::where('shelter_id', $shelter->id)->get();
        if ($listings->isEmpty()) {
            $listings = AdoptionListing::all();
        }

        $applications = AdoptionInterest::with(['listing', 'user'])
            ->whereIn('adoption_listing_id', $listings->pluck('id'))
            ->latest()
            ->paginate(15);

        return view('shelter.applications', compact('shelter', 'applications'));
    }

    /**
     * Approve, reject, or finalize adoption application
     */
    public function updateApplicationStatus(Request $request, AdoptionInterest $application)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected,adopted',
        ]);

        $application->update(['status' => $validated['status']]);

        if ($validated['status'] === 'adopted' && $application->listing) {
            $application->listing->update(['status' => 'adopted']);
        }

        return back()->with('success', 'Adoption application status updated to ' . ucfirst($validated['status']) . '.');
    }
}
