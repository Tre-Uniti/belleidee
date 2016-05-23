@extends('app')
@section('siteTitle')
    Users
@stop

@section('centerText')
        <h2>Users who joined in {{ $filter }}</h2>
        <div class ="indexNav">
              <a href={{ url('/users/elevationTime/'. $time)}}><button type = "button" class = "indexButton">Elevated</button></a>
               <a href={{ url('/users/search')}}><button type = "button" class = "indexButton">Search</button></a>
              <a href={{ url('/users/extensionTime/'.$time)}}><button type = "button" class = "indexButton">Extended</button></a>

        <nav class = "infoNav">
            <ul>
                <li>
                    <a href = {{ url('/users') }}><button type = "button" class = "indexButton">Recent Users</button></a>
                </li>
            </ul>
        </nav>
    </div>

    <div class = "indexLeft">
        <h4>Handle</h4>
    </div>
    <div class = "indexRight">
        <h4>Joined</h4>
    </div>

    @foreach ($users as $User)
        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('UserController@show', [$User->id])}}"><button type = "button" class = "interactButton">{{ $User->handle }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('UserController@show', [$User->id])}}"><button type = "button" class = "interactButton">{{ $User->created_at->format('M-d-Y') }}</button></a>
            </div>
        </div>
    @endforeach

@stop

@section('centerFooter')
    {!! $users->render() !!}
@stop
