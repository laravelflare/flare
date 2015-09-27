@extends('flare::admin.sections.wrapper')

@section('page_title', 'Dashboard')

@section('content')

<div class="row">

    @if (count($widgetAdminCollection) > 0)
        @foreach ($widgetAdminCollection as $widget)

            {!! $widget->render() !!}

        @endforeach
    @else 
        @if (count($modelAdminCollection) > 0)
            @foreach($modelAdminCollection as $modelAdmin)
                @foreach ($modelAdmin->getManagedModels() as $managedModel)
                    {!! (new $managedModel())->defaultWidget()->render() !!}
                @endforeach
            @endforeach
        @else
            <div class="col-xs-12">
                <p>
                    Add some widgets to your configuration and they will appear on your Dashboard or define some Models for Flare to manage and some widgets will be created automatically.
                </p>
            </div>
        @endif
    @endif

</div>

@stop
