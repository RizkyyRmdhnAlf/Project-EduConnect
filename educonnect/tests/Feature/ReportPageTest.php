<?php

namespace Tests\Feature;

use App\Models\Report;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
}
