@extends('app')
@section('siteTitle')
    Delete Account
@stop
@section('centerText')
    <h2>Are you sure you want to delete?</h2>
    <p>The content you have created that is part of the Idee community is transferred while rest is deleted.</p>

    <table align = "center">
        <tr>
            <td><a href="{{ url('/home') }}"><button type = "button" class = "interactButton">Cancel</button></a></td>
            <td>{!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id]]) !!}
                {!! Form::submit('Delete Account', ['class' => 'interactButton', 'id' => 'delete']) !!}
                {!! Form::close() !!}</td>
        </tr>
    </table>
    <hr/>

    <table align = "center">
        <tr>
            <th>Content:</th>
            <th>Action:</th>
        </tr>
        <tr>
            <td><a href="{{ url('/posts/user/'. $user->id) }}"><button type = "button" class = "interactButton">Posts</button></a></td>
            <td><a href="{{ url('/users/'. 20) }}"><button type = "button" class = "interactButton">Transferred</button></a></td>
        </tr>
        <tr>
            <td><a href="{{ url('/extensions/user/'. $user->id) }}"><button type = "button" class = "interactButton">Extensions</button></a></td>
            <td><a href="{{ url('/users/'. 20) }}"><button type = "button" class = "interactButton">Transferred</button></a></td>
        </tr>
        <tr>
            <td><a href="{{ url('/questions') }}"><button type = "button" class = "interactButton">Questions</button></a></td>
            <td><a href="{{ url('/users/'. 20) }}"><button type = "button" class = "interactButton">Transferred</button></a></td>
        </tr>
        <tr>
            <td><a href="{{ url('/users/elevatedBy/'. $user->id) }}"><button type = "button" class = "interactButton">Elevations</button></a></td>
            <td><a href="{{ url('/users/'. 20) }}"><button type = "button" class = "interactButton">Transferred</button></a></td>
        </tr>
        <tr>
            <td><a href="{{ url('/users/extendedBy/'. $user->id) }}"><button type = "button" class = "interactButton">Extended by</button></a></td>
            <td><a href="{{ url('/users/'. 20) }}"><button type = "button" class = "interactButton">Transferred</button></a></td>
        </tr>
        <tr>
            <td><a href="{{ url('/intolerances') }}"><button type = "button" class = "interactButton">Intolerances</button></a></td>
            <td><a href="{{ url('/users/'. 20) }}"><button type = "button" class = "interactButton">Transferred</button></a></td>
        </tr>
        <tr>
            <td><a href="{{ url('/beaconRequests') }}"><button type = "button" class = "interactButton">Beacon Requests</button></a></td>
            <td><a href="{{ url('/users/'. 20) }}"><button type = "button" class = "interactButton">Transferred</button></a></td>
        </tr>
        <tr>
            <td><a href="{{ url('/sponsorRequests') }}"><button type = "button" class = "interactButton">Sponsor Requests</button></a></td>
            <td><a href="{{ url('/users/'. 20) }}"><button type = "button" class = "interactButton">Transferred</button></a></td>
        </tr>
        <tr>
            <td><a href="{{ url('/beacons') }}"><button type = "button" class = "interactButton">Beacons</button></a></td>
            <td><a href="{{ url('/users/'. 20) }}"><button type = "button" class = "interactButton">Transferred</button></a></td>
        </tr>
        <tr>
            <td><a href="{{ url('/sponsors') }}"><button type = "button" class = "interactButton">Sponsors</button></a></td>
            <td><a href="{{ url('/users/'. 20) }}"><button type = "button" class = "interactButton">Transferred</button></a></td>
        </tr>
        <tr>
            <td><a href="{{ url('/invites') }}"><button type = "button" class = "interactButton">Invites</button></a></td>
            <td><button type = "button" class = "interactButton">Deleted</button></td>
        </tr>
        <tr>
            <td><a href="{{ url('/notifications') }}"><button type = "button" class = "interactButton">Notifications</button></a></td>
            <td><button type = "button" class = "interactButton">Deleted</button></td>
        </tr>
        <tr>
            <td><a href="{{ url('/settings') }}"><button type = "button" class = "interactButton">Sponsorships</button></a></td>
            <td><button type = "button" class = "interactButton">Deleted</button></td>
        </tr>
        <tr>
            <td><a href="{{ url('/drafts') }}"><button type = "button" class = "interactButton">Drafts</button></a></td>
            <td><button type = "button" class = "interactButton">Deleted</button></td>
        </tr>
        <tr>
            <td><a href="{{ url('/bookmarks') }}"><button type = "button" class = "interactButton">Bookmarks</button></a></td>
            <td><button type = "button" class = "interactButton">Deleted</button></td>
        </tr>
        <tr>
            <td><a href="{{ url('/users/'. $user->id) }}"><button type = "button" class = "interactButton">User</button></a></td>
            <td><button type = "button" class = "interactButton">Deleted</button></td>
        </tr>
    </table>


@stop
@section('centerFooter')

@stop
