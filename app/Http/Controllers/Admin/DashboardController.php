<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        
        $stats = [
            'total_orders_today' => Order::whereDate('created_at', $today)->count(),
            'total_revenue_today' => Order::whereDate('created_at', $today)->where('status', '!=', 'cancelled')->sum('total_price'),
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('status', '!=', 'cancelled')->sum('total_price'),
        ];

        // Recent orders
        $recentOrders = Order::with('user')->orderBy('created_at', 'desc')->limit(10)->get();

        // Sales chart data (last 7 days)
        $salesData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $salesData[] = [
                'date' => $date->format('d/m'),
                'revenue' => Order::whereDate('created_at', $date)->where('status', '!=', 'cancelled')->sum('total_price'),
                'orders' => Order::whereDate('created_at', $date)->count(),
            ];
        }

        // Top selling menus
        $topMenus = \DB::table('order_items')
            ->join('menus', 'order_items.menu_id', '=', 'menus.id')
            ->select('menus.name', \DB::raw('SUM(order_items.quantity) as total_sold'))
            ->groupBy('menus.id', 'menus.name')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'salesData', 'topMenus'));
    }
}
