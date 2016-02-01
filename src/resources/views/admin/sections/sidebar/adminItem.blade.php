<li class="treeview {{ Request::is( $adminItem::relativeUrl() . '*' ) ? 'active' : '' }}">
    <a href="{{ $adminItem::url() }}">
        @if ($adminItem::getIcon())
        <i class="fa fa-{{ $adminItem::getIcon() }}"></i>
        @endif
        <span>{{ $adminItem::pluralTitle() }}</span>
    </a>

    @if(isset($adminItems) && is_array($adminItems) && !empty($adminItems))
        <ul class="treeview-menu">
            @include('flare::admin.sections.sidebar.items', ['items' => $adminItems])
        </ul>
    @elseif(count((new $adminItem)->menuItems()) > 0)
        <ul class="treeview-menu">
            @include('flare::admin.sections.sidebar.menuitem', ['items' => (new $adminItem)->menuItems()])
        </ul>
    @endif
</li>