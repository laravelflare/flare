<div class="box-footer clearfix">
    @if ($modelAdmin->hasCreating())
        <div class="pull-left">
            <a href="{{ $modelAdmin->currentUrl('create') }}" class="btn btn-success">
                <i class="fa fa-{{ $modelAdmin->getIcon() }}"></i>
                Add {{ $modelAdmin->getTitle() }}
            </a>
        </div>
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