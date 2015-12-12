<div class="box-body no-padding">
    <table class="table table-striped">
        <thead>
            <tr>
                @foreach ($modelAdmin->getColumns() as $key => $field)
                    <th>
                        @if (strpos($key, '.') == 0 && !$modelAdmin->model()->hasGetMutator($key) && !$modelAdmin->hasGetMutator($key) && $modelAdmin->isSortable())
                            <a href="{{ $modelAdmin::currentUrl('') }}?order={{ $key }}&sort={{ ($modelAdmin->sortBy() == 'asc' ? 'desc' : 'asc') }}">
                                {{ $field }}
                                @if (Request::input('order', 'id') == $key)
                                    <i class="fa fa-caret-{{ ($modelAdmin->sortBy() == 'asc' ? 'up' : 'down') }}"></i>
                                @endif
                            </a>
                        @else 
                            {{ $field }}
                        @endif
                    </th>
                @endforeach
                <th></th>
            </tr>
        </thead>
        <tbody>
        @if ($modelItems->count() > 0)    
            @foreach($modelItems as $modelItem)    
                <tr>
                    @foreach ($modelAdmin->getColumns() as $key => $field)
                    <td>
                        {!! $modelAdmin->getAttribute($key, $modelItem) !!}
                    </td>
                    @endforeach
                    <td style="width: 1%; white-space:nowrap">
                        <a class="btn btn-success btn-xs" href="{{ $modelAdmin::currentUrl('view/'.$modelItem->getKey()) }}">
                            <i class="fa fa-eye"></i>
                            View
                        </a>
                        <a class="btn btn-primary btn-xs" href="{{ $modelAdmin::currentUrl('edit/'.$modelItem->getKey()) }}">
                            <i class="fa fa-edit"></i>
                            Edit
                        </a>
                        @if (isset($modelAdmin->softDeletingModel) && $modelItem->trashed())
                        <a class="btn btn-info btn-xs" href="{{ $modelAdmin::currentUrl('restore/'.$modelItem->getKey()) }}">
                            <i class="fa fa-undo"></i>
                            Restore
                        </a>
                        @else
                        <a class="btn btn-warning btn-xs" href="{{ $modelAdmin::currentUrl('clone/'.$modelItem->getKey()) }}">
                            <i class="fa fa-clone"></i>
                            Clone
                        </a>
                        @endif
                        <a class="btn btn-danger btn-xs" href="{{ $modelAdmin::currentUrl('delete/'.$modelItem->getKey()) }}">
                            <i class="fa fa-trash"></i>
                            @if (!isset($modelAdmin->softDeletingModel) || $modelItem->trashed())
                                Delete
                            @else 
                                Trash
                            @endif
                        </a>
                    </td>
                </tr>
            @endforeach
        @else 
            <tr>
                <td colspan="{{ count($modelAdmin->getColumns())+2 }}">
                    No {{ $modelAdmin->pluralTitle() }} Found
                </td>
            </tr>
        @endif
        </tbody>
    </table>
</div>