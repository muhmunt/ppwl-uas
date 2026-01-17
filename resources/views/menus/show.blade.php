@php
    $isAdmin = auth()->user()->role === 'admin';
    $routePrefix = $isAdmin ? 'admin.' : '';
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="page-header">
            <div>
                <h1 class="page-title">{{ $menu->name }}</h1>
                <p class="page-subtitle">Detail menu</p>
            </div>
            <div class="flex items-center gap-2">
                @if($isAdmin)
                    <x-ui.button href="{{ route('admin.menus.edit', $menu) }}" variant="secondary" size="sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit
                    </x-ui.button>
                @endif
                <x-ui.button href="{{ route($routePrefix . 'menus.index') }}" variant="ghost" size="sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </x-ui.button>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <x-ui.card>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Image --}}
                <div>
                    @if($menu->image)
                        <img src="{{ Storage::url($menu->image) }}" alt="{{ $menu->name }}"
                            class="w-full h-80 object-cover rounded-xl shadow-soft">
                    @else
                        <div class="w-full h-80 bg-slate-100 rounded-xl flex items-center justify-center">
                            <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                </div>

                {{-- Details --}}
                <div class="space-y-5">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900">{{ $menu->name }}</h2>
                        <div class="mt-2">
                            <x-ui.badge type="info">{{ $menu->category->name }}</x-ui.badge>
                        </div>
                    </div>

                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-bold text-emerald-600">Rp
                            {{ number_format($menu->price, 0, ',', '.') }}</span>
                    </div>

                    <div class="grid grid-cols-2 gap-4 py-4 border-y border-slate-100">
                        <div>
                            <p class="text-sm text-slate-500">Stok</p>
                            <p class="text-lg font-semibold text-slate-900">{{ $menu->stock }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500">Status</p>
                            <div class="mt-1">
                                @if($menu->is_available)
                                    <x-ui.badge type="success">Tersedia</x-ui.badge>
                                @else
                                    <x-ui.badge type="danger">Tidak Tersedia</x-ui.badge>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($menu->description)
                        <div>
                            <p class="text-sm font-medium text-slate-500 mb-2">Deskripsi</p>
                            <p class="text-slate-700">{{ $menu->description }}</p>
                        </div>
                    @endif

                    @if($isAdmin)
                        <div class="pt-4 border-t border-slate-100">
                            <form action="{{ route('admin.menus.destroy', $menu) }}" method="POST"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu ini?');">
                                @csrf
                                @method('DELETE')
                                <x-ui.button type="submit" variant="danger" class="w-full">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Hapus Menu
                                </x-ui.button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </x-ui.card>
    </div>
</x-app-layout>