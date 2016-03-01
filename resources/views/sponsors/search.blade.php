@extends('app')
@section('siteTitle')
    Search Sponsors
@stop

@section('centerText')
    <div>
        <h2>Search Sponsors</h2>
        {!! Form::open(['url' => 'sponsors/results', 'method' => 'GET']) !!}
        <table align = "center">
            <tr>
                <td>{!! Form::select('type', $types) !!}</td>
            </tr>
            <tr>
                <td>{!! Form::text('identifier', null, ['class' => 'createTitleText', 'autofocus']) !!}</td>
            </tr>
            <tr>
                <td>{!! Form::submit('Search', ['class' => 'navButton']) !!}</td>
            </tr>
        </table>
        {!! Form:: close() !!}
    </div>
@stop
@section('centerFooter')
            <a href="{{ url('/sponsors/') }}"><button type = "button" class = "navButton">All Sponsors</button></a>
            <a href="{{ url('/search') }}"><button type = "button" class = "navButton">Global Search</button></a>
@stop


