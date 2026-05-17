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
        <h1 class="text-2xl font-bold text-gray-800">Analisis dengan AI</h1>
        <p class="text-gray-500 mt-1">{{ $analisi->judul }}</p>
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

    {{-- OCR Result Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-800">Hasil OCR</h2>
            @if ($analisi->status_ocr === 'completed')
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Selesai
            </span>
            @elseif ($analisi->status_ocr === 'failed')
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Gagal
            </span>
            @else
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">
                <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Pending
            </span>
            @endif
        </div>
        <div class="bg-gray-50 rounded-xl p-4 text-sm text-gray-600 max-h-60 overflow-y-auto border border-gray-200">
            <pre class="whitespace-pre-wrap font-sans">{{ $analisi->hasil_ocr ?? 'Tidak ada hasil OCR' }}</pre>
        </div>
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
        <div class="mt-4 flex items-center gap-3">
            <a href="{{ route('user.analisis.show', $analisi->id) }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-medium transition-all duration-150">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                <span>Reset</span>
            </a>
        </div>
    </div>
    @endif
</div>
@endsection