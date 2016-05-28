@extends('app')
@section('siteTitle')
    User Extensions
@stop

@section('centerText')
    <h2>Extensions by <a href={{ url('/users/'. $user->id)}}>{{ $user->handle }}</a></h2>
        <div class = "indexNav">
            <a href={{ url('/extensions/user/elevated/'. $user->id)}}><button type = "button" class = "indexButton">Top Elevated</button></a>
            <a href={{ url('/users/'.$user->id)}}><button type = "button" class = "indexButton">Profile</button></a>
            <a href={{ url('extensions/user/elevated/'. $user->id)}}><button type = "button" class = "indexButton">Most Extended</button></a>
    </div>
    <div class = "indexLeft">
        <h4>Title</h4>
    </div>
    <div class = "indexRight">
        <h4>Date</h4>
    </div>

    @foreach ($extensions as $extension)

        <div class = "listResource">
        <div class = "listResourceLeft">
            <a href="{{ action('ExtensionController@show', [$extension->id])}}"><button type = "button" class = "interactButtonLeft">{{ $extension->title }}</button></a>
        </div>
        <div class = "listResourceRight">
            <a href="{{ action('PostController@listDates', [$extension->created_at->format('M-d-Y')])}}"><button type = "button" class = "interactButton">{{ $extension->created_at->format('M-d-Y') }}</button></a>
        </div>
        </div>
    @endforeach

@stop

@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $extensions])
@stop
