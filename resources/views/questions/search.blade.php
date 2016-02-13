@extends('app')
@section('siteTitle')
    Search Questions
@stop


@section('centerText')
    <div>
        <h2>Search Questions</h2>
        {!! Form::open(['url' => 'questions/results']) !!}
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
            <a href="{{ url('/questions/') }}"><button type = "button" class = "navButton">Recent Questions</button></a>
            <a href="{{ url('/search') }}"><button type = "button" class = "navButton">Global Search</button></a>
@stop


