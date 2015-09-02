@extends('flare::admin.sections.wrapper')

@section('page_title', 'Manage '.$modelAdmin::PluralTitle())

@section('sidebar')
    @include('flare::admin.modelAdmin.sidebar')
@stop

@section('content')

<div class="">
    <h1>{{ $modelAdmin::PluralTitle() }}</h1>

    @foreach($modelAdmin->model('User')->getFillable() as $attribute)

        {!! $modelAdmin->viewAttribute($attribute) !!}

        {!! $modelAdmin->editNameAttribute() !!}

        <br><br>

    @endforeach

    This works aswell: $modelAdmin->viewNameAttribute() <br><br>

    This works aswell: $modelAdmin->editNameAttribute() <br><br>

    etc... <br><br>

    {{ var_dump($modelAdmin->model()) }}

</div>

@stop