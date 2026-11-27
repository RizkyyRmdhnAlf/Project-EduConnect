<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReportController extends Controller
{
    /**
     * Display a listing of reports.
     */
    public function index(Request $request): View
    {
        // Query daftar laporan
        $query = Report::query();

        // Pencarian berdasarkan judul, deskripsi, dan lokasi
        $query->when($request->filled('search'), function ($q) use ($request) {
            $search = $request->search;

            $q->where(function ($subQuery) use ($search) {
                $subQuery->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        });

        // Filter berdasarkan kategori
        $query->when($request->filled('category'), function ($q) use ($request) {
            $q->where('category', $request->category);
        });

        // Filter berdasarkan status
        $query->when($request->filled('status'), function ($q) use ($request) {
            $q->where('status', $request->status);
        });

        // Pagination dan pengurutan laporan terbaru
        $reports = $query->latest()
            ->paginate(9)
            ->withQueryString();

        // Statistik seluruh laporan
        $statistics = [
            'total' => Report::count(),
            'waiting' => Report::where('status', 'Menunggu')->count(),
            'processing' => Report::where('status', 'Dalam Proses')->count(),
            'completed' => Report::where('status', 'Selesai')->count(),
            'rejected' => Report::where('status', 'Ditolak')->count(),
        ];

        // Mengambil daftar kategori yang tersedia
        $categories = Report::query()
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('reports.index', compact(
            'reports',
            'statistics',
            'categories'
        ));
    }

    /**
     * Display the specified report.
     */
    public function show(Report $report): View
    {
        $imageUrl = null;

        if ($report->image) {
            $imageUrl = Str::startsWith($report->image, ['http://', 'https://', '/'])
                ? $report->image
                : asset('storage/'.$report->image);
        }

        return view('reports.show', compact('report', 'imageUrl'));
    }
}
