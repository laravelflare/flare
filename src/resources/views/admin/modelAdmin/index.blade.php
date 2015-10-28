@extends('flare::admin.sections.wrapper')

@section('page_title', $modelAdmin->pluralTitle())

@section('content')

<div class="">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        All {{ $modelAdmin->modelManager()->pluralTitle() }}
                    </h3>
                </div>
                <div class="box-body no-padding">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                @foreach ($modelAdmin->modelManager()->getSummaryFields() as $key => $field)
                                <th {{ ($key == 'id' ? 'style="tight"' : '') }} style="tight">
                                    @if (strpos($key, '.') == 0 && !$modelAdmin->modelManager()->model->hasGetMutator($key))
                                    <a href="{{ $modelAdmin::currentUrl('') }}?order={{ $key }}&sort={{ ($modelAdmin->modelManager()->sortBy() == 'asc' ? 'desc' : 'asc') }}">
                                        {{ $field }}
                                        @if (Request::input('order', 'id') == $key)
                                        <i class="fa fa-caret-{{ ($modelAdmin->modelManager()->sortBy() == 'asc' ? 'up' : 'down') }}"></i>
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
                        @if ($modelAdmin->modelManager()->items()->count() > 0)    
                            @foreach($modelAdmin->modelManager()->items() as $modelItem)    
                                <tr>
                                    @foreach ($modelAdmin->modelManager()->getSummaryFields() as $key => $field)
                                    <td>
                                        {!! $modelAdmin->modelManager()->getAttribute($key, $modelItem) !!}
                                    </td>
                                    @endforeach
                                    <td style="width: 1%; white-space:nowrap">
                                        <a class="btn btn-success btn-xs" href="{{ $modelAdmin::currentUrl('view/'.$modelItem->id) }}">
                                            <i class="fa fa-eye"></i>
                                            View
                                        </a>
                                        <a class="btn btn-primary btn-xs" href="{{ $modelAdmin::currentUrl('edit/'.$modelItem->id) }}">
                                            <i class="fa fa-edit"></i>
                                            Edit
                                        </a>
                                        <a class="btn btn-danger btn-xs" href="{{ $modelAdmin::currentUrl('delete/'.$modelItem->id) }}">
                                            <i class="fa fa-trash"></i>
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else 
                            <tr>
                                <td colspan="{{ count($modelAdmin->modelManager()->getSummaryFields())+2 }}">
                                    No {{ $modelAdmin->modelManager()->pluralTitle() }} Found
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="box-footer clearfix">
                    <div class="pull-left">
                        <a href="{{ $modelAdmin::currentUrl('create') }}" class="btn btn-success">
                            <i class="fa fa-{{ $modelAdmin::$icon }}"></i>
                            Add {{ $modelAdmin->modelManager()->title() }}
                        </a>
                    </div>

                    @if ($modelAdmin->modelManager()->getPerPage())
                    <div class="pull-right" style="margin-top: -20px; margin-bottom: -20px;">
                        {!! $modelAdmin->modelManager()->items()->appends([
                                                                            'sort' => $modelAdmin->modelManager()->sortBy() == 'asc' ? 'asc' : null,
                                                                            'order' => $modelAdmin->modelManager()->orderBy(),
                                                                        ])->render() !!}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@stop
