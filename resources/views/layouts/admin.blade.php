<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - CaffeSpot</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        outfit: ['Outfit']
                    },
                    boxShadow: {
                        neon: '0 0 25px rgba(250,204,21,.4)'
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }

        .glass {
            background: rgba(255, 255, 255, .05);
            backdrop-filter: blur(15px);
        }

        input,
        textarea,
        select {
            color: black !important;
        }

        label {
            color: #1f2937 !important;
            font-weight: 600;
        }
    </style>

    @stack('styles')
</head>

<body class="bg-gradient-to-br from-zinc-900 via-gray-900 to-black text-white">

    <div class="flex h-screen overflow-hidden">

        <!-- SIDEBAR -->
        <aside class="w-72 glass border-r border-white/10 flex flex-col">

            <div class="px-6 py-6 border-b border-white/10">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 text-xl font-bold text-amber-400">
                    <i class="fas fa-mug-hot animate-pulse"></i>
                    CaffeSpot
                </a>
                <p class="text-xs text-white/60">Admin Control Panel</p>
            </div>

            <!-- SIDEBAR MENU -->
            <nav class="flex-1 mt-4">

                @php
                    $nav = [
                        ['admin.dashboard', 'tachometer-alt', 'Dashboard'],
                        ['admin.cafes.index', 'store', 'Kelola Cafe'],
                        ['admin.reviews.index', 'star', 'Kelola Review'],
                        ['admin.users.index', 'users', 'Kelola User'],
                    ];
                @endphp

                @foreach ($nav as $item)
                    @php
                        $isActive =
                            request()->routeIs($item[0]) || request()->routeIs(str_replace('.index', '.*', $item[0]));
                    @endphp

                    <a href="{{ route($item[0]) }}"
                        class="group flex items-center px-6 py-3 transition relative
                   {{ $isActive
                       ? 'bg-white/10 text-amber-400 border-l-4 border-amber-400'
                       : 'text-white/70 hover:text-amber-400 hover:bg-white/5' }}">

                        <i class="fas fa-{{ $item[1] }} w-6"></i>
                        <span>{{ $item[2] }}</span>
                        <span class="absolute right-5 opacity-0 group-hover:opacity-100 transition">→</span>
                    </a>
                @endforeach

                <!-- BAWAH -->
                <div class="mt-6 border-t border-white/10">

                    <a href="{{ route('home') }}" class="flex items-center px-6 py-3 text-white/70 hover:bg-white/5">
                        <i class="fas fa-home w-6"></i> Website
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex items-center px-6 py-3 w-full hover:bg-red-500/10 text-red-400">
                            <i class="fas fa-sign-out-alt w-6"></i> Logout
                        </button>
                    </form>

                </div>

            </nav>

        </aside>

        <!-- CONTENT -->
        <div class="flex-1 flex flex-col">

            <!-- TOP BAR -->
            <header class="glass border-b border-white/10 px-8 py-4 flex justify-between items-center">
                <h1 class="text-xl font-bold text-amber-400">@yield('title', 'Dashboard')</h1>

                <div class="flex items-center gap-3">
                    <span class="text-white/70">{{ auth()->user()->name }}</span>
                    <img src="{{ auth()->user()->avatar
                        ? asset('storage/' . auth()->user()->avatar)
                        : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
                        class="w-10 h-10 rounded-full ring ring-amber-400">
                </div>
            </header>

            <!-- FLASH -->
            @if (session('success'))
                <div class="mx-8 mt-4 px-4 py-3 bg-green-500/15 text-green-400 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mx-8 mt-4 px-4 py-3 bg-red-500/15 text-red-400 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <!-- PAGE CONTENT -->
            <main class="flex-1 overflow-y-auto p-8" data-aos="fade-up">
                @yield('content')
            </main>

        </div>

    </div>

    <script>
        AOS.init({
            duration: 800,
            once: true
        });
    </script>

    @stack('scripts')
</body>

</html>
