@extends('flare::admin.sections.wrapper')
@section('page_title', $modelAdmin->getEntityTitle())
@section('content')

<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">
            View {{ $modelAdmin->getEntityTitle() }}
        </h3>
    </div>
    @if($modelAdmin->hasLanguages())
        <div class="box-body">
            <label style="padding: 7px 10px 0">
                View Language:
            </label>
            @foreach($modelAdmin->languages() as $key => $language)
                <a href="{{ $modelAdmin->modelHasLanguage($modelAdmin->model, $key)
                          ? $modelAdmin->routeToViewModelTranslation($key, $modelAdmin->model)
                          : $modelAdmin->routeToCreateModelTranslation($key, $modelAdmin->model)
                    }}" class="btn {{ $modelAdmin->isLanguage($key) ? 'btn-info' : 'btn-default' }} btn-flat">
                    {{ $modelAdmin->modelHasLanguage($modelAdmin->model, $key) ? $language : 'Add '.$language }}
                </a>
            @endforeach
        </div>
    @endif
    <form action="" method="post">
        <div class="box-body">
            @foreach ($modelAdmin->outputFields() as $attribute => $field)
                {{ $field->render('view') }}
            @endforeach
        </div>
        <div class="box-footer">
            {!! csrf_field() !!}

            @include('flare::admin.modeladmin.includes.actions.before')

            @include('flare::admin.modeladmin.includes.actions.back')

            @if ($modelAdmin->hasRouting())
                @include('flare::admin.modeladmin.includes.actions.route')
            @endif
            @if ($modelAdmin->hasEditing())
                @include('flare::admin.modeladmin.includes.actions.edit')
            @endif
            @if ($modelAdmin->hasDeleting() && ($modelAdmin->hasSoftDeleting() && $modelItem->trashed()))
                @include('flare::admin.modeladmin.includes.actions.restore')
            @elseif ($modelAdmin->hasCloning())
                @include('flare::admin.modeladmin.includes.actions.clone')
            @endif
            @if ($modelAdmin->hasDeleting())
                @include('flare::admin.modeladmin.includes.actions.delete')
            @endif

            @include('flare::admin.modeladmin.includes.actions.after')
        </div>
    </form>
</div>

@endsection
