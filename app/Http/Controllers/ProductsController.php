<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    //
    public function index(){
        return Product::all();
    }

//  public function show(Product $product){
//    return $product;
//   }

  public function showProduct($id){
      if (Product::where('id', $id)->exists()) {
          $product = Product::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
          return response($product, 200);
      } else {
          return response()->json([
              "message" => "Product not found"
          ], 404);
      }
  }

  public function store(Request $request){
        $product = Product::create($request->all());
        return response()->json($product,201);
  }

  public function updateProduct(Request $request, $id) {
        if (Product::where('id', $id)->exists()) {
            $product = Product::find($id);
            $product->description = is_null($request->description) ? $product->description : $request->description;
            $product->title = is_null($request->title) ? $product->title : $request->title;
            $product->price = is_null($request->price) ? $product->price : $request->price;
            $product->availability = is_null($request->title) ? $product->availability : $request->availability;
//            $product->touch();
            $product->save();

            return response()->json([
                "message" => "records updated successfully"
            ], 200);
        } else {
            return response()->json([
                "message" => "Student not found"
            ], 404);

        }
   }

//  public function update(Request $request, Product $product){
//        $product->update($request->all());
//        return response()->json($product, 200);
//  }
//
//  public function delete(Product $product){
//        $product->delete();
//        return response()->json(null,204);
//  }

  public function deleteProduct($id) {
        if(Product::where('id', $id)->exists()) {
            $product = Product::find($id);
            $product->delete();

            return response()->json([
                "message" => "records deleted"
            ], 202);
        } else {
            return response()->json([
                "message" => "Product not found"
            ], 404);
        }
    }
}
