<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $report->title }} - EduConnect</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#F8FAFC]">
    <x-navbar active="laporan" />

    <main class="mx-auto max-w-5xl px-6 py-10">
        <a
            href="{{ route('reports.index') }}"
            class="mb-6 inline-flex items-center gap-2 rounded-lg text-sm font-semibold text-[#0F766E] transition hover:text-[#123B5D] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#14B8A6]"
        >
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                <path d="m15 18-6-6 6-6M9 12h12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
            </svg>
            Kembali ke daftar laporan
        </a>

        <article class="overflow-hidden rounded-3xl border border-[#E2E8F0] bg-white shadow-sm">
            @if ($imageUrl)
                <img
                    src="{{ $imageUrl }}"
                    alt="Foto laporan: {{ $report->title }}"
                    class="max-h-[28rem] w-full object-cover"
                >
            @endif

            <div class="p-6 sm:p-10">
                @php
                    $statusClasses = [
                        'Menunggu' => 'bg-slate-100 text-slate-700',
                        'Dalam Proses' => 'bg-amber-100 text-amber-800',
                        'Selesai' => 'bg-emerald-100 text-emerald-800',
                        'Ditolak' => 'bg-red-100 text-red-800',
                    ];
                @endphp

                <div class="flex flex-wrap items-center gap-2">
                    <span class="rounded-full bg-[#E0F2FE] px-3 py-1 text-xs font-semibold text-[#0369A1]">
                        {{ $report->category }}
                    </span>
                    <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $statusClasses[$report->status] ?? 'bg-slate-100 text-slate-700' }}">
                        {{ $report->status }}
                    </span>
                </div>

                <h1 class="mt-5 text-3xl font-bold leading-tight text-[#123B5D] sm:text-4xl">
                    {{ $report->title }}
                </h1>

                <div class="mt-5 flex flex-wrap gap-x-6 gap-y-3 text-sm text-[#64748B]">
                    <p class="inline-flex items-center gap-2">
                        <svg class="h-4 w-4 text-[#14B8A6]" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path d="M20 10c0 5-8 12-8 12S4 15 4 10a8 8 0 1 1 16 0Z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            <circle cx="12" cy="10" r="2.5" stroke-width="2" />
                        </svg>
                        {{ $report->location }}
                    </p>
                    <p class="inline-flex items-center gap-2">
                        <svg class="h-4 w-4 text-[#14B8A6]" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <rect x="3" y="5" width="18" height="16" rx="2" stroke-width="2" />
                            <path d="M16 3v4M8 3v4M3 11h18" stroke-linecap="round" stroke-width="2" />
                        </svg>
                        Dilaporkan pada {{ $report->created_at->format('d M Y') }}
                    </p>
                </div>

                <div class="my-8 border-t border-[#E2E8F0]"></div>

                <section aria-labelledby="report-description">
                    <h2 id="report-description" class="text-lg font-bold text-[#123B5D]">
                        Deskripsi Laporan
                    </h2>
                    <p class="mt-3 whitespace-pre-line text-sm leading-7 text-[#475569]">
                        {{ $report->description }}
                    </p>
                </section>
            </div>
        </article>
    </main>

    <x-footer />
</body>
</html>
