@extends('app')
@section('siteTitle')
    User Extensions
@stop



@section('centerText')
    <div>
        <h2>Extensions by {{ $user->handle }}</h2>
        <table style="display: inline-block;">
            <tr>
                <td><a href={{ url('/extensions/sortByElevation')}}>Top Elevated</a></td>
                <td><a href={{ url('/indev')}}>Search</a></td>
                <td><a href={{ url('/extensions/sortByExtension')}}>Most Extended</a></td>
            </tr>
        </table>
    </div>
    <div style = "width: 50%; float: left;">
        <h4>Title</h4>
    </div>
    <div style = "width: 50%; float: right;">
        <h4>User</h4>
    </div>

    @foreach ($extensions as $extension)

        <div class = "listResource">
        <div class = "listResourceLeft">
            <a href="{{ action('ExtensionController@show', [$extension->id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{ $extension->title }}</button></a>
        </div>
        <div class = "listResourceRight">
            <a href="{{ action('PostController@listDates', [$extension->created_at->format('M-d-Y')])}}"><button type = "button" class = "interactButton">{{ $extension->created_at->format('M-d-Y') }}</button></a>
        </div>
        </div>
    @endforeach

@stop

@section('centerFooter')
    {!! $extensions->render() !!}
@stop

@include('extensions.rightSide')