<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <div class="relative min-h-screen bg-gray-100">
        @if (Route::has('login'))
            <div class="p-6 text-right">
                @auth
                    <a href="{{ url('/dashboard') }}" class="font-medium text-indigo-600 hover:text-indigo-800 focus:outline-none focus:underline transition ease-in-out duration-150">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-800 focus:outline-none focus:underline transition ease-in-out duration-150">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 font-medium text-indigo-600 hover:text-indigo-800 focus:outline-none focus:underline transition ease-in-out duration-150">Register</a>
                    @endif
                @endauth
            </div>
        @endif

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="flex flex-col items-center justify-center">
                <h1 class="text-4xl font-bold text-center text-gray-900 mb-6">
                    Selamat Datang di Sistem Manajemen Proyek
                </h1>
                
                <p class="text-lg text-center text-gray-600 mb-8 max-w-3xl">
                    Platform untuk mengelola proyek, tugas, dan kolaborasi tim Anda dengan mudah.
                </p>
                
                <div class="flex flex-wrap justify-center gap-4 mb-12">
                    <div class="bg-white p-6 rounded-lg shadow-md max-w-xs text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        <h2 class="text-lg font-semibold text-gray-900 mb-2">Manajemen Proyek</h2>
                        <p class="text-gray-600">Kelola proyek dengan efisien, tetapkan tenggat waktu, dan pantau perkembangan.</p>
                    </div>
                    
                    <div class="bg-white p-6 rounded-lg shadow-md max-w-xs text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h2 class="text-lg font-semibold text-gray-900 mb-2">Pelacakan Tugas</h2>
                        <p class="text-gray-600">Buat dan tetapkan tugas, tetapkan prioritas, dan lacak penyelesaian.</p>
                    </div>
                    
                    <div class="bg-white p-6 rounded-lg shadow-md max-w-xs text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                        </svg>
                        <h2 class="text-lg font-semibold text-gray-900 mb-2">Kolaborasi Tim</h2>
                        <p class="text-gray-600">Komunikasi yang lancar dengan komentar dan pemberitahuan real-time.</p>
                    </div>
                </div>
                
                <div class="text-center">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-md shadow-md transition duration-150 ease-in-out">
                            Akses Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-md shadow-md transition duration-150 ease-in-out">
                            Mulai Sekarang
                        </a>
                    @endauth
                </div>
            </div>
        </div>
        
        <footer class="bg-white shadow mt-8 py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <p class="text-center text-gray-500 text-sm">
                    &copy; {{ date('Y') }} Sistem Manajemen Proyek. All rights reserved.
                </p>
            </div>
        </footer>
    </div>
</body>
</html>
