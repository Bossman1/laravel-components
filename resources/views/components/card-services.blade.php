@props([
    'image' => null,
    'title' => null,
    'subtitle' => null,
    'items' => [],
    'link' => '#',
])

<a href="{{ $link }}" class="block group">
    <div class="bg-white rounded-[16px]  overflow-hidden  transition border border-slate-200">
        {{-- Top image --}}
        <div class="relative">
            <div class="overflow-hidden aspect-[4/3]">
                <img
                    src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw=="
                    data-src="{{ $image }}" alt="Card Image" loading="lazy"
                     class="lazyload object-cover w-full">
            </div>
        </div>

        {{-- Content --}}
        <div class="px-4  relative">
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
                                <span class="font-medium text-sky-600 text-[16px] font-custom-bold">{{ $item['number'] }}</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</a>
