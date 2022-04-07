<?php

namespace App\Http\Controllers;

use App\Models\BrandModel;
use App\Models\MulripleImage;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Image;
use Auth;

class BrandController extends Controller
{
    /////      Auth Middleware     /////

    public function __construct()
    {
        $this->middleware('auth');
    }
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

        /////     Without Image Intervention     /////

        // $name_gen = hexdec(uniqid());
        // $img_ext = strtolower($brand_image->getClientOriginalExtension());
        // $img_name = $name_gen . '.'  . $img_ext;
        // $up_location = 'image/brand/';
        // $last_img = $up_location . $img_name;
        // $brand_image->move($up_location, $img_name);

        // $brand = new BrandModel;
        // $brand->brand_name = $request->brand_name;
        // $brand->brand_image = $last_img;
        // $brand->save();

        /////     Without Image Intervention     /////

        $name_gen = hexdec(uniqid()) . '.' . $brand_image->getClientOriginalExtension();
        $last_img = 'image/brand/' . $name_gen;
        Image::make($brand_image)->resize(300, 200)->save($last_img); // With Image Intervention

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

    /////        Multiple Image     /////

    public function multipleImage()
    {
        $images = MulripleImage::all();
        return view('admin.multipleimage.index', compact('images'));
    }

    public function addMultipleImage(Request $request)
    {
        $multiple_images = $request->file('multiple_image');

        foreach ($multiple_images as $multiple_image) {
            $name_gen = hexdec(uniqid()) . '.' . $multiple_image->getClientOriginalExtension();
            $last_img = 'image/multiple_image/' . $name_gen;
            Image::make($multiple_image)->resize(300, 200)->save($last_img); // With Image Intervention

            $multi = new MulripleImage;
            $multi->image = $last_img;
            $multi->save();
        }
        return Redirect()->back()->with('success', 'Images Inserted Successfully');
    }

    public function Logout()
    {
        Auth::logout();
        return Redirect()->route('login')->with('success', 'User Logged Out..!');
    }
}
