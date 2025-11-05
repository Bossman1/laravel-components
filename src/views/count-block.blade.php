@props([
    'wrapperClass' => '',
    'number' => '',
    'text' =>'',
    'numberClass' =>''
])

<div class="{{ $wrapperClass }}">
    <div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center text-black rounded-[16px] bg-white border border-slate-200 p-4']) }}>
        <p class="font-custom-bold text-[28px] text-slate-800 {{ $numberClass }}">{{ $number ?? '' }}</p>
        <p class="font-custom-regular text-[16px] text-slate-700">{{ $text ?? '' }}</p>
    </div>
</div>
