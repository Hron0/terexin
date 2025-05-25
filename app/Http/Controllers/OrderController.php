<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the user's orders.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\View\View
     */
    public function show(Order $order)
    {
        // Check if the order belongs to the user
        if ($order->user_id != Auth::id()) {
            return redirect()->route('orders')->with('error', 'Доступ запрещен.');
        }
        
        $order->load('items.product');
        
        return view('orders.show', compact('order'));
    }

    /**
     * Show the checkout page.
     *
     * @return \Illuminate\View\View
     */
    public function checkout()
    {
        $basket = Basket::where('user_id', Auth::id())->first();
        
        if (!$basket || $basket->items->isEmpty()) {
            return redirect()->route('basket')->with('error', 'Ваша корзина пуста.');
        }
        
        $items = $basket->items()->with('product.category')->get();
        $total = $items->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
        
        return view('orders.checkout', compact('items', 'total'));
    }

    /**
     * Create a new order from the user's basket.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'payment_method' => 'required|in:card,cash',
            'delivery_method' => 'required|in:courier,pickup',
            'notes' => 'nullable|string|max:1000',
        ]);
        
        $basket = Basket::where('user_id', Auth::id())->first();
        
        if (!$basket || $basket->items->isEmpty()) {
            return back()->with('error', 'Ваша корзина пуста.');
        }
        
        $total = $basket->items->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
        
        DB::beginTransaction();
        
        try {
            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'total' => $total,
                'status' => 'pending',
                'full_name' => $validated['full_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'payment_method' => $validated['payment_method'],
                'delivery_method' => $validated['delivery_method'],
                'notes' => $validated['notes'] ?? null,
            ]);
            
            // Create order items
            foreach ($basket->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
            }
            
            // Clear basket
            $basket->items()->delete();
            
            // Update cart count in session
            session(['cart_count' => 0]);
            
            DB::commit();
            
            return redirect()->route('orders.show', $order)->with('success', 'Заказ успешно оформлен! Номер заказа: #' . $order->id);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Произошла ошибка при оформлении заказа. Пожалуйста, попробуйте еще раз.');
        }
    }
}
