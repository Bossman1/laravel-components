@props([
    'image' => null,
    'logo' => null,
    'time' => null,
    'title' => null,
    'subtitle' => null,
    'items' => [],
    'link' => '#',
])

<a href="{{ $link }}" class="block group">
    <div class="bg-white rounded-[16px]  overflow-hidden  transition border border-slate-200">
        {{-- Top image --}}
        <div class="relative">
            <div class="overflow-hidden aspect-[5/3]">
                <img
                    src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw=="
                    data-src="{{ $image }}" alt="Card Image" loading="lazy"
                     class="lazyload object-cover w-full object-cover">
            </div>


            {{-- Logo overlay --}}
            <div class="absolute -bottom-10 !left-[12px]">
                <img
                    src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw=="
                    data-src="{{ $logo }}" alt="Logo" loading="lazy"
                     class="lazyload w-[88px] h-[88px] rounded-[24px] border border-[#E2E8F0]  bg-white shadow object-cover">
            </div>
        </div>

        {{-- Content --}}
        <div class="pt-[30px] px-4  relative">
            {{-- Time + Calendar --}}
            <div class="absolute  top-[12px] !right-[12px]">
                <div class="flex items-center gap-2 mb-2 ml-auto">
                    <div class="flex items-center text-xs bg-green-100 text-green-700 px-2 py-[8px] rounded-[8px] gap-1">
                        <x-dynamic-component :component="'phosphor-clock'" class="h-[16px] w-[16px]"/>
                        <span class="text-[14px]">{{ $time }}</span>
                    </div>
                    <div class="h-[40px] w-[40px] rounded-full bg-green-600 flex items-center justify-center text-white">
                        <div class="flex items-center justify-center">
                            <x-dynamic-component :component="'phosphor-calendar-dots'" class="h-[24px] w-[24px]"/>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-[17px]">
                {{-- Title --}}
                <span class="text-slate-500 font-custom-regular text-[14px]">{{ $title }}</span>
                {{-- Subtitle --}}
                <h3 class=" text-slate-800 font-custom-semibold text-[16px] group-hover:text-blue-600">{{ $subtitle }}</h3>

                {{-- List items --}}
                <div class="mt-3">
                    @foreach($items as $item)
                        <div class="flex items-center justify-between  @if($loop->iteration  === 1) pb-[10px] border-b border-b-slate-100 @endif @if($loop->iteration  === 3) !pb-[20px] !pt-[12px] @else py-[8px] @endif">
                            <div class="flex items-center gap-2 text-gray-600">
                                <x-dynamic-component :component="$item['icon']" class="h-[24px] w-[24px] pr-[0.5px]"/>
                                <span class="text-[14px] font-custom-regular">{!! $item['text'] !!}</span>
                            </div>

                            @if(isset($item['number']))
                                <span class="font-medium text-sky-800 text-[16px] font-custom-bold">{{ $item['number'] }}</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</a>
