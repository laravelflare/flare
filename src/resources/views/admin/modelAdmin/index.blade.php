@extends('flare::admin.sections.wrapper')

@section('page_title', 'Model Admin')

@section('content')

<div class="">
    <h1>{{ $modelAdmin::PluralTitle() }}</h1>

    {{ var_dump($modelAdmin->model()) }}

</div>

@stop