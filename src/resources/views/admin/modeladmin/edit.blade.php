@extends('flare::admin.sections.wrapper')

@section('page_title', $modelAdmin->getTitle())

@section('content')

<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">
            Edit {{ $modelAdmin->getTitle() }}
        </h3>
    </div>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="box-body">
            @foreach ($modelAdmin->getFields() as $attribute => $field)
                {!! \Flare::attributes()->renderAttribute('edit', $attribute, $field, $modelItem, $modelAdmin) !!}
            @endforeach
        </div>
        <div class="box-footer">
            {!! csrf_field() !!}
            <a href="{{ $modelAdmin->currentUrl() }}" class="btn btn-default">
                Cancel
            </a>
            <button class="btn btn-primary" type="submit">
                <i class="fa fa-edit"></i>
                Update {{ $modelAdmin->getTitle() }}
            </button>
        </div>
    </form>
</div>

@endsection
