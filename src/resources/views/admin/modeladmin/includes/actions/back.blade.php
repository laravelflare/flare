@if (method_exists($modelAdmin, 'actionsBack'))
    {{ $modelAdmin->actionsBack($modelItem) }}
@else
    <a href="{{ $modelAdmin->currentUrl() }}" class="btn btn-default">
        Back
    </a>
@endif
