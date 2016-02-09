@extends('app')
@section('siteTitle')
    Home
@stop

@section('centerText')
    <h2>Home of {{$user->handle}}</h2>
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
        <tr>
            <th colspan="2">Community Question:</th>
        </tr>
        <tr>
            <td colspan="2"><a href = {{ url('questions/'. $question->id)}}><button type = "button" class = "interactButton">{{ $question->question }}</button></a></td>
        </tr>
    </table>
@stop

@section('centerFooter')
    <a href="{{ url('/bookmarks/personal') }}"><button type = "button" class = "navButton">Bookmarks</button></a>
        <a href="{{ url('/auth/logout') }}"><button type = "button" class = "navButton">Logout</button></a>
@stop

@section('rightSideBar')
    <h2>Hosted</h2>

    <div class = "innerPhotos">
        <a href="/"><img src={{asset('img/idee.png')}} alt="idee" height = "97%" width = "85%"></a>
    </div>
@stop
