@extends('layouts.master')

@section('title', 'Tambah Analisis - Saktiv')
@section('page_title', 'Tambah Analisis Data')

@section('content')
<div class="mx-auto max-w-2xl">
    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('user.analisis.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                <svg class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Tambah Analisis Data</h1>
        </div>
        <p class="text-gray-500">Tambahkan data analisis baru</p>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <form action="{{ route('user.analisis.store') }}" method="POST">
            @csrf

            {{-- Judul --}}
            <div class="mb-6">
                <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">
                    Judul <span class="text-red-500">*</span>
                </label>
                <input type="text" id="judul" name="judul" value="{{ old('judul') }}" required
                    placeholder="Masukkan judul analisis..."
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all @error('judul') border-red-500 @enderror">
                @error('judul')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Info Box --}}
            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-xl">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="text-sm text-blue-700">
                        <p class="font-medium">Informasi:</p>
                        <p class="mt-1">Setelah menyimpan, Anda dapat menambahkan file-file SPJ yang ingin dianalisis.</p>
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
                        Simpan Data
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection