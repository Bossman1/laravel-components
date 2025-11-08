@props([
    'position' =>'left',
    'sidebarClass' =>'',
    'contentClass' => ''
])


<div {{ $attributes->merge(['class' => 'flex flex-col md:flex-row gap-[24px]']) }}>
    @if($position == 'left')
        <aside class="hidden lg:block w-[312px] shrink-0 {{ $sidebarClass }}"> {{ $sidebar ?? '' }} </aside>
    @endif

    <main class="flex-1 rounded-t-[16px]  {{ $contentClass }}">  {{ $content ?? '' }} </main>

    @if($position == 'right')
        <aside class="hidden lg:block w-[312px] shrink-0  {{ $sidebarClass }}"> {{ $sidebar ?? '' }} </aside>
    @endif

</div>
