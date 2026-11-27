<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Throwable;

class AuthController extends Controller
{
    /**
     * Display the login page.
     */
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        if (! ($user instanceof User)) {
            abort(401);
        }

        try {
            AuditLog::query()->create([
                'actor_id' => $user->id,
                'action' => 'user_login',
                'target_type' => 'user',
                'target_id' => $user->id,
            ]);
        } catch (Throwable) {
            // Continue even if audit log table is unavailable.
        }

        return redirect()->intended(route($this->dashboardRouteName($user)))
            ->with('status', 'Selamat datang kembali di EduConnect!');
    }

    /**
     * Display the registration page with role selection.
     */
    public function showRegisterForm(Request $request): View
    {
        $requestedRole = strtolower(trim((string) $request->query('role', UserRole::Pelajar->value)));

        if ($requestedRole === 'siswa') {
            $requestedRole = UserRole::Pelajar->value;
        }

        if (! in_array($requestedRole, UserRole::registrableValues(), true)) {
            $requestedRole = UserRole::Pelajar->value;
        }

        return view('auth.register', [
            'roles' => UserRole::registrableRoles(),
            'selectedRole' => $requestedRole,
        ]);
    }

    /**
     * Handle an incoming registration request.
     */
    public function register(RegisterRequest $request): RedirectResponse
    {
        $validated = $request->safe()->only([
            'display_name',
            'email',
            'password',
            'role',
            'location',
            'institution',
            'bio',
        ]);

        $user = User::query()->create([
            'display_name' => $validated['display_name'],
            'email' => $validated['email'],
            'password_hash' => $validated['password'],
            'role' => $validated['role'],
            'account_status' => $validated['role'] === UserRole::Pengelola->value
                ? User::ACCOUNT_STATUS_PENDING_VERIFICATION
                : User::ACCOUNT_STATUS_ACTIVE,
            'location' => $validated['location'],
            'institution' => $validated['institution'],
            'bio' => $validated['bio'] ?? null,
        ]);

        try {
            AuditLog::query()->create([
                'actor_id' => $user->id,
                'action' => 'user_registered',
                'target_type' => 'user',
                'target_id' => $user->id,
            ]);
        } catch (Throwable) {
            // Continue even if audit log table is unavailable.
        }

        if ($user->isPendingVerification()) {
            return to_route('login')
                ->with('status', 'Pendaftaran berhasil. Akun Pengelola Anda berstatus Menunggu Verifikasi dan dapat digunakan setelah disetujui administrator.');
        }

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route($this->dashboardRouteName($user))
            ->with('status', 'Pendaftaran berhasil! Selamat bergabung di ekosistem EduConnect.');
    }

    /**
     * Destroy an authenticated session.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    /**
     * Display the 403 Access Denied page.
     */
    public function accessDenied(): Response
    {
        return response()->view('auth.access-denied', [
            'reason' => 'Anda tidak memiliki hak akses ke halaman yang dituju.',
            'requiredRoles' => [],
        ], 403);
    }

    private function dashboardRouteName(User $user): string
    {
        $role = $user->role instanceof UserRole
            ? $user->role
            : UserRole::from((string) $user->role);

        return match ($role) {
            UserRole::Pelajar => 'dashboard.pelajar',
            UserRole::Relawan => 'dashboard.relawan',
            UserRole::Pengelola => 'dashboard.pengelola',
            UserRole::Admin => 'dashboard.admin',
        };
    }
}
