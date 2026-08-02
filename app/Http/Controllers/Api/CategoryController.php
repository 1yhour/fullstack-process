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
use App\Traits\ApiResponseTrait;
class CategoryController extends Controller
{
    use ApiResponseTrait;
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::latest()->paginate(10);
        $categoryCollection = CategoryResource::collection($category);
        return $this->successResponse("Successfully fetched categories", $categoryCollection);
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
            return $this->successResponse("Successfully created category", new CategoryResource($category), 201);
        }catch(Exception $e){
            Log::error("Failed to create the category" . $e->getMessage());
            return $this->errorResponse("Failed to create category", 500);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return $this->successResponse("Successfully fetched category", new CategoryResource($category));
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
            return $this->successResponse("Category Updated", new CategoryResource($category));
        }catch(Throwable $e){
            Log::error("Failed to Update Category");
            return $this->errorResponse("Failed to Update Category", 500);
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
        return $this->successMessage("Category Deleted");
    }
}
