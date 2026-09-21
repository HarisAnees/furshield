<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request and enforce role-based access control.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        // 1. Unauthenticated checks
        if (!$user) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
            return redirect()->guest(route('login'))->with('error', 'Please sign in with authorized credentials to access this portal.');
        }

        // 2. Role authorization checks
        if (!in_array($user->role, $roles, true)) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json(['message' => 'Forbidden. Required role: ' . implode(',', $roles)], 403);
            }

            // Redirect user to their own role-specific portal with an informative message
            $targetRoute = match ($user->role) {
                'admin' => 'admin.dashboard',
                'vet' => 'vet.dashboard',
                'shelter' => 'shelter.dashboard',
                default => 'owner.dashboard',
            };

            $roleLabels = [
                'admin' => 'Platform Administrator',
                'vet' => 'Licensed Veterinarian',
                'shelter' => 'Animal Shelter Staff',
                'owner' => 'Pet Owner',
            ];

            $userRoleLabel = $roleLabels[$user->role] ?? ucfirst($user->role);
            $requiredLabel = implode(' or ', array_map(fn($r) => $roleLabels[$r] ?? ucfirst($r), $roles));

            return redirect()->route($targetRoute)->with('error', "Access restricted: You are signed in as a {$userRoleLabel}. That portal is reserved for {$requiredLabel} accounts.");
        }

        return $next($request);
    }
}
