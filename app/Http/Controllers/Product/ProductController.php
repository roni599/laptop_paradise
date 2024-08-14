<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::with(['category', 'supplier'])->get();
        return response($product);
    }
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_code' => 'required|string|max:255|unique:products',
            'root' => 'required|string|max:255',
            'buying_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'buying_date' => 'required|date',
            'category_id' => 'required|integer|exists:categories,id',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'product_quantity' => 'required|integer',
            'image' => 'nullable|string',
        ]);

        $product = new Product();
        $product->product_name = $request->product_name;
        $product->product_code = $request->product_code;
        $product->root = $request->root;
        $product->buying_price = $request->buying_price;
        $product->selling_price = $request->selling_price;
        $product->buying_date = $request->buying_date;
        $product->category_id = $request->category_id;
        $product->supplier_id = $request->supplier_id;
        $product->product_quantity = $request->product_quantity;

        $imageName = '';
        if ($request->image) {
            $position = strpos($request->image, ';');
            $sub = substr($request->image, 0, $position);
            $ext = explode('/', $sub)[1];
            $imageName = rand(1, 1000) . '_' . $request->product_name . '.' . $ext;
            $image = str_replace('data:image/' . $ext . ';base64,', '', $request->image);
            $image = str_replace(' ', '+', $image);

            $imagePath = public_path('backend/images/product/' . $imageName);

            // Ensure the directory exists
            if (!File::isDirectory(public_path('backend/images/product'))) {
                File::makeDirectory(public_path('backend/images/product'), 0755, true, true);
            }

            File::put($imagePath, base64_decode($image));
            $product->image = $imageName;
        }
        $product->save();
        return response()->json(['message' => 'product created successfully']);
    }

    public function delete($id)
    {
        $product = Product::find($id);
        $image = $product->image;
        $imagePath = public_path('backend/images/product/' . $image);
        if ($image && file_exists($imagePath)) {
            unlink($imagePath);
            $product->delete();
        } else {
            $product->delete();
        }
    }
    public function update(Request $request)
    {

        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_code' => 'required|string|max:255|unique:products,product_code,' . $request->id,
            'root' => 'required|string|max:255',
            'buying_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'buying_date' => 'required|date',
            'category_id' => 'required|integer|exists:categories,id',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'product_quantity' => 'required|integer',
            'image' => 'nullable|string',
        ]);

        $product = Product::find($request->id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->update($request->only([
            'product_name', 'product_code', 'root', 'buying_price', 'selling_price', 'buying_date', 'category_id', 'supplier_id', 'product_quantity'
        ]));
        if ($request->has('image') && strpos($request->image, 'data:image/') === 0) {
            $imagePath = public_path('backend/images/product/' . $product->image);
            if ($product->image && file_exists($imagePath)) {
                unlink($imagePath);
            }

            $position = strpos($request->image, ';');
            $sub = substr($request->image, 0, $position);
            $ext = explode('/', $sub)[1];
            $imageName = rand(1, 1000) . '_' . $request->name . '.' . $ext;
            $image = str_replace('data:image/' . $ext . ';base64,', '', $request->image);
            $image = str_replace(' ', '+', $image);

            $imagePath = public_path('backend/images/product/' . $imageName);
            if (!File::isDirectory(public_path('backend/images/product'))) {
                File::makeDirectory(public_path('backend/images/product'), 0755, true, true);
            }

            File::put($imagePath, base64_decode($image));
            $product->image = $imageName;
        }

        $product->save();

        return response()->json(['message' => 'Product updated successfully']);
    }
    public function stocks_update(Request $request)
    {
        $request->validate([
            'product_quantity' => 'required|integer',
        ]);

        $product = Product::find($request->id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        $product->product_quantity = $request->product_quantity;
        $product->save();
        return response()->json(['message' => 'Stocks updated successfully']);
    }
}
