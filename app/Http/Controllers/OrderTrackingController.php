<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderTrackingController extends Controller
{
    public function view()
    {
        return view('dashboard.order-tracking.view');
    }

    public function user_tracking($id)
    {
        $IfTrackingCodeExits = Order::where('tracking_code', $id)->first();
        $order = Order::find($IfTrackingCodeExits->id);
        return view('dashboard.order-tracking.users-tracking', compact('order'));
    }

    public function tracking_results(Request $request)
    {
        $IfTrackingCodeExits = Order::where('tracking_code', $request->tracking_id)->first();
        if (!$IfTrackingCodeExits) {
            return redirect('/order-track/view')->with('warning', 'No Order Exists Against this Tracking ID!');
        }

        $order = Order::find($IfTrackingCodeExits->id);
        $tracking_id = $request->tracking_id;
        return view('dashboard.order-tracking.track', compact('order','tracking_id'));
    }
}