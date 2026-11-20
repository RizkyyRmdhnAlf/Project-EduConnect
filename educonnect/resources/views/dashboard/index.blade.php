@php
    use App\Enums\UserRole;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Dashboard {{ $role->label() }} — EduConnect</title>

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#F8FAFC] font-sans text-[#334155] antialiased">
        <div class="flex min-h-screen">
            {{-- Sidebar Desktop --}}
            <aside class="hidden w-72 shrink-0 flex-col justify-between border-r border-[#E2E8F0] bg-white p-6 lg:flex">
                <div>
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#14B8A6] text-white shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z" />
                                <path d="M22 10v6" />
                                <path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5" />
                            </svg>
                        </span>
                        <span class="text-xl font-bold tracking-tight text-[#123B5D]">
                            EduConnect<span class="text-[#14B8A6]">.</span>
                        </span>
                    </a>

                    <div class="mt-6 rounded-2xl bg-[#EAF6F4] p-4">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-[#0D9488]">
                            Peran Aktif
                        </span>
                        <p class="mt-0.5 text-sm font-bold text-[#123B5D]">
                            {{ $role->label() }}
                        </p>
                        <p class="mt-1 text-xs text-[#334155]">
                            {{ $user->institution ?? $user->location ?? 'Ekosistem EduConnect' }}
                        </p>
                    </div>

                    <nav aria-label="Menu Dashboard" class="mt-6 space-y-1.5">
                        @foreach ($menuItems as $item)
                            <a
                                href="{{ route('dashboard') }}"
                                @class([
                                    'flex items-center justify-between rounded-xl px-4 py-3 text-sm font-semibold transition',
                                    'bg-[#123B5D] text-white shadow-xs' => $item['active'],
                                    'text-[#334155] hover:bg-[#F8FAFC] hover:text-[#123B5D]' => ! $item['active'],
                                ])
                            >
                                <span>{{ $item['label'] }}</span>
                                @if ($item['badge'])
                                    <span class="rounded-full bg-[#14B8A6]/20 px-2.5 py-0.5 text-[11px] font-bold text-[#14B8A6]">
                                        {{ $item['badge'] }}
                                    </span>
                                @endif
                            </a>
                        @endforeach
                    </nav>
                </div>

                <div class="border-t border-[#E2E8F0] pt-5">
                    <div class="mb-4 flex items-center justify-between">
                        <div class="min-w-0">
                            <p class="truncate text-sm font-bold text-[#123B5D]">{{ $user->display_name }}</p>
                            <p class="truncate text-xs text-[#334155]/80">{{ $user->email }}</p>
                        </div>
                        <span class="inline-flex items-center rounded-full bg-[#EAF6F4] px-2.5 py-0.5 text-[11px] font-semibold text-[#0D9488]">
                            Aktif
                        </span>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                            type="submit"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-[#E2E8F0] bg-[#F8FAFC] px-4 py-2.5 text-sm font-semibold text-[#123B5D] transition hover:border-red-200 hover:bg-red-50 hover:text-red-600"
                        >
                            <span>Keluar dari Akun</span>
                        </button>
                    </form>
                </div>
            </aside>

            {{-- Konten Utama Dashboard --}}
            <div class="flex flex-1 flex-col">
                {{-- Header Dashboard --}}
                <header class="flex items-center justify-between border-b border-[#E2E8F0] bg-white px-6 py-4">
                    <div>
                        <nav aria-label="Breadcrumb" class="text-xs font-medium text-[#334155]/75">
                            <a href="{{ route('home') }}" class="hover:text-[#14B8A6]">Beranda</a>
                            <span class="mx-1.5">/</span>
                            <span class="text-[#123B5D]">Dashboard</span>
                        </nav>
                        <h1 class="mt-0.5 text-xl font-bold text-[#123B5D]">
                            Dashboard {{ $role->label() }}
                        </h1>
                    </div>

                    <div class="flex items-center gap-3">
                        <a
                            href="{{ route('home') }}"
                            class="rounded-xl border border-[#E2E8F0] bg-white px-4 py-2 text-xs font-semibold text-[#123B5D] transition hover:border-[#14B8A6] hover:text-[#14B8A6]"
                        >
                            Lihat Beranda
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="lg:hidden">
                            @csrf
                            <button
                                type="submit"
                                class="rounded-xl bg-red-50 px-4 py-2 text-xs font-semibold text-red-600"
                            >
                                Keluar
                            </button>
                        </form>
                    </div>
                </header>

                <main class="flex-1 p-6 sm:p-8">
                    @if (session('status'))
                        <div
                            role="status"
                            class="mb-6 flex items-center gap-3 rounded-2xl border border-[#14B8A6]/30 bg-[#EAF6F4] px-5 py-4 text-sm font-semibold text-[#123B5D]"
                        >
                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-[#14B8A6] text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M20 6 9 17l-5-5" />
                                </svg>
                            </span>
                            <span>{{ session('status') }}</span>
                        </div>
                    @endif

                    {{-- Summary Cards --}}
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                        <div class="rounded-2xl border border-[#E2E8F0] bg-white p-6 shadow-xs">
                            <span class="text-xs font-bold uppercase tracking-wider text-[#14B8A6]">Lokasi Belajar</span>
                            <p class="mt-2 text-3xl font-extrabold text-[#123B5D]">{{ $stats['locations_count'] }}</p>
                            <p class="mt-1 text-xs text-[#334155]">Tempat belajar terdaftar di direktori</p>
                        </div>

                        <div class="rounded-2xl border border-[#E2E8F0] bg-white p-6 shadow-xs">
                            <span class="text-xs font-bold uppercase tracking-wider text-[#14B8A6]">Laporan Kebutuhan</span>
                            <p class="mt-2 text-3xl font-extrabold text-[#123B5D]">{{ $stats['needs_count'] }}</p>
                            <p class="mt-1 text-xs text-[#334155]">Kebutuhan pendidikan dilaporkan</p>
                        </div>

                        <div class="rounded-2xl border border-[#E2E8F0] bg-white p-6 shadow-xs">
                            <span class="text-xs font-bold uppercase tracking-wider text-[#14B8A6]">Tawaran Bantuan</span>
                            <p class="mt-2 text-3xl font-extrabold text-[#123B5D]">{{ $stats['offers_count'] }}</p>
                            <p class="mt-1 text-xs text-[#334155]">Kontribusi relawan aktif</p>
                        </div>

                        <div class="rounded-2xl border border-[#E2E8F0] bg-white p-6 shadow-xs">
                            <span class="text-xs font-bold uppercase tracking-wider text-[#14B8A6]">Status Akun</span>
                            <div class="mt-2 flex items-center gap-2">
                                <span class="inline-flex items-center rounded-full bg-[#EAF6F4] px-3 py-1 text-xs font-bold text-[#0D9488]">
                                    Terverifikasi &bull; {{ ucfirst($user->account_status) }}
                                </span>
                            </div>
                            <p class="mt-2 text-xs text-[#334155]">ID UUID: {{ \Illuminate\Support\Str::limit($user->id, 13) }}</p>
                        </div>
                    </div>

                    {{-- Ringkasan Hak Akses Berdasarkan Use Case & Role --}}
                    <div class="mt-8 rounded-3xl border border-[#E2E8F0] bg-white p-6 shadow-xs sm:p-8">
                        <span class="text-xs font-bold uppercase tracking-widest text-[#14B8A6]">
                            Hak Akses &amp; Fitur Peran
                        </span>
                        <h2 class="mt-2 text-xl font-bold text-[#123B5D]">
                            Halo, {{ $user->display_name }}!
                        </h2>
                        <p class="mt-1 text-sm text-[#334155]">
                            {{ $role->description() }}
                        </p>

                        <div class="mt-6 flex flex-wrap gap-3">
                            <a
                                href="{{ route('dashboard.pelajar') }}"
                                class="rounded-xl border border-[#E2E8F0] bg-[#F8FAFC] px-4 py-2.5 text-xs font-semibold text-[#123B5D] transition hover:border-[#14B8A6]"
                            >
                                Area Pelajar
                            </a>
                            <a
                                href="{{ route('dashboard.relawan') }}"
                                class="rounded-xl border border-[#E2E8F0] bg-[#F8FAFC] px-4 py-2.5 text-xs font-semibold text-[#123B5D] transition hover:border-[#14B8A6]"
                            >
                                Area Relawan
                            </a>
                            <a
                                href="{{ route('dashboard.pengelola') }}"
                                class="rounded-xl border border-[#E2E8F0] bg-[#F8FAFC] px-4 py-2.5 text-xs font-semibold text-[#123B5D] transition hover:border-[#14B8A6]"
                            >
                                Area Pengelola Tempat
                            </a>
                            <a
                                href="{{ route('dashboard.admin') }}"
                                class="rounded-xl border border-[#E2E8F0] bg-[#F8FAFC] px-4 py-2.5 text-xs font-semibold text-[#123B5D] transition hover:border-[#14B8A6]"
                            >
                                Area Administrator
                            </a>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
