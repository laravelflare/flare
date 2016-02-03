@extends('flare::admin.sections.wrapper')
@section('page_title', 'Page Not Found')
@section('content')

    <section class="content">
        <div class="error-page">
            <h2 class="headline text-yellow">
                404
            </h2>
            <div class="error-content" style="padding-top: 18px;">
                <h3>
                    <i class="fa fa-warning text-yellow"></i>
                    Oops! Page not found.
                </h3>
                <p>
                    We could not find the page you were looking for. <br>
                    Please <a href="{{ Flare::adminUrl() }}">return to dashboard</a>.
                </p>
            </div>
        </div>
    </section>

@endsection
