<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserSubscription;
use App\Models\User;
use \Carbon\Carbon;

class OrderBookingController extends Controller
{
    public function view()
    {
        return view('dashboard.order-booking.view');
    }

    public function normal_details(Request $request)
    {
        $user = User::where('email',$request->email)->first();
        if($user){
            return array('success' => true, 'user_id' => encrypt($user->id));
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
                    return array('success' => true,
                                'subscription' => $user_subscription->subscription->name,
                                'remaining_weight' => $subscription->remaining_weight,
                                'vaild_upto' => Carbon::parse($subscription->end_date)->format('d-F-Y'),
                                'valid_upto_result' => $ValidUptoResult,
                                'user_id' => encrypt($subscription->user_id)        
                            );
                }else{
                    return array('success' => false, 'msg' => 'No Subscription Found with this Email!');
                }
        }else{
            return array('success' => false, 'msg' => 'No User found with this Email!');
        }
    }
}