@php
  $NewSubsciptions = \App\Models\UserSubscription::where('notify_subscribed', '1')->get();
@endphp

<nav class="navbar">
  <a href="#" class="sidebar-toggler">
    <i data-feather="menu"></i>
  </a>
  <div class="navbar-content">
    <ul class="navbar-nav">
      @role('Super Admin')
      <li style="margin-right:15px;" class="nav-item dropdown nav-notifications">
        <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i data-feather="bell"></i>
          <div @if(count($NewSubsciptions)) class="indicator" @endif>
            <div class="circle"></div>
          </div>
        </a>
        <div class="dropdown-menu" aria-labelledby="notificationDropdown">
          <div class="dropdown-header d-flex align-items-center justify-content-between">
            <p class="mb-0 font-weight-medium">{{ count($NewSubsciptions) }} New Notifications</p>
          </div>
          <div class="dropdown-body">
            @foreach($NewSubsciptions as $serial => $subscription)
            <a href="{{ url('/user-subscription/view')}}" class="dropdown-item">
              <div class="icon">
                <i data-feather="trello"></i>
              </div>
              <div class="content">
                <p>{{ $subscription->user->name }} subscribed for {{ $subscription->subscription->name }} Bucket!</p>
                <p class="sub-text text-muted">{{ $subscription->created_at->diffForHumans() }}</p>
              </div>
            </a>
          @endforeach
          </div>
        </div>
      </li>
    @else
      <li style="margin-right:15px;" class="nav-item dropdown nav-notifications">
        <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i data-feather="bell"></i>
          <div @if(0) class="indicator" @endif>
            <div class="circle"></div>
          </div>
        </a>
        <div class="dropdown-menu" aria-labelledby="notificationDropdown">
          <div class="dropdown-header d-flex align-items-center justify-content-between">
            <p class="mb-0 font-weight-medium">0 New Notifications</p>
          </div>
          <div class="dropdown-body">
            <a class="dropdown-item">
              <div class="content">
                <p>No New Notifications</p>
              </div>
            </a>
          </div>
        </div>
      </li>
    @endrole
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
                <a href="{{ url('/general/profile') }}" class="nav-link">
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