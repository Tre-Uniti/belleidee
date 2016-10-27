@extends('app')
@section('siteTitle')
    Delete Account
@stop
@section('centerText')
    <h2>Are you sure you want to delete?</h2>
    <p>The content you have created that has been interacted with by the Belle-idee community is transferred while the rest is deleted.</p>

    <div class = "formInput">
        <p>
            <a href="{{ url('/settings') }}" class = "indexLink">Cancel</a>

        </p>
          {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id]]) !!}
                {!! Form::submit('Delete Account', ['class' => 'navButton', 'id' => 'delete']) !!}
                {!! Form::close() !!}
    </div>
    <hr/>

    <div class = "formInput">
        <a href="{{ url('/posts/user/'. $user->id) }}"><button type = "button" class = "interactButton">Posts</button></a>
        ->
        <a href="{{ url('/users/'. 20) }}"><button type = "button" class = "interactButton">Transferred</button></a>
        </div>
    <div class = "formInput">
        <a href="{{ url('/extensions/user/'. $user->id) }}"><button type = "button" class = "interactButton">Extensions</button></a>
        ->
        <a href="{{ url('/users/'. 20) }}"><button type = "button" class = "interactButton">Transferred</button></a>
    </div>
    <div class = "formInput">
        <a href="{{ url('/questions') }}"><button type = "button" class = "interactButton">Questions</button></a>
        ->
        <a href="{{ url('/users/'. 20) }}"><button type = "button" class = "interactButton">Transferred</button></a>
    </div>
    <div class = "formInput">
        <a href="{{ url('/users/elevatedBy/'. $user->id) }}"><button type = "button" class = "interactButton">Elevations</button></a>
        ->
        <a href="{{ url('/users/'. 20) }}"><button type = "button" class = "interactButton">Transferred</button></a>
    </div>
    <div class = "formInput">
        <a href="{{ url('/users/extendedBy/'. $user->id) }}"><button type = "button" class = "interactButton">Extended by</button></a>
        ->
        <a href="{{ url('/users/'. 20) }}"><button type = "button" class = "interactButton">Transferred</button></a>
    </div>
    <div class = "formInput">
        <a href="{{ url('/intolerances') }}"><button type = "button" class = "interactButton">Intolerances</button></a>
        ->
        <a href="{{ url('/users/'. 20) }}"><button type = "button" class = "interactButton">Transferred</button></a>
    </div>
    <div class = "formInput">
        <a href="{{ url('/beaconRequests') }}"><button type = "button" class = "interactButton">Beacon Requests</button></a>
        ->
        <a href="{{ url('/users/'. 20) }}"><button type = "button" class = "interactButton">Transferred</button></a>
    </div>
    <div class = "formInput">
        <a href="{{ url('/sponsorRequests') }}"><button type = "button" class = "interactButton">Sponsor Requests</button></a>
        ->
        <a href="{{ url('/users/'. 20) }}"><button type = "button" class = "interactButton">Transferred</button></a>
    </div>
    <div class = "formInput">
        <a href="{{ url('/beacons') }}"><button type = "button" class = "interactButton">Beacons</button></a>
        ->
        <a href="{{ url('/users/'. 20) }}"><button type = "button" class = "interactButton">Transferred</button></a>
    </div>
    <div class = "formInput">
        <a href="{{ url('/sponsors') }}"><button type = "button" class = "interactButton">Sponsors</button></a>
        ->
        <a href="{{ url('/users/'. 20) }}"><button type = "button" class = "interactButton">Transferred</button></a>
    </div>
    <div class = "formInput">
        <a href="{{ url('/invites') }}"><button type = "button" class = "interactButton">Invites</button></a>
        ->
        <button type = "button" class = "interactButton">Deleted</button>
    </div>
    <div class = "formInput">
        <a href="{{ url('/notifications') }}"><button type = "button" class = "interactButton">Notifications</button></a>
        ->
        <button type = "button" class = "interactButton">Deleted</button>
    </div>
    <div class = "formInput">
        <a href="{{ url('/settings') }}"><button type = "button" class = "interactButton">Sponsorships</button></a>
        ->
        <button type = "button" class = "interactButton">Deleted</button>
    </div>
    <div class = "formInput">
        <a href="{{ url('/drafts') }}"><button type = "button" class = "interactButton">Drafts</button></a>
        ->
        <button type = "button" class = "interactButton">Deleted</button>
    </div>
    <div class = "formInput">
        <a href="{{ url('/bookmarks') }}"><button type = "button" class = "interactButton">Bookmarks</button></a>
        ->
        <button type = "button" class = "interactButton">Deleted</button>
    </div>
    <div class = "formInput">
        <a href="{{ url('/users/'. $user->id) }}"><button type = "button" class = "interactButton">User</button></a>
        ->
        <button type = "button" class = "interactButton">Deleted</button>
    </div>
@stop
