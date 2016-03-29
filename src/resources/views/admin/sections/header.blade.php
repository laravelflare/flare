<header class="main-header">

    <a href="{{ url('admin') }}" class="logo">
        <i class="fa fa-fire"></i>
        <span>
            {!! Flare::getAdminTitle() !!}
        </span>
        <style>
            .logo i {
                display: none;
            }
            .sidebar-collapse > span {
                display: none;
            }
            .sidebar-collapse .logo i {
                display: inline;
            }
        </style>
    </a>

    <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">
                Toggle navigation
            </span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li>
                    <a href="{{ url('/') }}" aria-expanded="true" data-toggle="tooltip" data-placement="bottom" data-original-title="Home">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li>
                    <a href="{{ Flare::adminUrl('/') }}" aria-expanded="true" data-toggle="tooltip" data-placement="bottom" data-original-title="Dashboard">
                        <i class="fa fa-dashboard"></i>
                    </a>
                </li>

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ asset(isset(Auth::user()->pic) ? Auth::user()->pic : '/vendor/flare/user.jpg') }}" class="user-image" alt="User Image"/>
                        <span class="hidden-xs">
                            {{ Auth::user()->name }}
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <img src="{{ asset(isset(Auth::user()->pic) ? Auth::user()->pic : '/vendor/flare/user.jpg') }}" class="img-circle" alt="User Image" />
                            <p>
                                {{ Auth::user()->name }}

                                @if (Flare::show('github'))
                                    <small>Laravel <strong>Flare</strong></small>
                                @else
                                    <small>
                                        {{ Flare::getAdminTitle() }}
                                    </small>
                                @endif
                            </p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                               
                            </div>
                            <div class="pull-right">
                                <a href="{{ \Flare::adminUrl('logout') }}" class="btn btn-default btn-flat">
                                    Sign out
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
