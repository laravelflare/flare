@if (method_exists($modelAdmin, 'actionsClone'))
    {{ $modelAdmin->actionsClone($modelItem) }}
@else
    <a href="{{ $modelAdmin->currentUrl('clone/'.$modelItem->getKey()) }}" class="btn btn-warning">
        <i class="fa fa-clone"></i>
        Clone
    </a>
@endif
