<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use Illuminate\Support\Carbon;
use Image;
use Auth;

class HomeController extends Controller
{
    /////      Auth Middleware     /////

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function homeSlider()
    {
        $sliders = Slider::latest()->get();
        return view('admin.slider.index', compact('sliders'));
    }

    public function addSlider()
    {
        return view('admin.slider.create');
    }

    public function saveSlider(Request $request)
    {
        $images = $request->file('image');

        $name_gen = hexdec(uniqid()) . '.' . $images->getClientOriginalExtension();
        $last_img = 'image/slider/' . $name_gen;
        Image::make($images)->resize(1920, 1088)->save($last_img); // With Image Intervention

        Slider::insert([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $last_img,
            'created_at' => Carbon::now()
        ]);

        return Redirect()->route('home.slider')->with('success', 'Slider Inserted Successfully');
    }
}
