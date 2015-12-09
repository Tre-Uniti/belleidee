@extends('app')
@section('siteTitle')
    Extensions
@stop

@include('extensions.leftSide')

@section('centerText')
    <h2>Extension of {{ $sources['post_title'] }}</h2>
    <div style = "width: 50%; float: left;">
        <select>
            <option>Top Elevated</option>
            <option>Top Extended</option>
            <option>With Beacon</option>
            <option>Legacy Posts</option>
        </select>
    </div>

    <div style = "width: 50%; float: right;">
        <select>
            <option>Today</option>
            <option>Week</option>
            <option>Month</option>
            <option>2015</option>
        </select>
    </div>

    @foreach ($extensions as $extension)

        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('ExtensionController@show', [$extension->id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{ $extension->title }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('ExtensionController@show', [$extension->id])}}"><button type = "button" class = "interactButton">{{ $extension->created_at->format('M-d-Y') }}</button></a>
            </div>
        </div>
    @endforeach

@stop

@section('centerFooter')
    {!! $extensions->render() !!}
@stop

@include('extensions.rightSide')