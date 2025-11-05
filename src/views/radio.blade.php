@props([
    'label' => '',
    'icon' => null,
    'iconPosition' => 'left', // top, bottom, left, right
])

@php
    $directions = [
        'top' => 'flex-col-reverse items-center',
        'bottom' => 'flex-col items-center',
        'left' => 'flex-row-reverse items-center',
        'right' => 'flex-row items-center',
    ];
@endphp

<label class="flex {{ $directions[$iconPosition] }} gap-2 cursor-pointer select-none">
    <input type="radio" name="{{ $attributes->get('name') }}" class="hidden peer">
    @if($icon)
        <div class="text-xl text-gray-500 peer-checked:text-blue-600 transition">{!! $icon !!}</div>
    @endif
    <div class="flex items-center gap-2">
        <div class="w-5 h-5 rounded-full border border-gray-400 peer-checked:border-blue-600 peer-checked:bg-blue-600 transition"></div>
        <span class="text-gray-700">{{ $label }}</span>
    </div>
</label>
