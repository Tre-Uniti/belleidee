@extends('app')
@section('siteTitle')
    Show User
@stop

@section('centerText')
    <h2>Profile of {{$user->handle}}</h2>
    <div class = "indexNav">
        <b>Creations:</b>
    </div>
    <div class = "indexNav">
        <a href="{{ url('/posts/user/'. $user->id) }}"><button type = "button" class = "indexButton">Posts: {{ $posts }}</button></a>
        <a href="{{ url('/extensions/user/'. $user->id) }}"><button type = "button" class = "indexButton">Extensions: {{ $extensions }}</button></a>
    </div>
    <div class = "indexNav">
        <b>Inspires Others:</b>
    </div>
    <div class = "indexNav">
        <a href="{{ url('/users/elevatedBy/'. $user->id) }}"><button type = "button" class = "indexButton">Elevated: {{ $user->elevation }}</button></a>
        <a href="{{ url('/users/extendedBy/'. $user->id) }}"><button type = "button" class = "indexButton">Extended: {{ $user->extension }}</button></a>
    </div>

@stop

@section('centerFooter')
    <div id = "centerFooter">

        @if(Auth::id() != $user->id)
            <a href="{{ url('/bookmarks/users/'.$user->id) }}"><button type = "button" class = "navButton">Bookmark</button></a>
        @endif
            @if(Auth::user()->type > 1)
                <a href="{{ url('intolerances/userIndex/'. $user->id) }}"><button type = "button" class = "navButton">Intolerances</button></a>
                <a href="{{ url('users/'. $user->id . '/edit') }}"><button type = "button" class = "navButton">Edit</button></a>
                {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id]]) !!}
                {!! Form::submit('Delete User', ['class' => 'navButton', 'id' => 'delete']) !!}
                {!! Form::close() !!}

            @endif
    </div>
@stop

