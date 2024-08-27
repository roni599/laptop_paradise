<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::with(['product'])->get();
        return response()->json($stocks);
    }
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'user_id' => 'required',
            'stock_date' => 'required',
            'stock_quantity' => 'required|integer|min:1',
            'buying_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
        ]);
        $product = Product::where('id', $request->product_id)->first();
        $product->quantity += $request->stock_quantity;
        $product->save();

        $stocks = new Stock();
        $stocks->stock_date = $request->stock_date;
        $stocks->product_id = $request->product_id;
        $stocks->user_id = $request->user_id;
        $stocks->stock_quantity = $request->stock_quantity;
        $stocks->buying_price = $request->buying_price;
        $stocks->selling_price = $request->selling_price;

        $stocks->save();
        return response()->json([
            'message' => 'Stocks created successfully',
            'stock_id' => $stocks->id
        ]);
    }
}
