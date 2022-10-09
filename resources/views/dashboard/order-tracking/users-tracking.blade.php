<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Tracking | W-{{$order->id}}</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Open+Sans&display=swap');body{background-color: #eeeeee;font-family: 'Open Sans',serif}.container{margin-top:50px;margin-bottom: 50px}.card{position: relative;display: -webkit-box;display: -ms-flexbox;display: flex;-webkit-box-orient: vertical;-webkit-box-direction: normal;-ms-flex-direction: column;flex-direction: column;min-width: 0;word-wrap: break-word;background-color: #172128;border: 1px solid #262F36 !important;background-clip: border-box;border: 1px solid rgba(0, 0, 0, 0.1);border-radius: 0.10rem}.card-header:first-child{border-radius: calc(0.37rem - 1px) calc(0.37rem - 1px) 0 0}.card-header{padding: 0.75rem 1.25rem;margin-bottom: 0;background-color: #fff;border-bottom: 1px solid rgba(0, 0, 0, 0.1)}.track{position: relative;background-color: #ddd;height: 7px;display: -webkit-box;display: -ms-flexbox;display: flex;margin-bottom: 60px;margin-top: 50px}.track .step{-webkit-box-flex: 1;-ms-flex-positive: 1;flex-grow: 1;width: 25%;margin-top: -18px;text-align: center;position: relative}.track .step.active:before{background: #E09946}.track .step::before{height: 7px;position: absolute;content: "";width: 100%;left: 0;top: 18px}.track .step.active .icon{background: #E09946;color: #fff}.track .icon{display: inline-block;width: 40px;height: 40px;line-height: 40px;position: relative;border-radius: 100%;background: #ddd}.track .step.active .text{font-weight: 400;color: white}.track .text{display: block;margin-top: 7px}.itemside{position: relative;display: -webkit-box;display: -ms-flexbox;display: flex;width: 100%}.itemside .aside{position: relative;-ms-flex-negative: 0;flex-shrink: 0}.img-sm{width: 80px;height: 80px;padding: 7px}ul.row, ul.row-sm{list-style: none;padding: 0}.itemside .info{padding-left: 15px;padding-right: 7px}.itemside .title{display: block;margin-bottom: 5px;color: #212529}p{margin-top: 0;margin-bottom: 1rem}.btn-warning{color: #ffffff;background-color: #E09946;border-color: #E09946;border-radius: 1px}.btn-warning:hover{color: #ffffff;background-color: #E09946;border-color: #E09946;border-radius: 1px}
    </style>
</head>
<body style="background: #101920">
    <h3 style="text-align: center;margin-top:20px;color:white;text-decoration:underline;">Wizz Express & Logistics</h3>
 <div class="container">
    <article class="card">
        <div class="card-body">
            <h6 class="mb-3">Tracking ID: {{$order->tracking_code}}</h6>
            <article class="card">
                <div class="card-body row">
                    <div class="col"> <strong>Estimated Delivery time:</strong><br>{{\Carbon\Carbon::parse($order->created_at)->format('d F, Y')}}</div>
                    <div class="col"> <strong>Shipping BY:</strong><br>Wizz Express & Logistics</div>
                    <div class="col"> <strong>Status:</strong><br>{{$order->status}}</div>
                    <div class="col"> <strong>Tracking #:</strong><br>{{$order->tracking_code}}</div>
                </div>
            </article>
            <div class="track">
                <div class="step @if($order->status == 'Confirmed' || $order->status == 'Paid' || $order->status == 'Started' || $order->status == 'In progress' || $order->status == 'Complete') active @endif"><span class="icon"><i class="fa fa-check"></i></span><span class="text">Confirmed</span></div>
                <div class="step @if($order->status == 'Paid' || $order->status == 'Started' || $order->status == 'In progress' || $order->status == 'Complete') active @endif"><span class="icon"><i class="fa fa-coins"></i></span><span class="text">Paid</span></div>
                <div class="step @if($order->status == 'Started' || $order->status == 'In progress' || $order->status == 'Complete') active @endif"><span class="icon"><i class="fa fa-hourglass-start"></i></span><span class="text">Started</span> </div>
                <div class="step @if($order->status == 'In progress' || $order->status == 'Complete') active @endif"><span class="icon"><i class="fa fa-truck"></i></span><span class="text">In progress</span></div>
                <div class="step @if($order->status == 'Complete') active @endif"><span class="icon"><i class="fa fa-box"></i></span><span class="text">Complete</span></div>
            </div>
        </div>
    </article>
</div>
</body>
</html>