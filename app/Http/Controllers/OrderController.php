<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\User;

class OrderController extends Controller
{
    public function order(Request $requests)
    {
        $request = json_decode($requests->getContent(), true);
        $user_id = User::where('auth_key', $requests->bearerToken())->first();
        $request['user_id'] = $user_id->id;
        $product = Product::where('id', $request['product_id'])->first();
        $current_count = $product->available_stock - $request['quantity'];
        if ($current_count < 0) {
            return response([
                'message' => 'Failed to order this product due to unavailability of the stock',
            ], 400);
        }
        Product::where('id', $request['product_id'])->update([
            'available_stock' => $current_count,
        ]);
        Order::create($request);
        return response([
            'message' => 'You have successfully ordered this product',
        ], 201);
    }
}
