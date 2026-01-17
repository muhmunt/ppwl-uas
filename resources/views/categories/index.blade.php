<x-app-layout>
    <x-slot name="header">
        <div class="page-header">
            <div>
                <h1 class="page-title">Manajemen Kategori</h1>
                <p class="page-subtitle">Kelola kategori menu</p>
            </div>
            <x-ui.button href="{{ route('admin.categories.create') }}" variant="primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Kategori
            </x-ui.button>
        </div>
    </x-slot>

    {{-- Filters --}}
    <x-ui.card class="mb-6">
        <form method="GET" action="{{ route('admin.categories.index') }}">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <x-ui.input type="text" name="search" :value="request('search')" placeholder="Cari kategori..."
                    class="lg:col-span-2" />

                <x-ui.select name="status" placeholder="Semua Status">
                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                </x-ui.select>

                <div class="flex gap-2">
                    <x-ui.button type="submit" variant="secondary" class="flex-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Filter
                    </x-ui.button>

                    @if(request('search') || request('status') !== null)
                        <x-ui.button href="{{ route('admin.categories.index') }}" variant="ghost">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </x-ui.button>
                    @endif
                </div>
            </div>
        </form>
    </x-ui.card>

    {{-- Categories Table --}}
    <x-ui.card :padding="false">
        <x-ui.table>
            <x-slot name="head">
                <th>Gambar</th>
                <th>Nama</th>
                <th>Deskripsi</th>
                <th>Status</th>
                <th>Urutan</th>
                <th class="text-right">Aksi</th>
            </x-slot>

            @forelse($categories as $category)
                <tr>
                    <td>
                        @if($category->image)
                            <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}"
                                class="w-14 h-14 object-cover rounded-lg border border-slate-200">
                        @else
                            <div class="w-14 h-14 bg-slate-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                    </td>
                    <td>
                        <span class="font-medium text-slate-900">{{ $category->name }}</span>
                    </td>
                    <td class="text-slate-600 max-w-xs truncate">
                        {{ Str::limit($category->description, 50) }}
                    </td>
                    <td>
                        <x-ui.badge :type="$category->is_active ? 'success' : 'danger'">
                            {{ $category->is_active ? 'Aktif' : 'Tidak Aktif' }}
                        </x-ui.badge>
                    </td>
                    <td class="text-slate-600">{{ $category->sort_order }}</td>
                    <td>
                        <div class="flex items-center justify-end gap-1">
                            {{-- View --}}
                            <x-ui.button href="{{ route('admin.categories.show', $category) }}" variant="ghost" size="sm"
                                title="Lihat">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </x-ui.button>

                            {{-- Edit --}}
                            <x-ui.button href="{{ route('admin.categories.edit', $category) }}" variant="ghost" size="sm"
                                title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </x-ui.button>

                            {{-- Delete --}}
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                                @csrf
                                @method('DELETE')
                                <x-ui.button type="submit" variant="ghost" size="sm" title="Hapus"
                                    class="text-red-600 hover:text-red-700 hover:bg-red-50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </x-ui.button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="p-0">
                        <x-ui.empty-state icon="folder" title="Tidak ada kategori"
                            description="Belum ada kategori yang ditemukan. Tambah kategori baru untuk memulai.">
                            <x-slot name="action">
                                <x-ui.button href="{{ route('admin.categories.create') }}" variant="primary" size="sm">
                                    Tambah Kategori Baru
                                </x-ui.button>
                            </x-slot>
                        </x-ui.empty-state>
                    </td>
                </tr>
            @endforelse
        </x-ui.table>

        {{-- Pagination --}}
        @if($categories->hasPages())
            <x-slot name="footer">
                {{ $categories->links() }}
            </x-slot>
        @endif
    </x-ui.card>
</x-app-layout>