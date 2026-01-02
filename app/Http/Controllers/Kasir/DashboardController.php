<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Stats akan diupdate setelah model Order dibuat
        $stats = [
            'my_orders_today' => 0,
            'my_revenue_today' => 0,
            'active_orders' => 0,
        ];

        return view('kasir.dashboard', compact('stats'));
    }
}
