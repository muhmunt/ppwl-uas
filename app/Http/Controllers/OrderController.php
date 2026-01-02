<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Menu;
use App\Models\Category;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'orderItems.menu']);

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by date
        if ($request->has('date') && $request->date) {
            $query->whereDate('created_at', $request->date);
        }

        // Filter by user (kasir can only see their own orders, admin can see all)
        if (auth()->user()->role === 'kasir') {
            $query->where('user_id', auth()->id());
        } elseif ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        // Search by order number
        if ($request->has('search') && $request->search) {
            $query->where('order_number', 'like', '%' . $request->search . '%')
                  ->orWhere('customer_name', 'like', '%' . $request->search . '%');
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('is_active', true)->with(['menus' => function($query) {
            $query->where('is_available', true);
        }])->orderBy('name')->get();

        return view('orders.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderRequest $request)
    {
        DB::beginTransaction();
        try {
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => auth()->id(),
                'customer_name' => $request->customer_name,
                'table_number' => $request->table_number,
                'status' => 'pending',
                'notes' => $request->notes,
            ]);

            $totalPrice = 0;

            foreach ($request->items as $item) {
                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $item['menu_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['quantity'] * $item['price'],
                    'notes' => $item['notes'] ?? null,
                ]);

                $totalPrice += $orderItem->subtotal;

                // Update stock if available
                $menu = Menu::find($item['menu_id']);
                if ($menu && $menu->stock > 0) {
                    $menu->stock -= $item['quantity'];
                    $menu->save();
                }
            }

            $order->total_price = $totalPrice;
            $order->save();

            DB::commit();

            return redirect()->route('orders.show', $order)
                ->with('success', 'Pesanan berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal membuat pesanan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        // Authorization check
        if (auth()->user()->role === 'kasir' && $order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized.');
        }

        $order->load(['user', 'orderItems.menu']);
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        // Only pending orders can be edited
        if ($order->status !== 'pending') {
            return redirect()->route('orders.show', $order)
                ->with('error', 'Hanya pesanan dengan status pending yang dapat diedit.');
        }

        // Authorization check
        if (auth()->user()->role === 'kasir' && $order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized.');
        }

        $categories = Category::where('is_active', true)->with(['menus' => function($query) {
            $query->where('is_available', true);
        }])->orderBy('name')->get();

        $order->load('orderItems.menu');

        return view('orders.edit', compact('order', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderRequest $request, Order $order)
    {
        // Only pending orders can be updated
        if ($order->status !== 'pending') {
            return redirect()->route('orders.show', $order)
                ->with('error', 'Hanya pesanan dengan status pending yang dapat diupdate.');
        }

        // Authorization check
        if (auth()->user()->role === 'kasir' && $order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized.');
        }

        DB::beginTransaction();
        try {
            $order->customer_name = $request->customer_name;
            $order->table_number = $request->table_number;
            $order->notes = $request->notes;
            $order->save();

            // Restore stock from old items
            foreach ($order->orderItems as $oldItem) {
                $menu = $oldItem->menu;
                if ($menu && $menu->stock >= 0) {
                    $menu->stock += $oldItem->quantity;
                    $menu->save();
                }
            }

            // Delete old items
            $order->orderItems()->delete();

            // Create new items
            $totalPrice = 0;
            foreach ($request->items as $item) {
                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $item['menu_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['quantity'] * $item['price'],
                    'notes' => $item['notes'] ?? null,
                ]);

                $totalPrice += $orderItem->subtotal;

                // Update stock
                $menu = Menu::find($item['menu_id']);
                if ($menu && $menu->stock > 0) {
                    $menu->stock -= $item['quantity'];
                    $menu->save();
                }
            }

            $order->total_price = $totalPrice;
            $order->save();

            DB::commit();

            return redirect()->route('orders.show', $order)
                ->with('success', 'Pesanan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal memperbarui pesanan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        // Only admin can delete orders
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized.');
        }

        // Only pending orders can be deleted
        if ($order->status !== 'pending') {
            return redirect()->route('orders.show', $order)
                ->with('error', 'Hanya pesanan dengan status pending yang dapat dihapus.');
        }

        DB::beginTransaction();
        try {
            // Restore stock
            foreach ($order->orderItems as $item) {
                $menu = $item->menu;
                if ($menu && $menu->stock >= 0) {
                    $menu->stock += $item->quantity;
                    $menu->save();
                }
            }

            $order->orderItems()->delete();
            $order->delete();

            DB::commit();

            return redirect()->route('orders.index')
                ->with('success', 'Pesanan berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menghapus pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Update order status.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => ['required', 'in:pending,processing,completed,cancelled'],
        ]);

        $order->status = $request->status;
        $order->save();

        return redirect()->back()
            ->with('success', 'Status pesanan berhasil diperbarui.');
    }

    /**
     * Print order receipt.
     */
    public function print(Order $order)
    {
        $order->load(['user', 'orderItems.menu']);
        
        $pdf = Pdf::loadView('orders.receipt', compact('order'));
        return $pdf->download('order-' . $order->order_number . '.pdf');
    }
}