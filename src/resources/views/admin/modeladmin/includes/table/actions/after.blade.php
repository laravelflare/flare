@if (method_exists($modelAdmin, 'tableActionsAfter'))
    {{ $modelAdmin->tableActionsAfter($modelItem) }}
@endif