<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

    //Routes Without Middleware
    Route::get('/order/confirm/{id}', [App\Http\Controllers\OrderBookingController::class, 'confirm_order']);
    Route::get('/order/track/{id}', [App\Http\Controllers\OrderTrackingController::class, 'user_tracking']);

Route::group(['middleware' => 'auth', 'prevent-back-history'], function () {
    
    //Trigger Daily Notifications
    Route::get('/trigger', function () {
        Artisan::call('daily:update');
        return ('All Notifications Sent!');
    });
    
    //Home Route
    Route::get('/', [App\Http\Controllers\DashboardController::class, 'index']);
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'filter']);

    //User Profile Routes
    Route::get('/profile/view', [App\Http\Controllers\UserProfileController::class, 'view']);

    //Role Routes
    Route::get('/role/view', [App\Http\Controllers\RoleController::class, 'view'])->middleware('can:View Role');
    Route::get('/role/add', [App\Http\Controllers\RoleController::class, 'create'])->middleware('can:Add Role');
    Route::post('/role/store', [App\Http\Controllers\RoleController::class, 'store'])->middleware('can:Add Role');
    Route::get('/role/edit/{id}', [App\Http\Controllers\RoleController::class, 'edit'])->middleware('can:Edit Role');
    Route::post('/role/update/{id}', [App\Http\Controllers\RoleController::class, 'update'])->middleware('can:Edit Role');
    Route::get('/role/destroy/{id}', [App\Http\Controllers\RoleController::class, 'destroy'])->middleware('can:Delete Role');
    Route::post('/role/role_check', [App\Http\Controllers\RoleController::class, 'role_check']);
    
    //User Routes
    Route::get('/user/view', [App\Http\Controllers\UserController::class, 'view'])->middleware('can:View User');
    Route::get('/user/add', [App\Http\Controllers\UserController::class, 'create'])->middleware('can:Add User');
    Route::post('/user/store', [App\Http\Controllers\UserController::class, 'store'])->middleware('can:Add User');
    Route::get('/user/edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->middleware('can:Edit User');
    Route::post('/user/update/{id}', [App\Http\Controllers\UserController::class, 'update'])->middleware('can:Edit User');
    Route::get('/user/destroy/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->middleware('can:Delete User');

    //Vehicle Routes
    Route::get('/vehicle/view', [App\Http\Controllers\VehicleController::class, 'view'])->middleware('can:View Vehicle');
    Route::get('/vehicle/add', [App\Http\Controllers\VehicleController::class, 'create'])->middleware('can:Add Vehicle');
    Route::post('/vehicle/store', [App\Http\Controllers\VehicleController::class, 'store'])->middleware('can:Add Vehicle');
    Route::get('/vehicle/edit/{id}', [App\Http\Controllers\VehicleController::class, 'edit'])->middleware('can:Edit Vehicle');
    Route::post('/vehicle/update/{id}', [App\Http\Controllers\VehicleController::class, 'update'])->middleware('can:Edit Vehicle');
    Route::get('/vehicle/destroy/{id}', [App\Http\Controllers\VehicleController::class, 'destroy'])->middleware('can:Delete Vehicle');

    //Routeway Routes
    Route::get('/route/view', [App\Http\Controllers\RouteController::class, 'view'])->middleware('can:View Route');
    Route::get('/route/add', [App\Http\Controllers\RouteController::class, 'create'])->middleware('can:Add Route');
    Route::post('/route/store', [App\Http\Controllers\RouteController::class, 'store'])->middleware('can:Add Route');
    Route::get('/route/edit/{id}', [App\Http\Controllers\RouteController::class, 'edit'])->middleware('can:Edit Route');
    Route::post('/route/update/{id}', [App\Http\Controllers\RouteController::class, 'update'])->middleware('can:Edit Route');
    Route::get('/route/destroy/{id}', [App\Http\Controllers\RouteController::class, 'destroy'])->middleware('can:Delete Route');
    Route::post('/city/store', [App\Http\Controllers\RouteController::class, 'city_store'])->middleware('can:Add City');

    //Subscription Routes
    Route::get('/subscription/view', [App\Http\Controllers\SubscriptionController::class, 'view'])->middleware('can:View Subscription');
    Route::get('/subscription/add', [App\Http\Controllers\SubscriptionController::class, 'create'])->middleware('can:Add Subscription');
    Route::post('/subscription/store', [App\Http\Controllers\SubscriptionController::class, 'store'])->middleware('can:Add Subscription');
    Route::get('/subscription/edit/{id}', [App\Http\Controllers\SubscriptionController::class, 'edit'])->middleware('can:Edit Subscription');
    Route::post('/subscription/update/{id}', [App\Http\Controllers\SubscriptionController::class, 'update'])->middleware('can:Edit Subscription');
    Route::get('/subscription/destroy/{id}', [App\Http\Controllers\SubscriptionController::class, 'destroy'])->middleware('can:Delete Subscription');

    //User Subscription Routes
    Route::get('/user-subscription/view', [App\Http\Controllers\UserSubscriptionController::class, 'view'])->middleware('can:View User Subscription');
    Route::get('/user-subscription/add', [App\Http\Controllers\UserSubscriptionController::class, 'create'])->middleware('can:Add User Subscription');
    Route::post('/user-subscription/store', [App\Http\Controllers\UserSubscriptionController::class, 'store'])->middleware('can:Add User Subscription');
    Route::get('/user-subscription/edit/{id}', [App\Http\Controllers\UserSubscriptionController::class, 'edit'])->middleware('can:Edit User Subscription');
    Route::post('/user-subscription/update/{id}', [App\Http\Controllers\UserSubscriptionController::class, 'update'])->middleware('can:Edit User Subscription');
    Route::get('/user-subscription/destroy/{id}', [App\Http\Controllers\UserSubscriptionController::class, 'destroy'])->middleware('can:Delete User Subscription');
    Route::get('/user-subscription/mail/{id}', [App\Http\Controllers\UserSubscriptionController::class, 'renew_mail'])->middleware('can:Renewal Mail User Subscription');
    Route::get('/user-subscription/acknowledge/{id}', [App\Http\Controllers\UserSubscriptionController::class, 'acknowledge'])->middleware('can:Acknowledge User Subscription');
    Route::get('/user/subscribe/{id}', [App\Http\Controllers\UserSubscriptionController::class, 'user_subscribe'])->middleware('can:View Subscription');

    //Trip Routes
    Route::get('/trip/view', [App\Http\Controllers\TripController::class, 'view'])->middleware('can:View Trip');
    Route::get('/trip/add', [App\Http\Controllers\TripController::class, 'create'])->middleware('can:Add Trip');
    Route::post('/trip/store', [App\Http\Controllers\TripController::class, 'store'])->middleware('can:Add Trip');
    Route::get('/trip/edit/{id}', [App\Http\Controllers\TripController::class, 'edit'])->middleware('can:Edit Trip');
    Route::post('/trip/update/{id}', [App\Http\Controllers\TripController::class, 'update'])->middleware('can:Edit Trip');
    Route::get('/trip/destroy/{id}', [App\Http\Controllers\TripController::class, 'destroy'])->middleware('can:Delete Trip');
    Route::post('/trip/get/rate', [App\Http\Controllers\TripController::class, 'get_rate'])->name('getRate');
    Route::get('/trip/acknowledge/{id}', [App\Http\Controllers\TripController::class, 'acknowledge'])->middleware('can:Acknowledge Trip');
    Route::get('/trip/start/{id}', [App\Http\Controllers\TripController::class, 'start'])->middleware('can:Edit Trip Status');
    Route::get('/trip/complete/{id}', [App\Http\Controllers\TripController::class, 'complete'])->middleware('can:Edit Trip Status');
    Route::get('/trip/gps/coordinates/{id}', [App\Http\Controllers\TripController::class, 'current_gps_coordinates'])->middleware('can:GPS Coordinates Trip');

    //Bill Routes
    Route::get('/bill/view', [App\Http\Controllers\BillController::class, 'view'])->middleware('can:View Bill');
    Route::post('/bill/generate/monthly/statement', [App\Http\Controllers\BillController::class, 'monthly_generate'])->middleware('can:Generate Monthly Bill');
    Route::post('/bill/generate/monthly/range/statement', [App\Http\Controllers\BillController::class, 'monthly_range_generate'])->middleware('can:Generate Monthly Range Bill');
    Route::post('/bill/generate/date/range/statement', [App\Http\Controllers\BillController::class, 'date_range_generate'])->middleware('can:Generate Date Range Bill');

    //Order Routes
    Route::get('/order/view', [App\Http\Controllers\OrderController::class, 'view'])->middleware('can:View Order');
    Route::get('/order/invoice/{id}', [App\Http\Controllers\OrderController::class, 'download_invoice'])->middleware('can:Download Order Invoice');
    Route::get('/order/destroy/{id}', [App\Http\Controllers\OrderController::class, 'destroy_order'])->middleware('can:Delete Order');
    Route::get('/order/view/items/{id}', [App\Http\Controllers\OrderController::class, 'view_order_details'])->middleware('can:View Order Details');
    Route::get('/order/edit/items/{id}', [App\Http\Controllers\OrderController::class, 'edit_order_details'])->middleware('can:Edit Order Details');
    Route::post('/order/paid/{id}', [App\Http\Controllers\OrderController::class, 'order_paid'])->middleware('can:Edit Order Details');
    Route::get('/order/start/{id}', [App\Http\Controllers\OrderController::class, 'order_start'])->middleware('can:Edit Order Details');
    Route::get('/order/in/progress/{id}', [App\Http\Controllers\OrderController::class, 'order_in_progress'])->middleware('can:Edit Order Details');
    Route::get('/order/complete/{id}', [App\Http\Controllers\OrderController::class, 'order_complete'])->middleware('can:Edit Order Details');
    Route::get('/order/acknowledge/{id}', [App\Http\Controllers\OrderController::class, 'acknowledge_order'])->middleware('can:Acknowledge Order');    
    Route::get('/order/paid/invoice/{id}', [App\Http\Controllers\OrderController::class, 'download_paid_invoice'])->middleware('can:View Order');
    
    //Order Booking
    Route::get('/order-book/view', [App\Http\Controllers\OrderBookingController::class, 'view'])->middleware('can:Book Order');
    Route::get('/order-book/add/{id}', [App\Http\Controllers\OrderBookingController::class, 'add'])->middleware('can:Book Order');    
    Route::get('/order-book/destroy/{id}', [App\Http\Controllers\OrderBookingController::class, 'destroy_order'])->middleware('can:Book Order');
    Route::post('/order-book/item/store', [App\Http\Controllers\OrderBookingController::class, 'add_order_item'])->middleware('can:Book Order');
    Route::get('/order-book/complete/{id}', [App\Http\Controllers\OrderBookingController::class, 'complete_order'])->middleware('can:Book Order');
    Route::get('/order-book/item/destroy/{id}', [App\Http\Controllers\OrderBookingController::class, 'destroy'])->middleware('can:Book Order');
    Route::post('/order-book/item/update/{id}', [App\Http\Controllers\OrderBookingController::class, 'update'])->middleware('can:Book Order');
    Route::post('/order-book/subscription/details', [App\Http\Controllers\OrderBookingController::class, 'subscription_details'])->name('getSubscriptionDetails')->middleware('can:Book Order');
    Route::post('/order-book/normal/details', [App\Http\Controllers\OrderBookingController::class, 'normal_details'])->name('getNormalDetails')->middleware('can:Book Order');

    //Order Tracking Routes
    Route::get('/order-track/view', [App\Http\Controllers\OrderTrackingController::class, 'view'])->middleware('can:Track Order');
    Route::post('/order-track/results', [App\Http\Controllers\OrderTrackingController::class, 'tracking_results'])->middleware('can:Track Order');

    //Job Routes
    Route::get('/job/view', [App\Http\Controllers\JobController::class, 'view'])->middleware('can:View Job');
    Route::get('/job/add', [App\Http\Controllers\JobController::class, 'create'])->middleware('can:Add Job');
    Route::post('/job/store', [App\Http\Controllers\JobController::class, 'store'])->middleware('can:Add Job');
    Route::get('/job/edit/{id}', [App\Http\Controllers\JobController::class, 'edit'])->middleware('can:Edit Job');
    Route::post('/job/update/{id}', [App\Http\Controllers\JobController::class, 'update'])->middleware('can:Edit Job');
    Route::get('/job/destroy/{id}', [App\Http\Controllers\JobController::class, 'destroy'])->middleware('can:Delete Job');
    
    //Job Applicant Routes
    Route::get('/job/view-applicant/{id}', [App\Http\Controllers\JobApplicantController::class, 'view'])->middleware('can:View Job Applicant');
    Route::get('/job/applicant-resume/{id}', [App\Http\Controllers\JobApplicantController::class, 'download_resume'])->middleware('can:View Job Applicant');
    Route::get('/job/applicant-delete/{id}', [App\Http\Controllers\JobApplicantController::class, 'delete_applicant'])->middleware('can:Delete Job Applicant');
    Route::post('/job/shortlist-applicant/{id}', [App\Http\Controllers\JobApplicantController::class, 'shortlist'])->middleware('can:Shortlist Job Applicant');

    //GPS Tracking Routes
    Route::get('/gps/view', [App\Http\Controllers\GPSTrackingController::class, 'view'])->middleware('can:View GPS');
    Route::get('/gps/track/{id}', [App\Http\Controllers\GPSTrackingController::class, 'track'])->middleware('can:Track GPS');
});