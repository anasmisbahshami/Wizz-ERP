<p>Hi, {{$name}}</p>

<p>Your Order# W-{{$order->id}} has been completed! Thank you for utilizing our service, for promotions and  discount offers stay tuned to our <a href="{{ url('/') }}">website.</a></p>

<p>If you wish to recieve our latest offers <a href="{{url('news/letter/subscribe/'.encrypt($order->user->id))}}">click here</a> to subscribe to our news letter!</p>

<p>Regards,</p>
<p>Wizz Express & Logistics</p>