<x-app-layout>
    <x-slot name="header">
        <div class="page-header">
            <div>
                <h1 class="page-title">Tambah Menu</h1>
                <p class="page-subtitle">Buat menu baru untuk dijual</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <x-ui.card>
            <form method="POST" action="{{ route('admin.menus.store') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <x-ui.select 
                    name="category_id" 
                    label="Kategori" 
                    required 
                    :error="$errors->first('category_id')"
                    placeholder="Pilih Kategori"
                >
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </x-ui.select>

                <x-ui.input 
                    name="name" 
                    label="Nama Menu" 
                    :value="old('name')" 
                    required 
                    :error="$errors->first('name')"
                    placeholder="Contoh: Nasi Goreng Spesial"
                />

                <div>
                    <label class="form-label">Deskripsi</label>
                    <textarea 
                        name="description" 
                        rows="3" 
                        class="form-input"
                        placeholder="Deskripsi menu (opsional)"
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="form-label">Harga <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500 text-sm">Rp</span>
                        <input 
                            type="number" 
                            name="price" 
                            value="{{ old('price') }}" 
                            step="100" 
                            min="0" 
                            required 
                            class="form-input pl-10"
                            placeholder="0"
                        >
                    </div>
                    @error('price')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <x-ui.input 
                    type="number" 
                    name="stock" 
                    label="Stok" 
                    :value="old('stock', 0)" 
                    min="0"
                    :error="$errors->first('stock')"
                />

                <div>
                    <label class="form-label">Gambar</label>
                    <input 
                        type="file" 
                        name="image" 
                        id="image" 
                        accept="image/*" 
                        class="form-input file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-rose-50 file:text-rose-600 file:font-medium hover:file:bg-rose-100"
                    >
                    @error('image')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                    <div id="image-preview" class="mt-3"></div>
                </div>

                <div class="flex items-center gap-2">
                    <input 
                        type="checkbox" 
                        name="is_available" 
                        value="1" 
                        id="is_available" 
                        {{ old('is_available', true) ? 'checked' : '' }}
                        class="w-4 h-4 rounded border-slate-300 text-rose-600 focus:ring-rose-500"
                    >
                    <label for="is_available" class="text-sm font-medium text-slate-700">Tersedia untuk dijual</label>
                </div>

                <div class="flex gap-3 pt-4 border-t border-slate-200">
                    <x-ui.button href="{{ route('admin.menus.index') }}" variant="ghost" class="flex-1">
                        Batal
                    </x-ui.button>
                    <x-ui.button type="submit" variant="primary" class="flex-1">
                        Simpan Menu
                    </x-ui.button>
                </div>
            </form>
        </x-ui.card>
    </div>

    <script>
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('image-preview');
                    preview.innerHTML = '<img src="' + e.target.result + '" class="w-32 h-32 object-cover rounded-lg border border-slate-200">';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-app-layout>