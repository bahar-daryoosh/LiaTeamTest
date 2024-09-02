<?php


namespace App\Services;


use Illuminate\Support\Facades\Hash;
use App\Models\Product;

class ProductService
{


    public function __construct()
    {

    }

    public function index()
    {
        return Product::all();
    }

    public function create($input)
    {
        $product = Product::create($input);
        // $product = $this->dbFunction->dbTransaction([$this->productQuery, 'insert'], $input);
        return $product;
    }

    public function show($id){
        return Product::findOrFail($id);
    }

    public function update($input,$id)
    {
        return Product::findOrFail($id)->update($input);
        // $this->productQuery->update($input['input'], $input['product_id']);

    }




    public function softDelete($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return $product;
        //return Product::find($product_id)->delete();
        // return $this->dbFunction->dbTransaction([$this->productQuery,'delete_avatar'],$product_id);
    }
}