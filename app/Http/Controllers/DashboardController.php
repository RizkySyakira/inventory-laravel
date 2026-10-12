<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();

        $totalStock = Product::sum('stock');

        $lowStockProducts = Product::with('category')
            ->whereColumn('stock', '<=', 'minimum_stock')
            ->orderBy('stock')
            ->get();

        $totalMovements = StockMovement::count();

        $recentMovements = StockMovement::with('product')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalProducts',
            'totalStock',
            'lowStockProducts',
            'totalMovements',
            'recentMovements'
        ));
    }
}
