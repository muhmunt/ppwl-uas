<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-white fw-bold mb-0">
            <i class="bi bi-graph-up me-2"></i>{{ __('Laporan Penjualan') }}
        </h2>
    </x-slot>

    <!-- Filter -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="mb-0 fw-bold">
                <i class="bi bi-funnel me-2"></i>Filter Laporan
            </h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.reports.index') }}" class="row g-3">
                <div class="col-12 col-md-4">
                    <label class="form-label fw-bold">Dari Tanggal</label>
                    <input type="date" name="start_date" value="{{ $startDate }}" class="form-control">
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label fw-bold">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ $endDate }}" class="form-control">
                </div>
                <div class="col-12 col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-2"></i>Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-gradient rounded-3 p-3 me-3">
                            <i class="bi bi-receipt-cutoff text-white fs-4"></i>
                        </div>
                        <div>
                            <p class="text-muted small mb-1">Total Pesanan</p>
                            <h3 class="mb-0 fw-bold text-primary">{{ $stats['total_orders'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-gradient rounded-3 p-3 me-3">
                            <i class="bi bi-currency-dollar text-white fs-4"></i>
                        </div>
                        <div>
                            <p class="text-muted small mb-1">Total Pendapatan</p>
                            <h3 class="mb-0 fw-bold text-success">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-info bg-gradient rounded-3 p-3 me-3">
                            <i class="bi bi-bar-chart text-white fs-4"></i>
                        </div>
                        <div>
                            <p class="text-muted small mb-1">Rata-rata Pesanan</p>
                            <h3 class="mb-0 fw-bold text-info">Rp {{ number_format($stats['average_order'], 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Daily Reports -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="mb-0 fw-bold text-primary">
                <i class="bi bi-calendar-check me-2"></i>Laporan Harian
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Jumlah Pesanan</th>
                            <th>Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dailyReports as $report)
                            <tr>
                                <td><strong>{{ $report['date_formatted'] }}</strong></td>
                                <td>
                                    <span class="badge bg-primary">{{ $report['orders'] }} pesanan</span>
                                </td>
                                <td class="fw-bold text-success">Rp {{ number_format($report['revenue'], 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Menu Sales -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="mb-0 fw-bold text-info">
                <i class="bi bi-menu-button-wide me-2"></i>Penjualan Menu
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Menu</th>
                            <th>Terjual</th>
                            <th>Total Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($menuSales as $sale)
                            <tr>
                                <td><strong>{{ $sale->name }}</strong></td>
                                <td>
                                    <span class="badge bg-success">{{ $sale->total_sold }} item</span>
                                </td>
                                <td class="fw-bold text-success">Rp {{ number_format($sale->total_revenue, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    Tidak ada data penjualan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>