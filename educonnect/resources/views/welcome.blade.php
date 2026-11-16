<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="EduConnect mempertemukan siswa, relawan, dan pengelola ruang belajar dalam satu ekosistem yang aman, terbuka, dan berdampak.">

        <title>EduConnect — Ruang Belajar yang Tepat, Masa Depan yang Dekat</title>

        @fonts

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#F8FAFC] font-sans text-[#334155] antialiased selection:bg-[#14B8A6]/20 selection:text-[#123B5D]">
        {{-- Skip Link untuk Aksesibilitas --}}
        <a
            href="#main-content"
            class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-[100] focus:rounded-xl focus:bg-[#123B5D] focus:px-4 focus:py-2.5 focus:text-sm focus:font-semibold focus:text-white focus:shadow-lg focus:outline-none focus:ring-2 focus:ring-[#14B8A6]"
        >
            Lewati ke konten utama
        </a>

        {{-- Struktur Navigasi Utama --}}
        <x-navbar active="beranda" />

        <main id="main-content">
            {{-- ============================================================
                 A. HERO SECTION
                 ============================================================ --}}
            <section class="relative overflow-hidden pt-10 pb-16 sm:pt-14 sm:pb-24 lg:pt-20 lg:pb-28">
                {{-- Ornamen Latar Belakang Lembut --}}
                <div class="pointer-events-none absolute -top-24 right-0 -z-10 h-96 w-96 rounded-full bg-[#EAF6F4] blur-3xl" aria-hidden="true"></div>
                <div class="pointer-events-none absolute bottom-0 -left-24 -z-10 h-80 w-80 rounded-full bg-[#14B8A6]/5 blur-3xl" aria-hidden="true"></div>

                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 items-center gap-12 lg:grid-cols-12 lg:gap-12">
                        {{-- Kolom Kiri --}}
                        <div class="lg:col-span-7">
                            {{-- Badge --}}
                            <div class="inline-flex items-center gap-2 rounded-full border border-[#14B8A6]/25 bg-[#EAF6F4] px-4 py-1.5 text-xs font-bold uppercase tracking-widest text-[#0D9488]">
                                <span class="h-2 w-2 rounded-full bg-[#14B8A6]" aria-hidden="true"></span>
                                <span>Pendidikan tumbuh dari koneksi</span>
                            </div>

                            {{-- Headline Besar --}}
                            <h1 class="mt-6 text-4xl font-extrabold tracking-tight text-[#123B5D] sm:text-5xl lg:text-[3.5rem] lg:leading-[1.12]">
                                Ruang belajar yang tepat,
                                <span class="block text-[#14B8A6]">masa depan yang dekat.</span>
                            </h1>

                            {{-- Deskripsi --}}
                            <p class="mt-6 max-w-2xl text-base leading-relaxed text-[#334155] sm:text-lg sm:leading-relaxed">
                                EduConnect mempertemukan siswa, relawan, dan pengelola ruang belajar dalam satu ekosistem yang aman, terbuka, dan berdampak.
                            </p>

                            {{-- Formulir Pencarian --}}
                            <form
                                action="{{ url('/tempat-belajar') }}"
                                method="GET"
                                role="search"
                                aria-label="Cari tempat belajar"
                                class="mt-8 rounded-2xl border border-[#E2E8F0] bg-white p-3 shadow-lg shadow-[#123B5D]/5"
                            >
                                <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                                    {{-- Input Kata Kunci --}}
                                    <div class="relative flex-1">
                                        <label for="search-keyword" class="sr-only">Kata kunci tempat belajar</label>
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#14B8A6]">
                                            {{-- Lucide Search Icon --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <circle cx="11" cy="11" r="8" />
                                                <path d="m21 21-4.3-4.3" />
                                            </svg>
                                        </div>
                                        <input
                                            type="text"
                                            id="search-keyword"
                                            name="q"
                                            placeholder="Cari nama ruang, perpustakaan, atau fasilitas..."
                                            class="w-full rounded-xl border border-transparent bg-[#F8FAFC] py-3 pr-4 pl-11 text-sm text-[#123B5D] placeholder:text-[#334155]/60 focus:border-[#14B8A6] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#14B8A6]/20"
                                        />
                                    </div>

                                    {{-- Divider Desktop --}}
                                    <div class="hidden h-8 w-px bg-[#E2E8F0] sm:block" aria-hidden="true"></div>

                                    {{-- Dropdown Lokasi --}}
                                    <div class="relative sm:w-52">
                                        <label for="search-location" class="sr-only">Pilih lokasi kota</label>
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#14B8A6]">
                                            {{-- Lucide MapPin Icon --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0" />
                                                <circle cx="12" cy="10" r="3" />
                                            </svg>
                                        </div>
                                        <select
                                            id="search-location"
                                            name="lokasi"
                                            class="w-full appearance-none rounded-xl border border-transparent bg-[#F8FAFC] py-3 pr-9 pl-11 text-sm font-medium text-[#123B5D] focus:border-[#14B8A6] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#14B8A6]/20"
                                        >
                                            <option value="">Semua Lokasi</option>
                                            @foreach($locations as $city)
                                                <option value="{{ $city }}">{{ $city }}</option>
                                            @endforeach
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-[#334155]/70">
                                            {{-- Lucide ChevronDown Icon --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <path d="m6 9 6 6 6-6" />
                                            </svg>
                                        </div>
                                    </div>

                                    {{-- Tombol Temukan --}}
                                    <button
                                        type="submit"
                                        class="group inline-flex items-center justify-center gap-2 rounded-xl bg-[#123B5D] px-6 py-3.5 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-[#14B8A6] hover:shadow-md focus:outline-none focus-visible:ring-2 focus-visible:ring-[#14B8A6] focus-visible:ring-offset-2 sm:w-auto"
                                    >
                                        <span>Temukan</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M5 12h14" />
                                            <path d="m12 5 7 7-7 7" />
                                        </svg>
                                    </button>
                                </div>
                            </form>

                            {{-- Tiga Trust Indicator --}}
                            <div class="mt-8 flex flex-wrap items-center gap-x-6 gap-y-3">
                                <div class="inline-flex items-center gap-2 text-sm font-medium text-[#334155]">
                                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-[#EAF6F4] text-[#14B8A6]">
                                        {{-- Lucide ShieldCheck Icon --}}
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z" />
                                            <path d="m9 12 2 2 4-4" />
                                        </svg>
                                    </span>
                                    <span>Tempat terverifikasi</span>
                                </div>

                                <div class="inline-flex items-center gap-2 text-sm font-medium text-[#334155]">
                                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-[#EAF6F4] text-[#14B8A6]">
                                        {{-- Lucide Users Icon --}}
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                            <circle cx="9" cy="7" r="4" />
                                            <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                        </svg>
                                    </span>
                                    <span>Komunitas terpercaya</span>
                                </div>

                                <div class="inline-flex items-center gap-2 text-sm font-medium text-[#334155]">
                                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-[#EAF6F4] text-[#14B8A6]">
                                        {{-- Lucide Sparkles / HeartHandshake Icon --}}
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <circle cx="12" cy="12" r="10" />
                                            <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20" />
                                            <path d="M2 12h20" />
                                        </svg>
                                    </span>
                                    <span>Terbuka untuk semua</span>
                                </div>
                            </div>
                        </div>

                        {{-- Kolom Kanan: Komposisi Visual Kolase Foto Tempat Belajar --}}
                        <div class="relative lg:col-span-5">
                            {{-- Ornamen Abstrak Lingkaran, Border, dan Shape Lembut --}}
                            <div class="pointer-events-none absolute -top-6 -right-6 h-40 w-40 rounded-full border-2 border-dashed border-[#14B8A6]/30" aria-hidden="true"></div>
                            <div class="pointer-events-none absolute -bottom-8 -left-8 h-48 w-48 rounded-3xl bg-[#EAF6F4] -z-10" aria-hidden="true"></div>
                            <div class="pointer-events-none absolute top-1/2 -right-4 h-24 w-24 -translate-y-1/2 rounded-full bg-[#123B5D]/5" aria-hidden="true"></div>

                            <div class="relative mx-auto max-w-md lg:max-w-none">
                                {{-- Gambar Utama Berukuran Besar --}}
                                <div class="relative overflow-hidden rounded-3xl border border-[#E2E8F0] bg-white p-3 shadow-xl shadow-[#123B5D]/10">
                                    <div class="relative aspect-[4/3] overflow-hidden rounded-2xl bg-[#EAF6F4]">
                                        @if(!empty($heroPlace['image']))
                                            <img
                                                src="{{ $heroPlace['image'] }}"
                                                alt="Suasana belajar di {{ $heroPlace['title'] }}"
                                                class="h-full w-full object-cover"
                                            />
                                        @else
                                            {{-- Placeholder Ilustratif Menggunakan Ikon Buku & Komunitas --}}
                                            <div class="flex h-full w-full flex-col items-center justify-center bg-gradient-to-br from-[#123B5D] via-[#123B5D]/95 to-[#14B8A6]/80 p-8 text-center text-white">
                                                <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-white/15 backdrop-blur-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#14B8A6]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                        <path d="M12 7v14" />
                                                        <path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z" />
                                                    </svg>
                                                </div>
                                                <p class="mt-4 text-sm font-semibold text-white">Ruang Belajar &amp; Literasi Komunitas</p>
                                                <p class="mt-1 text-xs text-white/75">Terbuka dan ramah untuk seluruh pelajar</p>
                                            </div>
                                        @endif

                                        {{-- Gradient Overlay Halus --}}
                                        <div class="absolute inset-0 bg-gradient-to-t from-[#123B5D]/80 via-[#123B5D]/20 to-transparent"></div>

                                        {{-- Badge "Tempat pilihan" --}}
                                        <div class="absolute top-3.5 left-3.5">
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-[#14B8A6] px-3.5 py-1 text-xs font-bold text-white shadow-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                                                </svg>
                                                <span>Tempat pilihan</span>
                                            </span>
                                        </div>

                                        {{-- Informasi Nama dan Lokasi Tempat Belajar --}}
                                        <div class="absolute inset-x-4 bottom-4 text-white">
                                            <p class="text-xs font-medium text-[#EAF6F4]">
                                                {{ $heroPlace['category'] ?? 'Rumah Belajar' }} &bull; {{ $heroPlace['location'] ?? 'Kebayoran Baru, Jakarta Selatan' }}
                                            </p>
                                            <p class="mt-0.5 text-lg font-bold tracking-tight">
                                                {{ $heroPlace['title'] ?? 'Rumah Baca Pelita Nusantara' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Kartu Informasi "Aman untuk belajar" (Floating Top-Left / Mid-Left) --}}
                                <div class="mt-4 flex items-center gap-3.5 rounded-2xl border border-[#E2E8F0] bg-white p-4 shadow-lg shadow-[#123B5D]/10 sm:absolute sm:-top-5 sm:-left-6 sm:mt-0 sm:max-w-[235px]">
                                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#EAF6F4] text-[#14B8A6]">
                                        {{-- Lucide ShieldCheck Icon --}}
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z" />
                                            <path d="m9 12 2 2 4-4" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-[#123B5D]">Aman untuk belajar</p>
                                        <p class="text-xs text-[#334155]">Telah diverifikasi langsung oleh tim komunitas</p>
                                    </div>
                                </div>

                                {{-- Gambar Pendukung Berukuran Lebih Kecil (Kolase Sudut Kanan Bawah) --}}
                                <div class="mt-4 overflow-hidden rounded-2xl border-2 border-white bg-white p-2 shadow-xl shadow-[#123B5D]/10 sm:mt-6 sm:ml-auto sm:w-64">
                                    <div class="flex items-center gap-3">
                                        <div class="relative h-16 w-20 shrink-0 overflow-hidden rounded-xl bg-[#EAF6F4]">
                                            @if(!empty($featuredPlaces[1]['image'] ?? null))
                                                <img
                                                    src="{{ $featuredPlaces[1]['image'] }}"
                                                    alt="Aktivitas komunitas belajar di {{ $featuredPlaces[1]['title'] }}"
                                                    class="h-full w-full object-cover"
                                                />
                                            @else
                                                <div class="flex h-full w-full items-center justify-center bg-[#123B5D] text-[#14B8A6]">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                                        <circle cx="9" cy="7" r="4" />
                                                        <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="min-w-0 pr-2">
                                            <span class="inline-block rounded-md bg-[#EAF6F4] px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-[#0D9488]">
                                                Kolaborasi
                                            </span>
                                            <p class="mt-1 truncate text-xs font-bold text-[#123B5D]">
                                                {{ $featuredPlaces[1]['title'] ?? 'Komunitas Belajar Aktif' }}
                                            </p>
                                            <p class="truncate text-[11px] text-[#334155]">
                                                {{ $featuredPlaces[1]['city'] ?? 'Terbuka akhir pekan' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ============================================================
                 B. STATISTIK SINGKAT
                 ============================================================ --}}
            <section aria-label="Statistik EduConnect" class="border-y border-[#E2E8F0] bg-white py-12 sm:py-16">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <dl class="grid grid-cols-2 gap-8 lg:grid-cols-4 lg:gap-12">
                        {{-- 1. Jumlah Tempat Belajar --}}
                        <div class="flex flex-col items-start border-l-2 border-[#14B8A6] pl-5">
                            <dt class="order-2 mt-2 text-xs font-bold uppercase tracking-widest text-[#334155]/80">
                                Tempat Belajar
                            </dt>
                            <dd class="order-1 text-3xl font-extrabold tracking-tight text-[#123B5D] sm:text-4xl lg:text-5xl">
                                {{ $stats['total_places'] }}
                            </dd>
                        </div>

                        {{-- 2. Jumlah Kota Terhubung --}}
                        <div class="flex flex-col items-start border-l-2 border-[#14B8A6] pl-5">
                            <dt class="order-2 mt-2 text-xs font-bold uppercase tracking-widest text-[#334155]/80">
                                Kota Terhubung
                            </dt>
                            <dd class="order-1 text-3xl font-extrabold tracking-tight text-[#123B5D] sm:text-4xl lg:text-5xl">
                                {{ $stats['total_cities'] }}
                            </dd>
                        </div>

                        {{-- 3. Persentase Tempat Terverifikasi --}}
                        <div class="flex flex-col items-start border-l-2 border-[#14B8A6] pl-5">
                            <dt class="order-2 mt-2 text-xs font-bold uppercase tracking-widest text-[#334155]/80">
                                Tempat Terverifikasi
                            </dt>
                            <dd class="order-1 text-3xl font-extrabold tracking-tight text-[#123B5D] sm:text-4xl lg:text-5xl">
                                {{ $stats['verified_percentage'] }}%
                            </dd>
                        </div>

                        {{-- 4. Jumlah Cara Berkontribusi --}}
                        <div class="flex flex-col items-start border-l-2 border-[#14B8A6] pl-5">
                            <dt class="order-2 mt-2 text-xs font-bold uppercase tracking-widest text-[#334155]/80">
                                Cara Berkontribusi
                            </dt>
                            <dd class="order-1 text-3xl font-extrabold tracking-tight text-[#123B5D] sm:text-4xl lg:text-5xl">
                                {{ $stats['contribution_ways'] }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </section>

            {{-- ============================================================
                 C. PILIHAN PERAN PENGGUNA
                 ============================================================ --}}
            <section id="peran-pengguna" class="py-20 sm:py-24 lg:py-28">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="mx-auto max-w-3xl text-center">
                        <span class="text-xs font-bold uppercase tracking-[0.2em] text-[#14B8A6]">
                            Peran dalam Ekosistem
                        </span>
                        <h2 class="mt-3 text-3xl font-bold tracking-tight text-[#123B5D] sm:text-4xl">
                            Satu ekosistem, banyak cara untuk membuat perubahan.
                        </h2>
                        <p class="mt-4 text-base leading-relaxed text-[#334155]">
                            Pilih peran yang paling sesuai dengan kebutuhan atau kontribusi yang ingin kamu berikan hari ini.
                        </p>
                    </div>

                    <div class="mt-14 grid grid-cols-1 gap-8 lg:grid-cols-3">
                        {{-- Kartu 1: Saya ingin belajar (Navy Blue & Teks Putih) --}}
                        <div class="group relative flex flex-col justify-between overflow-hidden rounded-3xl bg-[#123B5D] p-8 text-white shadow-lg shadow-[#123B5D]/10 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-[#123B5D]/20 sm:p-9">
                            {{-- Nomor Urutan Besar Transparan --}}
                            <span class="pointer-events-none absolute top-4 right-6 select-none text-7xl font-extrabold tracking-tighter text-white/10" aria-hidden="true">
                                01
                            </span>

                            <div>
                                {{-- Ikon --}}
                                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white/10 text-[#14B8A6] ring-1 ring-white/15">
                                    {{-- Lucide BookOpen Icon --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M12 7v14" />
                                        <path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z" />
                                    </svg>
                                </div>

                                <h3 class="mt-7 text-2xl font-bold tracking-tight text-white">
                                    Saya ingin belajar
                                </h3>

                                <p class="mt-3 text-base leading-relaxed text-white/85">
                                    Temukan tempat yang nyaman, fasilitas yang sesuai, dan komunitas yang mendukungmu.
                                </p>
                            </div>

                            <div class="mt-8 pt-4">
                                <a
                                    href="{{ url('/tempat-belajar') }}"
                                    class="inline-flex items-center gap-2 rounded-xl bg-[#14B8A6] px-5 py-3 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-[#0D9488] focus:outline-none focus-visible:ring-2 focus-visible:ring-white"
                                >
                                    <span>Cari tempat belajar</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M5 12h14" />
                                        <path d="m12 5 7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                        {{-- Kartu 2: Saya ingin membantu (Putih dengan Border Slate) --}}
                        <div class="group relative flex flex-col justify-between overflow-hidden rounded-3xl border border-[#E2E8F0] bg-white p-8 text-[#334155] shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-[#14B8A6]/50 hover:shadow-xl hover:shadow-[#123B5D]/5 sm:p-9">
                            {{-- Nomor Urutan Besar Transparan --}}
                            <span class="pointer-events-none absolute top-4 right-6 select-none text-7xl font-extrabold tracking-tighter text-[#123B5D]/5" aria-hidden="true">
                                02
                            </span>

                            <div>
                                {{-- Ikon --}}
                                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-[#EAF6F4] text-[#14B8A6]">
                                    {{-- Lucide HeartHandshake Icon --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
                                        <path d="M12 5 9.04 7.96a2.17 2.17 0 0 0 0 3.08c.82.82 2.13.85 3 .07l2.07-1.9a2.82 2.82 0 0 1 3.79 0l2.96 2.66" />
                                        <path d="m18 15-2-2" />
                                        <path d="m15 18-2-2" />
                                    </svg>
                                </div>

                                <h3 class="mt-7 text-2xl font-bold tracking-tight text-[#123B5D]">
                                    Saya ingin membantu
                                </h3>

                                <p class="mt-3 text-base leading-relaxed text-[#334155]">
                                    Bagikan keahlian, waktu, atau sumber daya kepada siswa yang membutuhkannya.
                                </p>
                            </div>

                            <div class="mt-8 pt-4">
                                <a
                                    href="{{ url('/registrasi?role=relawan') }}"
                                    class="inline-flex items-center gap-2 rounded-xl border border-[#E2E8F0] bg-[#F8FAFC] px-5 py-3 text-sm font-semibold text-[#123B5D] transition-all duration-200 group-hover:border-[#14B8A6] group-hover:bg-[#14B8A6] group-hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-[#14B8A6]"
                                >
                                    <span>Jadi relawan</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M5 12h14" />
                                        <path d="m12 5 7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                        {{-- Kartu 3: Saya mengelola ruang (Background Light Teal) --}}
                        <div class="group relative flex flex-col justify-between overflow-hidden rounded-3xl border border-[#14B8A6]/20 bg-[#EAF6F4] p-8 text-[#334155] shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-[#14B8A6]/50 hover:shadow-xl hover:shadow-[#14B8A6]/10 sm:p-9">
                            {{-- Nomor Urutan Besar Transparan --}}
                            <span class="pointer-events-none absolute top-4 right-6 select-none text-7xl font-extrabold tracking-tighter text-[#14B8A6]/15" aria-hidden="true">
                                03
                            </span>

                            <div>
                                {{-- Ikon --}}
                                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white text-[#123B5D] shadow-xs">
                                    {{-- Lucide Building2 / Landmark Icon --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#14B8A6]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z" />
                                        <path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2" />
                                        <path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2" />
                                        <path d="M10 6h4" />
                                        <path d="M10 10h4" />
                                        <path d="M10 14h4" />
                                        <path d="M10 18h4" />
                                    </svg>
                                </div>

                                <h3 class="mt-7 text-2xl font-bold tracking-tight text-[#123B5D]">
                                    Saya mengelola ruang
                                </h3>

                                <p class="mt-3 text-base leading-relaxed text-[#334155]">
                                    Perkenalkan ruang belajarmu dan terhubung dengan lebih banyak siswa serta relawan.
                                </p>
                            </div>

                            <div class="mt-8 pt-4">
                                <a
                                    href="{{ url('/registrasi?role=pengelola') }}"
                                    class="inline-flex items-center gap-2 rounded-xl bg-[#123B5D] px-5 py-3 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-[#14B8A6] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#123B5D]"
                                >
                                    <span>Daftarkan tempat</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M5 12h14" />
                                        <path d="m12 5 7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ============================================================
                 D. TEMPAT BELAJAR UNGGULAN
                 ============================================================ --}}
            <section id="tempat-unggulan" class="border-y border-[#E2E8F0] bg-[#EAF6F4]/60 py-20 sm:py-24 lg:py-28">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    {{-- Header Section --}}
                    <div class="flex flex-col items-start justify-between gap-6 md:flex-row md:items-end">
                        <div class="max-w-2xl">
                            <span class="text-xs font-bold uppercase tracking-[0.2em] text-[#14B8A6]">
                                Direktori Pilihan
                            </span>
                            <h2 class="mt-3 text-3xl font-bold tracking-tight text-[#123B5D] sm:text-4xl">
                                Ruang belajar untuk setiap langkah.
                            </h2>
                            <p class="mt-3 text-base leading-relaxed text-[#334155]">
                                Pilihan tempat terverifikasi yang siap mendukung perjalanan belajarmu.
                            </p>
                        </div>

                        <div class="flex flex-wrap items-center gap-3">
                            <a
                                href="{{ url('/tempat-belajar') }}"
                                class="group inline-flex items-center gap-2 rounded-xl border border-[#E2E8F0] bg-white px-5 py-3 text-sm font-semibold text-[#123B5D] shadow-xs transition-all duration-200 hover:border-[#14B8A6] hover:text-[#14B8A6] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#14B8A6]"
                            >
                                <span>Lihat semua tempat</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M5 12h14" />
                                    <path d="m12 5 7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    {{-- Grid Maksimal Tiga Kartu Tempat Belajar atau Empty State --}}
                    @if($featuredPlaces->isNotEmpty())
                        <div class="mt-12 grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                            @foreach($featuredPlaces->take(3) as $place)
                                <x-place-card :place="$place" />
                            @endforeach
                        </div>
                    @else
                        {{-- Empty State: Tempat belajar sedang disiapkan --}}
                        <div class="mt-12 flex flex-col items-center justify-center rounded-3xl border border-dashed border-[#14B8A6]/40 bg-white px-6 py-16 text-center shadow-xs sm:px-12">
                            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-[#EAF6F4] text-[#14B8A6]">
                                {{-- Lucide BookMarked / Compass Icon --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M12 7v14" />
                                    <path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z" />
                                </svg>
                            </div>
                            <h3 class="mt-6 text-xl font-bold text-[#123B5D]">
                                Tempat belajar sedang disiapkan
                            </h3>
                            <p class="mt-2 max-w-md text-sm leading-relaxed text-[#334155]">
                                Saat ini tim kami sedang memverifikasi ruang belajar baru. Silakan kembali lagi nanti untuk melihat tempat belajar terbaru di kotamu.
                            </p>
                            <div class="mt-6 flex flex-wrap items-center justify-center gap-3">
                                <a
                                    href="{{ url('/registrasi?role=pengelola') }}"
                                    class="inline-flex items-center gap-2 rounded-xl bg-[#14B8A6] px-5 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-[#0D9488]"
                                >
                                    <span>Daftarkan Ruang Belajar</span>
                                </a>
                                @if($isEmptyPreview ?? false)
                                    <a
                                        href="{{ route('home') }}"
                                        class="inline-flex items-center gap-2 rounded-xl border border-[#E2E8F0] bg-[#F8FAFC] px-4 py-2.5 text-sm font-medium text-[#123B5D] transition-colors hover:bg-[#E2E8F0]/50"
                                    >
                                        <span>Tampilkan Data Contoh</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </section>

            {{-- ============================================================
                 E. CARA KERJA PLATFORM
                 ============================================================ --}}
            <section id="cara-kerja" class="py-20 sm:py-24 lg:py-28">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 items-start gap-12 lg:grid-cols-12 lg:gap-16">
                        {{-- Kolom Kiri --}}
                        <div class="lg:sticky lg:top-28 lg:col-span-5">
                            <span class="text-xs font-bold uppercase tracking-[0.2em] text-[#14B8A6]">
                                Mudah dan transparan
                            </span>
                            <h2 class="mt-3 text-3xl font-bold tracking-tight text-[#123B5D] sm:text-4xl lg:leading-tight">
                                Dari mencari ruang hingga menciptakan dampak.
                            </h2>
                            <p class="mt-4 text-base leading-relaxed text-[#334155]">
                                Kami merancang alur yang sederhana agar setiap pelajar, relawan, dan pengelola tempat dapat saling terhubung tanpa hambatan teknis.
                            </p>

                            <div class="mt-8">
                                <a
                                    href="#peran-pengguna"
                                    class="group inline-flex items-center gap-2.5 rounded-xl bg-[#123B5D] px-6 py-3.5 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:bg-[#14B8A6] hover:shadow-md focus:outline-none focus-visible:ring-2 focus-visible:ring-[#14B8A6] focus-visible:ring-offset-2"
                                >
                                    <span>Kenali EduConnect</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M5 12h14" />
                                        <path d="m12 5 7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                        {{-- Kolom Kanan: Tiga Langkah Kartu Horizontal --}}
                        <div class="flex flex-col gap-6 lg:col-span-7">
                            {{-- Langkah 1 --}}
                            <div class="group flex flex-col gap-5 rounded-2xl border border-[#E2E8F0] bg-white p-6 shadow-xs transition-all duration-300 hover:-translate-y-1 hover:border-[#14B8A6]/40 hover:shadow-md sm:flex-row sm:items-start sm:p-7">
                                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-[#EAF6F4] text-[#14B8A6] transition-colors duration-200 group-hover:bg-[#14B8A6] group-hover:text-white">
                                    {{-- Lucide Search / Compass Icon --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <circle cx="11" cy="11" r="8" />
                                        <path d="m21 21-4.3-4.3" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="text-xs font-bold uppercase tracking-widest text-[#14B8A6]">Langkah 01</span>
                                        <span class="text-2xl font-extrabold text-[#123B5D]/10">01</span>
                                    </div>
                                    <h3 class="mt-1 text-xl font-bold text-[#123B5D]">
                                        Temukan yang sesuai
                                    </h3>
                                    <p class="mt-2 text-sm leading-relaxed text-[#334155] sm:text-base">
                                        Gunakan lokasi, biaya, jadwal, dan fasilitas untuk menemukan ruang terbaik.
                                    </p>
                                </div>
                            </div>

                            {{-- Langkah 2 --}}
                            <div class="group flex flex-col gap-5 rounded-2xl border border-[#E2E8F0] bg-white p-6 shadow-xs transition-all duration-300 hover:-translate-y-1 hover:border-[#14B8A6]/40 hover:shadow-md sm:flex-row sm:items-start sm:p-7">
                                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-[#EAF6F4] text-[#14B8A6] transition-colors duration-200 group-hover:bg-[#14B8A6] group-hover:text-white">
                                    {{-- Lucide ShieldCheck Icon --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z" />
                                        <path d="m9 12 2 2 4-4" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="text-xs font-bold uppercase tracking-widest text-[#14B8A6]">Langkah 02</span>
                                        <span class="text-2xl font-extrabold text-[#123B5D]/10">02</span>
                                    </div>
                                    <h3 class="mt-1 text-xl font-bold text-[#123B5D]">
                                        Terhubung dengan aman
                                    </h3>
                                    <p class="mt-2 text-sm leading-relaxed text-[#334155] sm:text-base">
                                        Setiap tempat melewati proses verifikasi sebelum tampil di direktori.
                                    </p>
                                </div>
                            </div>

                            {{-- Langkah 3 --}}
                            <div class="group flex flex-col gap-5 rounded-2xl border border-[#E2E8F0] bg-white p-6 shadow-xs transition-all duration-300 hover:-translate-y-1 hover:border-[#14B8A6]/40 hover:shadow-md sm:flex-row sm:items-start sm:p-7">
                                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-[#EAF6F4] text-[#14B8A6] transition-colors duration-200 group-hover:bg-[#14B8A6] group-hover:text-white">
                                    {{-- Lucide Users / Sprout Icon --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                        <circle cx="9" cy="7" r="4" />
                                        <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="text-xs font-bold uppercase tracking-widest text-[#14B8A6]">Langkah 03</span>
                                        <span class="text-2xl font-extrabold text-[#123B5D]/10">03</span>
                                    </div>
                                    <h3 class="mt-1 text-xl font-bold text-[#123B5D]">
                                        Tumbuh bersama komunitas
                                    </h3>
                                    <p class="mt-2 text-sm leading-relaxed text-[#334155] sm:text-base">
                                        Belajar, berbagi kebutuhan, atau hadir sebagai relawan untuk memberi dampak.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ============================================================
                 F. CTA PENUTUP
                 ============================================================ --}}
            <section id="cta-penutup" class="pb-20 sm:pb-24 lg:pb-28">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="relative overflow-hidden rounded-3xl bg-[#123B5D] px-6 py-16 text-center shadow-xl shadow-[#123B5D]/15 sm:px-12 sm:py-20 lg:px-20">
                        {{-- Ornamen Lingkaran Transparan --}}
                        <div class="pointer-events-none absolute -top-24 -left-24 h-72 w-72 rounded-full border border-white/10 bg-white/5" aria-hidden="true"></div>
                        <div class="pointer-events-none absolute -right-20 -bottom-28 h-80 w-80 rounded-full border border-[#14B8A6]/20 bg-[#14B8A6]/10" aria-hidden="true"></div>
                        <div class="pointer-events-none absolute top-10 right-16 hidden h-20 w-20 rounded-full border border-white/10 lg:block" aria-hidden="true"></div>

                        <div class="relative mx-auto max-w-2xl">
                            <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1.5 text-xs font-bold uppercase tracking-widest text-[#14B8A6]">
                                Mulai Langkahmu
                            </span>

                            <h2 class="mt-5 text-3xl font-bold tracking-tight text-white sm:text-4xl lg:leading-tight">
                                Ada banyak cara untuk ikut membuka akses pendidikan.
                            </h2>

                            <p class="mt-4 text-base leading-relaxed text-white/85 sm:text-lg">
                                Bergabung sebagai relawan atau daftarkan ruang belajar yang kamu kelola.
                            </p>

                            <div class="mt-9 flex flex-col items-center justify-center gap-4 sm:flex-row">
                                {{-- Tombol Teal: Jadi Relawan --}}
                                <a
                                    href="{{ url('/registrasi?role=relawan') }}"
                                    class="group inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#14B8A6] px-7 py-3.5 text-sm font-semibold text-white shadow-md shadow-[#14B8A6]/25 transition-all duration-200 hover:-translate-y-0.5 hover:bg-[#0D9488] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#14B8A6] focus-visible:ring-offset-2 focus-visible:ring-offset-[#123B5D] sm:w-auto"
                                >
                                    <span>Jadi Relawan</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M5 12h14" />
                                        <path d="m12 5 7 7-7 7" />
                                    </svg>
                                </a>

                                {{-- Tombol Outline Transparan: Daftarkan Tempat --}}
                                <a
                                    href="{{ url('/registrasi?role=pengelola') }}"
                                    class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-white/30 bg-white/5 px-7 py-3.5 text-sm font-semibold text-white backdrop-blur-xs transition-all duration-200 hover:-translate-y-0.5 hover:border-white hover:bg-white/15 focus:outline-none focus-visible:ring-2 focus-visible:ring-white sm:w-auto"
                                >
                                    <span>Daftarkan Tempat</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        {{-- ============================================================
             G. FOOTER
             ============================================================ --}}
        <x-footer />

        @stack('scripts')
    </body>
</html>
