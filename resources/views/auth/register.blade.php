@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="min-h-screen flex items-center justify-center px-6 py-12">

    <div class="w-full max-w-md glass rounded-3xl shadow-xl p-8" data-aos="zoom-in">

        <!-- LOGO / HEADER -->
        <div class="text-center mb-6">
            <div class="mx-auto w-16 h-16 flex items-center justify-center bg-amber-500 text-black rounded-full shadow-lg mb-4">
                <i class="fas fa-user-plus text-2xl"></i>
            </div>
            <h2 class="text-3xl font-bold text-white">Daftar Akun</h2>
            <p class="text-white/70">Buat akun CaffeSpot</p>
        </div>

        <!-- FORM -->
        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- NAME -->
            <div>
                <label class="block text-sm font-semibold text-white mb-1">
                    <i class="fas fa-user mr-1"></i> Nama Lengkap
                </label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="input-ui @error('name') border-red-500 @enderror"
                    placeholder="John Doe" required>
                @error('name') <p class="error-ui">{{ $message }}</p> @enderror
            </div>

            <!-- EMAIL -->
            <div>
                <label class="block text-sm font-semibold text-white mb-1">
                    <i class="fas fa-envelope mr-1"></i> Email
                </label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="input-ui @error('email') border-red-500 @enderror"
                    placeholder="email@contoh.com" required>
                @error('email') <p class="error-ui">{{ $message }}</p> @enderror
            </div>

            <!-- PHONE -->
            <div>
                <label class="block text-sm font-semibold text-white mb-1">
                    <i class="fas fa-phone mr-1"></i> No. Telepon (Opsional)
                </label>
                <input type="text" name="phone" value="{{ old('phone') }}"
                    class="input-ui"
                    placeholder="08xxxxxxxxxx">
            </div>

            <!-- PASSWORD -->
            <div>
                <label class="block text-sm font-semibold text-white mb-1">
                    <i class="fas fa-lock mr-1"></i> Password
                </label>
                <input type="password" name="password"
                    class="input-ui @error('password') border-red-500 @enderror"
                    placeholder="Min. 8 karakter" required>
                @error('password') <p class="error-ui">{{ $message }}</p> @enderror
            </div>

            <!-- CONFIRM -->
            <div>
                <label class="block text-sm font-semibold text-white mb-1">
                    <i class="fas fa-lock mr-1"></i> Konfirmasi Password
                </label>
                <input type="password" name="password_confirmation"
                    class="input-ui"
                    placeholder="Ulangi password" required>
            </div>

            <!-- SUBMIT -->
            <button type="submit" class="btn-primary w-full mt-2">
                <i class="fas fa-user-plus mr-2"></i> Daftar
            </button>
        </form>

        <!-- LOGIN -->
        <p class="text-center text-sm text-white/70 mt-6">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-amber-400 hover:underline">Login sekarang</a>
        </p>

    </div>
</div>

<!-- STYLE -->
<style>
    .glass {
        background: rgba(255,255,255,0.08);
        backdrop-filter: blur(15px);
    }

    .input-ui {
        width: 100%;
        padding: 10px 14px;
        border-radius: .75rem;
        background: rgba(255,255,255,.1);
        border: 1px solid rgba(255,255,255,.2);
        color: white;
        outline: none;
        transition: .3s;
    }

    .input-ui:focus {
        border-color: #f59e0b;
        box-shadow: 0 0 0 2px #f59e0b55;
    }

    .btn-primary {
        background: linear-gradient(to right, #f59e0b, #fb923c);
        padding: 12px;
        font-weight: bold;
        border-radius: .75rem;
        color: black;
        transition: .3s;
    }

    .btn-primary:hover {
        transform: scale(1.03);
        filter: brightness(1.05);
    }

    .error-ui {
        color: #f87171;
        font-size: .8rem;
        margin-top: 4px;
    }
</style>
@endsection
