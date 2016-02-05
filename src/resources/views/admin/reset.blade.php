@include('flare::admin.sections.head')
 
    <div class="container-fluid" style="padding-top: 120px">
        <div class="row">
            <div class="col-md-6 col-lg-4 col-md-offset-3 col-lg-offset-4">
                <h1 class="text-{{ Flare::config('admin_theme') }}" style="text-align: center; padding-bottom: 40px;">
                    {!! Flare::config('admin_title') !!}
                </h1>

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

                    <form class="form-horizontal" role="form" method="POST" action="{{ route('flare::reset') }}">
                        {!! csrf_field() !!}

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{{ $email or old('email') }}">
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password">
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Confirm Password</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password_confirmation">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-refresh"></i>Reset Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-lg-12" style="padding-top: 30px;text-align: center;">
                    <a class="text-{{ Flare::config('admin_theme') }}" style="border-bottom: 1px dotted;" href="{{ route('flare::login') }}">
                        Login
                    </a>
                </div>
            </div>
        </div>
    </div>

@include('flare::admin.sections.foot')
