@extends('flare::admin.sections.wrapper')
@section('page_title', 'Delete '.$modelAdmin->getTitle())
@section('content')

<div class="box box-danger">
    <div class="box-header with-border">
        <h3 class="box-title">
            Delete {{ $modelAdmin->getTitle() }}
        </h3>
    </div>
    <form action="" method="post">
        <div class="box-body">
            <div class="alert alert-danger no-margin">
                <i class="icon fa fa-exclamation-triangle"></i>
                @if (!$modelAdmin->hasSoftDeletes() || $modelItem->trashed())
                    <strong>Are you sure you wish to permanently delete this {{ $modelAdmin->getTitle() }}?</strong>
                    <p>
                        Once a {{ $modelAdmin->getTitle() }} is permanently deleted it can no longer be recovered.
                    </p>
                @else 
                    <strong>Are you sure you wish to trash this {{ $modelAdmin->getTitle() }}?</strong>
                    <p>
                        The {{ $modelAdmin->getTitle() }} will be sent to the trash, where it can either be restored or deleted permanently.
                    </p>
                @endif
            </div>
        </div>
        <div class="box-footer">
            {!! csrf_field() !!}
            <a href="{{ $modelAdmin->currentUrl() }}" class="btn btn-default">
                Cancel
            </a>
            <button class="btn btn-danger" type="submit">
                <i class="fa fa-trash"></i>
                @if (!$modelAdmin->hasSoftDeletes() || $modelItem->trashed())
                    Delete {{ $modelAdmin->getTitle() }}
                @else 
                    Trash {{ $modelAdmin->getTitle() }}
                @endif
            </button>
        </div>
    </form>
</div>

@endsection
