<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{

    public function uploadToLocal(Request $request)
    {
        // Handle uploading to local disk
        $path = $request->file('image')->store('images', 'local');
        return response()->json(['path' => $path]);
    }

    public function uploadToPublic(Request $request)
    {
        // Handle uploading to public disk
        $path = $request->file('image')->store('images', 'public');
        return response()->json(['path' => $path]);
    }

    public function index()
    {
        // Retrieve all products
        $products = Product::all();
        return response()->json($products, 200);
    }

    public function store(Request $request)
    {
        // Create a new product
        $product = Product::create($request->all());
        return response()->json(['message' => 'Product created successfully'], 201);
    }

    public function show($id)
    {
        // Retrieve a specific product by ID
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        return response()->json(['message' => 'Display product with ID: ' . $id, 'product' => $product], 200);
    }

    public function update(Request $request, $id)
    {
        // Update an existing product by ID
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        $product->update($request->all());
        return response()->json(['message' => 'Product with ID: ' . $id . ' updated successfully'], 200);
    }

    public function destroy($id)
    {
        // Delete a product by ID
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        $product->delete();
        return response()->json(['message' => 'Product with ID: ' . $id . ' deleted successfully'], 200);
    }

    public function uploadImageLocal(Request $request)
    {
        // Handle uploading an image using the local disk driver
        $path = $request->file('image')->store('images', 'local');
        return response()->json(['message' => 'Image successfully stored in local disk driver', 'path' => $path], 200);
    }

    public function uploadImagePublic(Request $request)
    {
        // Handle uploading an image using the public disk driver
        $path = $request->file('image')->store('images', 'public');
        return response()->json(['message' => 'Image successfully stored in public disk driver', 'path' => $path], 200);
    }
}
