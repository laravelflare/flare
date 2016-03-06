@if (method_exists($modelAdmin, 'actionsDelete'))
    {{ $modelAdmin->actionsDelete($modelItem) }}
@else
    <a href="{{ $modelAdmin->currentUrl('delete/'.$modelItem->getKey()) }}" class="btn btn-danger">
        <i class="fa fa-trash"></i>
        @if (!$modelAdmin->hasSoftDeleting() || $modelItem->trashed())
            Delete
        @else 
            Trash
        @endif
    </a>
@endif
