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
                        data-inputmask="'alias': '{{ (isset($field['inputmask']) ? $field['inputmask'] : 'yyyy/mm/dd') }}'"
                        class="form-control focus.inputmask"
                        value="{{ old($attribute, $modelManager->getAttributeFromArray($attribute, $model) ) }}">
            </div>

            @if ($errors->has($attribute))
                <span class="help-block">
                    {{ $errors->first($attribute) }}
                </span>
            @endif
        </div>
    </div>
</div>

@section('enqueued-js')
    <script>
    $(function () {
        $("#{{ $attribute }}").inputmask("{{ (isset($field['inputmask']) ? $field['inputmask'] : 'yyyy/mm/dd') }}", {"placeholder": "{{ (isset($field['inputmask']) ? $field['inputmask'] : 'yyyy/mm/dd') }}"});
    });
    </script>
@append
