@if (method_exists($modelAdmin, 'actionsRoute'))
    {{ $modelAdmin->actionsRoute($modelItem) }}
@else
    <a href="{{ $modelAdmin->routeTo($modelItem) }}" class="btn btn-default">
        <i class="fa fa-external-link"></i>
        Page
    </a>
@endif
