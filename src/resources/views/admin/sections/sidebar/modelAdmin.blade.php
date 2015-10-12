<li class="treeview {{ Request::is( $adminItem::relativeUrl() . '*' ) ? 'active' : '' }}">
    <a href="{{ $adminItem::url() }}">
        @if ($adminItem::$icon)
        <i class="fa fa-{{ $adminItem::$icon }}"></i>
        @endif
        <span>{{ $adminItem::pluralTitle() }}</span>
    </a>
    <ul class="treeview-menu">
        @foreach ($adminItem->getManagedModels()->take(1) as $managedModel)
        <li class="{{ Request::is( $adminItem::relativeUrl() . '*' ) ? 'active' : '' }}">
            <a href="{{ $adminItem::url() }}">
                All {{ $managedModel::pluralTitle() }}
            </a>
        </li>
        <li class="{{ Request::is( $adminItem::relativeUrl('create') ) ? 'active' : '' }}">
            <a href="{{ $adminItem::url('create') }}">
                Create {{ $managedModel::title() }}
            </a>
        </li>
        @endforeach
        @if ($adminItem->getManagedModels()->count() > 1)
            @foreach ($adminItem->getManagedModels()->slice(1) as $managedModel)
            <li class="treeview {{ Request::is( $adminItem::relativeUrl($managedModel::urlPrefix()).'/*') ? 'active' : '' }}">
                <a href="{{ $adminItem::url() . '/' . $managedModel::urlPrefix() }}">
                    @if ($managedModel::$icon)
                    <i class="fa fa-{{ $managedModel::$icon }}" style="width: 17px;"></i>
                    @endif
                    {{ $managedModel::pluralTitle() }}
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is( $adminItem::relativeUrl($managedModel::urlPrefix())) ? 'active' : '' }}">
                        <a href="{{ $adminItem::url($managedModel::urlPrefix()) }}">
                            All {{ $managedModel::pluralTitle() }}
                        </a>
                    </li>
                    <li class="{{ Request::is( $adminItem::relativeUrl($managedModel::urlPrefix()) . '/create') ? 'active' : '' }}">
                        <a href="{{ $adminItem::url($managedModel::urlPrefix() . '/create')  }}">
                            Create {{ $managedModel::title() }}
                        </a>
                    </li>
                </ul>
            </li>
            @endforeach
        @endif
    </ul>
</li>