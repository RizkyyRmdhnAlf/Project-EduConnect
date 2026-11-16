@props(['place'])

@php
    $facilities = array_slice($place['facilities'] ?? [], 0, 3);
    $isVerified = ($place['verification_status'] ?? 'Terverifikasi') === 'Terverifikasi';
@endphp

<article
    {{ $attributes->merge([
        'class' => 'group flex flex-col overflow-hidden rounded-2xl border border-[#E2E8F0] bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-[#14B8A6]/40 hover:shadow-xl hover:shadow-[#123B5D]/5',
    ]) }}
>
    {{-- Foto / Placeholder Ilustratif --}}
    <div class="relative aspect-[16/10] w-full overflow-hidden bg-[#EAF6F4]">
        @if(!empty($place['image']))
            <img
                src="{{ $place['image'] }}"
                alt="Foto {{ $place['title'] }} di {{ $place['location'] }}"
                loading="lazy"
                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
            />
        @else
            <div class="flex h-full w-full flex-col items-center justify-center bg-gradient-to-br from-[#EAF6F4] to-[#E2E8F0]/60 p-6 text-center">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white/90 text-[#14B8A6] shadow-sm">
                    {{-- Lucide BookOpen Icon --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M12 7v14" />
                        <path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z" />
                    </svg>
                </div>
                <span class="mt-3 text-xs font-medium text-[#123B5D]/70">Ruang Belajar Komunitas</span>
            </div>
        @endif

        {{-- Overlay Badges: Kategori & Status Terverifikasi --}}
        <div class="absolute inset-x-4 top-4 flex flex-wrap items-center justify-between gap-2">
            <span class="inline-flex items-center rounded-full bg-[#123B5D]/90 px-3 py-1 text-xs font-semibold text-white backdrop-blur-sm">
                {{ $place['category'] }}
            </span>

            @if($isVerified)
                <span class="inline-flex items-center gap-1.5 rounded-full bg-[#EAF6F4] px-3 py-1 text-xs font-semibold text-[#0D9488] shadow-xs ring-1 ring-[#14B8A6]/25">
                    {{-- Lucide BadgeCheck / ShieldCheck Icon --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-[#14B8A6]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z" />
                        <path d="m9 12 2 2 4-4" />
                    </svg>
                    <span>Terverifikasi</span>
                </span>
            @endif
        </div>
    </div>

    {{-- Konten Kartu --}}
    <div class="flex flex-1 flex-col p-6">
        {{-- Lokasi --}}
        <div class="flex items-center gap-1.5 text-xs font-medium text-[#334155]/80">
            {{-- Lucide MapPin Icon --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 shrink-0 text-[#14B8A6]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0" />
                <circle cx="12" cy="10" r="3" />
            </svg>
            <span class="truncate">{{ $place['location'] }}</span>
        </div>

        {{-- Nama Tempat --}}
        <h3 class="mt-2 text-lg font-bold tracking-tight text-[#123B5D] transition-colors duration-200 group-hover:text-[#14B8A6]">
            <a href="{{ url('/tempat-belajar/' . $place['slug']) }}" class="focus:outline-none focus-visible:underline">
                {{ $place['title'] }}
            </a>
        </h3>

        {{-- Deskripsi Singkat --}}
        <p class="mt-2 line-clamp-2 text-sm leading-relaxed text-[#334155]">
            {{ $place['description'] }}
        </p>

        {{-- Maksimal Tiga Fasilitas --}}
        @if(!empty($facilities))
            <ul class="mt-4 flex flex-wrap gap-2" aria-label="Fasilitas tempat belajar">
                @foreach($facilities as $facility)
                    <li class="inline-flex items-center gap-1.5 rounded-lg border border-[#E2E8F0] bg-[#F8FAFC] px-2.5 py-1 text-xs font-medium text-[#334155]">
                        <span class="h-1.5 w-1.5 rounded-full bg-[#14B8A6]" aria-hidden="true"></span>
                        <span>{{ $facility }}</span>
                    </li>
                @endforeach
            </ul>
        @endif

        {{-- Footer Kartu: Biaya / Label Gratis & Link Lihat Detail --}}
        <div class="mt-auto pt-6">
            <div class="flex items-center justify-between border-t border-[#E2E8F0] pt-4">
                <div>
                    <span class="block text-[11px] font-medium uppercase tracking-wider text-[#334155]/70">Biaya Akses</span>
                    @if($place['is_free'] ?? true)
                        <span class="inline-flex items-center rounded-md bg-[#EAF6F4] px-2.5 py-0.5 text-xs font-bold text-[#0D9488]">
                            Gratis
                        </span>
                    @else
                        <span class="text-sm font-bold text-[#123B5D]">
                            {{ $place['cost'] }}
                        </span>
                    @endif
                </div>

                <a
                    href="{{ url('/tempat-belajar/' . $place['slug']) }}"
                    class="inline-flex items-center gap-1.5 text-sm font-semibold text-[#123B5D] transition-colors duration-200 group-hover:text-[#14B8A6] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#14B8A6] rounded-lg"
                >
                    <span>Lihat detail</span>
                    {{-- Lucide ArrowRight Icon --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M5 12h14" />
                        <path d="m12 5 7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</article>
