@props([
    'text' => null,
    'position' => 'center',        // 'start', 'center', 'end'
    'textClass' => '',
    'iconClass' => '',
    'iconBefore' => null,          // Blade component name for icon before text
    'iconAfter' => null,           // Blade component name for icon after text
])

@if($text)
    <div class="flex items-center my-2 w-full">
        {{-- Left line --}}
        @if($position === 'end' || $position === 'center')
            <div {{ $attributes->merge(['class' => 'flex-1 border-t border-slate-200']) }}></div>
        @endif

        {{-- Text with optional icon before --}}
        <div class="flex items-center px-2 whitespace-nowrap text-slate-500 {{ $textClass }}">
            @if($iconBefore)
                <x-dynamic-component :component="$iconBefore" class="h-[20px] w-[20px] mr-1 {{ $iconClass }}" />
            @endif

            <span>{{ $text }}</span>

            @if($iconAfter)
                <x-dynamic-component :component="$iconAfter" class="h-[20px] w-[20px] ml-1 {{ $iconClass }}" />
            @endif
        </div>

        {{-- Right line --}}
        @if($position === 'start' || $position === 'center')
            <div {{ $attributes->merge(['class' => 'flex-1 border-t border-slate-200']) }}></div>
        @endif
    </div>
@else
    {{-- Simple horizontal line --}}
    <hr {{ $attributes->merge(['class' => 'my-2 border-t border-slate-100']) }}>
@endif
