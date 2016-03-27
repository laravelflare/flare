<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

        <title>
            @yield('page_title', Flare::getSafeAdminTitle())
        </title>
        
        <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

        <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
        <link href="{{ asset('vendor/flare/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('vendor/flare/css/AdminLTE.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('vendor/flare/css/skins/skin-'.Flare::config('admin_theme').'.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('vendor/flare/plugins/datepicker/datepicker3.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('vendor/flare/plugins/morris/morris.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('vendor/flare/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('vendor/flare/plugins/pace/pace.min.css') }}" rel="stylesheet" type="text/css" />

        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script>
            var APP_URL = {!! json_encode(url('/')) !!};
            var ADMIN_URL = {!! json_encode(Flare::adminUrl()) !!};
        </script>

        @yield('enqueued-css')
    </head>
    <body class="hold-transition skin-{{ Flare::config('admin_theme') }} sidebar-mini">
