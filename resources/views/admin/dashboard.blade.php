<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-white fw-bold mb-0">
            <i class="bi bi-speedometer2 me-2"></i>{{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Pesanan Hari Ini -->
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-gradient rounded-3 p-3 me-3">
                            <i class="bi bi-clipboard-check text-white fs-4"></i>
                        </div>
                        <div>
                            <p class="text-muted small mb-1">Pesanan Hari Ini</p>
                            <h3 class="mb-0 fw-bold text-primary">{{ $stats['total_orders_today'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Pendapatan Hari Ini -->
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-gradient rounded-3 p-3 me-3">
                            <i class="bi bi-currency-dollar text-white fs-4"></i>
                        </div>
                        <div>
                            <p class="text-muted small mb-1">Pendapatan Hari Ini</p>
                            <h3 class="mb-0 fw-bold text-success">Rp {{ number_format($stats['total_revenue_today'], 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Pesanan -->
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-info bg-gradient rounded-3 p-3 me-3">
                            <i class="bi bi-receipt-cutoff text-white fs-4"></i>
                        </div>
                        <div>
                            <p class="text-muted small mb-1">Total Pesanan</p>
                            <h3 class="mb-0 fw-bold text-info">{{ $stats['total_orders'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Pendapatan -->
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning bg-gradient rounded-3 p-3 me-3">
                            <i class="bi bi-graph-up-arrow text-white fs-4"></i>
                        </div>
                        <div>
                            <p class="text-muted small mb-1">Total Pendapatan</p>
                            <h3 class="mb-0 fw-bold text-warning">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold text-primary">
                        <i class="bi bi-clock-history me-2"></i>Pesanan Terbaru
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No. Pesanan</th>
                                    <th>Pelanggan</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Kasir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders as $order)
                                    <tr>
                                        <td><strong>{{ $order->order_number }}</strong></td>
                                        <td>{{ $order->customer_name ?? '-' }}</td>
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
                                        <td>{{ $order->user->name }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">Tidak ada pesanan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Menus -->
    <div class="row mb-4">
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold text-info">
                        <i class="bi bi-star-fill me-2"></i>Menu Terlaris
                    </h5>
                </div>
                <div class="card-body">
                    @forelse($topMenus as $menu)
                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span class="fw-medium">{{ $menu->name }}</span>
                            <span class="badge bg-primary">{{ $menu->total_sold }}x terjual</span>
                        </div>
                    @empty
                        <p class="text-muted text-center py-3 mb-0">Belum ada data penjualan</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold text-primary">
                        <i class="bi bi-lightning-fill me-2"></i>Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-sm-6 col-lg-3">
                            <a href="{{ route('admin.orders.create') }}" class="btn btn-primary w-100 d-flex align-items-center justify-content-center">
                                <i class="bi bi-plus-circle me-2"></i>
                                Buat Pesanan Baru
                            </a>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-3">
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-success w-100 d-flex align-items-center justify-content-center">
                                <i class="bi bi-tag me-2"></i>
                                Tambah Kategori
                            </a>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-3">
                            <a href="{{ route('admin.menus.create') }}" class="btn btn-info w-100 d-flex align-items-center justify-content-center">
                                <i class="bi bi-file-plus me-2"></i>
                                Tambah Menu
                            </a>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-3">
                            <a href="{{ route('admin.reports.index') }}" class="btn btn-warning w-100 d-flex align-items-center justify-content-center">
                                <i class="bi bi-file-earmark-bar-graph me-2"></i>
                                Laporan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>