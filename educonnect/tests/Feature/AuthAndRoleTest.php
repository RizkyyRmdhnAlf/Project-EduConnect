<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
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
            ->assertSee('Pengelola Tempat Belajar');
    }

    public function test_user_can_register_as_pelajar_relawan_or_pengelola_with_uuid(): void
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

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticated();

        $user = User::query()->where('email', 'bima@educonnect.id')->firstOrFail();

        $this->assertTrue(Str::isUuid($user->id));
        $this->assertSame('Bima Sakti', $user->display_name);
        $this->assertSame(UserRole::Relawan, $user->role);
        $this->assertSame('active', $user->account_status);
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
        ])->assertRedirect(route('dashboard'));

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
}
