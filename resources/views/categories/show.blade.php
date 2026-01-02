<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Kategori') }}
            </h2>
            <div>
                <a href="{{ route('categories.edit', $category) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
                    Edit
                </a>
                <a href="{{ route('categories.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
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
                            @if($category->image)
                                <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" class="w-full h-64 object-cover rounded-lg">
                            @else
                                <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <span class="text-gray-400">No Image</span>
                                </div>
                            @endif
                        </div>

                        <!-- Details -->
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ $category->name }}</h3>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                @if($category->is_active)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Tidak Aktif</span>
                                @endif
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Urutan</label>
                                <p class="text-gray-900">{{ $category->sort_order }}</p>
                            </div>

                            @if($category->description)
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                    <p class="text-gray-900">{{ $category->description }}</p>
                                </div>
                            @endif

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Total Menu</label>
                                <p class="text-gray-900">{{ $category->menus->count() }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Menu List -->
                    @if($category->menus->count() > 0)
                        <div class="mt-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Menu dalam Kategori ini</h4>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Menu</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($category->menus as $menu)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $menu->name }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if($menu->is_available)
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Tersedia</span>
                                                    @else
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Tidak Tersedia</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
