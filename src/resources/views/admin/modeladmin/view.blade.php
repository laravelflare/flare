@extends('flare::admin.sections.wrapper')

@section('page_title', $modelAdmin::title())

@section('content')

<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">
            Create {{ $modelAdmin->title() }}
        </h3>
    </div>
    <form action="" method="post">
        <div class="box-body">
            @foreach ($modelAdmin->getFields() as $attribute => $field)
                {!! \Flare::renderAttribute('view', $attribute, $field, $modelItem, $modelAdmin) !!}
            @endforeach
        </div>
        <div class="box-footer">
            {!! csrf_field() !!}
            <a href="{{ $modelAdmin::currentUrl() }}" class="btn btn-default">
                Back
            </a>
            <a href="{{ $modelAdmin::currentUrl('edit/'.$modelItem->getKey()) }}" class="btn btn-primary">
                <i class="fa fa-edit"></i>
                Edit {{ $modelAdmin->title() }}
            </a>
            <a href="{{ $modelAdmin::currentUrl('clone/'.$modelItem->getKey()) }}" class="btn btn-warning">
                <i class="fa fa-clone"></i>
                Clone {{ $modelAdmin->title() }}
            </a>
            <a href="{{ $modelAdmin::currentUrl('delete/'.$modelItem->getKey()) }}" class="btn btn-danger">      
                <i class="fa fa-trash"></i>      
                @if (!$modelAdmin->hasSoftDeletes() || $modelItem->trashed())
                Delete
                @else 
                Trash
                @endif
            </a>
        </div>
    </form>
</div>

@stop
