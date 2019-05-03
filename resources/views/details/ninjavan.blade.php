<table class="table table-responsive">
    <thead>
        <tr>
            <th>#</th>
            <th>Date/Time</th>
            <th>Description</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tracking_code->histories as $key => $history)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $history->history_date_time->format('d M Y h:i A') }}</td>
            <td>{{ $history->description }}</td>
        </tr>
        @endforeach
        @if ($tracking_code->histories->count() == 0)
        <tr>
            <td colspan="4" class="text-center">
                <h3>There is no data found, yet.</h3>
            </td>
        </tr>
        @endif
    </tbody>
</table>
