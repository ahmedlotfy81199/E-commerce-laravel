<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index() // Fetch all Orders
    {
        return response()->json(Order::with(['product'])->get(), 200);
    }

    public function deliverOrder(Order $order) //Set status as Order Delivered
    {
        $order->is_delivered = true;
        $status = $order->save();

        return response()->json([
            'status'    => $status,
            'data'      => $order,
            'message'   => $status ? 'Order Delivered!' : 'Error Delivering Order'
        ]);
    }

    public function store(Request $request) //Creates an Order
    {
        $product = Product::find($request->product_id);
        if($product->quantity<=0){
            return response()->json(["message"=>"sorry this product is currntly unaviliable"]);
        }
        $order = Order::create([
            'product_id' => $request->product_id,
            'user_id' => auth()->guard('api')->user()->id,
            'quantity' => $request->quantity,
            'address' => $request->address
        ]);
        $product->quantity -= $order->quantity;
        $product->save();


        return response()->json([
            'status' => (bool) $order,
            'data'   => $order,
            'message' => $order ? 'Order Created!' : 'Error Creating Order'
        ]);
    }

    public function show(Order $order)
    {
        return response()->json($order, 200);
    }

    public function update(Request $request, Order $order) //Updates the Order
    {
        $status = $order->update(
            $request->only(['quantity'])
        );

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Order Updated!' : 'Error Updating Order'
        ]);
    }

    public function destroy(Order $order)  //Deletes the Order
    {
        $status = $order->delete();

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Order Deleted!' : 'Error Deleting Order'
        ]);
    }
}
