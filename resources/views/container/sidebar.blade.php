<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="{{ asset("dist/img/AdminLTELogo.png") }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                {{--<img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">--}}
                <img src="https://www.gravatar.com/avatar/<?=md5(Auth::user()->email)?>.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-cogs"></i>
                        <p>
                            Settings
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-tint"></i></i>
                        <p>
                            Wattering
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fab fa-free-code-camp"></i>
                        <p>
                            FireSecurity
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-user-lock"></i>
                        <p>
                            Security
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-folder-open"></i>
                        <p>
                            All data
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                            CRUD
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('sensors.index') }}" class="nav-link">
                                <i class="fas fa-puzzle-piece"></i>
                                <p>
                                    Sensors
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('relays.index') }}" class="nav-link">
                                <i class="fas fa-puzzle-piece"></i>
                                <p>
                                    Relays
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('types.index') }}" class="nav-link">
                                <i class="fas fa-puzzle-piece"></i>
                                <p>
                                    Type Devices
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('locations.index') }}" class="nav-link">
                                <i class="fas fa-puzzle-piece"></i>
                                <p>
                                    Location Devices
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('secure.index') }}" class="nav-link">
                                <i class="fas fa-puzzle-piece"></i>
                                <p>
                                    Secure Devices
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('fire_secure.index') }}" class="nav-link">
                                <i class="fas fa-puzzle-piece"></i>
                                <p>
                                    FireSecure Devices
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
