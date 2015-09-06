<header class="navbar navbar-dark bg-inverse">
    <button class="navbar-toggler hidden-sm-up" type="button" data-toggle="collapse" data-target="#flareNavbar">
        &#9776;
    </button>
    <div class="collapse navbar-toggleable-xs" id="flareNavbar">
        <a class="navbar-brand" href="{{ url('admin') }}">
            Flare
        </a>
        <ul class="nav navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="{{ url('admin') }}">
                    Home 
                        <span class="sr-only">(current)</span>
                </a>
            </li>
            @foreach($modelAdminCollection as $modelAdmin)
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="{{ $modelAdmin::Url('users') }}" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    {{ $modelAdmin::PluralTitle() }}
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ $modelAdmin::Url() }}">All Users</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ $modelAdmin::Url() }}/create">Create User</a>
                    <a class="dropdown-item" href="{{ $modelAdmin::Url() }}/edit">Edit User</a>
                    <a class="dropdown-item" href="{{ $modelAdmin::Url() }}/delete">Delete User</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ $modelAdmin::Url() }}/usergroup">All User Groups</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ $modelAdmin::Url() }}/usergroup/create">Create User Group</a>
                    <a class="dropdown-item" href="{{ $modelAdmin::Url() }}/usergroup/edit">Edit User Group</a>
                    <a class="dropdown-item" href="{{ $modelAdmin::Url() }}/usergroup/delete">Delete User Group</a>
                </div>
            </li>
            @endforeach
        </ul>
        <form class="form-inline navbar-form pull-right">
            <input class="form-control" type="text" placeholder="Search">
            <button class="btn btn-success-outline" type="submit">Search</button>
        </form>
    </div>
</header>
