@props([
    'id' => 'checkbox',
    'name' => 'checkbox',
    'value' => '1',
    'label' => '',
    'checked' => false,
    'disabled' => false,
    'helper' => '',
    'labelClass' =>'',
    'helperClass' =>'',
    'labelPosition' => 'after', // 'after' | 'before' | 'top' | 'under'
])

<div class="@if(in_array($labelPosition, ['top','under'])) flex flex-col @else flex items-center  @endif">

    {{-- Label on top --}}
    @if($label && $labelPosition === 'top')
        <label for="{{ $id }}" class="mb-1 text-slate-600 text-[16px] select-none {{ $labelClass }}">
            {{ $label }}
        </label>
    @endif

    <div class="flex @if($labelPosition === 'under' || $labelPosition === 'top') flex-col items-center @else items-center  @endif">

        {{-- Label before --}}
        @if($label && $labelPosition === 'before')
            <label for="{{ $id }}" class="mr-[4px] text-slate-600 text-[16px] select-none {{ $labelClass }}">
                {{ $label }}
            </label>
        @endif

        {{-- Checkbox --}}
        <input
            type="checkbox"
            id="{{ $id }}"
            name="{{ $name }}"
            value="{{ $value }}"
            @if($checked) checked @endif
            @if($disabled) disabled @endif
            {{ $attributes->merge([
                'class' => 'w-5 h-5 text-blue-600 bg-white border border-slate-300 rounded focus:ring-2 focus:ring-blue-500 focus:outline-none disabled:opacity-50 disabled:cursor-not-allowed'
            ]) }}
        />

        {{-- Label after --}}
        @if($label && $labelPosition === 'after')
            <label for="{{ $id }}" class="ml-2 text-slate-600 text-[16px] select-none {{ $labelClass }}">
                {{ $label }}
            </label>
        @endif

        {{-- Label under --}}
        @if($label && $labelPosition === 'under')
            <label for="{{ $id }}" class="mt-1 text-slate-600 text-[16px] text-center select-none {{ $labelClass }}">
                {{ $label }}
            </label>
        @endif
    </div>

    {{-- Helper text --}}
    @if($helper)
        <p class="text-gray-400 text-sm mt-0.5 {{ $helperClass }}">{{ $helper }}</p>
    @endif
</div>
