<x-kasir-layout>
    <x-slot name="header">
        <h2 class="text-white fw-bold mb-0">
            <i class="bi bi-speedometer2 me-2"></i>{{ __('Dashboard Kasir') }}
        </h2>
    </x-slot>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <!-- Pesanan Saya Hari Ini -->
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-gradient rounded-3 p-3 me-3">
                            <i class="bi bi-clipboard-check text-white fs-4"></i>
                        </div>
                        <div>
                            <p class="text-muted small mb-1">Pesanan Saya Hari Ini</p>
                            <h3 class="mb-0 fw-bold text-success">{{ $stats['my_orders_today'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pendapatan Saya Hari Ini -->
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-gradient rounded-3 p-3 me-3">
                            <i class="bi bi-currency-dollar text-white fs-4"></i>
                        </div>
                        <div>
                            <p class="text-muted small mb-1">Pendapatan Saya Hari Ini</p>
                            <h3 class="mb-0 fw-bold text-primary">Rp {{ number_format($stats['my_revenue_today'], 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pesanan Aktif -->
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning bg-gradient rounded-3 p-3 me-3">
                            <i class="bi bi-hourglass-split text-white fs-4"></i>
                        </div>
                        <div>
                            <p class="text-muted small mb-1">Pesanan Aktif</p>
                            <h3 class="mb-0 fw-bold text-warning">{{ $stats['active_orders'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- My Recent Orders -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold text-success">
                        <i class="bi bi-receipt me-2"></i>Pesanan Saya
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No. Pesanan</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($myOrders as $order)
                                    <tr>
                                        <td><strong>{{ $order->order_number }}</strong></td>
                                        <td class="fw-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                        <td>
                                            @php
                                                $statusClasses = [
                                                    'completed' => 'bg-success',
                                                    'pending' => 'bg-warning',
                                                    'processing' => 'bg-info',
                                                    'cancelled' => 'bg-danger',
                                                ];
                                                $statusClass = $statusClasses[$order->status] ?? 'bg-secondary';
                                            @endphp
                                            <span class="badge {{ $statusClass }}">{{ ucfirst($order->status) }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye me-1"></i>Lihat
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">Belum ada pesanan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Action -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold text-primary">
                        <i class="bi bi-lightning-fill me-2"></i>Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('orders.create') }}" class="btn btn-primary btn-lg d-inline-flex align-items-center">
                        <i class="bi bi-plus-circle me-2"></i>
                        Buat Pesanan Baru
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-kasir-layout>