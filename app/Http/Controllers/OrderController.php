<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItems;

class OrderController extends Controller
{
    public function view()
    {
        $orders = Order::orderBy('id','DESC')->get();    
        return view('dashboard.order.view', compact('orders'));
    }
}
