<?php

namespace App\Http\Controllers\Serial;

use App\Http\Controllers\Controller;
use App\Models\Serial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SerialController extends Controller
{
    public function index()
    {
        $stocks = Serial::with('user')->get();
        return response()->json($stocks);
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
}
