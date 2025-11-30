@extends('layouts.app')

@section('title', $cafe->name)

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    <!-- Back Button -->
    <a href="{{ route('cafes.index') }}"
       class="inline-flex items-center text-amber-400 hover:text-amber-500 mb-8 transition">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

        <!-- LEFT -->
        <div class="lg:col-span-2 space-y-8">

            <!-- MAIN PHOTOS -->
            <div class="glass rounded-2xl overflow-hidden shadow-xl border border-white/10">
                @if ($cafe->photos->count() > 0)
                    <div class="relative group">
                        <img id="main-photo"
                             src="{{ asset('storage/' . $cafe->photos->first()->photo_path) }}"
                             class="w-full h-[480px] object-cover transition duration-500 group-hover:scale-105 cursor-pointer"
                             alt="{{ $cafe->name }}">

                        <!-- Zoom Modal -->
                        <div id="zoomModal"
                             class="fixed inset-0 hidden bg-black/80 z-50 items-center justify-center">
                            <button id="zoomClose"
                                    class="absolute top-6 right-6 text-white text-3xl">×</button>
                            <img id="zoomImage" class="max-w-[90%] max-h-[90%] rounded-xl shadow-2xl">
                        </div>
                    </div>

                    <!-- Thumbnail Row -->
                    @if ($cafe->photos->count() > 1)
                        <div class="flex gap-3 p-4 overflow-x-auto">
                            @foreach ($cafe->photos as $photo)
                                <button onclick="switchMainPhoto('{{ asset('storage/' . $photo->photo_path) }}')"
                                        class="w-24 h-24 rounded-xl overflow-hidden hover:ring-2 hover:ring-amber-400 transition">
                                    <img src="{{ asset('storage/' . $photo->photo_path) }}"
                                         class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif

                @else
                    <div class="flex items-center justify-center h-[300px] bg-white/5">
                        <i class="fas fa-coffee text-7xl text-white/30"></i>
                    </div>
                @endif
            </div>

            <!-- DESCRIPTION -->
            <div class="glass p-8 rounded-2xl shadow-xl border border-white/10">
                <h1 class="text-4xl font-bold text-amber-400 mb-3">{{ $cafe->name }}</h1>

                <div class="flex items-center mb-4">
                    <div class="flex text-yellow-400 text-xl mr-4">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= floor($cafe->avg_rating))
                                <i class="fas fa-star"></i>
                            @elseif ($i - 0.5 <= $cafe->avg_rating)
                                <i class="fas fa-star-half-alt"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </div>
                    <span class="text-sm text-white/70">
                        {{ number_format($cafe->avg_rating, 1) }} • {{ $cafe->total_reviews }} review
                    </span>
                </div>

                <p class="text-white/80 leading-relaxed whitespace-pre-line">
                    {{ $cafe->description }}
                </p>
            </div>

            <!-- REVIEWS -->
            <div class="glass p-8 rounded-2xl shadow-xl border border-white/10">

                <h2 class="text-2xl font-bold mb-5">Reviews</h2>

                @auth
                    @if (!$userHasReviewed)

                        <!-- Review Form -->
                        <form action="{{ route('reviews.store') }}" method="POST"
                              class="bg-white/5 p-5 rounded-xl mb-8">
                            @csrf
                            <input type="hidden" name="cafe_id" value="{{ $cafe->id }}">

                            <!-- Rating -->
                            <label class="font-semibold mb-2 block">Rating:</label>
                            <div class="flex gap-2 mb-4">
                                @for ($i = 1; $i <= 5; $i++)
                                    <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}"
                                           class="hidden peer/star{{ $i }}">
                                    <label for="star{{ $i }}"
                                           class="text-3xl cursor-pointer text-white/40 hover:text-yellow-400 peer-checked/star{{ $i }}:text-yellow-400 transition">
                                        <i class="fas fa-star"></i>
                                    </label>
                                @endfor
                            </div>

                            <!-- Comment -->
                            <label class="font-semibold mb-2 block">Komentar:</label>
                            <textarea name="comment"
                                      class="w-full bg-black/20 border border-white/10 p-4 rounded-xl text-white/90 focus:ring-2 focus:ring-amber-400"
                                      rows="3"
                                      placeholder="Ceritakan pengalamanmu..."></textarea>

                            <button class="mt-4 bg-amber-500 hover:bg-amber-600 px-5 py-2 rounded-xl text-white transition">
                                <i class="fas fa-paper-plane mr-2"></i> Kirim
                            </button>
                        </form>

                    @else
                        <div class="bg-blue-500/10 border border-blue-400/20 text-blue-200 p-4 rounded-xl mb-8">
                            <i class="fas fa-info-circle mr-2"></i>
                            Kamu sudah memberikan review.
                        </div>
                    @endif

                @else
                    <div class="bg-white/5 p-5 rounded-xl text-center mb-6">
                        <p class="text-white/70 mb-3">Login untuk memberikan review</p>
                        <a href="{{ route('login') }}"
                           class="bg-amber-500 hover:bg-amber-600 px-5 py-2 rounded-xl text-white inline-block">
                           Login Sekarang
                        </a>
                    </div>
                @endauth

                <!-- Reviews List -->
                @forelse ($cafe->approvedReviews as $review)
                    <div class="border-b border-white/10 py-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-semibold text-white">{{ $review->user->name }}</p>
                                <div class="flex text-yellow-400">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $review->rating ? '' : 'text-white/10' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            <span class="text-white/50 text-sm">{{ $review->created_at->diffForHumans() }}</span>
                        </div>

                        @if ($review->comment)
                            <p class="text-white/70 mt-2">{{ $review->comment }}</p>
                        @endif
                    </div>
                @empty
                    <p class="text-white/50 text-center py-6">Belum ada review.</p>
                @endforelse
            </div>

        </div>

        <!-- RIGHT SIDEBAR -->
        <div class="space-y-8">

            <!-- FAVORITE + Nearby -->
            <div class="glass p-6 rounded-2xl shadow-xl border border-white/10">
                @auth
                    @if ($isFavorited)
                        <form action="{{ route('favorites.destroy', $cafe) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="w-full py-3 bg-red-500 hover:bg-red-600 rounded-xl text-white mb-3">
                                <i class="fas fa-heart-broken mr-2"></i> Hapus Favorit
                            </button>
                        </form>
                    @else
                        <form action="{{ route('favorites.store', $cafe) }}" method="POST">
                            @csrf
                            <button class="w-full py-3 bg-amber-500 hover:bg-amber-600 rounded-xl text-white mb-3">
                                <i class="fas fa-heart mr-2"></i> Tambah Favorit
                            </button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                       class="block w-full py-3 bg-amber-500 hover:bg-amber-600 text-white text-center rounded-xl mb-3">
                        Login untuk Favorit
                    </a>
                @endauth

                <a href="{{ route('cafes.nearby') }}"
                   class="block w-full py-3 text-center border border-white/10 rounded-xl hover:bg-white/5 transition">
                    <i class="fas fa-map-marker-alt mr-2"></i> Cafe Terdekat
                </a>
            </div>

            <!-- INFO -->
            <div class="glass p-6 rounded-2xl shadow-xl border border-white/10">
                <h3 class="text-xl font-bold mb-4">Informasi Cafe</h3>
                <div class="space-y-3 text-white/80">
                    <div>
                        <p class="text-sm text-white/60">Alamat</p>
                        <p class="font-semibold">{{ $cafe->address }}</p>
                        <p class="text-sm">{{ $cafe->district }}, {{ $cafe->city }}</p>
                    </div>

                    @if ($cafe->phone)
                        <div>
                            <p class="text-sm text-white/60">Telepon</p>
                            <p class="font-semibold">{{ $cafe->phone }}</p>
                        </div>
                    @endif

                    <div>
                        <p class="text-sm text-white/60">Jam Buka</p>
                        <p class="font-semibold">
                            {{ date('H:i', strtotime($cafe->open_time)) }} -
                            {{ date('H:i', strtotime($cafe->close_time)) }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-white/60">Kisaran Harga</p>
                        <p class="font-semibold">{{ $cafe->price_range }}</p>
                    </div>

                    @if ($cafe->capacity)
                        <div>
                            <p class="text-sm text-white/60">Kapasitas</p>
                            <p class="font-semibold">{{ $cafe->capacity }} orang</p>
                        </div>
                    @endif

                    <div>
                        <p class="text-sm text-white/60">Suasana</p>
                        <p class="font-semibold capitalize">{{ $cafe->atmosphere }}</p>
                    </div>
                </div>
            </div>

            <!-- FACILITIES -->
            <div class="glass p-6 rounded-2xl shadow-xl border border-white/10">
                <h3 class="text-xl font-bold mb-4">Fasilitas</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach ($cafe->facilities as $facility)
                        <span class="px-3 py-1 bg-amber-200 text-amber-800 rounded-full text-sm">
                            {{ $facility->name }}
                        </span>
                    @endforeach
                </div>
            </div>

            <!-- ACTIVITIES -->
            <div class="glass p-6 rounded-2xl shadow-xl border border-white/10">
                <h3 class="text-xl font-bold mb-4">Cocok Untuk</h3>
                <div class="space-y-2">
                    @foreach ($cafe->activities as $activity)
                        <div class="flex items-center text-white/90">
                            <i class="fas fa-check-circle text-green-400 mr-2"></i>
                            {{ $activity->name }}
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
    // thumbnail → main photo
    function switchMainPhoto(src) {
        const main = document.getElementById("main-photo");
        main.classList.add("opacity-0");
        setTimeout(() => {
            main.src = src;
            main.classList.remove("opacity-0");
        }, 150);
    }

    // zoom modal
    document.addEventListener("DOMContentLoaded", () => {
        const main = document.getElementById("main-photo");
        const modal = document.getElementById("zoomModal");
        const img = document.getElementById("zoomImage");
        const closeBtn = document.getElementById("zoomClose");

        main.addEventListener("click", () => {
            img.src = main.src;
            modal.classList.remove("hidden");
            modal.classList.add("flex");
        });

        closeBtn.addEventListener("click", () => {
            modal.classList.add("hidden");
        });

        modal.addEventListener("click", (e) => {
            if (e.target === modal) modal.classList.add("hidden");
        });
    });
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const stars = document.querySelectorAll("label[for^='star']");

    stars.forEach((star, index) => {
        star.addEventListener("click", () => {
            let rating = index + 1;

            stars.forEach((s, i) => {
                if (i < rating) {
                    s.classList.add("text-yellow-400");
                    s.classList.remove("text-white/40");
                } else {
                    s.classList.add("text-white/40");
                    s.classList.remove("text-yellow-400");
                }
            });
        });
    });
});
</script>

@endpush
@endsection
