@props([
    'heading' => '',
    'headingHref' => '',
    'cityClass' =>'',
    'alphabets' =>[],
    'visibleLetters' =>[],
])

@if(count($alphabets))
    <div {{ $attributes->merge(['class' => 'flex flex-wrap gap-[26.12px]']) }}>
        @if(trim($heading) != '')
            <div class="text-[#1565C0] hover:text-blue-600 font-custom-bold-upper text-[16px] flex justify-between items-center">
                @if(isset($headingHref) && trim($headingHref) !=='')
                    <a href="{{ $headingHref }}"> @endif {{ $heading }}  @if(isset($headingHref) && trim($headingHref) !=='')  </a> @endif
            </div>
        @endif
        @foreach ($alphabets as $alphabet)

                @if (empty($visibleLetters) || in_array($alphabet['letter'], $visibleLetters))

                    @if(isset($alphabet['href']) && trim($alphabet['href']) !=='')
                        <a href="{{ $alphabet['href'] }}"
                           @if(isset($alphabet['hrefOptions']))
                                @foreach(($alphabet['hrefOptions'] ?? []) as $key => $val)
                                    {{ $key }}="{{ $val }}"
                                @endforeach
                           @endif

                        class="flex justify-between items-center text-[16px] text-[#1E293B] hover:text-sky-700 font-custom-bold-upper">
                        @endif
                        @if(!isset($alphabet['href'])) <span class="{{ $cityClass }}"> @endif
                            {{ $alphabet['letter'] }}
                            @if(!isset($alphabet['href'])) </span> @endif
                        @if(isset($alphabet['href']) && trim($alphabet['href']) !=='')</a>
                    @endif

                @endif


        @endforeach
    </div>
@endif
