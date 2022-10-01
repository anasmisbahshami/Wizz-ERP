<p>Hi, {{$name}}</p>

<p>Your Order# W-{{$order->id}} is in progress! Track your order by clicking on this <a href="{{ url('/order/track/'.$order->tracking_code) }}">link</a> here.</p>

<p>Regards,</p>
<p>Wizz Express & Logistics</p>