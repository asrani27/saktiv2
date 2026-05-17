<nav class="px-4 py-6 overflow-y-auto h-[calc(100vh-88px)]">
    <!-- Menu Section -->
    <div class="mb-6">
        <p class="px-3 mb-3 text-xs font-semibold text-blue-200 uppercase tracking-wider">Menu</p>
        <ul class="space-y-1">
            <!-- Dashboard -->
            <li>
                <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-white transition-all duration-150 
                    {{ request()->routeIs('user.dashboard') ? 'bg-white/20 shadow-lg' : 'hover:bg-white/10' }}">
                    <svg class="w-5 h-5 text-blue-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span
                        class="font-medium {{ request()->routeIs('user.dashboard') ? 'text-white' : 'text-white/90' }}">Dashboard</span>
                </a>
            </li>

            <!-- Chat AI -->
            <li>
                <a href="{{ route('user.chat.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-white transition-all duration-150 
                    {{ request()->routeIs('user.chat.*') ? 'bg-white/20 shadow-lg' : 'hover:bg-white/10' }}">
                    <svg class="w-5 h-5 text-blue-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <span
                        class="font-medium {{ request()->routeIs('user.chat') ? 'text-white' : 'text-white/90' }}">Chat
                        AI</span>
                </a>
            </li>

            <!-- Analisis Data -->
            <li>
                <a href="{{ route('user.analisis.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-white transition-all duration-150 
                    {{ request()->routeIs('user.analisis.*') ? 'bg-white/20 shadow-lg' : 'hover:bg-white/10' }}">
                    <svg class="w-5 h-5 text-blue-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <span
                        class="font-medium {{ request()->routeIs('user.analisis') ? 'text-white' : 'text-white/90' }}">Analisis
                        Data</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Setting Section -->
    <div>
        <p class="px-3 mb-3 text-xs font-semibold text-blue-200 uppercase tracking-wider">Setting</p>
        <ul class="space-y-1">

            <!-- Keluar -->
            <li>
                <form method="POST" action="{{ route('logout') }}" class="m-0"
                    onsubmit="return confirm('Apakah Anda yakin ingin keluar?');">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-white hover:bg-red-500/20 transition-all duration-150">
                        <svg class="w-5 h-5 text-red-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="font-medium text-white/90">Keluar</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>
</nav>