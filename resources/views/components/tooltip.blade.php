@props([
    'target' => uniqid(),
    'label' => 'label',
    'text' => '',
    'labelClass' => '',
    'icon' => false,
    'iconClass' => false,
    'buttonClass' => '',
    'contentClass' =>''
])

<div class="relative w-auto">
    <span data-tooltip-target="tooltip-{{ $target }}"  class="cursor-help px-5 py-2.5 text-center {{ $labelClass }}">
        @if($icon)
            <x-dynamic-component :component="$icon" class="h-[24px] w-[24px] {{ $iconClass }}"/>
        @else
             {{ $label }}
        @endif
    </span>

    <div id="tooltip-{{ $target }}" role="tooltip"
         class="absolute z-10 invisible  px-3 py-2 font-medium   rounded-lg shadow-xs opacity-0 tooltip {{ $contentClass }}">
         {{ $text ?? '' }}
        <div class="tooltip-arrow" data-popper-arrow></div>
    </div>
</div>
