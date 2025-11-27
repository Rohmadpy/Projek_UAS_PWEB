@extends('layouts.admin')

@section('title', 'Kelola Review')

@section('content')

<!-- HEADER -->
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-3xl font-bold text-gray-800">Kelola Review</h2>
        <p class="text-gray-500">Total: {{ $reviews->total() }} review</p>
    </div>
</div>

<!-- FILTER -->
<div class="glass-box mb-6">
    <form method="GET" action="{{ route('admin.reviews.index') }}" class="flex flex-col md:flex-row gap-4">

        <select name="status" class="filter-input">
            <option value="">Semua Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
        </select>

        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari café atau user..." class="filter-input flex-1">

        <button type="submit" class="btn-primary">
            <i class="fas fa-search mr-1"></i> Cari
        </button>

    </form>
</div>

<!-- TABLE -->
<div class="glass-box overflow-x-auto">
    <table class="min-w-full text-sm">
        <thead>
            <tr class="bg-gray-100 text-gray-600 text-xs uppercase">
                <th class="cell-header">Café</th>
                <th class="cell-header">User</th>
                <th class="cell-header">Rating</th>
                <th class="cell-header">Komentar</th>
                <th class="cell-header">Status</th>
                <th class="cell-header">Aksi</th>
            </tr>
        </thead>
        <tbody>

        @forelse($reviews as $review)
            <tr class="hover:bg-gray-50 transition">
                <td class="cell font-semibold">{{ $review->cafe->name }}</td>
                <td class="cell">{{ $review->user->name }}</td>

                <!-- RATING -->
                <td class="cell">
                    <div class="flex text-yellow-400">
                        @for($i = 1; $i <= $review->rating; $i++)
                            <i class="fas fa-star"></i>
                        @endfor
                    </div>
                </td>

                <!-- COMMENT -->
                <td class="cell max-w-xs truncate">{{ $review->comment ?: '-' }}</td>

                <!-- STATUS -->
                <td class="cell">
                    <span class="badge 
                        {{ $review->status == 'approved' ? 'badge-green' : '' }}
                        {{ $review->status == 'pending' ? 'badge-yellow' : '' }}
                        {{ $review->status == 'rejected' ? 'badge-red' : '' }}">
                        {{ ucfirst($review->status) }}
                    </span>
                </td>

                <!-- ACTION -->
                <td class="cell">
                    <div class="flex items-center gap-3">

                    @if($review->status == 'pending')
                        <form method="POST" action="{{ route('admin.reviews.approve', $review) }}">
                            @csrf
                            <button class="icon-btn icon-success" title="Approve">
                                <i class="fas fa-check"></i>
                            </button>
                        </form>

                        <form method="POST" action="{{ route('admin.reviews.reject', $review) }}">
                            @csrf
                            <button class="icon-btn icon-warning" title="Reject">
                                <i class="fas fa-times"></i>
                            </button>
                        </form>
                    @endif

                        <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}"
                              onsubmit="return confirm('Yakin hapus review ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="icon-btn icon-danger" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>

                    </div>
                </td>
            </tr>

        @empty
            <tr>
                <td colspan="6" class="text-center py-6 text-gray-500">Belum ada review</td>
            </tr>
        @endforelse

        </tbody>
    </table>
</div>

<!-- PAGINATION -->
<div class="mt-6">
    {{ $reviews->links() }}
</div>

<!-- STYLE -->
<style>

.glass-box {
    background: rgba(255,255,255,.96);
    border-radius: 14px;
    padding: 1.2rem;
    box-shadow: 0 10px 25px rgba(0,0,0,.05);
}

/* FIX WARNA TEKS PUTIH */
table, th, td {
    color: #1f2937 !important; /* abu gelap */
}

select, option {
    color: #1f2937 !important;
    background-color: #ffffff !important;
}

.filter-input {
    color: #1f2937 !important;
}

/* INPUT */
.filter-input {
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    padding: .55rem .8rem;
    transition: .2s;
}

.filter-input:focus {
    outline: none;
    border-color: #f59e0b;
    box-shadow: 0 0 0 2px rgba(245,158,11,.2);
}

/* BUTTON */
.btn-primary {
    background: linear-gradient(to right, #f59e0b, #d97706);
    color: white;
    padding: .55rem 1rem;
    border-radius: 10px;
    font-weight: 600;
    transition: .2s;
}

.btn-primary:hover {
    opacity: .9;
}

/* TABLE */
.cell-header {
    padding: .7rem;
    text-align: left;
}

.cell {
    padding: .7rem;
}

/* BADGE */
.badge {
    padding: .2rem .7rem;
    font-size: .75rem;
    border-radius: 999px;
    font-weight: 600;
}

.badge-green {
    background: #dcfce7;
    color: #15803d;
}

.badge-yellow {
    background: #fef9c3;
    color: #854d0e;
}

.badge-red {
    background: #fee2e2;
    color: #b91c1c;
}

/* ACTION BTN */
.icon-btn {
    font-size: 1rem;
    transition: .2s;
}

.icon-success { color: #16a34a; }
.icon-warning { color: #eab308; }
.icon-danger { color: #dc2626; }

.icon-btn:hover { transform: scale(1.15); }

</style>

@endsection
