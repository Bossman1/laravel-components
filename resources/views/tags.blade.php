@props([
    'heading' => '',
    'tags' => [],
    'tagClass' =>'',
])

@if(count($tags))
    <div {{ $attributes->merge(['class' => 'flex flex-wrap gap-[8px]']) }}>
        @if(trim($heading) != '')
            <div class="text-slate-700 font-custom-bold text-[16px] flex justify-between items-center">{{ $heading }}
                :
            </div>
        @endif
        @foreach ($tags as $tag)
            @if(isset($tag['href']) && trim($tag['href']) !=='')
                <a href="{{ $tag['href'] }}"
                @foreach(($tag['hrefOptions'] ?? []) as $key => $val)
                    {{ $key }}="{{ $val }}"
                @endforeach
                class="px-[24px] py-[10.5px] bg-white border border-slate-300 text-slate-700 rounded-[4px] text-[14px] hover:bg-slate-200 transition">
                @endif
                @if(!isset($tag['href'])) <span class="{{ $tagClass }}"> @endif
                    {{ $tag['text'] }}
                    @if(!isset($tag['href'])) </span> @endif
                @if(isset($tag['href']) && trim($tag['href']) !=='')</a>
            @endif
        @endforeach
    </div>
@endif
