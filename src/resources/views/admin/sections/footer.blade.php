<footer class="main-footer">
    @if (Flare::show('version'))
        <span class="pull-right hidden-xs" style="padding-left: 10px; padding-top: 1px">
            Version: <b>{{ Flare::version() }}</b> 
        </span>
    @endif

    @if (Flare::show('github'))
        <a href="https://github.com/laravelflare/flare" target="_blank">
            <span class="btn btn-social-icon btn-github btn-xs">
                <i class="fa fa-github"></i>
            </span>
            <span class="text-red" style="padding-left: 10px; top: 1px; position: relative;">
                Laravel <strong>Flare</strong>
            </span>
        </a>
    @else
        <span class="text-{{ Flare::config('admin_theme') }} " style="padding-left: 10px; top: 1px; position: relative;">
            {{ Flare::getAdminTitle() }}
        </span>
    @endif
</footer>
