<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /////      Auth Middleware     /////

    public function __construct()
    {
        $this->middleware('auth');
    }
    /////      Eloquent ORM SHOW Data      /////

    public function allCategory()
    {
        $categories = Category::latest()->paginate(5);
        $trashCat = Category::onlyTrashed()->latest()->paginate(3);
        return view('admin.category.index', compact('categories', 'trashCat'));
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
        /////       First Approach with Eloquent ORM INSERT       /////

        // Category::insert([
        //     'category_name' => $request->category_name,
        //     'user_id' => Auth::user()->id,
        //     'created_at' => Carbon::now(),
        // ]);

        /////        Best Practice Eloquent ORM INSERT          /////

        $category = new Category;
        $category->category_name = $request->category_name;
        $category->user_id = Auth::user()->id;
        $category->save();

        /////        Query Builder Approach  INSERT        /////

        // $data = array();
        // $data['category_name'] = $request->category_name;
        // $data['user_id'] = Auth::user()->id;
        // DB::table('categories')->insert($data);

        return Redirect()->back()->with('success', 'Category Created Successfully');
    }

    /////     Eloquent ORM UPDATE      /////

    public function editCategory($id)
    {
        $category_id = Category::find($id);
        return view('admin.category.edit', compact('category_id'));
    }

    public function updateCategory(Request $request, $id)
    {
        $category_id = Category::find($id)->update([
            'category_name' => $request->category_name,
            'user_id' => Auth::user()->id,
        ]);
        return Redirect()->route('all.category')->with('success', 'Category Updated Successfully');
    }

    /////     Query Builder UPDATE     /////
    // public function editCategory($id)
    // {
    //     $category_id = DB::table('categories')->where('id', $id)->first();
    //     return view('admin.category.edit', compact('category_id'));
    // }

    // public function updateCategory(Request $request, $id)
    // {
    //     $data = array();
    //     $data['category_name'] = $request->category_name;
    //     $data['user_id'] = Auth::user()->id;
    //     DB::table('categories')->where('id', $id)->update($data);
    //     return Redirect()->route('all.category')->with('success', 'Category Updated Successfully');
    // }

    /////      Elequent ORM SOFT DELETE     /////

    public function softDelete($id)
    {
        $delete = Category::find($id)->delete();
        return Redirect()->back()->with('success', 'Category Moved To Trash Bin Successfully');
    }

    public function restoreCategory($id)
    {
        $restore_data = Category::withTrashed()->find($id)->restore();
        return Redirect()->back()->with('success', 'Category Restored Successfully');
    }

    public function clearCategory($id)
    {
        $clear = Category::onlyTrashed()->find($id)->forceDelete();
        return Redirect()->back()->with('success', 'Category Permenantly Deleted');
    }
}
