@extends('app')
@section('siteTitle')
    Drafts
@stop

@section('centerText')
    <div>
    <h2>Recent Drafts</h2>
    <table style="display: inline-block;">
        <tr>
            <td><a href={{ url('/indev')}}></a>Sort by Oldest</td>
            <td><a href={{ url('/indev')}}>Search</a></td>
            <td><a href={{ url('/drafts/create')}}>Create Draft</a></td>
        </tr>
    </table>
    </div>
    <div style = "width: 50%; float: left;">
        <h4>Title</h4>
    </div>
    <div style = "width: 50%; float: right;">
        <h4>Date</h4>
    </div>
    @foreach ($drafts as $draft)
        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('DraftController@show', [$draft->id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{ $draft->title }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('DraftController@show', [$draft->id])}}"><button type = "button" class = "interactButton">{{ $draft->created_at->format('M-d-Y')}}</button></a>
            </div>
        </div>
    @endforeach


@stop
@section('centerFooter')
    {!! $drafts->render() !!}
@stop

@include('posts.rightSide')


