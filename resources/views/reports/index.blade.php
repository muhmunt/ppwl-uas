<x-app-layout>
    <x-slot name="header">
        <div class="page-header">
            <div>
                <h1 class="page-title">Laporan Penjualan</h1>
                <p class="page-subtitle">Analisis pendapatan dan performa menu</p>
            </div>
        </div>
    </x-slot>

    {{-- Filter Section --}}
    <x-ui.card class="mb-6">
        <x-slot name="header">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                <h3 class="font-semibold text-slate-900">Filter Periode</h3>
            </div>
        </x-slot>

        <form method="GET" action="{{ route('admin.reports.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <x-ui.input type="date" name="start_date" label="Dari Tanggal" :value="$startDate" />
            <x-ui.input type="date" name="end_date" label="Sampai Tanggal" :value="$endDate" />
            <div class="flex items-end">
                <x-ui.button type="submit" variant="primary" class="w-full">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Terapkan Filter
                </x-ui.button>
            </div>
        </form>
    </x-ui.card>

    {{-- Stats Cards (KPIs) --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
        {{-- Total Orders --}}
        <x-ui.card class="relative overflow-hidden">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Pesanan</p>
                    <p class="mt-2 text-3xl font-bold text-slate-900">{{ number_format($stats['total_orders']) }}</p>
                    <p class="mt-1 text-xs text-slate-500">Periode yang dipilih</p>
                </div>
                <div class="p-3 bg-rose-100 rounded-xl">
                    <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
        </x-ui.card>

        {{-- Total Revenue --}}
        <x-ui.card class="relative overflow-hidden">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Pendapatan</p>
                    <p class="mt-2 text-3xl font-bold text-emerald-600">Rp
                        {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
                    <p class="mt-1 text-xs text-slate-500">Pendapatan bersih</p>
                </div>
                <div class="p-3 bg-emerald-100 rounded-xl">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </x-ui.card>

        {{-- Average Order --}}
        <x-ui.card class="relative overflow-hidden">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Rata-rata Pesanan</p>
                    <p class="mt-2 text-3xl font-bold text-sky-600">Rp
                        {{ number_format($stats['average_order'], 0, ',', '.') }}</p>
                    <p class="mt-1 text-xs text-slate-500">Per transaksi</p>
                </div>
                <div class="p-3 bg-sky-100 rounded-xl">
                    <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
            </div>
        </x-ui.card>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Daily Reports Table --}}
        <x-ui.card :padding="false">
            <x-slot name="header">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <h3 class="font-semibold text-slate-900">Laporan Harian</h3>
                    </div>
                </div>
            </x-slot>

            <x-ui.table>
                <x-slot name="head">
                    <th>Tanggal</th>
                    <th>Pesanan</th>
                    <th class="text-right">Pendapatan</th>
                </x-slot>

                @forelse($dailyReports as $report)
                    <tr>
                        <td class="font-medium text-slate-900">{{ $report['date_formatted'] }}</td>
                        <td>
                            <x-ui.badge type="info">{{ $report['orders'] }} pesanan</x-ui.badge>
                        </td>
                        <td class="text-right font-semibold text-emerald-600">
                            Rp {{ number_format($report['revenue'], 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="p-0">
                            <x-ui.empty-state icon="chart" title="Tidak ada data"
                                description="Belum ada data laporan untuk periode ini." />
                        </td>
                    </tr>
                @endforelse
            </x-ui.table>
        </x-ui.card>

        {{-- Menu Sales Table --}}
        <x-ui.card :padding="false">
            <x-slot name="header">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <h3 class="font-semibold text-slate-900">Penjualan Menu</h3>
                    </div>
                </div>
            </x-slot>

            <x-ui.table>
                <x-slot name="head">
                    <th>Menu</th>
                    <th>Terjual</th>
                    <th class="text-right">Pendapatan</th>
                </x-slot>

                @forelse($menuSales as $sale)
                    <tr>
                        <td class="font-medium text-slate-900">{{ $sale->name }}</td>
                        <td>
                            <x-ui.badge type="success">{{ $sale->total_sold }} item</x-ui.badge>
                        </td>
                        <td class="text-right font-semibold text-emerald-600">
                            Rp {{ number_format($sale->total_revenue, 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="p-0">
                            <x-ui.empty-state icon="folder" title="Tidak ada data"
                                description="Belum ada penjualan menu untuk periode ini." />
                        </td>
                    </tr>
                @endforelse
            </x-ui.table>
        </x-ui.card>
    </div>
</x-app-layout>