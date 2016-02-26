@if (method_exists($modelAdmin, 'tableTbodyRowNotFound'))
    {{ $modelAdmin->tableTbodyRowNotFound() }}
@else
    <tr>
        <td colspan="{{ count($modelAdmin->getColumns())+2 }}">
            No {{ $modelAdmin->getPluralTitle() }} Found
        </td>
    </tr>
@endif