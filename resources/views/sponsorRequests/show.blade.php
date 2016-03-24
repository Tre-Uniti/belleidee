@extends('app')
@section('siteTitle')
    Sponsor Request
@stop

@section('centerMenu')
    <h2>{{ $sponsorRequest->name }}</h2>
@stop

@section('centerText')
    <div>
        <table style="display: inline-block;">
            <tr>
                <td><b>Address: </b></td>
                <td>{{ $sponsorRequest->address }}</td>
            </tr>
            <tr>
                <td><b>Country:</b> </td>
                <td>{{ $sponsorRequest->country }}</td>
            </tr>
            <tr>
                <td><b>City or Region:</b> </td>
                <td>{{ $sponsorRequest->location }}</td>
            </tr>
            <tr>
                <td><b>Phone:</b> </td>
                <td>{{ $sponsorRequest->phone }}</td>
            <tr>
                <td><b>Email:</b> </td>
                <td>{{ $sponsorRequest->email }}</td>
            </tr>
            <tr>
                <td><b>Website:</b> </td>
                <td>{{ $sponsorRequest->website }}</td>
            </tr>
            <tr>
                <td><b>Adult: </b></td>
                <td>{{ $sponsorRequest->adult }}</td>
            </tr>
    </table>
        </div>
@stop

@section('centerFooter')
    <div id = "centerFooter">
        <a href="{{ url('/sponsorRequests/') }}"><button type = "button" class = "navButton">Requests</button></a>
        @if($sponsorRequest->user_id == $user->id)
            <a href="{{ url('/sponsorRequests/'.$sponsorRequest->id .'/edit') }}"><button type = "button" class = "navButton">Edit</button></a>
        @endif
        @if($user->type > 1)
                <a href="{{ url('/admin/sponsor/review/'.$sponsorRequest->id) }}"><button type = "button" class = "navButton">Review</button></a>
        @endif
    </div>
@stop

