@extends('flare::admin.sections.wrapper')

@section('page_title', 'Create '.$modelAdmin::Title())

@section('sidebar')
    @include('flare::admin.modelAdmin.sidebar')
@stop

@section('content')

<div class="">
    <h1>Create {{ $modelAdmin::Title() }}</h1>


</div>

@stop