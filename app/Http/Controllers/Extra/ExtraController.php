<?php

namespace App\Http\Controllers\Extra;

use App\Http\Controllers\Controller;
use App\Models\Extra;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Pos;
use App\Models\Product;
use Illuminate\Http\Request;

class ExtraController extends Controller
{
    public function index()
    {
        $vats = Extra::first();
        return response()->json($vats);
    }
    public function orderDoneCustomer(Request $request)
    {
        $validatedData = $request->validate([
            'customer_id' => 'required',
            'qty' => 'required',
            'subtotal' => 'required',
            'vat' => 'required',
            'total' => 'required',
            'pay' => 'required',
            'due' => 'required',
            'payby' => 'required',
        ]);
        $order = Order::create([
            'customer_id' => $request->customer_id,
            'qty' => $request->qty,
            'subtotal' => $request->subtotal,
            'vat' => $request->vat,
            'total' => $request->total,
            'pay' => $request->pay,
            'due' => $request->due,
            'payby' => $request->payby,
            'order_date' => Date('d/m/Y'),
            'order_month' => Date('F'),
            'order_year' => Date('Y')
        ]);
        $pos_contents = Pos::all();
        foreach ($pos_contents as $pos_content) {
            OrderDetail::create([
                'order_id'=>$order->id,
                'product_id'=>$pos_content->pro_id,
                'pro_quantity'=>$pos_content->pro_quantity,
                'pro_price'=>$pos_content->pro_price,
                'sub_total'=>$pos_content->sub_total
            ]);
            $productMinimize = Product::find($pos_content->pro_id);
            $productMinimize->update([
                'product_quantity' => $productMinimize->product_quantity - $pos_content->pro_quantity
            ]);
        }
        Pos::query()->delete();
        return response()->json($order->id);
    }
}
