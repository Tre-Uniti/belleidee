@extends('app')
@section('siteTitle')
    Show Support Case
@stop

@section('centerText')
    <h2>{{ $support->subject }}</h2>
    <p>(This {{ $support->type }} ticket is {{ $support->status }})</p>
    <div id = "centerTextContent">
        <p>
            {{ $support->request }}
        </p>
    </div>
@stop

@section('centerFooter')
    <a href="{{ url('supports/') }}"><button type = "button" class = "navButton">Other Requests</button></a>
    <a href="{{ url('supports/'. $support->id . '/edit') }}"><button type = "button" class = "navButton">Edit</button></a>
    @if($user->type > 1)
        {!! Form::open(['method' => 'DELETE', 'route' => ['supports.destroy', $support->id], 'class' => 'formBlock']) !!}
        {!! Form::submit('Delete', ['class' => 'redButton', 'id' => 'delete']) !!}
        {!! Form::close() !!}
    @endif
@stop


