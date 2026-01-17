<x-app-layout>
    <x-slot name="header">
        <div class="page-header">
            <div>
                <h1 class="page-title">{{ $category->name }}</h1>
                <p class="page-subtitle">Detail kategori</p>
            </div>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route('admin.categories.edit', $category) }}" variant="secondary" size="sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </x-ui.button>
                <x-ui.button href="{{ route('admin.categories.index') }}" variant="ghost" size="sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </x-ui.button>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        {{-- Category Details --}}
        <x-ui.card>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Image --}}
                <div>
                    @if($category->image)
                        <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}"
                            class="w-full h-64 object-cover rounded-xl shadow-soft">
                    @else
                        <div class="w-full h-64 bg-slate-100 rounded-xl flex items-center justify-center">
                            <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                    @endif
                </div>

                {{-- Details --}}
                <div class="space-y-5">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900">{{ $category->name }}</h2>
                        <div class="mt-2">
                            @if($category->is_active)
                                <x-ui.badge type="success">Aktif</x-ui.badge>
                            @else
                                <x-ui.badge type="danger">Tidak Aktif</x-ui.badge>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 py-4 border-y border-slate-100">
                        <div>
                            <p class="text-sm text-slate-500">Urutan</p>
                            <p class="text-lg font-semibold text-slate-900">{{ $category->sort_order }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500">Total Menu</p>
                            <p class="text-lg font-semibold text-slate-900">{{ $category->menus->count() }}</p>
                        </div>
                    </div>

                    @if($category->description)
                        <div>
                            <p class="text-sm font-medium text-slate-500 mb-2">Deskripsi</p>
                            <p class="text-slate-700">{{ $category->description }}</p>
                        </div>
                    @endif

                    <div class="pt-4 border-t border-slate-100">
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                            @csrf
                            @method('DELETE')
                            <x-ui.button type="submit" variant="danger" class="w-full">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Hapus Kategori
                            </x-ui.button>
                        </form>
                    </div>
                </div>
            </div>
        </x-ui.card>

        {{-- Menu List --}}
        @if($category->menus->count() > 0)
            <x-ui.card :padding="false">
                <x-slot name="header">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <h3 class="font-semibold text-slate-900">Menu dalam Kategori</h3>
                        <span class="ml-auto text-sm text-slate-500">{{ $category->menus->count() }} menu</span>
                    </div>
                </x-slot>

                <x-ui.table>
                    <x-slot name="head">
                        <th>Nama Menu</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                    </x-slot>

                    @foreach($category->menus as $menu)
                        <tr>
                            <td class="font-medium text-slate-900">{{ $menu->name }}</td>
                            <td class="font-semibold text-emerald-600">Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                            <td>{{ $menu->stock }}</td>
                            <td>
                                @if($menu->is_available)
                                    <x-ui.badge type="success">Tersedia</x-ui.badge>
                                @else
                                    <x-ui.badge type="danger">Tidak Tersedia</x-ui.badge>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </x-ui.table>
            </x-ui.card>
        @endif
    </div>
</x-app-layout>