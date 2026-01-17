<x-app-layout>
    <x-slot name="header">
        <div class="page-header">
            <div>
                <h1 class="page-title">Edit Kategori</h1>
                <p class="page-subtitle">{{ $category->name }}</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <x-ui.card>
            <form method="POST" action="{{ route('admin.categories.update', $category) }}" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')

                <x-ui.input 
                    name="name" 
                    label="Nama Kategori" 
                    :value="old('name', $category->name)" 
                    required 
                    :error="$errors->first('name')"
                />

                <div>
                    <label class="form-label">Deskripsi</label>
                    <textarea 
                        name="description" 
                        rows="3" 
                        class="form-input"
                        placeholder="Deskripsi kategori (opsional)"
                    >{{ old('description', $category->description) }}</textarea>
                    @error('description')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="form-label">Gambar</label>
                    @if($category->image)
                        <div class="mb-3">
                            <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" class="w-32 h-32 object-cover rounded-lg border border-slate-200">
                        </div>
                    @endif
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

                <x-ui.input 
                    type="number" 
                    name="sort_order" 
                    label="Urutan" 
                    :value="old('sort_order', $category->sort_order)" 
                    min="0"
                    :error="$errors->first('sort_order')"
                />

                <div class="flex items-center gap-2">
                    <input 
                        type="checkbox" 
                        name="is_active" 
                        value="1" 
                        id="is_active" 
                        {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                        class="w-4 h-4 rounded border-slate-300 text-rose-600 focus:ring-rose-500"
                    >
                    <label for="is_active" class="text-sm font-medium text-slate-700">Aktif</label>
                </div>

                <div class="flex gap-3 pt-4 border-t border-slate-200">
                    <x-ui.button href="{{ route('admin.categories.index') }}" variant="ghost" class="flex-1">
                        Batal
                    </x-ui.button>
                    <x-ui.button type="submit" variant="primary" class="flex-1">
                        Update Kategori
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