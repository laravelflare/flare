<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('/vendor/flare/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>Example User</p>
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
            <li class="active">
                <a href="{{ url('admin') }}">
                    <span>Dashboard</span>
                </a>
            </li>
            @foreach($modelAdminCollection as $modelAdmin)
            <li class="header">
                {{ $modelAdmin::PluralTitle() }}
            </li>
            <li>
                <a href="{{ $modelAdmin::Url() }}/create">
                    <span>
                        Create User
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ $modelAdmin::Url() }}/edit">
                    <span>
                        Edit User
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ $modelAdmin::Url() }}/delete">
                    <span>
                        Delete User
                    </span>
                </a>
            </li>
            <li class="treeview">
                <a href="{{ $modelAdmin::Url() }}/usergroup">
                    <span>
                        User Groups
                    </span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="{{ $modelAdmin::Url() }}/usergroup">
                            All User Groups
                        </a>
                    </li>
                    <li>
                        <a href="{{ $modelAdmin::Url() }}/usergroup/create">
                            Create User Group
                        </a>
                    </li>
                    <li>
                        <a href="{{ $modelAdmin::Url() }}/usergroup/edit">
                            Edit User Group
                        </a>
                    </li>
                    <li>
                        <a href="{{ $modelAdmin::Url() }}/usergroup/delete">
                            Delete User Group
                        </a>
                    </li>
                </ul>
            </li>
            @endforeach
        </ul>
    </section>
</aside>