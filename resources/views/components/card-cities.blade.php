@props([
    'image' => null,
    'time' => null,
    'title' => null,
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
                     class="lazyload object-cover w-full">
            </div>
        </div>

        {{-- Content --}}
        <div class="pt-[12px] px-4  relative">
            <div class="">
                {{-- Title --}}
                <h3 class=" text-slate-800 font-custom-bold-upper text-[16px] group-hover:text-blue-600">{{ $title }}</h3>

                {{-- List items --}}
                <div class="mt-[4px]">
                    @foreach($items as $item)
                        <div class="flex items-center justify-between h-[40px] {{ !$loop->last ? 'border-b border-b-slate-100' : '' }}">
                            <div class="flex items-center gap-2 text-gray-600">
                                <x-dynamic-component :component="$item['icon']" class="h-[24px] w-[24px] pr-[0.5px]"/>
                                <span class="text-[14px] text-slate-700  font-custom-regular">{!! $item['text'] !!}</span>
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
