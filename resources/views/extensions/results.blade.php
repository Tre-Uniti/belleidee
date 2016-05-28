@extends('app')
@section('siteTitle')
    Search Extensions
@stop

@section('centerText')
        <h2>Search Results</h2>
        <div class = "indexNav">
            <a href={{ url('/extensions/')}}><button type = "button" class = "indexButton">Recent Extensions</button></a>
            <a href={{ url('/extensions/search')}}><button type = "button" class = "indexButton">Extension Search</button></a>
            <a href={{ url('/search')}}><button type = "button" class = "indexButton">Global Search</button></a>
        </div>
        <div class = "indexLeft">
            <h4>Title</h4>
        </div>
        <div class = "indexRight">
            <h4>User</h4>
        </div>
        @foreach ($results as $result)
            <div class = "listResource">
                <div class = "listResourceLeft">
                    <a href="{{ action('ExtensionController@show', [$result->id])}}"><button type = "button" class = "interactButtonLeft">{{$result->title}}</button></a>
                </div>
                <div class = "listResourceRight">
                    <a href="{{ action('UserController@show', [$result->user_id])}}"><button type = "button" class = "interactButton">{{$result->user->handle}}</button></a>
                </div>
            </div>
        @endforeach
@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $results->appends(['title' => $title])])
@stop



