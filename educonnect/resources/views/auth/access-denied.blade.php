<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Akses Ditolak — EduConnect</title>

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="flex min-h-screen flex-col bg-[#F8FAFC] font-sans text-[#334155] antialiased">
        <x-navbar active="" />

        <main id="main-content" class="flex flex-1 items-center justify-center px-4 py-16 sm:px-6 lg:px-8">
            <div class="w-full max-w-lg rounded-3xl border border-[#E2E8F0] bg-white p-8 text-center shadow-xl shadow-[#123B5D]/5 sm:p-12">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-red-50 text-red-600 ring-1 ring-red-200">
                    {{-- Lucide ShieldAlert Icon --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z" />
                        <path d="M12 8v4" />
                        <path d="M12 16h.01" />
                    </svg>
                </div>

                <span class="mt-5 inline-flex items-center rounded-full bg-red-50 px-3 py-1 text-xs font-bold uppercase tracking-wider text-red-700">
                    403 &bull; Akses Ditolak
                </span>

                <h1 class="mt-4 text-2xl font-extrabold tracking-tight text-[#123B5D] sm:text-3xl">
                    Halaman Ini Membutuhkan Izin Khusus
                </h1>

                <p class="mt-3 text-sm leading-relaxed text-[#334155] sm:text-base">
                    {{ $reason ?? 'Maaf, peran akun Anda saat ini tidak memiliki hak akses untuk membuka halaman tersebut.' }}
                </p>

                @auth
                    <div class="mt-6 rounded-2xl border border-[#E2E8F0] bg-[#F8FAFC] p-4 text-xs text-[#334155]">
                        <span>Masuk sebagai:</span>
                        <strong class="font-bold text-[#123B5D]">{{ auth()->user()->display_name }}</strong>
                        <span class="ml-1 rounded-md bg-[#EAF6F4] px-2 py-0.5 font-semibold text-[#0D9488]">
                            {{ auth()->user()->role?->label() }}
                        </span>
                    </div>
                @endauth

                <div class="mt-8 flex flex-col items-center justify-center gap-3 sm:flex-row">
                    @auth
                        <a
                            href="{{ route('dashboard') }}"
                            class="inline-flex w-full items-center justify-center rounded-xl bg-[#123B5D] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[#14B8A6] sm:w-auto"
                        >
                            Kembali ke Dashboard Saya
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="inline-flex w-full items-center justify-center rounded-xl bg-[#123B5D] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[#14B8A6] sm:w-auto"
                        >
                            Masuk ke Akun
                        </a>
                    @endauth

                    <a
                        href="{{ route('home') }}"
                        class="inline-flex w-full items-center justify-center rounded-xl border border-[#E2E8F0] bg-white px-6 py-3 text-sm font-semibold text-[#123B5D] transition hover:bg-[#F8FAFC] sm:w-auto"
                    >
                        Ke Beranda
                    </a>
                </div>
            </div>
        </main>

        <x-footer />
    </body>
</html>
