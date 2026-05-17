@extends('layouts.master')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Users -->
    <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-lg p-6 border border-white/50 hover:shadow-xl transition-shadow duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Users</p>
                <p class="text-3xl font-bold text-gray-800">1,234</p>
                <p class="text-sm text-green-600 mt-1 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                    </svg>
                    +12%
                </p>
            </div>
            <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center">
                <svg class="w-7 h-7 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Active Sessions -->
    <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-lg p-6 border border-white/50 hover:shadow-xl transition-shadow duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Active Sessions</p>
                <p class="text-3xl font-bold text-gray-800">89</p>
                <p class="text-sm text-green-600 mt-1 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                    </svg>
                    +5%
                </p>
            </div>
            <div class="w-14 h-14 bg-green-100 rounded-2xl flex items-center justify-center">
                <svg class="w-7 h-7 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Chat Messages -->
    <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-lg p-6 border border-white/50 hover:shadow-xl transition-shadow duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Chat Messages</p>
                <p class="text-3xl font-bold text-gray-800">5,678</p>
                <p class="text-sm text-green-600 mt-1 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                    </svg>
                    +23%
                </p>
            </div>
            <div class="w-14 h-14 bg-purple-100 rounded-2xl flex items-center justify-center">
                <svg class="w-7 h-7 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- System Status -->
    <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-lg p-6 border border-white/50 hover:shadow-xl transition-shadow duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">System Status</p>
                <p class="text-xl font-bold text-green-600">Online</p>
                <p class="text-sm text-gray-400 mt-1">All systems running</p>
            </div>
            <div class="w-14 h-14 bg-indigo-100 rounded-2xl flex items-center justify-center">
                <svg class="w-7 h-7 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Charts and Activity -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Activity -->
    <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800">Recent Activity</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <div class="flex items-start gap-4 p-4 bg-blue-50 rounded-xl">
                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800">New user registered</p>
                        <p class="text-xs text-gray-500 mt-1">John Doe joined the platform</p>
                    </div>
                    <span class="text-xs text-gray-400 shrink-0">2 min ago</span>
                </div>

                <div class="flex items-start gap-4 p-4 bg-green-50 rounded-xl">
                    <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800">Task completed</p>
                        <p class="text-xs text-gray-500 mt-1">System backup successfully</p>
                    </div>
                    <span class="text-xs text-gray-400 shrink-0">15 min ago</span>
                </div>

                <div class="flex items-start gap-4 p-4 bg-purple-50 rounded-xl">
                    <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800">New chat message</p>
                        <p class="text-xs text-gray-500 mt-1">AI assistant responded</p>
                    </div>
                    <span class="text-xs text-gray-400 shrink-0">1 hour ago</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800">Quick Actions</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('admin.users') }}"
                    class="flex flex-col items-center justify-center p-6 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl text-white hover:shadow-lg hover:scale-105 transition-all duration-200">
                    <svg class="w-8 h-8 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    <span class="font-medium">Add User</span>
                </a>

                <a href="{{ route('admin.chat') }}"
                    class="flex flex-col items-center justify-center p-6 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl text-white hover:shadow-lg hover:scale-105 transition-all duration-200">
                    <svg class="w-8 h-8 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <span class="font-medium">Open Chat</span>
                </a>

                <a href="#"
                    class="flex flex-col items-center justify-center p-6 bg-gradient-to-br from-green-500 to-green-600 rounded-xl text-white hover:shadow-lg hover:scale-105 transition-all duration-200">
                    <svg class="w-8 h-8 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="font-medium">Reports</span>
                </a>

                <a href="{{ route('admin.profile') }}"
                    class="flex flex-col items-center justify-center p-6 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl text-white hover:shadow-lg hover:scale-105 transition-all duration-200">
                    <svg class="w-8 h-8 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="font-medium">Settings</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
