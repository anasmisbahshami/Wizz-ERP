<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="shortcut icon" href="{{ asset('/assets/images/logo.png') }}">
    <title>Order Confirmed | W-{{$order->id}}</title>
</head>
<body style="background-color: #eeeeee;">
    <div class="row">
        <div align="center" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 25px;">
            <img src="https://img.icons8.com/carbon-copy/100/000000/checked-checkbox.png" width="125" height="120" style="display: block; border: 0px;" />
            <h2 style="font-size: 30px; font-weight: 800; line-height: 36px; color: #333333; margin: 0;">
                Order Confirmed!
            </h2>
        </div>
    </div>
</body>
<script>
    $(document).ready(function(){
        setTimeout(function(){
            window.location.replace('http://127.0.0.1:8000/order/view');
        }, 3000);
    })
</script>
</html>