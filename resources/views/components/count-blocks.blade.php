@props([
    'wrapperClass' => '',
    'blocks' => []
])

<div class="{{ $wrapperClass }}">
    @if($blocks && count($blocks))
         @foreach($blocks as $k => $block)
           @if(isset($block['href']) && trim($block['href']) !=='') <a href="{{ $block['href'] }}">  @endif
            <div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center text-black rounded-[16px] bg-white border border-slate-200 p-4']) }}>
                <p class="font-custom-bold text-[28px] text-slate-800">{{ $block['number'] ?? '' }}</p>
                <p class="font-custom-regular text-[16px] text-slate-700">{{ $block['text'] ?? '' }}</p>
            </div>
           @if(isset($block['href']) && trim($block['href']) !=='')  </a>  @endif
        @endforeach
    @endif
</div>
