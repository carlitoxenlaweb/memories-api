<?php

namespace App\Http\Controllers;

use App\Models\Finish;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\ProductFinish;
use App\Models\ProductImage;
use App\Models\Promotion;
use App\Models\Orders;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function view()
    {
        return view("pages.orders", [
            "orders" => Orders::with(['client', 'product', 'finish', 'images'])->get()
        ]);
    }

    public function patch(Request $request)
    {
        $order = Orders::find($request->input('id'));

        $order->status = $request->input('status');
        $order->paid = $request->input('paid');
        
        $order->save();
        return redirect()->route('orders.index');
    }
}
