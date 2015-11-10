@extends('app')
@section('siteTitle')
    Discover
@stop

@section('leftSideBar')
    <div id = "leftSide">
        <h2>{{Auth::user()->handle}}</h2>
        <div class = "innerProfileMenus">
            <a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Elevation: 0</button></a>
            <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Extension: 0</button></a>


            <p>This is your motto, it is customized by the user
                It can be your motto, or another motto you like.  What happens with a third line</p>
        </div>
        <hr/>
        <h2>Top Posts</h2>
        <div class = "innerProfileMenus">
            <ul>
                <li><a href="{{ url('/posts/create') }}"><button type = "button" class = "interactButton">Your most inspired post</button></a></li>
                <li><a href="{{ url('/posts/create') }}"><button type = "button" class = "interactButton">Your second most inspired post</button></a></li>
                <li><a href="{{ url('/posts/create') }}"><button type = "button" class = "interactButton">Your third post inspired post</button></a></li>
            </ul>
        </div>
        <hr/>
        <a href="/"><img src={{asset('img/idee.png')}} alt="idee" height = "55%" width = "55%"></a>
    </div>
@stop

@section('centerText')
    <h2>Discover New Posts</h2>
    <h4>Sort by:</h4>
    <section>
        @foreach ($posts as $post)
            <article>
                <table align = "center" cellpadding = "15">
                    <thead>
                    <tr>
                        <td colspan="2"><h4><a href="{{ action('PostController@show', [$post->id])}}"> {{ $post->title }}</a></h4></td colspan="2">
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Elevation: 100 300{{$post->elevation}}</button></a></td>
                        <td><a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Extension: 53{{$post->extension}}</button></a></td>
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

@section('rightSideBar')
    <div id = "rightSide">
        <h2>Inspired By:</h2>
        <div class = "innerProfileMenus">
            <ul>
                <li><a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Handle of user 1</button></a></li>
                <li><a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Handle of user 2</button></a></li>
                <li><a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Handle of user 3</button></a></li>
            </ul>
        </div>
        <hr/>
        <h2>Inspires:</h2>
        <div class = "innerProfileMenus">
            <ul>
                <li><a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Handle of user 4</button></a></li>
                <li><a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Handle of user 5</button></a></li>
                <li><a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Handle of user 6</button></a></li>
            </ul>
        </div>
        <hr/>
        <a href="/"><img src={{asset('img/idee.png')}} alt="idee" height = "55%" width = "55%"></a>
    </div>
@stop


