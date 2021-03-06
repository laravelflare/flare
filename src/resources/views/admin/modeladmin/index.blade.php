@extends('flare::admin.sections.wrapper')
@section('page_title', $modelAdmin->getPluralTitle()) 
@section('content')

<div class="">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <div class="btn-group">
                        <a href="{{ $modelAdmin->currentUrl(\Request::get('filter') ? '?filter='.\Request::get('filter') : false) }}" class="btn btn-default btn-flat">
                            @if($modelAdmin->hasTranslating())
                                <i class="fa fa-globe" style="margin-right: 5px"></i>
                            @endif
                            All {{ $modelAdmin->getPluralEntityTitle() }}
                            <span class="badge bg-green" style="margin-left: 15px">
                                {{ $totals['all'] }}
                            </span>
                        </a>
                        @if ($modelAdmin->hasSoftDeleting())
                            <button data-toggle="dropdown" class="btn btn-default btn-flat dropdown-toggle" type="button">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul role="menu" class="dropdown-menu">
                                <li>
                                    <a href="{{ $modelAdmin->currentUrl(\Request::get('filter') ? 'all?filter='.\Request::get('filter') : 'all') }}">
                                        With Trashed
                                        <span class="badge bg-yellow">{{ $totals['with_trashed'] }}</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ $modelAdmin->currentUrl(\Request::get('trashed') ? 'trashed?filter='.\Request::get('filter') : 'trashed') }}">
                                        Trashed Only
                                        <span class="badge bg-red">{{ $totals['only_trashed'] }}</span>
                                    </a>
                                </li>
                            </ul>
                        @endif
                    </div>
                    @if($modelAdmin->hasSearch ?? false)
                        <div class="box-tools pull-right" style="margin-top: 7px; width: 200px;">
                            <form action="" method="get">
                                <div class="input-group">
                                    <input type="text" class="form-control input-sm" placeholder="Search {{ $modelAdmin->getPluralTitle() }}" name="query">

                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-primary btn-sm btn-flat">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                    
                    @include('flare::admin.modeladmin.includes.header.filter', ['type' => null])
                </div>
                
                @include('flare::admin.modeladmin.includes.modelitem-list')
                
                @include('flare::admin.modeladmin.includes.modelitem-list-footer')

            </div>
        </div>
    </div>
</div>

@endsection
