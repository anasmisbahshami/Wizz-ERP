<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    public function view()
    {
        return view('dashboard.order-tracking.view');
    }
}
