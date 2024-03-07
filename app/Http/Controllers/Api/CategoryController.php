<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CategoryStoreRequest;
use App\Http\Requests\Api\CategoryUpdateRequest;
use App\Http\Resources\Api\CategoryCollection;
use App\Http\Resources\Api\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    public function index(Request $request): CategoryCollection
    {
        $categories = Category::all();

        return new CategoryCollection($categories);
    }

    public function store(CategoryStoreRequest $request): CategoryResource
    {
        $category = Category::create($request->validated());

        return new CategoryResource($category);
    }

    public function show(Request $request, Category $category): CategoryResource
    {
        return new CategoryResource($category);
    }

    public function update(CategoryUpdateRequest $request, Category $category): CategoryResource
    {
        $category->update($request->validated());

        return new CategoryResource($category);
    }

    public function destroy(Request $request, Category $category): Response
    {
        $category->delete();

        return response()->noContent();
    }
}
