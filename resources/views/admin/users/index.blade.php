@extends('layouts.admin')

@section('title', 'Kelola User')

@section('content')

<!-- HEADER -->
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-3xl font-bold text-gray-800">Kelola User</h2>
        <p class="text-gray-500">Total: {{ $users->total() }} user</p>
    </div>
</div>

<!-- FILTER -->
<div class="glass-box mb-6">
    <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col md:flex-row gap-4">

        <select name="status" class="filter-input">
            <option value="">Semua Status</option>
            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
        </select>

        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari nama atau email..." class="filter-input flex-1">

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
                <th class="cell-header">Nama</th>
                <th class="cell-header">Email</th>
                <th class="cell-header">Status</th>
                <th class="cell-header">Bergabung</th>
                <th class="cell-header">Aksi</th>
            </tr>
        </thead>
        <tbody>

        @forelse($users as $user)
            <tr class="hover:bg-gray-50 transition">
                <td class="cell font-semibold">{{ $user->name }}</td>
                <td class="cell">{{ $user->email }}</td>
                <td class="cell">
                    <span class="badge {{ $user->is_active ? 'badge-green' : 'badge-red' }}">
                        {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td class="cell">{{ $user->created_at->format('d M Y') }}</td>
                <td class="cell">
                    <div class="flex items-center gap-3">

                        <!-- TOGGLE -->
                        <form method="POST" action="{{ route('admin.users.toggle', $user) }}">
                            @csrf
                            <button type="submit"
                                class="icon-btn {{ $user->is_active ? 'icon-danger' : 'icon-success' }}"
                                title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                <i class="fas {{ $user->is_active ? 'fa-ban' : 'fa-check-circle' }}"></i>
                            </button>
                        </form>

                        <!-- RESET -->
                        <form method="POST" action="{{ route('admin.users.reset-password', $user) }}"
                            onsubmit="return confirm('Reset password user ini?')">
                            @csrf
                            <button type="submit" class="icon-btn icon-warning" title="Reset Password">
                                <i class="fas fa-key"></i>
                            </button>
                        </form>

                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center py-6 text-gray-500">Belum ada user</td>
            </tr>
        @endforelse

        </tbody>
    </table>
</div>

<!-- PAGINATION -->
<div class="mt-6">
    {{ $users->links() }}
</div>

<!-- STYLE -->
<style>

.glass-box {
    background: rgba(255,255,255,.96);
    border-radius: 14px;
    padding: 1.2rem;
    box-shadow: 0 10px 25px rgba(0,0,0,.05);
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

/* FIX WARNA TEKS DI TABEL (BIAR GA PUTIH) */
.cell {
    padding: .7rem;
    color: #1f2937 !important; /* warna teks hitam-abu gelap */
}

.cell.font-semibold {
    color: #111827 !important; /* lebih gelap untuk nama */
}

.badge {
    font-size: .75rem;
    padding: .18rem .6rem;
    border-radius: 99px;
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

/* ACTION BTN */
.icon-btn {
    font-size: 1rem;
    transition: .2s;
}

.icon-danger { color: #dc2626; }
.icon-success { color: #16a34a; }
.icon-warning { color: #d97706; }

.icon-btn:hover { transform: scale(1.15); }

</style>

@endsection
