<div class="row">
    <div class="col-sm-6">
        <div class="form-group @if ($errors->has($attribute)) has-error @endif">
            <label class="control-label" for="{{ $attribute }}">
                {{ $attributeTitle }} @if (isset($field['required'])) * @endif
            </label>

            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text"
                        name="{{ $attribute }}"
                        id="{{ $attribute }}"
                        data-mask="" 
                        data-inputmask="'alias': '{{ (isset($field['inputmask']) ? $field['inputmask'] : '') }}'"
                        class="form-control focus.inputmask"
                        value="">
            </div>

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
        $("#{{ $attribute }}").inputmask("{{ (isset($field['inputmask']) ? $field['inputmask'] : '') }}", {"placeholder": "{{ (isset($field['inputmask']) ? $field['inputmask'] : '') }}"});
    });
    </script>
@append
