<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Http\Resources\CategoryResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::latest()->paginate(10);
        return response()->json([
            "success"=> true,
            "message"=> "Successfully fetched categories",
            "data" => CategoryResource::collection($category)
        ], 200);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {   
        try{
            $validated = $request->validated();
            $category = DB::transaction(function() use ($validated){
                return Category::create($validated);
            });
            return response()->json(
            [
                "success"=> true,
                "message"=> "Successfully created category",
                "data" => new CategoryResource($category)
            ], 201
        );
        }catch(Exception $e){
            Log::error("Failed to create the category" . $e->getMessage());
            return response()->json(
                [
                    "success" => false,
                    "message" => "Failed to create category",
                ], 500
            );
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return response()->json([
            "success" => true,
            "message" => "Successfully fetched category",
            "data" => new CategoryResource($category)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        try{
            $validated = $request->validated();
            DB::transaction(function () use ($validated, $category){
                return $category->update($validated);
            });
            return response()->json(
                [
                    "success" => true,
                    "message" => "Category Updated",
                    "data" => new CategoryResource($category)
                ],200
            );
        }catch(Throwable $e){
            Log::error("Failed to Update Category");
            return response()->json(
                [
                    "success" => false,
                    "message" => "Failed to Update",
                ],500
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $cate = Category::findOrFail($category->id);
        
        DB::transaction(function() use ($cate){
            return $cate->delete();
        });
        return response()->json(
            [
                "success" => true,
                "message" => "Category Deleted",
            ],200
        );
    }
}
