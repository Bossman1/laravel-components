@props([
    'image' => null,
    'logo' => null,
    'time' => null,
    'title' => null,
    'subtitle' => null,
    'items' => [],
    'link' => '#',
    'bookingLink' => '#',
    'price' =>'',
    'id' =>''
])


    <div class="bg-white rounded-[16px]  overflow-hidden  transition border border-slate-200">
        {{-- Top image --}}
        <div class="relative">

            <div class="overflow-hidden   aspect-[5/3]">
                <a href="{{ $link }}" class="block group">
                <img
                    src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw=="
                    loading="lazy"
                    data-src="{{ $image }}" alt="Card Image"
                    class="lazyload object-cover w-full">
                </a>
            </div>


            {{-- Logo overlay --}}
            <div class="absolute -bottom-14 left-1/2 transform -translate-x-1/2   aspect-[5/3]">
                <a href="{{ $link }}" class="block group">
                <img
                    src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw=="
                    loading="lazy"
                    data-src="{{ $logo }}" alt="Logo"
                    class="lazyload w-[160px] h-[160px] rounded-[24px] border border-[#E2E8F0] bg-white shadow">
                </a>
            </div>
        </div>

        {{-- Content --}}
        <div class="pt-[57px] px-[16px] pb-[16px]  relative">
            <div class="my-[17px] flex flex-col items-center text-center">
                {{-- Title --}}
                <span class="text-slate-500 font-custom-regular text-[14px]"><a href="{{ $link }}" class="block group">{{ $title }}</a></span>
                {{-- Subtitle --}}
                <h3 class=" text-slate-800 font-custom-semibold text-[16px] group-hover:text-blue-600"><a href="{{ $link }}" class="block group">{{ $subtitle }}</a></h3>

                <div class="w-full">
                    <div class="flex items-center gap-2 my-2 ml-auto">
                        <div class="w-full bg-green-100 text-green-700 px-2 py-2 rounded-[8px] flex items-center justify-center gap-1">
                            <x-dynamic-component :component="'phosphor-clock'" class="h-[16px] w-[16px]"/>
                            <span class="text-[14px]">{{ $time }}</span>
                        </div>
                        <div class="h-[40px] w-[46px] rounded-full bg-green-600 flex items-center justify-center text-white">
                            <div class="flex items-center justify-center">
                                <x-dynamic-component :component="'phosphor-calendar-dots'" class="h-[24px] w-[24px]"/>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="mt-[8px] flex flex-col items-start text-center">
                {{-- List items --}}
                <div class="grid grid-cols-1 gap-[8px] w-full my-[8px]">
                    @foreach($items as $item)

                        @if(isset($price) &&  trim($price) !=='')
                            <div class="flex jus items-center  text-gray-600 w-full gap-[12px]">
                                <span class="font-medium text-sky-700 text-[16px] font-custom-bold">{{ $price }}₾</span>
                                <x-button icon="phosphor-calendar-dots" iconPosition="left" size="sm" variant="outline" class="w-full" :href="$bookingLink">
                                    სერვისის დაჯავშნა
                                </x-button>
                            </div>
                        @endif
                        <div class="flex items-center gap-[4px] text-gray-600 w-full">
                            <x-dynamic-component :component="$item['icon']" class="h-[24px] w-[24px]"/>
                            @if(isset($item['number']))
                                <span class="font-medium text-sky-800 text-[16px] font-custom-bold">{{ $item['number'] }}</span>
                            @endif

                            <span class="text-[14px] font-custom-regular">{!! $item['text'] !!}</span>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</a>
