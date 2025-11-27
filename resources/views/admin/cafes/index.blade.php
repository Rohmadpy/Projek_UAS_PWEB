@extends('layouts.admin')

@section('title', 'Kelola Café')

@section('content')

<!-- HEADER -->
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-3xl font-bold text-gray-800">Kelola Café</h2>
        <p class="text-gray-500">Total: {{ $cafes->total() }} café</p>
    </div>

    <a href="{{ route('admin.cafes.create') }}" class="btn-primary">
        <i class="fas fa-plus mr-2"></i>Tambah Café
    </a>
</div>

<!-- TABLE -->
<div class="glass-box overflow-x-auto">
    <table class="min-w-full text-sm">
        <thead>
            <tr class="bg-gray-100 text-gray-600 text-xs uppercase">
                <th class="cell-header">Café</th>
                <th class="cell-header">Kota</th>
                <th class="cell-header">Rating</th>
                <th class="cell-header">Status</th>
                <th class="cell-header">Aksi</th>
            </tr>
        </thead>
        <tbody>

        @forelse($cafes as $cafe)
            <tr class="hover:bg-gray-50 transition">

                <!-- CAFE INFO -->
                <td class="cell">
                    <div class="flex items-center gap-3">
                        @if($cafe->primaryPhoto)
                            <img src="{{ asset('storage/' . $cafe->primaryPhoto->photo_path) }}"
                                 class="w-12 h-12 rounded-lg object-cover shadow">
                        @else
                            <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                <i class="fas fa-coffee text-gray-400"></i>
                            </div>
                        @endif
                        <div>
                            <p class="font-semibold cafe-name">{{ $cafe->name }}</p>
                            <p class="text-xs cafe-district">{{ $cafe->district }}</p>
                        </div>
                    </div>
                </td>

                <!-- CITY -->
                <td class="cell text-gray-700">{{ $cafe->city }}</td>

                <!-- RATING -->
                <td class="cell">
                    <div class="flex items-center text-yellow-500">
                        <i class="fas fa-star mr-1"></i>
                        {{ number_format($cafe->avg_rating, 1) }}
                    </div>
                </td>

                <!-- STATUS -->
                <td class="cell">
                    <span class="badge {{ $cafe->is_active ? 'badge-green' : 'badge-red' }}">
                        {{ $cafe->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>

                <!-- ACTION -->
                <td class="cell">
                    <div class="flex items-center gap-3">

                        <a href="{{ route('admin.cafes.edit', $cafe) }}"
                           class="icon-btn text-blue-600" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form method="POST" action="{{ route('admin.cafes.destroy', $cafe) }}"
                              onsubmit="return confirm('Yakin hapus café ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="icon-btn text-red-600" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>

                    </div>
                </td>

            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center text-gray-500 py-6">Belum ada café</td>
            </tr>
        @endforelse

        </tbody>
    </table>
</div>

<!-- PAGINATION -->
<div class="mt-6">
    {{ $cafes->links() }}
</div>

<!-- STYLE -->
<style>

.glass-box {
    background: rgba(255,255,255,.95);
    border-radius: 14px;
    padding: 1.2rem;
    box-shadow: 0 8px 20px rgba(0,0,0,.05);
}

/* TABLE */
.cell-header {
    padding: .8rem;
    text-align: left;
}

.cell {
    padding: .75rem;
}

/* FIX WARNA TEKS (ANTI KETIMPA CSS GLOBAL) */
.cafe-name {
    color: #1f2937 !important; /* gray-800 */
}

.cafe-district {
    color: #4b5563 !important; /* gray-600 */
}

/* BUTTON */
.btn-primary {
    background: linear-gradient(to right, #f59e0b, #d97706);
    color: #fff;
    padding: .55rem 1.2rem;
    border-radius: 10px;
    font-weight: 600;
    transition: .2s;
}

.btn-primary:hover {
    opacity: .9;
}

/* BADGE */
.badge {
    padding: .25rem .7rem;
    font-size: .75rem;
    border-radius: 999px;
    font-weight: 600;
}

.badge-green {
    background: #dcfce7;
    color: #15803d;
}

.badge-red {
    background: #fee2e2;
    color: #b91c1c;
}

/* ICON */
.icon-btn {
    font-size: 1.05rem;
    transition: .2s;
}

.icon-btn:hover {
    transform: scale(1.15);
}

</style>

@endsection
