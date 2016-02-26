@if (method_exists($modelAdmin, 'tableActionsView'))
    {{ $modelAdmin->tableActionsView($modelItem) }}
@else
    <a class="btn btn-success btn-xs" href="{{ $modelAdmin->currentUrl('view/'.$modelItem->getKey()) }}">
        <i class="fa fa-eye"></i>
        View
    </a>
@endif