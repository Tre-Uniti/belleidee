@extends('app')
@section('siteTitle')
    Home
@stop
@section('leftSideBar')
        <div>
            <h2>Beliefs</h2>
            {!! Form::open(['url' => 'posts']) !!}
            {!! Form::select('index', $categories) !!}
            {!! Form::close()   !!}
            <hr/>
            <div class = "innerProfileMenus">
                <h2>Posts</h2>
                <ul>
                @if ($profilePosts->isEmpty())
                    <li><a href="{{url('/extension/create')}}"> <button type = "button" class = "interactButton">Create a new Extension</button></a></li>
                @else
                    @foreach($profilePosts as $profilePost)
                        <li><a href="{{ action('PostController@show', [$profilePost->id])}}">
                                <button type = "button" class = "interactButton">{{ $profilePost->title }}</button></a>
                        </li>
                    @endforeach
                @endif
                </ul>
            </div>
<hr/>
        <div class = "innerPhotos">
        <a href="/"><img src={{asset('img/backgroundLandscape.jpg')}} alt="idee" height = "97%" width = "85%"></a>
        </div>
</div>
    @stop
@section('centerText')
    <h1>Home of {{$user->handle}}</h1>
    <div class = "innerHomeMenus">
        <a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Elevation: 0</button></a>
        <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Extension: 0</button></a>
        <p>{{$user->motto}}</p>
    </div>
    <h2>People who inspire you</h2>
    <div class = "innerHomeMenus">
        <a href="{{ url('/indev')}}"><button type = "button" class = "interactButton">None yet, extend another's post to be inspired</button></a>
    </div>
    <h2>People you inspire:</h2>
    <div class = "innerHomeMenus">
        <a href="{{ url('/indev')}}"><button type = "button" class = "interactButton">None yet, need someone to extend your post</button></a>
    </div>

    <h2>Question of the Week:</h2>
    <div class = "innerHomeMenus">
        <h4>What constitutes an inspiration?  Is it the only way to learn of something new?</h4>

        <a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Elevate: 0</button></a>
        <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Extend: 0</button></a>
    </div>
    <br/>
    <br/>

@stop
@section('centerFooter')
@stop
@section('rightSideBar')


            <h2>Legacy</h2>
            {!! Form::open(['url' => 'posts']) !!}
            {!! Form::select('index', $categories) !!}
            {!! Form::close()   !!}
            <hr/>
            <div class = "innerProfileMenus">
            <h2>Extensions</h2>
                <ul>
                @if ($profileExtensions->isEmpty())
                    <li><a href="{{url('/extension/create')}}"> <button type = "button" class = "interactButton">Create a new Extension</button></a></li>
                @else
                    @foreach($profileExtensions as $profileExtension)
                        <li><a href="{{ action('ExtensionController@show', [$profileExtension->id])}}">
                                <button type = "button" class = "interactButton">{{ $profileExtension->title }}</button></a>
                        </li>
                    @endforeach
                @endif
                </ul>
        </div>
            <hr/>

        <div class = "innerPhotos">
            <a href="/"><img src={{asset('img/idee.png')}} alt="idee" height = "97%" width = "85%"></a>
        </div>

@stop
