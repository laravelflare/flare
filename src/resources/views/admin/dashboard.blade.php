@extends('flare::admin.sections.wrapper')

@section('page_title', 'Dashboard')

@section('content')

  <div class="row">
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-green">
        <div class="inner">
          <h3>1</h3> @get('somethign')
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

    {{--<div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box bg-aqua">
        <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Bookmarks</span>
          <span class="info-box-number">41,410</span>
          <div class="progress">
            <div style="width: 70%" class="progress-bar"></div>
          </div>
          <span class="progress-description">
            70% Increase in 30 Days
          </span>
        </div><!-- /.info-box-content -->
      </div><!-- /.info-box -->
    </div>--}}
  </div><!-- /.row -->

@stop