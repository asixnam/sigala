<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    private function userHasRole($user, array $roles): bool
    {
        if (!$user) return false;
        if (in_array($user->role, $roles)) return true;
        if (in_array($user->role, ['superadmin', 'admin_dinas', 'admin_tte']) && (in_array('superadmin', $roles) || in_array('admin_dinas', $roles) || in_array('admin_tte', $roles))) {
            return true;
        }
        return false;
    }

    private function redirectToDashboard($user): Response
    {
        if ($user && in_array($user->role, ['superadmin', 'admin_dinas', 'admin_tte'])) {
            return redirect()->route('admin.dashboard');
        } elseif ($user && $user->role === 'admin_sekolah') {
            return redirect()->route('sekolah.dashboard');
        } elseif ($user && $user->role === 'gtk') {
            return redirect()->route('gtk.dashboard');
        }
        return redirect()->route('login');
    }

    /**
     * Handle an incoming request with context-aware guard resolution.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $guardMap = [
            'superadmin' => 'superadmin',
            'admin_dinas' => 'superadmin',
            'admin_tte' => 'superadmin',
            'admin_sekolah' => 'admin_sekolah',
            'gtk' => 'gtk',
        ];

        $path = $request->path();
        $routeName = $request->route() ? $request->route()->getName() : '';
        $referer = $request->header('referer', '');

        // 1. Determine preferred guard based on tab URL context or Referer
        $preferredGuard = null;
        if (str_starts_with($path, 'admin') || str_starts_with($routeName, 'admin.')) {
            $preferredGuard = 'superadmin';
        } elseif (str_starts_with($path, 'sekolah') || str_starts_with($routeName, 'sekolah.')) {
            $preferredGuard = 'admin_sekolah';
        } elseif (str_starts_with($path, 'gtk') || str_starts_with($routeName, 'gtk.')) {
            $preferredGuard = 'gtk';
        } else {
            // Shared routes (e.g. usulan.show, sk.preview, sk.download)
            if (str_contains($referer, '/admin') || str_contains($referer, 'admin.')) {
                $preferredGuard = 'superadmin';
            } elseif (str_contains($referer, '/sekolah') || str_contains($referer, 'sekolah.')) {
                $preferredGuard = 'admin_sekolah';
            } elseif (str_contains($referer, '/gtk') || str_contains($referer, 'gtk.')) {
                $preferredGuard = 'gtk';
            }
        }

        // 2. Try preferred guard first if valid & authenticated
        if ($preferredGuard && Auth::guard($preferredGuard)->check()) {
            $user = Auth::guard($preferredGuard)->user();
            if ($this->userHasRole($user, $roles)) {
                Auth::shouldUse($preferredGuard);
                return $next($request);
            }
        }

        // 3. Check matching guards in allowed roles order
        foreach ($roles as $role) {
            $guard = $guardMap[$role] ?? 'web';
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                if ($this->userHasRole($user, $roles)) {
                    Auth::shouldUse($guard);
                    return $next($request);
                }
            }
        }

        // 4. Fallback: if logged in under another guard, check preferred first or fallback
        if ($preferredGuard && Auth::guard($preferredGuard)->check()) {
            return $this->redirectToDashboard(Auth::guard($preferredGuard)->user());
        }

        foreach (['gtk', 'admin_sekolah', 'superadmin', 'web'] as $guard) {
            if (Auth::guard($guard)->check()) {
                return $this->redirectToDashboard(Auth::guard($guard)->user());
            }
        }

        return redirect()->route('login');
    }
}
