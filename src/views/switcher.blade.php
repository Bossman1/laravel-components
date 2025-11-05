@props([
    'label' => false,
    'id' => 'hs_'.uniqid(),
    'name' => 'name_'.uniqid(),
])
<label for="{{ $id }}" class="inline-flex flex-col items-center cursor-pointer">
    <span class="relative inline-block w-11 h-6">
        <input type="checkbox" id="{{ $id }}" name="{{ $name }}" class="peer sr-only">
        <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600 dark:bg-neutral-700 dark:peer-checked:bg-blue-500 peer-disabled:opacity-50 peer-disabled:pointer-events-none"></span>
        <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full dark:bg-neutral-400 dark:peer-checked:bg-white"></span>
    </span>

    @if($label)
        <span {{ $attributes->merge(['class' => 'text-[14px] text-slate-600 mt-1 text-center']) }}>{{ $label }}</span>
    @endif
</label>
