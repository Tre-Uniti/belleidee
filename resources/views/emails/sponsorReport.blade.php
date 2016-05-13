@extends('emails.base')

@section('emailContent')
    <tr>
        <td colspan="3" style = "text-align: center"><h3>Monthly Report</h3></td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: center"><b>{{$sponsor->name}}</b></td>
    </tr>
    <tr>
        <td colspan="3"><hr/></td>
    </tr>

    <tr>
        <td style = "text-align: center"><b>Views:</b> </td>
        <td style = "text-align: center"><b>Clicks:</b> </td>
        <td style = "text-align: center"><b>Missed Views:</b></td>
    </tr>
    <tr>
        <td style = "text-align: center">{{ $sponsor->views }}</td>
        <td style = "text-align: center">{{ $sponsor->clicks}}</td>
        <td style = "text-align: center">{{ $sponsor->missed }}</td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: center">If you have any questions or concerns please submit a support ticket <a href = "{{ url('/supports/create') }}">here.</a></td>
    </tr>
@endsection
@section('messageType')
    <tr><td>Reporting</td></tr>
    <tr><td>Monthly Usage</td></tr>
@stop