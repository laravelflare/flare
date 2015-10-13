<li class="treeview {{ Request::is( $adminItem::relativeUrl() . '*' ) ? 'active' : '' }}">
    <a href="{{ $adminItem::url() }}">
        @if ($adminItem::getIcon())
        <i class="fa fa-{{ $adminItem::getIcon() }}"></i>
        @endif
        <span>{{ $adminItem::pluralTitle() }}</span>
    </a>
    @if (count($adminItem->menuItems()) > 0)
    <ul class="treeview-menu">
        @foreach ($adminItem->menuItems() as $adminItem)
            @include('flare::admin.sections.sidebar.adminItem', ['adminItem' => $adminItem])
        @endforeach
    </ul>
    @endif
</li>