<div class="row">
    <div class="col-sm-6">
        <div class="form-group @if ($errors->has($attribute)) has-error @endif">
            <label class="control-label" for="{{ $attribute }}">
                {{ $attributeTitle }} @if (isset($field['required'])) * @endif
            </label>
            <input id="{{ $attribute }}"
                    class="form-control {{ $field['class'] or null }}"
                    type="{{ $field['type'] or 'text' }}"
                    name="{{ $attribute }}"
                    @if (isset($field['maxlength'])) maxlength="{{ $field['maxlength'] }}" @endif
                    @if (isset($field['disabled'])) disabled="disabled" @endif
                    @if (isset($field['readonly'])) readonly="readonly" @endif
                    @if (isset($field['autocomplete'])) autocomplete="{{ ($field['autocomplete'] ? 'on' : 'off') }}" @endif
                    @if (isset($field['autofocus'])) autofocus="autofocus" @endif
                    @if (isset($field['pattern'])) pattern="{{ $field['pattern'] }}" @endif
                    @if (isset($field['required'])) required="required" @endif
                    @if (isset($field['placeholder'])) placeholder="{{ $field['placeholder'] }}" @endif
                    value="{{ old($attribute, $model->$attribute) }}">
            @if ($errors->has($attribute))
                <span class="help-block">
                    {{ $errors->first($attribute) }}
                </span>
            @endif
        </div>
    </div>
</div>