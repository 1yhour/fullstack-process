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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
