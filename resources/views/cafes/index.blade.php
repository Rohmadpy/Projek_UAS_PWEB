@extends('layouts.app')

@section('title', 'Semua Café')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12" data-aos="fade-up">

    <!-- HERO -->
    <div class="relative rounded-3xl p-10 mb-10 overflow-hidden shadow-xl bg-gradient-to-tr from-amber-500 to-orange-500">

        <div class="relative z-10">
            <h1 class="text-4xl font-bold">Temukan Cafe Favoritmu</h1>
            <p class="text-xl text-white/80">{{ $cafes->total() }} cafe yang tersedia untuk kamu</p>
        </div>

        <div class="absolute inset-0 opacity-20"
            style="background-image: url('https://images.unsplash.com/flagged/photo-1552566626-52f8b828add9'); background-size: cover;">
        </div>
    </div>

    <!-- FILTER PANEL -->
    <div class="glass rounded-2xl shadow-lg p-6 mb-10 border border-white/20" data-aos="zoom-in">

        <form method="GET" action="{{ route('cafes.index') }}">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">

                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari cafe..."
                    class="input-ui">

                <select name="city" class="input-ui">
                    <option value="">Semua Kota</option>
                    @foreach($cities as $city)
                        <option value="{{ $city }}" @selected(request('city') == $city)>
                            {{ $city }}
                        </option>
                    @endforeach
                </select>

                <select name="price_range" class="input-ui">
                    <option value="">Semua Harga</option>
                    <option value="$" @selected(request('price_range') == '$')>$ Murah</option>
                    <option value="$$" @selected(request('price_range') == '$$')>$$ Sedang</option>
                    <option value="$$$" @selected(request('price_range') == '$$$')>$$$ Mahal</option>
                </select>

                <select name="sort" class="input-ui">
                    <option value="rating" @selected(request('sort') == 'rating')>⭐ Rating Tertinggi</option>
                    <option value="reviews" @selected(request('sort') == 'reviews')>🔥 Paling Populer</option>
                    <option value="name" @selected(request('sort') == 'name')>🔤 Nama A-Z</option>
                </select>

            </div>

            <!-- FACILITIES -->
            <div class="mb-4">
                <p class="font-semibold text-white/70 mb-2">Fasilitas</p>

                <div class="flex flex-wrap gap-2">
                    @foreach($facilities as $facility)
                        <label class="chip-ui">
                            <input type="checkbox" name="facilities[]"
                                value="{{ $facility->id }}"
                                {{ in_array($facility->id, request('facilities', [])) ? 'checked' : '' }}>
                            <span>{{ $facility->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- ACTIONS -->
            <div class="flex gap-2">
                <button class="btn-primary">
                    <i class="fas fa-search mr-2"></i> Cari
                </button>
                <a href="{{ route('cafes.index') }}" class="btn-reset">
                    <i class="fas fa-redo mr-2"></i> Reset
                </a>
            </div>

        </form>
    </div>

    <!-- GRID -->
    @if($cafes->count())

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">

        @foreach($cafes as $cafe)

        <div class="glass rounded-xl overflow-hidden hover:scale-105 transition" data-aos="zoom-in">

            <!-- IMAGE -->
            <div class="relative h-48">
                @if($cafe->primaryPhoto)
                    <img src="{{ asset('storage/' . $cafe->primaryPhoto->photo_path) }}" 
                        class="w-full h-full object-cover">
                @else
                    <div class="flex h-full items-center justify-center text-white/30">
                        <i class="fas fa-coffee text-6xl"></i>
                    </div>
                @endif

                <div class="absolute top-2 right-2 bg-white text-black text-sm px-3 py-1 rounded-full font-semibold">
                    {{ $cafe->price_range }}
                </div>
            </div>

            <!-- CONTENT -->
            <div class="p-4">

                <h3 class="font-bold truncate">{{ $cafe->name }}</h3>

                <div class="flex items-center text-yellow-400 text-sm mb-1">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="{{ $i <= floor($cafe->avg_rating) ? 'fas' : 'far' }} fa-star"></i>
                    @endfor
                    <span class="ml-2 text-white/60">
                        {{ number_format($cafe->avg_rating,1) }} ({{ $cafe->total_reviews }})
                    </span>
                </div>

                <p class="text-white/60 text-sm">
                    <i class="fas fa-map-marker-alt mr-1"></i>
                    {{ $cafe->district }}, {{ $cafe->city }}
                </p>

                <div class="flex flex-wrap gap-1 mt-2">
                    @foreach($cafe->facilities->take(3) as $facility)
                        <span class="badge-ui">{{ $facility->name }}</span>
                    @endforeach
                    @if($cafe->facilities->count() > 3)
                        <span class="badge-ui">+{{ $cafe->facilities->count() - 3 }}</span>
                    @endif
                </div>

                <a href="{{ route('cafes.show', $cafe->slug) }}" 
                    class="btn-detail mt-3 block w-full">
                    Lihat Detail
                </a>

            </div>

        </div>

        @endforeach
    </div>

    <div class="mt-8">{{ $cafes->links() }}</div>

    @else

    <div class="text-center py-16 text-white/60">
        <i class="fas fa-search text-6xl mb-4"></i>
        <p class="text-lg">Tidak ada cafe ditemukan</p>
        <a href="{{ route('cafes.index') }}" class="text-amber-400 underline">Reset filter</a>
    </div>

    @endif

</div>

{{-- CUSTOM UI CLASS --}}
<style>
    .glass {
        background: rgba(255,255,255,0.08);
        backdrop-filter: blur(12px);
        border-radius: 1rem;
    }

    .input-ui {
        background: rgba(255,255,255,0.9) !important;
        border: 1px solid rgba(255,255,255,0.4);
        padding: 10px 14px;
        border-radius: .6rem;
        width: 100%;
        color: black !important; /* <-- FIX */
    }

    .input-ui option {
        color: black !important;   /* <-- FIX */
        background: white !important;
    }

    .chip-ui {
        background: rgba(255,255,255,.1);
        display: inline-flex;
        gap: 6px;
        align-items: center;
        padding: 6px 10px;
        border-radius: 999px;
        cursor: pointer;
    }

    .chip-ui input { display:none; }

    .chip-ui input:checked + span {
        color: #f59e0b;
        font-weight: bold;
    }

    .btn-primary {
        background: #f59e0b;
        padding: 10px 16px;
        border-radius: .6rem;
        color: black;
    }

    .btn-reset {
        background: rgba(255,255,255,.1);
        padding: 10px 16px;
        border-radius: .6rem;
    }

    .btn-detail {
        background: linear-gradient(to right, #f59e0b, #fb923c);
        text-align: center;
        padding: 8px;
        border-radius: .5rem;
    }

    .badge-ui {
        background: rgba(255,255,255,.1);
        font-size:.75rem;
        padding: 4px 8px;
        border-radius: 6px;
    }
</style>
@endsection
