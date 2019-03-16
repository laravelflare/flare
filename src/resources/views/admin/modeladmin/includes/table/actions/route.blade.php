@if (method_exists($modelAdmin, 'tableActionsRoute'))
    {{ $modelAdmin->tableActionsRoute($modelItem) }}
@else
    <a href="{{ $modelAdmin->routeTo($modelItem) }}" class="btn btn-default btn-xs">
        <i class="fa fa-external-link"></i>
        Page
    </a>
@endif
