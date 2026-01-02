<?php

namespace App\Http\Controllers\Kasir;

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
        $userId = auth()->id();
        
        $stats = [
            'my_orders_today' => Order::where('user_id', $userId)->whereDate('created_at', $today)->count(),
            'my_revenue_today' => Order::where('user_id', $userId)->whereDate('created_at', $today)->where('status', '!=', 'cancelled')->sum('total_price'),
            'active_orders' => Order::where('user_id', $userId)->whereIn('status', ['pending', 'processing'])->count(),
        ];

        // My recent orders
        $myOrders = Order::where('user_id', $userId)->orderBy('created_at', 'desc')->limit(10)->get();

        return view('kasir.dashboard', compact('stats', 'myOrders'));
    }
}
