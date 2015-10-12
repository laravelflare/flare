<li class="treeview {{ Request::is( $adminItem::relativeUrl() . '*' ) ? 'active' : '' }}">
    <a href="{{ $adminItem::url() }}">
        @if ($adminItem::getIcon())
        <i class="fa fa-{{ $adminItem::getIcon() }}"></i>
        @endif
        <span>{{ $adminItem::pluralTitle() }}</span>
    </a>
  
</li>