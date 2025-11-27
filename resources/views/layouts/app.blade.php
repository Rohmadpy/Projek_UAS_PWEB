<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Café Finder')</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        outfit: ['Outfit', 'sans-serif']
                    },
                    boxShadow: {
                        glow: '0 0 30px rgba(251, 146, 60, .25)'
                    },
                    animation: {
                        float: 'float 4s ease-in-out infinite',
                        glow: 'glow 2s infinite ease-in-out'
                    },
                    keyframes: {
                        float: {
                            '0%,100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-6px)' }
                        },
                        glow: {
                            '0%,100%': { boxShadow: '0 0 20px rgba(251,146,60,.2)' },
                            '50%': { boxShadow: '0 0 40px rgba(251,146,60,.5)' }
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Outfit', sans-serif; }
        .glass { backdrop-filter: blur(14px); background: rgba(255,255,255,.05); }
    </style>

    @stack('styles')
</head>
<body class="bg-gradient-to-br from-zinc-900 via-neutral-900 to-black text-white">

<!-- NAVBAR -->
<nav class="fixed top-0 left-0 w-full glass border-b border-white/10 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

        <a href="{{ route('home') }}" class="flex items-center gap-2 text-xl text-amber-400 font-bold animate-float">
            <i class="fas fa-mug-hot"></i> Café Finder
        </a>

        <div class="hidden md:flex gap-8 items-center">

            <a href="{{ route('home') }}" class="hover:text-amber-400 transition">Beranda</a>
            <a href="{{ route('cafes.nearby') }}" class="hover:text-amber-400 transition">Terdekat</a>

            @auth
                <a href="{{ route('favorites.index') }}" class="hover:text-amber-400 transition">Favorit</a>
                <a href="{{ route('profile.index') }}" class="hover:text-amber-400 transition">Profil</a>

                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}"
                       class="bg-amber-500 px-4 py-2 rounded-xl shadow-glow hover:bg-amber-600 transition">
                       Admin Panel
                    </a>
                @endif

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="text-red-400 hover:text-red-500 transition">Logout</button>
                </form>

            @else
                <a href="{{ route('login') }}" class="hover:text-amber-400 transition">Login</a>
                <a href="{{ route('register') }}"
                   class="bg-amber-500 px-5 py-2 rounded-xl hover:bg-amber-600 transition shadow-glow">
                   Daftar
                </a>
            @endauth
        </div>

        <button id="menuBtn" class="md:hidden text-2xl">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <!-- MOBILE MENU -->
    <div id="mobileMenu" class="hidden md:hidden px-6 pb-4 flex flex-col gap-3">
        <a href="{{ route('home') }}">Beranda</a>
        <a href="{{ route('cafes.nearby') }}">Terdekat</a>

        @auth
            <a href="{{ route('favorites.index') }}">Favorit</a>
            <a href="{{ route('profile.index') }}">Profil</a>
            <form action="{{ route('logout') }}" method="POST">@csrf
                <button class="text-red-400">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Register</a>
        @endauth
    </div>
</nav>

<!-- CONTENT -->
<main class="pt-28 min-h-screen" data-aos="fade-up">
    @yield('content')
</main>

<!-- FOOTER -->
<footer class="glass border-t border-white/10 mt-24">
    <div class="max-w-7xl mx-auto grid md:grid-cols-3 gap-10 px-6 py-14">

        <div>
            <h2 class="text-xl text-amber-400 font-bold mb-3">Café Finder</h2>
            <p class="text-white/70">Cari tempat ngopi favorit dengan rasa premium.</p>
        </div>

        <div>
            <h3 class="font-semibold mb-3">Menu</h3>
            <ul class="space-y-2 text-white/70">
                <li><a href="{{ route('home') }}" class="hover:text-amber-400">Beranda</a></li>
                <li><a href="{{ route('cafes.nearby') }}" class="hover:text-amber-400">Terdekat</a></li>
                <li><a href="{{ route('favorites.index') }}" class="hover:text-amber-400">Favorit</a></li>
            </ul>
        </div>

        <div>
            <h3 class="font-semibold mb-3">Kontak</h3>
            <p class="text-white/70"><i class="fas fa-envelope"></i> info@cafefinder.com</p>
            <p class="text-white/70"><i class="fas fa-map-marker-alt"></i> Jember</p>
        </div>

    </div>

    <div class="border-t border-white/10 text-center py-4 text-white/50">
        &copy; {{ date('Y') }} Café Finder
    </div>
</footer>

<!-- SCRIPT -->
<script>
    AOS.init({ once: true, duration: 900 });

    document.getElementById("menuBtn").onclick = () => {
        document.getElementById("mobileMenu").classList.toggle("hidden");
    };
</script>

@stack('scripts')

</body>
</html>
