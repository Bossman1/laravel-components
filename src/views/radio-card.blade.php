@props([
    'id' => 'id_'.uniqid(),
    'name' => 'name_'.uniqid(),
    'value' => '',
    'label' => '',
    'labelDescription' => '',
    'icon' => null,
    'iconPosition' => 'right', // right | left
    'iconClass' => 'h-[48px] w-[48px]',
    'options' => [],
    'textPosition' => 'bottom' // bottom | right
])


@if(is_array($options) && !empty($options))
    @foreach($options as $k => $option)

        @php

            $iconPosition  = $option['iconPosition'] ?? 'right';
            $id  = $option['id']  ?? uniqid();
        @endphp
        <label
                for="{{ $id }}"
                class="flex-1 items-start gap-3 p-4 border border-sky-200 rounded-[12px] bg-sky-50 cursor-pointer hover:bg-sky-100 transition">
            <!-- Radio + Label stacked vertically -->
            <div class="flex @if($textPosition == 'right') flex-row gap-2 @else flex-col @endif  items-start">
                <div class="flex justify-start items-center gap-[8px]">
                    @if($iconPosition ==='left')
                        <div>
                            <x-dynamic-component :component="$option['icon']" class="{{ $iconClass }}" />
                        </div>
                    @endif
                    <input
                            id="{{ $id }}"
                            type="radio"
                            name="{{ $name }}"
                            value="{{ $option['value'] ??  '' }}"
                            class="w-[16px] h-[16px] text-sky-600 bg-gray-100 border-gray-300 focus:ring-sky-600 focus:ring-1"
                            {{ isset($option['checked']) ? 'checked': '' }}
                    />
                    @if($iconPosition ==='right')
                        <div>
                            <x-dynamic-component :component="$option['icon']" class="{{ $iconClass }}" />
                        </div>
                    @endif
                </div>

                <div class="@if($textPosition == 'bottom') mt-2  @endif  select-none">
                    <div class="text-[16px] text-slate-800 font-custom-bold-upper">
                        {{ $option['label'] }}
                    </div>
                    @if(isset($option['labelDescription']) && trim($option['labelDescription']) !='')
                        <div class="text-[15px] text-slate-600">
                            {{ $option['labelDescription'] }}
                        </div>
                    @endif
                </div>
            </div>
        </label>

    @endforeach
@else
    <label
            for="{{ $id }}"
            class="flex-1 items-start gap-3 p-4 border border-sky-200 rounded-[12px] bg-sky-50 cursor-pointer hover:bg-sky-100 transition">
        <!-- Radio + Label stacked vertically -->
        <div class="flex @if($textPosition == 'right') flex-row @else flex-col @endif items-start">
            <div class="flex justify-start items-center gap-[8px]">
                @if($iconPosition ==='left')
                    <div>
                        <x-dynamic-component :component="$icon" class="h-[48px] w-[48px]" />
                    </div>
                @endif
                <input
                        id="{{ $id }}"
                        type="radio"
                        name="{{ $name }}"
                        value="{{ $value ?? '' }}"
                        class="w-[16px] h-[16px] text-sky-600 bg-gray-100 border-gray-300 focus:ring-sky-600 focus:ring-1"
                        checked
                />
                @if($iconPosition ==='right')
                    <div>
                        <x-dynamic-component :component="$icon" class="h-[48px] w-[48px]" />
                    </div>
                @endif
            </div>

            <div class="@if($textPosition == 'bottom') mt-2 gap-2 @endif select-none">
                <div class="text-[16px] text-slate-800 font-custom-bold-upper">
                    {{ $label }}
                </div>
                @if(isset($labelDescription) && trim($labelDescription) !='')
                    <div class="text-[15px] text-slate-600">
                        {{ $labelDescription }}
                    </div>
                @endif
            </div>
        </div>
    </label>
@endif