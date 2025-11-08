@props([
    'placeholder' => 'placeholder',
    'floatingLabelPlaceholder' => '',
    'name' => 'name',
    'id' => 'id',
    'type' => 'text',
    'value' => '',
    'attributes' => [],
    'options' => [],
    'isFloatingLabel' => false,
    'labelClass' => '',
    'showEye' => true,
    'labelPosition' => 'top',
    'mask' => null,
    'showStrength' => false,
])

<div
    class="relative w-full @if(!$isFloatingLabel && ($labelPosition === 'before' || $labelPosition === 'after')) flex items-center @endif">

    {{-- Normal label before input --}}
    @if(!$isFloatingLabel && ($labelPosition === 'before'|| $labelPosition === 'top'))
        <label for="{{ $id }}" class="block mr-2 text-gray-700 mb-1 {{ $labelClass }}">
            {!! $placeholder !!}
        </label>
    @endif

    <div class="relative w-full">
        <input
            {{ $attributes->merge([
                'class' => 'peer block w-full border border-slate-300 rounded-[12px] bg-transparent px-3 pt-2 pb-2 text-[16px] text-slate-600'
                    . ($isFloatingLabel ? ' placeholder-transparent ' : '')
                    . ' focus:outline-none focus:ring-2 focus:ring-blue-500'
            ]) }}
            type="{{ $type }}"
            id="{{ $id }}"
            @if(!$isFloatingLabel)
                placeholder="{{ $placeholder }}"
            @endif
            name="{{ $name }}"
            value="{{ $value }}"
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

        {{-- Floating label --}}
        @if($isFloatingLabel)
            <label for="{{ $id }}" id="{{ $id }}-label"
                   class="absolute left-3  text-gray-500 transition-all
                          peer-placeholder-shown:top-3.5
                          peer-placeholder-shown:text-gray-400
                          peer-placeholder-shown:text-base
                          peer-focus:top-1
                          peer-focus:text-blue-500
                          top-[0.875rem]
                          {{ $labelClass }}">
                {!! isset($floatingLabelPlaceholder) && !empty($floatingLabelPlaceholder) ? $floatingLabelPlaceholder : $placeholder !!}
            </label>
        @endif

        {{-- Eye icon --}}
        @if ($type === 'password' && $showEye)
            <button type="button"
                    onclick="togglePasswordVisibility('{{ $id }}')"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-700 focus:outline-none"
                    tabindex="-1">
                <svg id="eye-icon-{{ $id }}" xmlns="http://www.w3.org/2000/svg"
                     fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                     class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.284 4.5 12 4.5c4.716 0 8.577 3.01 9.964 7.183.07.207.07.432 0 .639C20.577 16.49 16.716 19.5 12 19.5c-4.716 0-8.577-3.01-9.964-7.178z"/>
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </button>
        @endif
    </div>

    {{-- Normal label after input --}}
    @if(!$isFloatingLabel && $labelPosition === 'after')
        <label for="{{ $id }}" class="block ml-2 text-gray-700 {{ $labelClass }}">
            {!! $placeholder !!}
        </label>
    @endif
</div>

{{-- ✅ Password Strength Section --}}
@if($type === 'password' && $showStrength)
    <div class="px-[16px] py-[16px]  bg-slate-100 rounded-[16px] mt-[4px]">
        <div class="mt-3 flex items-center justify-between bg-white py-[4px] px-[24px] rounded-[16px]" id="{{ $id }}-progress-wrp">
            <div class="flex justify-between items-center flex-1 space-x-1  h-[29px]" id="{{ $id }}-progress">
                @for ($i = 1; $i <= 5; $i++)
                    <div class="h-2 flex-1 bg-gray-300 rounded-[16px] transition-all duration-300"></div>
                @endfor
            </div>
            <span id="{{ $id }}-strength-text" class="hidden flex justify-between items-center text-[14px] text-gray-600 whitespace-nowrap h-[29px] bg-green-50 px-[10px] py-[10px] rounded-[36px]"></span>
        </div>

        <ul class="mt-3 text-[14px] space-y-2" id="{{ $id }}-rules">
            <li id="{{ $id }}-rule-length" class="flex items-center gap-2 text-slate-600">
                <span class="icon-wrapper"><x-dynamic-component :component="'phosphor-info'" class="h-[24px] w-[24px]"/></span>
                მინიმუმ 6 სიმბოლო (აუცილებელია)
            </li>
            <li id="{{ $id }}-rule-number" class="flex items-center gap-2 text-slate-600">
                <span class="icon-wrapper"><x-dynamic-component :component="'phosphor-info'" class="h-[24px] w-[24px]"/></span>
                ციფრები (0-9)
            </li>
            <li id="{{ $id }}-rule-lower" class="flex items-center gap-2 text-slate-600">
                <span class="icon-wrapper"><x-dynamic-component :component="'phosphor-info'" class="h-[24px] w-[24px]"/></span>
                პატარა ლათინური ასოები
            </li>
            <li id="{{ $id }}-rule-upper" class="flex items-center gap-2 text-slate-600">
                <span class="icon-wrapper"><x-dynamic-component :component="'phosphor-info'" class="h-[24px] w-[24px]"/></span>
                დიდი ლათინური ასოები
            </li>
            <li id="{{ $id }}-rule-symbol" class="flex items-center gap-2 text-slate-600">
                <span class="icon-wrapper"><x-dynamic-component :component="'phosphor-info'" class="h-[24px] w-[24px]"/></span>
                სიმბოლოები
            </li>
        </ul>
    </div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const input = document.getElementById('{{ $id }}');
        const label = document.getElementById('{{ $id }}-label');
        if (!input || !label) return;

        const floatLabel = () => {
            label.classList.add('!text-[11px]');
            label.classList.remove('text-[16px]');
            label.style.top = '0.25rem';
        };
        const resetLabel = () => {
            if (input.value.trim() === '') {
                label.classList.remove('!text-[11px]');
                label.classList.add('text-[16px]');
                label.style.top = '0.875rem';
            }
        };
        @if($mask === 'phone')
        floatLabel();
        @endif
        input.addEventListener('focus', floatLabel);
        input.addEventListener('click', floatLabel);
        input.addEventListener('blur', () => { @if($mask !== 'phone') resetLabel(); @endif });
        input.addEventListener('input', () => {
            if (input.value.trim() !== '') floatLabel();
            else { @if($mask !== 'phone') resetLabel(); @endif }
        });
        if (input.value.trim() !== '') floatLabel();
    });


    @if($mask === 'phone')

    document.addEventListener('DOMContentLoaded', () => {
        const input = document.getElementById('{{ $id }}');
        const fixedPart = '+995 ';
        let digits = []; // store only user-entered digits

        const formatPhone = () => {
            let formatted = fixedPart;
            formatted += (digits[0]||'_') + (digits[1]||'_') + (digits[2]||'_');
            formatted += ' / ';
            formatted += (digits[3]||'_') + (digits[4]||'_');
            formatted += ' - ';
            formatted += (digits[5]||'_') + (digits[6]||'_');
            formatted += ' - ';
            formatted += (digits[7]||'_') + (digits[8]||'_');
            return formatted;
        };

        const setCursor = () => {
            const pos = input.value.indexOf('_');
            if(pos !== -1) input.setSelectionRange(pos, pos);
            else input.setSelectionRange(input.value.length, input.value.length);
        };

        const updateInput = () => {
            input.value = formatPhone();
            setCursor();
        };

        // Initialize input
        input.value = formatPhone();

        input.addEventListener('keydown', (e) => {
            if(e.key === 'Backspace'){
                e.preventDefault();
                if(digits.length > 0){
                    digits.pop(); // remove last digit
                    updateInput();
                }
            } else if(/\d/.test(e.key) && digits.length < 9){
                e.preventDefault();
                digits.push(e.key); // add digit
                updateInput();
            } else if(e.key.length === 1){ // prevent non-numeric keys
                e.preventDefault();
            }
        });

        input.addEventListener('focus', () => {
            setTimeout(setCursor, 0);
        });
    });

    @endif



    function togglePasswordVisibility(id) {
        const input = document.getElementById(id);
        const icon = document.getElementById('eye-icon-' + id);
        if (!input || !icon) return;

        if (input.type === 'password') {
            input.type = 'text';
            icon.outerHTML = `
        <svg id="eye-icon-${id}" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"
             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.27-2.943-9.544-7a9.956 9.956 0 012.222-3.45M6.634 6.634A9.955 9.955 0 0112 5c4.478 0 8.27 2.943 9.544 7a9.952 9.952 0 01-4.302 5.118M15 12a3 3 0 11-6 0 3 3 0 016 0zM3 3l18 18"></path>
        </svg>`;
        } else {
            input.type = 'password';
            icon.outerHTML = `
        <svg id="eye-icon-${id}" xmlns="http://www.w3.org/2000/svg"
             fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
             class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.284 4.5 12 4.5c4.716 0 8.577 3.01 9.964 7.183.07.207.07.432 0 .639C20.577 16.49 16.716 19.5 12 19.5c-4.716 0-8.577-3.01-9.964-7.178z" />
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>`;
        }
    }


    @if($type === 'password' && $showStrength)
    $(document).ready(function(){
        function updatePasswordStrength(password, id){
            const rules = {
                length: password.length >= 6,
                number: /[0-9]/.test(password),
                lower: /[a-z]/.test(password),
                upper: /[A-Z]/.test(password),
                symbol: /[^A-Za-z0-9]/.test(password)
            };

            let score = Object.values(rules).filter(v => v).length;
            $.each(rules, function(key, value){
                const el = $(`#${id}-rule-${key}`);
                const iconWrapper = el.find('.icon-wrapper');

                if(value) {
                    el.removeClass('text-slate-600 text-red-700').addClass('text-green-700');
                    iconWrapper.html(`<x-dynamic-component :component="'phosphor-check'" class="h-[24px] w-[24px]"/>`);
                } else {
                    if(password.length === 0) {
                        el.removeClass('text-red-700 text-green-700').addClass('text-slate-600');
                        iconWrapper.html(`<x-dynamic-component :component="'phosphor-info'" class="h-[24px] w-[24px]"/>`);
                    } else {
                        el.removeClass('text-slate-600 text-green-700').addClass('text-red-700');
                        iconWrapper.html(`<x-dynamic-component :component="'phosphor-x'" class="h-[24px] w-[24px]"/>`);
                    }
                }
            });

            const segments = $(`#${id}-progress div`);
            const segmentsWrp = $(`#${id}-progress-wrp`);
            segments.removeClass('bg-red-500 bg-yellow-500 bg-green-500').addClass('bg-gray-300');
            let color = 'bg-red-500';
            if(score >= 3 && score < 5) color = 'bg-yellow-500';
            if(score === 5) color = 'bg-green-500';
            segments.each(function(index){
                if(index < score) $(this).removeClass('bg-gray-300').addClass(color);
            });

            const text = $(`#${id}-strength-text`);
            if(password.length === 0){
                console.log('no');
                segmentsWrp.removeClass('pl-[24px] pr-[5px]').addClass('px-[24px]');
            }else {
                console.log('yes');
                segmentsWrp.removeClass('px-[24px]').addClass('pl-[24px] pr-[5px]');
            }
            if(password.length === 0){
                text.text('').removeClass().addClass('hidden flex justify-between items-center text-[14px] text-slate-600 h-[29px] whitespace-nowrap px-[10px] py-[10px] rounded-[36px] bg-green-50 ml-[10px]');
            } else if(score <= 2){
                text.text('ცუდი პაროლი').removeClass().addClass('flex justify-between items-center text-[14px] text-red-700  h-[29px] whitespace-nowrap px-[10px] py-[10px] rounded-[36px] bg-green-50 ml-[10px]');
            } else if(score >= 3 && score < 5){
                text.text('საშუალო პაროლი').removeClass().addClass('flex justify-between items-center text-[14px] text-yellow-600  h-[29px] whitespace-nowrap px-[10px] py-[10px] rounded-[36px] bg-green-50 ml-[10px]');
            } else if(score === 5){
                text.text('კარგი პაროლი').removeClass().addClass('flex justify-between items-center text-[14px] text-green-700  h-[29px] whitespace-nowrap px-[10px] py-[10px] rounded-[36px] bg-green-50 ml-[10px]');
            }
        }

        $(`#{{ $id }}`).on('input', function(){
            updatePasswordStrength($(this).val(), '{{ $id }}');
        });
    });
    @endif
</script>
