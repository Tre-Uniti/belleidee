@extends('app')
@section('siteTitle')
    Global Search
@stop

@section('centerText')
    <div>
        <h2>Global Search</h2>
        {!! Form::open(['url' => '/results']) !!}
        <table align = "center">
            <tr>
                <th>
                    {!!  Form::label('type', 'Type:') !!}
                </th>
            </tr>
            <tr>
                <td>{!! Form::select('type', $types) !!}</td>
            </tr>
            <tr>
                <td>{!! Form::text('identifier', null, ['class' => 'createTitleText']) !!}</td>
            </tr>
            <tr>
                <td>{!! Form::submit('Search', ['class' => 'navButton']) !!}</td>
            </tr>
        </table>
        {!! Form:: close() !!}
    </div>
@stop
@section('centerFooter')

@stop


