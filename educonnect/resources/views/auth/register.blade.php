@php
    $currentRole = old('role', $selectedRole ?? 'pelajar');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Daftar akun EduConnect sebagai Pelajar, Relawan/Komunitas, atau Pengelola Tempat Belajar.">

        <title>Registrasi Akun — EduConnect</title>

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

        <x-navbar active="register" />

        <main id="main-content" class="flex-1 py-12 sm:py-16 lg:py-20">
            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
                {{-- Header Registrasi --}}
                <div class="text-center">
                    <div class="inline-flex items-center gap-2 rounded-full border border-[#14B8A6]/25 bg-[#EAF6F4] px-4 py-1.5 text-xs font-bold uppercase tracking-widest text-[#0D9488]">
                        <span class="h-2 w-2 rounded-full bg-[#14B8A6]" aria-hidden="true"></span>
                        <span>Bergabung Bersama Komunitas</span>
                    </div>
                    <h1 class="mt-4 text-3xl font-extrabold tracking-tight text-[#123B5D] sm:text-4xl">
                        Buat Akun EduConnect Anda
                    </h1>
                    <p class="mx-auto mt-3 max-w-2xl text-base leading-relaxed text-[#334155]">
                        Pilih peran yang sesuai dengan tujuan Anda. Formulir pendaftaran akan menyesuaikan kebutuhan informasi berdasarkan peran yang dipilih.
                    </p>
                </div>

                {{-- Form Card --}}
                <div class="mt-10 overflow-hidden rounded-3xl border border-[#E2E8F0] bg-white p-6 shadow-xl shadow-[#123B5D]/5 sm:p-10 lg:p-12">
                    {{-- Pesan Error Terstruktur --}}
                    @if ($errors->any())
                        <div
                            role="alert"
                            aria-live="polite"
                            class="mb-8 rounded-2xl border border-red-200 bg-red-50/90 p-4 text-red-800"
                        >
                            <div class="flex items-start gap-3">
                                <div class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-red-100 text-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <circle cx="12" cy="12" r="10" />
                                        <line x1="12" x2="12" y1="8" y2="12" />
                                        <line x1="12" x2="12.01" y1="16" y2="16" />
                                    </svg>
                                </div>
                                <div class="text-sm">
                                    <p class="font-bold text-red-900">Mohon periksa kembali data pendaftaran Anda</p>
                                    <ul class="mt-1.5 list-disc space-y-1 pl-4 text-xs leading-relaxed text-red-700">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register.store') }}" id="registration-form" novalidate>
                        @csrf

                        {{-- 1. Pemilihan Peran Pengguna (3 Role: Pelajar, Relawan, Pengelola) --}}
                        <fieldset>
                            <legend class="text-sm font-bold uppercase tracking-wider text-[#123B5D]">
                                1. Pilih Peran Anda di EduConnect
                            </legend>
                            <p class="mt-1 text-xs text-[#334155]/80">
                                Pendaftaran publik tersedia untuk Pelajar, Relawan/Komunitas, dan Pengelola Tempat Belajar.
                            </p>

                            <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-3">
                                {{-- Role 1: Pelajar / Siswa --}}
                                <label
                                    for="role-pelajar"
                                    data-role-card="pelajar"
                                    class="role-card group relative flex cursor-pointer flex-col justify-between rounded-2xl border-2 p-5 transition-all duration-200 hover:-translate-y-0.5"
                                >
                                    <input
                                        type="radio"
                                        id="role-pelajar"
                                        name="role"
                                        value="pelajar"
                                        class="sr-only"
                                        @checked($currentRole === 'pelajar')
                                    />
                                    <div>
                                        <div class="flex items-center justify-between">
                                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#EAF6F4] text-[#14B8A6]">
                                                {{-- Lucide BookOpen Icon --}}
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                    <path d="M12 7v14" />
                                                    <path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z" />
                                                </svg>
                                            </span>
                                            <span class="role-check-badge flex h-5 w-5 items-center justify-center rounded-full border border-[#E2E8F0]">
                                                <span class="role-check-dot h-2.5 w-2.5 rounded-full bg-[#14B8A6] opacity-0 transition-opacity"></span>
                                            </span>
                                        </div>
                                        <span class="mt-4 block text-base font-bold text-[#123B5D]">
                                            Pelajar / Siswa
                                        </span>
                                        <span class="mt-1 block text-xs leading-relaxed text-[#334155]">
                                            Cari tempat belajar nyaman dan laporkan kebutuhan pendidikanmu.
                                        </span>
                                    </div>
                                </label>

                                {{-- Role 2: Relawan / Komunitas --}}
                                <label
                                    for="role-relawan"
                                    data-role-card="relawan"
                                    class="role-card group relative flex cursor-pointer flex-col justify-between rounded-2xl border-2 p-5 transition-all duration-200 hover:-translate-y-0.5"
                                >
                                    <input
                                        type="radio"
                                        id="role-relawan"
                                        name="role"
                                        value="relawan"
                                        class="sr-only"
                                        @checked($currentRole === 'relawan')
                                    />
                                    <div>
                                        <div class="flex items-center justify-between">
                                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#EAF6F4] text-[#14B8A6]">
                                                {{-- Lucide HeartHandshake Icon --}}
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                    <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
                                                    <path d="M12 5 9.04 7.96a2.17 2.17 0 0 0 0 3.08c.82.82 2.13.85 3 .07l2.07-1.9a2.82 2.82 0 0 1 3.79 0l2.96 2.66" />
                                                </svg>
                                            </span>
                                            <span class="role-check-badge flex h-5 w-5 items-center justify-center rounded-full border border-[#E2E8F0]">
                                                <span class="role-check-dot h-2.5 w-2.5 rounded-full bg-[#14B8A6] opacity-0 transition-opacity"></span>
                                            </span>
                                        </div>
                                        <span class="mt-4 block text-base font-bold text-[#123B5D]">
                                            Relawan / Komunitas
                                        </span>
                                        <span class="mt-1 block text-xs leading-relaxed text-[#334155]">
                                            Tawarkan bantuan mengajar, pendampingan, atau sumber belajar.
                                        </span>
                                    </div>
                                </label>

                                {{-- Role 3: Pengelola Tempat Belajar --}}
                                <label
                                    for="role-pengelola"
                                    data-role-card="pengelola"
                                    class="role-card group relative flex cursor-pointer flex-col justify-between rounded-2xl border-2 p-5 transition-all duration-200 hover:-translate-y-0.5"
                                >
                                    <input
                                        type="radio"
                                        id="role-pengelola"
                                        name="role"
                                        value="pengelola"
                                        class="sr-only"
                                        @checked($currentRole === 'pengelola')
                                    />
                                    <div>
                                        <div class="flex items-center justify-between">
                                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#EAF6F4] text-[#14B8A6]">
                                                {{-- Lucide Building2 Icon --}}
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                    <path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z" />
                                                    <path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2" />
                                                    <path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2" />
                                                    <path d="M10 6h4" />
                                                    <path d="M10 10h4" />
                                                    <path d="M10 14h4" />
                                                    <path d="M10 18h4" />
                                                </svg>
                                            </span>
                                            <span class="role-check-badge flex h-5 w-5 items-center justify-center rounded-full border border-[#E2E8F0]">
                                                <span class="role-check-dot h-2.5 w-2.5 rounded-full bg-[#14B8A6] opacity-0 transition-opacity"></span>
                                            </span>
                                        </div>
                                        <span class="mt-4 block text-base font-bold text-[#123B5D]">
                                            Pengelola Tempat Belajar
                                        </span>
                                        <span class="mt-1 block text-xs leading-relaxed text-[#334155]">
                                            Daftarkan dan kelola rumah baca, perpustakaan, atau ruang komunitas.
                                        </span>
                                    </div>
                                </label>
                            </div>
                            @error('role')
                                <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                            @enderror
                        </fieldset>

                        {{-- Banner Kontekstual yang Berubah Sesuai Role --}}
                        <div class="mt-6 flex items-center justify-between gap-4 rounded-2xl border border-[#14B8A6]/25 bg-[#EAF6F4]/70 px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-[#14B8A6] text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z" />
                                        <path d="m9 12 2 2 4-4" />
                                    </svg>
                                </span>
                                <p id="role-context-banner" class="text-xs font-medium text-[#123B5D] sm:text-sm">
                                    Anda mendaftar sebagai <strong>Pelajar / Siswa</strong> untuk mencari ruang belajar dan melaporkan kebutuhan pendidikan.
                                </p>
                            </div>
                        </div>

                        {{-- 2. Data Profil & Konteks Role --}}
                        <div class="mt-8 border-t border-[#E2E8F0] pt-8">
                            <h2 class="text-sm font-bold uppercase tracking-wider text-[#123B5D]">
                                2. Informasi Akun &amp; Detail Peran
                            </h2>

                            <div class="mt-5 grid grid-cols-1 gap-6 sm:grid-cols-2">
                                {{-- Nama Lengkap / Komunitas / Pengelola (display_name di ERD) --}}
                                <div>
                                    <label for="display_name" id="label-display-name" class="block text-sm font-semibold text-[#123B5D]">
                                        Nama Lengkap Pelajar
                                    </label>
                                    <input
                                        id="display_name"
                                        type="text"
                                        name="display_name"
                                        value="{{ old('display_name') }}"
                                        required
                                        autocomplete="name"
                                        placeholder="Contoh: Nadia Putri"
                                        @class([
                                            'mt-2 w-full rounded-xl border px-4 py-3 text-sm text-[#123B5D] placeholder:text-[#334155]/50 transition focus:bg-white focus:outline-none focus:ring-2',
                                            'border-red-300 bg-red-50/40 focus:border-red-500 focus:ring-red-500/20' => $errors->has('display_name'),
                                            'border-[#E2E8F0] bg-[#F8FAFC] focus:border-[#14B8A6] focus:ring-[#14B8A6]/20' => ! $errors->has('display_name'),
                                        ])
                                    />
                                    @error('display_name')
                                        <p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Email --}}
                                <div>
                                    <label for="email" class="block text-sm font-semibold text-[#123B5D]">
                                        Alamat Email
                                    </label>
                                    <input
                                        id="email"
                                        type="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        required
                                        autocomplete="email"
                                        placeholder="nama@email.com"
                                        @class([
                                            'mt-2 w-full rounded-xl border px-4 py-3 text-sm text-[#123B5D] placeholder:text-[#334155]/50 transition focus:bg-white focus:outline-none focus:ring-2',
                                            'border-red-300 bg-red-50/40 focus:border-red-500 focus:ring-red-500/20' => $errors->has('email'),
                                            'border-[#E2E8F0] bg-[#F8FAFC] focus:border-[#14B8A6] focus:ring-[#14B8A6]/20' => ! $errors->has('email'),
                                        ])
                                    />
                                    @error('email')
                                        <p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Field Dinamis Sesuai Role: Asal Sekolah / Fokus Relawan / Nama Tempat Belajar --}}
                                <div>
                                    <label for="institution" id="label-institution" class="block text-sm font-semibold text-[#123B5D]">
                                        Asal Sekolah / Jenjang Pendidikan
                                    </label>
                                    <input
                                        id="institution"
                                        type="text"
                                        name="institution"
                                        value="{{ old('institution') }}"
                                        required
                                        placeholder="Contoh: SMAN 70 Jakarta (Kelas 11)"
                                        @class([
                                            'mt-2 w-full rounded-xl border px-4 py-3 text-sm text-[#123B5D] placeholder:text-[#334155]/50 transition focus:bg-white focus:outline-none focus:ring-2',
                                            'border-red-300 bg-red-50/40 focus:border-red-500 focus:ring-red-500/20' => $errors->has('institution'),
                                            'border-[#E2E8F0] bg-[#F8FAFC] focus:border-[#14B8A6] focus:ring-[#14B8A6]/20' => ! $errors->has('institution'),
                                        ])
                                    />
                                    <p id="hint-institution" class="mt-1 text-xs text-[#334155]/75">
                                        Cantumkan sekolah, kampus, atau jenjang pendidikan Anda saat ini.
                                    </p>
                                    @error('institution')
                                        <p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Lokasi / Kota --}}
                                <div>
                                    <label for="location" id="label-location" class="block text-sm font-semibold text-[#123B5D]">
                                        Kota / Domisili Belajar
                                    </label>
                                    <input
                                        id="location"
                                        type="text"
                                        name="location"
                                        value="{{ old('location') }}"
                                        required
                                        placeholder="Contoh: Jakarta Selatan"
                                        @class([
                                            'mt-2 w-full rounded-xl border px-4 py-3 text-sm text-[#123B5D] placeholder:text-[#334155]/50 transition focus:bg-white focus:outline-none focus:ring-2',
                                            'border-red-300 bg-red-50/40 focus:border-red-500 focus:ring-red-500/20' => $errors->has('location'),
                                            'border-[#E2E8F0] bg-[#F8FAFC] focus:border-[#14B8A6] focus:ring-[#14B8A6]/20' => ! $errors->has('location'),
                                        ])
                                    />
                                    @error('location')
                                        <p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Bio / Deskripsi Dinamis --}}
                                <div class="sm:col-span-2">
                                    <label for="bio" id="label-bio" class="block text-sm font-semibold text-[#123B5D]">
                                        Kebutuhan Belajar Utama (Opsional)
                                    </label>
                                    <textarea
                                        id="bio"
                                        name="bio"
                                        rows="3"
                                        placeholder="Ceritakan singkat fasilitas ruang belajar atau pendampingan yang sedang kamu butuhkan..."
                                        class="mt-2 w-full rounded-xl border border-[#E2E8F0] bg-[#F8FAFC] px-4 py-3 text-sm text-[#123B5D] placeholder:text-[#334155]/50 transition focus:border-[#14B8A6] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#14B8A6]/20"
                                    >{{ old('bio') }}</textarea>
                                    @error('bio')
                                        <p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Kata Sandi --}}
                                <div>
                                    <label for="password" class="block text-sm font-semibold text-[#123B5D]">
                                        Kata Sandi
                                    </label>
                                    <div class="relative mt-2">
                                        <input
                                            id="password"
                                            type="password"
                                            name="password"
                                            required
                                            autocomplete="new-password"
                                            placeholder="Minimal 8 karakter"
                                            @class([
                                                'w-full rounded-xl border py-3 pr-11 pl-4 text-sm text-[#123B5D] placeholder:text-[#334155]/50 transition focus:bg-white focus:outline-none focus:ring-2',
                                                'border-red-300 bg-red-50/40 focus:border-red-500 focus:ring-red-500/20' => $errors->has('password'),
                                                'border-[#E2E8F0] bg-[#F8FAFC] focus:border-[#14B8A6] focus:ring-[#14B8A6]/20' => ! $errors->has('password'),
                                            ])
                                        />
                                        <button
                                            type="button"
                                            id="toggle-password"
                                            aria-label="Tampilkan kata sandi"
                                            aria-pressed="false"
                                            class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-[#334155]/60 transition hover:text-[#123B5D] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#14B8A6] rounded-r-xl"
                                        >
                                            <svg
                                                id="eye-open-password"
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
                                            <svg
                                                id="eye-closed-password"
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

                                {{-- Konfirmasi Kata Sandi --}}
                                <div>
                                    <label for="password_confirmation" class="block text-sm font-semibold text-[#123B5D]">
                                        Konfirmasi Kata Sandi
                                    </label>
                                    <div class="relative mt-2">
                                        <input
                                            id="password_confirmation"
                                            type="password"
                                            name="password_confirmation"
                                            required
                                            autocomplete="new-password"
                                            placeholder="Ulangi kata sandi Anda"
                                            class="w-full rounded-xl border border-[#E2E8F0] bg-[#F8FAFC] py-3 pr-11 pl-4 text-sm text-[#123B5D] placeholder:text-[#334155]/50 transition focus:border-[#14B8A6] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#14B8A6]/20"
                                        />
                                        <button
                                            type="button"
                                            id="toggle-password-confirmation"
                                            aria-label="Tampilkan konfirmasi kata sandi"
                                            aria-pressed="false"
                                            class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-[#334155]/60 transition hover:text-[#123B5D] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#14B8A6] rounded-r-xl"
                                        >
                                            <svg
                                                id="eye-open-confirmation"
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
                                            <svg
                                                id="eye-closed-confirmation"
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
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Submit & Info Keamanan Role --}}
                        <div class="mt-8 flex flex-col items-center justify-between gap-4 border-t border-[#E2E8F0] pt-6 sm:flex-row">
                            <p class="text-xs text-[#334155]/80">
                                Sudah memiliki akun?
                                <a href="{{ route('login') }}" class="font-bold text-[#14B8A6] hover:underline">
                                    Masuk di sini
                                </a>
                            </p>

                            <button
                                type="submit"
                                id="submit-register-btn"
                                class="group inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#14B8A6] px-7 py-3.5 text-sm font-semibold text-white shadow-md shadow-[#14B8A6]/20 transition-all duration-200 hover:-translate-y-0.5 hover:bg-[#0D9488] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#14B8A6] focus-visible:ring-offset-2 sm:w-auto"
                            >
                                <span id="submit-register-label">Daftar sebagai Pelajar</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M5 12h14" />
                                    <path d="m12 5 7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>

        <x-footer />

        @stack('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Fitur tampil/sembunyikan kata sandi dan konfirmasi kata sandi.
                function setupPasswordToggle(inputId, buttonId, openIconId, closedIconId, showLabel, hideLabel) {
                    const passwordInput = document.getElementById(inputId);
                    const toggleButton = document.getElementById(buttonId);
                    const eyeOpen = document.getElementById(openIconId);
                    const eyeClosed = document.getElementById(closedIconId);

                    if (!passwordInput || !toggleButton || !eyeOpen || !eyeClosed) {
                        return;
                    }

                    toggleButton.addEventListener('click', function () {
                        const willShowPassword = passwordInput.type === 'password';

                        passwordInput.type = willShowPassword ? 'text' : 'password';
                        eyeOpen.classList.toggle('hidden', !willShowPassword);
                        eyeClosed.classList.toggle('hidden', willShowPassword);

                        toggleButton.setAttribute(
                            'aria-label',
                            willShowPassword ? hideLabel : showLabel
                        );
                        toggleButton.setAttribute('aria-pressed', String(willShowPassword));
                    });
                }

                setupPasswordToggle(
                    'password',
                    'toggle-password',
                    'eye-open-password',
                    'eye-closed-password',
                    'Tampilkan kata sandi',
                    'Sembunyikan kata sandi'
                );

                setupPasswordToggle(
                    'password_confirmation',
                    'toggle-password-confirmation',
                    'eye-open-confirmation',
                    'eye-closed-confirmation',
                    'Tampilkan konfirmasi kata sandi',
                    'Sembunyikan konfirmasi kata sandi'
                );

                const roleCopy = {
                    pelajar: {
                        banner: 'Anda mendaftar sebagai <strong>Pelajar / Siswa</strong> untuk mencari ruang belajar dan melaporkan kebutuhan pendidikan.',
                        displayNameLabel: 'Nama Lengkap Pelajar',
                        displayNamePlaceholder: 'Contoh: Nadia Putri',
                        institutionLabel: 'Asal Sekolah / Jenjang Pendidikan',
                        institutionPlaceholder: 'Contoh: SMAN 70 Jakarta (Kelas 11)',
                        institutionHint: 'Cantumkan sekolah, kampus, atau jenjang pendidikan Anda saat ini.',
                        locationLabel: 'Kota / Domisili Belajar',
                        locationPlaceholder: 'Contoh: Jakarta Selatan',
                        bioLabel: 'Kebutuhan Belajar Utama (Opsional)',
                        bioPlaceholder: 'Ceritakan singkat fasilitas ruang belajar atau pendampingan yang sedang kamu butuhkan...',
                        submitLabel: 'Daftar sebagai Pelajar'
                    },
                    relawan: {
                        banner: 'Anda mendaftar sebagai <strong>Relawan / Komunitas</strong> untuk menawarkan bantuan mengajar, pendampingan, atau sumber daya.',
                        displayNameLabel: 'Nama Relawan atau Komunitas',
                        displayNamePlaceholder: 'Contoh: Raka Pratama / Komunitas Pengajar Muda',
                        institutionLabel: 'Bidang Keahlian / Fokus Bantuan',
                        institutionPlaceholder: 'Contoh: Pengajar Matematika, Bahasa Inggris & Donasi Buku',
                        institutionHint: 'Sebutkan keahlian mengajar, materi bimbingan, atau jenis dukungan yang dapat diberikan.',
                        locationLabel: 'Kota / Area Jangkauan Relawan',
                        locationPlaceholder: 'Contoh: Bandung & Sekitarnya',
                        bioLabel: 'Rencana Kontribusi & Pengalaman Singkat (Opsional)',
                        bioPlaceholder: 'Ceritakan pengalaman kerelawanan atau jadwal ketersediaan Anda untuk mendampingi pelajar...',
                        submitLabel: 'Daftar sebagai Relawan'
                    },
                    pengelola: {
                        banner: 'Anda mendaftar sebagai <strong>Pengelola Tempat Belajar</strong>. Akun berstatus Menunggu Verifikasi sebelum dapat menggunakan fitur Pengelola.',
                        displayNameLabel: 'Nama Penanggung Jawab / Pengelola',
                        displayNamePlaceholder: 'Contoh: Budi Santoso',
                        institutionLabel: 'Nama Ruang Belajar / Perpustakaan',
                        institutionPlaceholder: 'Contoh: Rumah Baca Pelita Nusantara',
                        institutionHint: 'Nama resmi atau komunitas dari tempat belajar yang Anda kelola.',
                        locationLabel: 'Kota / Wilayah Lokasi Belajar',
                        locationPlaceholder: 'Contoh: Kebayoran Baru, Jakarta Selatan',
                        bioLabel: 'Deskripsi Singkat & Fasilitas Ruang Belajar (Opsional)',
                        bioPlaceholder: 'Jelaskan jam operasional, fasilitas utama (Wi-Fi, Area Baca, Ruang Diskusi), dan kapasitas ruang...',
                        submitLabel: 'Daftar sebagai Pengelola Tempat'
                    }
                };

                const radioInputs = document.querySelectorAll('input[name="role"]');
                const cards = document.querySelectorAll('[data-role-card]');

                function applyRoleUI(role) {
                    const config = roleCopy[role] || roleCopy.pelajar;

                    cards.forEach(function (card) {
                        const isSelected = card.getAttribute('data-role-card') === role;
                        const dot = card.querySelector('.role-check-dot');
                        const badge = card.querySelector('.role-check-badge');

                        card.classList.toggle('border-[#14B8A6]', isSelected);
                        card.classList.toggle('bg-[#EAF6F4]/35', isSelected);
                        card.classList.toggle('shadow-md', isSelected);
                        card.classList.toggle('border-[#E2E8F0]', !isSelected);
                        card.classList.toggle('bg-white', !isSelected);

                        if (dot) {
                            dot.classList.toggle('opacity-100', isSelected);
                            dot.classList.toggle('opacity-0', !isSelected);
                        }
                        if (badge) {
                            badge.classList.toggle('border-[#14B8A6]', isSelected);
                        }
                    });

                    const bannerEl = document.getElementById('role-context-banner');
                    const displayNameLabel = document.getElementById('label-display-name');
                    const displayNameInput = document.getElementById('display_name');
                    const institutionLabel = document.getElementById('label-institution');
                    const institutionInput = document.getElementById('institution');
                    const institutionHint = document.getElementById('hint-institution');
                    const locationLabel = document.getElementById('label-location');
                    const locationInput = document.getElementById('location');
                    const bioLabel = document.getElementById('label-bio');
                    const bioInput = document.getElementById('bio');
                    const submitLabel = document.getElementById('submit-register-label');

                    if (bannerEl) bannerEl.innerHTML = config.banner;
                    if (displayNameLabel) displayNameLabel.textContent = config.displayNameLabel;
                    if (displayNameInput) displayNameInput.setAttribute('placeholder', config.displayNamePlaceholder);
                    if (institutionLabel) institutionLabel.textContent = config.institutionLabel;
                    if (institutionInput) institutionInput.setAttribute('placeholder', config.institutionPlaceholder);
                    if (institutionHint) institutionHint.textContent = config.institutionHint;
                    if (locationLabel) locationLabel.textContent = config.locationLabel;
                    if (locationInput) locationInput.setAttribute('placeholder', config.locationPlaceholder);
                    if (bioLabel) bioLabel.textContent = config.bioLabel;
                    if (bioInput) bioInput.setAttribute('placeholder', config.bioPlaceholder);
                    if (submitLabel) submitLabel.textContent = config.submitLabel;
                }

                radioInputs.forEach(function (radio) {
                    radio.addEventListener('change', function () {
                        if (radio.checked) {
                            applyRoleUI(radio.value);
                        }
                    });
                });

                const checkedRadio = document.querySelector('input[name="role"]:checked');
                applyRoleUI(checkedRadio ? checkedRadio.value : 'pelajar');
            });
        </script>
    </body>
</html>
