@extends('flare::admin.sections.wrapper')

@section('page_title', $modelAdmin->Title())

@section('content')

<div class="">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">
                        {{ $modelAdmin->modelManager()->PluralTitle() }}
                    </h3>
                </div>
                <div class="box-body no-padding">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                @foreach ($modelAdmin->modelManager()->getSummaryFields() as $key => $field)
                                <th {{ ($key == 'id' ? 'style="tight"' : '') }} style="tight">
                                    {{ $field }}
                                </th>
                                @endforeach
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($modelAdmin->modelManager()->items() as $modelItem)    
                            <tr>
                                @foreach ($modelAdmin->modelManager()->getSummaryFields() as $key => $field)
                                <td>
                                    {{ $modelAdmin->modelManager()->getAttribute($key, $modelItem) }}
                                </td>
                                @endforeach
                                <td style="width: 1%; white-space:nowrap">
                                    <a class="btn btn-primary btn-xs" href="{{ $modelAdmin::CurrentUrl() }}/edit/{{ $modelItem->id }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a class="btn btn-danger btn-xs" href="{{ $modelAdmin::CurrentUrl() }}/delete/{{ $modelItem->id }}">
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
                        <a href="{{ $modelAdmin::CurrentUrl('create') }}" class="btn btn-success">
                            Add {{ $modelAdmin->modelManager()->Title() }}
                        </a>
                    </div>

                    @if ($modelAdmin->modelManager()->getPerPage())
                    <div class="pull-right" style="margin-top: -20px; margin-bottom: -20px;">
                        {!! $modelAdmin->modelManager()->items()->render() !!}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@stop