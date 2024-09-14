<?php

namespace App\Http\Controllers\Serial;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Serial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Illuminate\Support\Str;

class SerialController extends Controller
{
    public function index()
    {
        $serials = Serial::with('user')->get();
        // $barcodes = [];

        // $generator = new BarcodeGeneratorPNG();
        // foreach ($serials as $serial) {
        //     $barcodes[] = [
        //         'user' => $serial->user,
        //         'serial' => $serial,
        //         'barcode' => base64_encode($generator->getBarcode($serial->serial_no, $generator::TYPE_CODE_128))
        //     ];
        // }

        return response()->json($serials);
    }
    public function store(Request $request)
    {
        $request->validate([
            'rows.*.serial_no' => 'required',
            'rows.*.color' => 'required',
            'rows.*.image' => 'nullable|string',
            'rows.*.userid' => 'required',
            'rows.*.stocksId' => 'required'
        ]);
        foreach ($request->rows as $rowData) {
            $serial = new Serial();
            $serial->serial_no = $rowData['serial_no'];
            $serial->color = $rowData['color'];
            $serial->stock_id = $rowData['stocksId'];
            $serial->user_id = $rowData['userid'];
            if (!empty($rowData['image'])) {
                $position = strpos($rowData['image'], ';');
                $sub = substr($rowData['image'], 0, $position);
                $ext = explode('/', $sub)[1];
                $imageName = rand(1, 1000) . '_' . $rowData['serial_no'] . '.' . $ext;
                $image = str_replace('data:image/' . $ext . ';base64,', '', $rowData['image']);
                $image = str_replace(' ', '+', $image);
                $imagePath = public_path('backend/images/serial/' . $imageName);
                if (!File::isDirectory(public_path('backend/images/serial'))) {
                    File::makeDirectory(public_path('backend/images/serial'), 0755, true, true);
                }
                File::put($imagePath, base64_decode($image));
                $serial->image = $imageName;
            }
            $serial->save();
        }
        return response()->json($request->rows);
    }
    public function update(Request $request)
    {
        $request->validate([
            'serial_no' => 'required',
            'color' => 'required',
            'status' => 'required',
            'return_status' => 'required',
            'image' => 'nullable|string',
        ]);

        $serial = Serial::findOrFail($request->id);

        if ($request->has('image') && strpos($request->image, 'data:image/') === 0) {
            // Delete old image if it exists
            $oldImagePath = public_path('backend/images/serial/' . $serial->image);
            if ($serial->image && file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }

            // Process the new image
            $position = strpos($request->image, ';');
            $sub = substr($request->image, 0, $position);
            $ext = explode('/', $sub)[1];
            $imageName = rand(1, 1000) . '_' . $request->serial_no . '.' . $ext;
            $image = str_replace('data:image/' . $ext . ';base64,', '', $request->image);
            $image = str_replace(' ', '+', $image);

            // Ensure the directory exists and save the new image
            $imagePath = public_path('backend/images/serial/' . $imageName);
            if (!File::isDirectory(public_path('backend/images/serial'))) {
                File::makeDirectory(public_path('backend/images/serial'), 0755, true, true);
            }

            File::put($imagePath, base64_decode($image));
            $serial->image = $imageName;
        }

        $serial->serial_no = $request->serial_no;
        $serial->color = $request->color;
        $serial->status = $request->status;
        $serial->return_status = $request->return_status;

        $serial->save();
        return response()->json(['message' => 'Serial details updated successfully']);
    }
    public function delete($id)
    {
        $serial = Serial::find($id);
        $image = $serial->image;
        $imagePath = public_path('backend/images/serial/' . $image);
        if ($image && file_exists($imagePath)) {
            unlink($imagePath);
            $serial->delete();
        } else {
            $serial->delete();
        }
    }
    public function getSerialsByStock($stockId)
    {
        $serials = Serial::where('stock_id', $stockId)->get(['serial_no']);
        $generator = new BarcodeGeneratorPNG();
        $serialsWithBarcodes = [];
        foreach ($serials as $serial) {
            $serialsWithBarcodes[] = [
                'serial_no' => $serial->serial_no,
                'barcode' => base64_encode($generator->getBarcode($serial->serial_no, $generator::TYPE_CODE_128))
            ];
        }
        return response()->json($serialsWithBarcodes);
    }


    //testing right
    // public function searchBarcode(Request $request)
    // {
    //     $barcode = $request->input('barcode');
    //     $card=$request->input('card');
    //     $serial = Serial::with(['stock.product', 'user'])
    //         ->where('serial_no', $barcode)
    //         ->first();

    //     $uuid = 'LP' . substr((string) Str::uuid(), 0, 4);
    //     $cart=new Cart();
    //     $cart->cart_id=$uuid;
    //     $cart->save();
    //     return response()->json([
    //         $cart->id,
    //         $serial
    //     ]);
    // }

    // public function searchBarcode(Request $request)
    // {
    //     // Get the barcode from the request
    //     $barcode = $request->input('barcode');
    //     $serial = Serial::with(['stock.product', 'user'])
    //         ->where('serial_no', $barcode)
    //         ->first();
    //     // Retrieve or create a cart
    //     $uuid = 'LP' . substr((string) Str::uuid(), 0, 4);

    //     // Create a new cart
    //     $cart = new Cart();
    //     $cart->cart_id = $uuid;
    //     $cart->save();

    //     // Store the cart ID in the session
    //     $request->session()->put('cart_id', $cart->id);
    //     $cartId = $request->session()->get('cart_id');
    //     return response()->json($cartId);


    //     if (!$cartId) {
    //         // Generate a UUID for the cart
    //         $uuid = 'LP' . substr((string) Str::uuid(), 0, 4);

    //         // Create a new cart
    //         $cart = new Cart();
    //         $cart->cart_id = $uuid;
    //         $cart->save();

    //         // Store the cart ID in the session
    //         $request->session()->put('cart_id', $cart->id);

    //         $cartId = $cart->id;
    //     }

    //     // Find the serial based on the barcode
    //     $serial = Serial::with(['stock.product', 'user'])
    //         ->where('serial_no', $barcode)
    //         ->first();

    //     // Check if the serial and its related data exist
    //     if ($serial && $serial->stock && $serial->stock->product) {
    //         // Create or update the CartItem
    //         $cartItem = CartItem::where('cart_id', $cartId)
    //             ->where('serial_id', $serial->id)
    //             ->first();

    //         if ($cartItem) {
    //             // If the item already exists in the cart, update the quantity
    //             $cartItem->quantity += 1;
    //         } else {
    //             // If the item does not exist in the cart, create a new CartItem
    //             $cartItem = new CartItem();
    //             $cartItem->cart_id = $cartId;
    //             $cartItem->item_no = $serial->stock->product->id;
    //             $cartItem->price = $serial->stock->selling_price;
    //             $cartItem->serial_id = $serial->id;
    //             $cartItem->quantity = 1; // Initialize with quantity 1
    //         }

    //         // Save the CartItem
    //         $cartItem->save();

    //         return response()->json(['message' => 'Item added to cart successfully.']);
    //     } else {
    //         return response()->json(['error' => 'Serial, stock, or product not found for barcode ' . $barcode], 404);
    //     }
    // }

    // public function searchBarcode(Request $request)
    // {
    //     $barcode = $request->input('barcode');

    //     // Find the serial based on the barcode
    //     $serial = Serial::with(['stock.product', 'user'])
    //         ->where('serial_no', $barcode)
    //         ->first();

    //     if (!$serial || !$serial->stock || !$serial->stock->product) {
    //         return response()->json(['error' => 'Serial, stock, or product not found for barcode ' . $barcode], 404);
    //     }

    //     // Retrieve or create a cart
    //     $cartId = $request->session()->get('cart_id');

    //     if (!$cartId) {
    //         $uuid = 'LP' . substr((string) Str::uuid(), 0, 4);

    //         $cart = new Cart();
    //         $cart->cart_id = $uuid;
    //         $cart->save();

    //         $cartId = $cart->id;
    //         $request->session()->put('cart_id', $cartId);
    //     }

    //     // Return the cart ID and the cart item details
    //     return response()->json([
    //         'cart_id' => $cartId,
    //         'serial' => $serial
    //     ]);
    // }



    public function searchBarcode(Request $request)
    {
        $barcode = $request->input('barcode');
        $cartId = $request->input('cart_id');

        // Retrieve serial data based on barcode
        $serial = Serial::with(['stock.product', 'user'])
            ->where('serial_no', $barcode)
            ->first();
        
        // Check if cart_id is provided
        if ($cartId) {
            // Check if the cart_id exists in the Cart table
            $cart = Cart::find($cartId);

            if ($cart) {
                // Cart ID exists, return the existing ID
                $cartItem = new CartItem();
                $cartItem->cart_id = $cart->id;
                $cartItem->serial_id = $serial->id;
                $cartItem->quantity = 1;
                $cartItem->item_no=$serial->stock->product->id;
                $cartItem->price=$serial->stock->product->selling_price;
                $cartItem->save();
                return response()->json([
                    $cart->id,
                    $serial
                ]);
            } else {
                // Cart ID does not exist, create a new cart
                $cart = new Cart();
                $cart->cart_id = $cart; // Optionally set cart_id if needed
                $cart->save();

                $cartItem = new CartItem();
                $cartItem->cart_id = $cart->id;
                $cartItem->serial_id = $serial->id;
                $cartItem->quantity = 1;
                $cartItem->item_no=$serial->stock->product->id;
                $cartItem->price=$serial->stock->product->selling_price;
                $cartItem->save();
                return response()->json([
                    $cart->id,
                    $serial
                ]);
            }
        } else {
            // No cart_id provided, create a new cart
            $cart = new Cart();
            $cart->cart_id = 'LP' . substr((string) Str::uuid(), 0, 4);
            $cart->save();

            $cartItem = new CartItem();
            $cartItem->cart_id = $cart->id;
            $cartItem->serial_id = $serial->id;
            $cartItem->quantity = 1;
            $cartItem->item_no=$serial->stock->product->id;
            $cartItem->price=$serial->stock->selling_price;
            $cartItem->save();
            return response()->json([
                $cart->id,
                $serial
            ]);
        }
    }
}
