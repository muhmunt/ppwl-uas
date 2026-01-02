<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Menu') }}
            </h2>
            <div>
                <a href="{{ route('menus.edit', $menu) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
                    Edit
                </a>
                <a href="{{ route('menus.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Image -->
                        <div>
                            @if($menu->image)
                                <img src="{{ Storage::url($menu->image) }}" alt="{{ $menu->name }}" class="w-full h-64 object-cover rounded-lg">
                            @else
                                <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <span class="text-gray-400">No Image</span>
                                </div>
                            @endif
                        </div>

                        <!-- Details -->
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ $menu->name }}</h3>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Kategori</label>
                                <p class="text-gray-900">{{ $menu->category->name }}</p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Harga</label>
                                <p class="text-gray-900 text-xl font-bold">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Stok</label>
                                <p class="text-gray-900">{{ $menu->stock }}</p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                @if($menu->is_available)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Tersedia</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Tidak Tersedia</span>
                                @endif
                            </div>

                            @if($menu->description)
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                    <p class="text-gray-900">{{ $menu->description }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
