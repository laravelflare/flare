@extends('flare::admin.sections.wrapper')
@section('page_title', 'Dashboard')
@section('content')

    <div class="row">
        @if (count($widgets->all()) > 0)
            @foreach ($widgets->all() as $widget)
                {!! $widget->render() !!}
            @endforeach
        @else 
            <div class="col-xs-12">
                <p>
                    Add some widgets to your configuration and they will appear on your Dashboard or define some Models for Flare to manage and some widgets will be created automatically.
                </p>
            </div>
        @endif
    </div>

@endsection
