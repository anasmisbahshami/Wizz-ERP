<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmationMail;
use App\Models\UserSubscription;
use App\Models\User;
use App\Models\Order;
use App\Models\Trip;
use App\Models\OrderItem;
use \Carbon\Carbon;
use Dompdf\Dompdf;
use Auth;

class OrderBookingController extends Controller
{
    public function view()
    {
        //Order Statuses 
        //(Unconfirmed, Confirmed, Unpaid, Paid, Started, In progress, Complete)
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

        //Adding Trip
        $trip = new Trip();
        $trip->vehicle_id = $request->vehicle_id;
        $trip->route_id = $request->route_id;
        $trip->date = $item->created_at;
        $trip->rate = $request->rate;
        $trip->save();

        return redirect()->back()->with('success', 'Order Item Added Successfully!');
    }

    public function update(Request $request, $id)
    {   
        $id = decrypt($id);
        $orderItem = OrderItem::find($id);

        $order = Order::find($orderItem->order_id);
        $OrderWeight = $request->weight*$request->quantity;

    //Checking Order Type
    if ($order->type == 'Subscription') {
        $user_subscription = $order->user_subscription;
        
        //Checking if OrderItem Weight is < TotalRenewed Weight     
        if ($orderItem->weight < $OrderWeight) {
            $extraWeight = $OrderWeight - $orderItem->weight;

            //Updating OrderItem if User is Subscribed & Has Remaining Weight > TotalRenewed Weight 
            if (!($user_subscription->status == 'Subscribed' && $user_subscription->remaining_weight >= $extraWeight)) {
                return redirect()->back()->with('warning', 'Either Subscription is Expired or Remaining Weight is not sufficent!');
            }
            
            //Subtracting Extra Weight from User Subscription Weight
            $user_subscription->update([
                'remaining_weight' => $user_subscription->remaining_weight - $extraWeight
            ]); 
        }

        //Checking if OrderItem Weight is < TotalRenewed Weight     
        elseif($orderItem->weight > $OrderWeight){
            $extraWeight = $orderItem->weight - $OrderWeight;
                
            //Updating OrderItem if User is Subscribed 
            if (!($user_subscription->status == 'Subscribed')) {
                return redirect()->back()->with('warning', 'Your Subscription is Expired!');
            }

            //Adding Extra Weight to User Subscription Weight
            $user_subscription->update([
                'remaining_weight' => $user_subscription->remaining_weight + $extraWeight
            ]);
        }
    }

        $orderItem->name = $request->name;
        $orderItem->weight = $OrderWeight;
        $orderItem->quantity = $request->quantity;
        $orderItem->vehicle_id = $request->vehicle_id;
        $orderItem->route_id = $request->route_id;
        $orderItem->price = $request->rate;
        $orderItem->delivery_address = $request->delivery_address;
        $orderItem->save();

        //Updating Trip
        $trip = Trip::where('vehicle_id', $orderItem->vehicle_id)->where('route_id', $orderItem->route_id)
                    ->where('rate', $orderItem->price)->first();

        Trip::find($trip->id)->update([
            'vehicle_id' => $request->vehicle_id,
            'route_id' => $request->route_id,
            'rate' => $request->rate,
        ]);

        return redirect()->back()->with('success', 'Order Item Updated Successfully!');
    }

    public function confirm_order($id)
    {
        $id = decrypt($id);
        $order = Order::find($id);
        if ($order->status == "Confirmed") {
            return redirect('/');
        }
        $order->status = "Confirmed";
        $order->save();
        return view('dashboard.order-booking.confirm', compact('order'));
    }

    public function complete_order($id)
    {
        $id = decrypt($id);
        $order = Order::find($id);
        
        if (count($order->items) <= 0 ) {
            return redirect()->back()->with('warning', 'Order Must Have At least One Item!');
        }

        if ($order->type == 'Subscription') {
            $order->status = 'Paid';
            $order->notify_paid = '1';
            $order->save();

        //Order Invoice Generation (Logo)
        $avatarUrl = public_path('/assets/images/logo.png');
        $arrContextOptions=array(
                        "ssl"=>array(
                            "verify_peer"=>false,
                            "verify_peer_name"=>false,
                        ),
                    );
        $type = pathinfo($avatarUrl, PATHINFO_EXTENSION);
        $avatarData = file_get_contents($avatarUrl, false, stream_context_create($arrContextOptions));
        $avatarBase64Data = base64_encode($avatarData);
        $base64 = 'data:image/' . $type . ';base64,' . $avatarBase64Data;

        //Dimension Invoice
        $avatarUrl1 = public_path('/assets/images/dimension.png');
        $arrContextOptions1=array(
                        "ssl"=>array(
                            "verify_peer"=>false,
                            "verify_peer_name"=>false,
                        ),
                    );
        $type1 = pathinfo($avatarUrl1, PATHINFO_EXTENSION);
        $avatarData1 = file_get_contents($avatarUrl1, false, stream_context_create($arrContextOptions1));
        $avatarBase64Data1 = base64_encode($avatarData1);
        $base641 = 'data:image/' . $type1 . ';base64,' . $avatarBase64Data1;

        $data = array('email' => $order->user->email,'name' => $order->user->name, 'order' => $order);

        $html = view('pdf.order_invoice', compact('base64', 'base641','order'));

        $dompdf = new Dompdf();

        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('letter', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        //Sending Mail and Invoice to User Email
        Mail::send('emails.order_invoice', $data,
        function($message) use($data, $dompdf){
        $message->to($data['email'], $data['name'])
        ->subject('Order Invoice | W-'.$data['order']->id)
        ->attachData($dompdf->output(), 'Invoice - W-'.$data['order']->id.'.pdf')
        ->from('donotreply@wizz-express.com','Wizz Express & Logistics');
        });

        return redirect('/order/view')->with('success', 'Order Invoice has been sent to your email!');
        
    }else{
        //Order Invoice Generation (Logo)
        $avatarUrl = public_path('/assets/images/logo.png');
        $arrContextOptions=array(
                        "ssl"=>array(
                            "verify_peer"=>false,
                            "verify_peer_name"=>false,
                        ),
                    );
        $type = pathinfo($avatarUrl, PATHINFO_EXTENSION);
        $avatarData = file_get_contents($avatarUrl, false, stream_context_create($arrContextOptions));
        $avatarBase64Data = base64_encode($avatarData);
        $base64 = 'data:image/' . $type . ';base64,' . $avatarBase64Data;

        //Dimension Invoice
        $avatarUrl1 = public_path('/assets/images/dimension.png');
        $arrContextOptions1=array(
                        "ssl"=>array(
                            "verify_peer"=>false,
                            "verify_peer_name"=>false,
                        ),
                    );
        $type1 = pathinfo($avatarUrl1, PATHINFO_EXTENSION);
        $avatarData1 = file_get_contents($avatarUrl1, false, stream_context_create($arrContextOptions1));
        $avatarBase64Data1 = base64_encode($avatarData1);
        $base641 = 'data:image/' . $type1 . ';base64,' . $avatarBase64Data1;

        $data = array('email' => $order->user->email,'name' => $order->user->name, 'order' => $order);

        $html = view('pdf.order_invoice', compact('base64', 'base641','order'));

        $dompdf = new Dompdf();

        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('letter', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        //Sending Mail and Invoice to User Email
        Mail::send('emails.order_confirmation', $data,
        function($message) use($data, $dompdf){
        $message->to($data['email'], $data['name'])
        ->subject('Order Confirmation | W-'.$data['order']->id)
        ->attachData($dompdf->output(), 'Invoice - W-'.$data['order']->id.'.pdf')
        ->from('donotreply@wizz-express.com','Wizz Express & Logistics');
        });

        return redirect('/order/view')->with('success', 'Order Confirmation Email & Invoice has been sent to your email address!');
    }

    }

    public function destroy_order($id)
    {
        $id = decrypt($id);
        $order = Order::find($id);

        if ($order->type == 'Subscription') {
            $user_subscription = $order->user_subscription;
            $UsedWeight = $order->items->sum('weight');

            //Adding Used Weight to User Subscription Weight
            $user_subscription->update([
                'remaining_weight' => $user_subscription->remaining_weight + $UsedWeight
            ]);
        }
        
        //Deleting OrderItems
        foreach ($order->items as $item) {
            $item->delete();
        }

        //Deleting Order
        $order->delete();

        return redirect('/order-book/view');
    }

    public function destroy($id)
    {
        $id = decrypt($id);
        OrderItem::find($id)->delete();

        return redirect()->back()->with('success', 'Order Item Removed Successfully!');
    }

    public function normal_details(Request $request)
    {
        $user = User::where('email',$request->email)->first();
        if($user){
            $order = new Order();
            $order->type = 'Normal';
            $order->user_id = $user->id;
            $order->booked_by = Auth::id();
            $order->save();
            return array('success' => true, 'order_id' => encrypt($order->id));
        }else{
            //If no email found Create Default User
            $user = new User();
            $user->name = strtok($request->email, '@');
            $user->email = $request->email;
            $user->password = Hash::make('default');
            $user->save();
            $user->assignRole('User');
            //Creating new order
            $order = new Order();
            $order->type = 'Normal';
            $order->user_id = $user->id;
            $order->booked_by = Auth::id();
            $order->save();
            return array('success' => true, 'order_id' => encrypt($order->id));
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
                    $order->status = 'Confirmed';
                    $order->user_id = $subscription->user_id;
                    $order->booked_by = Auth::id();
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