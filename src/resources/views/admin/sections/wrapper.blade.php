@include('flare::admin.sections.head')

<div class="wrapper">

        @include('flare::admin.sections.header')

        <div class="content-wrapper">
                <section class="content-header">
                    <h1>
                        @yield('page_title')
                        <small>{{ $page_description or null }}</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
                        <li class="active">Here</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">          
                    @yield('content')
                </section>
        </div>

        @include('flare::admin.sections.sidebar')

</div>

@include('flare::admin.sections.footer')