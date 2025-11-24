<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardStatisticsController extends Controller
{
    public function index()
    {
        $productStats = DB::table('product_statistics_view')->first();
        $customerStats = DB::table('customer_statistics_view')->first();
        $orderStats = DB::table('order_statistics_view')->first();

        return response()->json([
            'products' => $productStats,
            'customers' => $customerStats,
            'orders'    => $orderStats,
        ]);
    }
}
