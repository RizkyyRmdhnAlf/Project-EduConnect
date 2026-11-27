<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RuntimeException;

class ReportController extends Controller
{
    /**
     * Show the form for creating a report.
     */
    public function create(): View
    {
        return view('reports.create');
    }

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
     * Store a newly created report.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'category' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:10', 'max:1500'],
            'location' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ], [
            'title.required' => 'Judul laporan wajib diisi.',
            'title.max' => 'Judul laporan maksimal 150 karakter.',
            'category.required' => 'Kategori kebutuhan wajib diisi.',
            'category.max' => 'Kategori maksimal 255 karakter.',
            'description.required' => 'Deskripsi kebutuhan wajib diisi.',
            'description.min' => 'Deskripsi kebutuhan minimal 10 karakter.',
            'description.max' => 'Deskripsi kebutuhan maksimal 1500 karakter.',
            'location.required' => 'Lokasi kebutuhan wajib diisi.',
            'location.max' => 'Lokasi maksimal 255 karakter.',
            'image.image' => 'File yang diunggah harus berupa gambar.',
            'image.mimes' => 'Foto harus berformat JPG, JPEG, PNG, atau WEBP.',
            'image.max' => 'Ukuran foto maksimal 5 MB.',
        ]);

        $imagePath = null;

        if (isset($validated['image'])) {
            $imagePath = $validated['image']->store('reports', 'public');

            if ($imagePath === false) {
                throw new RuntimeException('Foto laporan gagal disimpan.');
            }
        }

        Report::query()->create([
            'title' => $validated['title'],
            'category' => $validated['category'],
            'description' => $validated['description'],
            'location' => $validated['location'],
            'image' => $imagePath,
            'status' => 'Menunggu',
        ]);

        return to_route('reports.index')
            ->with('success', 'Laporan kebutuhan pendidikan berhasil dikirim.');
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
