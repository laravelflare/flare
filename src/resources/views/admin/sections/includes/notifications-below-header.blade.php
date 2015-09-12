@if (Session::has('notifications_below_header'))
    <section class="content-header notifications">
        @foreach (Session::get('notifications_below_header') as $notification)
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-{{ (isset($notification['type']) ? $notification['type'] : 'info' )}} {{ (isset($dismissable) && $dismissable) ? 'alert-dismissible' : '' }}">
                        @if (isset($notification['dismissable']) && $notification['dismissable'])
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        @endif
                        @if (isset($notification['title']))
                        <h4>
                            @if (isset($notification['icon']))
                            <i class="icon fa fa-{{ $notification['icon'] }}"></i>
                            @endif
                            {{ $notification['title'] }}
                        </h4>
                        @else
                            @if (isset($notification['icon']))
                            <i class="icon fa fa-{{ $notification['icon'] }}"></i>
                            @endif
                        @endif
                        @if (isset($notification['message']))
                        {!! $notification['message'] !!}
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </section>
@endif
