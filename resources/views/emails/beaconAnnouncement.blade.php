@extends('emails.base')

@section('emailContent')
    <tr>
        <td colspan = "3"><h3>Greetings, {{$user->handle}}</h3></td>
    </tr>
    <tr>
        <td colspan="3"><b>This is a new announcement from <a href = "{{ url('/beacons/'. $beacon->beacon_tag) }}">{{ $beacon->name }}</a></b></td>
    </tr>
    <tr>
        <td colspan="3"> <b>{{ $announcement->title }}</b></td>
    </tr>
    <tr>
        <td colspan="3">{{ $announcement->description }}</td>
    </tr>
    <tr>
        <td colspan="3">You may also view the announcement <a href = "{{ url('/announcements/'. $announcement->id) }}">here.</a></td>
    </tr>
@endsection
@section('messageType')
    <tr><td>System Message</td></tr>
    <tr><td>Beacon Deactivated</td></tr>
@stop