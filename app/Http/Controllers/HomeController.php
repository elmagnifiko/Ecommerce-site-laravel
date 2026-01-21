<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', true)->latest()->take(8)->get();
        $categories = Category::all();
        
        return view('home', compact('products', 'categories'));
    }

    public function products()
    {
        $products = Product::where('is_active', true)->latest()->paginate(12);
        $categories = Category::all();
        
        return view('products', compact('products', 'categories'));
    }

    public function categories()
    {
        $categories = Category::withCount('products')->get();
        
        return view('categories', compact('categories'));
    }

    public function categoryProducts($id)
    {
        $category = Category::findOrFail($id);
        $products = Product::where('category_id', $id)
            ->where('is_active', true)
            ->latest()
            ->paginate(12);
        $categories = Category::all();
        
        return view('category-products', compact('category', 'products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();
        
        return view('product-detail', compact('product', 'relatedProducts'));
    }
}