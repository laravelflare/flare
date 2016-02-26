@if (method_exists($modelAdmin, 'modelitemListFooter'))
    {{ $modelAdmin->modelitemListFooter($modelItems) }}
@else
    <div class="box-footer clearfix">
        @if ($modelAdmin->hasCreating())
            @include('flare::admin.modeladmin.includes.actions.create')
        @endif

        @if ($modelAdmin->getPerPage())
            <div class="pull-right" style="margin-top: -20px; margin-bottom: -20px;">
                {!! $modelItems->appends([
                                        'sort' => $modelAdmin->sortBy() == 'asc' ? 'asc' : null,
                                        'order' => $modelAdmin->orderBy(),
                                        'filter' => \Request::get('filter'),
                                    ])->render() !!}
            </div>
        @endif
    </div>
@endif
