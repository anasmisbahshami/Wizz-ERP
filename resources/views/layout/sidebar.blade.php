<nav class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
            <!-- PurchaseOrder<span>MS</span> -->
            <img src="{{ asset('assets/images/LOGO_RGB_W.svg') }}" style="width:100px;">

        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
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
        </ul>
    </div>
</nav>
