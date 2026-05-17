@extends('layouts.master')

@section('title', 'Dashboard - User')

@section('content')
<div class="mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">User Dashboard</h1>
        <p class="text-gray-600 mt-2">Selamat datang di halaman dashboard user.</p>
    </div>

    <!-- Welcome Card -->
    <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center">
                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-semibold text-gray-800">Halo, {{ auth()->user()->name }}!</h2>
                <p class="text-gray-500">Role: <span class="font-medium text-blue-600">{{ auth()->user()->role
                        }}</span></p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                    </svg>
                </div>
                <span class="text-2xl font-bold text-gray-800">0</span>
            </div>
            <h3 class="text-gray-600 font-medium">Aktivitas Saya</h3>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="text-2xl font-bold text-gray-800">0</span>
            </div>
            <h3 class="text-gray-600 font-medium">Total Aktivitas</h3>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                    </svg>
                </div>
                <span class="text-2xl font-bold text-gray-800">0</span>
            </div>
            <h3 class="text-gray-600 font-medium">Statistik</h3>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-2xl shadow-lg p-8">
        <h3 class="text-xl font-semibold text-gray-800 mb-6">Aksi Cepat</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <button class="flex items-center gap-4 p-4 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors group">
                <div
                    class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center group-hover:scale-105 transition-transform">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </div>
                <div class="text-left">
                    <h4 class="font-semibold text-gray-800">Tambah Aktivitas</h4>
                    <p class="text-sm text-gray-500">Buat aktivitas baru</p>
                </div>
            </button>

            <button
                class="flex items-center gap-4 p-4 bg-green-50 rounded-xl hover:bg-green-100 transition-colors group">
                <div
                    class="w-12 h-12 bg-green-600 rounded-xl flex items-center justify-center group-hover:scale-105 transition-transform">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.137a48.354 48.354 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.87.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                    </svg>
                </div>
                <div class="text-left">
                    <h4 class="font-semibold text-gray-800">Lihat Laporan</h4>
                    <p class="text-sm text-gray-500">Statistik aktivitas</p>
                </div>
            </button>

            <button
                class="flex items-center gap-4 p-4 bg-purple-50 rounded-xl hover:bg-purple-100 transition-colors group">
                <div
                    class="w-12 h-12 bg-purple-600 rounded-xl flex items-center justify-center group-hover:scale-105 transition-transform">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                </div>
                <div class="text-left">
                    <h4 class="font-semibold text-gray-800">Profil Saya</h4>
                    <p class="text-sm text-gray-500">Kelola informasi akun</p>
                </div>
            </button>

            <form method="POST" action="{{ route('logout') }}" class="block">
                @csrf
                <button type="submit"
                    class="flex items-center gap-4 p-4 bg-red-50 rounded-xl hover:bg-red-100 transition-colors group w-full text-left">
                    <div
                        class="w-12 h-12 bg-red-600 rounded-xl flex items-center justify-center group-hover:scale-105 transition-transform">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800">Keluar</h4>
                        <p class="text-sm text-gray-500">Logout dari aplikasi</p>
                    </div>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection