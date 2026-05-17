<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - {{ config('app.name', 'Laravel') }}</title>

    @fonts

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="bg-gradient-to-br from-blue-200 via-blue-100 to-indigo-200 min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    <!-- SVG Patterns for Wave/Circle Background -->
    <svg class="absolute inset-0 w-full h-full opacity-60" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <!-- Circle Pattern 1 -->
            <pattern id="circles1" x="0" y="0" width="120" height="120" patternUnits="userSpaceOnUse">
                <circle cx="60" cy="60" r="40" fill="none" stroke="#2563eb" stroke-width="2" opacity="0.5" />
                <circle cx="60" cy="60" r="25" fill="none" stroke="#4f46e5" stroke-width="1.5" opacity="0.4" />
                <circle cx="60" cy="60" r="10" fill="#3b82f6" opacity="0.2" />
            </pattern>
            <!-- Wave Pattern -->
            {{-- <pattern id="waves" x="0" y="0" width="200" height="100" patternUnits="userSpaceOnUse">
                <path d="M0 30 Q25 10 50 30 T100 30 T150 30 T200 30" fill="none" stroke="#60a5fa" stroke-width="2.5"
                    opacity="0.5" />
                <path d="M0 50 Q25 30 50 50 T100 50 T150 50 T200 50" fill="none" stroke="#3b82f6" stroke-width="2"
                    opacity="0.4" />
                <path d="M0 70 Q25 50 50 70 T100 70 T150 70 T200 70" fill="none" stroke="#6366f1" stroke-width="2"
                    opacity="0.35" />
            </pattern> --}}
            <!-- Dot Pattern -->
            <pattern id="dots" x="0" y="0" width="30" height="30" patternUnits="userSpaceOnUse">
                <circle cx="15" cy="15" r="3" fill="#3b82f6" opacity="0.4" />
            </pattern>
        </defs>
        <rect width="100%" height="100%" fill="url(#circles1)" />
        <rect width="100%" height="100%" fill="url(#waves)" />
        <rect width="100%" height="100%" fill="url(#dots)" opacity="0.6" />
    </svg>

    <!-- Large decorative gradient circles -->
    <div
        class="absolute top-0 left-0 w-[600px] h-[600px] bg-gradient-to-br from-blue-400/50 via-blue-300/30 to-transparent rounded-full -translate-x-1/4 -translate-y-1/4">
    </div>
    <div
        class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-gradient-to-tl from-indigo-400/50 via-indigo-300/30 to-transparent rounded-full translate-x-1/4 translate-y-1/4">
    </div>
    <div
        class="absolute top-1/3 right-0 w-[400px] h-[400px] bg-gradient-to-bl from-blue-300/40 to-transparent rounded-full">
    </div>
    <div
        class="absolute bottom-1/4 left-0 w-[350px] h-[350px] bg-gradient-to-tr from-indigo-300/40 to-transparent rounded-full">
    </div>

    <!-- Visible ring circles -->
    <div class="absolute top-1/4 left-1/4 w-40 h-40 border-[3px] border-blue-400/40 rounded-full"></div>
    <div class="absolute bottom-1/4 right-1/4 w-56 h-56 border-[4px] border-indigo-400/40 rounded-full"></div>
    <div class="absolute top-2/3 left-1/3 w-28 h-28 border-[2px] border-blue-500/30 rounded-full"></div>
    <div class="absolute bottom-1/3 right-1/3 w-44 h-44 border-[3px] border-indigo-500/30 rounded-full"></div>

    <!-- Additional small decorative circles -->
    <div class="absolute top-1/2 left-1/4 w-16 h-16 bg-blue-200/30 rounded-full"></div>
    <div class="absolute bottom-1/2 right-1/4 w-20 h-20 bg-indigo-200/30 rounded-full"></div>
    <div class="absolute top-1/3 right-1/3 w-12 h-12 bg-blue-300/40 rounded-full"></div>
    <div class="absolute bottom-1/4 left-2/3 w-14 h-14 bg-indigo-300/40 rounded-full"></div>

    <div
        class="w-full max-w-5xl mx-auto bg-white/90 backdrop-blur-sm rounded-2xl shadow-2xl overflow-hidden relative z-10">
        <div class="flex flex-col lg:flex-row">
            <!-- Left Column - Branding -->
            <div
                class="lg:w-1/2 bg-gradient-to-br from-blue-600 to-blue-700 p-8 lg:p-12 flex flex-col justify-center items-center text-center">
                <!-- App Icon -->
                <div
                    class="w-24 h-24 bg-white rounded-2xl shadow-lg flex items-center justify-center mb-8 overflow-hidden">
                    <img src="{{ asset('logo/sakti.png') }}" alt="SISAKTI Logo" class="w-20 h-20 object-contain" />
                </div>

                <!-- App Title -->
                <h1 class="text-3xl lg:text-4xl font-bold text-white mb-4">SISAKTI</h1>

                <!-- Slogan -->
                <p class="text-blue-100 text-lg lg:text-xl max-w-md">
                    Sistem Integrasi Sinkronisasi Audit Ketataan Instansi
                </p>

                <!-- Decorative Elements -->
                <div class="mt-12 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-blue-400 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-blue-300 flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Right Column - Login Form -->
            <div class="lg:w-1/2 p-8 lg:p-12 flex items-center justify-center">
                <div class="w-full max-w-md">
                    <!-- Header -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">Masuk</h2>
                        <p class="text-gray-500">Silakan masukkan username dan password Anda</p>
                    </div>

                    <!-- Error Messages -->
                    @if ($errors->any())
                    <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-red-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                            <div class="text-sm text-red-700">
                                @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Login Form -->
                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        <!-- Username Field -->
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                                Username
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                    </svg>
                                </div>
                                <input id="username" name="username" type="text" value="{{ old('username') }}" required
                                    autofocus autocomplete="username" placeholder="Masukkan username"
                                    class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-200 bg-white text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-150" />
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Password
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                    </svg>
                                </div>
                                <input id="password" name="password" type="password" required
                                    autocomplete="current-password" placeholder="Masukkan password"
                                    class="w-full pl-10 pr-12 py-3 rounded-lg border border-gray-200 bg-white text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-150" />
                                <button type="button" onclick="togglePassword()"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors p-1"
                                    aria-label="Toggle password visibility">
                                    <svg id="eye-icon" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <svg id="eye-off-icon" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center justify-between">
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input type="checkbox" name="remember" id="remember"
                                    class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer" />
                                <span class="text-sm text-gray-600 group-hover:text-blue-600 transition-colors">
                                    Ingat saya
                                </span>
                            </label>
                            @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                class="text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors">
                                Lupa password?
                            </a>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full py-3 px-4 rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700 transition-all duration-150 active:scale-[0.98] flex items-center justify-center gap-2 shadow-lg shadow-blue-600/30">
                            <span>Masuk</span>
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </button>
                    </form>

                    <!-- Register Link -->
                    @if (Route::has('register'))
                    <p class="mt-8 text-center text-sm text-gray-500">
                        Belum punya akun?
                        <a href="{{ route('register') }}"
                            class="font-semibold text-blue-600 hover:text-blue-700 transition-colors">
                            Daftar sekarang
                        </a>
                    </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
                const passwordInput = document.getElementById('password');
                const eyeIcon = document.getElementById('eye-icon');
                const eyeOffIcon = document.getElementById('eye-off-icon');
                
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeIcon.classList.add('hidden');
                    eyeOffIcon.classList.remove('hidden');
                } else {
                    passwordInput.type = 'password';
                    eyeIcon.classList.remove('hidden');
                    eyeOffIcon.classList.add('hidden');
                }
            }
    </script>
</body>

</html>