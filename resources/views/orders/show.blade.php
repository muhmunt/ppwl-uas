@php
    $isAdmin = auth()->user()->role === 'admin';
    $routePrefix = $isAdmin ? 'admin.' : '';
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="page-header">
            <div>
                <h1 class="page-title">Detail Pesanan</h1>
                <p class="page-subtitle">{{ $order->order_number }}</p>
            </div>
            <div class="flex items-center gap-2">
                <x-ui.button href="{{ route($routePrefix . 'orders.print', $order) }}" variant="ghost" target="_blank">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print
                </x-ui.button>
                @if($order->status === 'pending')
                    <x-ui.button href="{{ route($routePrefix . 'orders.edit', $order) }}" variant="secondary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit
                    </x-ui.button>
                @endif
                <x-ui.button href="{{ route($routePrefix . 'orders.index') }}" variant="ghost">
                    Kembali
                </x-ui.button>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        {{-- Order Info --}}
        <x-ui.card>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-6">
                <div>
                    <p class="text-sm text-slate-500">No. Pesanan</p>
                    <p class="text-lg font-semibold text-slate-900">{{ $order->order_number }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-500">Status</p>
                    <div class="mt-1">
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
                    </div>
                </div>
                <div>
                    <p class="text-sm text-slate-500">Pelanggan</p>
                    <p class="text-lg font-medium text-slate-900">{{ $order->customer_name ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-500">Meja</p>
                    <p class="text-lg font-medium text-slate-900">{{ $order->table_number ?? '-' }}</p>
                </div>
            </div>
        </x-ui.card>

        {{-- Update Status --}}
        <x-ui.card>
            <x-slot name="header">
                <h3 class="font-semibold text-slate-900">Update Status</h3>
            </x-slot>
            <form method="POST" action="{{ route($routePrefix . 'orders.update-status', $order) }}"
                class="flex items-end gap-3">
                @csrf
                <div class="flex-1">
                    <x-ui.select name="status" label="Status Pesanan">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing
                        </option>
                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed
                        </option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled
                        </option>
                    </x-ui.select>
                </div>
                <x-ui.button type="submit" variant="primary">
                    Update Status
                </x-ui.button>
            </form>
        </x-ui.card>

        {{-- Order Items --}}
        <x-ui.card :padding="false">
            <x-slot name="header">
                <h3 class="font-semibold text-slate-900">Item Pesanan</h3>
            </x-slot>

            <x-ui.table>
                <x-slot name="head">
                    <th>Menu</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th class="text-right">Subtotal</th>
                </x-slot>

                @foreach($order->orderItems as $item)
                    <tr>
                        <td class="font-medium text-slate-900">{{ $item->menu->name }}</td>
                        <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td class="text-right font-medium">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr class="bg-slate-50">
                    <td colspan="3" class="text-right font-semibold text-slate-900">Total</td>
                    <td class="text-right font-bold text-lg text-emerald-600">Rp
                        {{ number_format($order->total_price, 0, ',', '.') }}</td>
                </tr>
            </x-ui.table>
        </x-ui.card>

        {{-- Notes --}}
        @if($order->notes)
            <x-ui.card>
                <x-slot name="header">
                    <h3 class="font-semibold text-slate-900">Catatan</h3>
                </x-slot>
                <p class="text-slate-700">{{ $order->notes }}</p>
            </x-ui.card>
        @endif

        {{-- Delete Action (Admin only, pending orders) --}}
        @if($isAdmin && $order->status === 'pending')
            <div class="flex justify-end">
                <form action="{{ route('admin.orders.destroy', $order) }}" method="POST"
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?');">
                    @csrf
                    @method('DELETE')
                    <x-ui.button type="submit" variant="danger">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Hapus Pesanan
                    </x-ui.button>
                </form>
            </div>
        @endif
    </div>
</x-app-layout>