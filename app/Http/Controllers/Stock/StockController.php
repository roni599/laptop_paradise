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
        $stocks = Stock::with(['product', 'user'])->get();
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
    public function update(Request $request)
    {
        $request->validate([
            'product_model' => 'required|string|max:255',
            'user_id' => 'required',
            'stock_quantity' => 'required|integer|min:1',
            'selling_price' => 'required|numeric|min:0',
            'buying_price' => 'required|numeric|min:0',
            'status' => 'required',
            'stock_date' => 'required',
        ]);
        $product = Product::where('id', $request->product_id)->first();
        $stock = Stock::where('id', $request->id)->first();

        if (!$product || !$stock) {
            return response()->json(['message' => 'Product or Stock not found!'], 404);
        }
        if ($stock->stock_quantity != $request->stock_quantity) {
            if ($stock->stock_quantity > $request->stock_quantity) {
                $product->quantity -= ($stock->stock_quantity - $request->stock_quantity);
            } else {
                $product->quantity += ($request->stock_quantity - $stock->stock_quantity);
            }
            $stock->stock_quantity = $request->stock_quantity;
        }
        $stock->buying_price = $request->buying_price;
        $stock->selling_price = $request->selling_price;
        $stock->status = $request->status;
        $stock->stock_date = $request->stock_date;
        $product->save();
        $stock->save();
        return response()->json(['message' => 'Stock data updated successfully!'], 200);
    }
    public function delete($id)
    {
        $stock = Stock::find($id);
        if (!$stock) {
            return response()->json(['message' => 'Stock not found!'], 404);
        }
        $product = Product::find($stock->product_id);
        if (!$product) {
            return response()->json(['message' => 'Product not found!'], 404);
        }
        $product->quantity -= $stock->stock_quantity;
        $product->save();
        $stock->delete();
        return response()->json(['message' => 'Stock deleted and product quantity updated successfully!', 'product' => $product], 200);
    }
}
