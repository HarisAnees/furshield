<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HealthRecord;
use App\Models\Pet;
use Illuminate\Http\Request;

class AdminHealthRecordController extends Controller
{
    public function index(Request $request)
    {
        $query = HealthRecord::with('pet.user')->latest('recorded_at');

        if ($request->filled('type')) {
            $query->where('record_type', $request->input('type'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('provider_name', 'like', "%{$search}%")
                  ->orWhereHas('pet', fn ($p) => $p->where('name', 'like', "%{$search}%"));
            });
        }

        $records = $query->paginate(15)->withQueryString();
        $pets = Pet::with('user')->orderBy('name')->get();

        return view('admin.health_records.index', compact('records', 'pets'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pet_id' => 'required|exists:pets,id',
            'record_type' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'recorded_at' => 'required|date',
            'provider_name' => 'nullable|string|max:255',
            'medication' => 'nullable|string',
        ]);

        HealthRecord::create($validated);

        return redirect()->route('admin.health-records.index')->with('success', 'Health record saved successfully.');
    }

    public function destroy(HealthRecord $healthRecord)
    {
        $healthRecord->delete();

        return redirect()->route('admin.health-records.index')->with('success', 'Health record deleted.');
    }
}
