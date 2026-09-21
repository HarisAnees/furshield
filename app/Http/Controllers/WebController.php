<?php

namespace App\Http\Controllers;

use App\Models\AdoptionListing;
use App\Models\Appointment;
use App\Models\AuditLog;
use App\Models\CareContent;
use App\Models\HealthRecord;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Pet;
use App\Models\Product;
use App\Models\User;
use App\Models\Vet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WebController extends Controller
{
    private function getCurrentUser(): User
    {
        if (Auth::check()) {
            return Auth::user();
        }

        $sarah = User::where('email', 'sarah@example.com')->first();
        if ($sarah) {
            return $sarah;
        }

        return User::firstOrCreate(
            ['email' => 'sarah@example.com'],
            ['name' => 'Sarah Johnson', 'password' => bcrypt('password'), 'role' => 'owner', 'phone' => '+1 (555) 019-2834', 'address' => '742 Evergreen Terrace, Springfield']
        );
    }

    // 1. Homepage (Panel 1)
    public function home()
    {
        $adoptablePets = AdoptionListing::where('status', 'available')->take(3)->get();
        $products = Product::where('is_active', true)->take(4)->get();
        $careArticles = CareContent::where('is_published', true)->take(3)->get();

        return view('frontend.home', compact('adoptablePets', 'products', 'careArticles'));
    }

    // 2. About Us (Panel 2)
    public function about()
    {
        return view('frontend.about');
    }

    // 3. Pet Profiles (Panel 3)
    public function pets()
    {
        $user = $this->getCurrentUser();
        $pets = Pet::where('user_id', $user->id)->latest()->get();

        $reminders = [
            ['title' => 'Vaccination Reminder', 'pet' => 'Luna', 'due' => 'Due in 3 days', 'icon' => '💉', 'color' => '#10b981', 'bg' => '#ecfdf5'],
            ['title' => 'Grooming Appointment', 'pet' => 'Buddy', 'due' => 'in 5 days', 'icon' => '✂️', 'color' => '#0284c7', 'bg' => '#e0f2fe'],
            ['title' => 'Health Checkup', 'pet' => 'Max', 'due' => 'in 12 days', 'icon' => '🩺', 'color' => '#ea580c', 'bg' => '#fff7ed'],
        ];

        return view('frontend.pets.index', compact('user', 'pets', 'reminders'));
    }

    // Pet Detail (Panel 11 & 15)
    public function petDetail(Pet $pet)
    {
        $user = $this->getCurrentUser();
        $records = HealthRecord::where('pet_id', $pet->id)->latest('recorded_at')->get();
        $appointments = Appointment::with('vet.user')->where('pet_id', $pet->id)->latest('starts_at')->get();

        return view('frontend.pets.show', compact('user', 'pet', 'records', 'appointments'));
    }

    // Store New Pet
    public function storePet(Request $request)
    {
        $user = $this->getCurrentUser();

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

        $validated['user_id'] = $user->id;
        Pet::create($validated);

        return redirect()->route('pets.index')->with('success', "Pet profile '{$validated['name']}' registered successfully!");
    }

    // 4. Vet Appointments (Panel 4)
    public function appointments(Request $request)
    {
        $user = $this->getCurrentUser();
        $query = Vet::with('user')->where('is_available', true);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('specialization', 'like', "%{$search}%")
                  ->orWhere('clinic_name', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('condition')) {
            $condition = $request->input('condition');
            $query->where(function ($q) use ($condition) {
                $q->where('specialization', 'like', "%{$condition}%")
                  ->orWhere('bio', 'like', "%{$condition}%");
            });
        }

        if ($request->filled('location')) {
            $loc = $request->input('location');
            $query->where(function ($q) use ($loc) {
                $q->where('city', 'like', "%{$loc}%")
                  ->orWhere('address', 'like', "%{$loc}%");
            });
        }

        $vets = $query->get();
        $pets = Pet::where('user_id', $user->id)->get();

        return view('frontend.appointments', compact('user', 'vets', 'pets'));
    }

    // Book Appointment
    public function bookAppointment(Request $request)
    {
        $user = $this->getCurrentUser();

        $validated = $request->validate([
            'pet_id' => 'required|exists:pets,id',
            'vet_id' => 'required|exists:vets,id',
            'starts_at' => 'required|date',
            'reason' => 'required|string|max:255',
        ]);

        $validated['user_id'] = $user->id;
        $validated['ends_at'] = Carbon::parse($validated['starts_at'])->addMinutes(30);
        $validated['status'] = 'confirmed';

        $appointment = Appointment::create($validated);

        // Record in audit log
        AuditLog::create([
            'action' => 'Appointment Booked: ' . $validated['reason'],
            'user_id' => $user->id,
            'subject_type' => 'Appointment',
            'subject_id' => $appointment->id,
            'metadata' => ['pet_id' => $validated['pet_id'], 'vet_id' => $validated['vet_id']],
        ]);

        return redirect()->route('appointments.index')->with('success', 'Your appointment has been booked and confirmed with the veterinarian!');
    }

    // 5. Adoption (Panel 5)
    public function adoption(Request $request)
    {
        $query = AdoptionListing::with('shelter')->latest();

        if ($request->filled('species')) {
            $query->where('species', $request->input('species'));
        }

        $adoptablePets = $query->paginate(9);

        return view('frontend.adoption', compact('adoptablePets'));
    }

    // Apply for Adoption
    public function applyAdoption(Request $request, AdoptionListing $adoption)
    {
        $user = $this->getCurrentUser();

        $validated = $request->validate([
            'applicant_name' => 'required|string|max:255',
            'applicant_email' => 'required|email',
            'applicant_phone' => 'required|string|max:50',
            'notes' => 'nullable|string',
        ]);

        $adoption->update(['status' => 'pending']);

        AuditLog::create([
            'action' => "Adoption Application for {$adoption->pet_name}",
            'user_id' => $user->id,
            'subject_type' => 'AdoptionListing',
            'subject_id' => $adoption->id,
            'metadata' => $validated,
        ]);

        return redirect()->route('adoption.index')->with('success', "Thank you! Your adoption application for {$adoption->pet_name} has been submitted to the rescue shelter.");
    }

    // 6. Products Catalog (Panel 6)
    public function products(Request $request)
    {
        $query = Product::where('is_active', true);

        $selectedCategory = $request->input('category', 'All');
        if ($selectedCategory && $selectedCategory !== 'All') {
            $query->where('category', $selectedCategory);
        }

        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->input('sort') === 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($request->input('sort') === 'price_desc') {
            $query->orderBy('price', 'desc');
        } else {
            $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();

        $allCount = Product::where('is_active', true)->count();
        $categoryCounts = Product::where('is_active', true)
            ->select('category', DB::raw('count(*) as count'))
            ->groupBy('category')
            ->pluck('count', 'category')
            ->toArray();

        $availableCategories = Product::where('is_active', true)
            ->distinct()
            ->pluck('category')
            ->sort()
            ->values()
            ->toArray();

        return view('frontend.products', compact(
            'products',
            'selectedCategory',
            'categoryCounts',
            'allCount',
            'availableCategories'
        ));
    }

    // 7. Shopping Cart (Panel 8)
    public function cart()
    {
        $cart = session()->get('cart', []);
        $subtotal = 0;

        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $shipping = 0.00;
        $total = $subtotal + $shipping;

        return view('frontend.cart', compact('cart', 'subtotal', 'shipping', 'total'));
    }

    public function addToCart(Request $request, Product $product)
    {
        if (!auth()->check()) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'requires_auth' => true,
                    'message' => 'Please sign in to your FurShield account to add items to your cart.',
                    'login_url' => route('login', ['redirect' => url()->previous() ?: route('products.index')])
                ], 401);
            }
            return redirect()->route('login', ['redirect' => url()->previous() ?: route('products.index')])
                ->with('info', 'Please sign in to your FurShield account to add products to your cart.');
        }

        $quantity = max(1, (int)$request->input('quantity', 1));
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'category' => $product->category,
                'price' => (float)$product->price,
                'quantity' => $quantity,
                'image' => $this->getProductImage($product),
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', "{$product->name} added to your shopping cart!");
    }

    public function updateCart(Request $request)
    {
        $productId = $request->input('product_id');
        $action = $request->input('action');
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            if ($action === 'increase') {
                $cart[$productId]['quantity']++;
            } elseif ($action === 'decrease') {
                $cart[$productId]['quantity']--;
                if ($cart[$productId]['quantity'] <= 0) {
                    unset($cart[$productId]);
                }
            }
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index');
    }

    public function removeFromCart(Request $request, $productId)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }

    // 8. Checkout (Panel 13)
    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('products.index')->with('error', 'Your cart is empty. Please add items to proceed.');
        }

        $user = $this->getCurrentUser();
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        $total = $subtotal;

        return view('frontend.checkout', compact('cart', 'user', 'subtotal', 'total'));
    }

    public function processCheckout(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('products.index')->with('error', 'Your cart is empty.');
        }

        $user = $this->getCurrentUser();

        $validated = $request->validate([
            'recipient_name' => 'required|string|max:255',
            'delivery_address' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'payment_method' => 'required|string',
        ]);

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => $user->id,
                'status' => 'requested',
                'subtotal' => $subtotal,
                'notes' => "Delivery to: {$validated['delivery_address']}. Payment: {$validated['payment_method']}",
            ]);

            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'product_name' => $item['name'],
                    'unit_price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'line_total' => $item['price'] * $item['quantity'],
                ]);

                // Decrement product stock
                Product::where('id', $item['id'])->decrement('stock_quantity', $item['quantity']);
            }

            DB::commit();
            session()->forget('cart');

            return redirect()->route('home')->with('success', "Order #ORD-{$order->id} placed successfully! It has been received and is now in processing.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Could not complete order: ' . $e->getMessage());
        }
    }

    // 9. Care & Tips (Panel 7)
    public function careTips(Request $request)
    {
        $query = CareContent::where('is_published', true)->latest();

        if ($request->filled('category') && $request->input('category') !== 'all') {
            $query->where('category', $request->input('category'));
        }

        $articles = $query->paginate(9)->withQueryString();
        $categories = ['All', 'Health', 'Nutrition', 'Training', 'Grooming'];

        return view('frontend.care_tips', compact('articles', 'categories'));
    }

    // 10. Contact Us (Panel 14)
    public function contact()
    {
        return view('frontend.contact');
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:2000',
        ]);

        AuditLog::create([
            'action' => "Customer Inquiry from {$validated['name']}",
            'user_id' => Auth::id() ?? 1,
            'subject_type' => 'ContactInquiry',
            'metadata' => $validated,
        ]);

        return back()->with('success', 'Thank you for reaching out! Our veterinary care team has received your message and will respond shortly.');
    }

    public function newsletter(Request $request)
    {
        $validated = $request->validate(['email' => 'required|email']);

        AuditLog::create([
            'action' => "Newsletter Subscription: {$validated['email']}",
            'user_id' => Auth::id() ?? 1,
            'subject_type' => 'Newsletter',
            'metadata' => $validated,
        ]);

        return back()->with('success', 'Thank you for subscribing to FurShield pet health tips!');
    }

    private function getProductImage($product): string
    {
        $name = strtolower($product->name);
        if (str_contains($name, 'food') || str_contains($name, 'salmon')) return '/images/dog-food.jpg';
        if (str_contains($name, 'litter')) return '/images/cat-litter.jpg';
        if (str_contains($name, 'shampoo')) return '/images/pet-shampoo.jpg';
        if (str_contains($name, 'toy') || str_contains($name, 'rope')) return '/images/dog-toys.jpg';
        return '/images/dog-food.jpg';
    }
}
