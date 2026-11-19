@props(['active' => 'beranda'])

<header class="sticky top-0 z-50 w-full border-b border-[#E2E8F0] bg-white/95 backdrop-blur-md">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
        {{-- Logo EduConnect --}}
        <a
            href="{{ route('home') }}"
            class="group inline-flex items-center gap-3 rounded-xl focus:outline-none focus-visible:ring-2 focus-visible:ring-[#14B8A6] focus-visible:ring-offset-2"
            aria-label="Beranda EduConnect"
        >
            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#14B8A6] text-white shadow-sm shadow-[#14B8A6]/25 transition-transform duration-200 group-hover:scale-105">
                {{-- Lucide GraduationCap Icon --}}
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

        {{-- Navigasi Desktop (Tengah) --}}
        <nav aria-label="Navigasi utama" class="hidden md:flex md:items-center md:gap-8">
            <a
                href="{{ route('home') }}"
                @class([
                    'relative py-2 text-sm font-semibold transition-colors duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#14B8A6] rounded-lg',
                    'text-[#14B8A6] after:absolute after:inset-x-0 after:bottom-0 after:h-0.5 after:rounded-full after:bg-[#14B8A6]' => $active === 'beranda',
                    'text-[#334155] hover:text-[#123B5D]' => $active !== 'beranda',
                ])
                @if($active === 'beranda') aria-current="page" @endif
            >
                Beranda
            </a>
            <a
                href="{{ url('/tempat-belajar') }}"
                @class([
                    'relative py-2 text-sm font-semibold transition-colors duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#14B8A6] rounded-lg',
                    'text-[#14B8A6] after:absolute after:inset-x-0 after:bottom-0 after:h-0.5 after:rounded-full after:bg-[#14B8A6]' => $active === 'tempat-belajar',
                    'text-[#334155] hover:text-[#123B5D]' => $active !== 'tempat-belajar',
                ])
            >
                Tempat Belajar
            </a>
            <a
                href="{{ route('register', ['role' => 'relawan']) }}"
                class="relative py-2 text-sm font-medium text-[#334155] transition-colors duration-200 hover:text-[#123B5D] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#14B8A6] rounded-lg"
            >
                Jadi Relawan
            </a>
            <a
                href="{{ route('home') }}#cara-kerja"
                class="relative py-2 text-sm font-medium text-[#334155] transition-colors duration-200 hover:text-[#123B5D] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#14B8A6] rounded-lg"
            >
                Tentang Kami
            </a>
        </nav>

        {{-- Tombol Masuk & Daftar Sekarang / Dashboard (Kanan pada Desktop) --}}
        <div class="hidden md:flex md:items-center md:gap-3">
            @auth
                <a
                    href="{{ route('dashboard') }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-[#EAF6F4] px-4 py-2.5 text-sm font-semibold text-[#123B5D] transition-colors duration-200 hover:bg-[#14B8A6] hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-[#14B8A6]"
                >
                    <span>Dashboard</span>
                    <span class="rounded-md bg-white/80 px-2 py-0.5 text-xs font-bold text-[#0D9488]">
                        {{ auth()->user()->role?->label() ?? 'Pengguna' }}
                    </span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-xl border border-[#E2E8F0] px-4 py-2.5 text-sm font-semibold text-[#334155] transition-colors duration-200 hover:border-red-200 hover:bg-red-50 hover:text-red-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500"
                    >
                        Keluar
                    </button>
                </form>
            @else
                <a
                    href="{{ route('login') }}"
                    @class([
                        'inline-flex items-center justify-center rounded-xl px-4 py-2.5 text-sm font-semibold transition-colors duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#14B8A6]',
                        'bg-[#EAF6F4] text-[#14B8A6]' => $active === 'login',
                        'text-[#123B5D] hover:bg-[#EAF6F4] hover:text-[#14B8A6]' => $active !== 'login',
                    ])
                >
                    Masuk
                </a>
                <a
                    href="{{ route('register') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#14B8A6] px-5 py-2.5 text-sm font-semibold text-white shadow-sm shadow-[#14B8A6]/20 transition-all duration-200 hover:-translate-y-0.5 hover:bg-[#0D9488] hover:shadow-md focus:outline-none focus-visible:ring-2 focus-visible:ring-[#14B8A6] focus-visible:ring-offset-2"
                >
                    <span>Daftar Sekarang</span>
                </a>
            @endauth
        </div>

        {{-- Tombol Hamburger Mobile --}}
        <div class="flex md:hidden">
            <button
                type="button"
                id="mobile-menu-button"
                aria-expanded="false"
                aria-controls="mobile-menu-panel"
                aria-label="Buka menu navigasi"
                class="inline-flex h-11 w-11 items-center justify-center rounded-xl border border-[#E2E8F0] bg-white text-[#123B5D] transition-colors hover:bg-[#F8FAFC] hover:text-[#14B8A6] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#14B8A6]"
            >
                {{-- Hamburger Icon --}}
                <svg id="mobile-menu-icon-open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <line x1="4" x2="20" y1="12" y2="12" />
                    <line x1="4" x2="20" y1="6" y2="6" />
                    <line x1="4" x2="20" y1="18" y2="18" />
                </svg>
                {{-- Close Icon --}}
                <svg id="mobile-menu-icon-close" xmlns="http://www.w3.org/2000/svg" class="hidden h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M18 6 6 18" />
                    <path d="m6 6 12 12" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Panel Dropdown Mobile --}}
    <div
        id="mobile-menu-panel"
        class="hidden border-t border-[#E2E8F0] bg-white px-4 pt-3 pb-6 shadow-lg md:hidden"
    >
        <nav aria-label="Navigasi mobile" class="flex flex-col gap-1">
            <a
                href="{{ route('home') }}"
                @class([
                    'flex items-center justify-between rounded-xl px-4 py-3 text-base font-semibold transition-colors',
                    'bg-[#EAF6F4] text-[#14B8A6]' => $active === 'beranda',
                    'text-[#334155] hover:bg-[#F8FAFC] hover:text-[#123B5D]' => $active !== 'beranda',
                ])
                @if($active === 'beranda') aria-current="page" @endif
            >
                <span>Beranda</span>
                @if($active === 'beranda')
                    <span class="h-2 w-2 rounded-full bg-[#14B8A6]"></span>
                @endif
            </a>
            <a
                href="{{ url('/tempat-belajar') }}"
                class="flex items-center justify-between rounded-xl px-4 py-3 text-base font-medium text-[#334155] transition-colors hover:bg-[#F8FAFC] hover:text-[#123B5D]"
            >
                <span>Tempat Belajar</span>
            </a>
            <a
                href="{{ route('register', ['role' => 'relawan']) }}"
                class="mobile-nav-link flex items-center justify-between rounded-xl px-4 py-3 text-base font-medium text-[#334155] transition-colors hover:bg-[#F8FAFC] hover:text-[#123B5D]"
            >
                <span>Jadi Relawan</span>
            </a>
            <a
                href="{{ route('home') }}#cara-kerja"
                class="mobile-nav-link flex items-center justify-between rounded-xl px-4 py-3 text-base font-medium text-[#334155] transition-colors hover:bg-[#F8FAFC] hover:text-[#123B5D]"
            >
                <span>Tentang Kami</span>
            </a>
        </nav>

        {{-- Dua CTA Terpisah pada Mobile --}}
        <div class="mt-4 flex flex-col gap-2.5 border-t border-[#E2E8F0] pt-4">
            @auth
                <a
                    href="{{ route('dashboard') }}"
                    class="inline-flex w-full items-center justify-center rounded-xl bg-[#123B5D] px-4 py-3 text-sm font-semibold text-white transition-colors hover:bg-[#14B8A6]"
                >
                    Ke Dashboard ({{ auth()->user()->role?->label() }})
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        type="submit"
                        class="inline-flex w-full items-center justify-center rounded-xl border border-[#E2E8F0] bg-white px-4 py-3 text-sm font-semibold text-red-600 transition-colors hover:bg-red-50"
                    >
                        Keluar
                    </button>
                </form>
            @else
                <a
                    href="{{ route('login') }}"
                    class="inline-flex w-full items-center justify-center rounded-xl border border-[#E2E8F0] bg-white px-4 py-3 text-sm font-semibold text-[#123B5D] transition-colors hover:border-[#123B5D] hover:bg-[#F8FAFC]"
                >
                    Masuk
                </a>
                <a
                    href="{{ route('register') }}"
                    class="inline-flex w-full items-center justify-center rounded-xl bg-[#14B8A6] px-4 py-3 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-[#0D9488]"
                >
                    Daftar Sekarang
                </a>
            @endauth
        </div>
    </div>
</header>

@pushOnce('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btn = document.getElementById('mobile-menu-button');
        const panel = document.getElementById('mobile-menu-panel');
        const iconOpen = document.getElementById('mobile-menu-icon-open');
        const iconClose = document.getElementById('mobile-menu-icon-close');

        if (!btn || !panel) return;

        function toggleMenu(forceClose = false) {
            const isExpanded = btn.getAttribute('aria-expanded') === 'true';
            const nextState = forceClose ? false : !isExpanded;

            btn.setAttribute('aria-expanded', String(nextState));
            panel.classList.toggle('hidden', !nextState);
            iconOpen.classList.toggle('hidden', nextState);
            iconClose.classList.toggle('hidden', !nextState);
        }

        btn.addEventListener('click', function () {
            toggleMenu();
        });

        panel.querySelectorAll('.mobile-nav-link').forEach(function (link) {
            link.addEventListener('click', function () {
                toggleMenu(true);
            });
        });
    });
</script>
@endPushOnce
