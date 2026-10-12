<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StockMovementController extends Controller
{
    
    public function index()
    {
    $movements = StockMovement::with('product')
        ->oldest()
        ->paginate(10);

    return view('stock_movements.index', compact('movements'));
    }


    public function create()
    {
        $products = Product::orderBy('name')->get();

        return view('stock_movements.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'type' => ['required', Rule::in(['IN', 'OUT'])],
            'quantity' => ['required', 'integer', 'min:1'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::transaction(function () use ($validated) {
            $product = Product::whereKey($validated['product_id'])
                ->lockForUpdate()
                ->firstOrFail();

            $quantity = (int) $validated['quantity'];

            if (
                $validated['type'] === 'OUT' &&
                $product->stock < $quantity
            ) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'quantity' => 'Stok tidak mencukupi untuk transaksi keluar.',
                ]);
            }

            if ($validated['type'] === 'IN') {
                $product->increment('stock', $quantity);
            } else {
                $product->decrement('stock', $quantity);
            }

            StockMovement::create([
                'product_id' => $product->id,
                'user_id' => null,
                'type' => $validated['type'],
                'quantity' => $quantity,
                'notes' => $validated['notes'] ?? null,
            ]);
        });

        return redirect()
            ->route('stock-movements.index')
            ->with('success', 'Transaksi stok berhasil disimpan.');
    }
}
