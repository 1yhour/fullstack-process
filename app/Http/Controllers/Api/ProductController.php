<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = Product::latest()->paginate(15);
        return response()->json(
            [
                "success"=> true,
                "message"=> "Successfully fetched products",
                "data" => ProductResource::collection($product),
            ], 200
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        try{
            $validated = $request->validated();
            $product = DB::transaction(function() use ($validated){
                return Product::create($validated);
            });
            return response()->json(
                [
                    "success"=> true,
                    "message"=> "Successfully created product",
                    "data" => new ProductResource($product)
                ], 201
        );
        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json(
                [
                    "success"=> false,
                    "message"=> "Failed to create product",
                ], 500
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response()->json(
            [
                "success" => true,
                "message" => "Successfully get the products",
                "data" => new ProductResource($product)
            ], 200
        );
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        try{
            $validated = $request->validated();
            DB::transaction(function() use ($validated, $product){
                return $product->update($validated);
            });
            
            return response()->json(
                [
                    "success" => true,
                    "message" => "Product Updated",
                    "data" => new ProductResource($product)
                ],200
            );
        }catch(Throwable $e){
            Log::error("Failed to update the product" . $e->getMessage());
            return response()->json(
                [
                    "success" => false,
                    "message" => "Failed to update product",
                ], 500
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try{
            DB::transaction(function() use ($product){
                return $product->delete();
            });
            return response()->json(
                [
                    "success" => true,
                    "message" => "Successfully deleted the product",
                ], 200
            );
        }catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json(
                [
                    "success" => false,
                    "message" => "Failed to delete the product",
                ], 500
            );
        }
    }
}
