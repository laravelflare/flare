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

        <ul class="sidebar-menu">
            <li class="{{ Request::is('admin') ? 'active' : '' }}">
                <a href="{{ Flare::adminUrl() }}">
                    <i class="fa fa-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            @foreach($modelAdminCollection as $modelAdmin)
            <li class="treeview {{ Request::is( $modelAdmin::RelativeUrl() . '*' ) ? 'active' : '' }}">
                <a href="{{ $modelAdmin::Url() }}">
                    @if ($modelAdmin::$icon)
                    <i class="fa fa-{{ $modelAdmin::$icon }}"></i>
                    @endif
                    <span>{{ $modelAdmin::PluralTitle() }}</span>
                </a>
                <ul class="treeview-menu">
                    @foreach ($modelAdmin->getManagedModels()->take(1) as $managedModel)
                    <li class="{{ Request::is( $modelAdmin::RelativeUrl() . '*' ) ? 'active' : '' }}">
                        <a href="{{ $modelAdmin::Url() }}">
                            All {{ $managedModel::PluralTitle() }}
                        </a>
                    </li>
                    <li class="{{ Request::is( $modelAdmin::RelativeUrl('create') ) ? 'active' : '' }}">
                        <a href="{{ $modelAdmin::Url('create') }}">
                            Create {{ $managedModel::Title() }}
                        </a>
                    </li>
                    @endforeach
                    @if ($modelAdmin->getManagedModels()->count() > 1)
                        @foreach ($modelAdmin->getManagedModels()->slice(1)->take(1) as $managedModel)
                        <li class="treeview {{ Request::is( $modelAdmin::RelativeUrl() . '/'.$managedModel::UrlPrefix().'/*') ? 'active' : '' }}">
                            <a href="{{ $modelAdmin::Url() . '/' . $managedModel::UrlPrefix() }}">
                                @if ($managedModel::$icon)
                                <i class="fa fa-{{ $managedModel::$icon }}" style="width: 17px;"></i>
                                @endif
                                {{ $managedModel::PluralTitle() }}
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li class="{{ Request::is( $modelAdmin::RelativeUrl() . '/' . $managedModel::UrlPrefix() . '/*') ? 'active' : '' }}">
                                    <a href="{{ $modelAdmin::Url($managedModel::UrlPrefix()) }}">
                                        All {{ $managedModel::PluralTitle() }}
                                    </a>
                                </li>
                                <li class="{{ Request::is( $modelAdmin::RelativeUrl() . '/' . $managedModel::UrlPrefix() . '/create') ? 'active' : '' }}">
                                    <a href="{{ $modelAdmin::Url($managedModel::UrlPrefix() . '/create')  }}">
                                        Create {{ $managedModel::Title() }}
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endforeach
                    @endif
                </ul>
            </li>
            @endforeach
        </ul>
    </section>
</aside>