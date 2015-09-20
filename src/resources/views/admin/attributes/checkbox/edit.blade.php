<div class="row">
    <div class="col-sm-6">
        <div class="form-group @if ($errors->has($attribute)) has-error @endif">
            <label class="control-label" for="{{ $attribute }}">{{ $attributeTitle }}</label>
            
            @if ($errors->has($attribute))
                <span class="help-block">{{ $errors->first($attribute) }}</span>
            @endif
        </div>
    </div>
</div>