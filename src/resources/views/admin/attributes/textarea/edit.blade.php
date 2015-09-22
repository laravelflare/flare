<div class="row">
    <div class="col-sm-6">
        <div class="form-group @if ($errors->has($attribute)) has-error @endif">
            <label class="control-label" for="{{ $attribute }}">
                {{ $attributeTitle }} @if (isset($field['required'])) * @endif
            </label>
            <textarea id="{{ $attribute }}"
                        class="form-control {{ $field['class'] or null }}"
                        name="{{ $attribute }}"
                        @if (isset($field['required'])) required="required" @endif>{{ old($attribute, $modelManager->getAttribute($attribute, $model) ) }}</textarea>
            @if ($errors->has($attribute))
                <span class="help-block">
                    {{ $errors->first($attribute) }}
                </span>
            @endif
        </div>
    </div>
</div>