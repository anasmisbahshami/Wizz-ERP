<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\UserSubscription;

class SubscriptionController extends Controller
{
    public function view()
    {
        if (\Auth::user()->hasRole('User')) {
            $IfUserHasSubscription = UserSubscription::where('user_id', \Auth::id())->first();
            if ($IfUserHasSubscription) {
                if ($IfUserHasSubscription->status == 'Subscribed') {
                    $subscriptions = Subscription::all();
                    return view('dashboard.subscriptions.details.edit', compact('subscriptions','IfUserHasSubscription'));
                }else{
                    $subscriptions = Subscription::all();
                    return view('dashboard.subscriptions.details.add', compact('subscriptions'));
                }
            }else{
                $subscriptions = Subscription::all();
                return view('dashboard.subscriptions.details.add', compact('subscriptions'));
            }
        }
        
        $subscriptions = Subscription::all();
        return view('dashboard.subscriptions.view', compact('subscriptions'));
    }

    public function create()
    {
        return view('dashboard.subscriptions.add');
    }

    public function store(Request $request)
    {
        $input = $request->except('_token');
        Subscription::create($input);

        return redirect('subscription/view')->with('success','New Subscription has been added.');
    }

    public function edit($id)
    {
        $id = decrypt($id);
        $subscription = Subscription::find($id);

        return view('dashboard.subscriptions.edit', compact('subscription'));
    }

    public function update(Request $request, $id)
    {
        $id = decrypt($id);
        $input = $request->except('_token');

        Subscription::find($id)->update($input);
        
        return redirect('subscription/view')->with('success','Subscription has been updated.');
    }

    public function destroy($id)
    {
        $id = decrypt($id);

        $UserHasSubscription = UserSubscription::where('subscription_id',$id)->get();
        
        if ($UserHasSubscription->isNotEmpty()) {
            return back()->with('warning', 'Can not delete this subscription, Users are Subscribed with this Subscription!');
        }

        Subscription::find($id)->delete();

        return back()->with('success','Subscription has been deleted');
    }
}
