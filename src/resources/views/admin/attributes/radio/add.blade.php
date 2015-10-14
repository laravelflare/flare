<div class="row">
    <div class="col-sm-6">
        <div class="form-group @if ($errors->has($attribute)) has-error @endif">
            <label class="control-label" for="{{ $attribute }}">
                {{ $attributeTitle }} @if (isset($field['required'])) * @endif
            </label>

            <div class="col-sm-12">   
                @if(count($field['options']) > 0)
                    @foreach ($field['options'] as $value => $option)
                    <div class="col-sm-12 col-md-6 col-lg-4">
                        <p>
                            <input type="radio"
                                    value="{{ $value }}"
                                    name="{{ $attribute }}"
                                    @if (isset($field['required'])) required="required" @endif
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
