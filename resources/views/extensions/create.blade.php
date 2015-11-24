@extends('app')
@section('siteTitle')
    Create
@stop

@include('extensions.leftSide')

@section('centerText')
    <h2>Create Extension</h2>
    <div class="errors">
    @include ('errors.list')
    </div>
    @foreach($sources as $source)
        <ul>
        <li>{{$source  }}</li>
        </ul>
        @endforeach

    {!! Form::open(['url' => 'extensions']) !!}
    @include ('extensions._form', ['submitButtonText' => 'Post Extension'])
    {!! Form::close()   !!}

@stop

@section('centerFooter')
    <div id = "centerFooter">
        <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Save as draft</button></a>
        <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Add Sources</button></a>
    </div>
@stop

@include('posts.rightSide')


