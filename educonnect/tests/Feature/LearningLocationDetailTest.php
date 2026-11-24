<?php

namespace Tests\Feature;

use App\Models\LearningLocation;
use App\Models\LearningPlace;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LearningLocationDetailTest extends TestCase
{
    use RefreshDatabase;

    public function test_learning_location_detail_page_displays_all_additional_details(): void
    {
        $owner = User::factory()->pengelola()->create([
            'display_name' => 'Komunitas Literasi Nusantara',
            'institution' => 'Rumah Baca Pelita Nusantara',
            'location' => 'Jakarta Selatan',
            'bio' => 'Pengelola ruang baca komunitas terbuka untuk pelajar.',
        ]);

        $location = LearningLocation::query()->create([
            'owner_id' => $owner->id,
            'name' => 'Rumah Baca Pelita Nusantara',
            'slug' => 'rumah-baca-pelita-nusantara',
            'category' => 'Rumah Belajar',
            'location' => 'Kebayoran Baru, Jakarta Selatan',
            'city' => 'Jakarta Selatan',
            'public_address' => 'Jl. Kerinci Raya No. 18, Kebayoran Baru',
            'description' => 'Ruang belajar komunitas yang hangat dengan koleksi buku lengkap.',
            'facilities' => ['Wi-Fi', 'Area Baca', 'Ruang Diskusi'],
            'capacity' => 45,
            'contact_info' => 'WhatsApp Pengelola: 0812-8800-1122',
            'age_group' => 'SD, SMP & SMA',
            'access_notes' => 'Pengunjung dapat langsung datang atau mendaftar sesi sore.',
            'cost_info' => 'Gratis',
            'is_free' => true,
            'schedule' => 'Senin – Sabtu, 09.00 – 18.00 WIB',
            'weekend_availability' => true,
            'latitude' => -6.2415860,
            'longitude' => 106.7931100,
            'publication_status' => 'Terverifikasi',
        ]);

        LearningLocation::query()->create([
            'owner_id' => $owner->id,
            'name' => 'Perpustakaan Komunitas Cendekia',
            'slug' => 'perpustakaan-komunitas-cendekia',
            'category' => 'Perpustakaan',
            'location' => 'Coblong, Bandung',
            'city' => 'Bandung',
            'public_address' => 'Jl. Ir. H. Juanda No. 142, Coblong',
            'description' => 'Perpustakaan terbuka dengan suasana tenang.',
            'facilities' => ['Wi-Fi', 'AC'],
            'cost_info' => 'Gratis',
            'is_free' => true,
            'publication_status' => 'Terverifikasi',
        ]);

        $response = $this->get(route('learning-places.show', $location->slug));

        $response
            ->assertOk()
            ->assertSee('Rumah Baca Pelita Nusantara')
            ->assertSee('Jl. Kerinci Raya No. 18, Kebayoran Baru')
            ->assertSee('45 Orang')
            ->assertSee('WhatsApp Pengelola: 0812-8800-1122')
            ->assertSee('SD, SMP &amp; SMA', false)
            ->assertSee('Pengunjung dapat langsung datang atau mendaftar sesi sore.')
            ->assertSee('Wi-Fi')
            ->assertSee('Area Baca')
            ->assertSee('Senin – Sabtu, 09.00 – 18.00 WIB')
            ->assertSee('Komunitas Literasi Nusantara')
            ->assertSee('Rekomendasi Tempat Belajar Lain')
            ->assertSee('Perpustakaan Komunitas Cendekia');
    }

    public function test_learning_place_record_can_also_be_viewed_on_detail_page(): void
    {
        LearningPlace::query()->create([
            'name' => 'Balai Belajar Mandiri',
            'category' => 'Rumah Belajar',
            'address' => 'Jl. Merdeka No. 10, Bandung',
            'description' => 'Tempat diskusi dan belajar bersama gratis.',
        ]);

        $this->get(route('learning-places.show', 'balai-belajar-mandiri'))
            ->assertOk()
            ->assertSee('Balai Belajar Mandiri')
            ->assertSee('Jl. Merdeka No. 10, Bandung');
    }

    public function test_unknown_slug_returns_custom_404_page(): void
    {
        $this->get('/tempat-belajar/lokasi-tidak-ada')
            ->assertNotFound()
            ->assertSee('Tempat belajar tidak ditemukan');
    }

    public function test_user_can_submit_content_report_on_learning_location(): void
    {
        $location = LearningLocation::query()->create([
            'name' => 'Sanggar Belajar Lentera Muda',
            'slug' => 'sanggar-belajar-lentera-muda',
            'category' => 'Pusat Komunitas',
            'location' => 'Sleman, Yogyakarta',
            'city' => 'Yogyakarta',
            'public_address' => 'Jl. Kaliurang Km 6.5, Sleman',
            'description' => 'Pusat kolaborasi siswa dan relawan mahasiswa.',
            'cost_info' => 'Gratis',
            'is_free' => true,
            'publication_status' => 'Terverifikasi',
        ]);

        $pelajar = User::factory()->pelajar()->create([
            'display_name' => 'Nadia Putri',
        ]);

        $response = $this->actingAs($pelajar)
            ->post(route('learning-places.report', $location->slug), [
                'title' => 'Perubahan jam tutup akhir pekan',
                'description' => 'Pada hari Minggu tempat ini tutup lebih awal pukul 16.00 WIB.',
            ]);

        $response
            ->assertRedirect(route('learning-places.show', $location->slug))
            ->assertSessionHas('report_success');

        $this->assertDatabaseHas('flags', [
            'learning_location_id' => $location->id,
            'place_slug' => $location->slug,
            'reporter_id' => $pelajar->id,
            'title' => 'Perubahan jam tutup akhir pekan',
            'moderation_status' => 'Menunggu',
        ]);
    }

    public function test_directory_supports_search_and_location_filter(): void
    {
        LearningLocation::query()->create([
            'name' => 'Rumah Baca Pelita Nusantara',
            'slug' => 'rumah-baca-pelita-nusantara',
            'category' => 'Rumah Belajar',
            'location' => 'Kebayoran Baru, Jakarta Selatan',
            'city' => 'Jakarta Selatan',
            'public_address' => 'Jl. Kerinci Raya No. 18',
            'description' => 'Ruang belajar komunitas dengan Wi-Fi gratis.',
            'cost_info' => 'Gratis',
            'is_free' => true,
            'publication_status' => 'Terverifikasi',
        ]);

        LearningLocation::query()->create([
            'name' => 'Perpustakaan Komunitas Cendekia',
            'slug' => 'perpustakaan-komunitas-cendekia',
            'category' => 'Perpustakaan',
            'location' => 'Coblong, Bandung',
            'city' => 'Bandung',
            'public_address' => 'Jl. Ir. H. Juanda No. 142',
            'description' => 'Perpustakaan terbuka di Bandung.',
            'cost_info' => 'Gratis',
            'is_free' => true,
            'publication_status' => 'Terverifikasi',
        ]);

        $this->get('/tempat-belajar?q=Pelita&lokasi=Jakarta+Selatan')
            ->assertOk()
            ->assertSee('Rumah Baca Pelita Nusantara')
            ->assertDontSee('Perpustakaan Komunitas Cendekia');
    }

    public function test_directory_filters_by_city_district_and_price_together(): void
    {
        LearningLocation::query()->create([
            'name' => 'Kelas Sains Kabupaten Bandung',
            'slug' => 'kelas-sains-kabupaten-bandung',
            'category' => 'Bimbingan Belajar',
            'location' => 'Kabupaten Bandung, Jawa Barat',
            'city' => 'Bandung',
            'public_address' => 'Jl. Pendidikan No. 12',
            'description' => 'Kelas sains untuk pelajar.',
            'cost_info' => 'Rp50.000 per sesi',
            'is_free' => false,
        ]);

        LearningLocation::query()->create([
            'name' => 'Rumah Baca Gratis Kabupaten Bandung',
            'slug' => 'rumah-baca-gratis-kabupaten-bandung',
            'category' => 'Rumah Belajar',
            'location' => 'Kabupaten Bandung, Jawa Barat',
            'city' => 'Bandung',
            'public_address' => 'Jl. Literasi No. 8',
            'description' => 'Ruang baca gratis untuk pelajar.',
            'cost_info' => 'Gratis',
            'is_free' => true,
        ]);

        LearningLocation::query()->create([
            'name' => 'Kelas Sains Kota Bogor',
            'slug' => 'kelas-sains-kota-bogor',
            'category' => 'Bimbingan Belajar',
            'location' => 'Kota Bogor, Jawa Barat',
            'city' => 'Bogor',
            'public_address' => 'Jl. Pendidikan No. 2',
            'description' => 'Kelas sains untuk pelajar.',
            'cost_info' => 'Rp50.000 per sesi',
            'is_free' => false,
        ]);

        $this->get(route('learning-places.index', [
            'kota' => 'Bandung',
            'kabupaten' => 'Kabupaten Bandung',
            'harga' => 'berbayar',
        ]))
            ->assertOk()
            ->assertSee('Kelas Sains Kabupaten Bandung')
            ->assertDontSee('Rumah Baca Gratis Kabupaten Bandung')
            ->assertDontSee('Kelas Sains Kota Bogor')
            ->assertSee('name="kota"', false)
            ->assertSee('name="kabupaten"', false)
            ->assertSee('name="harga"', false);

        $this->get(route('learning-places.index', [
            'kota' => 'Bandung',
            'kabupaten' => 'Kabupaten Bandung',
            'harga' => 'gratis',
        ]))
            ->assertOk()
            ->assertSee('Rumah Baca Gratis Kabupaten Bandung')
            ->assertDontSee('Kelas Sains Kabupaten Bandung')
            ->assertDontSee('Kelas Sains Kota Bogor');
    }
}
