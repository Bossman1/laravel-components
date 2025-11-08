{{-- resources/views/components/button.blade.php --}}
@props([
    'href' => null,
    'icon' => null,
    'iconPosition' => 'left',
    'size' => 'md',
    'variant' => 'outline',
    'disabled' => false,
    'name' => '',
    'type' => 'button',
    'hrefOptions' => [],
    'options' => [],
    'textClass' =>''
])

@php
    $iconPosition = ($iconPosition === 'right') ? 'right' : 'left';
    $size = in_array($size, ['sm','md','lg']) ? $size : 'md';
    $variant = $variant ?: 'outline';
    $disabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);

    $slotText = trim((string) $slot);
    $hasText = $slotText !== '';
    $hasIcon = !empty($icon);
    $isIconOnly = $hasIcon && !$hasText;

    $textSize = match($size) {
        'sm','md' => 'text-[14px] leading-[14px]',
        'lg' => 'text-[16px] leading-[16px]',
        default => 'text-[14px] leading-[14px]',
    };

    // === Variants ===
    $variantClasses = [
        'primary'     => 'bg-red-700 text-white hover:bg-sky-900',
        'secondary'   => 'bg-[#00598A] text-white hover:bg-white',
        'outline'     => 'border border-[#CAD5E2] text-[#314158] hover:bg-sky-900 hover:text-white',
        'transparent' => 'bg-transparent text-[#314158] hover:bg-sky-900 hover:text-white border-0',
        'disabled'    => 'bg-[#E2E8F0] text-[#90A1B9] opacity-50 cursor-not-allowed border',
    ];
    $variantClass = $variantClasses[$variant] ?? $variantClasses['outline'];

    $containerPadding = '';
    $textPadding = '';
    $iconClass = '';

    if ($isIconOnly) {
        if ($size === 'sm') {
            $containerPadding = 'p-[8px] rounded-[4px]';
            $iconClass = 'w-6 h-6';
        } elseif ($size === 'md') {
            $containerPadding = 'p-[12px] rounded-[8px]';
            $iconClass = 'w-6 h-6';
        } else { // lg
            $containerPadding = 'p-[12px] rounded-[12px]';
            $iconClass = 'w-8 h-8';
        }
    } else {
        if ($size === 'sm') {
            if ($hasIcon) {
                if ($iconPosition === 'left') {
                    $containerPadding = 'py-[8px] pl-[8px] pr-[12px] rounded-[4px]';
                    $iconClass = 'w-6 h-6 mr-[4px]';
                } else {
                    $containerPadding = 'py-[8px] pr-[8px] pl-[12px] rounded-[4px]';
                    $iconClass = 'w-6 h-6 ml-[4px]';
                }
            } else {
                $containerPadding = 'px-[24px] py-[13px] rounded-[4px]';
            }
        } elseif ($size === 'md') {
            if ($hasIcon) {
                if ($iconPosition === 'left') {
                    $containerPadding = 'py-[12px] pl-[12px] pr-[16px] rounded-[8px]';
                    $iconClass = 'w-6 h-6 mr-[4px]';
                } else {
                    $containerPadding = 'py-[12px] pr-[12px] pl-[16px] rounded-[8px]';
                    $iconClass = 'w-6 h-6 ml-[4px]';
                }
            } else {
                $containerPadding = 'px-[28px] py-[17px] rounded-[8px]';
            }
        } else { // lg
            if ($hasIcon) {
                if ($iconPosition === 'left') {
                    $containerPadding = 'py-[12px] pl-[12px] pr-[16px] rounded-[12px]';
                    $iconClass = 'w-8 h-8 mr-[4px]';
                } else {
                    $containerPadding = 'py-[12px] pr-[12px] pl-[16px] rounded-[12px]';
                    $iconClass = 'w-8 h-8 ml-[4px]';
                }
            } else {
                $containerPadding = 'px-[28px] py-[20px] rounded-[12px]';
            }
        }
    }

    // === Base classes ===
    $base = 'items-center justify-center transition select-none cursor-pointer';

    // Handle responsive hidden
    $userClass = $attributes->get('class') ?? '';
    if (str_contains($userClass, 'hidden')) {
        $userClass = str_replace('hidden', 'hidden md:inline-flex', $userClass);
    }else{
        $userClass = "inline-flex {$userClass}";
    }

    $finalClasses = trim("{$base} {$variantClass} {$containerPadding} " . ($disabled ? 'pointer-events-none' : '') . " {$userClass}");

    $tag = $href ? 'a' : 'button';
@endphp

<{{ $tag }}
    @if($href) href="{{ $href }}"
        @if(count($hrefOptions))
            @foreach($hrefOptions as $key => $hrefOption)
                {{ $key }}="{{$hrefOption}}"
            @endforeach
        @endif
@else
    type="{{ $type }}" name="{{ $name }}"
@endif
@if($disabled)
    disabled
@endif

@if($options && count($options))
    @foreach($options as $key => $value)
        @if(is_int($key) || (is_numeric($key) && $key === $value))
            {{ $value }}
        @else
            {{ $key }}="{{ $value }}"
        @endif
    @endforeach
@endif


{{ $attributes->except('class')->merge(['class' => $finalClasses]) }}
>
{{-- Left icon --}}
@if($hasIcon && $iconPosition === 'left' && !$isIconOnly)
    <x-dynamic-component :component="$icon" class="{{ $iconClass }}"/>
@endif

{{-- Text --}}
@if($hasText)
    <span class="{{ $textPadding }} {{ $textSize }} {{ $textClass }}">{{ $slot }}</span>
@endif

{{-- Right icon --}}
@if($hasIcon && $iconPosition === 'right' && !$isIconOnly)
    <x-dynamic-component :component="$icon" class="{{ $iconClass }}"/>
@endif

{{-- Icon-only --}}
@if($isIconOnly)
    <x-dynamic-component :component="$icon" class="{{ $iconClass }}"/>
@endif
</{{ $tag }}>
