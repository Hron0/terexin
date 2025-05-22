<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display the catalog page with products and filters.
     */
    public function catalog(Request $request)
    {
        // Get all categories for the filter
        $categories = Category::all();
        
        // Get min and max prices for the price filter
        $minPrice = Product::min('price') ?? 0;
        $maxPrice = Product::max('price') ?? 100000;
        
        // Base query
        $query = Product::with(['category', 'characteristics']);
        
        // Apply filters if they exist in the request
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        
        if ($request->has('min_price') && $request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }
        
        if ($request->has('max_price') && $request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }
        
        // Sort products
        $sortBy = $request->sort ?? 'newest';
        
        switch ($sortBy) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        // Get paginated results
        $products = $query->paginate(12)->withQueryString();
        
        // Pass all necessary data to the view
        return view('catalog', compact(
            'products', 
            'categories', 
            'minPrice', 
            'maxPrice',
            'sortBy'
        ));
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'characteristics', 'images']);
        
        // Get related products from the same category
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();
            
        return view('product', compact('product', 'relatedProducts'));
    }
}
