<div class="box-body no-padding">
    <table class="table table-striped">
        <thead>
            @include('flare::admin.modeladmin.includes.table.thead-row')
        </thead>
        <tbody>
        @if ($modelItems->count() > 0)    
            @foreach($modelItems as $modelItem)    
                @include('flare::admin.modeladmin.includes.table.tbody-row')
            @endforeach
        @else 
            @include('flare::admin.modeladmin.includes.table.tbody-row-not-found')
        @endif
        </tbody>
    </table>
</div>