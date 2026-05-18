@extends('layouts.master')

@section('title', 'Analisis Data')
@section('page_title', 'Analisis Data')

@section('content')
<div class="mx-auto">
    {{-- Header --}}
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Analisis Data</h1>
            <p class="text-gray-500 mt-1">Kelola data analisis dan upload file</p>
        </div>
        <a href="{{ route('user.analisis.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium shadow-lg shadow-blue-600/30 transition-all duration-150">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            <span>Tambah Analisis</span>
        </a>
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

    {{-- Search & Filter Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6">
        <form method="GET" action="{{ route('user.analisis.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari judul..."
                    class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
            </div>
            <button type="submit"
                class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium transition-all duration-150">
                Cari
            </button>
            @if ($search)
            <a href="{{ route('user.analisis.index') }}"
                class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-medium transition-all duration-150">
                Reset
            </a>
            @endif
        </form>
    </div>

    {{-- Analisis Table Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        {{-- Desktop Table View (hidden on mobile) --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-600 to-indigo-600 border-b border-blue-700">
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            Judul</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            Files</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            File Count</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            Tanggal</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-white uppercase tracking-wider">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($analisis as $item)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-medium text-gray-800">{{ $item->judul }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @if ($item->files->count() > 0)
                            <div class="flex flex-wrap gap-1">
                                @foreach ($item->files->take(3) as $file)
                                <a href="{{ Storage::url($file->file_url) }}" target="_blank"
                                    class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 text-xs">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    {{ Str::limit($file->nama_file, 15) }}
                                </a>
                                @endforeach
                                @if ($item->files->count() > 3)
                                <span class="text-xs text-gray-500">+{{ $item->files->count() - 3 }} more</span>
                                @endif
                            </div>
                            @else
                            <span class="text-gray-400 text-sm">Tidak ada file</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-gray-600">{{ $item->files->count() }} file(s)</span>
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $item->status_badge['bg'] }} {{ $item->status_badge['text'] }}">
                                {{ $item->status_badge['label'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-500 text-sm">{{ $item->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('user.analisis.show', $item->id) }}"
                                    class="p-2 text-purple-600 hover:bg-purple-50 rounded-lg transition-colors"
                                    title="Detail">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                <a href="{{ route('user.analisis.edit', $item->id) }}"
                                    class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                    title="Edit">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                </a>
                                <form action="{{ route('user.analisis.destroy', $item->id) }}" method="POST"
                                    class="inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                        title="Hapus">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                <p class="text-gray-500 font-medium">Tidak ada data analisis ditemukan</p>
                                <p class="text-gray-400 text-sm mt-1">
                                    @if ($search)
                                    Coba ubah kata kunci pencarian
                                    @else
                                    Tambahkan data analisis baru untuk memulai
                                    @endif
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile Card View (hidden on desktop) --}}
        <div class="md:hidden divide-y divide-gray-100">
            @forelse ($analisis as $item)
            <div class="p-4 hover:bg-gray-50 transition-colors">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $item->judul }}</p>
                        <p class="text-sm text-gray-500 mt-1">{{ $item->created_at->format('d M Y') }}</p>
                    </div>
                    <span
                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $item->status_badge['bg'] }} {{ $item->status_badge['text'] }}">
                        {{ $item->status_badge['label'] }}
                    </span>
                </div>

                <div class="mt-3 space-y-2">
                    @if ($item->files->count() > 0)
                    <div class="text-sm text-gray-600">
                        <span class="text-gray-400">{{ $item->files->count() }} file(s)</span>
                    </div>
                    @endif
                </div>

                <div class="mt-4 flex items-center justify-end gap-2">
                    <a href="{{ route('user.analisis.show', $item->id) }}"
                        class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 bg-purple-50 hover:bg-purple-100 text-purple-600 rounded-xl font-medium transition-all duration-150">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <span>Detail</span>
                    </a>
                    <a href="{{ route('user.analisis.edit', $item->id) }}"
                        class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-xl font-medium transition-all duration-150">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                        <span>Edit</span>
                    </a>
                    <form action="{{ route('user.analisis.destroy', $item->id) }}" method="POST" class="flex-1 inline"
                        onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-xl font-medium transition-all duration-150">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>
                            <span>Hapus</span>
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="p-8 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                <p class="text-gray-500 font-medium">Tidak ada data analisis ditemukan</p>
                <p class="text-gray-400 text-sm mt-1">
                    @if ($search)
                    Coba ubah kata kunci pencarian
                    @else
                    Tambahkan data analisis baru untuk memulai
                    @endif
                </p>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if ($analisis->hasPages())
        <div class="px-4 py-4 border-t border-gray-100 md:px-6">
            {{ $analisis->links() }}
        </div>
        @endif
    </div>

    {{-- Summary --}}
    <div class="mt-4 text-sm text-gray-500 text-center">
        Menampilkan {{ $analisis->count() }} dari {{ $analisis->total() }} data
    </div>
</div>
@endsection