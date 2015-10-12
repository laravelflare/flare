<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('/vendor/flare/user.jpg') }}" class="img-circle" alt="User Image" />
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

        @include('flare::admin.sections.sidebar.search')

        <ul class="sidebar-menu">
            <li class="{{ Request::is(Flare::relativeAdminUrl()) ? 'active' : '' }}">
                <a href="{{ Flare::adminUrl() }}">
                    <i class="fa fa-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            @foreach($modelAdminCollection as $modelAdmin)
                @include('flare::admin.sections.sidebar.modelAdmin', ['adminItem' => $modelAdmin])
            @endforeach

            @foreach($moduleAdminCollection as $moduleAdmin)
                @include('flare::admin.sections.sidebar.moduleAdmin', ['adminItem' => $moduleAdmin])
            @endforeach
        </ul>
    </section>
</aside>
