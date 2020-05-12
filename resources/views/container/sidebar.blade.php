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
                @if(Auth::user())
                    <img src="https://www.gravatar.com/avatar/<?=md5(Auth::user()->email)?>.jpg" class="img-circle elevation-2" alt="User Image">

                @else
                    <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                @endif
            </div>
            <div class="info">
                @if(!empty(Auth::user()->name))
                    <a href="{{ route('settings') }}" class="d-block">
                        {{ Auth::user()->name }}
                    </a>
                @else
                    <a href="/login" class="d-block">Авторизируйтесь</a>
                @endif
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('settings') }}" class="nav-link">
                        <i class="fas fa-cogs"></i>
                        <p>
                            Настройки
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('watering') }}" class="nav-link">
                        <i class="fas fa-tint" style="padding: 4px;"></i>
                        <p>
                            Автополив
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('fire_secure') }}" class="nav-link">
                        <i class="fab fa-free-code-camp"></i>
                        <p>
                            Пожарная система
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('secure_system') }}" class="nav-link">
                        <i class="fas fa-user-lock"></i>
                        <p>
                            Охранная система
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('all-data') }}" class="nav-link">
                        <i class="fas fa-folder-open"></i>
                        <p>
                            Все данные
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('margulis') }}" class="nav-link">
                        <i class="fas fa-folder-open"></i>
                        <p>
                            Пристройка
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('history_greenhouse.index') }}" class="nav-link">
                        <i class="fas fa-folder-open"></i>
                        <p>
                            Теплица
                        </p>
                    </a>
                </li>

                <li class="nav-item has-treeview ">
                    <a class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                            Параметры
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('sensors.index') }}" class="nav-link">
                                <i class="fas fa-puzzle-piece"></i>
                                <p>
                                    Сенсоры
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('relays.index') }}" class="nav-link">
                                <i class="fas fa-puzzle-piece"></i>
                                <p>
                                    Реле
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('types.index') }}" class="nav-link">
                                <i class="fas fa-puzzle-piece"></i>
                                <p>
                                    Типы устройств
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('locations.index') }}" class="nav-link">
                                <i class="fas fa-puzzle-piece"></i>
                                <p>
                                    Место устройств
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('secure.index') }}" class="nav-link">
                                <i class="fas fa-puzzle-piece"></i>
                                <p>
                                    Охранные датчики
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('fire_secure.index') }}" class="nav-link">
                                <i class="fas fa-puzzle-piece"></i>
                                <p>
                                    Пожарные датчики
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('scheduler.index') }}" class="nav-link">
                                <i class="fas fa-puzzle-piece"></i>
                                <p>
                                    Планировщик
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('weight.index') }}" class="nav-link">
                                <i class="fas fa-puzzle-piece"></i>
                                <p>
                                    Вес
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('failed_jobs') }}" class="nav-link">
                                <i class="fas fa-puzzle-piece"></i>
                                <p>
                                    Дефект заданий
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
