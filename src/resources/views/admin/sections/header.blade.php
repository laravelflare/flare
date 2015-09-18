<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="{{ url('admin') }}" class="logo">
        <i class="fa fa-fire"></i>
        <span>
            Laravel <b>Flare</b>
        </span>

        <style>
            .logo i {
                display: none;
            }
            .sidebar-collapse span {
                display: none;
            }
            .sidebar-collapse .logo i {
                display: inline;
            }
        </style>
    </a>

    <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ asset('/vendor/flare/user.jpg') }}" class="user-image" alt="User Image"/>
                        <span class="hidden-xs">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <img src="{{ asset('/vendor/flare/user.jpg') }}" class="img-circle" alt="User Image" />
                            <p>
                                {{ Auth::user()->name }}
                                <small>Laravel <strong>Flare</strong></small>
                            </p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-right">
                                <a href="{{ url('admin/logout') }}" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>