<dl class="dl-horizontal">
    <dt>
        {{ $attributeTitle }}
    </dt>
    <dd>
        @if ($model->getAttribute($attribute))
            @if (is_scalar($model->getAttribute($attribute)))
                @if (array_key_exists($model->getAttribute($attribute), $field['options']))
                    {{ $field['options'][$model->getAttribute($attribute)] }}
                @else
                    {{ $model->getAttribute($attribute) }}
                @endif
            @else 
                @foreach ($model->getAttribute($attribute) as $key => $value)
                    @if (array_key_exists($model->getAttribute($attribute), $field['options']))
                        {{ $field['options'][$model->getAttribute($attribute)] }} <br>
                    @else
                        {{ $value }} <br>
                    @endif
                @endforeach
            @endif
        @endif
    </dd>
</dl>
