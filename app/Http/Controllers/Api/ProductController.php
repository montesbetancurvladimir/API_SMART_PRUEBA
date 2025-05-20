<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    public function index(){
        return response()->json(Product::with('category')->paginate(10));
    }

    public function show($id){
        $product = Product::with('category')->find($id);
        if (!$product) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }
        return response()->json($product);
    }

    public function store(StoreProductRequest $request){
        $product = Product::create($request->validated());
        return response()->json($product, 201);
    }

    public function update(UpdateProductRequest $request, $id) {
        $product = Product::find($id);
        if(!$product){
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }
        $product->update($request->validated());
        return response()->json($product);
    }

    public function destroy($id){
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }
        $product->delete();
        return response()->json(['message' => 'Producto eliminado']);
    }
}
