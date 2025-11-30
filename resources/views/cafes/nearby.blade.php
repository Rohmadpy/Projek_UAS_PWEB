@extends('layouts.app')

@section('title', 'Cafe Terdekat')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12" data-aos="fade-up">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-10">
        <div>
            <h1 class="text-4xl font-bold text-amber-400">Cafe Terdekat</h1>
            <p class="text-white/60 mt-1">Temukan cafe favoritmu di sekitar lokasi saat ini</p>
        </div>

        <div class="mt-4 md:mt-0">
            <a href="{{ route('cafes.index') }}"
               class="inline-flex items-center bg-white/10 hover:bg-white/20 px-4 py-2 rounded-lg transition">
                <i class="fas fa-th mr-2"></i> Semua Cafe
            </a>
        </div>
    </div>

    <!-- LOCATION FORM -->
    <div class="glass rounded-2xl shadow-xl p-6 mb-10 border border-white/10" data-aos="zoom-in">
        <h3 class="text-2xl font-bold mb-4">Cari Berdasarkan Lokasi</h3>

        <form method="GET" action="{{ route('cafes.nearby') }}" id="nearby-form">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-5">
                
                <!-- Latitude -->
                <div>
                    <label class="block text-white/70 font-semibold mb-2">Latitude</label>
                    <input type="text" 
                        name="latitude" 
                        id="latitude"
                        value="{{ request('latitude', $lat ?? '') }}"
                        class="w-full bg-transparent border border-white/20 px-4 py-2 rounded-lg focus:ring focus:ring-amber-500"
                        placeholder="-6.200000"
                        readonly>
                </div>

                <!-- Longitude -->
                <div>
                    <label class="block text-white/70 font-semibold mb-2">Longitude</label>
                    <input type="text" 
                        name="longitude" 
                        id="longitude"
                        value="{{ request('longitude', $lng ?? '') }}"
                        class="w-full bg-transparent border border-white/20 px-4 py-2 rounded-lg focus:ring focus:ring-amber-500"
                        placeholder="106.816666"
                        readonly>
                </div>

                <!-- Radius -->
                <div>
                    <label class="block text-white/70 font-semibold mb-2">Radius (km)</label>
                    <input type="number" 
                        name="radius"
                        value="{{ request('radius', 5) }}"
                        min="1" 
                        max="100"
                        class="w-full bg-transparent border border-white/20 px-4 py-2 rounded-lg focus:ring focus:ring-amber-500">
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex flex-wrap gap-3">
                <button type="button"
                    onclick="getLocation()"
                    class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-lg transition shadow">
                    <i class="fas fa-location-arrow mr-2"></i> Gunakan Lokasi Saya
                </button>

                <button type="submit"
                    class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-2 rounded-lg transition shadow">
                    <i class="fas fa-search mr-2"></i> Cari Cafe
                </button>
            </div>

        </form>
    </div>

    <!-- SEARCH RESULTS -->
    @if(isset($cafes) && $cafes->count() > 0)

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">

            @foreach($cafes as $cafe)
            <div class="glass rounded-xl overflow-hidden hover:scale-105 transition duration-300" data-aos="zoom-in">

                <!-- Café Image -->
                <div class="relative h-48">
                    @if($cafe->primaryPhoto)
                        <img src="{{ asset('storage/' . $cafe->primaryPhoto->photo_path) }}"
                            class="w-full h-full object-cover">
                    @else
                        <div class="flex items-center justify-center h-full text-white/30">
                            <i class="fas fa-coffee text-6xl"></i>
                        </div>
                    @endif

                    <!-- Distance Badge -->
                    <div class="absolute top-2 right-2 bg-amber-500 text-black px-3 py-1 rounded-full text-sm font-bold shadow">
                        {{ number_format($cafe->distance, 1) }} km
                    </div>
                </div>

                <!-- Café Content -->
                <div class="p-4">
                    <h3 class="text-lg font-bold mb-1">{{ $cafe->name }}</h3>

                    <!-- Rating -->
                    <div class="flex items-center mb-1 text-yellow-400">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="{{ $i <= floor($cafe->avg_rating) ? 'fas' : 'far' }} fa-star"></i>
                        @endfor
                        <span class="ml-2 text-sm text-white/50">
                            {{ number_format($cafe->avg_rating, 1) }}
                        </span>
                    </div>

                    <!-- Location -->
                    <p class="text-white/60 text-sm mb-3">
                        <i class="fas fa-map-marker-alt mr-1"></i>
                        {{ $cafe->district }}, {{ $cafe->city }}
                    </p>

                    <!-- Detail Button -->
                    <a href="{{ route('cafes.show', $cafe->slug) }}"
                        class="block w-full text-center bg-amber-500 hover:bg-amber-600 py-2 rounded-lg transition shadow">
                        Lihat Detail
                    </a>
                </div>
            </div>
            @endforeach

        </div>

    @elseif(request('latitude'))

        <!-- No Cafes Found -->
        <div class="text-center py-20 text-white/60">
            <i class="fas fa-map-marked-alt text-7xl mb-4"></i>
            <h2 class="text-xl font-bold">Tidak Ada Cafe Terdekat</h2>
            <p>Coba perbesar radius pencarian.</p>
        </div>

    @else

        <!-- Location Not Activated -->
        <div class="text-center py-20 text-white/60">
            <i class="fas fa-location-arrow text-7xl mb-4"></i>
            <h2 class="text-xl font-bold">Lokasi Belum Aktif</h2>
            <p>Klik tombol "Gunakan Lokasi Saya" untuk memulai.</p>
        </div>

    @endif

</div>

@push('scripts')
<script>
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else {
            alert('Geolocation tidak didukung oleh browser Anda.');
        }
    }

    function showPosition(position) {
        document.getElementById('latitude').value = position.coords.latitude;
        document.getElementById('longitude').value = position.coords.longitude;
        document.getElementById('nearby-form').submit();
    }

    function showError(error) {
        switch(error.code) {
            case error.PERMISSION_DENIED:
                alert('Anda menolak permintaan lokasi.');
                break;
            case error.POSITION_UNAVAILABLE:
                alert('Lokasi tidak tersedia.');
                break;
            case error.TIMEOUT:
                alert('Request timeout.');
                break;
            default:
                alert('Error tidak diketahui.');
        }
    }
</script>
@endpush

@endsection
