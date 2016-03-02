@if (method_exists($modelAdmin, 'actionsDelete'))
    {{ $modelAdmin->actionsDelete($modelItem) }}
@else
    <a href="{{ $modelAdmin->currentUrl('edit/'.$modelItem->getKey()) }}" class="btn btn-primary">
        <i class="fa fa-edit"></i>
        Edit {{ $modelAdmin->getEntityTitle() }}
    </a>
@endif