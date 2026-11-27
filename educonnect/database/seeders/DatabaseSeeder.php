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
        $this->call(NeedCategorySeeder::class);

        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@educonnect.id'],
            [
                'display_name' => 'Admin EduConnect',
                'password_hash' => 'password',
                'role' => UserRole::Admin,
                'account_status' => 'active',
                'location' => 'Kota Jambi',
                'institution' => 'Tim Moderator EduConnect Jambi',
                'bio' => 'Administrator platform EduConnect untuk verifikasi ruang belajar dan moderasi kebutuhan di wilayah Jambi.',
            ]
        );

        $owner = User::query()->updateOrCreate(
            ['email' => 'pengelola@educonnect.id'],
            [
                'display_name' => 'Komunitas Literasi Jambi',
                'password_hash' => 'password',
                'role' => UserRole::Pengelola,
                'account_status' => 'active',
                'location' => 'Telanaipura, Kota Jambi',
                'institution' => 'Jaringan Ruang Belajar Jambi',
                'bio' => 'Pengelola jaringan taman baca dan ruang belajar komunitas di Kota Jambi dan Muaro Jambi.',
            ]
        );

        $volunteer = User::query()->updateOrCreate(
            ['email' => 'relawan@educonnect.id'],
            [
                'display_name' => 'Raka Pratama',
                'password_hash' => 'password',
                'role' => UserRole::Relawan,
                'account_status' => 'active',
                'location' => 'Mendalo, Muaro Jambi',
                'institution' => 'Relawan Pengajar Muda UNJA',
                'bio' => 'Relawan pengajar matematika, sains dasar, dan literasi digital untuk pelajar di Jambi.',
            ]
        );

        $student = User::query()->updateOrCreate(
            ['email' => 'pelajar@educonnect.id'],
            [
                'display_name' => 'Nadia Putri',
                'password_hash' => 'password',
                'role' => UserRole::Pelajar,
                'account_status' => 'active',
                'location' => 'Kota Jambi',
                'institution' => 'SMAN 1 Kota Jambi',
                'bio' => 'Siswa kelas 11 yang mencari ruang diskusi kelompok dan bimbingan persiapan ujian.',
            ]
        );

        $locations = [
            [
                'name' => 'Dinas Perpustakaan dan Arsip Provinsi Jambi',
                'slug' => 'perpustakaan-daerah-provinsi-jambi',
                'category' => 'Perpustakaan',
                'location' => 'Telanaipura, Kota Jambi',
                'city' => 'Kota Jambi',
                'public_address' => 'Jl. Raden Poerboyo Kolopaking, Telanaipura, Kota Jambi, Jambi',
                'description' => 'Perpustakaan umum tingkat provinsi dengan koleksi buku lengkap, ruang baca ber-AC yang tenang, layanan internet, dan ruang diskusi bagi pelajar maupun mahasiswa.',
                'facilities' => ['Wi-Fi', 'AC', 'Area Baca', 'Ruang Diskusi', 'Parkir', 'Mushola'],
                'capacity' => 120,
                'contact_info' => 'Layanan Informasi Perpustakaan Prov. Jambi',
                'age_group' => 'Semua Usia',
                'access_notes' => 'Gratis untuk seluruh masyarakat dan pelajar. Pengunjung cukup mengisi buku tamu atau mendaftar kartu anggota perpustakaan untuk peminjaman buku.',
                'cost_info' => 'Gratis',
                'is_free' => true,
                'schedule' => 'Senin – Jumat, 08.00 – 16.00 WIB (Sabtu layanan terbatas)',
                'weekend_availability' => true,
                'latitude' => -1.6131556,
                'longitude' => 103.5748473,
                'publication_status' => 'Terverifikasi',
                'image' => 'https://images.unsplash.com/photo-1507842217343-583bb7270b66?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'name' => 'UPT Perpustakaan Universitas Jambi (UNJA) Mendalo',
                'slug' => 'perpustakaan-unja-mendalo-jambi',
                'category' => 'Perpustakaan',
                'location' => 'Mendalo Darat, Muaro Jambi',
                'city' => 'Muaro Jambi',
                'public_address' => 'Kampus UNJA Mendalo, Jl. Raya Jambi – Muara Bulian KM. 15, Mendalo Darat, Kec. Jambi Luar Kota, Muaro Jambi',
                'description' => 'Pusat sumber belajar dan literasi akademik utama di kawasan Mendalo dengan area baca luas, akses komputer, dan ruang diskusi kelompok.',
                'facilities' => ['Wi-Fi', 'AC', 'Komputer', 'Area Baca', 'Ruang Diskusi', 'Mushola'],
                'capacity' => 200,
                'contact_info' => 'perpustakaan.unja.ac.id',
                'age_group' => 'Pelajar SMA & Mahasiswa',
                'access_notes' => 'Pengunjung umum/pelajar dapat melapor ke meja resepsionis dengan membawa kartu identitas atau kartu pelajar untuk akses baca di tempat.',
                'cost_info' => 'Gratis',
                'is_free' => true,
                'schedule' => 'Senin – Jumat, 08.00 – 16.30 WIB',
                'weekend_availability' => false,
                'latitude' => -1.6130640,
                'longitude' => 103.5206580,
                'publication_status' => 'Terverifikasi',
                'image' => 'https://images.unsplash.com/photo-1521587760476-6c12a4b040da?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'name' => 'Dinas Kearsipan dan Perpustakaan Kota Jambi',
                'slug' => 'perpustakaan-umum-kota-jambi',
                'category' => 'Perpustakaan',
                'location' => 'Sungai Putri, Telanaipura, Kota Jambi',
                'city' => 'Kota Jambi',
                'public_address' => 'Jl. Prof. Dr. H. Sumantri Brojonegoro, Kel. Sungai Putri, Kec. Telanaipura, Kota Jambi 36124',
                'description' => 'Perpustakaan umum Kota Jambi yang ramah pelajar dengan koleksi bacaan populer, buku pelajaran, serta layanan literasi masyarakat.',
                'facilities' => ['Wi-Fi', 'AC', 'Area Baca', 'Parkir'],
                'capacity' => 80,
                'contact_info' => 'Dinas Kearsipan & Perpustakaan Kota Jambi',
                'age_group' => 'SD, SMP, SMA & Umum',
                'access_notes' => 'Terbuka gratis untuk pelajar di Kota Jambi. Tersedia pojok baca anak dan meja baca individu maupun kelompok.',
                'cost_info' => 'Gratis',
                'is_free' => true,
                'schedule' => 'Senin – Jumat, 08.00 – 16.00 WIB',
                'weekend_availability' => false,
                'latitude' => -1.6088000,
                'longitude' => 103.5882000,
                'publication_status' => 'Terverifikasi',
                'image' => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'name' => 'Taman Baco Atap Rumbe',
                'slug' => 'taman-baco-atap-rumbe-muaro-jambi',
                'category' => 'Rumah Belajar',
                'location' => 'Maro Sebo, Muaro Jambi',
                'city' => 'Muaro Jambi',
                'public_address' => 'Desa Jambi Tulo RT 03, Kec. Maro Sebo, Kab. Muaro Jambi, Jambi',
                'description' => 'Taman bacaan masyarakat dan ruang belajar komunitas yang berfokus pada literasi anak, pengembangan seni budaya lokal, serta edukasi cinta alam.',
                'facilities' => ['Area Baca', 'Ruang Diskusi', 'Parkir'],
                'capacity' => 35,
                'contact_info' => 'Pengelola Komunitas TBM Atap Rumbe',
                'age_group' => 'Anak-anak & Remaja',
                'access_notes' => 'Aktif mengadakan kegiatan membaca bersama, kelas kreatif, dan pendampingan belajar komunitas setiap sore dan akhir pekan.',
                'cost_info' => 'Gratis',
                'is_free' => true,
                'schedule' => 'Setiap Hari, 14.00 – 17.30 WIB',
                'weekend_availability' => true,
                'latitude' => -1.4820000,
                'longitude' => 103.6580000,
                'publication_status' => 'Terverifikasi',
                'image' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'name' => 'Taman Baca Cakrawala Literasi Jambi',
                'slug' => 'taman-baca-cakrawala-literasi-jambi',
                'category' => 'Rumah Belajar',
                'location' => 'Alam Barajo, Kota Jambi',
                'city' => 'Kota Jambi',
                'public_address' => 'Jl. Sersan Anwar Bay, Lrg. Ilham RT 01, Kel. Bagan Pete, Kec. Alam Barajo, Kota Jambi',
                'description' => 'Ruang baca masyarakat di wilayah Alam Barajo yang menyediakan buku bacaan anak, novel remaja, serta bimbingan belajar komunitas.',
                'facilities' => ['Area Baca', 'Ruang Diskusi', 'Mushola'],
                'capacity' => 25,
                'contact_info' => 'Pengelola TBM Cakrawala Literasi',
                'age_group' => 'SD & SMP',
                'access_notes' => 'Terbuka bagi anak-anak sekitar Bagan Pete dan Kota Jambi. Dapat berkolaborasi dengan relawan pengajar akhir pekan.',
                'cost_info' => 'Gratis',
                'is_free' => true,
                'schedule' => 'Selasa – Minggu, 14.00 – 17.30 WIB',
                'weekend_availability' => true,
                'latitude' => -1.6460000,
                'longitude' => 103.5680000,
                'publication_status' => 'Terverifikasi',
                'image' => null,
            ],
            [
                'name' => 'Taman Baca Sepakat 41 Paal Merah',
                'slug' => 'taman-baca-sepakat-41-paal-merah',
                'category' => 'Pusat Komunitas',
                'location' => 'Paal Merah, Kota Jambi',
                'city' => 'Kota Jambi',
                'public_address' => 'Jl. A. Muis RT 41, Kel. Lingkar Selatan, Kec. Paal Merah, Kota Jambi',
                'description' => 'Pusat literasi warga dan ruang belajar ramah anak di Lingkar Selatan yang aktif menjadi wadah membaca, diskusi, dan kegiatan relawan pendidikan.',
                'facilities' => ['Area Baca', 'Ruang Diskusi', 'Parkir'],
                'capacity' => 30,
                'contact_info' => 'Pengurus TBM Sepakat 41',
                'age_group' => 'SD, SMP & Umum',
                'access_notes' => 'Terbuka untuk kunjungan belajar maupun donasi buku bacaan anak dan pelajaran sekolah.',
                'cost_info' => 'Gratis',
                'is_free' => true,
                'schedule' => 'Senin – Sabtu, 14.00 – 17.30 WIB',
                'weekend_availability' => true,
                'latitude' => -1.6445000,
                'longitude' => 103.6350000,
                'publication_status' => 'Terverifikasi',
                'image' => null,
            ],
        ];

        $jambiSlugs = array_column($locations, 'slug');
        LearningLocation::query()->whereNotIn('slug', $jambiSlugs)->delete();

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
                'area_label' => 'Telanaipura, Kota Jambi',
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
