        <footer class="main-footer">
            <span class="pull-right hidden-xs" style="padding-left: 10px; padding-top: 1px">
                Version: <b>alpha</b> 
            </span>
            <a href="https://github.com/JacobBaileyLtd/flare" target="_blank">
                <span class="btn btn-social-icon btn-github btn-xs">
                    <i class="fa fa-github"></i>
                </span>
                <span class="text-red" style="padding-left: 10px; top: 1px; position: relative;">
                    Laravel <strong>Flare</strong>
                </span>
        </footer>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="{{ asset ('vendor/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset ('vendor/flare/dist/js/app.min.js') }}" type="text/javascript"></script>

        {{-- @yield('enqueued-js') --}}
    </body>
</html>