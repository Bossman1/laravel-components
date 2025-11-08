<a href="{{ $link }}" class="block h-full group">
    <div class="bg-white rounded-[16px]  overflow-hidden  transition border border-slate-200  flex flex-col">

        {{-- Top image --}}
        <div class="relative">
            <div class="overflow-hidden   aspect-[5/3]">
                <img
                    src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw=="
                    loading="lazy"
                    data-src="{{ $image }}" alt="Card Image"
                     class="lazyload object-cover w-full">
            </div>
        </div>

        {{-- Content --}}
        <div class="pt-[17.5px] px-[12px] ">
            {{-- Time --}}
            <div class="flex justify-start">
                <div class=" rounded-[8px] flex items-center justify-center gap-1 text-slate-500">
                    <x-dynamic-component :component="'phosphor-calendar-dots'" class="h-[16px] w-[16px]"/>
                    <span class="text-[14px]">{{ $time }}</span>
                </div>
            </div>

            <div class="pt-[4px] pb-[16px]">
                <h3 class="text-slate-800 font-custom-semibold text-[16px] group-hover:text-blue-600" title="{{ $title }}">{{ $shortTitle }}</h3>
            </div>
        </div>
    </div>
</a>
