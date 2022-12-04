@php
  //Super Admin, Admin Notifications
  $NewSubsciptions = \App\Models\UserSubscription::where('notify_subscribed', '1')->get();
  $TripStarted = \App\Models\Trip::where('notify_start', '1')->get();
  $TripFinish = \App\Models\Trip::where('notify_complete', '1')->get();
  $AssignedTrips = \App\Models\Trip::where('status', 'In Queue')->get();
  $PaidOrders = \App\Models\Order::where('notify_paid', 1)->get();
  
  //User Notification
  $StartedOrders = \Auth::user()->orders->where('notify_start', 1);
  $InProgressOrders = \Auth::user()->orders->where('notify_in_progress', 1);
  $CompletedOrders = \Auth::user()->orders->where('notify_complete', 1);
  
  //Driver Notifications
  $DriverStartTrip = 0;
  foreach ($AssignedTrips as $key => $trip) {
    if ($trip->vehicle->driver->id == Auth::id()) {
      $DriverStartTrip++;
    }
  }
  
@endphp

<nav class="navbar">
  <a href="#" class="sidebar-toggler">
    <i data-feather="menu"></i>
  </a>
  <div class="navbar-content">
    <ul class="navbar-nav">

      <!-- Chat Messenger -->
      <li class="nav-item dropdown nav-apps">
        <a class="nav-link" target="_blank" href="{{ url('/chat') }}">
          <i data-feather="message-square"></i>
        </a>
      </li>

      <!-- Notifications for Super Admin & Admin -->
      @hasanyrole('Super Admin|Admin')
      <li style="margin-right:15px;" class="nav-item dropdown nav-notifications">
        <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i data-feather="bell"></i>
          <div @if(count($NewSubsciptions) || count($TripStarted) || count($TripFinish) || count($PaidOrders)) class="indicator" @endif>
            <div class="circle"></div>
          </div>
        </a>
        <div class="dropdown-menu" aria-labelledby="notificationDropdown">
          <div class="dropdown-header d-flex align-items-center justify-content-between">
            <p class="mb-0 font-weight-medium">{{ count($NewSubsciptions) + count($TripStarted) + count($TripFinish) + count($PaidOrders) }} New Notifications</p>
          </div>
          <div class="dropdown-body">
            
            <!-- New Subscriptions Notifications-->
            @foreach($NewSubsciptions as $serial => $subscription)
            <a href="{{ url('/user-subscription/view')}}" class="dropdown-item">
              <div class="icon">
                <i data-feather="shopping-bag"></i>
              </div>
              <div class="content">
                <p>{{ $subscription->user->name }} subscribed for {{ $subscription->subscription->name }} Bucket!</p>
                <p class="sub-text text-muted">{{ $subscription->created_at->diffForHumans() }}</p>
              </div>
            </a>
          @endforeach

          <!-- Paid Orders Notifications-->
          @foreach($PaidOrders as $serial => $order)
          <a href="{{ url('/order/view')}}" class="dropdown-item">
            <div class="icon">
              <i data-feather="shopping-cart"></i>
            </div>
            <div class="content">
              <p>Order#{{ $order->id }} of Rs {{ number_format($order->items->sum('price'), 0) }} has been paid!</p>
              <p class="sub-text text-muted">{{ $order->updated_at->diffForHumans() }}</p>
            </div>
          </a>
          @endforeach

          <!-- Trip Start Notifications-->
          @foreach($TripStarted as $serial => $tripStart)
          <a href="{{ url('/trip/view')}}" class="dropdown-item">
            <div class="icon">
              <i data-feather="truck"></i>
            </div>
            <div class="content">
              <p>{{ $tripStart->vehicle->name }} trip started for {{ $tripStart->route->name }}!</p>
              <p class="sub-text text-muted">{{ $tripStart->created_at->diffForHumans() }}</p>
            </div>
          </a>
          @endforeach

        <!-- Trip Finish Notifications-->
        @foreach($TripFinish as $serial => $tripFinish)
        <a href="{{ url('/trip/view')}}" class="dropdown-item">
          <div class="icon">
            <i data-feather="check-square"></i>
          </div>
          <div class="content">
            <p>{{ $tripFinish->vehicle->name }} trip completed for {{ $tripFinish->route->name }}!</p>
            <p class="sub-text text-muted">{{ $tripFinish->updated_at->diffForHumans() }}</p>
          </div>
        </a>
        @endforeach

        <!-- If Empty Notifications-->
        @if ($TripFinish->isEmpty() && $TripStarted->isEmpty() && $NewSubsciptions->isEmpty() && $PaidOrders->isEmpty())
        <a class="dropdown-item">
          <div class="content">
            <p>No New Notifications</p>
          </div>
        </a>                
        @endif

          </div>
        </div>
      </li>
      @endhasanyrole

      <!-- Notifications for User -->
      @hasrole('User')
      <li style="margin-right:15px;" class="nav-item dropdown nav-notifications">
        <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i data-feather="bell"></i>
          <div @if(count($StartedOrders) || count($InProgressOrders) || count($CompletedOrders) ) class="indicator" @endif>
            <div class="circle"></div>
          </div>
        </a>
        <div class="dropdown-menu" aria-labelledby="notificationDropdown">
          <div class="dropdown-header d-flex align-items-center justify-content-between">
            <p class="mb-0 font-weight-medium">{{ count($StartedOrders) + count($InProgressOrders) + count($CompletedOrders) }} New Notifications</p>
          </div>
          <div class="dropdown-body">

          <!-- Order Started Notification -->
          @foreach($StartedOrders as $serial => $order)
              <a href="{{ url('/order/view')}}" class="dropdown-item">
                <div class="icon">
                  <i data-feather="package"></i>
                </div>
                <div class="content">
                  <p>Order#{{$order->id}} has been started!</p>
                  <p class="sub-text text-muted">{{ $order->created_at->diffForHumans() }}</p>
                </div>
              </a>
          @endforeach

          <!-- Order In Progress Notification -->
          @foreach($InProgressOrders as $serial => $order)
              <a href="{{ url('/order/view')}}" class="dropdown-item">
                <div class="icon">
                  <i data-feather="truck"></i>
                </div>
                <div class="content">
                  <p>Order#{{$order->id}} has been shipped!</p>
                  <p class="sub-text text-muted">{{ $order->created_at->diffForHumans() }}</p>
                </div>
              </a>
          @endforeach

          <!-- Order In Progress Notification -->
          @foreach($CompletedOrders as $serial => $order)
              <a href="{{ url('/order/view')}}" class="dropdown-item">
                <div class="icon">
                  <i data-feather="check-square"></i>
                </div>
                <div class="content">
                  <p>Order#{{$order->id}} has been completed!</p>
                  <p class="sub-text text-muted">{{ $order->created_at->diffForHumans() }}</p>
                </div>
              </a>
          @endforeach

          <!-- If Empty Notifications-->
          @if ($StartedOrders->isEmpty() && $InProgressOrders->isEmpty() && $CompletedOrders->isEmpty())
          <a class="dropdown-item">
            <div class="content">
              <p>No New Notifications</p>
            </div>
          </a>                
          @endif

          </div>
        </div>
      </li>
      @endhasrole

      <!-- Notifications for Driver -->
      @hasrole('Driver')
      <li style="margin-right:15px;" class="nav-item dropdown nav-notifications">
        <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i data-feather="bell"></i>
          <div @if($DriverStartTrip) class="indicator" @endif>
            <div class="circle"></div>
          </div>
        </a>
        <div class="dropdown-menu" aria-labelledby="notificationDropdown">
          <div class="dropdown-header d-flex align-items-center justify-content-between">
            <p class="mb-0 font-weight-medium">{{ $DriverStartTrip }} New Notifications</p>
          </div>
          <div class="dropdown-body">

          <!-- Trip Start Notifications-->
          @foreach($AssignedTrips as $serial => $tripStart)
            @if ($tripStart->vehicle->driver->id == Auth::id())
              <a href="{{ url('/trip/view')}}" class="dropdown-item">
                <div class="icon">
                  <i data-feather="truck"></i>
                </div>
                <div class="content">
                  <p>You have been assigned a trip from {{ $tripStart->route->name }} with {{ $tripStart->vehicle->name }}!</p>
                  <p class="sub-text text-muted">{{ $tripStart->created_at->diffForHumans() }}</p>
                </div>
              </a>      
            @endif
          @endforeach

          <!-- If Empty Notifications-->
          @if ($AssignedTrips->isEmpty())
          <a class="dropdown-item">
            <div class="content">
              <p>No New Notifications</p>
            </div>
          </a>                
          @endif

          </div>
        </div>
      </li>
      @endhasrole

      <li class="nav-item dropdown nav-profile">
        <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img src="{{asset('assets/images/'.Auth::user()->image)}}" alt="profile">
        </a>
        <div class="dropdown-menu" aria-labelledby="profileDropdown">
          <div class="dropdown-header d-flex flex-column align-items-center">
            <div class="figure mb-3">
              <img src="{{asset('assets/images/'.Auth::user()->image)}}" alt="">
            </div>
            <div class="info text-center">
                <p class="name font-weight-bold mb-0">{{Auth::user()->name}}</p>
              <p class="email text-muted mb-3">{{Auth::user()->email}}</p>
            </div>
          </div>
          <div class="dropdown-body">
            <ul class="profile-nav p-0 pt-3">
              <li class="nav-item pb-1">
                <a href="{{ url('/profile/view') }}" class="nav-link">
                  <i data-feather="user"></i>
                  <span>Profile</span>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('logout') }}" 
                      onclick="event.preventDefault();
                      document.getElementById('logout-form').submit();" class="nav-link">
                  <i data-feather="log-out"></i>
                  <span>Log Out</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
              </li>
            </ul>
          </div>
        </div>
      </li>
    </ul>
  </div>
</nav>