<?php

namespace App\Http\Controllers;

use App\Models\BrandModel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BrandController extends Controller
{
    public function allBrand()
    {
        $brands = BrandModel::latest()->paginate(5);
        return view('admin.brand.index', compact('brands'));
    }

    public function addBrand(Request $request)
    {
        $validatedData = $request->validate(
            [
                'brand_name' => 'required|unique:brands|min:4',
                'brand_image' => 'required|mimes:jpg,jpeg,png,webp',
            ],
            [
                'brand_name.required' => 'Please Input a Valid brand Name...!',
                'brand_name.min' => 'Brand Name Should Be Greater Then 4 Letters...!',
                'brand_image.mimes' => 'Brand Image Format Not Matched...!',
                'brand_image.required' => 'Please Input a brand Image...!',
            ]

        );

        $brand_image = $request->file('brand_image');
        $name_gen = hexdec(uniqid());
        $img_ext = strtolower($brand_image->getClientOriginalExtension());
        $img_name = $name_gen . '.'  . $img_ext;
        $up_location = 'image/brand/';
        $last_img = $up_location . $img_name;
        $brand_image->move($up_location, $img_name);

        $brand = new BrandModel;
        $brand->brand_name = $request->brand_name;
        $brand->brand_image = $last_img;
        $brand->save();

        // BrandModel::insert([
        //     'brand_name' => $request->brand_name,
        //     'brand_image' => $last_img,
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now()
        // ]);

        return Redirect()->back()->with('success', 'brand Inserted Successfully');
    }

    public function editBrand($id)
    {
        $brand_id = BrandModel::find($id);
        return view('admin.brand.edit', compact('brand_id'));
    }

    public function updateBrand(Request $request, $id)
    {
        $validatedData = $request->validate(
            [
                'brand_name' => 'required|min:4',
            ],
            [
                'brand_name.required' => 'Please Input a Valid brand Name...!',
                'brand_name.min' => 'Brand Name Should Be Greater Then 4 Letters...!',
                'brand_image.required' => 'Please Input a brand Image...!',
            ]
        );

        $old_image = $request->old_image;

        $brand_image = $request->file('brand_image');

        if ($brand_image) {
            $name_gen = hexdec(uniqid());
            $img_ext = strtolower($brand_image->getClientOriginalExtension());
            $img_name = $name_gen . '.'  . $img_ext;
            $up_location = 'image/brand/';
            $last_img = $up_location . $img_name;
            $brand_image->move($up_location, $img_name);

            unlink($old_image);

            BrandModel::find($id)->update([
                'brand_name' => $request->brand_name,
                'brand_image' => $last_img,
                'updated_at' => Carbon::now()
            ]);
            return Redirect()->route('all.brand')->with('success', 'brand Updated Successfully');
        } else {
            BrandModel::find($id)->update([
                'brand_name' => $request->brand_name,
                'updated_at' => Carbon::now()
            ]);
            return Redirect()->route('all.brand')->with('success', 'Brand Updated Successfully');
        }
    }

    public function deleteBrand($id)
    {
        $old_image = BrandModel::find($id)->brand_image;
        unlink($old_image);
        BrandModel::find($id)->delete();
        return Redirect()->back()->with('success', 'Brand Deleted Successfully');
    }
}



















// /////      Eloquent ORM SHOW Data      /////
//     public function allbrand()
//     {
//         $categories = brand::latest()->paginate(5);
//         $trashCat = brand::onlyTrashed()->latest()->paginate(3);
//         return view('admin.brand.index', compact('categories', 'trashCat'));
//     }
//     public function addbrand(Request $request)
//     {
//         $validatedData = $request->validate(
//             [
//                 'brand_name' => 'required|unique:categories|max:255'
//             ],
//             [
//                 'brand_name.required' => 'Please Input a Valid brand Name...!',
//                 'brand_name.max' => 'brand Name Should Be Less Then 255...!',
//                 'brand_name.unique' => 'brand Name Should Be Unique...!'
//             ]

//         );

//         $brand = new brand;
//         $brand->brand_name = $request->brand_name;
//         $brand->user_id = Auth::user()->id;
//         $brand->save();
//         return Redirect()->back()->with('success', 'brand Inserted Successfully');
//     }

//     /////     Eloquent ORM UPDATE      /////

//     public function editbrand($id)
//     {
//         $brand_id = brand::find($id);
//         return view('admin.brand.edit', compact('brand_id'));
//     }

//     public function updatebrand(Request $request, $id)
//     {
//         $brand_id = brand::find($id)->update([
//             'brand_name' => $request->brand_name,
//             'user_id' => Auth::user()->id,
//         ]);
//         return Redirect()->route('all.brand')->with('success', 'brand Updated Successfully');
//     }

//     /////      Elequent ORM SOFT DELETE     /////

//     public function softDelete($id)
//     {
//         $delete = brand::find($id)->delete();
//         return Redirect()->back()->with('success', 'brand Soft Deleted Successfully');
//     }

//     public function restorebrand($id)
//     {
//         $restore_data = brand::withTrashed()->find($id)->restore();
//         return Redirect()->back()->with('success', 'brand Restored Successfully');
//     }

//     public function clearbrand($id)
//     {
//         $clear = brand::onlyTrashed()->find($id)->forceDelete();
//         return Redirect()->back()->with('success', 'brand Permenantly Deleted');
//     }