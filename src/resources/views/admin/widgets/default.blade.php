<div class="col-xs-12 col-md-3">
    <div class="small-box bg-{{ $bgColour }}">
        <div class="inner">
            <h4>
                <strong>
                    {{ $pluralTitle }}
                </strong>
            </h4>
            <p>
                Currently: {{ $modelTotal }}
            </p>
        </div>
        <div class="icon">
            <i class="fa fa-{{ $icon }}"></i>
        </div>
        <a class="small-box-footer" href="{{ Flare::adminUrl() }}">
            View {{ $pluralTitle }} <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div>
</div>