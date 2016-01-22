@foreach($items as $key => $subitem)
    @if(class_exists($key))
        @include('flare::admin.sections.sidebar.adminItem', ['adminItem' => $key, 'adminItems' => $subitem])
    @elseif(!is_array($subitem) && class_exists($subitem))
            @include('flare::admin.sections.sidebar.adminItem', ['adminItem' => $subitem, 'adminItems' => []])
    @else
        @include('flare::admin.sections.sidebar.items', ['items' => $subitem])
    @endif
@endforeach
