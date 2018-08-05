        <!-- Filthy, even though Vue is god damn gorgeous -->
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('vendor/flare/plugins/jQuery/jQuery-2.2.0.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('vendor/flare/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('vendor/flare/js/app.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('vendor/flare/plugins/morris/morris.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('vendor/flare/plugins/select2/select2.full.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('vendor/flare/plugins/input-mask/jquery.inputmask.js') }}"></script>
        <script src="{{ asset('vendor/flare/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
        <script src="{{ asset('vendor/flare/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
        <script src="{{ asset('vendor/flare/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
        <script src="{{ asset('vendor/flare/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
        <script src="{{ asset('vendor/flare/plugins/pace/pace.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js" type="text/javascript"></script>
        <script src="{{ asset('vendor/flare/plugins/daterangepicker/daterangepicker.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js" type="text/javascript"></script>

        @yield('enqueued-js')
    </body>
</html>