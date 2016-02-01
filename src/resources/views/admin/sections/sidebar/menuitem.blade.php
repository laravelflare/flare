@foreach($items as $slug => $title)
    <li class="treeview {{ Request::is( Flare::adminUrl($slug) . '*' ) ? 'active' : '' }}">
        <a href="{{ Flare::adminUrl($slug) }}">
            <span>{{ $title }}</span>
        </a>
    </li>
@endforeach
