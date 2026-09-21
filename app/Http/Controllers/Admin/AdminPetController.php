<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Http\Request;

class AdminPetController extends Controller
{
    public function index(Request $request)
    {
        $query = Pet::with('user')->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('breed', 'like', "%{$search}%")
                  ->orWhere('species', 'like', "%{$search}%")
                  ->orWhere('microchip_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('species')) {
            $query->where('species', $request->input('species'));
        }

        $pets = $query->paginate(15)->withQueryString();
        $owners = User::where('role', 'owner')->orderBy('name')->get(['id', 'name']);

        return view('admin.pets.index', compact('pets', 'owners'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:100',
            'breed' => 'nullable|string|max:150',
            'sex' => 'required|in:male,female,unknown',
            'date_of_birth' => 'nullable|date',
            'weight_kg' => 'nullable|numeric|min:0',
            'microchip_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);

        Pet::create($validated);

        return redirect()->route('admin.pets.index')->with('success', 'Pet profile added successfully.');
    }

    public function update(Request $request, Pet $pet)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:100',
            'breed' => 'nullable|string|max:150',
            'sex' => 'required|in:male,female,unknown',
            'date_of_birth' => 'nullable|date',
            'weight_kg' => 'nullable|numeric|min:0',
            'microchip_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);

        $pet->update($validated);

        return redirect()->route('admin.pets.index')->with('success', 'Pet profile updated successfully.');
    }

    public function destroy(Pet $pet)
    {
        $pet->delete();

        return redirect()->route('admin.pets.index')->with('success', 'Pet removed successfully.');
    }
}
