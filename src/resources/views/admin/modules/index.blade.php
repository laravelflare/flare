@extends('flare::admin.sections.wrapper')

@section('page_title', 'Module Not Found')

@section('content')

    <section class="content">
        <div class="error-page">
            <h2 class="headline text-yellow">:/</h2>
            <div class="error-content" style="padding-top: 18px;">
                <h3>
                    <i class="fa fa-warning text-yellow"></i>
                    Your Module could not be found.
                </h3>
                <p>
                    <br>
                    It's possible you havn't created your Module View yet and you will therefore see this page. 
                    Modules allow you more flexibility and control over Flare ModelAdmins, however, they do require a more involved set up process.
                    You will need to, at a minimum, create a Module template. <br><br>

                    Read more about Modules in the <a href="{{ Flare::docsurl('modules') }}">Flare Docs</a>.
                </p>
            </div>
        </div>
    </section>

@endsection
