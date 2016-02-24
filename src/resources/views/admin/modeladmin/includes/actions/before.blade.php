@if (method_exists($modelAdmin, 'beforeActions'))
    {{ $modelAdmin->beforeActions($modelItem) }}
@endif