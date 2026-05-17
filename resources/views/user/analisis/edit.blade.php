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

            {{-- Current File --}}
            @if ($analisi->file_spj)
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">File Saat Ini</label>
                <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl border border-gray-200">
                    <svg class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-800">{{ basename($analisi->file_spj) }}</p>
                        <a href="{{ Storage::url($analisi->file_spj) }}" target="_blank"
                            class="text-sm text-blue-600 hover:text-blue-800">Lihat File</a>
                    </div>
                </div>
            </div>
            @endif

            {{-- Upload New File --}}
            <div class="mb-6">
                <label for="file_spj" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ $analisi->file_spj ? 'Ganti File SPJ' : 'Upload File SPJ' }}
                </label>
                <div class="relative">
                    <input type="file" id="file_spj" name="file_spj" accept=".pdf,.jpg,.jpeg,.png"
                        class="hidden" onchange="updateFileName(this)">
                    <label for="file_spj"
                        class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:bg-gray-50 transition-colors">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-10 h-10 text-gray-400 mb-3" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <p class="mb-2 text-sm text-gray-500">
                                <span class="font-semibold">Klik untuk upload</span> atau drag & drop
                            </p>
                            <p class="text-xs text-gray-400">PDF, JPG, JPEG, PNG (Maksimal 10MB)</p>
                            <p id="file-name" class="mt-2 text-sm text-blue-600 font-medium hidden"></p>
                        </div>
                    </label>
                </div>
                @error('file_spj')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
                <p class="mt-2 text-xs text-gray-500">Kosongkan jika tidak ingin更换文件</p>
            </div>

            {{-- Status Info --}}
            <div class="mb-6 p-4 bg-gray-50 border border-gray-200 rounded-xl">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-gray-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="text-sm text-gray-600">
                        <p class="font-medium">Informasi Status:</p>
                        <div class="mt-2 flex items-center gap-2">
                            <span
                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $analisi->status_badge['bg'] }} {{ $analisi->status_badge['text'] }}">
                                {{ $analisi->status_badge['label'] }}
                            </span>
                            <span class="text-xs text-gray-400">Status OCR saat ini</span>
                        </div>
                    </div>
                </div>
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
    function updateFileName(input) {
        const fileName = document.getElementById('file-name');
        if (input.files && input.files[0]) {
            fileName.textContent = 'File terpilih: ' + input.files[0].name;
            fileName.classList.remove('hidden');
        } else {
            fileName.classList.add('hidden');
        }
    }
</script>
@endpush
@endsection