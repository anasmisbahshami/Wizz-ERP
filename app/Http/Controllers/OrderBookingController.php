<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserSubscription;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use \Carbon\Carbon;

class OrderBookingController extends Controller
{
    public function view()
    {
        return view('dashboard.order-booking.view');
    }

    public function add($id)
    {
        $id = decrypt($id);
        $order = Order::find($id);

        return view('dashboard.order-booking.add',compact('order'));
    }

    public function add_order_item(Request $request)
    {
        $order = Order::find($request->order_id);
        $OrderWeight = $request->weight*$request->quantity;
        
        //Checking Order Type
        if ($order->type == 'Subscription') {
            $user_subscription = $order->user_subscription;
                //Placing Order Item if User is Subscribed & Has Remaining Weight > Total Weight 
                if (!($user_subscription->status == 'Subscribed' && $user_subscription->remaining_weight >= $OrderWeight)) {
                    return redirect()->back()->with('warning', 'Either Subscription is Expired or Remaining Weight is not sufficent!');
                }
            $user_subscription->update([
                'remaining_weight' => $user_subscription->remaining_weight - $OrderWeight
            ]); 
        }

        $item = new OrderItem();
        $item->order_id = $request->order_id;
        $item->name = $request->name;
        $item->weight = $OrderWeight;
        $item->quantity = $request->quantity;
        $item->vehicle_id = $request->vehicle_id;
        $item->route_id = $request->route_id;
        $item->price = $request->rate;
        $item->delivery_address = $request->delivery_address;
        $item->save();

        return redirect()->back()->with('success', 'Order Item Added Successfully!');
    }
    
    public function normal_details(Request $request)
    {
        $user = User::where('email',$request->email)->first();
        if($user){
            $order = new Order();
            $order->type = 'Normal';
            $order->user_id = $user->id;
            $order->save();
            return array('success' => true, 'order_id' => encrypt($order->id));
        }else{
            return array('success' => false, 'msg' => 'No User found with this Email!');
        }        
    }

    public function subscription_details(Request $request)
    {
        $user = User::where('email',$request->email)->first();
        if($user){
            $subscription = UserSubscription::where('user_id',$user->id)->first();
                if ($subscription) {
                    $user_subscription = UserSubscription::find($subscription->id);
                    //Checking Valid Upto Date
                    $CurrentDate = Carbon::now();
                    $SubscriptionEndDate = $subscription->end_date;
                    $ValidUptoResult = $SubscriptionEndDate->gte($CurrentDate);
                    //Creating Order
                    $order = new Order();
                    $order->type = 'Subscription';
                    $order->user_id = $subscription->user_id;
                    $order->save();
                    return array('success' => true,
                                'subscription' => $user_subscription->subscription->name,
                                'remaining_weight' => $subscription->remaining_weight,
                                'vaild_upto' => Carbon::parse($subscription->end_date)->format('d-F-Y'),
                                'valid_upto_result' => $ValidUptoResult,
                                'order_id' => encrypt($order->id)        
                            );
                }else{
                    return array('success' => false, 'msg' => 'No Subscription Found with this Email!');
                }
        }else{
            return array('success' => false, 'msg' => 'No User found with this Email!');
        }
    }
}