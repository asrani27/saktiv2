@extends('layouts.master')

@section('title', 'Edit Analisis - Saktiv')
@section('page_title', 'Edit Analisis Data SPJ')

@section('content')
<div class="mx-auto max-w-2xl">
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('user.analisis.index') }}"
                class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                <svg class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Edit Analisis Data SPJ</h1>
        </div>
        <p class="text-gray-500">Perbarui data analisis dan file SPJ</p>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('user.analisis.update', $analisi->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Judul --}}
            <div class="mb-6">
                <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">
                    Judul <span class="text-red-500">*</span>
                </label>
                <input type="text" id="judul" name="judul" value="{{ old('judul', $analisi->judul) }}" required
                    placeholder="Masukkan judul analisis..."
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all @error('judul') border-red-500 @enderror">
                @error('judul')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Current Files List --}}
            @if ($analisi->files->count() > 0)
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">File Saat Ini ({{ $analisi->files->count() }} file)</label>
                <div class="space-y-2">
                    @foreach ($analisi->files as $file)
                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-200">
                        <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-800">{{ $file->nama_file }}</p>
                        </div>
                        <a href="{{ Storage::url($file->file_url) }}" target="_blank"
                            class="text-sm text-blue-600 hover:text-blue-800">Lihat</a>
                        <form action="{{ route('user.analisis.file.destroy', $file->id) }}" method="POST" class="inline"
                            onsubmit="return confirm('Yakin ingin menghapus file ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Add New Files --}}
            <div class="mb-6">
                <label for="files" class="block text-sm font-medium text-gray-700 mb-2">
                    Tambah File Baru
                </label>
                <div class="relative">
                    <input type="file" id="files" name="files[]" multiple accept=".pdf,.jpg,.jpeg,.png"
                        class="hidden" onchange="updateFileNames(this)">
                    <label for="files"
                        class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:bg-gray-50 transition-colors">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <p class="mb-1 text-sm text-gray-500">
                                <span class="font-semibold">Klik untuk upload</span> atau drag & drop
                            </p>
                            <p class="text-xs text-gray-400">PDF, JPG, JPEG, PNG (Maksimal 10MB per file)</p>
                            <p id="file-count" class="mt-2 text-sm text-blue-600 font-medium hidden"></p>
                        </div>
                    </label>
                </div>
                @error('files.*')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('user.analisis.index') }}"
                    class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-medium transition-all duration-150">
                    Batal
                </a>
                <button type="submit"
                    class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium shadow-lg shadow-blue-600/30 transition-all duration-150">
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        Perbarui Data
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function updateFileNames(input) {
        const fileCount = document.getElementById('file-count');
        if (input.files && input.files.length > 0) {
            fileCount.textContent = input.files.length + ' file(s) terpilih';
            fileCount.classList.remove('hidden');
        } else {
            fileCount.classList.add('hidden');
        }
    }
</script>
@endpush
@endsection