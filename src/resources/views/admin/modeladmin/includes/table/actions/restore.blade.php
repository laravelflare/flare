@if (method_exists($modelAdmin, 'tableActionsRestore'))
    {{ $modelAdmin->tableActionsRestore($modelItem) }}
@else
    <a class="btn btn-info btn-xs" href="{{ $modelAdmin->currentUrl('restore/'.$modelItem->getKey()) }}">
        <i class="fa fa-undo"></i>
        Restore
    </a>
@endif