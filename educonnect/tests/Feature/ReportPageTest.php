<?php

namespace Tests\Feature;

use App\Models\Report;
use App\Models\User;
use Database\Seeders\NeedCategorySeeder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ReportPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_report_list_combines_search_and_filters_and_counts_rejected_reports(): void
    {
        Report::query()->create([
            'title' => 'Perbaikan ruang kelas',
            'category' => 'Sarana Belajar',
            'description' => 'Lantai ruang kelas perlu diperbaiki.',
            'location' => 'Bandung',
            'status' => 'Ditolak',
        ]);

        Report::query()->create([
            'title' => 'Perbaikan perpustakaan',
            'category' => 'Perpustakaan',
            'description' => 'Kondisi ruang baca perlu diperbaiki.',
            'location' => 'Jakarta',
            'status' => 'Menunggu',
        ]);

        $response = $this->get(route('reports.index', [
            'search' => 'kelas',
            'category' => 'Sarana Belajar',
            'status' => 'Ditolak',
        ]));

        $response
            ->assertOk()
            ->assertSee('Perbaikan ruang kelas')
            ->assertDontSee('Perbaikan perpustakaan')
            ->assertViewHas('statistics', fn (array $statistics): bool => $statistics['total'] === 2
                && $statistics['rejected'] === 1);
    }

    public function test_report_detail_displays_report_information(): void
    {
        $report = Report::query()->create([
            'title' => 'Bantuan buku untuk siswa',
            'category' => 'Perlengkapan',
            'description' => 'Siswa membutuhkan buku pelajaran tambahan.',
            'location' => 'Yogyakarta',
            'status' => 'Dalam Proses',
        ]);

        $this->get(route('reports.show', $report))
            ->assertOk()
            ->assertSee('Bantuan buku untuk siswa')
            ->assertSee('Perlengkapan')
            ->assertSee('Dalam Proses')
            ->assertSee('Yogyakarta')
            ->assertSee('Siswa membutuhkan buku pelajaran tambahan.')
            ->assertSee('Kembali ke daftar laporan');
    }

    public function test_report_pagination_displays_next_page_and_keeps_search_query(): void
    {
        foreach (range(1, 10) as $number) {
            Report::query()->create([
                'title' => 'Laporan '.$number,
                'category' => 'Fasilitas',
                'description' => 'Deskripsi laporan '.$number,
                'location' => 'Bandung',
                'status' => 'Menunggu',
                'created_at' => now()->addSeconds($number),
                'updated_at' => now()->addSeconds($number),
            ]);
        }

        $this->get(route('reports.index', [
            'search' => 'Laporan',
            'page' => 2,
        ]))
            ->assertOk()
            ->assertViewHas('reports', fn (LengthAwarePaginator $reports): bool => $reports->currentPage() === 2
                && $reports->count() === 1)
            ->assertSee('search=Laporan', false);
    }

    public function test_pelajar_can_open_the_report_creation_form(): void
    {
        $this->seed(NeedCategorySeeder::class);

        $this->actingAs(User::factory()->pelajar()->create())
            ->get(route('reports.create'))
            ->assertOk()
            ->assertSee('Ajukan Kebutuhan Pendidikan')
            ->assertSee('name="title"', false)
            ->assertSee('name="category"', false)
            ->assertSee('value="Buku"', false)
            ->assertSee('value="Alat Tulis"', false)
            ->assertSee('value="Fasilitas"', false)
            ->assertSee('value="Internet"', false)
            ->assertSee('value="Bimbingan Belajar"', false)
            ->assertSee('value="Lainnya"', false)
            ->assertSee('name="description"', false)
            ->assertSee('name="location"', false)
            ->assertSee('name="image"', false);
    }

    public function test_guest_is_redirected_to_login_when_opening_the_report_creation_form(): void
    {
        $this->get(route('reports.create'))
            ->assertRedirect(route('login'));
    }

    public function test_user_without_report_submission_role_cannot_open_the_creation_form(): void
    {
        $this->actingAs(User::factory()->relawan()->create())
            ->get(route('reports.create'))
            ->assertForbidden();
    }

    public function test_valid_report_submission_stores_an_image_as_waiting_and_displays_the_report(): void
    {
        $this->seed(NeedCategorySeeder::class);
        Storage::fake('public');
        $user = User::factory()->pelajar()->create();

        $response = $this->actingAs($user)->post(route('reports.store'), [
            'title' => 'Bantuan buku untuk siswa',
            'category' => 'Buku',
            'description' => 'Siswa membutuhkan buku pelajaran tambahan.',
            'location' => 'Yogyakarta',
            'image' => UploadedFile::fake()->image('buku.jpg'),
            'status' => 'Selesai',
        ]);

        $response
            ->assertRedirect(route('reports.index'))
            ->assertSessionHas('success', 'Laporan kebutuhan pendidikan berhasil dikirim.');

        $report = Report::query()->where('title', 'Bantuan buku untuk siswa')->firstOrFail();

        $this->assertSame('Menunggu', $report->status);
        $this->assertSame('Buku', $report->category);
        $this->assertSame('Yogyakarta', $report->location);
        Storage::disk('public')->assertExists($report->image);

        $this->get(route('reports.index'))
            ->assertOk()
            ->assertSee('Bantuan buku untuk siswa')
            ->assertSee('Buku')
            ->assertSee('Laporan kebutuhan pendidikan berhasil dikirim.');
    }

    public function test_report_can_be_submitted_without_an_image(): void
    {
        $this->seed(NeedCategorySeeder::class);

        $this->actingAs(User::factory()->pelajar()->create())
            ->post(route('reports.store'), [
                'title' => 'Pendampingan belajar matematika',
                'category' => 'Bimbingan Belajar',
                'description' => 'Membutuhkan relawan untuk pendampingan matematika.',
                'location' => 'Bandung',
            ])
            ->assertRedirect(route('reports.index'));

        $this->assertDatabaseHas('reports', [
            'title' => 'Pendampingan belajar matematika',
            'image' => null,
            'status' => 'Menunggu',
        ]);
    }

    public function test_invalid_report_submission_returns_field_errors_without_saving_a_report(): void
    {
        $this->actingAs(User::factory()->pelajar()->create())
            ->from(route('reports.create'))
            ->post(route('reports.store'), [
                'title' => '',
                'category' => '',
                'description' => '',
                'location' => '',
            ])
            ->assertRedirect(route('reports.create'))
            ->assertSessionHasErrors([
                'title' => 'Judul laporan wajib diisi.',
                'category' => 'Kategori kebutuhan wajib diisi.',
                'description' => 'Deskripsi kebutuhan wajib diisi.',
                'location' => 'Lokasi kebutuhan wajib diisi.',
            ]);

        $this->assertDatabaseCount('reports', 0);
    }

    public function test_non_image_upload_is_rejected_without_saving_a_report(): void
    {
        $this->seed(NeedCategorySeeder::class);
        Storage::fake('public');

        $this->actingAs(User::factory()->pelajar()->create())
            ->from(route('reports.create'))
            ->post(route('reports.store'), [
                'title' => 'Bantuan alat tulis',
                'category' => 'Buku',
                'description' => 'Membutuhkan alat tulis untuk kegiatan belajar.',
                'location' => 'Surabaya',
                'image' => UploadedFile::fake()->create('catatan.txt', 10, 'text/plain'),
            ])
            ->assertRedirect(route('reports.create'))
            ->assertSessionHasErrors([
                'image' => 'File yang diunggah harus berupa gambar.',
            ]);

        $this->assertDatabaseCount('reports', 0);
        Storage::disk('public')->assertDirectoryEmpty('reports');
    }

    public function test_report_submission_rejects_a_category_that_is_not_in_the_database(): void
    {
        $this->seed(NeedCategorySeeder::class);

        $this->actingAs(User::factory()->pelajar()->create())
            ->from(route('reports.create'))
            ->post(route('reports.store'), [
                'title' => 'Bantuan alat belajar',
                'category' => 'Kategori tidak terdaftar',
                'description' => 'Membutuhkan bantuan untuk kegiatan belajar.',
                'location' => 'Jakarta',
            ])
            ->assertRedirect(route('reports.create'))
            ->assertSessionHasErrors([
                'category' => 'Kategori yang dipilih tidak tersedia.',
            ]);

        $this->assertDatabaseCount('reports', 0);
    }
}
