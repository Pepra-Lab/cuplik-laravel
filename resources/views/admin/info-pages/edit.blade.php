@extends('layouts.admin')

@section('title', 'Edit Halaman Info')

@section('content')
<div class="space-y-5">

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-sm font-extrabold text-gray-900 dark:text-white">Edit Halaman: {{ $page->judul }}</h2>
            <p class="text-xs text-gray-400">Perubahan akan langsung tampil di halaman /info/{{ $page->slug }} pada kanal berita.</p>
        </div>
        <a href="{{ route('admin.info-pages.index') }}" class="text-xs font-semibold text-gray-500 hover:text-[#008a24]">&larr; Kembali</a>
    </div>

    <div class="bg-white dark:bg-[#121914] rounded-xl border border-gray-200 dark:border-zinc-800 shadow-sm max-w-4xl">
        <form id="editPageForm" action="{{ route('admin.info-pages.update', $page->slug) }}" method="POST" class="p-5 space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Label / Badge</label>
                    <input type="text" name="badge" value="{{ old('badge', $page->badge) }}" placeholder="Contoh: Informasi Redaksi"
                        class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Judul Halaman <span class="text-red-500">*</span></label>
                    <input type="text" name="judul" required value="{{ old('judul', $page->judul) }}"
                        class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
                    @error('judul') <span class="text-[11px] text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Subjudul</label>
                <input type="text" name="subjudul" value="{{ old('subjudul', $page->subjudul) }}" placeholder="Opsional, tampil di bawah judul"
                    class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#008a24]">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">Isi Halaman <span class="text-red-500">*</span></label>

                <textarea id="kontenEditor" name="konten" rows="16" required
                    class="w-full px-3 py-2 bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-lg text-xs text-gray-900 dark:text-white leading-relaxed focus:outline-none focus:ring-2 focus:ring-[#008a24]">{{ old('konten', $page->konten) }}</textarea>
                @error('konten') <span class="text-[11px] text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end pt-2 border-t border-gray-100 dark:border-zinc-800">
                <button type="submit" class="px-5 py-2 bg-[#008a24] hover:bg-[#006f1c] text-white font-bold text-xs rounded-lg transition-colors shadow-sm">
                    Simpan Halaman
                </button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
    /* Samakan tinggi dan warna area tulis CKEditor dengan textarea lain di CMS. */
    .ck-editor__editable_inline {
        min-height: 420px;
    }
    [data-theme="dark"] .ck.ck-editor__main > .ck-editor__editable,
    [data-theme="dark"] .ck.ck-toolbar {
        background: #27272a;
        color: #e5e7eb;
        border-color: #3f3f46;
    }
    [data-theme="dark"] .ck.ck-button,
    [data-theme="dark"] .ck.ck-dropdown .ck-button {
        color: #e5e7eb;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
    // Isi Halaman dipakai sebagai WYSIWYG lewat CKEditor, bukan textarea manual,
    // supaya admin tidak perlu menulis tag HTML sendiri untuk bold/italic/link/tabel.
    ClassicEditor
        .create(document.getElementById('kontenEditor'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'insertTable', 'blockQuote', '|', 'undo', 'redo'],
        })
        .then((editor) => {
            // CKEditor menggantikan tampilan textarea secara visual, tapi textarea
            // aslinya tetap ada di DOM dan dibaca saat form disubmit. Jadi sebelum
            // submit, konten editor disalin dulu kembali ke textarea tersebut.
            document.getElementById('editPageForm').addEventListener('submit', () => {
                editor.updateSourceElement();
            });
        })
        .catch((error) => console.error('Gagal memuat editor konten:', error));
</script>
@endpush
@endsection
