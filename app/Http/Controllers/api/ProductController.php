<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;

class ProductController extends Controller
{
    public function index() {
        $products = Product::all();
        // Check for products
        if ($products->count() > 0){
            return response()->json($products, 200); // Return all products and OK HTTP response
        } else {
            // No products found
            return response()->json([
                'status' => 404, // Send not found HTTP response
                'message' => 'No product records found.'
            ], 404);
        }
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'cat' => 'required|string',
            'product' => 'required|string',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'sale' => 'required|regex:/^\d+(\.\d{1,2})?$/'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422, // Send unprocessable content HTTP response
                'errors' => $validator->messages()
            ], 422);
        } else {
            $product = Product::create([
                'cat' => $request->cat,
                'product' => $request->product,
                'price' => $request->price,
                'sale' => $request->sale,
            ]);

            if ($product) {
                return response()->json([
                    'status' => 200, // Send OK HTTP response
                    'product' => 'Product added successfully.'
                ], 200);
            }else {
                return response()->json([
                    'status' => 500, // Send unexpected server error HTTP response
                    'message' => 'Servers were nuked out of orbit.'
                ], 500);
            }
        }
    }
}
