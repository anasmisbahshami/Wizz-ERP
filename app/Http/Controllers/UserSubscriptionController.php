<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserSubscription;
use App\Models\Subscription;
use \Carbon\Carbon;
use Mail;

class UserSubscriptionController extends Controller
{
    public function view()
    {
        $subscriptions = UserSubscription::all();
        return view('dashboard.user-subscriptions.view', compact('subscriptions'));
    }

    public function create()
    {
        return view('dashboard.user-subscriptions.add');
    }

    public function user_subscribe(Request $request, $id)
    {
        $id = decrypt($id);
        $IfUserHasSubscription = UserSubscription::where('user_id', \Auth::id())->first();

        //If User has a previous subscription
        if ($IfUserHasSubscription) {

            //Calculating Previous Weight
            $CurrentDate = Carbon::now();
            $PreviousEndDate = $IfUserHasSubscription->end_date;

            $result = $PreviousEndDate->gte($CurrentDate);
            if ($result) {
                $remaining_Weight = $IfUserHasSubscription->remaining_weight;
            }else{
                $remaining_Weight = 0;
            }
    
            $IfUserHasSubscription->update([
                "subscription_id" => $id,
                "start_date" => Carbon::now(),
                "end_date" => Carbon::now()->addMonth(),
                "remaining_weight" => Subscription::find($id)->weight+$remaining_Weight,
                "status" => 'Subscribed',
                "notify_subscribed" => '1'
            ]);

            return redirect()->back()->with('success', 'User Subscription has been updated.');
        }

        //If User has no previous subscription
        $user_subscription = new UserSubscription();
        $user_subscription->user_id = \Auth::id();
        $user_subscription->subscription_id = $id;
        $user_subscription->start_date = Carbon::now();
        $user_subscription->end_date = Carbon::now()->addMonth();
        $user_subscription->remaining_weight = Subscription::find($id)->weight;
        $user_subscription->status = 'Subscribed';
        $user_subscription->notify_subscribed = '1';
        $user_subscription->save();

        return redirect()->back()->with('success', 'User Subscription has been added.');
    }

    public function store(Request $request)
    {
        $IfUserHasSubscription = UserSubscription::where('user_id', $request->user_id)->first();
        if ($IfUserHasSubscription) {
            
            //Calculating Previous Weight
            $CurrentDate = Carbon::now();
            $PreviousEndDate = $IfUserHasSubscription->end_date;

            $result = $PreviousEndDate->gte($CurrentDate);
            if ($result) {
                $remaining_Weight = $IfUserHasSubscription->remaining_weight;
            }else{
                $remaining_Weight = 0;
            }
    
            $IfUserHasSubscription->update([
                "subscription_id" => $request->subscription_id,
                "start_date" => Carbon::now(),
                "end_date" => Carbon::now()->addMonth(),
                "remaining_weight" => Subscription::find($request->subscription_id)->weight+$remaining_Weight,
                "status" => 'Subscribed',
                "notify_subscribed" => '1'
            ]);

        return redirect('user-subscription/view')->with('success','User Subscription has been updated.');
        }

        $user_subscription = new UserSubscription();
        $user_subscription->user_id = $request->user_id;
        $user_subscription->subscription_id = $request->subscription_id;
        $user_subscription->start_date = Carbon::now();
        $user_subscription->end_date = Carbon::now()->addMonth();
        $user_subscription->remaining_weight = Subscription::find($request->subscription_id)->weight;
        $user_subscription->status = 'Subscribed';
        $user_subscription->notify_subscribed = '1';
        $user_subscription->save();

        return redirect('user-subscription/view')->with('success','New User Subscription has been added.');
    }

    public function edit($id)
    {
        $id = decrypt($id);
        $subscription = UserSubscription::find($id);

        return view('dashboard.user-subscriptions.edit', compact('subscription'));
    }

    public function renew_mail($id)
    {
        $id = decrypt($id);
        $subscription = UserSubscription::find($id);

        $data = array('name' => $subscription->user->name,
                'email' => $subscription->user->email );

        Mail::send('emails.subscription_expired', $data,
        function($message) use($data){
        $message->to($data['email'], $data['name'])
        ->subject('Subscription Expired | '. $data['name'])
        ->from('donotreply@wizz-logistics.com','Wizz Express & Logistics');
        });

        return redirect('user-subscription/view')->with('success','Subscription Expired Mail has been sent to the user.');
    }

    public function update(Request $request, $id)
    {
        $id = decrypt($id);
        $UserSubscription = UserSubscription::find($id);

        //Calculating Previous Weight
        $CurrentDate = Carbon::now();
        $PreviousEndDate = $UserSubscription->end_date;

        $result = $PreviousEndDate->gte($CurrentDate);
        if ($result) {
            $remaining_Weight = $UserSubscription->remaining_weight;
        }else{
            $remaining_Weight = 0;
        }
    
        UserSubscription::find($id)->update([
            "subscription_id" => $request->subscription_id,
            "start_date" => Carbon::now(),
            "end_date" => Carbon::now()->addMonth(),
            "remaining_weight" => Subscription::find($request->subscription_id)->weight + $remaining_Weight,
            "status" => 'Subscribed',
            "notify_subscribed" => '1'
        ]);
        
        return redirect('user-subscription/view')->with('success','User Subscription has been updated.');
    }

    public function destroy($id)
    {
        $id = decrypt($id);
        UserSubscription::find($id)->delete();

        return back()->with('success','User Subscription has been deleted');
    }

    public function acknowledge($id)
    {
        $id = decrypt($id);
        UserSubscription::find($id)->update([
            "notify_subscribed" => '0'
        ]);

        return back()->with('success','User Subscription Acknowledged');
    }
}