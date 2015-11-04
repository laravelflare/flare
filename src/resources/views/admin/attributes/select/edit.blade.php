<div class="row">
    <div class="col-sm-6">
        <div class="form-group @if ($errors->has($attribute)) has-error @endif">
            <label class="control-label" for="{{ $attribute }}">
                {{ $attributeTitle }} @if (isset($field['required'])) * @endif
            </label>
            
            @if(isset($field['options']) && count($field['options']) > 0)
                <select class="form-control"
                        name="{{ $attribute }}"
                        id="{{ $attribute }}"
                        @if (isset($field['required'])) required="required" @endif>
                    <option></option>
                    @foreach ($field['options'] as $value => $option)
                    <option value="{{ $value }}"
                                    @if ($model->getOriginal($attribute) == $value) selected="selected" @endif
                                >{{ $option }}</option>
                    @endforeach
                </select>

                @if(isset($field['help']))
                    <p class="help-block">{!! $field['help'] !!}</p>
                @endif
            @else
                <div class="callout callout-warning">
                    <strong>
                    No options available for {{ $attributeTitle }}!
                    </strong>
                </div>
            @endif
            
            @if ($errors->has($attribute))
                <p class="help-block">
                    <strong>{{ $errors->first($attribute) }}</strong>
                </p>
            @endif
        </div>
    </div>
</div>
