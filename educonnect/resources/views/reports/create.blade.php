<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Kebutuhan Pendidikan - EduConnect</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#F8FAFC]">
    <x-navbar active="laporan" />

    <main class="mx-auto max-w-5xl px-6 py-10">
        <a
            href="{{ route('reports.index') }}"
            class="inline-flex items-center gap-2 rounded-lg text-sm font-semibold text-[#0F766E] transition hover:text-[#123B5D] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#14B8A6]"
        >
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                <path d="m15 18-6-6 6-6M9 12h12" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
            </svg>
            Kembali ke daftar laporan
        </a>

        <section class="mt-6 overflow-hidden rounded-3xl border border-[#E2E8F0] bg-white shadow-sm">
            <div class="bg-gradient-to-r from-[#123B5D] to-[#0F766E] px-6 py-8 text-white sm:px-10">
                <span class="text-xs font-bold uppercase tracking-[0.18em] text-[#99F6E4]">
                    Suarakan Kebutuhan
                </span>
                <h1 class="mt-2 text-2xl font-extrabold sm:text-3xl">
                    Form Kebutuhan Pendidikan
                </h1>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-blue-50">
                    Ceritakan kebutuhan pendidikan di sekitarmu agar dapat ditinjau dan ditindaklanjuti oleh komunitas EduConnect.
                </p>
            </div>

            <form
                action="{{ route('reports.store') }}"
                method="POST"
                enctype="multipart/form-data"
                class="grid gap-8 p-6 sm:p-10 lg:grid-cols-[minmax(0,1fr)_16rem]"
            >
                @csrf

                <div class="grid content-start gap-5">
                    <div>
                        <label for="title" class="mb-2 block text-sm font-semibold text-[#334155]">
                            Judul laporan <span class="text-red-500">*</span>
                        </label>
                        <input
                            id="title"
                            name="title"
                            type="text"
                            value="{{ old('title') }}"
                            maxlength="255"
                            required
                            placeholder="Contoh: Membutuhkan buku bacaan untuk rumah belajar"
                            class="w-full rounded-xl border border-[#CBD5E1] bg-[#F8FAFC] px-4 py-3 text-sm text-[#123B5D] outline-none transition placeholder:text-[#94A3B8] focus:border-[#14B8A6] focus:ring-2 focus:ring-[#14B8A6]/20"
                            aria-describedby="title-error"
                        >
                        @error('title')
                            <p id="title-error" class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="category" class="mb-2 block text-sm font-semibold text-[#334155]">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <input
                            id="category"
                            name="category"
                            type="text"
                            value="{{ old('category') }}"
                            maxlength="100"
                            required
                            placeholder="Contoh: Perlengkapan belajar"
                            class="w-full rounded-xl border border-[#CBD5E1] bg-[#F8FAFC] px-4 py-3 text-sm text-[#123B5D] outline-none transition placeholder:text-[#94A3B8] focus:border-[#14B8A6] focus:ring-2 focus:ring-[#14B8A6]/20"
                            aria-describedby="category-error"
                        >
                        @error('category')
                            <p id="category-error" class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="location" class="mb-2 block text-sm font-semibold text-[#334155]">
                            Lokasi kebutuhan <span class="text-red-500">*</span>
                        </label>
                        <input
                            id="location"
                            name="location"
                            type="text"
                            value="{{ old('location') }}"
                            maxlength="255"
                            required
                            placeholder="Nama wilayah, kota, atau alamat"
                            class="w-full rounded-xl border border-[#CBD5E1] bg-[#F8FAFC] px-4 py-3 text-sm text-[#123B5D] outline-none transition placeholder:text-[#94A3B8] focus:border-[#14B8A6] focus:ring-2 focus:ring-[#14B8A6]/20"
                            aria-describedby="location-error"
                        >
                        @error('location')
                            <p id="location-error" class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="mb-2 block text-sm font-semibold text-[#334155]">
                            Deskripsi kebutuhan <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            id="description"
                            name="description"
                            rows="6"
                            maxlength="5000"
                            required
                            placeholder="Jelaskan kebutuhan, kondisi saat ini, dan bantuan yang diperlukan..."
                            class="w-full resize-y rounded-xl border border-[#CBD5E1] bg-[#F8FAFC] px-4 py-3 text-sm leading-6 text-[#123B5D] outline-none transition placeholder:text-[#94A3B8] focus:border-[#14B8A6] focus:ring-2 focus:ring-[#14B8A6]/20"
                            aria-describedby="description-help description-error"
                        >{{ old('description') }}</textarea>
                        <p id="description-help" class="mt-2 text-xs text-[#64748B]">
                            Maksimal 5.000 karakter.
                        </p>
                        @error('description')
                            <p id="description-error" class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="image" class="mb-2 block text-sm font-semibold text-[#334155]">
                            Foto pendukung <span class="font-normal text-[#64748B]">(opsional)</span>
                        </label>
                        <input
                            id="image"
                            name="image"
                            type="file"
                            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                            class="block w-full rounded-xl border border-[#CBD5E1] bg-[#F8FAFC] text-sm text-[#475569] file:mr-4 file:border-0 file:bg-[#EAF6F4] file:px-4 file:py-3 file:text-sm file:font-semibold file:text-[#0F766E] hover:file:bg-[#CCFBF1] focus:outline-none focus:ring-2 focus:ring-[#14B8A6]/20"
                            aria-describedby="image-help image-error"
                        >
                        <p id="image-help" class="mt-2 text-xs text-[#64748B]">
                            JPG, PNG, atau WEBP. Ukuran maksimal 5 MB.
                        </p>
                        @error('image')
                            <p id="image-error" class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col-reverse gap-3 pt-2 sm:flex-row sm:justify-end">
                        <a
                            href="{{ route('reports.index') }}"
                            class="inline-flex items-center justify-center rounded-xl border border-[#CBD5E1] px-5 py-3 text-sm font-semibold text-[#475569] transition hover:bg-[#F8FAFC] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#14B8A6]"
                        >
                            Batal
                        </a>
                        <button
                            type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#123B5D] px-6 py-3 text-sm font-bold text-white transition hover:bg-[#0F766E] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#14B8A6] focus-visible:ring-offset-2"
                        >
                            Kirim Laporan
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                <path d="M5 12h14m-7-7 7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            </svg>
                        </button>
                    </div>
                </div>

                <aside class="h-fit rounded-2xl border border-[#CCFBF1] bg-[#F0FDFA] p-5">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-white text-[#0F766E] shadow-sm">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path d="M12 22s8-4 8-11V5l-8-3-8 3v6c0 7 8 11 8 11Z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            <path d="m9 12 2 2 4-4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                        </svg>
                    </div>
                    <h2 class="mt-4 font-bold text-[#123B5D]">Sebelum mengirim</h2>
                    <ul class="mt-3 grid gap-3 text-sm leading-6 text-[#475569]">
                        <li>Gunakan judul dan kategori yang jelas.</li>
                        <li>Sertakan lokasi yang cukup spesifik untuk ditindaklanjuti.</li>
                        <li>Laporan akan berstatus <strong>Menunggu</strong> setelah dikirim.</li>
                        <li>Jangan sertakan data pribadi sensitif pada deskripsi atau foto.</li>
                    </ul>
                </aside>
            </form>
        </section>
    </main>

    <x-footer />
</body>
</html>
