<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kebutuhan Pendidikan - EduConnect</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#F8FAFC]">

    <x-navbar active="laporan" />

    <main class="mx-auto max-w-7xl px-6 py-10">

        {{-- Header --}}
        <section class="mb-8">
            <span class="text-sm font-semibold tracking-wider text-[#14B8A6]">
                EDUCONNECT
            </span>

            <div class="mt-2 flex flex-col justify-between gap-4 md:flex-row md:items-end">
                <div>
                    <h1 class="text-3xl font-bold text-[#123B5D] md:text-4xl">
                        Laporan Kebutuhan Pendidikan
                    </h1>

                    <p class="mt-3 max-w-2xl text-sm leading-6 text-[#64748B]">
                        Temukan berbagai kebutuhan pendidikan yang dilaporkan
                        masyarakat dan lihat perkembangan penanganannya.
                    </p>
                </div>
            </div>
        </section>

        {{-- Statistik --}}
        <section class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5">

            <div class="rounded-2xl border border-[#E2E8F0] bg-white p-5">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-[#64748B]">Total Laporan</p>
                    <span class="rounded-xl bg-blue-50 p-3 text-[#123B5D]">
                        <i class="fa-solid fa-file-lines"></i>
                    </span>
                </div>
                <h2 class="mt-4 text-3xl font-bold text-[#123B5D]">
                    {{ $statistics['total'] }}
                </h2>
            </div>

            <div class="rounded-2xl border border-[#E2E8F0] bg-white p-5">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-[#64748B]">Menunggu</p>
                    <span class="rounded-xl bg-slate-100 p-3 text-slate-600">
                        <i class="fa-solid fa-clock"></i>
                    </span>
                </div>
                <h2 class="mt-4 text-3xl font-bold text-slate-700">
                    {{ $statistics['waiting'] }}
                </h2>
            </div>

            <div class="rounded-2xl border border-[#E2E8F0] bg-white p-5">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-[#64748B]">Dalam Proses</p>
                    <span class="rounded-xl bg-amber-50 p-3 text-amber-600">
                        <i class="fa-solid fa-spinner"></i>
                    </span>
                </div>
                <h2 class="mt-4 text-3xl font-bold text-amber-600">
                    {{ $statistics['processing'] }}
                </h2>
            </div>

            <div class="rounded-2xl border border-[#E2E8F0] bg-white p-5">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-[#64748B]">Selesai</p>
                    <span class="rounded-xl bg-emerald-50 p-3 text-emerald-600">
                        <i class="fa-solid fa-circle-check"></i>
                    </span>
                </div>
                <h2 class="mt-4 text-3xl font-bold text-emerald-600">
                    {{ $statistics['completed'] }}
                </h2>
            </div>

            <div class="rounded-2xl border border-[#E2E8F0] bg-white p-5">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-[#64748B]">Ditolak</p>
                    <span class="rounded-xl bg-red-50 p-3 text-red-600">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </span>
                </div>
                <h2 class="mt-4 text-3xl font-bold text-red-600">
                    {{ $statistics['rejected'] }}
                </h2>
            </div>

        </section>

        {{-- Pencarian dan Filter --}}
        <section class="mb-8 rounded-2xl border border-[#E2E8F0] bg-white p-5">

            <form action="{{ route('reports.index') }}" method="GET">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-4">

                    <div class="md:col-span-2">
                        <label for="search" class="mb-2 block text-sm font-medium text-[#334155]">
                            Cari Laporan
                        </label>

                        <div class="flex items-center rounded-xl border border-[#CBD5E1] px-4 focus-within:border-[#14B8A6]">
                            <i class="fa-solid fa-magnifying-glass text-[#94A3B8]"></i>

                            <input
                                type="text"
                                id="search"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Cari judul, deskripsi, atau lokasi..."
                                class="w-full border-0 bg-transparent px-3 py-3 text-sm outline-none focus:ring-0"
                            >
                        </div>
                    </div>

                    <div>
                        <label for="category" class="mb-2 block text-sm font-medium text-[#334155]">
                            Kategori
                        </label>

                        <select
                            name="category"
                            id="category"
                            class="w-full rounded-xl border border-[#CBD5E1] px-4 py-3 text-sm outline-none focus:border-[#14B8A6]"
                        >
                            <option value="">Semua Kategori</option>

                            @foreach ($categories as $category)
                                <option
                                    value="{{ $category }}"
                                    @selected(request('category') == $category)
                                >
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="status" class="mb-2 block text-sm font-medium text-[#334155]">
                            Status
                        </label>

                        <select
                            name="status"
                            id="status"
                            class="w-full rounded-xl border border-[#CBD5E1] px-4 py-3 text-sm outline-none focus:border-[#14B8A6]"
                        >
                            <option value="">Semua Status</option>

                            <option value="Menunggu" @selected(request('status') == 'Menunggu')>
                                Menunggu
                            </option>

                            <option value="Dalam Proses" @selected(request('status') == 'Dalam Proses')>
                                Dalam Proses
                            </option>

                            <option value="Selesai" @selected(request('status') == 'Selesai')>
                                Selesai
                            </option>

                            <option value="Ditolak" @selected(request('status') == 'Ditolak')>
                                Ditolak
                            </option>
                        </select>
                    </div>

                </div>

                <div class="mt-4 flex flex-wrap justify-end gap-3">
                    <a
                        href="{{ route('reports.index') }}"
                        class="rounded-xl border border-[#CBD5E1] px-5 py-2.5 text-sm font-medium text-[#64748B] transition hover:bg-slate-50"
                    >
                        Reset
                    </a>

                    <button
                        type="submit"
                        class="rounded-xl bg-[#123B5D] px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-[#0D2F4A]"
                    >
                        Cari Laporan
                    </button>
                </div>
            </form>

        </section>

        {{-- Daftar Laporan --}}
        <section>

            <div class="mb-5 flex flex-col justify-between gap-2 sm:flex-row sm:items-center">
                <div>
                    <h2 class="text-xl font-bold text-[#123B5D]">
                        Daftar Laporan
                    </h2>

                    <p class="mt-1 text-sm text-[#64748B]">
                        Menampilkan {{ $reports->count() }} dari {{ $reports->total() }} laporan.
                    </p>
                </div>
            </div>

            @forelse ($reports as $report)

                <article class="mb-4 rounded-2xl border border-[#E2E8F0] bg-white p-5 transition hover:border-[#99D5CF] hover:shadow-md">

                    <div class="flex flex-col justify-between gap-4 md:flex-row">

                        <div class="flex-1">

                            <div class="mb-3 flex flex-wrap items-center gap-2">

                                <span class="rounded-full bg-[#E0F2FE] px-3 py-1 text-xs font-semibold text-[#0369A1]">
                                    {{ $report->category }}
                                </span>

                                @php
                                    $statusClasses = [
                                        'Menunggu' => 'bg-slate-100 text-slate-600',
                                        'Dalam Proses' => 'bg-amber-100 text-amber-700',
                                        'Selesai' => 'bg-emerald-100 text-emerald-700',
                                        'Ditolak' => 'bg-red-100 text-red-700',
                                    ];
                                @endphp

                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $statusClasses[$report->status] ?? 'bg-slate-100 text-slate-600' }}">
                                    {{ $report->status }}
                                </span>

                            </div>

                            <h3 class="text-lg font-bold text-[#123B5D]">
                                {{ $report->title }}
                            </h3>

                            <p class="mt-2 line-clamp-2 text-sm leading-6 text-[#64748B]">
                                {{ $report->description }}
                            </p>

                            <div class="mt-4 flex flex-wrap items-center gap-4 text-xs text-[#64748B]">

                                <span class="flex items-center gap-2">
                                    <i class="fa-solid fa-location-dot text-[#14B8A6]"></i>
                                    {{ $report->location }}
                                </span>

                                <span class="flex items-center gap-2">
                                    <i class="fa-regular fa-calendar text-[#14B8A6]"></i>
                                    {{ $report->created_at->format('d M Y') }}
                                </span>

                            </div>

                        </div>

                        <div class="flex items-center md:justify-center">
                            <a
                                href="{{ route('reports.show', $report) }}"
                                class="inline-flex items-center gap-2 rounded-xl border border-[#14B8A6] px-5 py-2.5 text-sm font-semibold text-[#0F766E] transition hover:bg-[#14B8A6] hover:text-white"
                            >
                                Lihat Detail
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>

                    </div>

                </article>

            @empty

                <div class="rounded-2xl border border-dashed border-[#CBD5E1] bg-white px-6 py-16 text-center">

                    <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-[#F1F5F9]">
                        <i class="fa-solid fa-file-circle-question text-2xl text-[#94A3B8]"></i>
                    </div>

                    <h3 class="text-lg font-bold text-[#123B5D]">
                        Belum Ada Laporan
                    </h3>

                    <p class="mx-auto mt-2 max-w-md text-sm text-[#64748B]">
                        Belum ada laporan kebutuhan pendidikan yang tersedia
                        atau tidak ditemukan laporan sesuai pencarianmu.
                    </p>

                    @if (request()->hasAny(['search', 'category', 'status']))
                        <a
                            href="{{ route('reports.index') }}"
                            class="mt-5 inline-block rounded-xl bg-[#123B5D] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#0D2F4A]"
                        >
                            Reset Filter
                        </a>
                    @endif

                </div>

            @endforelse

            {{-- Pagination --}}
            @if ($reports->hasPages())
                <div class="mt-8">
                    {{ $reports->links() }}
                </div>
            @endif

        </section>

    </main>

    <x-footer />

</body>
</html>
