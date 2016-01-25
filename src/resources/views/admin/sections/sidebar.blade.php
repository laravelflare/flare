<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset(isset(Auth::user()->pic) ? Auth::user()->pic : '/vendor/flare/user.jpg') }}" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>
                    {{ Auth::user()->name }}
                </p>
                <a href="#">
                    <i class="fa fa-circle text-success"></i> Online
                </a>
            </div>
        </div>

        <ul class="sidebar-menu">
            <li class="{{ Request::is(Flare::relativeAdminUrl()) ? 'active' : '' }}">
                <a href="{{ Flare::adminUrl() }}">
                    <i class="fa fa-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            @include('flare::admin.sections.sidebar.items', ['items' => $adminManager])
        </ul>
    </section>
</aside>
