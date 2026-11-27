<?php

namespace Tests\Feature;

use App\Models\Report;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ReportSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_report_form_displays_all_required_fields(): void
    {
        $this->get(route('reports.create'))
            ->assertOk()
            ->assertSee('Form Kebutuhan Pendidikan')
            ->assertSee('name="title"', false)
            ->assertSee('name="category"', false)
            ->assertSee('name="description"', false)
            ->assertSee('name="location"', false)
            ->assertSee('name="image"', false)
            ->assertSee('enctype="multipart/form-data"', false);
    }

    public function test_valid_submission_creates_waiting_report_and_shows_it_in_the_list(): void
    {
        $response = $this->followingRedirects()->post(route('reports.store'), [
            'title' => 'Buku untuk ruang belajar',
            'category' => 'Perlengkapan',
            'description' => 'Ruang belajar membutuhkan buku bacaan.',
            'location' => 'Bandung',
            'status' => 'Selesai',
        ]);

        $response
            ->assertOk()
            ->assertSee('Laporan kebutuhan pendidikan berhasil dikirim.')
            ->assertSee('Buku untuk ruang belajar');

        $this->assertDatabaseHas('reports', [
            'title' => 'Buku untuk ruang belajar',
            'category' => 'Perlengkapan',
            'description' => 'Ruang belajar membutuhkan buku bacaan.',
            'location' => 'Bandung',
            'status' => 'Menunggu',
            'image' => null,
        ]);
    }

    public function test_valid_image_upload_is_saved_and_attached_to_report(): void
    {
        Storage::fake('public');

        $this->post(route('reports.store'), [
            'title' => 'Alat tulis untuk siswa',
            'category' => 'Perlengkapan',
            'description' => 'Siswa memerlukan alat tulis untuk belajar.',
            'location' => 'Yogyakarta',
            'image' => UploadedFile::fake()->image('kebutuhan.png'),
        ])->assertRedirect(route('reports.index'))
            ->assertSessionHas('success', 'Laporan kebutuhan pendidikan berhasil dikirim.');

        $report = Report::query()->where('title', 'Alat tulis untuk siswa')->firstOrFail();

        $this->assertSame('Menunggu', $report->status);
        $this->assertNotNull($report->image);
        Storage::disk('public')->assertExists($report->image);
    }

    public function test_invalid_submission_returns_validation_errors_without_creating_report(): void
    {
        $this->from(route('reports.create'))
            ->post(route('reports.store'), [
                'image' => UploadedFile::fake()->create('dokumen.txt', 10, 'text/plain'),
            ])
            ->assertRedirect(route('reports.create'))
            ->assertSessionHasErrors(['title', 'category', 'description', 'location', 'image']);

        $this->assertDatabaseCount('reports', 0);
    }
}
