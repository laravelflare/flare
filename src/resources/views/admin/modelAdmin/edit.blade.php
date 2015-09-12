@extends('flare::admin.sections.wrapper')

@section('page_title', 'Edit '.$modelAdmin::Title())

@section('content')

<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">{{ $modelAdmin::Title() }} Attributes</h3>
    </div>
    <form action="" method="post">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group @if ($errors->has('name')) has-error @endif">
                        <label class="control-label" for="name">Name *</label>
                        <input class="form-control" type="text" name="name" id="name" value="{{ old('name', $modelItem->name) }}">
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <i class="fa fa-times-circle-o"></i>
                                {{ $errors->first('name') }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group @if ($errors->has('email')) has-error @endif">
                        <label class="control-label" for="email">Email *</label>
                        <input class="form-control" type="text" name="email" id="email" value="{{ old('email', $modelItem->email) }}">
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <i class="fa fa-times-circle-o"></i>
                                {{ $errors->first('email') }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group @if ($errors->has('password')) has-error @endif">
                        <label class="control-label" for="password">Password *</label>
                        <input class="form-control" type="password" name="password" id="password" value="{{ old('password', $modelItem->password) }}">
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <i class="fa fa-times-circle-o"></i>
                                {{ $errors->first('password') }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            {{--        
                    @foreach($modelAdmin->model()->getFillable() as $attribute)
                        {!! $modelAdmin->editAttribute($attribute) !!}
                    @endforeach
                --}}
        </div>
        <div class="box-footer">
            {!! csrf_field() !!}
            <a href="{{ $modelAdmin::URL() }}" class="btn btn-default">
                Cancel
            </a>
            <button class="btn btn-success" type="submit">
                Update {{ $modelAdmin::Title() }}
            </button>
        </div>
    </form>
</div>

@stop