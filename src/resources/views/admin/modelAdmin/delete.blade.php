@extends('flare::admin.sections.wrapper')

@section('page_title', 'Delete '.$modelAdmin::Title())

@section('content')

<div class="box box-danger">
    <div class="box-header with-border">
        <h3 class="box-title">Delete {{ $modelAdmin::Title() }}</h3>
    </div>
    <form action="" method="post">
        <div class="box-body">
            <div class="alert alert-danger">
                <i class="icon fa fa-danger"></i>
                Are you sure you wish to delete this {{ $modelAdmin::Title() }}?
            </div>
        </div>
        <div class="box-footer">
            {!! csrf_field() !!}
            <a href="{{ $modelAdmin::URL() }}" class="btn btn-default">
                Cancel
            </a>
            <button class="btn btn-danger" type="submit">
                Delete {{ $modelAdmin::Title() }}
            </button>
        </div>
    </div>
</div>

@stop