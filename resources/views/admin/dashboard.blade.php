@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<!-- HEADER -->
<div class="mb-8 flex items-center justify-between">
    <h1 class="text-3xl font-bold text-gray-800">Dashboard Admin</h1>
    <span class="text-sm text-gray-500">Overview sistem Café Finder</span>
</div>

<!-- STATS -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">

    <!-- CAFES -->
    <div class="glass-card border-l-8 border-amber-500">
        <div class="flex justify-between items-center">
            <div>
                <p class="stat-title">Total Café</p>
                <p class="stat-value">{{ $stats['total_cafes'] }}</p>
                <p class="stat-sub text-green-600">{{ $stats['active_cafes'] }} aktif</p>
            </div>
            <div class="stat-icon bg-amber-100 text-amber-600">
                <i class="fas fa-coffee"></i>
            </div>
        </div>
    </div>

    <!-- USERS -->
    <div class="glass-card border-l-8 border-blue-500">
        <div class="flex justify-between items-center">
            <div>
                <p class="stat-title">Total User</p>
                <p class="stat-value">{{ $stats['total_users'] }}</p>
                <p class="stat-sub text-green-600">{{ $stats['active_users'] }} aktif</p>
            </div>
            <div class="stat-icon bg-blue-100 text-blue-600">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>

    <!-- REVIEWS -->
    <div class="glass-card border-l-8 border-yellow-500">
        <div class="flex justify-between items-center">
            <div>
                <p class="stat-title">Review Pending</p>
                <p class="stat-value">{{ $stats['pending_reviews'] }}</p>
                <p class="stat-sub">{{ $stats['approved_reviews'] }} disetujui</p>
            </div>
            <div class="stat-icon bg-yellow-100 text-yellow-600">
                <i class="fas fa-star"></i>
            </div>
        </div>
    </div>

</div>

<!-- CONTENT -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    <!-- PENDING REVIEWS -->
    <div class="glass-box">
        <h2 class="section-title">Review Pending</h2>

        @forelse($recent_reviews as $review)
            <div class="list-item">
                <div>
                    <p class="font-semibold text-gray-800">{{ $review->cafe->name }}</p>
                    <p class="text-sm text-gray-500">oleh {{ $review->user->name }}</p>
                    <div class="flex text-yellow-400 text-sm mt-1">
                        @for($i = 1; $i <= $review->rating; $i++)
                            <i class="fas fa-star"></i>
                        @endfor
                    </div>
                </div>
                <a href="{{ route('admin.reviews.index') }}" class="btn-link">Lihat</a>
            </div>
        @empty
            <p class="text-center text-gray-500 pt-6">Tidak ada review pending</p>
        @endforelse
    </div>

    <!-- TOP CAFES -->
    <div class="glass-box">
        <h2 class="section-title">Top 5 Café</h2>

        @foreach($top_cafes as $cafe)
        <div class="flex items-center gap-4 list-item">

            {{-- FOTO CAFE --}}
            <div class="w-16 h-16 rounded-lg overflow-hidden shadow-md transform transition hover:scale-105">
                @if($cafe->primaryPhoto && $cafe->primaryPhoto->path)
                    <img src="{{ asset('storage/'.$cafe->primaryPhoto->path) }}"
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                        <i class="fas fa-coffee text-gray-400 text-2xl"></i>
                    </div>
                @endif
            </div>

            {{-- INFO --}}
            <div class="flex-1">
                <p class="font-semibold text-gray-800">{{ $cafe->name }}</p>
                <div class="flex items-center text-sm mt-1">
                    <div class="flex text-yellow-400 mr-2">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= $cafe->avg_rating ? '' : 'text-gray-300' }}"></i>
                        @endfor
                    </div>
                    <span class="text-gray-500">{{ number_format($cafe->avg_rating, 1) }}</span>
                </div>
            </div>

            <span class="text-sm text-gray-500">{{ $cafe->total_reviews }} reviews</span>
        </div>
        @endforeach

    </div>

</div>

<!-- STYLE -->
<style>

.glass-card {
    background: rgba(255,255,255,.9);
    backdrop-filter: blur(15px);
    border-radius: 1rem;
    padding: 1.5rem;
    box-shadow: 0 10px 25px rgba(0,0,0,.05);
    transition: .3s;
}

.glass-card:hover {
    transform: translateY(-3px);
}

.stat-title {
    color: #6b7280;
    font-size: .9rem;
}

.stat-value {
    font-size: 2.2rem;
    font-weight: bold;
    color: #111827;
}

.stat-sub {
    font-size: .8rem;
    color: #6b7280;
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 999px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
}

/* BOX */
.glass-box {
    background: rgba(255,255,255,.95);
    border-radius: 1rem;
    padding: 1.5rem;
    box-shadow: 0 10px 20px rgba(0,0,0,.05);
}

.section-title {
    font-size: 1.2rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.list-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #e5e7eb;
    padding: .7rem 0;
}

.list-item:last-child {
    border-bottom: none;
}

.btn-link {
    color: #f59e0b;
    font-size: .8rem;
    font-weight: 600;
    transition: .2s;
}

.btn-link:hover {
    text-decoration: underline;
}

</style>

@endsection
