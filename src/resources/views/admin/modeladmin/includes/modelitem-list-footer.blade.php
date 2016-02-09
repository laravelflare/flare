<div class="box-footer clearfix">
    <div class="pull-left">
        <a href="{{ $modelAdmin->currentUrl('create') }}" class="btn btn-success">
            <i class="fa fa-{{ $modelAdmin->getIcon() }}"></i>
            Add {{ $modelAdmin->getTitle() }}
        </a>
    </div>

    @if ($modelAdmin->getPerPage())
    <div class="pull-right" style="margin-top: -20px; margin-bottom: -20px;">
        {!! $modelAdmin->items()->appends([
                                                            'sort' => $modelAdmin->sortBy() == 'asc' ? 'asc' : null,
                                                            'order' => $modelAdmin->orderBy(),
                                                        ])->render() !!}
    </div>
    @endif
</div>