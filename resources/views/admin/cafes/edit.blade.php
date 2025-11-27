@extends('layouts.admin')

@section('title', 'Edit Café')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.cafes.index') }}" class="text-amber-600 hover:text-amber-700">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Café
    </a>
</div>

<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-bold mb-6">Edit Café: {{ $cafe->name }}</h2>

    <form method="POST" action="{{ route('admin.cafes.update', $cafe) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- ================= LEFT COLUMN ================= -->
            <div>
                <h3 class="text-lg font-bold mb-4 text-gray-700">Informasi Dasar</h3>

                <!-- Name -->
                <div class="mb-4">
                    <label class="block font-semibold">Nama Café *</label>
                    <input type="text" name="name" value="{{ old('name', $cafe->name) }}"
                        class="w-full border rounded px-4 py-2 @error('name') border-red-500 @enderror" required>
                    @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label class="block font-semibold">Deskripsi *</label>
                    <textarea name="description" rows="4"
                        class="w-full border rounded px-4 py-2 @error('description') border-red-500 @enderror" required>{{ old('description', $cafe->description) }}</textarea>
                    @error('description') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <!-- Address -->
                <div class="mb-4">
                    <label class="block font-semibold">Alamat Lengkap *</label>
                    <textarea name="address" rows="3"
                        class="w-full border rounded px-4 py-2 @error('address') border-red-500 @enderror" required>{{ old('address', $cafe->address) }}</textarea>
                </div>

                <!-- City & District -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="font-semibold">Kota *</label>
                        <input type="text" name="city" value="{{ old('city', $cafe->city) }}"
                            class="w-full border rounded px-4 py-2" required>
                    </div>
                    <div>
                        <label class="font-semibold">Kecamatan *</label>
                        <input type="text" name="district" value="{{ old('district', $cafe->district) }}"
                            class="w-full border rounded px-4 py-2" required>
                    </div>
                </div>

                <!-- Latitude Longitude -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="font-semibold">Latitude *</label>
                        <input type="number" step="0.00000001" name="latitude"
                            value="{{ old('latitude', $cafe->latitude) }}"
                            class="w-full border rounded px-4 py-2" required>
                    </div>
                    <div>
                        <label class="font-semibold">Longitude *</label>
                        <input type="number" step="0.00000001" name="longitude"
                            value="{{ old('longitude', $cafe->longitude) }}"
                            class="w-full border rounded px-4 py-2" required>
                    </div>
                </div>

                <!-- Phone & Capacity -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label>Telepon</label>
                        <input type="text" name="phone" value="{{ old('phone', $cafe->phone) }}"
                            class="w-full border rounded px-4 py-2">
                    </div>
                    <div>
                        <label>Kapasitas</label>
                        <input type="number" name="capacity" min="1"
                            value="{{ old('capacity', $cafe->capacity) }}"
                            class="w-full border rounded px-4 py-2">
                    </div>
                </div>
            </div>

            <!-- ================= RIGHT COLUMN ================= -->
            <div>
                <h3 class="text-lg font-bold mb-4 text-gray-700">Detail Operasional</h3>

                <!-- Open Close -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label>Jam Buka *</label>
                        <input type="time" name="open_time" value="{{ old('open_time', $cafe->open_time) }}"
                            class="w-full border rounded px-4 py-2" required>
                    </div>
                    <div>
                        <label>Jam Tutup *</label>
                        <input type="time" name="close_time" value="{{ old('close_time', $cafe->close_time) }}"
                            class="w-full border rounded px-4 py-2" required>
                    </div>
                </div>

                <!-- Price Range -->
                <div class="mb-4">
                    <label>Range Harga *</label>
                    <select name="price_range" class="w-full border rounded px-4 py-2" required>
                        <option value="">Pilih</option>
                        <option value="$" {{ old('price_range', $cafe->price_range) == '$' ? 'selected' : '' }}>$</option>
                        <option value="$$" {{ old('price_range', $cafe->price_range) == '$$' ? 'selected' : '' }}>$$</option>
                        <option value="$$$" {{ old('price_range', $cafe->price_range) == '$$$' ? 'selected' : '' }}>$$$</option>
                    </select>
                </div>

                <!-- Atmosphere -->
                <div class="mb-4">
                    <label>Suasana *</label>
                    <select name="atmosphere" class="w-full border rounded px-4 py-2" required>
                        <option value="tenang" {{ $cafe->atmosphere == 'tenang' ? 'selected' : '' }}>Tenang</option>
                        <option value="ramai" {{ $cafe->atmosphere == 'ramai' ? 'selected' : '' }}>Ramai</option>
                        <option value="cozy" {{ $cafe->atmosphere == 'cozy' ? 'selected' : '' }}>Cozy</option>
                        <option value="estetik" {{ $cafe->atmosphere == 'estetik' ? 'selected' : '' }}>Estetik</option>
                    </select>
                </div>

                <!-- Active -->
                <div class="mb-4">
                    <label><input type="checkbox" name="is_active" value="1" {{ $cafe->is_active ? 'checked' : '' }}> Café Aktif</label>
                </div>

                <!-- Facilities -->
                <div class="mb-4">
                    <label>Fasilitas</label>
                    <div class="grid grid-cols-2 gap-2 border p-2 rounded">
                        @foreach($facilities as $facility)
                            <label>
                                <input type="checkbox" name="facilities[]" value="{{ $facility->id }}"
                                    {{ $cafe->facilities->contains($facility->id) ? 'checked' : '' }}>
                                {{ $facility->name }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Activities -->
                <div class="mb-4">
                    <label>Aktivitas</label>
                    @foreach($activities as $activity)
                        <label class="block">
                            <input type="checkbox" name="activities[]" value="{{ $activity->id }}"
                                {{ $cafe->activities->contains($activity->id) ? 'checked' : '' }}>
                            {{ $activity->name }}
                        </label>
                    @endforeach
                </div>

                <!-- Existing Photos -->
                @if($cafe->photos->count())
                <div class="mb-4">
                    <label>Foto Saat Ini</label>
                    <div class="grid grid-cols-3 gap-2">
                        @foreach($cafe->photos as $photo)
                        <div class="relative">
                            <img src="{{ asset('storage/' . $photo->photo_path) }}" class="h-24 w-full object-cover rounded">
                            <label class="absolute top-0 right-0 bg-red-600 text-white text-xs p-1">
                                <input type="checkbox" name="delete_photos[]" value="{{ $photo->id }}"> Hapus
                            </label>
                            @if($photo->is_primary)
                            <span class="absolute bottom-0 left-0 bg-amber-600 text-xs text-white px-2">Primary</span>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Upload -->
                <div class="mb-4">
                    <label>Upload Foto Baru</label>
                    <input type="file" name="new_photos[]" multiple class="w-full border rounded px-4 py-2">
                </div>

                <!-- Primary -->
                <div class="mb-4">
                    <label>Foto Utama</label>
                    <select name="primary_photo" class="w-full border rounded px-4 py-2">
                        @foreach($cafe->photos as $photo)
                            <option value="{{ $photo->id }}" {{ $photo->is_primary ? 'selected' : '' }}>
                                Foto #{{ $loop->iteration }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Submit -->
        <div class="mt-6 border-t pt-4 flex gap-3">
            <button class="bg-amber-600 text-white px-6 py-2 rounded hover:bg-amber-700">
                <i class="fas fa-save"></i> Update
            </button>
            <a href="{{ route('admin.cafes.index') }}" class="bg-gray-300 px-6 py-2 rounded">Batal</a>
        </div>
    </form>
</div>
@endsection
