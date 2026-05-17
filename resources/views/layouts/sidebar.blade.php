<!-- Sidebar -->
<aside id="sidebar"
    class="fixed top-0 left-0 z-50 h-screen w-64 sm:w-72 bg-gradient-to-b from-blue-700 via-blue-600 to-indigo-700 shadow-2xl transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">

    <!-- Mobile Close Button -->
    <button onclick="toggleSidebar()"
        class="lg:hidden absolute top-4 right-4 p-2 text-white/70 hover:text-white hover:bg-white/10 rounded-lg transition-all z-50">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>

    <!-- Logo Section -->
    <div class="px-5 sm:px-6 py-5 border-b border-white/10">
        <div class="flex items-center gap-3">
            <div class="w-11 h-11 sm:w-12 sm:h-12 bg-white rounded-xl shadow-lg flex items-center justify-center">
                <svg class="w-6 h-6 sm:w-7 sm:h-7 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                </svg>
            </div>
            <div>
                <h1 class="text-lg sm:text-xl font-bold text-white">Saktiv</h1>
                <p class="text-xs text-blue-200">Admin Panel</p>
            </div>
        </div>
    </div>

    <!-- Navigation - Conditionally load menu based on user role -->
    @if(auth()->user()->role === 'admin')
        @include('layouts.partials.menu_admin')
    @else
        @include('layouts.partials.menu_user')
    @endif

    <!-- Footer -->
    <div
        class="absolute bottom-0 left-0 right-0 px-4 py-4 border-t border-white/10 bg-gradient-to-t from-blue-800/50 to-transparent">
        <p class="text-xs text-blue-200 text-center">Saktiv v1.0.0</p>
    </div>
</aside>