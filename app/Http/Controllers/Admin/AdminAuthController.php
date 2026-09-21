<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shelter;
use App\Models\User;
use App\Models\Vet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    /**
     * Map a user role to its designated primary dashboard route.
     */
    protected function dashboardRouteFor(User $user): string
    {
        return match ($user->role) {
            'admin' => 'admin.dashboard',
            'vet' => 'vet.dashboard',
            'shelter' => 'shelter.dashboard',
            default => 'owner.dashboard',
        };
    }

    public function showLogin(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route($this->dashboardRouteFor(Auth::user()));
        }

        if ($request->has('redirect')) {
            session()->put('url.intended', $request->input('redirect'));
        }

        return view('auth.auth_switch', ['mode' => 'signin']);
    }

    public function showRegister(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route($this->dashboardRouteFor(Auth::user()));
        }

        if ($request->has('redirect')) {
            session()->put('url.intended', $request->input('redirect'));
        }

        return view('auth.auth_switch', ['mode' => 'signup']);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'The provided credentials do not match our records.'])
                ->withInput($request->only('email'))
                ->with('mode', 'signin');
        }

        $request->session()->regenerate();
        $user = $request->user();

        if (!$user->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()
                ->withErrors(['email' => 'This account has been deactivated. Please contact support.'])
                ->withInput($request->only('email'))
                ->with('mode', 'signin');
        }

        $targetRoute = $this->dashboardRouteFor($user);
        return redirect()->intended(route($targetRoute))->with('success', 'Welcome back, ' . $user->name . '!');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:255'],
            'role' => ['nullable', 'string', 'in:owner,vet,shelter'],
        ]);

        $role = $validated['role'] ?? 'owner';

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'role' => $role,
            'is_active' => true,
        ]);

        // Auto-provision corresponding profile entity if clinician or shelter
        if ($role === 'vet') {
            Vet::firstOrCreate(['user_id' => $user->id], [
                'specialization' => 'General Practice',
                'experience_years' => 1,
                'clinic_name' => $user->name . ' Veterinary Clinic',
                'address' => $user->address ?? 'Clinic Address',
                'is_available' => true,
            ]);
        } elseif ($role === 'shelter') {
            Shelter::firstOrCreate(['user_id' => $user->id], [
                'organization_name' => $user->name,
                'description' => 'Dedicated animal shelter and rescue sanctuary.',
                'phone' => $user->phone ?? '+1 555-0100',
                'address' => $user->address ?? 'Rescue Blvd',
                'verified_at' => now(),
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();

        $targetRoute = $this->dashboardRouteFor($user);
        return redirect()->route($targetRoute)->with('success', 'Your account has been created! Welcome to FurShield, ' . $user->name . '.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'You have been successfully signed out.');
    }
}
