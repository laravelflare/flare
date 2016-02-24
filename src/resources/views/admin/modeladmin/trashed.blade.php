@extends('flare::admin.sections.wrapper')
@section('page_title', $modelAdmin->getPluralTitle())
@section('content')

<div class="">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                   <div class="btn-group">
                        <a href="{{ $modelAdmin->currentUrl('trashed') }}" class="btn btn-default btn-flat">
                            Trashed Only
                            <span class="badge bg-red" style="margin-left: 15px">{{ $totals['only_trashed'] }}</span>
                        </a>
                        <button data-toggle="dropdown" class="btn btn-default btn-flat dropdown-toggle" type="button">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul role="menu" class="dropdown-menu">
                            <li>
                                <a href="{{ $modelAdmin->currentUrl() }}">
                                    <span style="display:inline-block; width: 100px;">
                                        All {{ $modelAdmin->getPluralTitle() }}
                                    </span>
                                    <span class="badge bg-green">{{ $totals['all'] }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ $modelAdmin->currentUrl('all') }}">
                                    <span style="display:inline-block; width: 100px;">
                                        With Trashed
                                    </span>
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
