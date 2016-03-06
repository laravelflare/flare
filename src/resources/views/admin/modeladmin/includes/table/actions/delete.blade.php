@if (method_exists($modelAdmin, 'tableActionsDelete'))
    {{ $modelAdmin->tableActionsDelete($modelItem) }}
@else
    <a class="btn btn-danger btn-xs" href="{{ $modelAdmin->currentUrl('delete/'.$modelItem->getKey()) }}">
        <i class="fa fa-trash"></i>
        @if (!$modelAdmin->hasSoftDeleting() || $modelItem->trashed())
            Delete
        @else 
            Trash
        @endif
    </a>
@endif