<?php // TODO MVVM logic
$sent_at = $sent_at ? $sent_at->startOfDay() : null;
$today = $today ? $today->startOfDay() : null;
$deadline = $deadline ? $deadline->startOfDay() : null;
$deleted_at = $deleted_at ? $deleted_at->startOfDay() : null;

$latest_date = max([$today, $deadline, $deleted_at]);
$totalDays = $sent_at->diffInDays($latest_date);
$totalPercent = $totalDays / 100;

$timeline[0] = [
    'date' => $sent_at,
    'icon' => 'send',
    'name' => 'Envoyé',
    'slug' => 'created_at',
    'text' => $sent_at->diffForHumans()
];

$timeline[$sent_at->diffInDays($deadline) / $totalPercent] = [
    'date' => $deadline,
    'icon' => 'alert-triangle',
    'name' => 'Date limite',
    'slug' => 'deadline',
    'text' => $deadline->diffForHumans()
];
if (!$deleted_at) {
    $timeline[$sent_at->diffInDays($today) / $totalPercent] = [
        'date' => $today,
        'icon' => 'calendar',
        'name' => 'Aujourd\'hui',
        'slug' => 'today',
        'text' => ''
    ];
} else {
    $timeline[$sent_at->diffInDays($deleted_at) / $totalPercent] = [
        'date' => $deleted_at,
        'icon' => 'x-octagon',
        'name' => 'Cloturé',
        'slug' => 'deleted_at',
        'text' => $deleted_at->diffForHumans()
    ];
}
krsort($timeline);
$timelineAsc = $timeline;
ksort($timelineAsc);

?>

<div class="c-timeline">
    @foreach($timeline as $key => $val)
        @if($key == '100' && $val['slug'] === 'deadline')
            <div class="c-timeline__event c-timeline__event--in-time" style="width: {{ $key }}%"></div>
        @elseif($key == '100' && $val['slug'] !== 'deadline')
            <div class="c-timeline__event c-timeline__event--late" style="width: {{ $key }}%"></div>
        @else
            <div class="c-timeline__event" style="width: {{ $key }}%"></div>
        @endif
        <div class="c-timeline__info c-timeline__info--tmln c-timeline__info--{{ $val['slug'] }}"
             title="{{ $val['name'] . ' ' . $val['text'] }}" style="left: {{ $key }}%">
            @svg($val['icon'], 'c-timeline__icon')
        </div>
    @endforeach
</div>
<div class="c-timeline__texts">
    @foreach($timelineAsc as $key => $val)
        <time datetime="{{ $val['date'] }}" class="c-timeline__text"
              style="left: {{ $key }}%; transform: translateX(-{{ $key }}%);">
            {{ $val['name'] . ' ' . $val['text'] . ' (' . $val['date']->format('d/m') . ')' }}
        </time>
    @endforeach
</div>
<div class="c-timeline__captions">
    @foreach($timelineAsc as $key => $val)
        <time datetime="" class="c-timeline__caption">
            <div class="c-timeline__info c-timeline__info--{{ $val['slug'] }}"
                 title="{{ $val['name'] . ' ' . $val['text'] }}">
                @svg($val['icon'], 'c-timeline__icon')
            </div>
            {{ $val['name'] . ' ' . $val['text'] . ' (' . $val['date']->format('d/m') . ')' }}
        </time>
    @endforeach
</div>
