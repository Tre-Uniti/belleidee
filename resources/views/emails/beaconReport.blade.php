@extends('emails.base')

@section('emailContent')
    <tr>
        <td colspan="3" style = "text-align: center"><h3>Monthly Report</h3></td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: center"><b>{{$beacon->name}}</b></td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: center">Beacon Tag: {{ $beacon->beacon_tag }} </td>
    </tr>
    <tr>
        <td colspan="3"><hr/></td>
    </tr>

    <tr>
        <td style = "text-align: center"><b>Picture/Logo Views:</b> </td>
        <td style = "text-align: center"><b>Tag Usage:</b> </td>
        <td style = "text-align: center"><b>Total Tag Usage:</b></td>
    </tr>
    <tr>
        <td style = "text-align: center">{{ $beacon->tag_views }}</td>
        <td style = "text-align: center">{{ $beacon->tag_usage}}</td>
        <td style = "text-align: center">{{ $beacon->total_tag_usage }}</td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: center">If you have any questions or concerns please submit a support ticket <a href = "{{ url('/supports/create') }}">here.</a></td>
    </tr>
@endsection
@section('messageType')
    <tr><td>Reporting</td></tr>
    <tr><td>Monthly Usage</td></tr>
@stop