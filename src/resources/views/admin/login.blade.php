<!DOCTYPE html>
<html>
  <head>
      <meta charset="UTF-8">
      <title>@yield('page_title')</title>
      <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
      <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
      <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
      <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
      <link href="{{ asset('vendor/flare/dist/css/AdminLTE.min.css') }}" rel="stylesheet" type="text/css" />
      <link href="{{ asset('vendor/flare/dist/css/skins/skin-red.min.css') }}" rel="stylesheet" type="text/css" />

      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
      <![endif]-->

      {{-- @yield('enqueued-css')--}}
  </head>
  <body class="hold-transition skin-red sidebar-mini fixed">
    <style>
      body {
        background: #d73925;
      }
    </style>
    <div class="container-fluid" style="padding-top: 120px">
      <div class="row">
        <div class="col-md-6 col-lg-4 col-md-offset-3 col-lg-offset-4">
          <h1 style="text-align: center; color: white; padding-bottom: 40px;">Laravel <b>Flare</b></h1>

          <div style="margin: 0 20px; padding: 40px 25px 35px; border: 1px solid rgba(255,255,255,0.15); box-shadow: 0 4px 20px rgba(0,0,0,0.15)">
            @if (count($errors) > 0)
            <div style="padding-left: 15px; padding-right: 15px">
              <div class="alert alert-warning">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            </div>
            @endif

            <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/login') }}">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">

              <div class="form-group" style="padding-left: 15px; padding-right: 15px;">
                <div class="col-md-12">
                  <input type="email" class="form-control" placeholder="Email Address" name="email" value="{{ old('email') }}">
                </div>
              </div>

              <div class="form-group" style="padding-left: 15px; padding-right: 15px;">
                <div class="col-md-12">
                  <input type="password" class="form-control" placeholder="Password" name="password">
                </div>
              </div>

              <div class="col-md-6">
                <div class="checkbox">
                  <label style="color: white;">
                    <input type="checkbox" name="remember"> Remember Me
                  </label>
                </div>
              </div>
              <div class="col-md-6">
                <button type="submit" class="btn btn-default pull-right">Login</button>

                {{--<a class="btn btn-link" href="{{ url('/admin/password') }}">Forgot Your Password?</a>--}}
              </div>

              <div class="clearfix"></div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>