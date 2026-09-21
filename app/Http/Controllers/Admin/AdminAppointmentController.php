<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Pet;
use App\Models\User;
use App\Models\Vet;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminAppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with(['pet', 'user', 'vet.user'])->latest('starts_at');

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('reason', 'like', "%{$search}%")
                  ->orWhereHas('pet', fn ($p) => $p->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }

        $appointments = $query->paginate(15)->withQueryString();
        $pets = Pet::orderBy('name')->get(['id', 'name', 'user_id']);
        $users = User::where('role', 'owner')->orderBy('name')->get(['id', 'name']);
        $vets = Vet::with('user')->get();

        $statusCounts = [
            'all' => Appointment::count(),
            'scheduled' => Appointment::where('status', 'scheduled')->count(),
            'confirmed' => Appointment::where('status', 'confirmed')->count(),
            'completed' => Appointment::where('status', 'completed')->count(),
            'cancelled' => Appointment::where('status', 'cancelled')->count(),
        ];

        return view('admin.appointments.index', compact('appointments', 'pets', 'users', 'vets', 'statusCounts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'pet_id' => 'required|exists:pets,id',
            'vet_id' => 'required|exists:vets,id',
            'starts_at' => 'required|date',
            'reason' => 'required|string|max:255',
            'status' => 'required|in:scheduled,confirmed,completed,cancelled',
        ]);

        $validated['ends_at'] = Carbon::parse($validated['starts_at'])->addMinutes(30);

        Appointment::create($validated);

        return redirect()->route('admin.appointments.index')->with('success', 'Appointment scheduled successfully.');
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'status' => 'required|in:scheduled,confirmed,completed,cancelled',
        ]);

        $appointment->update($validated);

        return back()->with('success', "Appointment status updated to " . ucfirst($validated['status']) . ".");
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('admin.appointments.index')->with('success', 'Appointment record removed.');
    }
}
