<header class="navbar navbar-dark bg-inverse">
    <button class="navbar-toggler hidden-sm-up" type="button" data-toggle="collapse" data-target="#flareNavbar">
        &#9776;
    </button>
    <div class="collapse navbar-toggleable-xs" id="flareNavbar">
        <a class="navbar-brand" href="#">
            Flare
        </a>
        <ul class="nav navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="{{ url('admin') }}">
                    Home 
                        <span class="sr-only">(current)</span>
                </a>
            </li>
            @foreach($modelAdminCollection as $admin)
            <li class="nav-item">
                <a class="nav-link" href="{{ $admin::Url() }}">
                    {{ $admin::PluralTitle() }}
                </a>
            </li>
            @endforeach
        </ul>
        <form class="form-inline navbar-form pull-right">
            <input class="form-control" type="text" placeholder="Search">
            <button class="btn btn-success-outline" type="submit">Search</button>
        </form>
    </div>
</header>

<aside class="sidebar col-lg-2">
    Sidebar
</aside>

