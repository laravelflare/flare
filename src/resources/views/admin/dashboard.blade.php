@extends('flare::admin.sections.wrapper')

@section('page_title', 'Dashboard')

@section('content')

<div class="row">

    @if (count($widgetAdminCollection) > 0)
        @foreach ($widgetAdminCollection as $widget)

            {!! $widget->render() !!}

        @endforeach
    @else 

        <div class="col-xs-12">
            <p>
                <strong>Dashboard coming soon...</strong>
                <br><br>
                Add some widgets here to customize your Dashboard.
            </p>
        </div>

    @endif

</div>

@stop