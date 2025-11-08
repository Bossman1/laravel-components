@props([
    'image' => null,
    'logo' => null,
    'time' => null,
    'category' => null,
    'subtitle' => null,
    'city' =>'',
    'address' =>'',
    'website-url' => null,
    'meta-url' => null,
    'position' => 'top',
    'link' => '',
    'bookingLink' => '',
    'price' => ''
])


<div class="bg-white rounded-[16px] overflow-hidden transition border border-slate-200 group
    @if($position === 'full') md:flex md:flex-row md:h-[318px] @endif">

    {{-- Image --}}

    <div class="aspect-[5/3] @if($position === 'top') relative  @else relative  md:w-1/3 md:h-auto @endif">
        <a href="{{ $link }}">
            <img
                src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw=="
                loading="lazy"
                data-src="{{ $image }}" alt="Card Image" class="lazyload object-cover w-full h-full">
        </a>
        {{-- Logo overlay (top position or mobile) --}}
        @if(isset($logo) && trim($logo) !=='')
            <div class="absolute -bottom-10 left-[12px] z-10 @if($position === 'full') md:!static md:mb-0 @endif">
                <a href="{{ $link }}">
                    <img
                        src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw=="
                        loading="lazy"
                        data-src="{{ $logo }}" alt="Logo" class="lazyload w-[88px] h-[88px] rounded-[24px] border border-[#E2E8F0] bg-white shadow">
                </a>
            </div>
        @endif
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
                        class="lazyload hidden sm:block w-[88px] h-[88px] rounded-[24px] border border-[#E2E8F0] bg-white shadow">

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

                    <div class="flex items-center justify-between py-[12px] md:py-[8px]">
                        <div class="flex items-center justify-between gap-[4px] text-gray-600 w-full">
                            <div class="flex items-center gap-2">
                                <x-dynamic-component :component="'phosphor-map-pin'" class="h-[24px] w-[24px]" />
                                <div class="text-[14px] font-custom-regular "> <span class="font-custom-bold">{!! $city !!}</span> {!! $address !!} </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex @if(isset($bookingLink) && ($bookingLink !='' || $bookingLink != null))  justify-between @else justify-center @endif  items-center  text-gray-600 w-full gap-[12px] my-[12px]">
                        <span class="font-medium text-sky-700 text-[16px] font-custom-bold">{{ $price }}₾</span>
                        @if(isset($bookingLink) && ($bookingLink !='' || $bookingLink != null))
                            <x-button icon="phosphor-calendar-dots" iconPosition="left" size="sm" variant="outline" class="w-full" :href="$bookingLink">
                                სერვისის დაჯავშნა
                            </x-button>
                        @endif
                    </div>

            </div>
        </div>
    </div>
</div>

