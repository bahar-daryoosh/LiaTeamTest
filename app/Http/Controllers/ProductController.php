<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\ProductService;


class ProductController extends Controller
{
    public function __construct()
    {
        $this->productService = new ProductService();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->productService->index();
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        //
        $product = $this->productService->create($request->all());
        return response()->json(['message' => 'Product created successfully', 'product' => $product], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = $this->productService->show($id);

        return response()->json(['product' => $product]);
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request,$id)
    {
        $product = $this->productService->update( $request->all(),$id);

        return response()->json(['message' => 'Product updated successfully', 'product' => $product]);
   
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->productService->softDelete($id);

        return response()->json(['message' => 'Product deleted successfully']);
        //
    }
}
