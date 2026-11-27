<?php

namespace App\Models;

use App\Enums\UserRole;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'display_name',
    'name',
    'email',
    'password_hash',
    'password',
    'role',
    'account_status',
    'location',
    'institution',
    'bio',
])]
#[Hidden(['password_hash', 'password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasUuids, Notifiable;

    /**
     * Default model attributes before persistence.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'role' => 'pelajar',
        'account_status' => 'active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password_hash' => 'hashed',
            'role' => UserRole::class,
        ];
    }

    /**
     * Get the name of the password attribute for authentication.
     */
    public function getAuthPasswordName(): string
    {
        return 'password_hash';
    }

    /**
     * Alias `name` attribute to `display_name` in the database.
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes): ?string => $attributes['display_name'] ?? null,
            set: fn (?string $value): array => ['display_name' => $value],
        );
    }

    /**
     * Alias `password` attribute to `password_hash` in the database.
     */
    protected function password(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes): ?string => $attributes['password_hash'] ?? null,
            set: fn (?string $value): array => ['password_hash' => $value],
        );
    }

    /**
     * Determine whether the user has any of the given roles.
     */
    public function hasRole(UserRole|string ...$roles): bool
    {
        $currentRole = $this->role instanceof UserRole ? $this->role->value : (string) $this->role;

        foreach ($roles as $role) {
            $expected = $role instanceof UserRole ? $role->value : strtolower(trim($role));

            if ($currentRole === $expected) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user's account is active.
     */
    public function isActive(): bool
    {
        return $this->account_status === 'active';
    }

    /**
     * Locations owned/managed by this user (`owns` in ERD).
     */
    public function ownedLocations(): HasMany
    {
        return $this->hasMany(LearningLocation::class, 'owner_id');
    }

    /**
     * Learning needs reported by this user (`reports` in ERD).
     */
    public function reportedNeeds(): HasMany
    {
        return $this->hasMany(LearningNeed::class, 'reporter_id');
    }

    /**
     * Reports submitted through the education needs form.
     */
    public function submittedReports(): HasMany
    {
        return $this->hasMany(Report::class, 'reporter_id');
    }

    /**
     * Assistance offers submitted by this volunteer (`submits` in ERD).
     */
    public function submittedOffers(): HasMany
    {
        return $this->hasMany(AssistanceOffer::class, 'volunteer_id');
    }

    /**
     * Verifications performed by this admin (`performs` in ERD).
     */
    public function verifications(): HasMany
    {
        return $this->hasMany(Verification::class, 'admin_id');
    }

    /**
     * Audit logs recorded for actions by this actor (`acts` in ERD).
     */
    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class, 'actor_id');
    }
}
