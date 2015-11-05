@extends('flare::admin.sections.wrapper')

@section('page_title', 'Restore '.$modelAdmin->title())

@section('content')

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">
            Restore {{ $modelAdmin->title() }}
        </h3>
    </div>
    <form action="" method="post">
        <div class="box-body">
            <div class="alert alert-info no-margin">
                <strong>
                    Are you sure you wish to restore this {{ $modelAdmin->title() }}?
                </strong>
                <p>
                    Once this {{ $modelAdmin->title() }} is restored it will be publically available again.
                </p>
            </div>
        </div>
        <div class="box-footer">
            {!! csrf_field() !!}
            <a href="{{ $modelAdmin::currentUrl() }}" class="btn btn-default">
                Cancel
            </a>
            <button class="btn btn-info" type="submit">
                <i class="fa fa-undo"></i>
                Restore {{ $modelAdmin->title() }}
            </button>
        </div>
    </form>
</div>

@stop
