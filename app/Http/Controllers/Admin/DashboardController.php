<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Stats akan diupdate setelah model Order dan Menu dibuat
        $stats = [
            'total_orders_today' => 0,
            'total_revenue_today' => 0,
            'total_orders' => 0,
            'total_revenue' => 0,
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
