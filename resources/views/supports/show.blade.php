@extends('app')
@section('siteTitle')
    Show Beacon
@stop

@section('centerMenu')
    <h2>Support Request</h2>
    <table align = "center">
        <tr>
            <th>
                ID
            </th>
            <th>
                Type
            </th>
            <th>
                Status
            </th>
        </tr>
        <tr>
            <td>{{ $support->id }}</td>
            <td>{{ $support->type }}</td>
            <td>{{ $support->status }}</td>
        </tr>
    </table>
@stop

@section('centerText')
    <div id = "centerTextContent">

        <p>
            {{ $support->request }}
        </p>
    </div>
@stop

@section('centerFooter')
    <a href="{{ url('supports/') }}"><button type = "button" class = "navButton">Other Requests</button></a>
    <a href="{{ url('supports/'. $support->id . '/edit') }}"><button type = "button" class = "navButton">Edit</button></a>

@stop


