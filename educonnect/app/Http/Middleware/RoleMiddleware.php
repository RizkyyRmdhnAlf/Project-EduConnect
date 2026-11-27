<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request and verify user role and account status.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if ($user === null) {
            return redirect()->guest(route('login'));
        }

        if (! $user->isActive()) {
            $reason = $user->isPendingVerification()
                ? 'Akun Pengelola Anda berstatus Menunggu Verifikasi. Fitur khusus Pengelola tersedia setelah disetujui administrator.'
                : 'Akun Anda saat ini tidak aktif atau sedang dalam peninjauan administrator.';

            return response()->view('auth.access-denied', [
                'reason' => $reason,
                'requiredRoles' => $roles,
            ], 403);
        }

        if ($roles !== [] && ! $user->hasRole(...$roles)) {
            return response()->view('auth.access-denied', [
                'reason' => 'Peran akun Anda tidak memiliki izin untuk mengakses halaman atau fitur ini.',
                'requiredRoles' => $roles,
            ], 403);
        }

        return $next($request);
    }
}
