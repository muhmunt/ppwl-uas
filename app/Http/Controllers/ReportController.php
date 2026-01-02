<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->start_date ?? Carbon::today()->startOfMonth()->format('Y-m-d');
        $endDate = $request->end_date ?? Carbon::today()->format('Y-m-d');

        $orders = Order::with(['user', 'orderItems.menu'])
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where('status', '!=', 'cancelled')
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'total_orders' => $orders->count(),
            'total_revenue' => $orders->sum('total_price'),
            'average_order' => $orders->count() > 0 ? $orders->sum('total_price') / $orders->count() : 0,
        ];

        // Daily report
        $dailyReports = [];
        $current = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        
        while ($current <= $end) {
            $dayOrders = Order::whereDate('created_at', $current)
                ->where('status', '!=', 'cancelled')
                ->get();
            
            $dailyReports[] = [
                'date' => $current->format('Y-m-d'),
                'date_formatted' => $current->format('d/m/Y'),
                'orders' => $dayOrders->count(),
                'revenue' => $dayOrders->sum('total_price'),
            ];
            
            $current->addDay();
        }

        // Menu sales
        $menuSales = DB::table('order_items')
            ->join('menus', 'order_items.menu_id', '=', 'menus.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereBetween('orders.created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where('orders.status', '!=', 'cancelled')
            ->select('menus.name', DB::raw('SUM(order_items.quantity) as total_sold'), DB::raw('SUM(order_items.subtotal) as total_revenue'))
            ->groupBy('menus.id', 'menus.name')
            ->orderBy('total_sold', 'desc')
            ->get();

        return view('reports.index', compact('stats', 'dailyReports', 'menuSales', 'startDate', 'endDate'));
    }
}