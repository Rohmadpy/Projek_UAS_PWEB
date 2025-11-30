@extends('layouts.admin')

@section('title', 'Tambah Cafe Baru')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.cafes.index') }}" class="text-amber-600 hover:text-amber-700">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Cafe
    </a>
</div>

<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-bold mb-6">Tambah Cafe Baru</h2>

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

    <form method="POST" action="{{ route('admin.cafes.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- ================= LEFT COLUMN ================= --}}
            <div>
                <h3 class="text-lg font-bold mb-4 text-gray-700">Informasi Dasar</h3>

                <!-- Name -->
                <div class="mb-4">
                    <label class="font-semibold">Nama Cafe *</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full border rounded px-4 py-2 @error('name') border-red-500 @enderror" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label class="font-semibold">Deskripsi *</label>
                    <textarea name="description" rows="4"
                        class="w-full border rounded px-4 py-2 @error('description') border-red-500 @enderror"
                        required>{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div class="mb-4">
                    <label class="font-semibold">Alamat *</label>
                    <textarea name="address" rows="3"
                        class="w-full border rounded px-4 py-2 @error('address') border-red-500 @enderror"
                        required>{{ old('address') }}</textarea>
                    @error('address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- City & District -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="font-semibold">Kota *</label>
                        <input type="text" name="city" value="{{ old('city') }}"
                            class="w-full border rounded px-4 py-2 @error('city') border-red-500 @enderror" required>
                        @error('city')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="font-semibold">Kecamatan *</label>
                        <input type="text" name="district" value="{{ old('district') }}"
                            class="w-full border rounded px-4 py-2 @error('district') border-red-500 @enderror" required>
                        @error('district')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Lat Long -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="font-semibold">Latitude *</label>
                        <input type="number" step="0.0000001" name="latitude"
                            value="{{ old('latitude') }}" 
                            class="w-full border rounded px-4 py-2 @error('latitude') border-red-500 @enderror" required>
                        @error('latitude')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="font-semibold">Longitude *</label>
                        <input type="number" step="0.0000001" name="longitude"
                            value="{{ old('longitude') }}" 
                            class="w-full border rounded px-4 py-2 @error('longitude') border-red-500 @enderror" required>
                        @error('longitude')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Phone & Capacity -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="font-semibold">Telepon</label>
                        <input type="text" name="phone" placeholder="Telepon"
                            value="{{ old('phone') }}" 
                            class="w-full border rounded px-4 py-2 @error('phone') border-red-500 @enderror">
                        @error('phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="font-semibold">Kapasitas</label>
                        <input type="number" name="capacity" placeholder="Kapasitas"
                            value="{{ old('capacity') }}" 
                            class="w-full border rounded px-4 py-2 @error('capacity') border-red-500 @enderror">
                        @error('capacity')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- ================= RIGHT COLUMN ================= --}}
            <div>
                <h3 class="text-lg font-bold mb-4 text-gray-700">Detail Operasional</h3>

                <!-- Jam -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="font-semibold">Jam Buka *</label>
                        <input type="time" name="open_time" value="{{ old('open_time') }}" 
                            class="w-full border rounded px-4 py-2 @error('open_time') border-red-500 @enderror" required>
                        @error('open_time')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="font-semibold">Jam Tutup *</label>
                        <input type="time" name="close_time" value="{{ old('close_time') }}" 
                            class="w-full border rounded px-4 py-2 @error('close_time') border-red-500 @enderror" required>
                        @error('close_time')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Range Harga -->
                <div class="mb-4">
                    <label class="font-semibold">Range Harga *</label>
                    <select name="price_range" 
                        class="w-full border rounded px-4 py-2 @error('price_range') border-red-500 @enderror" required>
                        <option value="">Pilih Range Harga</option>
                        <option value="$" {{ old('price_range') == '$' ? 'selected' : '' }}>$ (Murah)</option>
                        <option value="$$" {{ old('price_range') == '$$' ? 'selected' : '' }}>$$ (Sedang)</option>
                        <option value="$$$" {{ old('price_range') == '$$$' ? 'selected' : '' }}>$$$ (Mahal)</option>
                    </select>
                    @error('price_range')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Atmosphere -->
                <div class="mb-4">
                    <label class="font-semibold">Suasana *</label>
                    <select name="atmosphere" 
                        class="w-full border rounded px-4 py-2 @error('atmosphere') border-red-500 @enderror" required>
                        <option value="">Pilih Suasana</option>
                        <option value="tenang" {{ old('atmosphere') == 'tenang' ? 'selected' : '' }}>Tenang</option>
                        <option value="ramai" {{ old('atmosphere') == 'ramai' ? 'selected' : '' }}>Ramai</option>
                        <option value="cozy" {{ old('atmosphere') == 'cozy' ? 'selected' : '' }}>Cozy</option>
                        <option value="estetik" {{ old('atmosphere') == 'estetik' ? 'selected' : '' }}>Estetik</option>
                    </select>
                    @error('atmosphere')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Facilities -->
                <div class="mb-4">
                    <label class="font-semibold">Fasilitas</label>
                    <div class="border rounded p-3 max-h-48 overflow-y-auto @error('facilities') border-red-500 @enderror">
                        @forelse($facilities as $f)
                            <label class="flex items-center mb-2">
                                <input type="checkbox" name="facilities[]" value="{{ $f->id }}"
                                    {{ in_array($f->id, (array)old('facilities', [])) ? 'checked' : '' }}
                                    class="mr-2">
                                <span>{{ $f->name }}</span>
                            </label>
                        @empty
                            <p class="text-gray-500">Tidak ada fasilitas tersedia</p>
                        @endforelse
                    </div>
                    @error('facilities')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Activities -->
                <div class="mb-4">
                    <label class="font-semibold">Aktivitas</label>
                    <div class="border rounded p-3 max-h-48 overflow-y-auto @error('activities') border-red-500 @enderror">
                        @forelse($activities as $a)
                            <label class="flex items-center mb-2">
                                <input type="checkbox" name="activities[]" value="{{ $a->id }}"
                                    {{ in_array($a->id, (array)old('activities', [])) ? 'checked' : '' }}
                                    class="mr-2">
                                <span>{{ $a->name }}</span>
                            </label>
                        @empty
                            <p class="text-gray-500">Tidak ada aktivitas tersedia</p>
                        @endforelse
                    </div>
                    @error('activities')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Photos Upload -->
                <div class="mb-4">
                    <label class="font-semibold">Upload Foto Cafe * (Minimal 1 foto)</label>
                    <input type="file" name="photos[]" id="photos" 
                        class="w-full border rounded p-2 @error('photos') border-red-500 @enderror" 
                        multiple required accept="image/jpeg,image/png,image/jpg"
                        onchange="previewImages(event)">
                    <p class="text-sm text-gray-500 mt-1">Format: JPG, JPEG, PNG. Maksimal 2MB per foto</p>
                    @error('photos')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Preview & Select Primary Photo -->
                <div id="preview-container" class="mb-4 hidden">
                    <label class="font-semibold mb-2 block">Pilih Foto Utama (Klik foto untuk memilih):</label>
                    <div id="image-previews" class="grid grid-cols-3 gap-3"></div>
                </div>

                <!-- Hidden Input for Primary Photo Index -->
                <input type="hidden" name="primary_photo" id="primary_photo" value="0">
            </div>

        </div>

        <div class="mt-6 border-t pt-4">
            <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white px-6 py-3 rounded">
                <i class="fas fa-save mr-2"></i> Simpan Cafe
            </button>
            <a href="{{ route('admin.cafes.index') }}" class="ml-2 bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-3 rounded inline-block">
                <i class="fas fa-times mr-2"></i> Batal
            </a>
        </div>

    </form>
</div>

<script>
function previewImages(event) {
    const container = document.getElementById('preview-container');
    const previewsDiv = document.getElementById('image-previews');
    const files = event.target.files;
    
    previewsDiv.innerHTML = '';
    
    if (files.length > 0) {
        container.classList.remove('hidden');
        
        Array.from(files).forEach((file, index) => {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative border-2 rounded-lg p-2 cursor-pointer hover:border-amber-500 transition ' + (index === 0 ? 'border-amber-500 bg-amber-50' : 'border-gray-300');
                div.onclick = () => selectPrimary(index);
                
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-32 object-cover rounded">
                    <div class="text-center mt-2">
                        <span class="text-xs ${index === 0 ? 'text-amber-600 font-bold' : 'text-gray-600'}">
                            ${index === 0 ? '★ Foto Utama' : 'Klik untuk jadikan utama'}
                        </span>
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

function selectPrimary(index) {
    document.getElementById('primary_photo').value = index;
    
    // Update visual selection
    const allDivs = document.querySelectorAll('#image-previews > div');
    allDivs.forEach((div, i) => {
        if (i === index) {
            div.className = 'relative border-2 rounded-lg p-2 cursor-pointer border-amber-500 bg-amber-50 transition';
            div.querySelector('span').className = 'text-xs text-amber-600 font-bold';
            div.querySelector('span').textContent = '★ Foto Utama';
        } else {
            div.className = 'relative border-2 rounded-lg p-2 cursor-pointer hover:border-amber-500 transition border-gray-300';
            div.querySelector('span').className = 'text-xs text-gray-600';
            div.querySelector('span').textContent = 'Klik untuk jadikan utama';
        }
    });
}
</script>
@endsection