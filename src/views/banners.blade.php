@props([
    'wrapperClass' =>'',
    'options' => [],
    'imageOptions' => [],
    'hrefOptions' => [],
    'imageClass' =>''
])
<div class="{{ $wrapperClass }}">
    @if(count($options))
        @foreach($options as $k => $option)
            <p {{ $attributes->merge(['class' => '']) }}>
                <a href="{{ $option['url'] }}"
                @if(count($hrefOptions))
                    @foreach($hrefOptions as $k =>  $hrefOption)
                        {{ $k }}  =  {{ $hrefOption }}
                    @endforeach
                @endif

                >
                <img
                    src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw=="
                    data-src="{{ $option['img'] }}" loading="lazy" class="lazyload {{ $imageClass }}"
                @if(count($imageOptions))
                    @foreach($imageOptions as $k =>  $imageOption)
                        {{ $k }}  = "{{ $imageOption }}"
                    @endforeach
                @endif
                />
                </a>

            </p>
        @endforeach
    @endif
</div>
