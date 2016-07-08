@extends('emails.base')

@section('emailContent')
    <tr>
        <td colspan = "3"><h3>Greetings, {{$user->handle}}</h3></td>
    </tr>
    <tr>
        <td colspan="3"><b>New announcement from <a href = "{{ url('/beacons/'. $beacon->beacon_tag) }}">{{ $beacon->name }}</a></b></td>
    </tr>
    <tr>
        <td colspan="3"><hr/></td>
    </tr>
    <tr>
        <td colspan="3"> <b>{{ $announcement->title }}</b></td>
    </tr>
    <tr>
        <td colspan="3">{{ $announcement->description }}</td>
    </tr>
    <tr>
        <td colspan="3">View the announcement <a href = "{{ url('/announcements/'. $announcement->id) }}">here.</a></td>
    </tr>
@endsection
@section('messageType')
    <tr><td>Beacon Announcement</td></tr>
@stop