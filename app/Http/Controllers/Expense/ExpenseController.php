<?php

namespace App\Http\Controllers\Expense;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expense = Expense::all();
        return response()->json($expense);
    }
    public function store(Request $request)
    {
        $request->validate([
            'expenser_name' => 'required',
            'expense_description' => 'required',
            'amount' => 'required|numeric',
            'paymenttype' => 'required',
            'date' => 'required|date',
            'expensecategory' => 'required',
            'cost_type' => 'required',
            'user_id' => 'required',
            'image' => 'required',
        ]);

        $expense=new Expense();

        $expense->expenser_name=$request->expenser_name;
        $expense->expense_desc=$request->expense_description;
        $expense->amount=$request->amouunt;
        $expense->cost_type=$request->cost_type;
        $expense->payment_type_id=$request->paymenttype;
        $expense->user_id=$request->user_id;
        $expense->date=$request->date;
        $expense->expense_category_id=$request->expensecategory;
        
        return response()->json($request->all());
    }
}
