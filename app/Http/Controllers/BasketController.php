<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\BasketItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BasketController extends Controller
{
    /**
     * Display the user's basket.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $basket = Basket::where('user_id', Auth::id())->first();
        
        if (!$basket) {
            $basket = Basket::create(['user_id' => Auth::id()]);
        }
        
        $items = $basket->items()->with('product.category')->get();
        $total = $items->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
        
        return view('basket.index', compact('items', 'total'));
    }

    /**
     * Add a product to the basket.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
        
        $basket = Basket::firstOrCreate(['user_id' => Auth::id()]);
        
        $basketItem = BasketItem::where('basket_id', $basket->id)
            ->where('product_id', $product->id)
            ->first();
        
        if ($basketItem) {
            $basketItem->quantity += $request->quantity;
            $basketItem->save();
        } else {
            BasketItem::create([
                'basket_id' => $basket->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
            ]);
        }
        
        // Update cart count in session
        $cartCount = BasketItem::where('basket_id', $basket->id)->sum('quantity');
        session(['cart_count' => $cartCount]);
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Товар добавлен в корзину',
                'cart_count' => $cartCount
            ]);
        }
        
        return back()->with('success', 'Товар добавлен в корзину.');
    }

    /**
     * Update the quantity of a basket item.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BasketItem  $item
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, BasketItem $item)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
        
        // Check if the item belongs to the user's basket
        $basket = Basket::where('user_id', Auth::id())->first();
        
        if ($item->basket_id != $basket->id) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Доступ запрещен'], 403);
            }
            return back()->with('error', 'Доступ запрещен.');
        }
        
        $item->quantity = $request->quantity;
        $item->save();
        
        // Update cart count in session
        $cartCount = BasketItem::where('basket_id', $basket->id)->sum('quantity');
        session(['cart_count' => $cartCount]);
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Количество товара обновлено',
                'cart_count' => $cartCount
            ]);
        }
        
        return back()->with('success', 'Количество товара обновлено.');
    }

    /**
     * Remove an item from the basket.
     *
     * @param  \App\Models\BasketItem  $item
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function remove(BasketItem $item)
    {
        // Check if the item belongs to the user's basket
        $basket = Basket::where('user_id', Auth::id())->first();
        
        if ($item->basket_id != $basket->id) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Доступ запрещен'], 403);
            }
            return back()->with('error', 'Доступ запрещен.');
        }
        
        $item->delete();
        
        // Update cart count in session
        $cartCount = BasketItem::where('basket_id', $basket->id)->sum('quantity');
        session(['cart_count' => $cartCount]);
        
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Товар удален из корзины',
                'cart_count' => $cartCount
            ]);
        }
        
        return back()->with('success', 'Товар удален из корзины.');
    }
}
