<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get total sales (default to 0 if no sales)
        $totalSales = Order::where('status', 'completed')
            ->sum('amount') ?? 0;

        // Get the currency from the first completed order, default to USD
        $currency = Order::where('status', 'completed')
            ->value('currency') ?? 'USD';

        // Get total orders (default to 0 if no orders)
        $totalOrders = Order::where('status', 'completed')
            ->count() ?? 0;

        // Get total products (default to 0 if no products)
        $totalProducts = Product::count() ?? 0;

        // Get recent orders (empty collection if no orders)
        $recentOrders = Order::with('product')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get top selling products (empty collection if no products)
        $topProducts = Product::withCount(['orders' => function($query) {
                $query->where('status', 'completed');
            }])
            ->orderBy('orders_count', 'desc')
            ->take(5)
            ->get();

        // Get sales over time (last 7 days)
        $salesOverTime = Order::where('status', 'completed')
            ->where('created_at', '>=', now()->subDays(7))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(amount) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // If no sales data, create empty dataset for the last 7 days
        if ($salesOverTime->isEmpty()) {
            $salesOverTime = collect(range(0, 6))->map(function($days) {
                $date = now()->subDays($days)->format('Y-m-d');
                return [
                    'date' => $date,
                    'total' => 0
                ];
            })->reverse();
        }

        return view('dashboard', compact(
            'totalSales',
            'totalOrders',
            'totalProducts',
            'recentOrders',
            'topProducts',
            'salesOverTime',
            'currency'
        ));
    }
}
