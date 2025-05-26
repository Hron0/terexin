<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items.product']);
        
        // Filter by status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }
        
        // Filter by date range
        if ($request->has('date_from') && !empty($request->date_from)) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && !empty($request->date_to)) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        // Search by order ID or customer name/email
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                  ->orWhere('full_name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'LIKE', "%{$search}%")
                               ->orWhere('email', 'LIKE', "%{$search}%");
                  });
            });
        }
        
        // Sort orders
        $sortBy = $request->sort ?? 'newest';
        switch ($sortBy) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'total_desc':
                $query->orderBy('total', 'desc');
                break;
            case 'total_asc':
                $query->orderBy('total', 'asc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        $orders = $query->paginate(15)->withQueryString();
        
        // Get statistics
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'processing_orders' => Order::where('status', 'processing')->count(),
            'completed_orders' => Order::whereIn('status', ['delivered'])->count(),
            'total_revenue' => Order::whereIn('status', ['processing', 'shipped', 'delivered'])->sum('total'),
            'today_orders' => Order::whereDate('created_at', today())->count(),
        ];
        
        return view('admin.orders.index', compact('orders', 'stats'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        $order->load(['user', 'items.product.category']);
        
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update the order status.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'notes' => 'nullable|string|max:1000'
        ]);
        
        $oldStatus = $order->status;
        $order->status = $request->status;
        
        // Update notes if provided
        if ($request->filled('notes')) {
            $order->notes = $request->notes;
        }
        
        $order->save();
        
        // Log status change (you can expand this to create an order history table)
        \Log::info("Order #{$order->id} status changed from {$oldStatus} to {$request->status} by admin " . auth()->user()->name);
        
        $statusText = $this->getStatusText($request->status);
        
        return back()->with('success', "Статус заказа #{$order->id} изменен на: {$statusText}");
    }

    /**
     * Get order statistics for dashboard.
     */
    public function getStats()
    {
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'processing_orders' => Order::where('status', 'processing')->count(),
            'shipped_orders' => Order::where('status', 'shipped')->count(),
            'delivered_orders' => Order::where('status', 'delivered')->count(),
            'cancelled_orders' => Order::where('status', 'cancelled')->count(),
            'total_revenue' => Order::whereIn('status', ['processing', 'shipped', 'delivered'])->sum('total'),
            'today_orders' => Order::whereDate('created_at', today())->count(),
            'this_month_orders' => Order::whereMonth('created_at', now()->month)->count(),
            'recent_orders' => Order::with(['user', 'items'])
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get()
        ];
        
        return $stats;
    }

    /**
     * Bulk update order statuses.
     */
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'order_ids' => 'required|array',
            'order_ids.*' => 'exists:orders,id',
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);
        
        $updatedCount = Order::whereIn('id', $request->order_ids)
            ->update(['status' => $request->status]);
        
        $statusText = $this->getStatusText($request->status);
        
        return back()->with('success', "Статус {$updatedCount} заказов изменен на: {$statusText}");
    }

    /**
     * Get human-readable status text.
     */
    private function getStatusText($status)
    {
        return match($status) {
            'pending' => 'Ожидает обработки',
            'processing' => 'В обработке',
            'shipped' => 'Отправлен',
            'delivered' => 'Доставлен',
            'cancelled' => 'Отменен',
            default => 'Неизвестно'
        };
    }
}
