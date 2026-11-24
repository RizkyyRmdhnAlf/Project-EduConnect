
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tempat Belajar - EduConnect</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#F8FAFC]">

    <x-navbar active="tempat-belajar" />

    <main>

        {{-- HERO SECTION --}}
        <section class="relative isolate overflow-hidden bg-gradient-to-br from-[#123B5D] via-[#164E70] to-[#0F766E]">

            {{-- Decorative Background --}}
            <div class="pointer-events-none absolute -right-20 -top-24 h-80 w-80 rounded-full border-[40px] border-white/5"></div>
            <div class="pointer-events-none absolute -bottom-40 -left-20 h-96 w-96 rounded-full bg-white/5 blur-3xl"></div>

            <div class="relative mx-auto max-w-7xl px-6 py-20 sm:py-24 lg:px-8">

                <div class="max-w-3xl">

                    <div class="mb-6 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-2 backdrop-blur-sm">
                        <span class="h-2 w-2 rounded-full bg-[#5EEAD4]"></span>
                        <span class="text-xs font-semibold tracking-[0.15em] text-[#CCFBF1]">
                            JELAJAHI EDUCONNECT
                        </span>
                    </div>

                    <h1 class="text-4xl font-extrabold leading-tight tracking-tight text-white sm:text-5xl lg:text-6xl">
                        Temukan Ruang
                        <span class="text-[#5EEAD4]">Belajar</span>
                        Terbaikmu.
                    </h1>

                    <p class="mt-6 max-w-2xl text-base leading-8 text-blue-100 sm:text-lg">
                        Setiap orang berhak mendapatkan kesempatan belajar.
                        Temukan berbagai tempat dan komunitas belajar yang
                        sesuai dengan kebutuhanmu melalui EduConnect.
                    </p>

                    <div class="mt-9 flex flex-wrap items-center gap-4">

                        <a href="#daftar-tempat"
                           class="inline-flex items-center gap-2 rounded-xl bg-[#14B8A6] px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-black/10 transition duration-200 hover:-translate-y-1 hover:bg-[#0D9488]">
                            Jelajahi Tempat Belajar
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>

                        <span class="text-sm text-blue-100">
                            Temukan kesempatan belajar di sekitarmu.
                        </span>

                    </div>

                </div>

            </div>
        </section>


        {{-- CONTENT SECTION --}}
        <section id="daftar-tempat" class="mx-auto max-w-7xl px-6 py-16 lg:px-8">

            {{-- Section Heading --}}
            <div class="mb-10 flex flex-col justify-between gap-5 sm:flex-row sm:items-end">

                <div>
                    <div class="mb-3 flex items-center gap-2">
                        <span class="h-1 w-8 rounded-full bg-[#14B8A6]"></span>
                        <span class="text-xs font-bold uppercase tracking-[0.18em] text-[#14B8A6]">
                            Direktori Pendidikan
                        </span>
                    </div>

                    <h2 class="text-2xl font-extrabold tracking-tight text-[#123B5D] sm:text-3xl">
                        Jelajahi Tempat Belajar
                    </h2>

                    <p class="mt-3 max-w-xl text-sm leading-6 text-[#64748B] sm:text-base">
                        Berbagai pilihan tempat belajar untuk mendukung
                        perjalanan pendidikan dan pengembangan dirimu.
                    </p>
                </div>

                {{-- Total Data --}}
                <div class="flex items-center gap-3 rounded-2xl border border-[#E2E8F0] bg-white px-5 py-4 shadow-sm">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#CCFBF1] text-[#0F766E]">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 21h18M5 21V7l8-4v18m6 0V11l-6-4M9 9v.01M9 12v.01M9 15v.01M9 18v.01"/>
                        </svg>
                    </div>

                    <div>
                        <p class="text-2xl font-extrabold text-[#123B5D]">
                            {{ $learningPlaces->count() }}
                        </p>
                        <p class="text-xs font-medium text-[#64748B]">
                            Tempat Belajar
                        </p>
                    </div>

                </div>

            </div>

            <form action="{{ route('learning-places.index') }}" method="GET" role="search" aria-label="Cari tempat belajar"
                  class="mb-8 grid gap-4 rounded-2xl border border-[#E2E8F0] bg-white p-5 shadow-sm sm:grid-cols-2 lg:grid-cols-5">
                <div class="sm:col-span-2 lg:col-span-2">
                    <label for="search-keyword" class="mb-1.5 block text-xs font-semibold text-[#334155]">Kata kunci</label>
                    <input id="search-keyword" type="search" name="q" value="{{ $keyword }}"
                           placeholder="Nama, kategori, fasilitas..."
                           class="w-full rounded-xl border border-[#CBD5E1] bg-[#F8FAFC] px-3.5 py-2.5 text-sm text-[#123B5D] focus:border-[#14B8A6] focus:outline-none focus:ring-2 focus:ring-[#14B8A6]/20">
                </div>
                <div>
                    <label for="search-city" class="mb-1.5 block text-xs font-semibold text-[#334155]">Kota</label>
                    <input id="search-city" type="text" name="kota" value="{{ $cityFilter }}"
                           placeholder="Contoh: Bandung"
                           class="w-full rounded-xl border border-[#CBD5E1] bg-[#F8FAFC] px-3.5 py-2.5 text-sm text-[#123B5D] focus:border-[#14B8A6] focus:outline-none focus:ring-2 focus:ring-[#14B8A6]/20">
                </div>
                <div>
                    <label for="search-district" class="mb-1.5 block text-xs font-semibold text-[#334155]">Kabupaten</label>
                    <input id="search-district" type="text" name="kabupaten" value="{{ $districtFilter }}"
                           placeholder="Contoh: Sleman"
                           class="w-full rounded-xl border border-[#CBD5E1] bg-[#F8FAFC] px-3.5 py-2.5 text-sm text-[#123B5D] focus:border-[#14B8A6] focus:outline-none focus:ring-2 focus:ring-[#14B8A6]/20">
                </div>
                <div>
                    <label for="search-price" class="mb-1.5 block text-xs font-semibold text-[#334155]">Harga</label>
                    <select id="search-price" name="harga"
                            class="w-full rounded-xl border border-[#CBD5E1] bg-[#F8FAFC] px-3.5 py-2.5 text-sm text-[#123B5D] focus:border-[#14B8A6] focus:outline-none focus:ring-2 focus:ring-[#14B8A6]/20">
                        <option value="">Semua harga</option>
                        <option value="gratis" @selected($priceFilter === 'gratis')>Gratis</option>
                        <option value="berbayar" @selected($priceFilter === 'berbayar')>Berbayar</option>
                    </select>
                </div>
                @if($locationFilter !== '')
                    <input type="hidden" name="lokasi" value="{{ $locationFilter }}">
                @endif
                <div class="flex items-end gap-2 sm:col-span-2 lg:col-span-5">
                    <button type="submit"
                            class="inline-flex items-center justify-center rounded-xl bg-[#123B5D] px-5 py-2.5 text-sm font-bold text-white transition hover:bg-[#0D9488]">
                        Cari Tempat
                    </button>
                    <a href="{{ route('learning-places.index') }}"
                       class="inline-flex items-center justify-center rounded-xl border border-[#CBD5E1] px-5 py-2.5 text-sm font-semibold text-[#334155] transition hover:bg-[#F8FAFC]">
                        Reset
                    </a>
                </div>
            </form>


            {{-- Active Search / Filter Indicator --}}
            @if(!empty($keyword) || !empty($locationFilter) || !empty($cityFilter) || !empty($districtFilter) || !empty($priceFilter))
                <div class="mb-8 flex flex-wrap items-center justify-between gap-3 rounded-2xl border border-[#14B8A6]/30 bg-[#EAF6F4] px-5 py-3.5 text-sm text-[#123B5D]">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="font-semibold">Menampilkan hasil pencarian</span>
                        @if(!empty($keyword))
                            <span class="rounded-lg bg-white px-2.5 py-1 text-xs font-bold text-[#0D9488]">Kata kunci: "{{ $keyword }}"</span>
                        @endif
                        @if(!empty($locationFilter))
                            <span class="rounded-lg bg-white px-2.5 py-1 text-xs font-bold text-[#0D9488]">Lokasi: {{ $locationFilter }}</span>
                        @endif
                        @if(!empty($cityFilter))
                            <span class="rounded-lg bg-white px-2.5 py-1 text-xs font-bold text-[#0D9488]">Kota: {{ $cityFilter }}</span>
                        @endif
                        @if(!empty($districtFilter))
                            <span class="rounded-lg bg-white px-2.5 py-1 text-xs font-bold text-[#0D9488]">Kabupaten: {{ $districtFilter }}</span>
                        @endif
                        @if($priceFilter === 'gratis' || $priceFilter === 'berbayar')
                            <span class="rounded-lg bg-white px-2.5 py-1 text-xs font-bold text-[#0D9488]">Harga: {{ ucfirst($priceFilter) }}</span>
                        @endif
                    </div>
                    <a href="{{ route('learning-places.index') }}" class="text-xs font-bold text-[#14B8A6] hover:underline">
                        Reset Filter
                    </a>
                </div>
            @endif

            {{-- Learning Places Grid --}}
            @forelse ($learningPlaces as $place)

                @if ($loop->first)
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @endif

                    <x-place-card :place="$place" />

                @if ($loop->last)
                    </div>
                @endif

            @empty

                {{-- Empty State --}}
                <div class="rounded-3xl border border-dashed border-[#CBD5E1] bg-white px-6 py-20 text-center">

                    <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl bg-[#F1F5F9]">
                        <svg class="h-10 w-10 text-[#94A3B8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 21h18M5 21V7l8-4v18m6 0V11l-6-4M9 9v.01M9 12v.01M9 15v.01"/>
                        </svg>
                    </div>

                    <h3 class="mt-6 text-xl font-bold text-[#123B5D]">
                        Belum Ada Tempat Belajar
                    </h3>

                    <p class="mx-auto mt-3 max-w-md text-sm leading-6 text-[#64748B]">
                        Saat ini belum ada tempat belajar yang tersedia.
                        Silakan kunjungi kembali halaman ini nanti untuk
                        menemukan berbagai pilihan tempat belajar.
                    </p>

                    <div class="mt-6 inline-flex items-center gap-2 rounded-full bg-[#F0FDFA] px-4 py-2 text-xs font-semibold text-[#0F766E]">
                        <span class="h-2 w-2 rounded-full bg-[#14B8A6]"></span>
                        Data tempat belajar akan ditampilkan di sini
                    </div>

                </div>

            @endforelse

        </section>

    </main>

    <x-footer />

</body>
</html>
