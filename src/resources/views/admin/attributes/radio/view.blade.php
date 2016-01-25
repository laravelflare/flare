<dl class="dl-horizontal">
    <dt>
        {{ $attributeTitle }}
    </dt>
    <dd>
        @if (is_scalar($modelManager->getAttribute($attribute, $model)) || is_null($modelManager->getAttribute($attribute, $model)))
            {{ $modelManager->getAttribute($attribute, $model) }}
        @else 
            @foreach ($modelManager->getAttribute($attribute, $model) as $key => $value)
            {{ $value }} <br>
            @endforeach
        @endif
    </dd>
</dl>
