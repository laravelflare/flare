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
            @foreach ($modelAdmin->modelManager()->getMapping() as $key => $field)
            {{ var_dump($key) }}
            {{ var_dump($field) }}
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group @if ($errors->has($key)) has-error @endif">
                        <label class="control-label" for="{{ $key }}">{{ $key }}</label>
                        <input class="form-control" type="text" name="{{ $key }}" id="{{ $key }}" value="{{ old($key) }}">
                        @if ($errors->has($key))
                            <span class="help-block">{{ $errors->first($key) }}</span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="box-footer">
            {!! csrf_field() !!}
            <a href="{{ $modelAdmin::CurrentUrl() }}" class="btn btn-default">
                Cancel
            </a>
            <button class="btn btn-success" type="submit">
                Add {{ $modelAdmin::Title() }}
            </button>
        </div>
    </form>
</div>

@stop