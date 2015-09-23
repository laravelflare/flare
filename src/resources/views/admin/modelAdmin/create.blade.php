@extends('flare::admin.sections.wrapper')

@section('page_title', $modelAdmin::Title())

@section('content')

<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">
            Create {{ $modelAdmin->modelManager()->Title() }}
        </h3>
    </div>
    <form action="" method="post">
        <div class="box-body">
            @foreach ($modelAdmin->modelManager()->getMapping() as $attribute => $field)
                {!! \Flare::addAttribute($attribute, $field, false, $modelAdmin->modelManager()) !!}
            @endforeach
        </div>
        <div class="box-footer">
            {!! csrf_field() !!}
            <a href="{{ $modelAdmin::CurrentUrl() }}" class="btn btn-default">
                Cancel
            </a>
            <button class="btn btn-success" type="submit">
                Add {{ $modelAdmin->modelManager()->Title() }}
            </button>
        </div>
    </form>
</div>

@stop