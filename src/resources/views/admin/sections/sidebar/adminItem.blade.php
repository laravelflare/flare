<li class="treeview {{ Request::is( (new $adminItem)->relativeUrl() . '*' ) ? 'active' : '' }}">
    <a href="{{ (new $adminItem)->url() }}">
        @if ((new $adminItem)->getIcon())
        <i class="fa fa-fw fa-{{ (new $adminItem)->getIcon() }}"></i>
        @endif
        <span>{{ (new $adminItem)->getPluralTitle() }}</span>
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