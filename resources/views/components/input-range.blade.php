@props([
    'id' => uniqid('slider_'),
    'min' => 0,
    'max' => 100,
    'start' => [0, 100],
    'step' => 1,
    'connect' => true,
    'showInputs' => false,         // show min/max inputs
    'json' => null,                // optional JSON from controller
    'minInputName' => null,
    'maxInputName' => null,
    'minPlaceholder' => 'Min',
    'maxPlaceholder' => 'Max',
    'minInputClass' => 'border rounded-md p-2 w-16 text-sm text-center',
    'maxInputClass' => 'border rounded-md p-2 w-16 text-sm text-center',
    'inputsWrapperClass' => 'flex gap-2 items-center ml-4',
    'sliderClass' => 'flex-1',
    'label' => null,
    'labelClass' => '',
    'showValueInLabel' => false,
    'showValueInLabelText' => '',
    'inputMobileStyle' => ''
])

@php
    if ($json && is_string($json)) {
        $decoded = json_decode($json, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            $start = $decoded['start'] ?? $start;
            $min = $decoded['min'] ?? $min;
            $max = $decoded['max'] ?? $max;
            $step = $decoded['step'] ?? $step;
            $connect = $decoded['connect'] ?? $connect;
        }
    }

    // This block handles both single value and array inputs
    if (!is_array($start)) $start = [$start];
    $isSingle = count($start) === 1;

    $minInputName = $minInputName ?? ('min_' . $id);
    // If it's a single slider, we still use maxInputName as a hidden field name for consistent form submission.
    $maxInputName = $maxInputName ?? ('max_' . $id);
@endphp

<div id="range-wrapper-{{ $id }}" {{ $attributes->merge(['class' => 'relative space-y-2']) }}>

    {{-- Label under slider --}}
    @if($label)
        <div class="text-sm text-gray-600 absolute left-0 top-[6px] {{ $labelClass }}">
            <span id="slider-label-{{ $id }}">
                {{ $label }}
                @if($showValueInLabel)
                    : <span>
                        @if($isSingle)
                            {{ $start[0] }}
                        @else
                            {{ $start[0] }} - {{ $start[1] }}
                        @endif {{ $showValueInLabelText }}
                    </span>
                @endif
            </span>
        </div>
    @endif

    {{-- Slider + Inputs inline --}}
    <div class="md:items-center gap-4 @if($inputMobileStyle ==='') flex-col sm:flex-row flex @else {{ $inputMobileStyle }}  @endif   ">

        <div id="range-{{ $id }}" class="{{ $sliderClass }}"></div>

        @if($showInputs)
            <div class="{{ $inputsWrapperClass }}">
                <input
                    type="number"
                    name="{{ $minInputName }}"
                    id="min-input-{{ $id }}"
                    placeholder="{{ $minPlaceholder }}"
                    class="{{ $minInputClass }}"
                    value="{{ $start[0] ?? $min }}"
                    min="{{ $min }}"
                    max="{{ $max }}"
                >
                {{-- Only show the max input for a range slider --}}
                @if(!$isSingle)
                    <input
                        type="number"
                        name="{{ $maxInputName }}"
                        id="max-input-{{ $id }}"
                        placeholder="{{ $maxPlaceholder }}"
                        class="{{ $maxInputClass }}"
                        value="{{ $start[1] ?? $max }}"
                        min="{{ $min }}"
                        max="{{ $max }}"
                    >
                    {{-- Use a hidden input for the single value to submit consistently on the maxInputName --}}
                @else
                    <input type="hidden" name="{{ $maxInputName }}" id="max-input-{{ $id }}"
                           value="{{ $start[0] ?? $max }}">
                @endif
            </div>
        @endif
    </div>

</div>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/nouislider@15.7.0/dist/nouislider.min.css">

<style>
    .noUi-target {
        background: #e5e7eb;
        border-radius: 0.5rem;
        height: 8px;
    }

    .noUi-horizontal .noUi-handle {
        background: white;
        border: 2px solid #3b82f6;
        border-radius: 9999px;
        width: 20px;
        height: 20px;
        top: -7px;
        margin-right: 7px
    }

    .noUi-connect {
        background: #3b82f6;
    }

    .noUi-handle.noUi-handle-lower, .noUi-handle.noUi-handle-upper {
        background: #00BCFF !important;
        border: 1px solid #F8FAFC !important;
        width: 20px !important;
        height: 20px !important;
    }

    .noUi-connect {
        background: #0084D1 !important;
    }

    .noUi-handle {
        box-shadow: none !important;
    }

    .noUi-handle::before, .noUi-handle::after {
        content: "" !important;
        background: transparent !important;
    }
</style>


<script src="https://cdn.jsdelivr.net/npm/nouislider@15.7.0/dist/nouislider.min.js"></script>

<script>
    (function () {
        const elId = 'range-{{ $id }}';
        const minInputId = 'min-input-{{ $id }}';
        const maxInputId = 'max-input-{{ $id }}';
        const cfg = {
            start: @json(array_values($start)),
            min: {{ $min }},
            max: {{ $max }},
            step: {{ $step }},
            connect: {{ $connect ? 'true' : 'false' }},
            showInputs: {{ $showInputs ? 'true' : 'false' }},
            isSingle: {{ $isSingle ? 'true' : 'false' }},
            showValueInLabel: {{ $showValueInLabel ? 'true' : 'false' }},
        };

        function tryInit(retries = 30) {

            const el = document.getElementById(elId);
            if (!el) return retries > 0 ? setTimeout(() => tryInit(retries - 1), 50) : console.warn('[slider] element not found:', elId);
            if (typeof noUiSlider === 'undefined') return retries > 0 ? setTimeout(() => tryInit(retries - 1), 100) : console.warn('[slider] noUiSlider not loaded:', elId);
            if (el.noUiSlider) try {
                el.noUiSlider.destroy();
            } catch (e) {
            }

            const startCfg = cfg.start.slice();
            for (let i = 0; i < startCfg.length; i++) {
                let v = Number(startCfg[i]);
                if (isNaN(v)) v = cfg.min;
                startCfg[i] = Math.min(Math.max(v, cfg.min), cfg.max);
            }

            // This determines if it's a single or range slider for noUiSlider.
            const finalStart = cfg.isSingle
                ? [startCfg[0]]
                : (startCfg.length >= 2 ? [startCfg[0], startCfg[1]] : [cfg.min, cfg.max]);

            noUiSlider.create(el, {
                start: finalStart,
                connect: cfg.connect,
                range: {min: cfg.min, max: cfg.max},
                step: cfg.step,
                format: {to: v => Math.round(v), from: v => Number(v)}
            });

            if (cfg.showInputs) {
                const minInput = document.getElementById(minInputId);
                const maxInput = document.getElementById(maxInputId);

                if (minInput) minInput.value = finalStart[0];
                // For single slider, max input is actually a hidden field storing the single value
                if (maxInput) maxInput.value = finalStart[1] ?? finalStart[0];

                el.noUiSlider.on('update', (values) => {
                    // values[0] is the current value for a single slider
                    if (minInput) minInput.value = values[0];
                    // values[1] is undefined for a single slider, so use values[0]
                    if (maxInput) maxInput.value = values[1] ?? values[0];

                    if (cfg.showValueInLabel) {
                        const labelEl = document.getElementById('slider-label-{{ $id }}');
                        if (labelEl) labelEl.querySelector('span').textContent = cfg.isSingle
                            ? values[0] + ' {{ $showValueInLabelText }} '
                            : values[0] + ' - ' + values[1] + ' {{ $showValueInLabelText }} ';
                    }
                });

                // Input listeners to update the slider
                if (minInput) minInput.addEventListener('change', () => {
                    const v = Number(minInput.value);
                    if (!isNaN(v)) el.noUiSlider.set([v, null]); // Update lower handle
                });
                if (maxInput && !cfg.isSingle) maxInput.addEventListener('change', () => {
                    const v = Number(maxInput.value);
                    if (!isNaN(v)) el.noUiSlider.set([null, v]); // Update upper handle (only for range)
                });

            } else if (cfg.showValueInLabel) {
                el.noUiSlider.on('update', (values) => {
                    const labelEl = document.getElementById('slider-label-{{ $id }}');
                    if (labelEl) labelEl.querySelector('span').textContent = cfg.isSingle
                        ? values[0] + ' {{ $showValueInLabelText }} '
                        : values[0] + ' - ' + values[1] + ' {{ $showValueInLabelText }} ';
                });
            }
        }

        if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', () => tryInit());
        else tryInit();
    })();
</script>

