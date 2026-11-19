<?php

namespace App\Http\Controllers;

use App\Models\LearningLocation;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Throwable;

class HomeController extends Controller
{
    /**
     * Display the EduConnect home page.
     */
    public function index(Request $request): View
    {
        $places = $this->getPlacesDataset($request->boolean('empty'));

        $verifiedPlaces = $places->where('verification_status', 'Terverifikasi');

        $totalPlaces = $verifiedPlaces->count();
        $totalCities = $verifiedPlaces->pluck('city')->filter()->unique()->count();
        $verifiedPercentage = $places->isNotEmpty()
            ? (int) round(($verifiedPlaces->count() / $places->count()) * 100)
            : 100;
        $contributionWays = 3;

        $locations = $verifiedPlaces
            ->pluck('city')
            ->filter()
            ->unique()
            ->sort()
            ->values();

        $featuredPlaces = $verifiedPlaces->take(3)->values();
        $heroPlace = $featuredPlaces->first();

        return view('welcome', [
            'featuredPlaces' => $featuredPlaces,
            'heroPlace' => $heroPlace,
            'locations' => $locations,
            'stats' => [
                'total_places' => $totalPlaces,
                'total_cities' => $totalCities,
                'verified_percentage' => $verifiedPercentage,
                'contribution_ways' => $contributionWays,
            ],
            'isEmptyPreview' => $request->boolean('empty'),
        ]);
    }

    /**
     * Retrieve the learning locations dataset from database or fallback collection.
     *
     * @return Collection<int, array<string, mixed>>
     */
    private function getPlacesDataset(bool $forceEmpty = false): Collection
    {
        if ($forceEmpty) {
            return collect();
        }

        try {
            if (Schema::hasTable('learning_locations')) {
                $dbLocations = LearningLocation::query()->latest()->get();

                if ($dbLocations->isNotEmpty()) {
                    return $dbLocations->map(fn (LearningLocation $place): array => [
                        'title' => $place->name,
                        'slug' => $place->slug,
                        'category' => $place->category,
                        'location' => $place->location,
                        'city' => $place->city ?? $place->location,
                        'address' => $place->public_address,
                        'description' => $place->description,
                        'facilities' => $place->facilities ?? [],
                        'cost' => $place->cost_info,
                        'is_free' => $place->is_free,
                        'schedule' => $place->schedule,
                        'weekend_open' => $place->weekend_availability,
                        'verification_status' => $place->publication_status,
                        'image' => $place->image,
                    ]);
                }
            }
        } catch (Throwable) {
            // Fallback to default dataset when database connection/table is not ready.
        }

        return collect([
            [
                'title' => 'Rumah Baca Pelita Nusantara',
                'slug' => 'rumah-baca-pelita-nusantara',
                'category' => 'Rumah Belajar',
                'location' => 'Kebayoran Baru, Jakarta Selatan',
                'city' => 'Jakarta Selatan',
                'address' => 'Jl. Kerinci Raya No. 18, Kebayoran Baru',
                'description' => 'Ruang belajar komunitas yang hangat dengan koleksi buku lengkap, pendampingan belajar sore, dan pojok literasi untuk pelajar.',
                'facilities' => ['Wi-Fi', 'Area Baca', 'Ruang Diskusi', 'Mushola'],
                'cost' => 'Gratis',
                'is_free' => true,
                'schedule' => 'Senin – Sabtu, 09.00 – 18.00 WIB',
                'weekend_open' => true,
                'verification_status' => 'Terverifikasi',
                'image' => 'https://images.unsplash.com/photo-1521587760476-6c12a4b040da?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'title' => 'Perpustakaan Komunitas Cendekia',
                'slug' => 'perpustakaan-komunitas-cendekia',
                'category' => 'Perpustakaan',
                'location' => 'Coblong, Bandung',
                'city' => 'Bandung',
                'address' => 'Jl. Ir. H. Juanda No. 142, Coblong',
                'description' => 'Perpustakaan terbuka dengan suasana tenang, akses komputer untuk tugas sekolah, dan kelas bimbingan rutin akhir pekan.',
                'facilities' => ['Wi-Fi', 'AC', 'Komputer', 'Area Baca'],
                'cost' => 'Gratis',
                'is_free' => true,
                'schedule' => 'Setiap Hari, 08.00 – 20.00 WIB',
                'weekend_open' => true,
                'verification_status' => 'Terverifikasi',
                'image' => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'title' => 'Sanggar Belajar Lentera Muda',
                'slug' => 'sanggar-belajar-lentera-muda',
                'category' => 'Pusat Komunitas',
                'location' => 'Mlati, Sleman, Yogyakarta',
                'city' => 'Yogyakarta',
                'address' => 'Jl. Kaliurang Km 6.5, Sleman',
                'description' => 'Pusat kolaborasi siswa dan relawan mahasiswa untuk diskusi kelompok, bengkel sains terapan, dan persiapan ujian.',
                'facilities' => ['Ruang Diskusi', 'Wi-Fi', 'Parkir', 'Mushola'],
                'cost' => 'Gratis',
                'is_free' => true,
                'schedule' => 'Selasa – Minggu, 10.00 – 19.00 WIB',
                'weekend_open' => true,
                'verification_status' => 'Terverifikasi',
                'image' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'title' => 'Ruang Tumbuh Bersama Surabaya',
                'slug' => 'ruang-tumbuh-bersama-surabaya',
                'category' => 'Ruang Belajar',
                'location' => 'Gubeng, Surabaya',
                'city' => 'Surabaya',
                'address' => 'Jl. Dharmawangsa No. 45, Gubeng',
                'description' => 'Ruang belajar bersama berfasilitas lengkap untuk siswa SMA dan mahasiswa yang membutuhkan tempat belajar kondusif.',
                'facilities' => ['AC', 'Wi-Fi', 'Ruang Diskusi'],
                'cost' => 'Rp10.000 / kunjungan',
                'is_free' => false,
                'schedule' => 'Senin – Minggu, 09.00 – 21.00 WIB',
                'weekend_open' => true,
                'verification_status' => 'Terverifikasi',
                'image' => null,
            ],
            [
                'title' => 'Balai Literasi Harapan Bangsa',
                'slug' => 'balai-literasi-harapan-bangsa',
                'category' => 'Rumah Belajar',
                'location' => 'Klojen, Malang',
                'city' => 'Malang',
                'address' => 'Jl. Semeru No. 21, Klojen',
                'description' => 'Tempat belajar ramah anak dan remaja dengan pendampingan relawan pengajar bahasa Inggris, matematika, dan literasi digital.',
                'facilities' => ['Area Baca', 'Komputer', 'Mushola'],
                'cost' => 'Gratis',
                'is_free' => true,
                'schedule' => 'Senin – Sabtu, 13.00 – 18.00 WIB',
                'weekend_open' => true,
                'verification_status' => 'Terverifikasi',
                'image' => null,
            ],
            [
                'title' => 'Pojok Belajar Kota Lama',
                'slug' => 'pojok-belajar-kota-lama',
                'category' => 'Perpustakaan',
                'location' => 'Semarang Tengah, Semarang',
                'city' => 'Semarang',
                'address' => 'Jl. Pemuda No. 88, Semarang Tengah',
                'description' => 'Ruang baca publik yang nyaman dengan akses internet cepat dan meja diskusi kelompok bagi pelajar di pusat kota.',
                'facilities' => ['Wi-Fi', 'AC', 'Area Baca'],
                'cost' => 'Gratis',
                'is_free' => true,
                'schedule' => 'Senin – Jumat, 08.00 – 17.00 WIB',
                'weekend_open' => false,
                'verification_status' => 'Terverifikasi',
                'image' => null,
            ],
        ]);
    }
}
