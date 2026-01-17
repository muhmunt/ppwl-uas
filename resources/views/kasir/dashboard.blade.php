<x-app-layout>
    <x-slot name="header">
        <div class="page-header">
            <div>
                <h1 class="page-title">Dashboard Kasir</h1>
                <p class="page-subtitle">Selamat datang, {{ Auth::user()->name }}</p>
            </div>
            <x-ui.button href="{{ route('orders.create') }}" variant="primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Buat Pesanan
            </x-ui.button>
        </div>
    </x-slot>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
        {{-- My Orders Today --}}
        <x-ui.card class="relative overflow-hidden">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Pesanan Saya Hari Ini</p>
                    <p class="mt-2 text-3xl font-bold text-slate-900">{{ $stats['my_orders_today'] }}</p>
                    <p class="mt-1 text-xs text-slate-500">Transaksi yang Anda buat</p>
                </div>
                <div class="p-3 bg-emerald-100 rounded-xl">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
            </div>
        </x-ui.card>

        {{-- My Revenue Today --}}
        <x-ui.card class="relative overflow-hidden">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Pendapatan Saya</p>
                    <p class="mt-2 text-3xl font-bold text-emerald-600">Rp
                        {{ number_format($stats['my_revenue_today'], 0, ',', '.') }}</p>
                    <p class="mt-1 text-xs text-slate-500">Dari pesanan hari ini</p>
                </div>
                <div class="p-3 bg-rose-100 rounded-xl">
                    <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </x-ui.card>

        {{-- Active Orders --}}
        <x-ui.card class="relative overflow-hidden">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Pesanan Aktif</p>
                    <p class="mt-2 text-3xl font-bold text-amber-600">{{ $stats['active_orders'] }}</p>
                    <p class="mt-1 text-xs text-slate-500">Menunggu diselesaikan</p>
                </div>
                <div class="p-3 bg-amber-100 rounded-xl">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('orders.index', ['status' => 'pending']) }}"
                    class="text-sm text-rose-600 hover:text-rose-700 font-medium">
                    Lihat pesanan aktif →
                </a>
            </div>
        </x-ui.card>
    </div>

    {{-- My Recent Orders --}}
    <x-ui.card :padding="false">
        <x-slot name="header">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <h3 class="font-semibold text-slate-900">Pesanan Saya</h3>
                </div>
                <a href="{{ route('orders.index') }}" class="text-sm text-rose-600 hover:text-rose-700 font-medium">
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
                <th class="text-right">Aksi</th>
            </x-slot>

            @forelse($myOrders as $order)
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
                    <td class="text-right">
                        <x-ui.button href="{{ route('orders.show', $order) }}" variant="ghost" size="sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Lihat
                        </x-ui.button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-0">
                        <x-ui.empty-state icon="cart" title="Belum ada pesanan"
                            description="Pesanan yang Anda buat akan muncul di sini.">
                            <x-slot name="action">
                                <x-ui.button href="{{ route('orders.create') }}" variant="primary">
                                    Buat Pesanan Pertama
                                </x-ui.button>
                            </x-slot>
                        </x-ui.empty-state>
                    </td>
                </tr>
            @endforelse
        </x-ui.table>
    </x-ui.card>
</x-app-layout>