@props([
    'haveTrash' =>  false
])

<a href="{{ $link }}" class="block h-full group">
    <div class="bg-white rounded-[16px]  overflow-hidden  transition border border-slate-200  flex flex-col">

        {{-- Top image --}}
        <div class="relative">
            <div class="overflow-hidden  aspect-[5/3]">
                <img
                    src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw=="
                    data-src="{{ $image }}" alt="Card Image" loading="lazy"
                     class="lazyload  object-cover w-full">
            </div>

            {{-- Logo overlay --}}
            <div class="absolute -bottom-10 !left-[12px]  aspect-[5/3]">
                <img
                    src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw=="
                    data-src="{{ $logo }}" alt="Logo" loading="lazy"
                     class="lazyload  w-[88px] h-[88px] rounded-[24px] border border-[#E2E8F0] bg-white shadow">
            </div>
        </div>

        {{-- Content --}}
        <div class="pt-[12px] px-[12px] flex-1">
            {{-- Time --}}
            <div class="flex justify-end mb-2">
                <div class="flex items-center text-xs bg-slate-200 text-[#7008E7] p-[8px] rounded">
                    <span class="text-[14px] font-custom-regular">{{ $time }}</span>
                </div>
            </div>

            <div>
                <span class="text-slate-500 font-custom-regular text-[14px]">{{ $title }}</span>
                <h3 class="text-slate-800 font-custom-semibold text-[16px] group-hover:text-blue-600">{{ $subtitle }}</h3>
                <x-line />
                <p class="font-custom-regular text-[16px]"> {{ $text }} </p>
                <x-line class="!my-[12px]" />
            </div>
        </div>

        {{-- Footer (sticks to bottom) --}}
        <div class="px-[12px] pb-[10px]">
            <div class="flex items-center">
                <span class="text-[16px] font-semibold text-sky-700 pr-[24px] font-custom-bold">
                    {{ $price ?? '' }} ₾
                </span>
                <x-button
                    icon="phosphor-credit-card"
                    iconPosition="left"
                    size="sm"
                    variant="outline"
                    class="flex-1 justify-center w-full"
                >
                    ყიდვა
                </x-button>
                @if($haveTrash)
                    <x-button size="sm" icon="phosphor-trash" variant="outline" class="ml-[12px]"    />
                @endif
            </div>
        </div>

    </div>
</a>
