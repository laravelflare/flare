@if (method_exists($modelAdmin, 'tableBodyRowNotFound'))
    {{ $modelAdmin->tableBodyRowNotFound() }}
@else
    <tr>
        <td colspan="{{ count($modelAdmin->getColumns())+2 }}">
            No {{ $modelAdmin->getPluralTitle() }} Found
        </td>
    </tr>
@endif