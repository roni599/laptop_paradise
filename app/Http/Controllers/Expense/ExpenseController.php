<?php

namespace App\Http\Controllers\Expense;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

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
            'details' => 'required|string',
            'amount' => 'required|numeric'
        ]);

        $expense = new Expense();
        $expense->details = $request->details;
        $expense->amount = $request->amount;
        $expense->save();
        return response()->json(['message' => "Expense Created Successfully"]);
    }

    public function delete($id)
    {
        $expense = Expense::find($id);
        $expense->delete();
        return response()->json(['message' => 'Expense deleted successfully']);
    }

    public function update(Request $request)
    {
        $request->validate([
            'details' => 'required|string',
            'amount' => 'required|numeric'
        ]);

        $expense = Expense::find($request->id);
        if (!$expense) {
            return response()->json(['message' => 'Expense not found'], 404);
        }

        $expense->details = $request->details;
        $expense->amount = $request->amount;

        $expense->save();

        return response()->json(['message' => 'Expense updated successfully']);
    }
}
