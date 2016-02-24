@if (method_exists($modelAdmin, 'tableBodyRow')) 
    {{ $modelAdmin->tableBodyRow() }}
@else
    <tr>
        @foreach ($modelAdmin->getColumns() as $key => $field)
            <td>
                {!! $modelAdmin->getAttribute($key, $modelItem) !!}
            </td>
        @endforeach
        <td style="width: 1%; white-space:nowrap">
            @include('flare::admin.modeladmin.includes.actions.before')

            @if ($modelAdmin->hasViewing())
                @include('flare::admin.modeladmin.includes.actions.view')
            @endif
            @if ($modelAdmin->hasEditting())
                @include('flare::admin.modeladmin.includes.actions.edit')
            @endif
            @if ($modelAdmin->hasDeleting() && ($modelAdmin->hasSoftDeleting() && $modelItem->trashed()))
                @include('flare::admin.modeladmin.includes.actions.restore')
            @elseif ($modelAdmin->hasCloning())
                @include('flare::admin.modeladmin.includes.actions.clone')
            @endif
            @if ($modelAdmin->hasDeleting())
                @include('flare::admin.modeladmin.includes.actions.delete')
            @endif

            @include('flare::admin.modeladmin.includes.actions.after')
        </td>
    </tr>
@endif