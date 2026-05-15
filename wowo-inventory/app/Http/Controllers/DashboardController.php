<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products' => Product::count(),
            'active_products'=> Product::active()->count(),
            'low_stock'      => Product::whereColumn('stock', '<=', 'min_stock')->count(),
            'total_value'    => Product::sum(DB::raw('stock * cost_price')),
        ];

        $lowStockProducts = Product::whereColumn('stock', '<=', 'min_stock')
            ->active()
            ->orderBy('stock')
            ->take(5)
            ->get();

        $recentProducts = Product::latest()->take(5)->get();

        $categoryStats = Product::selectRaw('category, COUNT(*) as count, SUM(stock) as total_stock')
            ->groupBy('category')
            ->orderByDesc('count')
            ->take(6)
            ->get();

        return view('dashboard', compact('stats', 'lowStockProducts', 'recentProducts', 'categoryStats'));
    }
}
