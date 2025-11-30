@extends('layouts.admin')

@section('title', 'Edit Café')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.cafes.index') }}" class="text-amber-600 hover:text-amber-700">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Cafe
    </a>
</div>

<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-bold mb-6">Edit Cafe: {{ $cafe->name }}</h2>

    {{-- Error Messages --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <p class="font-bold">Terjadi kesalahan:</p>
            <ul class="list-disc list-inside mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.cafes.update', $cafe) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- ================= LEFT COLUMN ================= -->
            <div>
                <h3 class="text-lg font-bold mb-4 text-gray-700">Informasi Dasar</h3>

                <!-- Name -->
                <div class="mb-4">
                    <label class="block font-semibold">Nama Cafe *</label>
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
                    @error('address') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <!-- City & District -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="font-semibold">Kota *</label>
                        <input type="text" name="city" value="{{ old('city', $cafe->city) }}"
                            class="w-full border rounded px-4 py-2 @error('city') border-red-500 @enderror" required>
                        @error('city') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="font-semibold">Kecamatan *</label>
                        <input type="text" name="district" value="{{ old('district', $cafe->district) }}"
                            class="w-full border rounded px-4 py-2 @error('district') border-red-500 @enderror" required>
                        @error('district') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Latitude Longitude -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="font-semibold">Latitude *</label>
                        <input type="number" step="0.00000001" name="latitude"
                            value="{{ old('latitude', $cafe->latitude) }}"
                            class="w-full border rounded px-4 py-2 @error('latitude') border-red-500 @enderror" required>
                        @error('latitude') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="font-semibold">Longitude *</label>
                        <input type="number" step="0.00000001" name="longitude"
                            value="{{ old('longitude', $cafe->longitude) }}"
                            class="w-full border rounded px-4 py-2 @error('longitude') border-red-500 @enderror" required>
                        @error('longitude') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Phone & Capacity -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="font-semibold">Telepon</label>
                        <input type="text" name="phone" value="{{ old('phone', $cafe->phone) }}"
                            class="w-full border rounded px-4 py-2 @error('phone') border-red-500 @enderror">
                        @error('phone') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="font-semibold">Kapasitas</label>
                        <input type="number" name="capacity" min="1"
                            value="{{ old('capacity', $cafe->capacity) }}"
                            class="w-full border rounded px-4 py-2 @error('capacity') border-red-500 @enderror">
                        @error('capacity') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- ================= RIGHT COLUMN ================= -->
            <div>
                <h3 class="text-lg font-bold mb-4 text-gray-700">Detail Operasional</h3>

                <!-- Open Close -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="font-semibold">Jam Buka *</label>
                        <input type="time" name="open_time" value="{{ old('open_time', $cafe->open_time) }}"
                            class="w-full border rounded px-4 py-2 @error('open_time') border-red-500 @enderror" required>
                        @error('open_time') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="font-semibold">Jam Tutup *</label>
                        <input type="time" name="close_time" value="{{ old('close_time', $cafe->close_time) }}"
                            class="w-full border rounded px-4 py-2 @error('close_time') border-red-500 @enderror" required>
                        @error('close_time') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Price Range -->
                <div class="mb-4">
                    <label class="font-semibold">Range Harga *</label>
                    <select name="price_range" class="w-full border rounded px-4 py-2 @error('price_range') border-red-500 @enderror" required>
                        <option value="">Pilih Range Harga</option>
                        <option value="$" {{ old('price_range', $cafe->price_range) == '$' ? 'selected' : '' }}>$ (Murah)</option>
                        <option value="$$" {{ old('price_range', $cafe->price_range) == '$$' ? 'selected' : '' }}>$$ (Sedang)</option>
                        <option value="$$$" {{ old('price_range', $cafe->price_range) == '$$$' ? 'selected' : '' }}>$$$ (Mahal)</option>
                    </select>
                    @error('price_range') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <!-- Atmosphere -->
                <div class="mb-4">
                    <label class="font-semibold">Suasana *</label>
                    <select name="atmosphere" class="w-full border rounded px-4 py-2 @error('atmosphere') border-red-500 @enderror" required>
                        <option value="">Pilih Suasana</option>
                        <option value="tenang" {{ old('atmosphere', $cafe->atmosphere) == 'tenang' ? 'selected' : '' }}>Tenang</option>
                        <option value="ramai" {{ old('atmosphere', $cafe->atmosphere) == 'ramai' ? 'selected' : '' }}>Ramai</option>
                        <option value="cozy" {{ old('atmosphere', $cafe->atmosphere) == 'cozy' ? 'selected' : '' }}>Cozy</option>
                        <option value="estetik" {{ old('atmosphere', $cafe->atmosphere) == 'estetik' ? 'selected' : '' }}>Estetik</option>
                    </select>
                    @error('atmosphere') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <!-- Active -->
                <div class="mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $cafe->is_active) ? 'checked' : '' }} class="mr-2">
                        <span class="font-semibold">Cafe Aktif</span>
                    </label>
                </div>

                <!-- Facilities -->
                <div class="mb-4">
                    <label class="font-semibold">Fasilitas</label>
                    <div class="border rounded p-3 max-h-48 overflow-y-auto @error('facilities') border-red-500 @enderror">
                        @forelse($facilities as $facility)
                            <label class="flex items-center mb-2">
                                <input type="checkbox" name="facilities[]" value="{{ $facility->id }}"
                                    {{ $cafe->facilities->contains($facility->id) || in_array($facility->id, (array)old('facilities', [])) ? 'checked' : '' }} class="mr-2">
                                <span>{{ $facility->name }}</span>
                            </label>
                        @empty
                            <p class="text-gray-500">Tidak ada fasilitas tersedia</p>
                        @endforelse
                    </div>
                    @error('facilities') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <!-- Activities -->
                <div class="mb-4">
                    <label class="font-semibold">Aktivitas</label>
                    <div class="border rounded p-3 max-h-48 overflow-y-auto @error('activities') border-red-500 @enderror">
                        @forelse($activities as $activity)
                            <label class="flex items-center mb-2">
                                <input type="checkbox" name="activities[]" value="{{ $activity->id }}"
                                    {{ $cafe->activities->contains($activity->id) || in_array($activity->id, (array)old('activities', [])) ? 'checked' : '' }} class="mr-2">
                                <span>{{ $activity->name }}</span>
                            </label>
                        @empty
                            <p class="text-gray-500">Tidak ada aktivitas tersedia</p>
                        @endforelse
                    </div>
                    @error('activities') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <!-- Existing Photos -->
                @if($cafe->photos->count())
                <div class="mb-4">
                    <label class="font-semibold block mb-2">Foto Saat Ini (Klik foto untuk jadikan utama)</label>
                    <div class="grid grid-cols-3 gap-3">
                        @foreach($cafe->photos as $photo)
                        <div class="relative border-2 rounded-lg p-2 {{ $photo->is_primary ? 'border-amber-500 bg-amber-50' : 'border-gray-300' }} cursor-pointer hover:border-amber-500 transition"
                             onclick="selectExistingPrimary({{ $photo->id }})">
                            <img src="{{ asset('storage/' . $photo->photo_path) }}" class="h-24 w-full object-cover rounded">
                            
                            <div class="absolute top-2 right-2">
                                <label class="bg-red-600 text-white text-xs px-2 py-1 rounded cursor-pointer hover:bg-red-700"
                                       onclick="event.stopPropagation()">
                                    <input type="checkbox" name="delete_photos[]" value="{{ $photo->id }}" class="mr-1">
                                    Hapus
                                </label>
                            </div>
                            
                            <div class="text-center mt-2">
                                <span class="text-xs photo-label-{{ $photo->id }} {{ $photo->is_primary ? 'text-amber-600 font-bold' : 'text-gray-600' }}">
                                    {{ $photo->is_primary ? '★ Foto Utama' : 'Klik untuk jadikan utama' }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Upload New Photos -->
                <div class="mb-4">
                    <label class="font-semibold">Upload Foto Baru</label>
                    <input type="file" name="new_photos[]" id="new_photos" multiple 
                        class="w-full border rounded p-2 @error('new_photos') border-red-500 @enderror" 
                        accept="image/jpeg,image/png,image/jpg"
                        onchange="previewNewImages(event)">
                    <p class="text-sm text-gray-500 mt-1">Format: JPG, JPEG, PNG. Maksimal 2MB per foto</p>
                    @error('new_photos') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <!-- Preview New Photos -->
                <div id="new-preview-container" class="mb-4 hidden">
                    <label class="font-semibold mb-2 block">Preview Foto Baru:</label>
                    <div id="new-image-previews" class="grid grid-cols-3 gap-3"></div>
                </div>

                <!-- Hidden Input for Primary Photo -->
                <input type="hidden" name="primary_photo" id="primary_photo" value="{{ $cafe->primaryPhoto->id ?? '' }}">
            </div>
        </div>

        <!-- Submit -->
        <div class="mt-6 border-t pt-4 flex gap-3">
            <button type="submit" class="bg-amber-600 text-white px-6 py-3 rounded hover:bg-amber-700">
                <i class="fas fa-save mr-2"></i> Update Cafe
            </button>
            <a href="{{ route('admin.cafes.index') }}" class="bg-gray-300 px-6 py-3 rounded hover:bg-gray-400">
                <i class="fas fa-times mr-2"></i> Batal
            </a>
        </div>
    </form>
</div>

<script>
function selectExistingPrimary(photoId) {
    document.getElementById('primary_photo').value = photoId;
    
    // Update visual selection for existing photos
    const allExisting = document.querySelectorAll('[onclick^="selectExistingPrimary"]');
    allExisting.forEach(div => {
        const currentId = div.getAttribute('onclick').match(/\d+/)[0];
        const labelSpan = div.querySelector('span[class*="photo-label"]');
        
        if (currentId == photoId) {
            div.className = 'relative border-2 rounded-lg p-2 border-amber-500 bg-amber-50 cursor-pointer hover:border-amber-500 transition';
            if (labelSpan) {
                labelSpan.className = labelSpan.className.replace('text-gray-600', 'text-amber-600 font-bold');
                labelSpan.textContent = '★ Foto Utama';
            }
        } else {
            div.className = 'relative border-2 rounded-lg p-2 border-gray-300 cursor-pointer hover:border-amber-500 transition';
            if (labelSpan) {
                labelSpan.className = labelSpan.className.replace('text-amber-600 font-bold', 'text-gray-600');
                labelSpan.textContent = 'Klik untuk jadikan utama';
            }
        }
    });
}

function previewNewImages(event) {
    const container = document.getElementById('new-preview-container');
    const previewsDiv = document.getElementById('new-image-previews');
    const files = event.target.files;
    
    previewsDiv.innerHTML = '';
    
    if (files.length > 0) {
        container.classList.remove('hidden');
        
        Array.from(files).forEach((file, index) => {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative border-2 rounded-lg p-2 border-gray-300';
                
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-24 object-cover rounded">
                    <div class="text-center mt-2">
                        <span class="text-xs text-gray-600">Foto baru #${index + 1}</span>
                    </div>
                `;
                
                previewsDiv.appendChild(div);
            };
            
            reader.readAsDataURL(file);
        });
    } else {
        container.classList.add('hidden');
    }
}
</script>
@endsection