<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SupplierController extends Controller
{
    public function index()
    {
        $supplier = Supplier::all();
        return response()->json($supplier);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:suppliers,email',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'shopname' => 'required|string|max:255',
            'image' => 'nullable|string',
        ]);

        $supplier = new Supplier();

        $supplier->name = $request->name;
        $supplier->email = $request->email;
        $supplier->address = $request->address;
        $supplier->phone = $request->phone;
        $supplier->shopname = $request->shopname;

        $imageName = '';
        if ($request->image) {
            $position = strpos($request->image, ';');
            $sub = substr($request->image, 0, $position);
            $ext = explode('/', $sub)[1];
            $imageName = rand(1, 1000) . '_' . $request->name . '.' . $ext;
            $image = str_replace('data:image/' . $ext . ';base64,', '', $request->image);
            $image = str_replace(' ', '+', $image);

            $imagePath = public_path('backend/images/supplier/' . $imageName);

            // Ensure the directory exists
            if (!File::isDirectory(public_path('backend/images/supplier'))) {
                File::makeDirectory(public_path('backend/images/supplier'), 0755, true, true);
            }

            File::put($imagePath, base64_decode($image));
            $supplier->image = $imageName;
        }

        $supplier->save();

        return response()->json(['message' => 'Supplier created successfully']);
    }

    public function delete($id)
    {
        $supplier = Supplier::find($id);
        $image = $supplier->image;
        $imagePath = public_path('backend/images/supplier/' . $image);
        if ($image && file_exists($imagePath)) {
            unlink($imagePath);
            $supplier->delete();
        } else {
            $supplier->delete();
        }
    }

    public function update(Request $request)
    {
       
        $request->validate([
            'id' => 'required|exists:suppliers,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $request->id,
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'shopname' => 'required|string|max:255',
            'image' => 'nullable|string',
        ]);
        $supplier = Supplier::find($request->id);
        if (!$supplier) {
            return response()->json(['message' => 'Suppler not found'], 404);
        }

        $supplier->update($request->only('name', 'email', 'address', 'phone', 'shopname'));

        if ($request->has('image') && strpos($request->image, 'data:image/') === 0) {
            $imagePath = public_path('backend/images/supplier/' . $supplier->image);
            if ($supplier->image && file_exists($imagePath)) {
                unlink($imagePath);
            }

            $position = strpos($request->image, ';');
            $sub = substr($request->image, 0, $position);
            $ext = explode('/', $sub)[1];
            $imageName = rand(1, 1000) . '_' . $request->name . '.' . $ext;
            $image = str_replace('data:image/' . $ext . ';base64,', '', $request->image);
            $image = str_replace(' ', '+', $image);

            $imagePath = public_path('backend/images/supplier/' . $imageName);
            if (!File::isDirectory(public_path('backend/images/supplier'))) {
                File::makeDirectory(public_path('backend/images/supplier'), 0755, true, true);
            }

            File::put($imagePath, base64_decode($image));
            $supplier->image = $imageName;
        }

        $supplier->save();

        return response()->json(['message' => 'Supplier updated successfully']);
    }


}
