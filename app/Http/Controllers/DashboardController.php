<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\UserSubscription;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use AmrShawky\LaravelCurrency\Facade\Currency;

class DashboardController extends Controller
{
    public function index()
    {
        if(\Auth::user()->hasAnyRole(['Super Admin','Admin'])){
            //Intializing Dates
            $start_date = Carbon::now()->subMonth(1)->format('d-F-Y');
            $end_date = Carbon::now()->format('d-F-Y');
            
        //++++++++++++++++++++++ Customer Figures Calculation Start ++++++++++++++++++++++//
            
            //Last Month Customers
            $last_month_customers = User::role('User')
            ->whereBetween('created_at', [Carbon::now()->subMonth(2), Carbon::now()->subMonth(1)])
            ->count();

            //Current Month Customers
            $current_month_customers = User::role('User')
            ->whereBetween('created_at', [Carbon::now()->subMonth(1), Carbon::now()])
            ->count();

            //Growth Rate of Customers comparing Last Month to Current Month
            if($last_month_customers == 0){
                $CustomersGrowthPercentage = 0;
            }else{
                $CustomersGrowthPercentage = ($current_month_customers/$last_month_customers)*100;
            }

            //Calculating Customers Growth Percentage
            if ($CustomersGrowthPercentage >= 0) {
                $CustomerSign = 'Positive';
            }else{
                $CustomerSign = 'Negative';
            }
            
            $CustomerArray = array(
                'CurrentMonthCustomers' => $current_month_customers,
                'CustomersGrowthPercentage' => $CustomersGrowthPercentage,
                'CustomerSign' => $CustomerSign,
            );

        //++++++++++++++++++++++ Customer Figures Calculation End ++++++++++++++++++++++//


        //++++++++++++++++++++++ Subscription Figures Calculation Start ++++++++++++++++++++++//

            //Last Month Subscriptions
            $last_month_subscriptions = UserSubscription::whereBetween('created_at', [Carbon::now()->subMonth(2), Carbon::now()->subMonth(1)])
            ->where('status', 'Subscribed')
            ->count();

            //Current Month Subscriptions
            $current_month_subscriptions = UserSubscription::whereBetween('created_at', [Carbon::now()->subMonth(1), Carbon::now()])
            ->where('status', 'Subscribed')
            ->count();

            //Growth Rate of Subscriptions comparing Last Month to Current Month
            if($last_month_subscriptions == 0){
                $SubscriptionGrowthPercentage = 0;
            }else{
                $SubscriptionGrowthPercentage = ($current_month_subscriptions/$last_month_subscriptions)*100;
            }

            //Calculating Subscription Growth Percentage
            if ($SubscriptionGrowthPercentage >= 0) {
                $SubscriptionSign = 'Positive';
            }else{
                $SubscriptionSign = 'Negative';
            }
            
            $SubscriptionArray = array(
                'CurrentMonthSubscriptions' => $current_month_subscriptions,
                'SubscriptionGrowthPercentage' => $SubscriptionGrowthPercentage,
                'SubscriptionSign' => $SubscriptionSign,
            );

        //++++++++++++++++++++++ Subscription Figures Calculation End ++++++++++++++++++++++//


        //++++++++++++++++++++++ Revenue Figures Calculation Start ++++++++++++++++++++++//

            //Calculating Last Month Orders
            $last_month_orders = Order::with('items')->whereBetween('created_at', [Carbon::now()->subMonth(2), Carbon::now()->subMonth(1)])->where('status', 'Complete')->get();

            //Calculating Last Month Orders Revenue
            $last_month_revenue = 0;
            foreach ($last_month_orders as $order) {
                $last_month_revenue += $order->items->sum('price');
            }

            //Calculating Current Month Orders Revenue
            $current_month_orders = Order::with('items')->whereBetween('created_at', [Carbon::now()->subMonth(1), Carbon::now()])->where('status', 'Complete')->get();

            //Calculating Current Month Order Revenue
            $current_month_revenue = 0;
            foreach ($current_month_orders as $order) {
                $current_month_revenue += $order->items->sum('price');
            }

            // Converting PKR to USD Revenue;
            $CurrentMonthDollarRevenue = Currency::convert()->from('PKR')->to('USD')->amount($current_month_revenue)->get();

            //Growth Rate of Revenue comparing Last Month to Current Month
            if($last_month_revenue == 0){
                $RevenueGrowthPercentage = 0;
            }else{
                $RevenueGrowthPercentage = ($current_month_revenue/$last_month_revenue)*100;
            }

            //Calculating Revenue Growth Percentage
            if ($RevenueGrowthPercentage >= 0) {
                $RevenueSign = 'Positive';
            }else{
                $RevenueSign = 'Negative';
            }

            $RevenueArray = array(
                'CurrentMonthDollarRevenue' => $CurrentMonthDollarRevenue,
                'RevenueGrowthPercentage' => $RevenueGrowthPercentage,
                'RevenueSign' => $RevenueSign,
            );

        //++++++++++++++++++++++ Revenue Figures Calculation End ++++++++++++++++++++++//

        //++++++++++++++++++++++ Order Statistics Query Start +++++++++++++++++++++++++//

        $OrderStatisticsData = DB::select('
        SELECT s.status, COUNT(s.id) AS "count"
        FROM orders s
        WHERE s.created_at BETWEEN "'.Carbon::now()->subMonth(1).'" AND "'.Carbon::now().'"
        GROUP BY s.status

        ORDER BY s.status');
            
        $OrderStatisticsArray = json_decode(json_encode($OrderStatisticsData), true);
        // HAVING s.status IN ("Confirmed", "Paid")
        // dd($OrderStatisticsArray);

        //++++++++++++++++++++++ Order Statistics Query End +++++++++++++++++++++++++//


        //++++++++++++++++++++++ Order Booked By Query Start +++++++++++++++++++++++++//

        $OrderBookedByData = DB::select('
        SELECT u.name, u.color, COUNT(s.id) AS "count"
        FROM orders s
        JOIN users u ON u.id = s.booked_by
        WHERE s.created_at BETWEEN "'.Carbon::now()->subMonth(1).'" AND "'.Carbon::now().'"
        GROUP BY u.id
        ORDER BY u.name');
            
        $OrderBookedByArray = json_decode(json_encode($OrderBookedByData), true);
        // dd($OrderBookedByArray);

        //++++++++++++++++++++++ Order Statistics Query End +++++++++++++++++++++++++//
        
        return view('dashboard.dashboard', compact('start_date', 'end_date','CustomerArray','SubscriptionArray','RevenueArray','OrderStatisticsArray','OrderBookedByArray'));

        }else{
            return redirect('/profile/view');
        }
    }

    public function filter(Request $request)
    {
        if(\Auth::user()->hasAnyRole(['Super Admin','Admin'])){
            //Intializing Dates
            $start_date = Carbon::parse($request->input('start_date'))->format('d-F-Y');
            $end_date = Carbon::parse($request->input('end_date'))->format('d-F-Y');

            //Filter Dates
            $filter_start_date = Carbon::parse($request->input('start_date'))->format('Y-m-d');
            $filter_end_date = Carbon::parse($request->input('end_date'))->format('Y-m-d');
            
        //++++++++++++++++++++++ Customer Figures Calculation Start ++++++++++++++++++++++//
            
            //Last Month Customers
            $last_month_customers = User::role('User')
            ->whereBetween('created_at', [Carbon::now()->subMonth(2), Carbon::now()->subMonth(1)])
            ->count();

            //Current Month Customers
            $current_month_customers = User::role('User')
            ->whereBetween('created_at', [$filter_start_date, $filter_end_date])
            ->count();

            //Growth Rate of Customers comparing Last Month to Current Month
            if($last_month_customers == 0){
                $CustomersGrowthPercentage = 0;
            }else{
                $CustomersGrowthPercentage = ($current_month_customers/$last_month_customers)*100;
            }

            //Calculating Customers Growth Percentage
            if ($CustomersGrowthPercentage >= 0) {
                $CustomerSign = 'Positive';
            }else{
                $CustomerSign = 'Negative';
            }
            
            $CustomerArray = array(
                'CurrentMonthCustomers' => $current_month_customers,
                'CustomersGrowthPercentage' => $CustomersGrowthPercentage,
                'CustomerSign' => $CustomerSign,
            );

        //++++++++++++++++++++++ Customer Figures Calculation End ++++++++++++++++++++++//


        //++++++++++++++++++++++ Subscription Figures Calculation Start ++++++++++++++++++++++//

            //Last Month Subscriptions
            $last_month_subscriptions = UserSubscription::whereBetween('created_at', [Carbon::now()->subMonth(2), Carbon::now()->subMonth(1)])
            ->where('status', 'Subscribed')
            ->count();

            //Current Month Subscriptions
            $current_month_subscriptions = UserSubscription::whereBetween('created_at', [$filter_start_date, $filter_end_date])
            ->where('status', 'Subscribed')
            ->count();

            //Growth Rate of Subscriptions comparing Last Month to Current Month
            if($last_month_subscriptions == 0){
                $SubscriptionGrowthPercentage = 0;
            }else{
                $SubscriptionGrowthPercentage = ($current_month_subscriptions/$last_month_subscriptions)*100;
            }

            //Calculating Subscription Growth Percentage
            if ($SubscriptionGrowthPercentage >= 0) {
                $SubscriptionSign = 'Positive';
            }else{
                $SubscriptionSign = 'Negative';
            }
            
            $SubscriptionArray = array(
                'CurrentMonthSubscriptions' => $current_month_subscriptions,
                'SubscriptionGrowthPercentage' => $SubscriptionGrowthPercentage,
                'SubscriptionSign' => $SubscriptionSign,
            );

        //++++++++++++++++++++++ Subscription Figures Calculation End ++++++++++++++++++++++//


        //++++++++++++++++++++++ Revenue Figures Calculation Start ++++++++++++++++++++++//

            //Calculating Last Month Orders
            $last_month_orders = Order::with('items')->whereBetween('created_at', [Carbon::now()->subMonth(2), Carbon::now()->subMonth(1)])->where('status', 'Complete')->get();

            //Calculating Last Month Orders Revenue
            $last_month_revenue = 0;
            foreach ($last_month_orders as $order) {
                $last_month_revenue += $order->items->sum('price');
            }

            //Calculating Current Month Orders Revenue
            $current_month_orders = Order::with('items')->whereBetween('created_at', [$filter_start_date, $filter_end_date])->where('status', 'Complete')->get();

            //Calculating Current Month Order Revenue
            $current_month_revenue = 0;
            foreach ($current_month_orders as $order) {
                $current_month_revenue += $order->items->sum('price');
            }

            // Converting PKR to USD Revenue;
            $CurrentMonthDollarRevenue = Currency::convert()->from('PKR')->to('USD')->amount($current_month_revenue)->get();

            //Growth Rate of Revenue comparing Last Month to Current Month
            if($last_month_revenue == 0){
                $RevenueGrowthPercentage = 0;
            }else{
                $RevenueGrowthPercentage = ($current_month_revenue/$last_month_revenue)*100;
            }

            //Calculating Revenue Growth Percentage
            if ($RevenueGrowthPercentage >= 0) {
                $RevenueSign = 'Positive';
            }else{
                $RevenueSign = 'Negative';
            }

            $RevenueArray = array(
                'CurrentMonthDollarRevenue' => $CurrentMonthDollarRevenue,
                'RevenueGrowthPercentage' => $RevenueGrowthPercentage,
                'RevenueSign' => $RevenueSign,
            );

        //++++++++++++++++++++++ Revenue Figures Calculation End ++++++++++++++++++++++//

        //++++++++++++++++++++++ Order Statistics Query Start +++++++++++++++++++++++++//

        $OrderStatisticsData = DB::select('
        SELECT s.status, COUNT(s.id) AS "count"
        FROM orders s
        WHERE s.created_at BETWEEN "'.$filter_start_date.'" AND "'.$filter_end_date.'"
        GROUP BY s.status

        ORDER BY s.status');

        $OrderStatisticsArray = json_decode(json_encode($OrderStatisticsData), true);
        // HAVING s.status IN ("Confirmed", "Paid")
        // dd($OrderStatisticsArray);

        //++++++++++++++++++++++ Order Statistics Query End +++++++++++++++++++++++++//


        //++++++++++++++++++++++ Order Booked By Query Start +++++++++++++++++++++++++//

        $OrderBookedByData = DB::select('
        SELECT u.name, u.color, COUNT(s.id) AS "count"
        FROM orders s
        JOIN users u ON u.id = s.booked_by
        WHERE s.created_at BETWEEN "'.$filter_start_date.'" AND "'.$filter_end_date.'"
        GROUP BY u.id
        ORDER BY u.name');
            
        $OrderBookedByArray = json_decode(json_encode($OrderBookedByData), true);
        // dd($OrderBookedByArray);

        //++++++++++++++++++++++ Order Statistics Query End +++++++++++++++++++++++++//
        
        return view('dashboard.dashboard', compact('start_date', 'end_date','CustomerArray','SubscriptionArray','RevenueArray','OrderStatisticsArray','OrderBookedByArray'));

        }else{
            return redirect('/profile/view');
        }
    }
}
