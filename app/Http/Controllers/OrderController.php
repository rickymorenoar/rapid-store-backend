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
        'quantity' => 'required|integer|min:1',
    ]);
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
            'status' => 'success',

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
}