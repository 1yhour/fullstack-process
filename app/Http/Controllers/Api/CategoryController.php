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
            "data" => CategoryResource::collec($category)
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
