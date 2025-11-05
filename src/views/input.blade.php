@props([
   'placeholder' => 'placeholder',
   'name' => 'name',
   'id' => 'id',
   'type' => 'text',
   'value' => '',
   'attributes' => [],
   'options' => []
])

@php
    $isDisabled = isset($options['disabled']) && $options['disabled'] === 'disabled';

    $baseClasses = ' h-[56px] rounded-[12px] border-[1px] border-slate-300 col-span-2 px-3 py-2 font-custom-regular text-[16px] text-slate-400';

    $disabledClasses = $baseClasses. ' !bg-slate-100 !text-slate-400 !cursor-not-allowed';

    $finalClass =  $isDisabled ? $disabledClasses : $baseClasses;
@endphp

<input
    type="{{ $type }}"
    placeholder="{!! $placeholder !!}"
    name="{{ $name }}"
    id="{{ $id }}"
    value="{{ $value }}"
{{ $attributes->merge(['class' => $finalClass]) }}
@if($options && count($options))
    @foreach($options as $key => $value)
        @if(is_int($key) || (is_numeric($key) && $key === $value))
            {{ $value }}
        @else
            {{ $key }}="{{ $value }}"
        @endif
    @endforeach
@endif
/>
