<?php

namespace Database\Factories;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'display_name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password_hash' => static::$password ??= Hash::make('password'),
            'role' => UserRole::Pelajar,
            'account_status' => 'active',
            'location' => fake()->randomElement(['Jakarta Selatan', 'Bandung', 'Yogyakarta', 'Surabaya']),
            'institution' => 'SMAN 1 Nusantara',
            'bio' => fake()->sentence(),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes): array => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * State for a Pelajar / Siswa user.
     */
    public function pelajar(): static
    {
        return $this->state(fn (array $attributes): array => [
            'role' => UserRole::Pelajar,
        ]);
    }

    /**
     * State for a Relawan / Komunitas user.
     */
    public function relawan(): static
    {
        return $this->state(fn (array $attributes): array => [
            'role' => UserRole::Relawan,
        ]);
    }

    /**
     * State for a Pengelola Tempat Belajar user.
     */
    public function pengelola(): static
    {
        return $this->state(fn (array $attributes): array => [
            'role' => UserRole::Pengelola,
        ]);
    }

    /**
     * State for an Administrator user.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes): array => [
            'role' => UserRole::Admin,
        ]);
    }
}
