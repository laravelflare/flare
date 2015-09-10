@extends('flare::admin.sections.wrapper')

@section('page_title', 'Create '.$modelAdmin::Title())

@section('content')

<div class="">
    <h1>Create {{ $modelAdmin::Title() }}</h1>

    <form action="" method="post">
        @foreach($modelAdmin->model()->getFillable() as $attribute)

            {!! $modelAdmin->editAttribute($attribute) !!}

        @endforeach

        {!! csrf_field() !!}

        <input type="submit">
    </form>
</div>

@stop