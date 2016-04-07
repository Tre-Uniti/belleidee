@extends('app')
@section('siteTitle')
    Show User
@stop

@section('centerText')
    <h2>Profile of {{$user->handle}}</h2>
    <table align = "center">
        <tr>
            <th colspan="2">Creations:</th>
        </tr>
        <tr>
            <td>
                <a href="{{ url('/posts/user/'. $user->id) }}"><button type = "button" class = "interactButton">Posts: {{ $posts }}</button></a>
            </td>
            <td>
                <a href="{{ url('/extensions/user/'. $user->id) }}"><button type = "button" class = "interactButton">Extensions: {{ $extensions }}</button></a>
            </td>
        </tr>
        <tr>

        </tr>
        <tr>
            <th colspan="2">Inspires Others:</th>
        </tr>
        <tr>
         <td>
              <a href="{{ url('/users/elevatedBy/'. $user->id) }}"><button type = "button" class = "interactButton">Elevated: {{ $user->elevation }}</button></a>
            </td>
         <td>
             <a href="{{ url('/users/extendedBy/'. $user->id) }}"><button type = "button" class = "interactButton">Extended: {{ $user->extension }}</button></a>
         </td>
        </tr>
    </table>

@stop

@section('centerFooter')
    <div id = "centerFooter">

        @if(Auth::id() != $user->id)
            <a href="{{ url('/bookmarks/users/'.$user->id) }}"><button type = "button" class = "navButton">Bookmark</button></a>
        @endif
            @if(Auth::user()->type > 1)
                <a href="{{ url('users/'. $user->id . '/edit') }}"><button type = "button" class = "navButton">Edit</button></a>
                {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id]]) !!}
                {!! Form::submit('Delete User', ['class' => 'navButton', 'id' => 'delete']) !!}
                {!! Form::close() !!}

            @endif
    </div>
@stop

