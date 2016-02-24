@if (method_exists($modelAdmin, 'tableHeadRow')) 
    {{ $modelAdmin->tableHeadRow() }}
@else
    <tr>
        @foreach ($modelAdmin->getColumns() as $key => $field)
            <th>
                @if ($modelAdmin->isSortableBy($key))
                    <a href="{{ $modelAdmin->currentUrl('') }}?order={{ $key }}&sort={{ ($modelAdmin->sortBy() == 'asc' ? 'desc' : 'asc') }}">
                        {{ $field }}
                        @if (Request::input('order', 'id') == $key)
                            <i class="fa fa-caret-{{ ($modelAdmin->sortBy() == 'asc' ? 'up' : 'down') }}"></i>
                        @endif
                    </a>
                @else 
                    {{ $field }}
                @endif
            </th>
        @endforeach
        <th></th>
    </tr>
@endif