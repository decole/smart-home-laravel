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
                <a href="{{ route('settings') }}" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link">
                        <i class="fas fa-cogs"></i>
                        <p>
                            Главная
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('telemetry') }}" class="nav-link">
                        <i class="fas fa-folder-open"></i>
                        <p>
                            Телеметрия
                        </p>
                    </a>
                </li>
{{--                <li class="nav-item">--}}
{{--                    <a href="/files" class="nav-link">--}}
{{--                        <i class="fas fa-file"></i>--}}
{{--                        <p>--}}
{{--                            Files--}}
{{--                        </p>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="nav-item">--}}
{{--                    <a href="/trackers" class="nav-link">--}}
{{--                        <i class="fa fa-fw fa-list-ol"></i>--}}
{{--                        <p>--}}
{{--                            Trackers--}}
{{--                        </p>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="nav-item">--}}
{{--                    <a href="/agiledashboard" class="nav-link">--}}
{{--                        <i class="fa fa-fw fa-table"></i>--}}
{{--                        <p>--}}
{{--                            Agile Dashboard--}}
{{--                        </p>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="nav-item">--}}
{{--                    <a href="/wiki" class="nav-link">--}}
{{--                        <i class="fab fa-wikipedia-w"></i>--}}
{{--                        <p>--}}
{{--                            Wiki--}}
{{--                        </p>--}}
{{--                    </a>--}}
{{--                </li>--}}
                {{--<li class="nav-item">--}}
                    {{--<a href="#" class="nav-link">--}}
                        {{--<i class="nav-icon fas fa-calendar-alt"></i>--}}
                        {{--<p>--}}
                            {{--Calendar--}}
                            {{--<span class="badge badge-info right">2</span>--}}
                        {{--</p>--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li class="nav-item has-treeview">--}}
                    {{--<a href="#" class="nav-link">--}}
                        {{--<i class="nav-icon far fa-envelope"></i>--}}
                        {{--<p>--}}
                            {{--Mailbox--}}
                            {{--<i class="fas fa-angle-left right"></i>--}}
                            {{--<span class="badge badge-info right">2</span>--}}
                        {{--</p>--}}
                    {{--</a>--}}
                    {{--<ul class="nav nav-treeview">--}}
                        {{--<li class="nav-item">--}}
                            {{--<a href="pages/mailbox/mailbox.html" class="nav-link">--}}
                                {{--<i class="far fa-circle nav-icon"></i>--}}
                                {{--<p>Inbox</p>--}}
                                {{--<span class="badge badge-info right">2</span>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="nav-item">--}}
                            {{--<a href="pages/mailbox/compose.html" class="nav-link">--}}
                                {{--<i class="far fa-circle nav-icon"></i>--}}
                                {{--<p>Compose</p>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li class="nav-item">--}}
                            {{--<a href="pages/mailbox/read-mail.html" class="nav-link">--}}
                                {{--<i class="far fa-circle nav-icon"></i>--}}
                                {{--<p>Read</p>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                {{--</li>--}}
                <li class="nav-header">MISCELLANEOUS</li>
                <li class="nav-item">
                    <a href="https://adminlte.io/docs/3.0" class="nav-link">
                        <i class="nav-icon fas fa-file"></i>
                        <p>Documentation</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
