<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\AssistanceOffer;
use App\Models\AuditLog;
use App\Models\LearningLocation;
use App\Models\LearningNeed;
use App\Models\User;
use App\Models\Verification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@educonnect.id'],
            [
                'display_name' => 'Admin EduConnect',
                'password_hash' => 'password',
                'role' => UserRole::Admin,
                'account_status' => 'active',
                'location' => 'Jakarta Pusat',
                'institution' => 'Tim Moderator EduConnect',
                'bio' => 'Administrator platform EduConnect untuk verifikasi ruang belajar dan moderasi kebutuhan.',
            ]
        );

        $owner = User::query()->updateOrCreate(
            ['email' => 'pengelola@educonnect.id'],
            [
                'display_name' => 'Komunitas Literasi Nusantara',
                'password_hash' => 'password',
                'role' => UserRole::Pengelola,
                'account_status' => 'active',
                'location' => 'Jakarta Selatan',
                'institution' => 'Rumah Baca Pelita Nusantara',
                'bio' => 'Pengelola jaringan rumah baca dan ruang belajar komunitas.',
            ]
        );

        $volunteer = User::query()->updateOrCreate(
            ['email' => 'relawan@educonnect.id'],
            [
                'display_name' => 'Raka Pratama',
                'password_hash' => 'password',
                'role' => UserRole::Relawan,
                'account_status' => 'active',
                'location' => 'Bandung',
                'institution' => 'Relawan Pengajar Muda ITB',
                'bio' => 'Relawan pengajar matematika, sains dasar, dan literasi digital untuk pelajar.',
            ]
        );

        $student = User::query()->updateOrCreate(
            ['email' => 'pelajar@educonnect.id'],
            [
                'display_name' => 'Nadia Putri',
                'password_hash' => 'password',
                'role' => UserRole::Pelajar,
                'account_status' => 'active',
                'location' => 'Jakarta Selatan',
                'institution' => 'SMAN 70 Jakarta',
                'bio' => 'Siswa kelas 11 yang mencari ruang diskusi kelompok dan bimbingan persiapan ujian.',
            ]
        );

        $locations = [
            [
                'name' => 'Rumah Baca Pelita Nusantara',
                'slug' => 'rumah-baca-pelita-nusantara',
                'category' => 'Rumah Belajar',
                'location' => 'Kebayoran Baru, Jakarta Selatan',
                'city' => 'Jakarta Selatan',
                'public_address' => 'Jl. Kerinci Raya No. 18, Kebayoran Baru',
                'description' => 'Ruang belajar komunitas yang hangat dengan koleksi buku lengkap, pendampingan belajar sore, dan pojok literasi untuk pelajar.',
                'facilities' => ['Wi-Fi', 'Area Baca', 'Ruang Diskusi', 'Mushola'],
                'cost_info' => 'Gratis',
                'is_free' => true,
                'schedule' => 'Senin – Sabtu, 09.00 – 18.00 WIB',
                'weekend_availability' => true,
                'latitude' => -6.2415860,
                'longitude' => 106.7931100,
                'publication_status' => 'Terverifikasi',
                'image' => 'https://images.unsplash.com/photo-1521587760476-6c12a4b040da?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'name' => 'Perpustakaan Komunitas Cendekia',
                'slug' => 'perpustakaan-komunitas-cendekia',
                'category' => 'Perpustakaan',
                'location' => 'Coblong, Bandung',
                'city' => 'Bandung',
                'public_address' => 'Jl. Ir. H. Juanda No. 142, Coblong',
                'description' => 'Perpustakaan terbuka dengan suasana tenang, akses komputer untuk tugas sekolah, dan kelas bimbingan rutin akhir pekan.',
                'facilities' => ['Wi-Fi', 'AC', 'Komputer', 'Area Baca'],
                'cost_info' => 'Gratis',
                'is_free' => true,
                'schedule' => 'Setiap Hari, 08.00 – 20.00 WIB',
                'weekend_availability' => true,
                'latitude' => -6.8898360,
                'longitude' => 107.6131440,
                'publication_status' => 'Terverifikasi',
                'image' => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'name' => 'Sanggar Belajar Lentera Muda',
                'slug' => 'sanggar-belajar-lentera-muda',
                'category' => 'Pusat Komunitas',
                'location' => 'Mlati, Sleman, Yogyakarta',
                'city' => 'Yogyakarta',
                'public_address' => 'Jl. Kaliurang Km 6.5, Sleman',
                'description' => 'Pusat kolaborasi siswa dan relawan mahasiswa untuk diskusi kelompok, bengkel sains terapan, dan persiapan ujian.',
                'facilities' => ['Ruang Diskusi', 'Wi-Fi', 'Parkir', 'Mushola'],
                'cost_info' => 'Gratis',
                'is_free' => true,
                'schedule' => 'Selasa – Minggu, 10.00 – 19.00 WIB',
                'weekend_availability' => true,
                'latitude' => -7.7520200,
                'longitude' => 110.3821900,
                'publication_status' => 'Terverifikasi',
                'image' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'name' => 'Ruang Tumbuh Bersama Surabaya',
                'slug' => 'ruang-tumbuh-bersama-surabaya',
                'category' => 'Ruang Belajar',
                'location' => 'Gubeng, Surabaya',
                'city' => 'Surabaya',
                'public_address' => 'Jl. Dharmawangsa No. 45, Gubeng',
                'description' => 'Ruang belajar bersama berfasilitas lengkap untuk siswa SMA dan mahasiswa yang membutuhkan tempat belajar kondusif.',
                'facilities' => ['AC', 'Wi-Fi', 'Ruang Diskusi'],
                'cost_info' => 'Rp10.000 / kunjungan',
                'is_free' => false,
                'schedule' => 'Senin – Minggu, 09.00 – 21.00 WIB',
                'weekend_availability' => true,
                'latitude' => -7.2756120,
                'longitude' => 112.7583900,
                'publication_status' => 'Terverifikasi',
                'image' => null,
            ],
            [
                'name' => 'Balai Literasi Harapan Bangsa',
                'slug' => 'balai-literasi-harapan-bangsa',
                'category' => 'Rumah Belajar',
                'location' => 'Klojen, Malang',
                'city' => 'Malang',
                'public_address' => 'Jl. Semeru No. 21, Klojen',
                'description' => 'Tempat belajar ramah anak dan remaja dengan pendampingan relawan pengajar bahasa Inggris, matematika, dan literasi digital.',
                'facilities' => ['Area Baca', 'Komputer', 'Mushola'],
                'cost_info' => 'Gratis',
                'is_free' => true,
                'schedule' => 'Senin – Sabtu, 13.00 – 18.00 WIB',
                'weekend_availability' => true,
                'latitude' => -7.9771300,
                'longitude' => 112.6280200,
                'publication_status' => 'Terverifikasi',
                'image' => null,
            ],
            [
                'name' => 'Pojok Belajar Kota Lama',
                'slug' => 'pojok-belajar-kota-lama',
                'category' => 'Perpustakaan',
                'location' => 'Semarang Tengah, Semarang',
                'city' => 'Semarang',
                'public_address' => 'Jl. Pemuda No. 88, Semarang Tengah',
                'description' => 'Ruang baca publik yang nyaman dengan akses internet cepat dan meja diskusi kelompok bagi pelajar di pusat kota.',
                'facilities' => ['Wi-Fi', 'AC', 'Area Baca'],
                'cost_info' => 'Gratis',
                'is_free' => true,
                'schedule' => 'Senin – Jumat, 08.00 – 17.00 WIB',
                'weekend_availability' => false,
                'latitude' => -6.9766670,
                'longitude' => 110.4166640,
                'publication_status' => 'Terverifikasi',
                'image' => null,
            ],
        ];

        $firstLocation = null;

        foreach ($locations as $locationData) {
            $loc = LearningLocation::query()->updateOrCreate(
                ['slug' => $locationData['slug']],
                array_merge($locationData, ['owner_id' => $owner->id])
            );

            $firstLocation ??= $loc;
        }

        $need = LearningNeed::query()->firstOrCreate(
            [
                'reporter_id' => $student->id,
                'title' => 'Pendampingan Belajar Matematika & Buku Latihan UTBK',
            ],
            [
                'category' => 'Pendampingan & Modul',
                'description' => 'Membutuhkan pendamping belajar rutin akhir pekan untuk kelompok 8 siswa kelas 11-12 serta modul latihan soal.',
                'area_label' => 'Kebayoran Baru, Jakarta Selatan',
                'need_status' => 'Dipublikasikan',
            ]
        );

        AssistanceOffer::query()->firstOrCreate(
            [
                'need_id' => $need->id,
                'volunteer_id' => $volunteer->id,
            ],
            [
                'offer_description' => 'Siap mendampingi sesi belajar matematika setiap hari Sabtu pukul 10.00 - 13.00 WIB beserta modul cetak.',
                'offer_status' => 'Dalam proses',
            ]
        );

        if ($firstLocation !== null) {
            Verification::query()->firstOrCreate(
                [
                    'target_type' => 'learning_location',
                    'target_id' => $firstLocation->id,
                    'admin_id' => $admin->id,
                ],
                [
                    'decision' => 'Terverifikasi',
                    'reason' => 'Lokasi ruang baca, jadwal operasional, dan pengelola telah diverifikasi lengkap.',
                    'verified_at' => now(),
                ]
            );

            AuditLog::query()->firstOrCreate(
                [
                    'actor_id' => $admin->id,
                    'action' => 'verify_location',
                    'target_type' => 'learning_location',
                    'target_id' => $firstLocation->id,
                ]
            );
        }
    }
}
