<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\CareContent;
use App\Models\HealthRecord;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Pet;
use App\Models\Product;
use App\Models\Reminder;
use App\Models\User;
use App\Models\Vet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OwnerPortalController extends Controller
{
    private function getCurrentOwner()
    {
        if (Auth::check()) {
            return Auth::user();
        }

        $sarah = User::where('email', 'sarah@example.com')->first();
        if ($sarah) {
            Auth::login($sarah);
            return $sarah;
        }

        return User::where('role', 'owner')->first();
    }

    // 1. My Pets Page
    public function pets()
    {
        $owner = $this->getCurrentOwner();
        $pets = Pet::where('user_id', $owner?->id)->latest()->get();

        return view('owner.pets.index', compact('owner', 'pets'));
    }

    public function storePet(Request $request)
    {
        $owner = $this->getCurrentOwner();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:100',
            'breed' => 'nullable|string|max:150',
            'sex' => 'required|in:male,female,unknown',
            'date_of_birth' => 'nullable|date',
            'weight_kg' => 'nullable|numeric|min:0',
            'microchip_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);

        $validated['user_id'] = $owner->id;
        Pet::create($validated);

        return redirect()->route('owner.pets')->with('success', "Pet profile '{$validated['name']}' added successfully!");
    }

    public function deletePet(Pet $pet)
    {
        $owner = $this->getCurrentOwner();
        abort_unless($pet->user_id === $owner->id, 403);

        $pet->delete();

        return redirect()->route('owner.pets')->with('success', 'Pet removed from your profile.');
    }

    // 2. Appointments Page
    public function appointments()
    {
        $owner = $this->getCurrentOwner();
        $appointments = Appointment::with(['pet', 'vet.user'])
            ->where('user_id', $owner?->id)
            ->latest('starts_at')
            ->get();

        $pets = Pet::where('user_id', $owner?->id)->get();
        $vets = Vet::with('user')->where('is_available', true)->get();

        return view('owner.appointments.index', compact('owner', 'appointments', 'pets', 'vets'));
    }

    public function bookAppointment(Request $request)
    {
        $owner = $this->getCurrentOwner();

        $validated = $request->validate([
            'pet_id' => 'required|exists:pets,id',
            'vet_id' => 'required|exists:vets,id',
            'starts_at' => 'required|date|after:now',
            'reason' => 'required|string|max:255',
        ]);

        $validated['user_id'] = $owner->id;
        $validated['ends_at'] = Carbon::parse($validated['starts_at'])->addMinutes(30);
        $validated['status'] = 'confirmed'; // auto-confirm for immediate feedback

        Appointment::create($validated);

        return redirect()->route('owner.appointments')->with('success', 'Appointment booked and confirmed! It is now visible in your appointments and the clinic schedule.');
    }

    public function cancelAppointment(Appointment $appointment)
    {
        $owner = $this->getCurrentOwner();
        abort_unless($appointment->user_id === $owner->id, 403);

        $appointment->update(['status' => 'cancelled']);

        return back()->with('success', 'Appointment has been cancelled.');
    }

    // 3. Health Records Page
    public function healthRecords(Request $request)
    {
        $owner = $this->getCurrentOwner();
        $pets = Pet::where('user_id', $owner?->id)->get();

        $query = HealthRecord::whereIn('pet_id', $pets->pluck('id'))->latest('recorded_at');

        if ($request->filled('pet_id')) {
            $query->where('pet_id', $request->input('pet_id'));
        }

        $records = $query->get();

        return view('owner.health_records.index', compact('owner', 'pets', 'records'));
    }

    // 4. Products / Marketplace Page
    public function products()
    {
        $owner = $this->getCurrentOwner();
        $products = Product::where('is_active', true)->latest()->get();
        $myOrders = Order::with('items')->where('user_id', $owner?->id)->latest()->get();

        return view('owner.products.index', compact('owner', 'products', 'myOrders'));
    }

    public function buyProduct(Request $request, Product $product)
    {
        $owner = $this->getCurrentOwner();

        $quantity = max(1, (int)$request->input('quantity', 1));
        $lineTotal = round($product->price * $quantity, 2);

        $order = Order::create([
            'user_id' => $owner->id,
            'status' => 'completed',
            'subtotal' => $lineTotal,
            'notes' => 'Direct Order for ' . $product->name,
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'unit_price' => $product->price,
            'quantity' => $quantity,
            'line_total' => $lineTotal,
        ]);

        return redirect()->route('owner.products')->with('success', "Order #ORD-{$order->id} placed successfully for {$product->name}!");
    }

    // 5. Care & Tips Page
    public function careTips()
    {
        $owner = $this->getCurrentOwner();
        $articles = CareContent::where('is_published', true)->latest()->get();

        return view('owner.care_tips.index', compact('owner', 'articles'));
    }

    // 6. Notifications Page
    public function notifications()
    {
        $owner = $this->getCurrentOwner();

        return view('owner.notifications.index', compact('owner'));
    }

    // 7. Profile Page
    public function profile()
    {
        $owner = $this->getCurrentOwner();

        return view('owner.profile.index', compact('owner'));
    }

    public function updateProfile(Request $request)
    {
        $owner = $this->getCurrentOwner();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$owner->id}",
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
        ]);

        $owner->update($validated);

        return back()->with('success', 'Profile information updated successfully.');
    }
}
