@if($notifications && !empty($notifications))
    <div class="c-notification__list">
        @foreach($notifications as $notification)
            @component('components/notification')
                {!! $notification !!}
            @endcomponent
        @endforeach
    </div>
@endif
