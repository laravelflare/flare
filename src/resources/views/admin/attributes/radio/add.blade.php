<div class="row">
    <div class="col-sm-6">
        <div class="form-group @if ($errors->has($attribute)) has-error @endif">
            <label class="control-label" for="{{ $attribute }}">
                {{ $attributeTitle }}
                @if (isset($field['required'])) 
                <span title="" data-placement="right" data-toggle="tooltip" data-original-title="This field is required">*</span>
                @endif
                @if(isset($field['tooltip']))
                <span title="" data-placement="right" data-toggle="tooltip" class="badge bg-black" data-original-title="{{ $field['tooltip'] }}">?</span>
                @endif
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
