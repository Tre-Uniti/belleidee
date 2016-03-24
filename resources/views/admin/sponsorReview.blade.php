@extends('app')
@section('siteTitle')
    Sponsor Review
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
            <tr>
            <tr>
                <td><b>User:</b></td>
                <td>{{ $sponsorRequest->user->handle }}</td>
            </tr>
        </table>
    </div>
@stop

@section('centerFooter')
    <div id = "centerFooter">
        @if($user->type > 1)
            <a href="{{ url('/admin/sponsor/convert/'.$sponsorRequest->id) }}"><button type = "button" class = "navButton">Convert to Sponsor</button></a>
                {!! Form::open(['method' => 'DELETE', 'route' => ['sponsorRequests.destroy', $sponsorRequest->id]]) !!}
                {!! Form::submit('Delete', ['class' => 'navButton', 'id' => 'delete']) !!}
                {!! Form::close() !!}

        @endif
    </div>
@stop

