<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function allCategory()
    {
        return view('admin.category.index');
    }

    public function addCategory(Request $request)
    {
        $validatedData = $request->validate([
            'category_name' => 'required|unique:categories|max:255'
        ]);
    }
}
