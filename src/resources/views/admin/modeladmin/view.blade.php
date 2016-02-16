@extends('flare::admin.sections.wrapper')
@section('page_title', $modelAdmin->getTitle())
@section('content')

<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">
            View {{ $modelAdmin->getTitle() }}
        </h3>
    </div>
    <form action="" method="post">
        <div class="box-body">
            @foreach ($modelAdmin->outputFields() as $attribute => $field)
                {{ $field->render('view') }}
            @endforeach
        </div>
        <div class="box-footer">
            {!! csrf_field() !!}
            <a href="{{ $modelAdmin->currentUrl() }}" class="btn btn-default">
                Back
            </a>
            @if ($modelAdmin->hasEditting())
                <a href="{{ $modelAdmin->currentUrl('edit/'.$modelItem->getKey()) }}" class="btn btn-primary">
                    <i class="fa fa-edit"></i>
                    Edit {{ $modelAdmin->getTitle() }}
                </a>
            @endif
            @if ($modelAdmin->hasDeleting() && ($modelAdmin->hasSoftDeleting() && $modelItem->trashed()))
                <a href="{{ $modelAdmin->currentUrl('restore/'.$modelItem->getKey()) }}" class="btn btn-info">
                    <i class="fa fa-undo"></i>
                    Restore
                </a>
            @elseif ($modelAdmin->hasCloning())
                <a href="{{ $modelAdmin->currentUrl('clone/'.$modelItem->getKey()) }}" class="btn btn-warning">
                    <i class="fa fa-clone"></i>
                    Clone
                </a>
            @endif
            @if ($modelAdmin->hasDeleting())
                <a href="{{ $modelAdmin->currentUrl('delete/'.$modelItem->getKey()) }}" class="btn btn-danger">
                    <i class="fa fa-trash"></i>
                    @if (!$modelAdmin->hasSoftDeleting() || $modelItem->trashed())
                        Delete
                    @else 
                        Trash
                    @endif
                </a>
            @endif
        </div>
    </form>
</div>

@endsection
