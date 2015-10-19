<div class="row">
    <div class="col-sm-6">
        <div class="form-group @if ($errors->has($attribute)) has-error @endif">
            <label class="control-label" for="{{ $attribute }}">
                {{ $attributeTitle }} @if (isset($field['required'])) * @endif
            </label>

            <div class="col-sm-12">            
                @if(isset($field['options']) && count($field['options']) > 0)
                    @foreach ($field['options'] as $value => $option)
                    <div class="col-sm-12 col-md-6 col-lg-4">
                        <p>
                            <input type="checkbox"
                                    value="{{ ($value === 0 && count($field['options']) === 1) ? 1 : $value }}"
                                    name="{{ $attribute }}{{ (count($field['options']) > 1 ? '[]' : '') }}"
                                    @if (isset($field['required'])) required="required" @endif
                                    @if (
                                            (is_scalar($modelManager->getAttributeFromArray($attribute, $model)) && $modelManager->getAttributeFromArray($attribute, $model) == $value)
                                        ||
                                            (is_array($modelManager->getAttributeFromArray($attribute, $model)) && array_key_exists($value, $modelManager->getAttributeFromArray($attribute, $model)))
                                        )
                                        checked="checked" @endif
                                    >
                            {{ $option }}
                        </p>
                    </div>
                    @endforeach
                @else 
                    <div class="callout callout-warning">
                        <strong>
                        No options available for {{ $attributeTitle }}!
                        </strong>
                    </div>
                @endif
            </div>
            
            @if ($errors->has($attribute))
                <span class="help-block">
                    {{ $errors->first($attribute) }}
                </span>
            @endif
        </div>
    </div>
</div>
