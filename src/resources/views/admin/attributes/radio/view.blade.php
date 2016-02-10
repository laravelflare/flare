<dl class="dl-horizontal">
    <dt>
        {{ $attributeTitle }}
    </dt>
    <dd>
        @if (is_scalar($modelManager->getAttribute($attribute)) || is_null($modelManager->getAttribute($attribute)))
            {{ $modelManager->getAttribute($attribute) }}
        @else 
            @foreach ($modelManager->getAttribute($attribute) as $key => $value)
            {{ $value }} <br>
            @endforeach
        @endif
    </dd>
</dl>
