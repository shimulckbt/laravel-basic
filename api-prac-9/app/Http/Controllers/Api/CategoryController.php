<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $cat = Category::latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Successfully retrieved category',
            'data' => $cat,
        ]);
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'name' => 'required|string|unique:categories',
        // ]);

        $data = Validator::make($request->all(), [
            'name' => 'required|string|unique:categories',
        ]);

        if ($data->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error',
                'errors' => $data->getMessageBag(),
            ], 405);
        }
        $formData = $data->validated();
        $formData['slug'] = Str::slug($formData['name']);
        $cat = Category::create($formData);

        return response()->json([
            'success' => true,
            'message' => 'Successfully created',
            'data' => $cat,
        ], 405);
    }

    public function show($id)
    {
        $cat = Category::find($id);
        if (!$cat) {
            return response()->json([
                'success' => false,
                'message' => 'Not Found ',
                'errors' => [],
            ], 404);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Successfully found',
                'data' => $cat,
            ], 405);
        }
    }


    public function update(Request $request, $id)
    {
        $cat = Category::find($id);
        if (!$cat) {
            return response()->json([
                'success' => false,
                'message' => 'Not Found ',
                'errors' => [],
            ], 404);
        }

        $data = Validator::make($request->all(), [
            'name' => 'required|string|unique:categories,name,' . $cat->id,
        ]);

        if ($data->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error',
                'errors' => $data->getMessageBag(),
            ], 422);
        }
        $formData = $data->validated();
        $formData['slug'] = Str::slug($formData['name']);
        $cat->update($formData);

        return response()->json([
            'success' => true,
            'message' => 'Successfully updated',
            'data' => $cat,
        ], 200);
    }
}
