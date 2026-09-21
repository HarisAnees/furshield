<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdoptionListing;
use App\Models\Shelter;
use Illuminate\Http\Request;

class AdminAdoptionController extends Controller
{
    public function index(Request $request)
    {
        $query = AdoptionListing::with('shelter')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('pet_name', 'like', "%{$search}%")
                  ->orWhere('breed', 'like', "%{$search}%")
                  ->orWhere('species', 'like', "%{$search}%");
            });
        }

        $listings = $query->paginate(12)->withQueryString();
        $shelters = Shelter::all();

        return view('admin.adoptions.index', compact('listings', 'shelters'));
    }

    public function store(Request $request)
    {
        $shelter = Shelter::first();
        $shelterId = $shelter ? $shelter->id : 1;

        $validated = $request->validate([
            'pet_name' => 'required|string|max:255',
            'species' => 'required|string|max:100',
            'breed' => 'nullable|string|max:150',
            'age_text' => 'nullable|string|max:100',
            'sex' => 'required|in:male,female,unknown',
            'health_summary' => 'nullable|string',
            'status' => 'required|in:available,pending,adopted',
        ]);

        $validated['shelter_id'] = $request->input('shelter_id', $shelterId);

        AdoptionListing::create($validated);

        return redirect()->route('admin.adoptions.index')->with('success', 'Rescue pet listing created successfully.');
    }

    public function updateStatus(Request $request, AdoptionListing $adoption)
    {
        $validated = $request->validate([
            'status' => 'required|in:available,pending,adopted',
        ]);

        $adoption->update($validated);

        return back()->with('success', 'Adoption status updated.');
    }

    public function destroy(AdoptionListing $adoption)
    {
        $adoption->delete();

        return redirect()->route('admin.adoptions.index')->with('success', 'Adoption listing removed.');
    }
}
