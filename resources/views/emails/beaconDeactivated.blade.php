@extends('emails.base')

@section('emailContent')
    <tr>
        <td colspan = "3"><h3>Greetings, {{$user->handle}}</h3></td>
    </tr>
    <tr>
        <td colspan="3"><b>{{ $beacon->name }}</b> has deactivated their Beacon account</td>
    </tr>
    <tr>
        <td colspan="3">The content localized to {{ $beacon->beacon_tag }} has been reassigned to 'No-Beacon'.</td>
    </tr>
    <tr>
        <td colspan="3">If you have any questions or concerns please submit a support ticket <a href = "{{ url('/supports/create') }}">here.</a></td>
    </tr>
@endsection
@section('messageType')
    <tr><td>System Message</td></tr>
    <tr><td>Beacon Deactivated</td></tr>
@stop