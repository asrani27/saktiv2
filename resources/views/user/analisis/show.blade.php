@extends('layouts.master')

@section('title', 'Analisis AI - Saktiv')
@section('page_title', 'Analisis SPJ dengan AI')

@section('content')
<div class="mx-auto max-w-4xl">
    {{-- Header --}}
    <div class="mb-6">
        <a href="{{ route('user.analisis.index') }}"
            class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 mb-4 transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Kembali ke Daftar</span>
        </a>
        <h1 class="text-2xl font-bold text-gray-800">{{ $analisi->judul }}</h1>
        <p class="text-gray-500 mt-1">Analisis dengan AI</p>
    </div>

    {{-- Flash Messages --}}
    @if (session('success'))
    <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3">
        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"
            stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span class="text-green-700 font-medium">{{ session('success') }}</span>
    </div>
    @endif

    @if (session('error'))
    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl flex items-center gap-3">
        <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"
            stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span class="text-red-700 font-medium">{{ session('error') }}</span>
    </div>
    @endif

    {{-- Add File Form --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Tambah File SPJ</h2>
        <form action="{{ route('user.analisis.file.store', $analisi->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="nama_file" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama File <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nama_file" name="nama_file" required
                        placeholder="Contoh: Kwitansi Pembelian"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                </div>
                <div class="md:col-span-2">
                    <label for="file_url" class="block text-sm font-medium text-gray-700 mb-2">
                        Upload File <span class="text-red-500">*</span>
                    </label>
                    <div class="flex gap-3">
                        <input type="file" id="file_url" name="file_url" accept=".pdf,.jpg,.jpeg,.png" required
                            class="flex-1 px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                        <button type="submit"
                            class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium transition-colors">
                            Upload
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- Files List --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-800">Daftar File ({{ $analisi->files->count() }})</h2>
        </div>
        
        @if ($analisi->files->count() > 0)
        <div class="space-y-4">
            @foreach ($analisi->files as $file)
            <div class="border border-gray-200 rounded-xl p-4">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex items-center gap-3">
                        <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <div>
                            <p class="font-medium text-gray-800">{{ $file->nama_file }}</p>
                            <a href="{{ Storage::url($file->file_url) }}" target="_blank"
                                class="text-sm text-blue-600 hover:text-blue-800">Lihat File</a>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        @if ($file->hasil_ocr)
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                            OCR Done
                        </span>
                        @else
                        <form action="{{ route('user.analisis.ocr.file', $file->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit"
                                class="px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs rounded-lg font-medium transition-colors">
                                OCR
                            </button>
                        </form>
                        @endif
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
                </div>
                
                @if ($file->hasil_ocr)
                <div class="bg-gray-50 rounded-lg p-3 text-sm text-gray-600 max-h-40 overflow-y-auto border border-gray-200">
                    <pre class="whitespace-pre-wrap font-sans">{{ Str::limit($file->hasil_ocr, 500) }}@if(strlen($file->hasil_ocr) > 500)...@endif</pre>
                </div>
                @else
                <div class="bg-gray-50 rounded-lg p-3 text-sm text-gray-400 border border-gray-200">
                    <em>Belum ada hasil OCR</em>
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-8 text-gray-500">
            <p>Tidak ada file yang diupload. Tambahkan file di atas.</p>
        </div>
        @endif
    </div>

    {{-- AI Analysis Form --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Ajukan Pertanyaan</h2>
        <form action="{{ route('user.analisis.analisis', $analisi->id) }}" method="POST" id="analisis-form">
            @csrf
            <div class="mb-4">
                <label for="prompt" class="block text-sm font-medium text-gray-700 mb-2">Prompt / Pertanyaan</label>
                <textarea 
                    id="prompt" 
                    name="prompt" 
                    rows="4" 
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all resize-none"
                    placeholder="Contoh: Analisis dokumen ini dan jelaskan hal-hal penting yang perlu diperhatikan dalam SPJ..."
                    required
                >{{ old('prompt') }}</textarea>
                @error('prompt')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <button 
                type="submit"
                class="w-full sm:w-auto px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-xl font-medium shadow-lg shadow-purple-600/30 transition-all duration-150 flex items-center justify-center gap-2"
            >
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                </svg>
                <span>Analisis</span>
            </button>
        </form>
    </div>

    {{-- AI Response --}}
    @if ($analisi->hasil_analisis)
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-800">Respon AI</h2>
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-teal-100 text-teal-700">
                <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Completed
            </span>
        </div>
        <div class="bg-purple-50 rounded-xl p-4 text-sm text-gray-700 max-h-96 overflow-y-auto border border-purple-100">
            <pre class="whitespace-pre-wrap font-sans">{{ $analisi->hasil_analisis }}</pre>
        </div>
    </div>
    @endif
</div>
@endsection