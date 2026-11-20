<?php

namespace App\Enums;

enum UserRole: string
{
    case Pelajar = 'pelajar';
    case Relawan = 'relawan';
    case Pengelola = 'pengelola';
    case Admin = 'admin';

    /**
     * Human-readable label in Indonesian.
     */
    public function label(): string
    {
        return match ($this) {
            self::Pelajar => 'Pelajar / Siswa',
            self::Relawan => 'Relawan / Komunitas',
            self::Pengelola => 'Pengelola Tempat Belajar',
            self::Admin => 'Administrator',
        };
    }

    /**
     * Short description of the role's purpose in EduConnect.
     */
    public function description(): string
    {
        return match ($this) {
            self::Pelajar => 'Temukan tempat belajar terverifikasi dan ajukan laporan kebutuhan pendidikan.',
            self::Relawan => 'Tawarkan bantuan mengajar, pendampingan, atau sumber daya pendidikan.',
            self::Pengelola => 'Daftarkan dan kelola lokasi ruang belajar atau perpustakaan komunitas.',
            self::Admin => 'Verifikasi lokasi belajar, moderasi laporan kebutuhan, dan pantau audit log.',
        };
    }

    /**
     * Roles allowed for public self-registration (excludes Admin).
     *
     * @return list<self>
     */
    public static function registrableRoles(): array
    {
        return [
            self::Pelajar,
            self::Relawan,
            self::Pengelola,
        ];
    }

    /**
     * String values of roles allowed for public self-registration.
     *
     * @return list<string>
     */
    public static function registrableValues(): array
    {
        return array_map(
            static fn (self $role): string => $role->value,
            self::registrableRoles()
        );
    }
}
