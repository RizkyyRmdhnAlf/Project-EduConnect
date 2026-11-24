<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Tempat Belajar Tidak Ditemukan — EduConnect</title>

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="flex min-h-screen flex-col bg-[#F8FAFC] font-sans text-[#334155] antialiased">
        <x-navbar active="tempat-belajar" />

        <main id="main-content" class="flex flex-1 items-center justify-center px-4 py-16 sm:px-6 lg:px-8">
            <div class="w-full max-w-lg rounded-3xl border border-[#E2E8F0] bg-white p-8 text-center shadow-xl shadow-[#123B5D]/5 sm:p-12">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-[#EAF6F4] text-[#14B8A6]">
                    {{-- Lucide MapPinOff / Compass Icon --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0" />
                        <circle cx="12" cy="10" r="3" />
                    </svg>
                </div>

                <span class="mt-5 inline-flex items-center rounded-full bg-[#EAF6F4] px-3.5 py-1 text-xs font-bold uppercase tracking-wider text-[#0D9488]">
                    404 &bull; Lokasi Tidak Ditemukan
                </span>

                <h1 class="mt-4 text-2xl font-extrabold tracking-tight text-[#123B5D] sm:text-3xl">
                    Tempat belajar tidak ditemukan
                </h1>

                <p class="mt-3 text-sm leading-relaxed text-[#334155] sm:text-base">
                    Maaf, lokasi belajar dengan tautan <code class="rounded bg-[#F8FAFC] px-1.5 py-0.5 font-mono text-xs text-[#123B5D]">{{ $slug }}</code> tidak tersedia atau telah dihapus dari direktori.
                </p>

                <div class="mt-8 flex flex-col items-center justify-center gap-3 sm:flex-row">
                    <a
                        href="{{ route('learning-places.index') }}"
                        class="inline-flex w-full items-center justify-center rounded-xl bg-[#14B8A6] px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#0D9488] sm:w-auto"
                    >
                        Jelajahi Semua Tempat
                    </a>
                    <a
                        href="{{ route('home') }}"
                        class="inline-flex w-full items-center justify-center rounded-xl border border-[#E2E8F0] bg-white px-6 py-3 text-sm font-semibold text-[#123B5D] transition hover:bg-[#F8FAFC] sm:w-auto"
                    >
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </main>

        <x-footer />
    </body>
</html>
