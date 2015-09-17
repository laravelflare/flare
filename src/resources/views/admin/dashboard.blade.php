@extends('flare::admin.sections.wrapper')

@section('page_title', 'Dashboard')

@section('content')

    <p>Dashboard coming soon.</p>

    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>1</h3>
                    <p>User Registrations</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a class="small-box-footer" href="{{ url('admin/users') }}">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

    </div><!-- /.row -->

@stop