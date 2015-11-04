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
                            <input type="radio"
                                    value="{{ $value }}"
                                    name="{{ $attribute }}"
                                    @if (isset($field['required'])) required="required" @endif
                                    @if (
                                            (is_scalar($model->getOriginal($attribute)) && $model->getOriginal($attribute) == $value)
                                        ||
                                            (is_array($model->getOriginal($attribute)) && array_key_exists($value, $model->getOriginal($attribute)))
                                        )
                                        checked="checked" @endif
                                    >
                            {{ $option }}
                        </p>
                    </div>
                    @endforeach

                    @if(isset($field['help']))
                    <div class="col-sm-12">
                        <p class="help-block">{!! $field['help'] !!}</p>
                    </div>
                    @endif
                @else
                    <div class="callout callout-warning">
                        <strong>
                        No options available for {{ $attributeTitle }}!
                        </strong>
                    </div>
                @endif
            </div>
            
            @if ($errors->has($attribute))
                <p class="help-block">
                    <strong>{{ $errors->first($attribute) }}</strong>
                </p>
            @endif
        </div>
    </div>
</div>
