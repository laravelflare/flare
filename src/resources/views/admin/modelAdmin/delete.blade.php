@extends('flare::admin.sections.wrapper')

@section('page_title', $modelAdmin::title())

@section('content')

<div class="box box-danger">
    <div class="box-header with-border">
        <h3 class="box-title">
            Delete {{ $modelAdmin->modelManager()->title() }}
        </h3>
    </div>
    <form action="" method="post">
        <div class="box-body">
            <div class="alert alert-danger">
                <i class="icon fa fa-danger"></i>
                Are you sure you wish to delete this {{ $modelAdmin->modelManager()->title() }}?
            </div>
        </div>
        <div class="box-footer">
            {!! csrf_field() !!}
            <a href="{{ $modelAdmin::currentUrl() }}" class="btn btn-default">
                Cancel
            </a>
            <button class="btn btn-danger" type="submit">
                <i class="fa fa-trash"></i>
                Delete {{ $modelAdmin->modelManager()->title() }}
            </button>
        </div>
    </form>
</div>

@stop
