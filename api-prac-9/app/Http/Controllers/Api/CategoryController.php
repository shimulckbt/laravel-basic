<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $cat = Category::latest()->get();

        // return response()->json([
        //     'success' => true,
        //     'message' => 'Successfully retrieved category',
        //     'data' => $cat,
        // ]);

        return new CategoryResource($cat);
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
            // return response()->json([
            //     'success' => false,
            //     'message' => 'Error',
            //     'errors' => $data->getMessageBag(),
            // ], 422);

            return (new ErrorResource($data->getMessageBag()))->response()->setStatusCode(422);
        }
        $formData = $data->validated();
        $formData['slug'] = Str::slug($formData['name']);
        $cat = Category::create($formData);

        // return response()->json([
        //     'success' => true,
        //     'message' => 'Successfully created',
        //     'data' => $cat,
        // ], 405);

        return (new SuccessResource(['message' => 'Category Successfully Created']))->response()->setStatusCode(201);
    }

    public function show(Category $category)
    {
        // $cat = Category::find($id);
        // if (!$cat) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Not Found ',
        //         'errors' => [],
        //     ], 404);
        // }
        return response()->json([
            'success' => true,
            'message' => 'Successfully found',
            'data' => $category,
        ], 405);
    }


    public function update(Request $request, Category $category)
    {
        // $cat = Category::find($id);
        // if (!$cat) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Not Found ',
        //         'errors' => [],
        //     ], 404);
        // }

        $data = Validator::make($request->all(), [
            'name' => 'required|string|unique:categories,name,' . $category->id,
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
        $category->update($formData);

        return response()->json([
            'success' => true,
            'message' => 'Successfully updated',
            'data' => $category,
        ], 200);
    }


    public function destroy(Category $category)
    {
        // $cat = Category::find($id);
        // if (!$cat) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Not Found ',
        //         'errors' => [],
        //     ], 404);
        // }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Successfully Deleted',
            'data' => $category,
        ], 200);
    }
}
