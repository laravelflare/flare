@extends('flare::admin.sections.wrapper')

@section('page_title', $modelAdmin->PluralTitle())

@section('content')

<div class="">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        All {{ $modelAdmin->modelManager()->PluralTitle() }}
                    </h3>
                    <div class="box-tools">
                        <div style="width: 350px;" class="input-group">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-sm btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                                    10 Per Page <span class="fa fa-caret-down"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="#">25 Per Page</a></li>
                                    <li><a href="#">50 Per Page</a></li>
                                    <li><a href="#">100 Per Page</a></li>
                                </ul>
                            </div>

                            <input type="text" placeholder="Search" class="form-control input-sm pull-right">

                            <div class="input-group-btn">
                                <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                @foreach ($modelAdmin->modelManager()->getSummaryFields() as $key => $field)
                                <th {{ ($key == 'id' ? 'style="tight"' : '') }} style="tight">
                                    @if (strpos($key, '.') == 0 && !$modelAdmin->modelManager()->model->hasGetMutator($key))
                                    <a href="{{ $modelAdmin::CurrentUrl('') }}?order={{ $key }}&sort={{ ($modelAdmin->modelManager()->sortBy() == 'asc' ? 'desc' : 'asc') }}">
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
                                        <a class="btn btn-success btn-xs" href="{{ $modelAdmin::CurrentUrl('view/'.$modelItem->id) }}">
                                            <i class="fa fa-eye"></i>
                                            View
                                        </a>
                                        <a class="btn btn-primary btn-xs" href="{{ $modelAdmin::CurrentUrl('edit/'.$modelItem->id) }}">
                                            <i class="fa fa-edit"></i>
                                            Edit
                                        </a>
                                        <a class="btn btn-danger btn-xs" href="{{ $modelAdmin::CurrentUrl('delete/'.$modelItem->id) }}">
                                            <i class="fa fa-trash"></i>
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else 
                            <tr>
                                <td colspan="{{ count($modelAdmin->modelManager()->getSummaryFields())+2 }}">
                                    No {{ $modelAdmin->modelManager()->PluralTitle() }} Found
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="box-footer clearfix">
                    <div class="pull-left">
                        <a href="{{ $modelAdmin::CurrentUrl('create') }}" class="btn btn-success">
                            <i class="fa fa-{{ $modelAdmin::$icon }}"></i>
                            Add {{ $modelAdmin->modelManager()->Title() }}
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
