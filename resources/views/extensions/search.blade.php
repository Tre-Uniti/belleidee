@extends('app')
@section('siteTitle')
    Search Extensions
@stop

@section('centerText')
    <div>
        <h2>Search Extensions</h2>
        {!! Form::open(['url' => 'extensions/results']) !!}
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
            <a href="{{ url('/extensions/') }}"><button type = "button" class = "navButton">Recent Extensions</button></a>
            <a href="{{ url('/search') }}"><button type = "button" class = "navButton">Global Search</button></a>
@stop


