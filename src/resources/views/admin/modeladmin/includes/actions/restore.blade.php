@if (method_exists($modelAdmin, 'restoreAction'))
    {{ $modelAdmin->restoreAction($modelItem) }}
@else
    <a class="btn btn-info btn-xs" href="{{ $modelAdmin->currentUrl('restore/'.$modelItem->getKey()) }}">
        <i class="fa fa-undo"></i>
        Restore
    </a>
@endif