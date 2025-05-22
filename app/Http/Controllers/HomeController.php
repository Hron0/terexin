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
        // Get featured categories
        $categories = Category::take(5)->get();
            
        return view('home', compact('categories'));
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