@extends('flare::admin.sections.wrapper')

@section('page_title', $modelAdmin::title())

@section('content')

<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">
            Create {{ $modelAdmin->title() }}
        </h3>
    </div>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="box-body">
            @foreach ($modelAdmin->getFields() as $attribute => $field)
                {!! \Flare::renderAttribute('add', $attribute, $field, false, $modelAdmin) !!}
            @endforeach
        </div>
        <div class="box-footer">
            {!! csrf_field() !!}
            <a href="{{ $modelAdmin::currentUrl() }}" class="btn btn-default">
                Cancel
            </a>
            <button class="btn btn-success" type="submit">
                Add {{ $modelAdmin->title() }}
            </button>
        </div>
    </form>
</div>

@stop
