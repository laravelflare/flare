@if (method_exists($modelAdmin, 'editAction'))
    {{ $modelAdmin->editAction($modelItem) }}
@else
    <a class="btn btn-primary btn-xs" href="{{ $modelAdmin->currentUrl('edit/'.$modelItem->getKey()) }}">
        <i class="fa fa-edit"></i>
        Edit
    </a>
@endif