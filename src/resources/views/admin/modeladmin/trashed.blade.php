@extends('flare::admin.sections.wrapper')
@section('page_title', $modelAdmin->getPluralEntityTitle())
@section('content')

<div class="">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                   <div class="btn-group">
                        <a href="{{ $modelAdmin->currentUrl(\Request::get('filter') ? 'trashed?filter='.\Request::get('filter') : 'trashed') }}" class="btn btn-default btn-flat">
                            Trashed Only
                            <span class="badge bg-red" style="margin-left: 15px">{{ $totals['only_trashed'] }}</span>
                        </a>
                        <button data-toggle="dropdown" class="btn btn-default btn-flat dropdown-toggle" type="button">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul role="menu" class="dropdown-menu">
                            <li>
                                <a href="{{ $modelAdmin->currentUrl(\Request::get('filter') ? '?filter='.\Request::get('filter') : false)  }}">
                                    All {{ $modelAdmin->getPluralEntityTitle() }}
                                    <span class="badge bg-green">{{ $totals['all'] }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ $modelAdmin->currentUrl(\Request::get('filter') ? 'all?filter='.\Request::get('filter') : 'all')  }}">
                                    With Trashed
                                    <span class="badge bg-yellow">{{ $totals['with_trashed'] }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    @include('flare::admin.modeladmin.includes.header.filter', ['type' => 'trashed'])
                </div>
                
                @include('flare::admin.modeladmin.includes.modelitem-list')
                
                @include('flare::admin.modeladmin.includes.modelitem-list-footer')

            </div>
        </div>
    </div>
</div>

@endsection
