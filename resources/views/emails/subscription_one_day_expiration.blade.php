<p>Hi, {{$name}}</p>

<p>Your Subscription bucket ({{$user_subscription->subscription->name}}) will expire in one day ({{ \Carbon\Carbon::parse($user_subscription->end_date)->format('d-F-Y') }}). Your subscription has remaining weight of {{ number_format($user_subscription->remaining_weight, 0) }} Kg. </p>

<p>Kindly Renew your Subscription before tommorrow, to add up your remaining weight for the next month. By clicking on this <a href="{{ url('/subscription/view') }}">link</a> here.</p>

<p>Regards,</p>
<p>Wizz Express & Logistics</p>