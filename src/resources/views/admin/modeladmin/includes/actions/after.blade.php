@if (method_exists($modelAdmin, 'actionsAfter'))
    {{ $modelAdmin->actionsAfter($modelItem) }}
@endif