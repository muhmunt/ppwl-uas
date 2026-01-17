@php
    $isAdmin = auth()->user()->role === 'admin';
    $routePrefix = $isAdmin ? 'admin.' : '';
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="page-header">
            <div>
                <h1 class="page-title">Manajemen Pesanan</h1>
                <p class="page-subtitle">Kelola semua pesanan pelanggan</p>
            </div>
            <x-ui.button href="{{ route($routePrefix . 'orders.create') }}" variant="primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Buat Pesanan Baru
            </x-ui.button>
        </div>
    </x-slot>

    {{-- Filters --}}
    <x-ui.card class="mb-6">
        <form method="GET" action="{{ route($routePrefix . 'orders.index') }}">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                <x-ui.input type="text" name="search" :value="request('search')" placeholder="Cari nomor pesanan..." />

                <x-ui.select name="status" placeholder="Semua Status">
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing
                    </option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </x-ui.select>

                <x-ui.input type="date" name="date" :value="request('date')" />

                <x-ui.button type="submit" variant="secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Filter
                </x-ui.button>

                @if(request('search') || request('status') || request('date'))
                    <x-ui.button href="{{ route($routePrefix . 'orders.index') }}" variant="ghost">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Reset
                    </x-ui.button>
                @endif
            </div>
        </form>
    </x-ui.card>

    {{-- Orders Table --}}
    <x-ui.card :padding="false">
        <x-ui.table>
            <x-slot name="head">
                <th>No. Pesanan</th>
                <th>Pelanggan</th>
                <th>Meja</th>
                <th>Total</th>
                <th>Status</th>
                @if($isAdmin)
                    <th>Kasir</th>
                @endif
                <th class="text-right">Aksi</th>
            </x-slot>

            @forelse($orders as $order)
                <tr>
                    <td>
                        <span class="font-medium text-slate-900">{{ $order->order_number }}</span>
                    </td>
                    <td>{{ $order->customer_name ?? '-' }}</td>
                    <td>{{ $order->table_number ?? '-' }}</td>
                    <td>
                        <span class="font-semibold text-emerald-600">
                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                        </span>
                    </td>
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
                    @if($isAdmin)
                        <td class="text-slate-600">{{ $order->user->name }}</td>
                    @endif
                    <td>
                        <div class="flex items-center justify-end gap-1">
                            {{-- View --}}
                            <x-ui.button href="{{ route($routePrefix . 'orders.show', $order) }}" variant="ghost" size="sm"
                                title="Lihat">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </x-ui.button>

                            @if($order->status === 'pending')
                                {{-- Edit --}}
                                <x-ui.button href="{{ route($routePrefix . 'orders.edit', $order) }}" variant="ghost" size="sm"
                                    title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </x-ui.button>

                                @if($isAdmin)
                                    {{-- Delete --}}
                                    <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?');">
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
                                @endif
                            @endif

                            {{-- Print --}}
                            <x-ui.button href="{{ route($routePrefix . 'orders.print', $order) }}" variant="ghost" size="sm"
                                target="_blank" title="Print">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                </svg>
                            </x-ui.button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ $isAdmin ? 7 : 6 }}" class="p-0">
                        <x-ui.empty-state icon="cart" title="Tidak ada pesanan"
                            description="Belum ada pesanan yang ditemukan. Buat pesanan baru untuk memulai.">
                            <x-slot name="action">
                                <x-ui.button href="{{ route($routePrefix . 'orders.create') }}" variant="primary" size="sm">
                                    Buat Pesanan Baru
                                </x-ui.button>
                            </x-slot>
                        </x-ui.empty-state>
                    </td>
                </tr>
            @endforelse
        </x-ui.table>

        {{-- Pagination --}}
        @if($orders->hasPages())
            <x-slot name="footer">
                {{ $orders->links() }}
            </x-slot>
        @endif
    </x-ui.card>
</x-app-layout>