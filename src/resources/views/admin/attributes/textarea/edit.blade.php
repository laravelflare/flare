<div class="row">
    <div class="col-sm-6">
        <div class="form-group @if ($errors->has($attribute)) has-error @endif">
            <label class="control-label" for="{{ $attribute }}">{{ $attributeTitle }}</label>
            <textarea id="{{ $attribute }}"
                        class="form-control {{ $field['class'] or null }}"
                        name="{{ $attribute }}">
                {{ old($attribute, $model->$attribute) }}</textarea>
            @if ($errors->has($attribute))
                <span class="help-block">{{ $errors->first($attribute) }}</span>
            @endif
        </div>
    </div>
</div>