<div class="row">
    <div class="col-sm-6">
        <div class="form-group @if ($errors->has($attribute)) has-error @endif">
            <label class="control-label" for="{{ $attribute }}">
                {{ $attributeTitle }} @if (isset($field['required'])) * @endif
            </label>
            <textarea id="{{ $attribute }}"
                        class="form-control {{ $field['class'] or null }}"
                        name="{{ $attribute }}"
                        @if (isset($field['required'])) required="required" @endif>{{ old($attribute) }}</textarea>
            
            @if(isset($field['help']))
                <p class="help-block">{!! $field['help'] !!}</p>
            @endif
            
            @if ($errors->has($attribute))
                <p class="help-block">
                    <strong>{{ $errors->first($attribute) }}</strong>
                </p>
            @endif
        </div>
    </div>
</div>

@section('enqueued-js')
    <script>
    $(function () {
        $("#{{ $attribute }}").wysihtml5();
    });
    </script>
@append 