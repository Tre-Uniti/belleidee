@extends('app')
@section('siteTitle')
    Search Users
@stop


@section('centerText')
    <div>
        <h2>Search Users</h2>
        {!! Form::open(['url' => 'users/results', 'method' => 'GET']) !!}
        <table align = "center">
            <tr>
                <th>Title:</th>
            </tr>
            <tr>
                <td>{!! Form::text('title', null, ['class' => 'createTitleText', 'autofocus']) !!}</td>
            </tr>
            <tr>
                <td>{!! Form::submit('Search', ['class' => 'navButton']) !!}</td>
            </tr>
        </table>
        {!! Form:: close() !!}
    </div>
@stop
@section('centerFooter')
            <a href="{{ url('/users/') }}"><button type = "button" class = "navButton">Recent Users</button></a>
            <a href="{{ url('/search') }}"><button type = "button" class = "navButton">Global Search</button></a>
@stop


