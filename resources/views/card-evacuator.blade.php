@props([
    'image' => null,
    'logo' => null,
    'time' => null,
    'category' => null,
    'subtitle' => null,
    'items' => [],
    'website-url' => null,
    'meta-url' => null,
    'position' => 'top',
    'link' => ''
])


<div class="bg-white rounded-[16px] overflow-hidden transition border border-slate-200 group
    @if($position === 'full') md:flex md:flex-row   @endif">

    {{-- Image --}}
        <div class="aspect-[4/3]   @if($position === 'top') relative  @else relative   md:h-auto   w-[424px]@endif">
         <a href="{{ $link }}">
            <img
                src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw=="
                loading="lazy"
                data-src="{{ $image }}" alt="Card Image" class="lazyload object-cover w-full h-full">
        </a>
        {{-- Logo overlay (top position or mobile) --}}
        <div class="absolute -bottom-10 left-[12px] z-10 md:hidden @if($position === 'full') md:!static md:mb-0 @endif">
            <a href="{{ $link }}">
                <img
                    src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw=="
                    loading="lazy"
                    data-src="{{ $logo }}" alt="Logo" class="lazyload w-[88px] h-[88px] rounded-[24px] border border-[#E2E8F0] bg-white shadow object-cover">
            </a>
        </div>
    </div>


    {{-- Content --}}
    <div class="relative px-4 pt-[30px] @if($position === 'full') md:w-2/3 md:!pt-[8px] @endif">

        {{-- Logo + Time (Full position desktop only) --}}
        @if($position === 'full')
            <a href="{{ $link }}">
                <div class="relative md:flex items-center gap-[13px] mb-3">
                    <img
                        src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw=="
                        loading="lazy"
                        data-src="{{ $logo }}" alt="Logo"
                        class="lazyload hidden sm:block w-[88px] h-[88px] rounded-[24px] border border-[#E2E8F0] bg-white shadow object-cover">

                    <div class="absolute top-[-14px] right-[-7px] md:top-[51px]  md:left-[100px]">
                        <div class="flex items-center gap-2">
                            <div class="flex items-center text-xs bg-green-100 text-green-700 px-2 py-[8px] rounded-[8px] gap-1">
                                <x-dynamic-component :component="'phosphor-clock'" class="h-[16px] w-[16px]"/>
                                <span class="text-[14px]">{{ $time }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        @elseif($position === 'top')
            {{-- Time absolute corner (top layout) --}}
            <div class="absolute top-[12px] right-[12px] ">
                <div class="flex items-center gap-2">
                    <div class="flex items-center text-xs bg-green-100 text-green-700 px-2 py-[8px] rounded-[8px] gap-1">
                        <x-dynamic-component :component="'phosphor-clock'" class="h-[16px] w-[16px]"/>
                        <span class="text-[14px]">{{ $time }}</span>
                    </div>
                </div>
            </div>
        @endif

        {{-- Category & Subtitle --}}
        <div class="mt-[17px] @if($position == 'full') md:mt-0 @endif">
            <span class="text-slate-500 font-custom-regular text-[14px]">{{ $category }}</span>
            <h2 class="text-slate-800 font-custom-semibold text-[16px] group-hover:text-blue-600">
                <a href="{{ $link }}">{{ $subtitle }}</a>
            </h2>

            {{-- List items --}}
            <div class="mt-3  @if($position == 'full') md:mt-0 @endif">
                @foreach($items as $item)
                    <div class="flex items-center justify-between py-[12px] md:py-[8px]">


                        <div class="flex items-center justify-between gap-2 text-gray-600 w-full">
                            <div class="flex items-center gap-2">
                                <x-dynamic-component :component="$item['icon']" class="h-[24px] w-[24px]" />
                                <span class="text-[14px] font-custom-regular @if(isset($item['website-url'])) hover:text-blue-600 @endif">
                                     @if(isset($item['website-url']))
                                        <a href="https://{{ $item['website-url'] }}" target="_blank">
                                            {!! $item['website-url'] !!}
                                        </a>
                                    @else
                                        {!! $item['text'] !!}
                                    @endisset
                                </span>
                            </div>

                            @if(isset($item['meta-url']))
                                <a href="{{ $item['meta-url'] }}" target="_blank" class="hover:text-blue-600">
                                    <x-dynamic-component :component="'phosphor-facebook-logo'" class="h-[24px] w-[24px]" />
                                </a>
                            @endif
                        </div>


                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

