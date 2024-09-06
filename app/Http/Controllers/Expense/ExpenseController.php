<?php

namespace App\Http\Controllers\Expense;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Reserve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ExpenseController extends Controller
{
    public function index()
    {
        $expense = Expense::with(['user','expenser','expensecategory','paymenttype'])->get();
        return response()->json($expense);
    }
    public function store(Request $request)
    {
        $request->validate([
            'expenserName' => 'required',
            'expense_description' => 'required',
            'amount' => 'required|numeric',
            'paymenttype' => 'required',
            'date' => 'required',
            'expensecategory' => 'required',
            'cost_type' => 'required',
            'user_id' => 'required',
            'image' => 'required',
        ]);

        $expense = new Expense();

        $expense->expenser_id = $request->expenserName;
        $expense->expense_desc = $request->expense_description;
        $expense->amount = $request->amount;
        $expense->cost_type = $request->cost_type;
        $expense->payment_type_id = $request->paymenttype;
        $expense->user_id = $request->user_id;
        $expense->date = $request->date;
        $expense->expense_category_id = $request->expensecategory;

        $imageName = '';
        if ($request->image) {
            $position = strpos($request->image, ';');
            $sub = substr($request->image, 0, $position);
            $ext = explode('/', $sub)[1];
            $imageName = rand(1, 1000) . '_' . $request->cost_type . '.' . $ext;
            $image = str_replace('data:image/' . $ext . ';base64,', '', $request->image);
            $image = str_replace(' ', '+', $image);

            $imagePath = public_path('backend/images/expense/' . $imageName);
            if (!File::isDirectory(public_path('backend/images/expense'))) {
                File::makeDirectory(public_path('backend/images/expense'), 0755, true, true);
            }
            File::put($imagePath, base64_decode($image));
            $expense->receipt_img = $imageName;
        }

        $expense->save();

        $expense_id = $expense->expenser_id;
        $reserve = new Reserve();
        $reserve->transaction_type = 'out';
        $reserve->amount = $request->amount;
        $reserve->expenser_id = $expense_id;
        $reserve->user_id = $request->user_id;
        $reserve->payment_type_id = $request->paymenttype;
        $reserve->save();
        return response()->json("expense created successfully");
    }
}
