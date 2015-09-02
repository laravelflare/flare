@extends('flare::admin.sections.wrapper')

@section('page_title', 'View '.$modelAdmin::Title())

@section('sidebar')
    @include('flare::admin.modelAdmin.sidebar')
@stop

@section('content')

<div class="">
    <h1>View {{ $modelAdmin::Title() }}</h1>


</div>

@stop