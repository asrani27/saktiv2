<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Saktiv')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen">
    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        @include('layouts.sidebar')

        {{-- Main Content --}}
        <div id="mainContent" class="flex-1 lg:ml-64 xl:ml-72">

            {{-- Top Navbar --}}
            <header class="bg-white shadow-sm sticky top-0 z-40">
                <div class="flex items-center justify-between px-4 py-3">
                    {{-- Mobile Menu Button --}}
                    <button onclick="toggleSidebar()"
                        class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors">
                        <svg class="w-6 h-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    {{-- Page Title (Hidden on mobile) --}}
                    <div class="hidden sm:block">
                        <h2 class="text-lg font-semibold text-gray-800">@yield('page_title', 'Dashboard')</h2>
                    </div>

                    {{-- User Menu --}}
                    <div class="flex items-center gap-3">
                        <div class="hidden sm:flex items-center gap-2">
                            <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                                <span class="text-white text-sm font-medium">{{ substr(Auth::user()->name ?? 'U', 0, 1)
                                    }}</span>
                            </div>
                            <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name ?? 'User' }}</span>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Page Content --}}
            <main
                class="p-6 min-h-[calc(100vh-64px)] bg-gradient-to-br from-blue-200 via-blue-100 to-indigo-200 relative">
                <div class="relative z-10">
                    @yield('content')
                </div>
            </main>

        </div>
    </div>

    {{-- Mobile Sidebar Overlay --}}
    <div id="sidebarOverlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-40 lg:hidden hidden"></div>

    {{-- JavaScript --}}
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            sidebar.classList.toggle('-translate-x-full');
            sidebar.classList.toggle('translate-x-0');
            overlay.classList.toggle('hidden');
        }
    </script>

    @stack('scripts')
</body>

</html>