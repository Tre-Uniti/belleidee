@extends('app')
@section('siteTitle')
    Search Users
@stop

@section('centerText')
    <div>
        <h2>Search Results</h2>
        <table style="display: inline-block;">
            <tr>
                <td><a href={{ url('/users/')}}>Recent User</a></td>
                <td><a href={{ url('/users/search')}}>User Search</a></td>
                <td><a href={{ url('/search')}}>Global Search</a></td>
            </tr>
        </table>
    </div>
        <div style = "width: 50%; float: left;">
            <h4>Handle</h4>
        </div>
        <div style = "width: 50%; float: right;">
            <h4>Joined</h4>
        </div>
    @foreach ($results as $result)
        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('UserController@show', [$result->id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{$result->handle}}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('UserController@show', [$result->id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{$result->created_at->format('M-d-Y')}}</button></a>
            </div>
        </div>
    @endforeach

@stop
@section('centerFooter')
    {!! $results->appends(['title' => $handle])->render() !!}
@stop



