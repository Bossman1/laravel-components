@props([
    'pageTitle' => null,
    'sidebarTitle' => null,
])

<div class="container mx-auto px-4 font-custom-regular">
    <div class="flex flex-col md:flex-row md:gap-6">

        {{-- Sidebar --}}
        <x-card-sidebar>
            {{-- Named slot for sidebar --}}
            @if($sidebarTitle)
                <h2 class="font-custom-semibold text-lg mb-4">{{ $sidebarTitle }}</h2>
            @endif
            {{ $sidebar ?? '' }}
        </x-card-sidebar>

        {{-- Main Content --}}
        <main class="flex-1 w-full mt-6 md:mt-0">
            <div class="rounded-xl">
                <h2 class="pb-5 text-[20px] md:text-[24px] font-custom-bold-upper leading-[24px]">{{ $pageTitle }}</h2>
                {{ $slot }}
            </div>
        </main>

    </div>
</div>
