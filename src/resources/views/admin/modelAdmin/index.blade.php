@extends('flare::admin.sections.wrapper')

@section('page_title', 'Manage '.$modelAdmin::PluralTitle())

@section('content')

<div class="">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">
                        {{ $modelAdmin::PluralTitle() }}
                    </h3>
                </div>
                <div class="box-body no-padding">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="tight">ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($modelAdmin->model()->all() as $modelItem)    
                            <tr>
                                <td>
                                    {{ $modelItem->id }}.
                                </td>
                                <td>
                                    {{ $modelItem->name }}
                                </td>
                                <td>
                                    {{ $modelItem->email }}
                                </td>
                                <td>
                                    {{ $modelItem->created_at }}
                                </td>
                                <td>
                                    {{ $modelItem->updated_at }}
                                </td>
                                <td style="width: 1%; white-space:nowrap">
                                    <a class="btn btn-primary btn-xs" href="{{ $modelAdmin::URL() }}/edit/{{ $modelItem->id }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a class="btn btn-danger btn-xs" href="{{ $modelAdmin::URL() }}/delete/{{ $modelItem->id }}">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="box-footer clearfix">
                    <div class="pull-left">
                        <a href="{{ $modelAdmin::URL() }}/create" class="btn btn-success">
                            Add {{ $modelAdmin::Title() }}
                        </a>
                    </div>
                    <ul class="pagination pagination-sm no-margin pull-right">
                        <li><a href="#">&laquo;</a></li>
                        <li><a href="#">1</a></li>
                        <li><a href="#">&raquo;</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@stop