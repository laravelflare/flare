@if (method_exists($modelAdmin, 'afterActions'))
    {{ $modelAdmin->afterActions($modelItem) }}
@endif