@component('mail::message')
# Tracking Code: {{ $tracking_code->code }}
# Courier: {{ $tracking_code->courier->name }}

@component('mail::table')
| Date/Time       | Description         |
| ------------- |:-------------:|
@foreach ($tracking_code->histories as $history)
| {{ $history->history_date_time->format('Y-m-d H:i') }} | {{ $history->description }} |
@endforeach
@if ($tracking_code->histories->count() == 0)
| | <h4>There is no data found, yet.</h4> | |
@endif
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
