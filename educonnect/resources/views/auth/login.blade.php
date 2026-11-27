<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Masuk ke akun EduConnect untuk mengelola ruang belajar, menawarkan bantuan relawan, atau melaporkan kebutuhan pendidikan.">

        <title>Masuk — EduConnect</title>

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="flex min-h-screen flex-col bg-[#F8FAFC] font-sans text-[#334155] antialiased selection:bg-[#14B8A6]/20 selection:text-[#123B5D]">
        <a
            href="#main-content"
            class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-[100] focus:rounded-xl focus:bg-[#123B5D] focus:px-4 focus:py-2.5 focus:text-sm focus:font-semibold focus:text-white focus:shadow-lg focus:outline-none focus:ring-2 focus:ring-[#14B8A6]"
        >
            Lewati ke konten utama
        </a>

        <x-navbar active="login" />

        <main id="main-content" class="flex flex-1 items-center py-12 sm:py-16 lg:py-20">
            <div class="mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 items-stretch overflow-hidden rounded-3xl border border-[#E2E8F0] bg-white shadow-xl shadow-[#123B5D]/5 lg:grid-cols-12">
                    {{-- Kolom Kiri: Visual & Informasi Ekosistem --}}
                    <div class="relative flex flex-col justify-between overflow-hidden bg-[#123B5D] p-8 text-white sm:p-10 lg:col-span-5 lg:p-12">
                        <div class="pointer-events-none absolute -top-20 -right-20 h-64 w-64 rounded-full bg-[#14B8A6]/15 blur-2xl" aria-hidden="true"></div>
                        <div class="pointer-events-none absolute -bottom-24 -left-16 h-72 w-72 rounded-full border border-white/10 bg-white/5" aria-hidden="true"></div>

                        <div class="relative">
                            <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3.5 py-1.5 text-xs font-bold uppercase tracking-widest text-[#14B8A6]">
                                <span class="h-2 w-2 rounded-full bg-[#14B8A6]" aria-hidden="true"></span>
                                <span>Akses Ekosistem</span>
                            </span>

                            <h1 class="mt-6 text-3xl font-extrabold tracking-tight text-white sm:text-4xl lg:leading-tight">
                                Satu koneksi untuk membuka masa depan.
                            </h1>

                            <p class="mt-4 text-sm leading-relaxed text-white/80 sm:text-base">
                                Masuk ke dashboard Anda untuk mencari tempat belajar, mengajukan kebutuhan pendidikan, menawarkan bantuan relawan, atau mengelola lokasi belajar.
                            </p>
                        </div>

                        {{-- Quick Fill Demo Accounts (4 Role) --}}
                        <div class="relative mt-10 rounded-2xl border border-white/15 bg-white/5 p-5 backdrop-blur-xs">
                            <p class="text-xs font-bold uppercase tracking-wider text-[#14B8A6]">
                                Akun Demo Pengujian (Klik untuk Isi Otomatis)
                            </p>
                            <p class="mt-1 text-xs text-white/75">
                                Kata sandi seluruh akun demo: <code class="rounded bg-white/15 px-1.5 py-0.5 font-mono text-white">password</code>
                            </p>
                            <div class="mt-3.5 grid grid-cols-1 gap-2 sm:grid-cols-2">
                                <button
                                    type="button"
                                    data-demo-email="pelajar@educonnect.id"
                                    class="demo-account-btn flex flex-col rounded-xl border border-white/15 bg-white/5 px-3 py-2 text-left transition hover:border-[#14B8A6] hover:bg-white/10"
                                >
                                    <span class="text-xs font-bold text-white">Pelajar / Siswa</span>
                                    <span class="truncate text-[11px] text-white/70">pelajar@educonnect.id</span>
                                </button>
                                <button
                                    type="button"
                                    data-demo-email="relawan@educonnect.id"
                                    class="demo-account-btn flex flex-col rounded-xl border border-white/15 bg-white/5 px-3 py-2 text-left transition hover:border-[#14B8A6] hover:bg-white/10"
                                >
                                    <span class="text-xs font-bold text-white">Relawan / Komunitas</span>
                                    <span class="truncate text-[11px] text-white/70">relawan@educonnect.id</span>
                                </button>
                                <button
                                    type="button"
                                    data-demo-email="pengelola@educonnect.id"
                                    class="demo-account-btn flex flex-col rounded-xl border border-white/15 bg-white/5 px-3 py-2 text-left transition hover:border-[#14B8A6] hover:bg-white/10"
                                >
                                    <span class="text-xs font-bold text-white">Pengelola Tempat</span>
                                    <span class="truncate text-[11px] text-white/70">pengelola@educonnect.id</span>
                                </button>
                                <button
                                    type="button"
                                    data-demo-email="admin@educonnect.id"
                                    class="demo-account-btn flex flex-col rounded-xl border border-white/15 bg-white/5 px-3 py-2 text-left transition hover:border-[#14B8A6] hover:bg-white/10"
                                >
                                    <span class="text-xs font-bold text-white">Administrator</span>
                                    <span class="truncate text-[11px] text-white/70">admin@educonnect.id</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Kolom Kanan: Form Login --}}
                    <div class="flex flex-col justify-center p-8 sm:p-10 lg:col-span-7 lg:p-14">
                        <div class="mx-auto w-full max-w-md">
                            <span class="text-xs font-bold uppercase tracking-[0.2em] text-[#14B8A6]">
                                Selamat Datang Kembali
                            </span>
                            <h2 class="mt-2 text-2xl font-bold tracking-tight text-[#123B5D] sm:text-3xl">
                                Masuk ke Akun EduConnect
                            </h2>
                            <p class="mt-2 text-sm leading-relaxed text-[#334155]">
                                Masukkan alamat email dan kata sandi yang terdaftar pada akun Anda.
                            </p>

                            @if (session('status'))
                                <div
                                    role="status"
                                    aria-live="polite"
                                    class="mt-6 rounded-2xl border border-[#99D5CF] bg-[#EAF6F4] px-4 py-3 text-sm text-[#123B5D]"
                                >
                                    {{ session('status') }}
                                </div>
                            @endif

                            {{-- Pesan Error Terstruktur --}}
                            @if ($errors->any())
                                <div
                                    role="alert"
                                    aria-live="polite"
                                    class="mt-6 rounded-2xl border border-red-200 bg-red-50/90 p-4 text-red-800"
                                >
                                    <div class="flex items-start gap-3">
                                        <div class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-red-100 text-red-600">
                                            {{-- Lucide AlertCircle Icon --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <circle cx="12" cy="12" r="10" />
                                                <line x1="12" x2="12" y1="8" y2="12" />
                                                <line x1="12" x2="12.01" y1="16" y2="16" />
                                            </svg>
                                        </div>
                                        <div class="text-sm">
                                            <p class="font-bold text-red-900">Tidak dapat masuk ke akun</p>
                                            <ul class="mt-1.5 list-disc space-y-1 pl-4 text-xs leading-relaxed text-red-700">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('login.store') }}" class="mt-7 space-y-5" novalidate>
                                @csrf

                                {{-- Field Email --}}
                                <div>
                                    <label for="email" class="block text-sm font-semibold text-[#123B5D]">
                                        Alamat Email
                                    </label>
                                    <div class="relative mt-2">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#334155]/60">
                                            {{-- Lucide Mail Icon --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <rect width="20" height="16" x="2" y="4" rx="2" />
                                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                                            </svg>
                                        </div>
                                        <input
                                            id="email"
                                            type="email"
                                            name="email"
                                            value="{{ old('email') }}"
                                            required
                                            autofocus
                                            autocomplete="email"
                                            placeholder="nama@email.com"
                                            @class([
                                                'w-full rounded-xl border py-3 pr-4 pl-11 text-sm text-[#123B5D] placeholder:text-[#334155]/50 transition focus:bg-white focus:outline-none focus:ring-2',
                                                'border-red-300 bg-red-50/40 focus:border-red-500 focus:ring-red-500/20' => $errors->has('email'),
                                                'border-[#E2E8F0] bg-[#F8FAFC] focus:border-[#14B8A6] focus:ring-[#14B8A6]/20' => ! $errors->has('email'),
                                            ])
                                        />
                                    </div>
                                    @error('email')
                                        <p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Field Password --}}
                                <div>
                                    <div class="flex items-center justify-between">
                                        <label for="password" class="block text-sm font-semibold text-[#123B5D]">
                                            Kata Sandi
                                        </label>
                                    </div>
                                    <div class="relative mt-2">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#334155]/60">
                                            {{-- Lucide Lock Icon --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                                                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                            </svg>
                                        </div>
                                        <input
                                            id="password"
                                            type="password"
                                            name="password"
                                            required
                                            autocomplete="current-password"
                                            placeholder="Masukkan kata sandi Anda"
                                            @class([
                                                'w-full rounded-xl border py-3 pr-11 pl-11 text-sm text-[#123B5D] placeholder:text-[#334155]/50 transition focus:bg-white focus:outline-none focus:ring-2',
                                                'border-red-300 bg-red-50/40 focus:border-red-500 focus:ring-red-500/20' => $errors->has('password'),
                                                'border-[#E2E8F0] bg-[#F8FAFC] focus:border-[#14B8A6] focus:ring-[#14B8A6]/20' => ! $errors->has('password'),
                                            ])
                                        />
                                        <button
                                            type="button"
                                            id="toggle-password"
                                            aria-label="Tampilkan kata sandi"
                                            aria-pressed="false"
                                            class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-[#334155]/60 hover:text-[#123B5D] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#14B8A6] rounded-r-xl"
                                        >
                                            {{-- Ikon Mata --}}
                                            <svg
                                                id="eye-open"
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                aria-hidden="true"
                                            >
                                                <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                                                <circle cx="12" cy="12" r="3" />
                                            </svg>

                                            {{-- Ikon Mata Dicoret --}}
                                            <svg
                                                id="eye-closed"
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="hidden h-5 w-5"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                aria-hidden="true"
                                            >
                                                <path d="M3 3l18 18" />
                                                <path d="M10.58 10.58a2 2 0 0 0 2.83 2.83" />
                                                <path d="M9.88 5.09A10.77 10.77 0 0 1 12 4.8c5.2 0 9.27 3.11 10.5 7.2a10.9 10.9 0 0 1-4.1 5.5" />
                                                <path d="M6.61 6.61A11.7 11.7 0 0 0 1.5 12c1.23 4.09 5.3 7.2 10.5 7.2 1.17 0 2.28-.19 3.31-.55" />
                                            </svg>
                                        </button>
                                    </div>
                                    @error('password')
                                        <p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Checkbox Remember Me --}}
                                <div class="flex items-center justify-between">
                                    <label for="remember" class="inline-flex cursor-pointer items-center gap-2.5 text-sm text-[#334155]">
                                        <input
                                            id="remember"
                                            type="checkbox"
                                            name="remember"
                                            value="1"
                                            @checked(old('remember'))
                                            class="h-4 w-4 rounded border-[#E2E8F0] text-[#14B8A6] focus:ring-[#14B8A6]"
                                        />
                                        <span>Ingat saya di perangkat ini</span>
                                    </label>
                                </div>

                                {{-- Tombol Masuk --}}
                                <button
                                    type="submit"
                                    class="group inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#123B5D] px-6 py-3.5 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:bg-[#14B8A6] hover:shadow-md focus:outline-none focus-visible:ring-2 focus-visible:ring-[#14B8A6] focus-visible:ring-offset-2"
                                >
                                    <span>Masuk</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M5 12h14" />
                                        <path d="m12 5 7 7-7 7" />
                                    </svg>
                                </button>
                            </form>

                            {{-- Link Registrasi --}}
                            <div class="mt-8 border-t border-[#E2E8F0] pt-6 text-center">
                                <p class="text-sm text-[#334155]">
                                    Belum memiliki akun EduConnect?
                                    <a
                                        href="{{ route('register') }}"
                                        class="font-bold text-[#14B8A6] underline-offset-4 transition hover:text-[#0D9488] hover:underline"
                                    >
                                        Daftar sekarang
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <x-footer />

        @stack('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const emailInput = document.getElementById('email');
                const passwordInput = document.getElementById('password');
                const toggleBtn = document.getElementById('toggle-password');

                if (toggleBtn && passwordInput) {
                    const eyeOpen = document.getElementById('eye-open');
                    const eyeClosed = document.getElementById('eye-closed');

                    toggleBtn.addEventListener('click', function () {
                        const isPassword = passwordInput.type === 'password';

                        passwordInput.type = isPassword ? 'text' : 'password';

                        if (eyeOpen && eyeClosed) {
                            eyeOpen.classList.toggle('hidden', !isPassword);
                            eyeClosed.classList.toggle('hidden', isPassword);
                        }

                        toggleBtn.setAttribute(
                            'aria-label',
                            isPassword ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'
                        );
                        toggleBtn.setAttribute('aria-pressed', String(isPassword));
                    });
                }

                document.querySelectorAll('.demo-account-btn').forEach(function (btn) {
                    btn.addEventListener('click', function () {
                        if (emailInput && passwordInput) {
                            emailInput.value = btn.getAttribute('data-demo-email') || '';
                            passwordInput.value = 'password';
                            emailInput.focus();
                        }
                    });
                });
            });
        </script>
    </body>
</html>
