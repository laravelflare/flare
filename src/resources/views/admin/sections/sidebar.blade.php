<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('/vendor/flare/user.jpg') }}" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <form class="sidebar-form" method="get" action="#">
            <div class="input-group">
                <input type="text" placeholder="Search..." class="form-control" name="q">
                <span class="input-group-btn">
                    <button class="btn btn-flat" id="search-btn" name="search" type="submit"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>

        <ul class="sidebar-menu">
            <li class="{{ Request::is('admin') ? 'active' : '' }}">
                <a href="{{ Flare::adminUrl() }}">
                    <i class="fa fa-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            @foreach($modelAdminCollection as $modelAdmin)
            <li class="treeview {{ Request::is( $modelAdmin::relativeUrl() . '*' ) ? 'active' : '' }}">
                <a href="{{ $modelAdmin::url() }}">
                    @if ($modelAdmin::$icon)
                    <i class="fa fa-{{ $modelAdmin::$icon }}"></i>
                    @endif
                    <span>{{ $modelAdmin::pluralTitle() }}</span>
                </a>
                <ul class="treeview-menu">
                    @foreach ($modelAdmin->getManagedModels()->take(1) as $managedModel)
                    <li class="{{ Request::is( $modelAdmin::relativeUrl() . '*' ) ? 'active' : '' }}">
                        <a href="{{ $modelAdmin::url() }}">
                            All {{ $managedModel::pluralTitle() }}
                        </a>
                    </li>
                    <li class="{{ Request::is( $modelAdmin::relativeUrl('create') ) ? 'active' : '' }}">
                        <a href="{{ $modelAdmin::url('create') }}">
                            Create {{ $managedModel::title() }}
                        </a>
                    </li>
                    @endforeach
                    @if ($modelAdmin->getManagedModels()->count() > 1)
                        @foreach ($modelAdmin->getManagedModels()->slice(1) as $managedModel)
                        <li class="treeview {{ Request::is( $modelAdmin::relativeUrl($managedModel::urlPrefix()).'/*') ? 'active' : '' }}">
                            <a href="{{ $modelAdmin::url() . '/' . $managedModel::urlPrefix() }}">
                                @if ($managedModel::$icon)
                                <i class="fa fa-{{ $managedModel::$icon }}" style="width: 17px;"></i>
                                @endif
                                {{ $managedModel::pluralTitle() }}
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li class="{{ Request::is( $modelAdmin::relativeUrl($managedModel::urlPrefix())) ? 'active' : '' }}">
                                    <a href="{{ $modelAdmin::url($managedModel::urlPrefix()) }}">
                                        All {{ $managedModel::pluralTitle() }}
                                    </a>
                                </li>
                                <li class="{{ Request::is( $modelAdmin::relativeUrl($managedModel::urlPrefix()) . '/create') ? 'active' : '' }}">
                                    <a href="{{ $modelAdmin::url($managedModel::urlPrefix() . '/create')  }}">
                                        Create {{ $managedModel::title() }}
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endforeach
                    @endif
                </ul>
            </li>
            @endforeach

            @foreach($moduleAdminCollection as $moduleAdmin)
            <li class="treeview {{ Request::is( $moduleAdmin::relativeUrl() . '*' ) ? 'active' : '' }}">
                <a href="{{ $moduleAdmin::url() }}">
                    @if ($moduleAdmin::$icon)
                    <i class="fa fa-{{ $moduleAdmin::$icon }}"></i>
                    @endif
                    <span>{{ $moduleAdmin::pluralTitle() }}</span>
                </a>
            </li>
            @endforeach
        </ul>
    </section>
</aside>
