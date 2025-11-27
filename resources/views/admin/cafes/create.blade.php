@extends('layouts.admin')

@section('title', 'Tambah Café Baru')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.cafes.index') }}" class="text-amber-600 hover:text-amber-700">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Café
    </a>
</div>

<div class="bg-white rounded-lg shadow-md p-6">
<h2 class="text-2xl font-bold mb-6">Tambah Café Baru</h2>

<form method="POST" action="{{ route('admin.cafes.store') }}" enctype="multipart/form-data">
@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

{{-- ================= LEFT COLUMN ================= --}}
<div>
<h3 class="text-lg font-bold mb-4 text-gray-700">Informasi Dasar</h3>

<!-- Name -->
<div class="mb-4">
    <label class="font-semibold">Nama Café *</label>
    <input type="text" name="name" value="{{ old('name') }}"
        class="w-full border rounded px-4 py-2 @error('name') border-red-500 @enderror" required>
</div>

<!-- Description -->
<div class="mb-4">
    <label class="font-semibold">Deskripsi *</label>
    <textarea name="description" rows="4"
        class="w-full border rounded px-4 py-2 @error('description') border-red-500 @enderror"
        required>{{ old('description') }}</textarea>
</div>

<!-- Address -->
<div class="mb-4">
    <label class="font-semibold">Alamat *</label>
    <textarea name="address" rows="3"
        class="w-full border rounded px-4 py-2 @error('address') border-red-500 @enderror"
        required>{{ old('address') }}</textarea>
</div>

<!-- City & District -->
<div class="grid grid-cols-2 gap-4 mb-4">
<div>
    <label>Kota *</label>
    <input type="text" name="city" value="{{ old('city') }}"
        class="w-full border rounded px-4 py-2" required>
</div>
<div>
    <label>Kecamatan *</label>
    <input type="text" name="district" value="{{ old('district') }}"
        class="w-full border rounded px-4 py-2" required>
</div>
</div>

<!-- Lat Long -->
<div class="grid grid-cols-2 gap-4 mb-4">
<div>
    <label>Latitude *</label>
    <input type="number" step="0.0000001" name="latitude"
        value="{{ old('latitude') }}" class="w-full border rounded px-4 py-2" required>
</div>
<div>
    <label>Longitude *</label>
    <input type="number" step="0.0000001" name="longitude"
        value="{{ old('longitude') }}" class="w-full border rounded px-4 py-2" required>
</div>
</div>

<!-- Phone & Capacity -->
<div class="grid grid-cols-2 gap-4 mb-4">
    <input type="text" name="phone" placeholder="Telepon"
        value="{{ old('phone') }}" class="w-full border rounded px-4 py-2">
    <input type="number" name="capacity" placeholder="Kapasitas"
        value="{{ old('capacity') }}" class="w-full border rounded px-4 py-2">
</div>
</div>

{{-- ================= RIGHT COLUMN ================= --}}
<div>
<h3 class="text-lg font-bold mb-4">Detail Operasional</h3>

<!-- Jam -->
<div class="grid grid-cols-2 gap-4 mb-4">
<input type="time" name="open_time" value="{{ old('open_time') }}" class="border px-4 py-2" required>
<input type="time" name="close_time" value="{{ old('close_time') }}" class="border px-4 py-2" required>
</div>

<!-- Range Harga -->
<select name="price_range" class="border px-4 py-2 w-full mb-4" required>
<option value="">Range Harga</option>
<option value="$">$</option>
<option value="$$">$$</option>
<option value="$$$">$$$</option>
</select>

<!-- Atmosphere -->
<select name="atmosphere" class="border px-4 py-2 w-full mb-4" required>
<option value="">Suasana</option>
<option value="tenang">Tenang</option>
<option value="ramai">Ramai</option>
<option value="cozy">Cozy</option>
<option value="estetik">Estetik</option>
</select>

<!-- Facilities -->
<div class="border rounded p-2 mb-4 max-h-48 overflow-y-auto">
@foreach($facilities as $f)
<label class="block">
<input type="checkbox" name="facilities[]" value="{{ $f->id }}"
{{ in_array($f->id, (array)old('facilities')) ? 'checked':'' }}>
{{ $f->name }}
</label>
@endforeach
</div>

<!-- Activities -->
<div class="border rounded p-2 mb-4 max-h-48 overflow-y-auto">
@foreach($activities as $a)
<label class="block">
<input type="checkbox" name="activities[]" value="{{ $a->id }}"
{{ in_array($a->id, (array)old('activities')) ? 'checked':'' }}>
{{ $a->name }}
</label>
@endforeach
</div>

<!-- Photos -->
<div class="mb-4">
<input type="file" name="photos[]" class="border w-full p-2" multiple required>
</div>

<!-- Primary -->
<div class="mb-4">
<input type="number" name="primary_photo" class="border p-2 w-full" placeholder="Index foto utama (0,1,2…)" required>
</div>
</div>

</div>

<div class="mt-6 border-t pt-4">
<button class="bg-amber-600 text-white px-6 py-3 rounded">Simpan Café</button>
<a href="{{ route('admin.cafes.index') }}" class="ml-2 bg-gray-300 px-6 py-3 rounded">Batal</a>
</div>

</form>
</div>
@endsection
