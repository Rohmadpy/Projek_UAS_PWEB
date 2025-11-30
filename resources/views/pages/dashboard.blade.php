
@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-16" data-aos="fade-up">


    <!-- Header -->
    <div class="flex justify-between items-center mb-12">
        <div>
            <h1 class="text-4xl font-bold bg-gradient-to-r from-amber-400 to-orange-500 bg-clip-text text-transparent">
                Dashboard
            </h1>
            <p class="text-white/60 mt-1">Selamat datang kembali di CaffeSpot</p>
        </div>

        <div class="hidden md:flex items-center gap-4">
            <a href="{{ route('profile.index') }}"
               class="bg-white/10 hover:bg-white/20 px-5 py-2 rounded-xl transition">
                <i class="fas fa-user mr-2"></i>Profil
            </a>
            <a href="{{ route('cafes.nearby') }}"
               class="bg-amber-500 hover:bg-amber-600 px-6 py-2 rounded-xl transition shadow-lg">
                <i class="fas fa-map-marker-alt mr-2"></i>Cari Cafe
            </a>
        </div>
    </div>

    <!-- STAT CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- FAVORIT -->
        <div class="glass p-6 rounded-2xl shadow-lg hover:scale-105 transition" data-aos="zoom-in">
            <div class="flex justify-between">
                <div>
                    <h4 class="text-white/60">Cafe Favorit</h4>
                    <h2 class="text-3xl font-bold">{{ $favoriteCount ?? '0' }}</h2>
                </div>
                <div class="text-amber-400 text-3xl">
                    <i class="fas fa-heart"></i>
                </div>
            </div>
        </div>

        <!-- REVIEW -->
        <div class="glass p-6 rounded-2xl shadow-lg hover:scale-105 transition" data-aos="zoom-in" data-aos-delay="100">
            <div class="flex justify-between">
                <div>
                    <h4 class="text-white/60">Review Anda</h4>
                    <h2 class="text-3xl font-bold">{{ $reviewCount ?? '0' }}</h2>
                </div>
                <div class="text-yellow-400 text-3xl">
                    <i class="fas fa-star"></i>
                </div>
            </div>
        </div>

        <!-- MEMBER -->
        <div class="glass p-6 rounded-2xl shadow-lg hover:scale-105 transition" data-aos="zoom-in" data-aos-delay="200">
            <div class="flex justify-between">
                <div>
                    <h4 class="text-white/60">Status</h4>
                    <h2 class="text-2xl font-bold text-green-400">Aktif</h2>
                </div>
                <div class="text-green-400 text-3xl">
                    <i class="fas fa-user-check"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- QUICK ACTION -->
    <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-8">

        <a href="{{ route('cafes.nearby') }}" class="glass rounded-2xl p-8 hover:scale-105 transition">
            <h3 class="text-xl font-bold text-amber-400 mb-2">
                Temukan Cafe Terdekat
            </h3>
            <p class="text-white/60">Cari berdasarkan lokasi kamu sekarang.</p>
        </a>

        <a href="{{ route('favorites.index') }}" class="glass rounded-2xl p-8 hover:scale-105 transition">
            <h3 class="text-xl font-bold text-pink-400 mb-2">
                Daftar Favorit
            </h3>
            <p class="text-white/60">Lihat cafe favoritmu.</p>
        </a>

    </div>

</div>
@endsection
