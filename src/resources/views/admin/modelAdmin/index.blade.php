@extends('flare::admin.sections.wrapper')

@section('page_title', 'Manage '.$modelAdmin::PluralTitle())

@section('sidebar')
    @include('flare::admin.modelAdmin.sidebar')
@stop

@section('content')

<div class="">
    <h1>{{ $modelAdmin::PluralTitle() }}</h1>

    {{ var_dump($modelAdmin->model()) }}

</div>

@stop