@props([
   'placeholder' => 'აირჩიეთ',
   'name' => 'name',
   'id' => 'id',
   'options' => [],
   'className' => '',
   'hasSearch' => false
])

<!-- Select -->
<select name="{{ $name }}" id="{{ $id }}"

        multiple=""
        data-hs-select-placeholder="{{ $placeholder }}"
        data-hs-select='{
    @if($hasSearch)  "hasSearch": true, @endif
  "placeholder": "{{ $placeholder }}",
  "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
  "searchClasses": "block w-full sm:text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 before:absolute before:inset-0 before:z-1 border-neutral-700 text-neutral-400 placeholder-neutral-500 py-1.5 sm:py-2 px-3",
  "toggleClasses": "block-select-btn hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative pt-[17px] focus:text-blue-600 ps-4 pe-9 flex gap-x-2 text-nowrap cursor-pointer bg-white border border-gray-200 rounded-[12px] text-start text-[16px] focus:outline-hidden focus:ring-1 text-slate-600 {{ $className }}",
  "toggleCountText": "selected",
  "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-[#E9EEF6] rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300",
  "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-blue-50 rounded-lg focus:outline-hidden focus:bg-blue-50",
  "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600 dark:text-blue-500 \" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",
  "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 dark:text-neutral-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
}' class="hidden  rounded-[12px] border-[1px] border-slate-300 col-span-2 px-3 py-2 font-custom-regular text-[16px] text-slate-400" >
    <option value="">{{ $placeholder }}</option>
    @if(is_array($options) && count($options) > 0)
        @foreach($options as $k => $option)
            <option value="{{ $k }}">{{ $option }}</option>
        @endforeach
    @endif
</select>
<!-- End Select -->
@push('js')
    <script>
        $(document).ready(function () {
            $('select[multiple][data-hs-select]').on('change', function () {
                const $select = $(this);
                const values = $select.val() || [];
                console.log(values);
                const $toggleBtn = $('.block-select-btn');
                const placeholder = $select.attr('data-hs-select')?.match(/"placeholder":\s*"([^"]+)"/)?.[1] || 'Select multiple options...';
                if (values.length === 0) {
                    $toggleBtn.html(placeholder);
                }else{
                    $toggleBtn.html(values.length + ' '+'{!! __($placeholder) !!}');
                }
            });
        });
    </script>
@endpush

