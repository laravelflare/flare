@if (method_exists($modelAdmin, 'cloneAction'))
    {{ $modelAdmin->cloneAction($modelItem) }}
@else
    <a class="btn btn-warning btn-xs" href="{{ $modelAdmin->currentUrl('clone/'.$modelItem->getKey()) }}">
        <i class="fa fa-clone"></i>
        Clone
    </a>
@endif