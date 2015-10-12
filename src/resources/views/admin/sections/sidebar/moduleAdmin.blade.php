<li class="treeview {{ Request::is( $adminItem::relativeUrl() . '*' ) ? 'active' : '' }}">
    <a href="{{ $adminItem::url() }}">
        @if ($adminItem::$icon)
        <i class="fa fa-{{ $adminItem::$icon }}"></i>
        @endif
        <span>{{ $adminItem::pluralTitle() }}</span>
    </a>
</li>