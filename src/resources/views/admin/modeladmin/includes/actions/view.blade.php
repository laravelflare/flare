@if (method_exists($modelAdmin, 'actionsDelete'))
    {{ $modelAdmin->actionsDelete($modelItem) }}
@else
    <a href="{{ $modelAdmin->currentUrl('view/'.$modelItem->getKey()) }}" class="btn btn-success">
        <i class="fa fa-eye"></i>
        View
    </a>
@endif
