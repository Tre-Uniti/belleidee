@extends('emails.base')

@section('emailContent')
    <tr>
        <td colspan = "3" style = "text-align: center"><h3>Greetings, {{$user->handle}}</h3></td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: center">Legacy posts are created by Admins to help users discover the inspirational texts of each belief.</td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: center">Below is a overview of the latest Legacy posts!</td>
    </tr>

    <tr>
        <td colspan="3"><hr/></td>
    </tr>


@endsection
@section('messageType')
    <tr><td>Community Message</td></tr>
    <tr><td>Legacy Report</td></tr>
@stop