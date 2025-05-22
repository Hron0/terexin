<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function index()
    {
        $categories = Category::all();
        $featuredProducts = Product::with('category')->latest()->take(8)->get();
        
        return view('home', compact('categories', 'featuredProducts'));
    }

    /**
     * Display the about us page.
     */
    public function about()
    {
        // Get categories for the footer
        $categories = Category::take(5)->get();
        
        return view('about', compact('categories'));
    }
}