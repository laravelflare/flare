<dl class="dl-horizontal">
    <dt>
        {{ $attributeTitle }}
    </dt>
    <dd>
        @if ($modelManager->getAttributeFromArray($attribute, $model))
            @if (is_scalar($modelManager->getAttributeFromArray($attribute, $model)))
                @if (array_key_exists($modelManager->getAttributeFromArray($attribute, $model), $field['options']))
                    {{ $field['options'][$modelManager->getAttributeFromArray($attribute, $model)] }}
                @else
                    {{ $modelManager->getAttributeFromArray($attribute, $model) }}
                @endif
            @else 
                @foreach ($modelManager->getAttributeFromArray($attribute, $model) as $key => $value)
                    @if (array_key_exists($modelManager->getAttributeFromArray($attribute, $model), $field['options']))
                        {{ $field['options'][$modelManager->getAttributeFromArray($attribute, $model)] }} <br>
                    @else
                        {{ $value }} <br>
                    @endif
                @endforeach
            @endif
        @endif
    </dd>
</dl>
