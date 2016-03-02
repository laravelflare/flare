@if (method_exists($modelAdmin, 'actionsCreate'))
    {{ $modelAdmin->actionsCreate() }}
@else
    <div class="pull-left">
        <a href="{{ $modelAdmin->currentUrl('create') }}" class="btn btn-success">
            <i class="fa fa-{{ $modelAdmin->getIcon() }}"></i>
            Add {{ $modelAdmin->getEntityTitle() }}
        </a>
    </div>
@endif