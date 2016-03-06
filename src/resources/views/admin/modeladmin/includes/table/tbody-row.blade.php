@if (method_exists($modelAdmin, 'tableTbodyRow')) 
    {{ $modelAdmin->tableTbodyRow($modelItem) }}
@else
    <tr>
        @foreach ($modelAdmin->getColumns() as $key => $field)
            <td>{!! $modelAdmin->getAttribute($key, $modelItem) !!}</td>
        @endforeach
        <td style="width: 1%; white-space:nowrap">
            @include('flare::admin.modeladmin.includes.table.actions.before')

            @if ($modelAdmin->hasViewing())
                @include('flare::admin.modeladmin.includes.table.actions.view')
            @endif
            @if ($modelAdmin->hasEditting())
                @include('flare::admin.modeladmin.includes.table.actions.edit')
            @endif
            @if ($modelAdmin->hasDeleting() && ($modelAdmin->hasSoftDeleting() && $modelItem->trashed()))
                @include('flare::admin.modeladmin.includes.table.actions.restore')
            @elseif ($modelAdmin->hasCloning())
                @include('flare::admin.modeladmin.includes.table.actions.clone')
            @endif
            @if ($modelAdmin->hasDeleting())
                @include('flare::admin.modeladmin.includes.table.actions.delete')
            @endif

            @include('flare::admin.modeladmin.includes.table.actions.after')
        </td>
    </tr>
@endif