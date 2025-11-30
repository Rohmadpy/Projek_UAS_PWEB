@extends('layouts.app')

@section('title', 'Cafe Favoritku')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">

    <!-- HEADER -->
    <div class="flex flex-wrap justify-between items-center mb-10">
        <div>
            <h1 class="text-4xl font-bold bg-gradient-to-r from-amber-400 to-orange-500 bg-clip-text text-transparent">
                Cafe Favoritku
            </h1>
            <p class="text-white/60 mt-1">{{ $favorites->total() }} cafe tersimpan</p>
        </div>

        <a href="{{ route('cafes.index') }}" class="mt-4 md:mt-0 bg-amber-500 hover:bg-amber-600 text-white px-6 py-3 rounded-xl shadow-lg transition hover:scale-105">
            <i class="fas fa-plus mr-2"></i>Tambah Cafe
        </a>
    </div>


    <!-- GRID CARD -->
    @if($favorites->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

        @foreach($favorites as $cafe)
        <div class="glass rounded-2xl overflow-hidden shadow-xl hover:scale-105 transition-all duration-300">

            <!-- IMAGE -->
            <div class="relative h-48">
                @if($cafe->primaryPhoto)
                    <img src="{{ asset('storage/' . $cafe->primaryPhoto->photo_path) }}" 
                         alt="{{ $cafe->name }}"
                         class="w-full h-full object-cover">
                @else
                    <div class="flex justify-center items-center h-full bg-white/10">
                        <i class="fas fa-coffee text-5xl text-white/40"></i>
                    </div>
                @endif

                <!-- DELETE -->
                <form method="POST" action="{{ route('favorites.destroy', $cafe) }}" class="absolute top-3 right-3">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        onclick="return confirm('Hapus dari favorit?')"
                        class="bg-red-500/90 hover:bg-red-600 p-2 rounded-full text-white shadow-md">
                        <i class="fas fa-heart-broken"></i>
                    </button>
                </form>

                <!-- BADGE -->
                <div class="absolute bottom-2 left-2 bg-black/50 text-white text-xs px-3 py-1 rounded-full">
                    ⭐ {{ number_format($cafe->avg_rating,1) }}
                </div>
            </div>

            <!-- CONTENT -->
            <div class="p-4">
                <h3 class="font-semibold truncate">{{ $cafe->name }}</h3>

                <!-- STAR -->
                <div class="flex text-yellow-400 text-sm my-2">
                    @for($i=1; $i<=5; $i++)
                        @if($i <= floor($cafe->avg_rating))
                            <i class="fas fa-star"></i>
                        @elseif($i - 0.5 <= $cafe->avg_rating)
                            <i class="fas fa-star-half-alt"></i>
                        @else
                            <i class="far fa-star"></i>
                        @endif
                    @endfor
                </div>

                <!-- LOCATION -->
                <p class="text-sm text-white/60 mb-3">
                    <i class="fas fa-map-marker-alt mr-1"></i>{{ $cafe->district }}, {{ $cafe->city }}
                </p>

                <!-- LINK -->
                <a href="{{ route('cafes.show', $cafe->slug) }}"
                   class="block text-center bg-amber-500 hover:bg-amber-600 py-2 rounded-xl text-sm transition">
                    Lihat Detail
                </a>
            </div>

        </div>
        @endforeach
    </div>

    <!-- PAGINATION -->
    <div class="mt-12">
        {{ $favorites->links() }}
    </div>

    @else
        <!-- EMPTY -->
        <div class="text-center py-20">
            <i class="fas fa-heart-broken text-7xl text-white/30 mb-4"></i>
            <h2 class="text-2xl font-bold mb-2">Belum Ada Cafe Favorit</h2>
            <p class="text-white/60 mb-6">Yuk mulai koleksi cafe favorit kamu</p>
            <a href="{{ route('cafes.index') }}"
               class="bg-amber-500 hover:bg-amber-600 px-8 py-4 rounded-xl transition inline-block">
                <i class="fas fa-search mr-2"></i>Cari Cafe
            </a>
        </div>
    @endif
</div>
@endsection
