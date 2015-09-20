@include('flare::admin.sections.head')

<div class="wrapper">

        @include('flare::admin.sections.header')

        <div class="content-wrapper">
            
                @include('flare::admin.sections.includes.notifications-above-header')

                <section class="content-header">
                    <h1>
                        @yield('page_title')
                        <small>
                            @yield('page_description', '')
                        </small>
                    </h1>
                </section>

                @include('flare::admin.sections.includes.notifications-below-header')

                <section class="content">          
                    @yield('content')
                </section>

        </div>

        @include('flare::admin.sections.sidebar')

</div>

@include('flare::admin.sections.footer')

@include('flare::admin.sections.foot')