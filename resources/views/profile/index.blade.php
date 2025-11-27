@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-16" data-aos="fade-up">

    <div class="mb-10 text-center">
        <h1 class="text-4xl font-bold bg-gradient-to-r from-amber-400 to-orange-500 bg-clip-text text-transparent">
            Profil Saya
        </h1>
        <p class="text-white/60 mt-2">Kelola data akun pribadimu</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

        <!-- PROFILE CARD -->
        <div class="glass rounded-2xl shadow-lg p-6 text-center hover:scale-105 transition" data-aos="zoom-in">

            @if($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}"
                     class="w-36 h-36 mx-auto rounded-full ring-4 ring-amber-400 object-cover shadow-lg">
            @else
                <div class="w-36 h-36 mx-auto rounded-full bg-amber-500 flex items-center justify-center shadow-lg">
                    <i class="fas fa-user text-5xl text-white"></i>
                </div>
            @endif

            <h2 class="mt-4 text-xl font-bold">{{ $user->name }}</h2>
            <p class="text-white/60">{{ $user->email }}</p>
            <p class="text-sm text-white/40 mt-1">
                Bergabung {{ $user->created_at->format('d M Y') }}
            </p>
        </div>

        <!-- FORM -->
        <div class="md:col-span-2 glass rounded-2xl p-8 shadow-lg" data-aos="fade-left">

            <h3 class="text-2xl font-bold text-amber-400 mb-8">Edit Profil</h3>

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- NAME -->
                <div>
                    <label class="flex items-center gap-2 mb-1 text-white/80">
                        <i class="fas fa-user"></i> Nama Lengkap
                    </label>
                    <input type="text" name="name" value="{{ old('name',$user->name) }}"
                           class="w-full px-4 py-3 rounded-xl bg-black/30 border border-white/10 focus:ring-2 focus:ring-amber-400 outline-none">
                    @error('name') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- EMAIL -->
                <div>
                    <label class="flex items-center gap-2 mb-1 text-white/80">
                        <i class="fas fa-envelope"></i> Email
                    </label>
                    <input type="email" name="email" value="{{ old('email',$user->email) }}"
                           class="w-full px-4 py-3 rounded-xl bg-black/30 border border-white/10 focus:ring-2 focus:ring-amber-400 outline-none">
                    @error('email') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- PHONE -->
                <div>
                    <label class="flex items-center gap-2 mb-1 text-white/80">
                        <i class="fas fa-phone"></i> No. Telepon
                    </label>
                    <input type="text" name="phone" value="{{ old('phone',$user->phone) }}"
                           class="w-full px-4 py-3 rounded-xl bg-black/30 border border-white/10 focus:ring-2 focus:ring-amber-400 outline-none">
                </div>

                <!-- AVATAR -->
                <div>
                    <label class="flex items-center gap-2 mb-1 text-white/80">
                        <i class="fas fa-image"></i> Foto Profil
                    </label>
                    <input type="file" name="avatar"
                           class="w-full px-4 py-3 rounded-xl bg-black/30 border border-white/10 text-white">
                    <p class="text-white/40 text-xs mt-1">Max 2MB (JPG, PNG)</p>
                    @error('avatar') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="my-10 border-t border-white/10"></div>

            <h4 class="text-lg font-semibold text-white mb-4">Ubah Password</h4>

            <!-- PASSWORDS -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="flex items-center gap-2 mb-1 text-white/80">
                        <i class="fas fa-lock"></i> Password Saat Ini
                    </label>
                    <input type="password" name="current_password"
                           placeholder="Kosongkan jika tidak ingin ubah"
                           class="w-full px-4 py-3 rounded-xl bg-black/30 border border-white/10 focus:ring-2 focus:ring-amber-400 outline-none">
                    @error('current_password') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="flex items-center gap-2 mb-1 text-white/80">
                        <i class="fas fa-key"></i> Password Baru
                    </label>
                    <input type="password" name="new_password"
                           placeholder="Minimal 8 karakter"
                           class="w-full px-4 py-3 rounded-xl bg-black/30 border border-white/10 focus:ring-2 focus:ring-amber-400 outline-none">
                    @error('new_password') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="flex items-center gap-2 mb-1 text-white/80">
                        <i class="fas fa-key"></i> Konfirmasi Password Baru
                    </label>
                    <input type="password" name="new_password_confirmation"
                           placeholder="Ulangi password"
                           class="w-full px-4 py-3 rounded-xl bg-black/30 border border-white/10 focus:ring-2 focus:ring-amber-400 outline-none">
                </div>

            </div>

            <!-- BUTTON -->
            <button type="submit"
                    class="mt-10 w-full bg-gradient-to-r from-amber-400 to-orange-500 py-4 rounded-xl font-bold hover:scale-105 transition shadow-lg">
                <i class="fas fa-save mr-2"></i> Simpan Perubahan
            </button>

            </form>
        </div>

    </div>
</div>
@endsection
