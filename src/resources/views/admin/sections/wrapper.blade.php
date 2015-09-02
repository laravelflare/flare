@include('flare::admin.sections.head')

    <div class="wrapper" style="background: #373a3c;">
        @include('flare::admin.sections.navbar')

        <aside class="sidebar col-lg-2">
            @yield('sidebar')
        </aside>

        <div class="col-lg-10 wrapper-content" style="background: white;">
            @yield('content')
        </div>
    </div>

@include('flare::admin.sections.footer')