<footer class="border-t border-[#E2E8F0] bg-white">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
        <div class="flex flex-col justify-between gap-10 lg:flex-row lg:items-center">
            {{-- Brand & Tagline --}}
            <div class="max-w-md">
                <a
                    href="{{ route('home') }}"
                    class="inline-flex items-center gap-3 rounded-xl focus:outline-none focus-visible:ring-2 focus-visible:ring-[#14B8A6]"
                >
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
                <p class="mt-3.5 text-base leading-relaxed text-[#334155]">
                    Menghubungkan kesempatan, membuka masa depan.
                </p>
            </div>

            {{-- Footer Links --}}
            <nav aria-label="Tautan informasi footer" class="flex flex-wrap items-center gap-x-8 gap-y-4">
                <a
                    href="#cara-kerja"
                    class="text-sm font-medium text-[#334155] transition-colors duration-200 hover:text-[#14B8A6] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#14B8A6] rounded-md"
                >
                    Tentang EduConnect
                </a>
                <a
                    href="{{ url('/tempat-belajar') }}"
                    class="text-sm font-medium text-[#334155] transition-colors duration-200 hover:text-[#14B8A6] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#14B8A6] rounded-md"
                >
                    Direktori Tempat Belajar
                </a>
                <a
                    href="#cta-penutup"
                    class="text-sm font-medium text-[#334155] transition-colors duration-200 hover:text-[#14B8A6] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#14B8A6] rounded-md"
                >
                    Pusat Bantuan
                </a>
                <a
                    href="#kebijakan-privasi"
                    class="text-sm font-medium text-[#334155] transition-colors duration-200 hover:text-[#14B8A6] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#14B8A6] rounded-md"
                >
                    Kebijakan Privasi
                </a>
            </nav>
        </div>

        <div class="mt-10 flex flex-col items-start justify-between gap-4 border-t border-[#E2E8F0] pt-8 sm:flex-row sm:items-center">
            <p class="text-sm text-[#334155]/80">
                &copy; {{ date('Y') }} EduConnect. Hak cipta dilindungi. Bersama memeratakan akses pendidikan Indonesia.
            </p>
            <div class="inline-flex items-center gap-2 text-xs font-medium text-[#334155]/80">
                <span class="h-2 w-2 rounded-full bg-[#14B8A6]"></span>
                <span>Ekosistem Pendidikan Terbuka &amp; Terverifikasi</span>
            </div>
        </div>
    </div>
</footer>
