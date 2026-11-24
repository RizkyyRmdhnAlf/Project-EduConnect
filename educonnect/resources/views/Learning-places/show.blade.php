@php
    $isVerified = ($place['verification_status'] ?? 'Menunggu') === 'Terverifikasi';
    $isRejected = ($place['verification_status'] ?? '') === 'Ditolak';
    $isFree = $place['is_free'] ?? false;
    $hasCoordinates = !empty($place['latitude']) && !empty($place['longitude']);
    $facilities = $place['facilities'] ?? [];
    $owner = $place['owner'] ?? null;

    if ($hasCoordinates) {
        $lat = (float) $place['latitude'];
        $lng = (float) $place['longitude'];
        $bbox = sprintf('%f,%f,%f,%f', $lng - 0.012, $lat - 0.008, $lng + 0.012, $lat + 0.008);
        $osmEmbedUrl = "https://www.openstreetmap.org/export/embed.html?bbox={$bbox}&layer=mapnik&marker={$lat},{$lng}";
        $googleMapsUrl = "https://www.google.com/maps/search/?api=1&query={$lat},{$lng}";
    } else {
        $googleMapsUrl = 'https://www.google.com/maps/search/?api=1&query='.urlencode($place['title'].' '.$place['address']);
    }
@endphp
<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="{{ \Illuminate\Support\Str::limit($place['description'], 155) }}">

        <title>{{ $place['title'] }} — EduConnect</title>

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#F8FAFC] font-sans text-[#334155] antialiased selection:bg-[#14B8A6]/20 selection:text-[#123B5D]">
        {{-- Skip Link --}}
        <a
            href="#main-content"
            class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-[100] focus:rounded-xl focus:bg-[#123B5D] focus:px-4 focus:py-2.5 focus:text-sm focus:font-semibold focus:text-white focus:shadow-lg focus:outline-none focus:ring-2 focus:ring-[#14B8A6]"
        >
            Lewati ke konten utama
        </a>

        <x-navbar active="tempat-belajar" />

        <main id="main-content" class="pb-20">
            {{-- Breadcrumb & Top Bar --}}
            <div class="border-b border-[#E2E8F0] bg-white">
                <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
                    <nav aria-label="Breadcrumb" class="flex items-center gap-2 text-xs font-medium text-[#334155]/80 sm:text-sm">
                        <a href="{{ route('home') }}" class="transition-colors hover:text-[#14B8A6]">Beranda</a>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-[#334155]/50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                        <a href="{{ route('learning-places.index') }}" class="transition-colors hover:text-[#14B8A6]">Tempat Belajar</a>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-[#334155]/50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                        <span class="truncate font-semibold text-[#123B5D]" aria-current="page">{{ $place['title'] }}</span>
                    </nav>

                    <a
                        href="{{ route('learning-places.index') }}"
                        class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#123B5D] transition-colors hover:text-[#14B8A6] sm:text-sm"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="m12 19-7-7 7-7" />
                            <path d="M19 12H5" />
                        </svg>
                        <span>Kembali ke Direktori</span>
                    </a>
                </div>
            </div>

            <div class="mx-auto max-w-7xl px-4 pt-8 sm:px-6 lg:px-8 lg:pt-10">
                {{-- Flash Success Alert (Laporan Terkirim) --}}
                @if (session('report_success'))
                    <div
                        role="status"
                        class="mb-6 flex items-start gap-3 rounded-2xl border border-[#14B8A6]/30 bg-[#EAF6F4] px-5 py-4 text-sm font-medium text-[#123B5D]"
                    >
                        <span class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-[#14B8A6] text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M20 6 9 17l-5-5" />
                            </svg>
                        </span>
                        <div>
                            <p class="font-bold text-[#123B5D]">Laporan Diterima</p>
                            <p class="mt-0.5 text-xs text-[#334155] sm:text-sm">{{ session('report_success') }}</p>
                        </div>
                    </div>
                @endif

                {{-- Validation Error Summary --}}
                @if ($errors->any())
                    <div
                        role="alert"
                        class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-800"
                    >
                        <p class="font-bold text-red-900">Laporan belum dapat dikirim</p>
                        <ul class="mt-1.5 list-disc space-y-1 pl-5 text-xs text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Hero Detail Card: Foto Utama + Header Info --}}
                <section class="overflow-hidden rounded-3xl border border-[#E2E8F0] bg-white shadow-sm">
                    <div class="grid grid-cols-1 lg:grid-cols-12">
                        {{-- Foto Utama --}}
                        <div class="relative aspect-[16/10] bg-[#EAF6F4] lg:col-span-6 lg:aspect-auto lg:min-h-[380px]">
                            @if (!empty($place['image']))
                                <img
                                    src="{{ $place['image'] }}"
                                    alt="Foto utama {{ $place['title'] }} di {{ $place['location'] }}"
                                    class="h-full w-full object-cover"
                                />
                            @else
                                <div class="flex h-full w-full flex-col items-center justify-center bg-gradient-to-br from-[#123B5D] via-[#164E70] to-[#14B8A6]/80 p-8 text-center text-white">
                                    <div class="flex h-20 w-20 items-center justify-center rounded-3xl bg-white/15 backdrop-blur-xs">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#5EEAD4]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M12 7v14" />
                                            <path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z" />
                                        </svg>
                                    </div>
                                    <p class="mt-4 text-sm font-bold tracking-wide text-white">Ruang Belajar Komunitas EduConnect</p>
                                    <p class="mt-1 text-xs text-white/75">Foto ruang belajar akan diperbarui oleh pengelola</p>
                                </div>
                            @endif

                            {{-- Overlay Badge Kategori --}}
                            <div class="absolute top-5 left-5">
                                <span class="inline-flex items-center rounded-full bg-[#123B5D]/90 px-4 py-1.5 text-xs font-semibold text-white shadow-sm backdrop-blur-md">
                                    {{ $place['category'] }}
                                </span>
                            </div>
                        </div>

                        {{-- Ringkasan Informasi Utama --}}
                        <div class="flex flex-col justify-between p-6 sm:p-8 lg:col-span-6 lg:p-10">
                            <div>
                                {{-- Status Badge (Terverifikasi / Menunggu / Ditolak) --}}
                                <div class="flex flex-wrap items-center gap-2.5">
                                    @if ($isVerified)
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-[#EAF6F4] px-3.5 py-1 text-xs font-bold text-[#0D9488] ring-1 ring-[#14B8A6]/30">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-[#14B8A6]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z" />
                                                <path d="m9 12 2 2 4-4" />
                                            </svg>
                                            <span>Terverifikasi</span>
                                        </span>
                                    @elseif ($isRejected)
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-3.5 py-1 text-xs font-bold text-red-700 ring-1 ring-red-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <circle cx="12" cy="12" r="10" />
                                                <path d="m15 9-6 6" />
                                                <path d="m9 9 6 6" />
                                            </svg>
                                            <span>Ditolak</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-3.5 py-1 text-xs font-bold text-amber-700 ring-1 ring-amber-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <circle cx="12" cy="12" r="10" />
                                                <polyline points="12 6 12 12 16 14" />
                                            </svg>
                                            <span>{{ $place['verification_status'] ?? 'Menunggu Verifikasi' }}</span>
                                        </span>
                                    @endif

                                    @if ($place['weekend_open'] ?? false)
                                        <span class="inline-flex items-center gap-1.5 rounded-full border border-[#E2E8F0] bg-[#F8FAFC] px-3 py-1 text-xs font-semibold text-[#123B5D]">
                                            <span class="h-1.5 w-1.5 rounded-full bg-[#14B8A6]" aria-hidden="true"></span>
                                            <span>Buka Akhir Pekan</span>
                                        </span>
                                    @endif
                                </div>

                                {{-- Nama Tempat --}}
                                <h1 class="mt-4 text-2xl font-extrabold tracking-tight text-[#123B5D] sm:text-3xl lg:text-4xl lg:leading-tight">
                                    {{ $place['title'] }}
                                </h1>

                                {{-- Lokasi & Alamat Lengkap --}}
                                <div class="mt-4 flex items-start gap-2.5 text-sm text-[#334155]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-5 w-5 shrink-0 text-[#14B8A6]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0" />
                                        <circle cx="12" cy="10" r="3" />
                                    </svg>
                                    <div>
                                        <p class="font-semibold text-[#123B5D]">{{ $place['location'] }}</p>
                                        @if ($place['address'] !== $place['location'])
                                            <p class="mt-0.5 text-xs leading-relaxed text-[#334155]/85 sm:text-sm">{{ $place['address'] }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Highlight Info Tambahan (Biaya, Kapasitas, Kelompok Usia) --}}
                            <div class="mt-8 grid grid-cols-2 gap-3 border-t border-[#E2E8F0] pt-6 sm:grid-cols-3">
                                <div class="rounded-2xl bg-[#F8FAFC] p-3.5">
                                    <span class="block text-[11px] font-bold uppercase tracking-wider text-[#334155]/70">Biaya Akses</span>
                                    @if ($isFree)
                                        <span class="mt-1 inline-block text-sm font-extrabold text-[#0D9488]">Gratis</span>
                                    @else
                                        <span class="mt-1 inline-block text-sm font-extrabold text-[#123B5D]">{{ $place['cost'] }}</span>
                                    @endif
                                </div>

                                <div class="rounded-2xl bg-[#F8FAFC] p-3.5">
                                    <span class="block text-[11px] font-bold uppercase tracking-wider text-[#334155]/70">Kapasitas Ruang</span>
                                    <span class="mt-1 inline-block text-sm font-extrabold text-[#123B5D]">
                                        {{ !empty($place['capacity']) ? $place['capacity'].' Orang' : 'Terbuka' }}
                                    </span>
                                </div>

                                <div class="col-span-2 rounded-2xl bg-[#F8FAFC] p-3.5 sm:col-span-1">
                                    <span class="block text-[11px] font-bold uppercase tracking-wider text-[#334155]/70">Target Pelajar</span>
                                    <span class="mt-1 inline-block text-sm font-extrabold text-[#123B5D]">
                                        {{ $place['age_group'] ?? 'Semua Usia' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Detail Konten 2 Kolom --}}
                <div class="mt-10 grid grid-cols-1 gap-8 lg:grid-cols-12">
                    {{-- Kolom Kiri: Deskripsi, Fasilitas, Jadwal, Peta Lokasi --}}
                    <div class="space-y-8 lg:col-span-8">
                        {{-- 1. Deskripsi Lengkap & Panduan Kunjungan --}}
                        <section class="rounded-3xl border border-[#E2E8F0] bg-white p-6 shadow-xs sm:p-8">
                            <span class="text-xs font-bold uppercase tracking-[0.2em] text-[#14B8A6]">
                                Tentang Ruang Belajar
                            </span>
                            <h2 class="mt-2 text-xl font-bold text-[#123B5D] sm:text-2xl">
                                Deskripsi &amp; Suasana Belajar
                            </h2>
                            <p class="mt-4 text-sm leading-relaxed text-[#334155] sm:text-base sm:leading-relaxed">
                                {{ $place['description'] }}
                            </p>

                            @if (!empty($place['access_notes']))
                                <div class="mt-6 rounded-2xl border border-[#14B8A6]/20 bg-[#EAF6F4]/60 p-5">
                                    <div class="flex items-start gap-3">
                                        <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-white text-[#14B8A6] shadow-xs">
                                            {{-- Lucide Info Icon --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <circle cx="12" cy="12" r="10" />
                                                <path d="M12 16v-4" />
                                                <path d="M12 8h.01" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-bold text-[#123B5D]">Catatan &amp; Panduan Kunjungan</h3>
                                            <p class="mt-1 text-xs leading-relaxed text-[#334155] sm:text-sm">
                                                {{ $place['access_notes'] }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </section>

                        {{-- 2. Fasilitas --}}
                        <section class="rounded-3xl border border-[#E2E8F0] bg-white p-6 shadow-xs sm:p-8">
                            <span class="text-xs font-bold uppercase tracking-[0.2em] text-[#14B8A6]">
                                Dukungan Sarana
                            </span>
                            <h2 class="mt-2 text-xl font-bold text-[#123B5D] sm:text-2xl">
                                Fasilitas Tersedia
                            </h2>

                            @if (!empty($facilities))
                                <div class="mt-5 grid grid-cols-1 gap-3 sm:grid-cols-2 md:grid-cols-3">
                                    @foreach ($facilities as $facility)
                                        <div class="flex items-center gap-3 rounded-2xl border border-[#E2E8F0] bg-[#F8FAFC] px-4 py-3.5 transition-colors hover:border-[#14B8A6]/40 hover:bg-[#EAF6F4]/40">
                                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-[#EAF6F4] text-[#14B8A6]">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                    <path d="M20 6 9 17l-5-5" />
                                                </svg>
                                            </span>
                                            <span class="text-sm font-semibold text-[#123B5D]">{{ $facility }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="mt-4 rounded-2xl border border-dashed border-[#E2E8F0] bg-[#F8FAFC] p-5 text-sm text-[#334155]/80">
                                    Daftar fasilitas rinci sedang dilengkapi oleh pengelola tempat belajar ini.
                                </div>
                            @endif
                        </section>

                        {{-- 3. Jadwal Operasional --}}
                        <section class="rounded-3xl border border-[#E2E8F0] bg-white p-6 shadow-xs sm:p-8">
                            <span class="text-xs font-bold uppercase tracking-[0.2em] text-[#14B8A6]">
                                Waktu Layanan
                            </span>
                            <h2 class="mt-2 text-xl font-bold text-[#123B5D] sm:text-2xl">
                                Jadwal Operasional
                            </h2>

                            <div class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div class="flex items-start gap-3.5 rounded-2xl border border-[#E2E8F0] bg-[#F8FAFC] p-5">
                                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EAF6F4] text-[#14B8A6]">
                                        {{-- Lucide Clock Icon --}}
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <circle cx="12" cy="12" r="10" />
                                            <polyline points="12 6 12 12 16 14" />
                                        </svg>
                                    </span>
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-wider text-[#334155]/70">Jam Buka</p>
                                        <p class="mt-1 text-sm font-bold text-[#123B5D]">{{ $place['schedule'] }}</p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-3.5 rounded-2xl border border-[#E2E8F0] bg-[#F8FAFC] p-5">
                                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EAF6F4] text-[#14B8A6]">
                                        {{-- Lucide Calendar Icon --}}
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M8 2v4" />
                                            <path d="M16 2v4" />
                                            <rect width="18" height="18" x="3" y="4" rx="2" />
                                            <path d="M3 10h18" />
                                        </svg>
                                    </span>
                                    <div>
                                        <p class="text-xs font-bold uppercase tracking-wider text-[#334155]/70">Ketersediaan Akhir Pekan</p>
                                        <p class="mt-1 text-sm font-bold text-[#123B5D]">
                                            {{ ($place['weekend_open'] ?? false) ? 'Buka pada akhir pekan (Sabtu/Minggu)' : 'Buka hari kerja (Senin – Jumat)' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </section>

                        {{-- 4. Peta Lokasi --}}
                        <section class="rounded-3xl border border-[#E2E8F0] bg-white p-6 shadow-xs sm:p-8">
                            <div class="flex flex-wrap items-end justify-between gap-4">
                                <div>
                                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-[#14B8A6]">
                                        Navigasi &amp; Arah
                                    </span>
                                    <h2 class="mt-2 text-xl font-bold text-[#123B5D] sm:text-2xl">
                                        Peta Lokasi
                                    </h2>
                                </div>

                                <a
                                    href="{{ $googleMapsUrl }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex items-center gap-2 rounded-xl border border-[#E2E8F0] bg-[#F8FAFC] px-4 py-2.5 text-xs font-semibold text-[#123B5D] transition hover:border-[#14B8A6] hover:bg-[#EAF6F4] hover:text-[#0D9488]"
                                >
                                    <span>Buka di Google Maps</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M15 3h6v6" />
                                        <path d="M10 14 21 3" />
                                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6" />
                                    </svg>
                                </a>
                            </div>

                            <div class="mt-5 overflow-hidden rounded-2xl border border-[#E2E8F0] bg-[#EAF6F4]">
                                @if ($hasCoordinates)
                                    <iframe
                                        title="Peta lokasi {{ $place['title'] }}"
                                        src="{{ $osmEmbedUrl }}"
                                        class="h-72 w-full border-0"
                                        loading="lazy"
                                    ></iframe>
                                    <div class="flex flex-wrap items-center justify-between gap-2 border-t border-[#E2E8F0] bg-[#F8FAFC] px-4 py-3 text-xs text-[#334155]">
                                        <span class="font-medium">{{ $place['address'] }}</span>
                                        <span class="font-mono text-[11px] text-[#334155]/75">
                                            Koordinat: {{ number_format($place['latitude'], 5) }}, {{ number_format($place['longitude'], 5) }}
                                        </span>
                                    </div>
                                @else
                                    <div class="flex flex-col items-center justify-center px-6 py-14 text-center">
                                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-[#14B8A6] shadow-xs">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0" />
                                                <circle cx="12" cy="10" r="3" />
                                            </svg>
                                        </div>
                                        <p class="mt-3 text-sm font-bold text-[#123B5D]">{{ $place['address'] }}</p>
                                        <p class="mt-1 text-xs text-[#334155]/80">Titik koordinat peta belum disematkan. Gunakan tombol "Buka di Google Maps" untuk petunjuk arah.</p>
                                    </div>
                                @endif
                            </div>
                        </section>
                    </div>

                    {{-- Kolom Kanan: Informasi Biaya, Pengelola, CTA & Laporkan Konten --}}
                    <aside class="space-y-6 lg:col-span-4">
                        <div class="lg:sticky lg:top-24 lg:space-y-6">
                            {{-- Kartu Informasi Biaya & Kontak --}}
                            <div class="rounded-3xl border border-[#E2E8F0] bg-white p-6 shadow-sm">
                                <span class="text-xs font-bold uppercase tracking-wider text-[#14B8A6]">
                                    Informasi Akses
                                </span>
                                <div class="mt-3 flex items-baseline justify-between gap-2">
                                    <h3 class="text-lg font-bold text-[#123B5D]">Biaya &amp; Pendaftaran</h3>
                                    @if ($isFree)
                                        <span class="rounded-full bg-[#EAF6F4] px-3 py-1 text-xs font-bold text-[#0D9488]">
                                            Gratis
                                        </span>
                                    @else
                                        <span class="rounded-full bg-[#F8FAFC] px-3 py-1 text-xs font-bold text-[#123B5D] ring-1 ring-[#E2E8F0]">
                                            {{ $place['cost'] }}
                                        </span>
                                    @endif
                                </div>

                                @if (!empty($place['contact_info']))
                                    <div class="mt-4 rounded-2xl border border-[#E2E8F0] bg-[#F8FAFC] p-4">
                                        <p class="text-[11px] font-bold uppercase tracking-wider text-[#334155]/70">Kontak Pengelola</p>
                                        <p class="mt-1 text-sm font-semibold text-[#123B5D]">{{ $place['contact_info'] }}</p>
                                    </div>
                                @endif

                                {{-- CTA Menghubungi / Mendaftar --}}
                                <div class="mt-6 space-y-3">
                                    @auth
                                        <a
                                            href="{{ route('dashboard') }}"
                                            class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#14B8A6] px-5 py-3.5 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:bg-[#0D9488] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#14B8A6]"
                                        >
                                            <span>Ajukan Kunjungan / Kebutuhan</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <path d="M5 12h14" />
                                                <path d="m12 5 7 7-7 7" />
                                            </svg>
                                        </a>
                                    @else
                                        <a
                                            href="{{ route('register', ['role' => 'pelajar']) }}"
                                            class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#14B8A6] px-5 py-3.5 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:bg-[#0D9488] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#14B8A6]"
                                        >
                                            <span>Daftar untuk Terhubung</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <path d="M5 12h14" />
                                                <path d="m12 5 7 7-7 7" />
                                            </svg>
                                        </a>
                                    @endauth

                                    <a
                                        href="{{ $googleMapsUrl }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-[#E2E8F0] bg-white px-5 py-3 text-sm font-semibold text-[#123B5D] transition hover:border-[#123B5D] hover:bg-[#F8FAFC]"
                                    >
                                        <span>Petunjuk Arah Lokasi</span>
                                    </a>
                                </div>
                            </div>

                            {{-- Kartu Informasi Pengelola --}}
                            <div class="rounded-3xl border border-[#E2E8F0] bg-white p-6 shadow-xs">
                                <span class="text-xs font-bold uppercase tracking-wider text-[#14B8A6]">
                                    Pengelola Ruang
                                </span>
                                <div class="mt-4 flex items-start gap-3.5">
                                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-[#123B5D] text-white">
                                        {{-- Lucide UserCheck Icon --}}
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#5EEAD4]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                            <circle cx="9" cy="7" r="4" />
                                            <polyline points="16 11 18 13 22 9" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="truncate text-base font-bold text-[#123B5D]">
                                            {{ $owner['display_name'] ?? 'Pengelola Komunitas EduConnect' }}
                                        </p>
                                        <p class="mt-0.5 text-xs font-medium text-[#0D9488]">
                                            {{ $owner['institution'] ?? $place['title'] }}
                                        </p>
                                        @if (!empty($owner['location']))
                                            <p class="mt-1 text-xs text-[#334155]/80">Berbasis di {{ $owner['location'] }}</p>
                                        @endif
                                    </div>
                                </div>

                                @if (!empty($owner['bio']))
                                    <p class="mt-4 border-t border-[#E2E8F0] pt-4 text-xs leading-relaxed text-[#334155]">
                                        {{ $owner['bio'] }}
                                    </p>
                                @endif
                            </div>

                            {{-- Kartu Tombol Laporkan Konten --}}
                            <div class="rounded-3xl border border-[#E2E8F0] bg-white p-6 shadow-xs">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <h3 class="text-sm font-bold text-[#123B5D]">Temukan ketidaksesuaian?</h3>
                                        <p class="mt-1 text-xs leading-relaxed text-[#334155]/85">
                                            Bantu kami menjaga keakuratan data alamat, jadwal, atau kondisi ruang belajar ini.
                                        </p>
                                    </div>
                                </div>

                                <button
                                    type="button"
                                    id="toggle-report-form"
                                    aria-expanded="{{ $errors->any() ? 'true' : 'false' }}"
                                    aria-controls="report-form-panel"
                                    class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-xl border border-[#E2E8F0] bg-[#F8FAFC] px-4 py-2.5 text-xs font-semibold text-[#334155] transition hover:border-amber-300 hover:bg-amber-50 hover:text-amber-800 focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-500"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z" />
                                        <line x1="4" x2="4" y1="22" y2="15" />
                                    </svg>
                                    <span>Laporkan Konten</span>
                                </button>

                                <form
                                    id="report-form-panel"
                                    method="POST"
                                    action="{{ route('learning-places.report', $place['slug']) }}"
                                    @class(['mt-5 space-y-4 border-t border-[#E2E8F0] pt-5', 'hidden' => ! $errors->any()])
                                >
                                    @csrf

                                    <div>
                                        <label for="report-title" class="block text-xs font-semibold text-[#123B5D]">
                                            Ringkasan Masalah
                                        </label>
                                        <input
                                            id="report-title"
                                            type="text"
                                            name="title"
                                            value="{{ old('title') }}"
                                            required
                                            placeholder="Contoh: Alamat atau jam buka berubah"
                                            class="mt-1.5 w-full rounded-xl border border-[#E2E8F0] bg-[#F8FAFC] px-3.5 py-2.5 text-xs text-[#123B5D] placeholder:text-[#334155]/50 focus:border-[#14B8A6] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#14B8A6]/20"
                                        />
                                    </div>

                                    @guest
                                        <div>
                                            <label for="report-name" class="block text-xs font-semibold text-[#123B5D]">
                                                Nama Anda (Opsional)
                                            </label>
                                            <input
                                                id="report-name"
                                                type="text"
                                                name="reporter_name"
                                                value="{{ old('reporter_name') }}"
                                                placeholder="Nama pelapor"
                                                class="mt-1.5 w-full rounded-xl border border-[#E2E8F0] bg-[#F8FAFC] px-3.5 py-2.5 text-xs text-[#123B5D] placeholder:text-[#334155]/50 focus:border-[#14B8A6] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#14B8A6]/20"
                                            />
                                        </div>
                                    @endguest

                                    <div>
                                        <label for="report-description" class="block text-xs font-semibold text-[#123B5D]">
                                            Detail Masalah
                                        </label>
                                        <textarea
                                            id="report-description"
                                            name="description"
                                            rows="3"
                                            required
                                            placeholder="Jelaskan informasi yang perlu diperbarui atau diperiksa oleh tim kami..."
                                            class="mt-1.5 w-full rounded-xl border border-[#E2E8F0] bg-[#F8FAFC] px-3.5 py-2.5 text-xs text-[#123B5D] placeholder:text-[#334155]/50 focus:border-[#14B8A6] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#14B8A6]/20"
                                        >{{ old('description') }}</textarea>
                                    </div>

                                    <button
                                        type="submit"
                                        class="inline-flex w-full items-center justify-center rounded-xl bg-[#123B5D] px-4 py-2.5 text-xs font-semibold text-white transition hover:bg-[#14B8A6]"
                                    >
                                        Kirim Laporan
                                    </button>
                                </form>
                            </div>
                        </div>
                    </aside>
                </div>

                {{-- Rekomendasi Tempat Belajar Lain --}}
                @if ($recommendations->isNotEmpty())
                    <section class="mt-16 border-t border-[#E2E8F0] pt-14">
                        <div class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-end">
                            <div>
                                <span class="text-xs font-bold uppercase tracking-[0.2em] text-[#14B8A6]">
                                    Pilihan Serupa
                                </span>
                                <h2 class="mt-2 text-2xl font-bold tracking-tight text-[#123B5D] sm:text-3xl">
                                    Rekomendasi Tempat Belajar Lain
                                </h2>
                            </div>
                            <a
                                href="{{ route('learning-places.index') }}"
                                class="inline-flex items-center gap-2 text-sm font-semibold text-[#14B8A6] hover:text-[#0D9488]"
                            >
                                <span>Lihat semua tempat</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M5 12h14" />
                                    <path d="m12 5 7 7-7 7" />
                                </svg>
                            </a>
                        </div>

                        <div class="mt-8 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                            @foreach ($recommendations as $recommendedPlace)
                                <x-place-card :place="$recommendedPlace" />
                            @endforeach
                        </div>
                    </section>
                @endif
            </div>
        </main>

        <x-footer />

        @stack('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const toggleBtn = document.getElementById('toggle-report-form');
                const panel = document.getElementById('report-form-panel');

                if (!toggleBtn || !panel) return;

                toggleBtn.addEventListener('click', function () {
                    const isHidden = panel.classList.contains('hidden');
                    panel.classList.toggle('hidden', !isHidden);
                    toggleBtn.setAttribute('aria-expanded', String(isHidden));
                });
            });
        </script>
    </body>
</html>
