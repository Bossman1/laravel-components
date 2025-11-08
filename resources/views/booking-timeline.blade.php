@props([
    'startDate' => now(),
    'weeks' => 2,
    'days' => null,
    'interval' => 60,
    'disabledTimes' => [],
    'businessStart' => '09:00',
    'businessEnd' => '18:00',
])

@php
    use Carbon\Carbon;

    $daysArray = [];
    $totalDays = $days ? $days : $weeks * 7; // if days is set, use it, else weeks * 7
    $locale = 'ka';
    Carbon::setLocale($locale);
    $current = Carbon::parse($startDate);

    for ($i = 0; $i < $totalDays; $i++) {
        $daysArray[] = [
            'date' => $current->format('Y-m-d'),
            'dayName' =>  $current->isoFormat('dddd'),
            'dayNum' => $current->format('d'),
            'monthShort' => $current->isoFormat('MMM'),
            'monthFull' => $current->isoFormat('MMMM'),
        ];
        $current->addDay();
    }

    // Generate times
    $times = [];
    $time = Carbon::parse($businessStart);
    $end = Carbon::parse($businessEnd);
    while ($time->lte($end)) {
        $times[] = $time->format('H:i');
        $time->addMinutes($interval);
    }

    // Chunking
    $chunkSize = $days ?? 7; // if days set, use it, else 7 for a week
    $weeksArray = array_chunk($daysArray, $chunkSize);
@endphp
{{--{{ dd($weeksArray) }}--}}
{{-- One week = one slide --}}


@foreach($weeksArray as $weeks)
    @foreach($weeks as $k => $day)
        <div class="booking-week-slide px-[4px]">
            <div class="overflow-x-auto">
                <div class="grid grid-cols-1 bg-white  overflow-hidden font-custom-regular space-x-[8px]">
                    {{-- Each column = One day --}}

                    <div class="flex flex-col  bg-white rounded-[16px] gap-[8px]">
                        {{-- Day header --}}
                        <div
                            class="day-header  py-[12px] text-center bg-slate-50 text-slate-800 rounded-[16px]"
                            data-date="{{ $day['date'] }}">
                            <div class="text-[36px] font-custom-bold-upper">{{ $day['dayNum'] }} <span class="text-[16px]">{{ $day['monthShort'] }}</span></div>
                            <div class="text-[16px]">{{ $day['dayName'] }}</div>
                        </div>

                        {{-- Time slots for this day --}}
                        @foreach($times as $time)
                            @php
                                $slotKey = $day['date'].' '.$time;
                                $disabled = in_array($slotKey, $disabledTimes);
                            @endphp

                        @if($disabled) @continue @endif
                            <button
                                class="time-slot w-full  border border-slate-300 rounded-[8px]  text-slate-500 text-[16px] py-[12px]  transition
                                       {{ $disabled ? 'bg-slate-100 cursor-not-allowed' : 'cursor-pointer hover:bg-sky-600 hover:border-sky-800 hover:text-white' }}"
                                data-date="{{ $day['date'] }}"
                                data-time="{{ $time }}"
                                {{ $disabled ? 'disabled' : '' }}>
                                {{ $time }}
                            </button>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    @endforeach
@endforeach


@once
    @push('js')
        <script>
            $(document).ready(function () {
                // Handle time selection
                $('.booking-timeline').off('click').on('click', '.time-slot:not(:disabled)', function () {
                    $('.time-slot').removeClass('!bg-sky-600 !border !border-sky-800 !text-white');
                    $('.day-header').removeClass('!bg-sky-700 !text-white');
                    $(this).addClass('!bg-sky-600 !border !border-sky-800 !text-white');
                    const date = $(this).data('date');
                    const time = $(this).data('time');
                    $(`.day-header[data-date="${date}"]`).addClass('!bg-sky-700 !text-white');
                    // console.log(`Selected: ${date} ${time}`);
                });
            });
        </script>
    @endpush
@endonce
