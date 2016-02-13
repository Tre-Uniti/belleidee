@extends('app')
@section('siteTitle')
    Search Extensions
@stop


@section('centerText')
    <div>
        <h2>Search Results</h2>
        <table style="display: inline-block;">
            <tr>
                <td><a href={{ url('/extensions/')}}>Recent Extensions</a></td>
                <td><a href={{ url('/extensions/search')}}>Extension Search</a></td>
                <td><a href={{ url('/search')}}>Global Search</a></td>
            </tr>
        </table>
    </div>
        <div style = "width: 50%; float: left;">
            <h4>Title</h4>
        </div>
        <div style = "width: 50%; float: right;">
            <h4>User</h4>
        </div>
        @foreach ($results as $result)
            <div class = "listResource">
                <div class = "listResourceLeft">
                    <a href="{{ action('ExtensionController@show', [$result['id']])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{$result['title']}}</button></a>
                </div>
                <div class = "listResourceRight">
                    <a href="{{ action('UserController@show', [$result['user_id']])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{$result['handle']}}</button></a>
                </div>
            </div>
        @endforeach

@stop
@section('centerFooter')

@stop



