<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\Extra;
use App\Models\Pos;
use App\Models\Product;
use GuzzleHttp\Psr7\Request;

class PosController extends Controller
{
    public function addProduct($id)
    {
        $product = Product::findOrFail($id);
        $pos = Pos::where('pro_id', $id)->first();
        if ($pos) {
            $pos->increment('pro_quantity', 1);
            $totalPrice = $pos->pro_quantity * $pos->pro_price;
            $pos->sub_total = $totalPrice;
            $pos->save();
        } else {
            $pos = POS::create([
                'pro_id' => $product->id,
                'pro_name' => $product->product_name,
                'pro_quantity' => 1,
                'pro_price' => $product->selling_price,
                'sub_total' => $product->selling_price,
            ]);
        }
        return response()->json(['message' => 'product Added successfully']);
    }
    public function allPos()
    {
        $pos = Pos::all();
        return response()->json($pos);
    }

    public function posremove($id)
    {
        $pos = Pos::findOrFail($id);
        $pos->delete();
        return response()->json(['message' => 'Pos removed successfully']);
    }
    public function posincrement($id)
    {
        $pos = Pos::findOrFail($id);
        $pos->increment('pro_quantity', 1);
        $totalPrice = $pos->pro_quantity * $pos->pro_price;
        $pos->sub_total = $totalPrice;
        $pos->save();
        return response()->json(['message' => 'Pos increment successfully']);
    }
    public function posdecrement($id)
    {
        $pos = Pos::findOrFail($id);
        $pos->decrement('pro_quantity', 1);
        $totalPrice = $pos->pro_quantity * $pos->pro_price;
        $pos->sub_total = $totalPrice;
        $pos->save();
        return response()->json(['message' => 'Pos dcrement successfully']);
    }
    public function orderDoneCustomer(Request $request){
        return response()->json($request);
    }
}
