<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class StockReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Pencarian berdasarkan nama produk atau SKU
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan status stok
        if ($request->status === 'menipis') {
            $query->whereColumn('stock', '<=', 'minimum_stock');
        } elseif ($request->status === 'aman') {
            $query->whereColumn('stock', '>', 'minimum_stock');
        }

        $products = $query
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('stock_reports.index', compact('products'));
    }
}
