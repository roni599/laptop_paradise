<?php

namespace App\Http\Controllers\Serial;

use App\Http\Controllers\Controller;
use App\Models\Serial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SerialController extends Controller
{
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

            // Assign the validated data to the Serial model
            $serial->serial_no = $rowData['serial_no'];
            $serial->color = $rowData['color'];
            $serial->stock_id = $rowData['stocksId'];
            $serial->user_id = $rowData['userid'];

            // Handle image upload if provided
            if (!empty($rowData['image'])) {
                $position = strpos($rowData['image'], ';');
                $sub = substr($rowData['image'], 0, $position);
                $ext = explode('/', $sub)[1];
                $imageName = rand(1, 1000) . '_' . $rowData['serial_no'] . '.' . $ext;
                $image = str_replace('data:image/' . $ext . ';base64,', '', $rowData['image']);
                $image = str_replace(' ', '+', $image);

                $imagePath = public_path('backend/images/serial/' . $imageName);

                // Ensure the directory exists
                if (!File::isDirectory(public_path('backend/images/serial'))) {
                    File::makeDirectory(public_path('backend/images/serial'), 0755, true, true);
                }

                // Save the decoded image to the specified path
                File::put($imagePath, base64_decode($image));

                // Assign the image name to the model
                $serial->image = $imageName;
            }

            
            // Save the Serial model to the database
            $serial->save();
        }

        // Return a response after successful creation
        return response()->json($request->rows);
 
    }
}
