@extends('app')
@section('siteTitle')
    Home
@stop
@section('leftSideBar')
    <div id = "leftSide">
        <div class = "innerProfileMenus">
            <h2>Beliefs</h2>

            <a href="{{ url('/indev')}}"><button type = "button" class = "interactButton">Atheism</button></a>
            <a href="{{ url('/indev')}}"><button type = "button" class = "interactButton">Adaptia</button></a>
            <a href="{{ url('/indev')}}"><button type = "button" class = "interactButton">Ba Gua</button></a>
            <a href="{{ url('/indev')}}"><button type = "button" class = "interactButton">Buddhism</button></a>
            <a href="{{ url('/indev')}}"><button type = "button" class = "interactButton">Christianity</button></a>
            <a href="{{ url('/indev')}}"><button type = "button" class = "interactButton">Druze</button></a>
            <a href="{{ url('/indev')}}"><button type = "button" class = "interactButton">Hinduism</button></a>
            <a href="{{ url('/indev')}}"><button type = "button" class = "interactButton">Islam</button></a>
            <a href="{{ url('/indev')}}"><button type = "button" class = "interactButton">Judaism</button></a>
            <a href="{{ url('/indev')}}"><button type = "button" class = "interactButton">Native</button></a>
            <a href="{{ url('/indev')}}"><button type = "button" class = "interactButton">Taoism</button></a>
            <a href="{{ url('/indev')}}"><button type = "button" class = "interactButton">Urantia</button></a>
        </div>
        <hr/>
        <div class = "innerProfileMenus">
        <h2>Your Posts:</h2>
            <ul>
                <li><a href="{{ url('/posts/create') }}"><button type = "button" class = "interactButton">Your most inspired post</button></a></li>
                <li><a href="{{ url('/posts/create') }}"><button type = "button" class = "interactButton">Your second most inspired post</button></a></li>
                <li><a href="{{ url('/posts/create') }}"><button type = "button" class = "interactButton">Your third post inspired post</button></a></li>
                <li><a href="{{ url('/posts/create') }}"><button type = "button" class = "interactButton">Your third post inspired post</button></a></li>
                <li><a href="{{ url('/posts/create') }}"><button type = "button" class = "interactButton">Your third post inspired post</button></a></li>
                <li><a href="{{ url('/posts/create') }}"><button type = "button" class = "interactButton">Your third post inspired post</button></a></li>
            </ul>
        </div>
        <hr/>
        <div class = "innerPhotos">
        <a href="/"><img src={{asset('img/backgroundLandscape.jpg')}} alt="idee" height = "97%" width = "85%"></a>
        </div>
    </div>
    @stop
@section('centerText')
    <h1>Home of {{Auth::user()->handle}}</h1>
    <div class = "innerHomeMenus">
        <a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Elevation: 0</button></a>
        <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Extension: 0</button></a>
        <p>This is your motto, it is customized by the user
            It can be your motto, or another motto you like.  What happens with a third line</p>
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

@stop
@section('centerFooter')
@stop
@section('rightSideBar')
    <div id = "rightSide">
        <div class = "innerProfileMenus">
            <h2>Legacy Posts</h2>
            <ul>
                <li><a href="{{ url('/posts/create') }}"><button type = "button" class = "interactButton">Your most inspired post</button></a></li>
                <li><a href="{{ url('/posts/create') }}"><button type = "button" class = "interactButton">Your second most inspired post</button></a></li>
                <li><a href="{{ url('/posts/create') }}"><button type = "button" class = "interactButton">Your third post inspired post</button></a></li>
                <li><a href="{{ url('/posts/create') }}"><button type = "button" class = "interactButton">Your third post inspired post</button></a></li>
            </ul>
        </div>
        <hr/>
        <div class = "innerProfileMenus">
            <h2>Your Sponsor</h2>

         <table align = "center">
            <thead>
            <tr><th>Name</th>
                <th># Days</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            <tr><td>Belle-Idee</td>
                <td>1</td>
                <td>Active</td>
            </tr>
            <tr>
                <td colspan = 3" ><a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">View Sponsor</button></a>
                    <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Change Sponsor</button></a>
                </td>
            </tr>
            </tbody>
        </table>
        </div>
        <hr/>
        <div class = "innerPhotos">
            <a href="/"><img src={{asset('img/idee.png')}} alt="idee" height = "97%" width = "85%"></a>
        </div>
    </div>
@stop
