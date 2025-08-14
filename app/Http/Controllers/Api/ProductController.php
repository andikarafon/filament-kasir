<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();

        return response()->json([
            'success' => true,
            'message' => 'Sukses',
            'data' => $products
        ]);
    }

    public function showByBarcode($barcode)
    {
        $product = Product::where('barcode', $barcode)->first();
        if (!$product) { //jika tidak ada 
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $product,
            'message' => 'Success'
        ]);
    }

}
