@if (method_exists($modelAdmin, 'actionsDelete'))
    {{ $modelAdmin->actionsDelete($modelItem) }}
@else
    <a href="{{ $modelAdmin->currentUrl('restore/'.$modelItem->getKey()) }}" class="btn btn-info">
        <i class="fa fa-undo"></i>
        Restore
    </a>
@endif
