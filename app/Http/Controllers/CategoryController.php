<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /////      Eloquent ORM      /////

    public function allCategory()
    {
        $categories = Category::latest()->paginate(5);
        return view('admin.category.index', compact('categories'));
    }

    /////      Query Builder    /////

    // public function allCategory()
    // {
    //     $categories = DB::table('categories')->join('users', 'categories.user_id', 'users.id')->select('categories.*', 'users.name')->latest()->paginate(5);
    //     // $categories = DB::table('categories')->latest()->paginate(5);
    //     return view('admin.category.index', compact('categories'));
    // }

    public function addCategory(Request $request)
    {
        $validatedData = $request->validate(
            [
                'category_name' => 'required|unique:categories|max:255'
            ],
            [
                'category_name.required' => 'Please Input a Valid Category Name...!',
                'category_name.max' => 'Category Name Should Be Less Then 255...!',
                'category_name.unique' => 'Category Name Should Be Unique...!'
            ]

        );
        /////       First Approach with Eloquent ORM       /////

        // Category::insert([
        //     'category_name' => $request->category_name,
        //     'user_id' => Auth::user()->id,
        //     'created_at' => Carbon::now(),
        // ]);

        /////        Best Practice Eloquent ORM          /////

        $category = new Category;
        $category->category_name = $request->category_name;
        $category->user_id = Auth::user()->id;
        $category->save();

        /////        Query Builder Approach         /////

        // $data = array();
        // $data['category_name'] = $request->category_name;
        // $data['user_id'] = Auth::user()->id;
        // DB::table('categories')->insert($data);

        return Redirect()->back()->with('success', 'Category Inserted Successfully');
    }
}
