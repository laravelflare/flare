@if (method_exists($modelAdmin, 'actionsEdit'))
    {{ $modelAdmin->actionsEdit($modelItem) }}
@else
    <a href="{{ $modelAdmin->currentUrl('edit/'.$modelItem->getKey()) }}" class="btn btn-primary">
        <i class="fa fa-edit"></i>
        Edit {{ $modelAdmin->getEntityTitle() }}
    </a>
@endif