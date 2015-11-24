@extends('app')
@section('siteTitle')
    Discover
@stop

@include('posts.leftSide')

@section('centerText')
    <h2>Discover New Posts</h2>
    <h4>Sort by:</h4>
    <section>
        @foreach ($posts as $post)
            <article>
                <table align = "center" cellpadding = "15">
                    <thead>
                    <tr>
                        <td colspan="2"><h4><a href="{{ action('PostController@show', [$post->id])}}"> {{ $post->title }}</a></h4></td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Elevation: 100 300{{$post->elevation}}</button></a></td>
                        <td><a href="{{ url('/extensions') }}"><button type = "button" class = "navButton">Extension: 53{{$post->extension}}</button></a></td>
                    </tr>
                    </tbody>
                </table>
            </article>
            <br/>
        @endforeach

    </section>

@stop
@section('centerFooter')

@stop

@include('posts.rightSide')


