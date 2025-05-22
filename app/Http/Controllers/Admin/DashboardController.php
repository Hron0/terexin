<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // Get counts for dashboard stats
        $stats = [
            'products' => Product::count(),
            'categories' => Category::count(),
            'users' => User::count(),
            'orders' => Order::count(),
            'recent_products' => Product::with('category')->latest()->take(5)->get(),
        ];
        
        return view('admin.dashboard', compact('stats'));
    }
}