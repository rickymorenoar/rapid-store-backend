<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request) 
    {

    $validatedData = $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1|max:10',
    ]);

    if($request->header('X-App-Secret') !== 'password-rahasia-kita') {
        return response()->json([
            'message' => 'Unauthorized access. Invalid X-App-Secret header.'
        ], 403);
    }
try{
    return DB::transaction(function () use ($request) {
        $product = Product::where('id', $request->product_id)->lockForUpdate()->first();
        
        if($product->stock < $request->quantity) {
            throw new \Exception('Insufficient stock for the requested product.');
        }

        $totalPrice = $product->price * $request->quantity;

        $order = Order::create([
            'product_id' => $request->product_id,
            'user_id' => 1,
            'quantity' => $request->quantity,
            'total_amount' => $totalPrice,
            'status' => 'pending',

        ]);

        $product->decrement('stock', $request->quantity);

        return response()->json([
            'message' => 'Order placed successfully',
            'data' => $order
        ], 201);
    });

    } catch (\Exception $e) {
        return response()->json([
            'message' => $e->getMessage()
        ], 400);
        }
    }

    public function index(Request $request)
    {

        $user = $request->user();

        if($user->role == 'admin') {
            $orders = Order::with('product')->get();
        } else {
            $orders = Order::with('product')->where('user_id', $user->id)->get();
        }

        return response()->json([
            'message' => 'Orders retrieved successfully',
            'data' => $orders
        ], 200);
    }

    public function updateStatus(Request $request, int $id)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,shipped,success,cancelled'
        ]);

        $order = Order::findOrFail($id);
        
        if($request->status === 'cancelled' && $order->status !== 'cancelled') {
            $product = Product::find($order->product_id);
            $product->increment('stock', $order->quantity);
        }

        $order->status = $request->status;
        $order->save();

        return response()->json([
            'message' => 'Order status updated to' . $request->status,
            'data' => $order
        ], 200);
    }
}