<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('/vendor/flare/user.jpg') }}" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>Aden Fraser</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
                <span class="input-group-btn">
                    <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>
        <ul class="sidebar-menu">
            <li class="{{ Request::is('admin') ? 'active' : '' }}">
                <a href="{{ url('admin') }}">
                    <i class="fa fa-dashboard"></i>
                    <span>
                        Dashboard
                    </span>
                </a>
            </li>
            @foreach($modelAdminCollection as $modelAdmin)
            <li class="treeview {{ Request::is( $modelAdmin::RelativeUrl() . '*' ) ? 'active' : '' }}">
                <a href="{{ $modelAdmin::Url() }}">
                    <i class="fa fa-user"></i>
                    <span>
                    {{ $modelAdmin::PluralTitle() }}
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is( $modelAdmin::RelativeUrl() . '*' ) ? 'active' : '' }}">
                        <a href="{{ $modelAdmin::Url() }}">
                            <span>
                                All Users
                            </span>
                        </a>
                    </li>
                    <li class="{{ Request::is( $modelAdmin::RelativeUrl() . '/create') ? 'active' : '' }}">
                        <a href="{{ $modelAdmin::Url() }}/create">
                            <span>
                                Create User
                            </span>
                        </a>
                    </li>
                    <li class="treeview {{ Request::is( $modelAdmin::RelativeUrl() . '/usergroup/*') ? 'active' : '' }}">
                        <a href="{{ $modelAdmin::Url() }}/usergroup">
                            <i class="fa fa-users" style="width: 17px;"></i>
                            <span>
                                User Groups
                            </span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="{{ Request::is( $modelAdmin::RelativeUrl() . '/usergroup/*') ? 'active' : '' }}">
                                <a href="{{ $modelAdmin::Url() }}/usergroup">
                                    All User Groups
                                </a>
                            </li>
                            <li class="{{ Request::is( $modelAdmin::RelativeUrl() . '/usergroup/create') ? 'active' : '' }}">
                                <a href="{{ $modelAdmin::Url() }}/usergroup/create">
                                    Create User Group
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            @endforeach
        </ul>
    </section>
</aside>