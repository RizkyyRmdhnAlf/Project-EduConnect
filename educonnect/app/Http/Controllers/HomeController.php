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
                'title' => 'Dinas Perpustakaan dan Arsip Provinsi Jambi',
                'slug' => 'perpustakaan-daerah-provinsi-jambi',
                'category' => 'Perpustakaan',
                'location' => 'Telanaipura, Kota Jambi',
                'city' => 'Kota Jambi',
                'address' => 'Jl. Raden Poerboyo Kolopaking, Telanaipura, Kota Jambi, Jambi',
                'description' => 'Perpustakaan umum tingkat provinsi dengan koleksi buku lengkap, ruang baca ber-AC yang tenang, layanan internet, dan ruang diskusi bagi pelajar maupun mahasiswa.',
                'facilities' => ['Wi-Fi', 'AC', 'Area Baca', 'Ruang Diskusi'],
                'cost' => 'Gratis',
                'is_free' => true,
                'schedule' => 'Senin – Jumat, 08.00 – 16.00 WIB',
                'weekend_open' => true,
                'verification_status' => 'Terverifikasi',
                'image' => 'https://images.unsplash.com/photo-1507842217343-583bb7270b66?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'title' => 'UPT Perpustakaan Universitas Jambi (UNJA) Mendalo',
                'slug' => 'perpustakaan-unja-mendalo-jambi',
                'category' => 'Perpustakaan',
                'location' => 'Mendalo Darat, Muaro Jambi',
                'city' => 'Muaro Jambi',
                'address' => 'Kampus UNJA Mendalo, Jl. Raya Jambi – Muara Bulian KM. 15, Mendalo Darat, Muaro Jambi',
                'description' => 'Pusat sumber belajar dan literasi akademik utama di kawasan Mendalo dengan area baca luas, akses komputer, dan ruang diskusi kelompok.',
                'facilities' => ['Wi-Fi', 'AC', 'Komputer', 'Area Baca'],
                'cost' => 'Gratis',
                'is_free' => true,
                'schedule' => 'Senin – Jumat, 08.00 – 16.30 WIB',
                'weekend_open' => false,
                'verification_status' => 'Terverifikasi',
                'image' => 'https://images.unsplash.com/photo-1521587760476-6c12a4b040da?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'title' => 'Taman Baco Atap Rumbe',
                'slug' => 'taman-baco-atap-rumbe-muaro-jambi',
                'category' => 'Rumah Belajar',
                'location' => 'Maro Sebo, Muaro Jambi',
                'city' => 'Muaro Jambi',
                'address' => 'Desa Jambi Tulo RT 03, Kec. Maro Sebo, Kab. Muaro Jambi, Jambi',
                'description' => 'Taman bacaan masyarakat dan ruang belajar komunitas yang berfokus pada literasi anak, pengembangan seni budaya lokal, serta edukasi cinta alam.',
                'facilities' => ['Area Baca', 'Ruang Diskusi', 'Parkir'],
                'cost' => 'Gratis',
                'is_free' => true,
                'schedule' => 'Setiap Hari, 14.00 – 17.30 WIB',
                'weekend_open' => true,
                'verification_status' => 'Terverifikasi',
                'image' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'title' => 'Dinas Kearsipan dan Perpustakaan Kota Jambi',
                'slug' => 'perpustakaan-umum-kota-jambi',
                'category' => 'Perpustakaan',
                'location' => 'Sungai Putri, Telanaipura, Kota Jambi',
                'city' => 'Kota Jambi',
                'address' => 'Jl. Prof. Dr. H. Sumantri Brojonegoro, Kel. Sungai Putri, Kec. Telanaipura, Kota Jambi',
                'description' => 'Perpustakaan umum Kota Jambi yang ramah pelajar dengan koleksi bacaan populer, buku pelajaran, serta layanan literasi masyarakat.',
                'facilities' => ['Wi-Fi', 'AC', 'Area Baca'],
                'cost' => 'Gratis',
                'is_free' => true,
                'schedule' => 'Senin – Jumat, 08.00 – 16.00 WIB',
                'weekend_open' => false,
                'verification_status' => 'Terverifikasi',
                'image' => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'title' => 'Taman Baca Cakrawala Literasi Jambi',
                'slug' => 'taman-baca-cakrawala-literasi-jambi',
                'category' => 'Rumah Belajar',
                'location' => 'Alam Barajo, Kota Jambi',
                'city' => 'Kota Jambi',
                'address' => 'Jl. Sersan Anwar Bay, Lrg. Ilham RT 01, Kel. Bagan Pete, Kec. Alam Barajo, Kota Jambi',
                'description' => 'Ruang baca masyarakat di wilayah Alam Barajo yang menyediakan buku bacaan anak, novel remaja, serta bimbingan belajar komunitas.',
                'facilities' => ['Area Baca', 'Ruang Diskusi', 'Mushola'],
                'cost' => 'Gratis',
                'is_free' => true,
                'schedule' => 'Selasa – Minggu, 14.00 – 17.30 WIB',
                'weekend_open' => true,
                'verification_status' => 'Terverifikasi',
                'image' => null,
            ],
            [
                'title' => 'Taman Baca Sepakat 41 Paal Merah',
                'slug' => 'taman-baca-sepakat-41-paal-merah',
                'category' => 'Pusat Komunitas',
                'location' => 'Paal Merah, Kota Jambi',
                'city' => 'Kota Jambi',
                'address' => 'Jl. A. Muis RT 41, Kel. Lingkar Selatan, Kec. Paal Merah, Kota Jambi',
                'description' => 'Pusat literasi warga dan ruang belajar ramah anak di Lingkar Selatan yang aktif menjadi wadah membaca, diskusi, dan kegiatan relawan pendidikan.',
                'facilities' => ['Area Baca', 'Ruang Diskusi', 'Parkir'],
                'cost' => 'Gratis',
                'is_free' => true,
                'schedule' => 'Senin – Sabtu, 14.00 – 17.30 WIB',
                'weekend_open' => true,
                'verification_status' => 'Terverifikasi',
                'image' => null,
            ],
        ]);
    }
}
