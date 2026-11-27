<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Ajukan kebutuhan pendidikan melalui EduConnect.">
    <title>Ajukan Kebutuhan Pendidikan - EduConnect</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#F8FAFC]">
    <x-navbar active="laporan" />

    <main class="mx-auto max-w-4xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
        <a
            href="{{ route('reports.index') }}"
            class="inline-flex items-center gap-2 rounded-lg text-sm font-semibold text-[#0F766E] transition hover:text-[#123B5D] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#14B8A6]"
        >
            <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
            Kembali ke daftar laporan
        </a>

        <section class="mt-6 overflow-hidden rounded-3xl border border-[#E2E8F0] bg-white shadow-sm">
            <div class="bg-gradient-to-br from-[#123B5D] to-[#0F766E] px-6 py-8 text-white sm:px-10 sm:py-10">
                <span class="text-xs font-bold uppercase tracking-[0.2em] text-teal-100">EduConnect</span>
                <h1 class="mt-3 text-2xl font-bold sm:text-3xl">Ajukan Kebutuhan Pendidikan</h1>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-white/85">
                    Ceritakan kebutuhan belajar yang perlu dibantu. Laporan akan ditinjau sebelum ditindaklanjuti.
                </p>
            </div>

            @if (session('error') || $errors->any())
                <div
                    role="alert"
                    aria-live="assertive"
                    class="mx-6 mt-6 flex items-start gap-3 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-800 sm:mx-10"
                >
                    <i class="fa-solid fa-circle-exclamation mt-0.5 text-red-600" aria-hidden="true"></i>
                    <p>{{ session('error', 'Laporan belum dapat disimpan. Periksa kembali isian yang ditandai.') }}</p>
                </div>
            @endif

            <form
                action="{{ route('reports.store') }}"
                method="POST"
                enctype="multipart/form-data"
                class="space-y-6 p-6 sm:p-10"
            >
                @csrf

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="title" class="mb-2 block text-sm font-semibold text-[#334155]">
                            Judul kebutuhan <span class="text-red-500">*</span>
                        </label>
                        <input
                            id="title"
                            name="title"
                            type="text"
                            value="{{ old('title') }}"
                            maxlength="150"
                            required
                            placeholder="Contoh: Membutuhkan buku pelajaran kelas 8"
                            class="w-full rounded-xl border border-[#CBD5E1] bg-white px-4 py-3 text-sm text-[#123B5D] outline-none transition placeholder:text-[#94A3B8] focus:border-[#14B8A6] focus:ring-4 focus:ring-[#14B8A6]/10"
                            @error('title') aria-invalid="true" aria-describedby="title-error" @enderror
                        >
                        @error('title')
                            <p id="title-error" class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="category" class="mb-2 block text-sm font-semibold text-[#334155]">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="category"
                            name="category"
                            class="w-full rounded-xl border border-[#CBD5E1] bg-white px-4 py-3 text-sm text-[#123B5D] outline-none transition focus:border-[#14B8A6] focus:ring-4 focus:ring-[#14B8A6]/10"
                            required
                            @error('category') aria-invalid="true" aria-describedby="category-error" @enderror
                        >
                            <option value="">Pilih kategori kebutuhan</option>
                            @foreach ($categories as $category)
                                <option
                                    value="{{ $category->name }}"
                                    @selected(old('category') === $category->name)
                                >
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
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
                            placeholder="Kota atau alamat area"
                            class="w-full rounded-xl border border-[#CBD5E1] bg-white px-4 py-3 text-sm text-[#123B5D] outline-none transition placeholder:text-[#94A3B8] focus:border-[#14B8A6] focus:ring-4 focus:ring-[#14B8A6]/10"
                            @error('location') aria-invalid="true" aria-describedby="location-error" @enderror
                        >
                        @error('location')
                            <p id="location-error" class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="description" class="mb-2 block text-sm font-semibold text-[#334155]">
                            Deskripsi kebutuhan <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            id="description"
                            name="description"
                            rows="6"
                            maxlength="1500"
                            required
                            placeholder="Jelaskan kebutuhan, jumlah yang diperlukan, dan informasi lain yang membantu..."
                            class="w-full resize-y rounded-xl border border-[#CBD5E1] bg-white px-4 py-3 text-sm leading-6 text-[#123B5D] outline-none transition placeholder:text-[#94A3B8] focus:border-[#14B8A6] focus:ring-4 focus:ring-[#14B8A6]/10"
                            @error('description') aria-invalid="true" aria-describedby="description-error" @enderror
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <p id="description-error" class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="image" class="mb-2 block text-sm font-semibold text-[#334155]">
                            Foto pendukung <span class="font-normal text-[#64748B]">(opsional)</span>
                        </label>
                        <input
                            id="image"
                            name="image"
                            type="file"
                            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                            class="block w-full cursor-pointer rounded-xl border border-[#CBD5E1] bg-white text-sm text-[#64748B] file:mr-4 file:border-0 file:bg-[#EAF6F4] file:px-4 file:py-3 file:text-sm file:font-semibold file:text-[#0F766E] hover:file:bg-[#D5F1EC] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#14B8A6]"
                            @error('image') aria-invalid="true" aria-describedby="image-hint image-error" @enderror
                        >
                        <p id="image-hint" class="mt-2 text-xs text-[#64748B]">
                            Format JPG, PNG, atau WEBP. Ukuran maksimal 5 MB.
                        </p>
                        @error('image')
                            <p id="image-error" class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex flex-col-reverse gap-3 border-t border-[#E2E8F0] pt-6 sm:flex-row sm:justify-end">
                    <a
                        href="{{ route('reports.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-[#CBD5E1] px-5 py-3 text-sm font-semibold text-[#475569] transition hover:bg-slate-50"
                    >
                        Batal
                    </a>
                    <button
                        type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#14B8A6] px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#0D9488] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#14B8A6] focus-visible:ring-offset-2"
                    >
                        <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>
                        Kirim Laporan
                    </button>
                </div>
            </form>
        </section>
    </main>

    <x-footer />
</body>
</html>
