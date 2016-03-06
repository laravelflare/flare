@if ($modelAdmin->filters())
    <div class="btn-group">
        <a href="{{ $modelAdmin->currentUrl($type.'?filter='.\Request::get('filter')) }}" class="btn btn-default btn-flat">
            Filter:
            @if ($filter = \Request::get('filter'))
                {{ $modelAdmin->safeFilters()[$filter] }}
            @else
                None
            @endif
        </a>
        <button data-toggle="dropdown" class="btn btn-default btn-flat dropdown-toggle" type="button">
            <span class="caret"></span>
            <span class="sr-only">Toggle Dropdown</span>
        </button>
        <ul role="menu" class="dropdown-menu">
            <li>
                <a href="{{ $modelAdmin->currentUrl($type) }}">
                    None
                </a>
            </li>
            @foreach ($modelAdmin->safeFilters() as $filterAction => $filter)
                <li>
                    <a href="{{ $modelAdmin->currentUrl($type.'?filter='.$filterAction) }}">
                       {{ $filter }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endif
