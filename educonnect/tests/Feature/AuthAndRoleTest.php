<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AuthAndRoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_and_registration_pages_can_be_rendered(): void
    {
        $this->get('/login')
            ->assertOk()
            ->assertSee('Masuk ke Akun EduConnect');

        $this->get('/registrasi')
            ->assertOk()
            ->assertSee('Buat Akun EduConnect Anda')
            ->assertSee('Pelajar / Siswa')
            ->assertSee('Relawan / Komunitas')
            ->assertSee('Pengelola Tempat Belajar')
            ->assertDontSee('value="admin"', false);
    }

    public function test_relawan_registration_creates_an_active_hashed_account_and_logs_them_in(): void
    {
        $response = $this->post('/registrasi', [
            'role' => 'relawan',
            'display_name' => 'Bima Sakti',
            'email' => 'bima@educonnect.id',
            'location' => 'Yogyakarta',
            'institution' => 'Komunitas Mengajar Jogja',
            'bio' => 'Siap mengajar fisika dan matematika.',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $user = User::query()->where('email', 'bima@educonnect.id')->firstOrFail();

        $response->assertRedirect(route('dashboard.relawan'));
        $this->assertAuthenticatedAs($user);
        $this->assertTrue(Str::isUuid($user->id));
        $this->assertSame('Bima Sakti', $user->display_name);
        $this->assertSame(UserRole::Relawan, $user->role);
        $this->assertSame(User::ACCOUNT_STATUS_ACTIVE, $user->account_status);
        $this->assertTrue(Hash::check('password123', $user->password_hash));
    }

    public function test_pelajar_registration_creates_an_active_hashed_account_and_logs_them_in(): void
    {
        $response = $this->post('/registrasi', [
            'role' => 'pelajar',
            'display_name' => 'Nadia Putri',
            'email' => 'nadia@educonnect.id',
            'location' => 'Kota Jambi',
            'institution' => 'SMAN 1 Kota Jambi',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $user = User::query()->where('email', 'nadia@educonnect.id')->firstOrFail();

        $response->assertRedirect(route('dashboard.pelajar'));
        $this->assertAuthenticatedAs($user);
        $this->assertSame(UserRole::Pelajar, $user->role);
        $this->assertSame(User::ACCOUNT_STATUS_ACTIVE, $user->account_status);
        $this->assertTrue(Hash::check('password123', $user->password_hash));
    }

    public function test_pengelola_registration_waits_for_verification_before_login(): void
    {
        $response = $this->post('/registrasi', [
            'role' => 'pengelola',
            'display_name' => 'Budi Santoso',
            'email' => 'budi@educonnect.id',
            'location' => 'Jakarta Selatan',
            'institution' => 'Rumah Baca Pelita',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response
            ->assertRedirect(route('login'))
            ->assertSessionHas('status', 'Pendaftaran berhasil. Akun Pengelola Anda berstatus Menunggu Verifikasi dan dapat digunakan setelah disetujui administrator.');
        $this->assertGuest();

        $user = User::query()->where('email', 'budi@educonnect.id')->firstOrFail();

        $this->assertSame(User::ACCOUNT_STATUS_PENDING_VERIFICATION, $user->account_status);
        $this->assertTrue(Hash::check('password123', $user->password_hash));

        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Menunggu Verifikasi');

        $this->post('/login', [
            'email' => 'budi@educonnect.id',
            'password' => 'password123',
        ])
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors([
                'email' => 'Akun Pengelola Anda berstatus Menunggu Verifikasi. Anda dapat masuk setelah administrator menyetujui pendaftaran.',
            ]);

        $this->assertGuest();
    }

    public function test_user_cannot_self_register_as_admin(): void
    {
        $response = $this->from('/registrasi')->post('/registrasi', [
            'role' => 'admin',
            'display_name' => 'Attacker Admin',
            'email' => 'attacker@educonnect.id',
            'location' => 'Jakarta',
            'institution' => 'Internal',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/registrasi');
        $response->assertSessionHasErrors('role');
        $this->assertGuest();
        $this->assertDatabaseMissing('users', ['email' => 'attacker@educonnect.id']);
    }

    public function test_user_can_login_and_logout(): void
    {
        $user = User::factory()->pelajar()->create([
            'email' => 'siswa@educonnect.id',
            'password_hash' => 'secret1234',
        ]);

        $this->post('/login', [
            'email' => 'siswa@educonnect.id',
            'password' => 'secret1234',
        ])->assertRedirect(route('dashboard.pelajar'));

        $this->assertAuthenticatedAs($user);

        $this->post('/logout')->assertRedirect(route('home'));
        $this->assertGuest();
    }

    public function test_role_middleware_enforces_role_permissions(): void
    {
        $pelajar = User::factory()->pelajar()->create();
        $admin = User::factory()->admin()->create();

        $this->actingAs($pelajar)
            ->get('/dashboard')
            ->assertOk();

        $this->actingAs($pelajar)
            ->get('/dashboard/admin')
            ->assertForbidden()
            ->assertSee('Halaman Ini Membutuhkan Izin Khusus');

        $this->actingAs($admin)
            ->get('/dashboard/admin')
            ->assertOk();
    }

    public function test_pending_pengelola_cannot_access_the_pengelola_dashboard(): void
    {
        $pengelola = User::factory()->pengelola()->create([
            'account_status' => User::ACCOUNT_STATUS_PENDING_VERIFICATION,
        ]);

        $this->actingAs($pengelola)
            ->get(route('dashboard.pengelola'))
            ->assertForbidden()
            ->assertSee('Menunggu Verifikasi');
    }

    #[DataProvider('activeRoleDashboardRoutes')]
    public function test_login_redirects_active_users_to_their_role_dashboard(string $role, string $dashboardRoute): void
    {
        $user = User::factory()->create([
            'role' => $role,
            'email' => $role.'@educonnect.id',
            'password_hash' => 'secret1234',
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'secret1234',
        ])->assertRedirect(route($dashboardRoute));

        $this->assertAuthenticatedAs($user);
    }

    /**
     * @return array<string, array{string, string}>
     */
    public static function activeRoleDashboardRoutes(): array
    {
        return [
            'pelajar' => ['pelajar', 'dashboard.pelajar'],
            'relawan' => ['relawan', 'dashboard.relawan'],
            'admin' => ['admin', 'dashboard.admin'],
        ];
    }
}
