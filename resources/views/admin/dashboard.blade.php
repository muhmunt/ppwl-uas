<x-app-layout>
    <x-slot name="header">
        <div class="page-header">
            <div>
                <h1 class="page-title">Dashboard Admin</h1>
                <p class="page-subtitle">Overview bisnis Anda hari ini</p>
            </div>
            <x-ui.button href="{{ route('admin.reports.index') }}" variant="secondary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                Lihat Laporan
            </x-ui.button>
        </div>
    </x-slot>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        {{-- Today's Orders --}}
        <x-ui.card class="relative overflow-hidden">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Pesanan Hari Ini</p>
                    <p class="mt-2 text-3xl font-bold text-slate-900">{{ $stats['total_orders_today'] }}</p>
                </div>
                <div class="p-3 bg-rose-100 rounded-xl">
                    <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
        </x-ui.card>

        {{-- Today's Revenue --}}
        <x-ui.card class="relative overflow-hidden">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Pendapatan Hari Ini</p>
                    <p class="mt-2 text-3xl font-bold text-emerald-600">Rp
                        {{ number_format($stats['total_revenue_today'], 0, ',', '.') }}</p>
                </div>
                <div class="p-3 bg-emerald-100 rounded-xl">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </x-ui.card>

        {{-- Total Orders --}}
        <x-ui.card class="relative overflow-hidden">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Pesanan</p>
                    <p class="mt-2 text-3xl font-bold text-slate-900">{{ $stats['total_orders'] }}</p>
                </div>
                <div class="p-3 bg-sky-100 rounded-xl">
                    <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
            </div>
        </x-ui.card>

        {{-- Total Revenue --}}
        <x-ui.card class="relative overflow-hidden">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Pendapatan</p>
                    <p class="mt-2 text-3xl font-bold text-amber-600">Rp
                        {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
                </div>
                <div class="p-3 bg-amber-100 rounded-xl">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
            </div>
        </x-ui.card>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        {{-- Recent Orders --}}
        <div class="lg:col-span-2">
            <x-ui.card :padding="false">
                <x-slot name="header">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="font-semibold text-slate-900">Pesanan Terbaru</h3>
                        </div>
                        <a href="{{ route('admin.orders.index') }}"
                            class="text-sm text-rose-600 hover:text-rose-700 font-medium">
                            Lihat semua →
                        </a>
                    </div>
                </x-slot>

                <x-ui.table>
                    <x-slot name="head">
                        <th>No. Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Kasir</th>
                    </x-slot>

                    @forelse($recentOrders as $order)
                        <tr>
                            <td class="font-semibold text-slate-900">{{ $order->order_number }}</td>
                            <td>{{ $order->customer_name ?? '-' }}</td>
                            <td class="font-semibold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            <td>
                                @php
                                    $statusType = match ($order->status) {
                                        'pending' => 'warning',
                                        'processing' => 'info',
                                        'completed' => 'success',
                                        'cancelled' => 'danger',
                                        default => 'neutral',
                                    };
                                @endphp
                                <x-ui.badge :type="$statusType">
                                    {{ ucfirst($order->status) }}
                                </x-ui.badge>
                            </td>
                            <td class="text-slate-600">{{ $order->user->name }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-0">
                                <x-ui.empty-state icon="cart" title="Belum ada pesanan"
                                    description="Pesanan terbaru akan muncul di sini." />
                            </td>
                        </tr>
                    @endforelse
                </x-ui.table>
            </x-ui.card>
        </div>

        {{-- Top Menus --}}
        <div class="lg:col-span-1">
            <x-ui.card>
                <x-slot name="header">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                        </svg>
                        <h3 class="font-semibold text-slate-900">Menu Terlaris</h3>
                    </div>
                </x-slot>

                <div class="space-y-3">
                    @forelse($topMenus as $index => $menu)
                        <div
                            class="flex items-center justify-between py-2 {{ !$loop->last ? 'border-b border-slate-100' : '' }}">
                            <div class="flex items-center gap-3">
                                <span
                                    class="flex h-6 w-6 items-center justify-center rounded-full {{ $index === 0 ? 'bg-amber-100 text-amber-700' : 'bg-slate-100 text-slate-600' }} text-xs font-semibold">
                                    {{ $index + 1 }}
                                </span>
                                <span class="font-medium text-slate-900">{{ $menu->name }}</span>
                            </div>
                            <x-ui.badge type="info">{{ $menu->total_sold }}x</x-ui.badge>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <svg class="w-10 h-10 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <p class="text-sm text-slate-500">Belum ada data penjualan</p>
                        </div>
                    @endforelse
                </div>
            </x-ui.card>
        </div>
    </div>

    {{-- Quick Actions --}}
    <x-ui.card>
        <x-slot name="header">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                <h3 class="font-semibold text-slate-900">Aksi Cepat</h3>
            </div>
        </x-slot>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <a href="{{ route('admin.orders.create') }}"
                class="flex flex-col items-center justify-center p-6 rounded-xl border-2 border-dashed border-slate-200 hover:border-rose-300 hover:bg-rose-50/50 transition-all group">
                <div class="p-3 bg-rose-100 rounded-xl group-hover:bg-rose-200 transition-colors">
                    <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <span class="mt-3 text-sm font-medium text-slate-700 group-hover:text-rose-700">Buat Pesanan</span>
            </a>

            <a href="{{ route('admin.menus.create') }}"
                class="flex flex-col items-center justify-center p-6 rounded-xl border-2 border-dashed border-slate-200 hover:border-sky-300 hover:bg-sky-50/50 transition-all group">
                <div class="p-3 bg-sky-100 rounded-xl group-hover:bg-sky-200 transition-colors">
                    <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <span class="mt-3 text-sm font-medium text-slate-700 group-hover:text-sky-700">Tambah Menu</span>
            </a>

            <a href="{{ route('admin.categories.create') }}"
                class="flex flex-col items-center justify-center p-6 rounded-xl border-2 border-dashed border-slate-200 hover:border-emerald-300 hover:bg-emerald-50/50 transition-all group">
                <div class="p-3 bg-emerald-100 rounded-xl group-hover:bg-emerald-200 transition-colors">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                </div>
                <span class="mt-3 text-sm font-medium text-slate-700 group-hover:text-emerald-700">Tambah
                    Kategori</span>
            </a>

            <a href="{{ route('admin.reports.index') }}"
                class="flex flex-col items-center justify-center p-6 rounded-xl border-2 border-dashed border-slate-200 hover:border-amber-300 hover:bg-amber-50/50 transition-all group">
                <div class="p-3 bg-amber-100 rounded-xl group-hover:bg-amber-200 transition-colors">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <span class="mt-3 text-sm font-medium text-slate-700 group-hover:text-amber-700">Lihat Laporan</span>
            </a>
        </div>
    </x-ui.card>
</x-app-layout>