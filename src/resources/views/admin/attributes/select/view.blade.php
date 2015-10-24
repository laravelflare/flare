<dl class="dl-horizontal">
    <dt>
        {{ $attributeTitle }}
    </dt>
    <dd>
        @if ($model->getOriginal($attribute))
            @if (is_scalar($model->getOriginal($attribute)))
                @if (array_key_exists($model->getOriginal($attribute), $field['options']))
                    {{ $field['options'][$model->getOriginal($attribute)] }}
                @else
                    {{ $model->getOriginal($attribute) }}
                @endif
            @else 
                @foreach ($model->getOriginal($attribute) as $key => $value)
                    @if (array_key_exists($model->getOriginal($attribute), $field['options']))
                        {{ $field['options'][$model->getOriginal($attribute)] }} <br>
                    @else
                        {{ $value }} <br>
                    @endif
                @endforeach
            @endif
        @endif
    </dd>
</dl>
