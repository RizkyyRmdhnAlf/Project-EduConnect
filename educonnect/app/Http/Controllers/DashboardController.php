<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\AssistanceOffer;
use App\Models\AuditLog;
use App\Models\LearningLocation;
use App\Models\LearningNeed;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Throwable;

class DashboardController extends Controller
{
    /**
     * Display the role-aware dashboard overview.
     */
    public function index(Request $request): View
    {
        /** @var User $user */
        $user = $request->user();
        $role = $user->role instanceof UserRole ? $user->role : UserRole::from((string) $user->role);

        $stats = [
            'locations_count' => 0,
            'needs_count' => 0,
            'offers_count' => 0,
            'users_count' => 0,
            'audit_logs_count' => 0,
        ];

        try {
            $stats['locations_count'] = LearningLocation::query()->count();
            $stats['needs_count'] = LearningNeed::query()->count();
            $stats['offers_count'] = AssistanceOffer::query()->count();
            $stats['users_count'] = User::query()->count();
            $stats['audit_logs_count'] = AuditLog::query()->count();
        } catch (Throwable) {
            // Keep zero defaults if tables are not yet migrated.
        }

        return view('dashboard.index', [
            'user' => $user,
            'role' => $role,
            'stats' => $stats,
            'menuItems' => $this->getMenuForRole($role),
        ]);
    }

    /**
     * Get the sidebar navigation items according to the user's role.
     *
     * @return list<array{label: string, badge: ?string, active: bool}>
     */
    private function getMenuForRole(UserRole $role): array
    {
        return match ($role) {
            UserRole::Pelajar => [
                ['label' => 'Ringkasan', 'badge' => null, 'active' => true],
                ['label' => 'Tempat Belajar', 'badge' => 'Terverifikasi', 'active' => false],
                ['label' => 'Laporan Kebutuhan', 'badge' => null, 'active' => false],
                ['label' => 'Status Laporan', 'badge' => null, 'active' => false],
                ['label' => 'Profil', 'badge' => null, 'active' => false],
            ],
            UserRole::Relawan => [
                ['label' => 'Ringkasan', 'badge' => null, 'active' => true],
                ['label' => 'Kebutuhan Tersedia', 'badge' => 'Publik', 'active' => false],
                ['label' => 'Penawaran Saya', 'badge' => null, 'active' => false],
                ['label' => 'Aktivitas', 'badge' => null, 'active' => false],
                ['label' => 'Profil', 'badge' => null, 'active' => false],
            ],
            UserRole::Pengelola => [
                ['label' => 'Ringkasan', 'badge' => null, 'active' => true],
                ['label' => 'Tempat Belajar Saya', 'badge' => null, 'active' => false],
                ['label' => 'Tambah Tempat', 'badge' => null, 'active' => false],
                ['label' => 'Status Verifikasi', 'badge' => 'Terverifikasi', 'active' => false],
                ['label' => 'Laporan Masuk', 'badge' => null, 'active' => false],
                ['label' => 'Profil', 'badge' => null, 'active' => false],
            ],
            UserRole::Admin => [
                ['label' => 'Ringkasan', 'badge' => null, 'active' => true],
                ['label' => 'Verifikasi Tempat', 'badge' => 'Admin', 'active' => false],
                ['label' => 'Manajemen Pengguna', 'badge' => null, 'active' => false],
                ['label' => 'Moderasi Konten', 'badge' => null, 'active' => false],
                ['label' => 'Laporan Kebutuhan', 'badge' => null, 'active' => false],
                ['label' => 'Audit Log', 'badge' => null, 'active' => false],
            ],
        };
    }
}
