<nav class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
            <!-- <p style="font-family:akira; color:#E09946;line-height:1.0;">WIZZ</p> -->
            <img style="width:60px" src="{{ asset('assets/images/logo.png') }}">
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">

            {{-- Dashboard --}}
            <li class="nav-item nav-category">Main</li>
            <li class="nav-item {{ active_class(['/']) }}">
                <a href="{{ url('/') }}" class="nav-link">
                    <i class="link-icon" data-feather="airplay"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>

            {{-- User Management --}}
            @canany(['View Role', 'View User'])
                <li class="nav-item nav-category">User Management</li>
                @canany(['View Role'])
                    <li class="nav-item {{ active_class(['role/*']) }}">
                        <a href="{{ url('role/view') }}" class="nav-link">
                            <i class="link-icon" data-feather="sliders"></i>
                            <span class="link-title">Roles</span>
                        </a>
                    </li>
                @endcanany

                @canany(['View User'])
                    <li class="nav-item {{ active_class(['user/*']) }}">
                        <a href="{{ url('user/view') }}" class="nav-link">
                            <i class="link-icon" data-feather="users"></i>
                            <span class="link-title">Users</span>
                        </a>
                    </li>
                @endcanany
            @endcanany

            {{-- Route Way Management --}}
            @canany(['View Vehicle', 'View Route'])
                <li class="nav-item nav-category">Routeway Management</li>
                @canany(['View Vehicle'])
                    <li class="nav-item {{ active_class(['vehicle/*']) }}">
                        <a href="{{ url('vehicle/view') }}" class="nav-link">
                            <i class="link-icon" data-feather="truck"></i>
                            <span class="link-title">Vehicles</span>
                        </a>
                    </li>
                @endcanany

                @canany(['View Route'])
                    <li class="nav-item {{ active_class(['route/*']) }}">
                        <a href="{{ url('route/view') }}" class="nav-link">
                            <i class="link-icon fa fa-road"></i>
                            <span class="link-title">Routes</span>
                        </a>
                    </li>
                @endcanany
            @endcanany

            {{-- Subscription Management --}}
            @canany(['View Subscription', 'View User Subscription'])
                <li class="nav-item nav-category">Subscription Management</li>
                @canany(['View Subscription'])
                    <li class="nav-item {{ active_class(['subscription/*']) }}">
                        <a href="{{ url('subscription/view') }}" class="nav-link">
                            <i class="link-icon fa fa-credit-card"></i>
                            <span class="link-title">Subscriptions</span>
                        </a>
                    </li>
                @endcanany

                @canany(['View User Subscription'])
                    <li class="nav-item {{ active_class(['user-subscription/*']) }}">
                        <a href="{{ url('user-subscription/view') }}" class="nav-link">
                            <i class="link-icon fa fa-address-card"></i>
                            <span class="link-title">Users Subscriptions</span>
                        </a>
                    </li>
                @endcanany
            @endcanany

            {{-- Automated Manager --}}
            @canany(['View Trip', 'View Bill'])
                <li class="nav-item nav-category">Automated Manager</li>
                @canany(['View Trip'])
                    <li class="nav-item {{ active_class(['trip/*']) }}">
                        <a href="{{ url('trip/view') }}" class="nav-link">
                            <i class="link-icon fa fa-sign-in"></i>
                            <span class="link-title">Trip Records</span>
                        </a>
                    </li>
                @endcanany

                @canany(['View Bill'])
                    <li class="nav-item {{ active_class(['bill/*']) }}">
                        <a href="{{ url('bill/view') }}" class="nav-link">
                            <i class="link-icon" data-feather="printer"></i>
                            <span class="link-title">Generate Bill</span>
                        </a>
                    </li>
                @endcanany
            @endcanany

            {{-- Order Management --}}
            @canany(['Book Order', 'View Order', 'Track Order'])
                <li class="nav-item nav-category">Order Management</li>
                @canany(['View Order'])
                    <li class="nav-item {{ active_class(['order/*']) }}">
                        <a href="{{ url('order/view') }}" class="nav-link">
                            <i class="link-icon" data-feather="layers"></i>
                            <span class="link-title">Orders</span>
                        </a>
                    </li>
                @endcanany

                @canany(['Book Order'])
                    <li class="nav-item {{ active_class(['order-book/*']) }}">
                        <a href="{{ url('order-book/view') }}" class="nav-link">
                            <i class="link-icon" data-feather="shopping-bag"></i>
                            <span class="link-title">Order Booking</span>
                        </a>
                    </li>
                @endcanany

                @canany(['Track Order'])
                    <li class="nav-item {{ active_class(['order-track/*']) }}">
                        <a href="{{ url('order-track/view') }}" class="nav-link">
                            <i class="link-icon" data-feather="compass"></i>
                            <span class="link-title">Order Tracking</span>
                        </a>
                    </li>
                @endcanany
            @endcanany

            {{-- Recruitment Management --}}
            @canany(['View Job'])
                <li class="nav-item nav-category">Recruitment Management</li>
                @canany(['View Job'])
                    <li class="nav-item {{ active_class(['job/*']) }}">
                        <a href="{{ url('job/view') }}" class="nav-link">
                            <i class="link-icon" data-feather="codepen"></i>
                            <span class="link-title">Job Openings</span>
                        </a>
                    </li>
                @endcanany
            @endcanany

        </ul>
    </div>
</nav>
