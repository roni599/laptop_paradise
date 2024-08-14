<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::all();
        return response()->json($category);
    }

    public function store(Request $request)
    {

        $request->validate([
            'categoryName' => 'required|string|max:255|unique:categories,category_name',
        ]);
        $category = new Category();
        $category->category_name = $request->categoryName;
        $category->save();

        return response()->json(['message' => 'Category created successfully']);
    }

    public function delete($id)
    {
        $employee = Category::find($id);
        $employee->delete();
        return response()->json(['message' => 'Category delete successfully']);
    }

    public function update(Request $request)
    {
        $request->validate([
            'categoryName' => 'required|string|max:255|unique:categories,category_name,' . $request->id,
        ]);

        $category = Category::find($request->id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $category->category_name = $request->categoryName;

        $category->save();

        return response()->json(['message' => 'Category updated successfully']);
    }
}
