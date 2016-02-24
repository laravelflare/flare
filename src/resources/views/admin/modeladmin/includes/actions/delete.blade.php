@if (method_exists($modelAdmin, 'deleteAction'))
    {{ $modelAdmin->deleteAction($modelItem) }}
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