
@props(['place'])

@php
    $facilities = array_slice($place['facilities'] ?? [], 0, 3);
    $isVerified = ($place['verification_status'] ?? 'Belum Diverifikasi') === 'Terverifikasi';
    $isFree = $place['is_free'] ?? true;
@endphp

<article
    {{ $attributes->merge([
        'class' => 'group flex h-full flex-col overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1.5 hover:border-teal-200 hover:shadow-xl hover:shadow-slate-900/10',
    ]) }}
>

    {{-- IMAGE SECTION --}}
    <div class="relative aspect-[16/10] overflow-hidden bg-slate-100">

        @if(!empty($place['image']))
            <img
                src="{{ $place['image'] }}"
                alt="Foto {{ $place['title'] }}"
                loading="lazy"
                class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"
            />
        @else
            <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-[#E0F2F1] via-[#F0FDFA] to-[#E2E8F0]">
                <div class="flex flex-col items-center">
                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-white text-teal-600 shadow-md shadow-teal-900/5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 7v14"/>
                            <path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"/>
                        </svg>
                    </div>

                    <span class="mt-3 text-xs font-semibold tracking-wide text-slate-500">
                        EDUCONNECT LEARNING SPACE
                    </span>
                </div>
            </div>
        @endif

        {{-- Image Gradient --}}
        <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-[#123B5D]/40 via-transparent to-black/10 opacity-60"></div>

        {{-- Category --}}
        <div class="absolute left-4 top-4">
            <span class="inline-flex items-center rounded-full border border-white/20 bg-[#123B5D]/90 px-3.5 py-1.5 text-xs font-semibold text-white shadow-sm backdrop-blur-md">
                {{ $place['category'] }}
            </span>
        </div>

        {{-- Verification Status --}}
        <div class="absolute right-4 top-4">
            @if($isVerified)
                <span class="inline-flex items-center gap-1.5 rounded-full border border-white/60 bg-white/95 px-3 py-1.5 text-xs font-bold text-teal-700 shadow-sm backdrop-blur-md">
                    <svg class="h-3.5 w-3.5 text-teal-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="m5 12 4 4L19 6"/>
                    </svg>
                    Terverifikasi
                </span>
            @else
                <span class="inline-flex items-center gap-1.5 rounded-full border border-white/50 bg-white/90 px-3 py-1.5 text-xs font-semibold text-slate-600 shadow-sm backdrop-blur-md">
                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="9"/>
                        <path d="M12 8v4m0 4h.01"/>
                    </svg>
                    Belum Diverifikasi
                </span>
            @endif
        </div>

    </div>


    {{-- CARD CONTENT --}}
    <div class="flex flex-1 flex-col p-5 sm:p-6">

        {{-- Location --}}
        <div class="flex items-center gap-2 text-xs font-medium text-slate-500">
            <svg class="h-4 w-4 shrink-0 text-teal-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 10c0 5-5.5 10-7.4 11.8a1 1 0 0 1-1.2 0C9.5 20 4 15 4 10a8 8 0 1 1 16 0Z"/>
                <circle cx="12" cy="10" r="2.5"/>
            </svg>

            <span class="truncate">
                {{ $place['location'] }}
            </span>
        </div>


        {{-- Place Name --}}
        <h3 class="mt-3 text-lg font-bold leading-snug tracking-tight text-[#123B5D] transition-colors duration-200 group-hover:text-teal-600">
            {{ $place['title'] }}
        </h3>


        {{-- Description --}}
        <p class="mt-2 line-clamp-2 min-h-11 text-sm leading-relaxed text-slate-500">
            {{ $place['description'] ?: 'Belum ada deskripsi untuk tempat belajar ini.' }}
        </p>


        {{-- Facilities --}}
        @if(!empty($facilities))
            <div class="mt-4">
                <p class="mb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                    Fasilitas
                </p>

                <ul class="flex flex-wrap gap-2">
                    @foreach($facilities as $facility)
                        <li class="inline-flex items-center gap-1.5 rounded-lg border border-slate-100 bg-slate-50 px-2.5 py-1.5 text-xs font-medium text-slate-600">
                            <span class="h-1.5 w-1.5 rounded-full bg-teal-500"></span>
                            {{ $facility }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif


        {{-- CARD FOOTER --}}
        <div class="mt-auto pt-6">

            <div class="flex items-center justify-between gap-3 border-t border-slate-100 pt-4">

                {{-- Access Cost --}}
                <div class="min-w-0">
                    <p class="text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400">
                        Biaya Akses
                    </p>

                    @if($isFree)
                        <div class="mt-1 inline-flex items-center gap-1.5 text-sm font-bold text-teal-600">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                                <path d="m5 12 4 4L19 6"/>
                            </svg>
                            Gratis
                        </div>
                    @else
                        <p class="mt-1 truncate text-sm font-bold text-[#123B5D]">
                            {{ $place['cost'] ?? 'Hubungi pengelola' }}
                        </p>
                    @endif
                </div>


                {{-- Detail Button --}}
                <a
                    href="{{ url('/tempat-belajar/' . $place['slug']) }}"
                    aria-label="Lihat detail {{ $place['title'] }}"
                    class="inline-flex shrink-0 items-center gap-2 rounded-xl bg-[#123B5D] px-4 py-2.5 text-xs font-bold text-white transition-all duration-200 hover:bg-teal-600 hover:shadow-lg hover:shadow-teal-900/10 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2"
                >
                    Lihat Detail

                    <svg class="h-3.5 w-3.5 transition-transform duration-200 group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14"/>
                        <path d="m12 5 7 7-7 7"/>
                    </svg>
                </a>

            </div>
        </div>

    </div>

</article>
