@extends('app')
@section('siteTitle')
    Demo
@stop

@section('leftSideBar')
    <div id = "leftSide">
        <h2>Your Handle</h2>
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
        <div class = "innerPhotos">
            <a href="/"><img src={{asset('img/background1.jpg')}} alt="idee" height = "93%" width = "90%"></a>
        </div>
    </div>
@stop

@section('centerText')
    <h1>A Demo Post</h1>
    <article>
        <table align = "center" cellpadding = "15">
            <thead>
            <tr><th>Indexer</th>
                <th>Beacon</th>
                <th>Indexer</th>
            </tr>
            </thead>
            <tbody>
            <tr><td>Adaptia</td>
                <td>Idee</td>
                <td>Greeting</td>
            </tr>
            <tr><td><button type = "button" class = "navButton">Sources </button></td>
                <td>                    <button type = "button" class = "interactButton">Elevate: 100 300</button></td>
                <td>                    <button type = "button" class = "navButton">Extend: 53</button></td>
            </tr>
            </tbody>
        </table>
        <div id = "centerTextContent">
        <p>From the moment we are born we are gifted with the ability to interact with each other.
            Our interactions ultimately determine our relationships or lack thereof. When our interactions are in service of others we elevate not only one person but also those around them.
            However, when our actions are to the detriment of a brother or sister we force them down and make their struggle more difficult.
            Many cultures throughout history have discovered when we work together we can achieve great things.
            When we fight each other we create barriers for new ideas and inspiration to truly manifest their true potential.
            For an idea or inspiration to reach its true potential it must be freely given of the person and joyfully extended by others.
        </p>
        <p>
            One may believe these gifts of spiritual insight and new thought are from a Creator being while others argue the source is within us.
            Regardless of the source, we cannot argue their beauty and unique capability to bring joy and understanding to our lives.
            The amazing moment where a person decides to share their gifts they in a sense set them free.
            They allow these gifts to be enjoyed by others and further explained and discerned through their extension.
        </p>
        <p>
            As we ponder our current society, are we working together as a world community or fighting for supremacy and control?
            Are we using the gifts and resources given to us for the benefit and enjoyment of a select few or for the majority?
            Are we promoting those emotions that elevate others or are we furthering the animistic tendencies inherent in humans?
            Such questions are open to extension.
        </p>
            <p>While I, Zoko may be the first user of this application I am certainly not the wisest nor most qualified to be posting. I am currently one small light attempting to shine in a world of darkness.
            Such an endeavor has been taken in hopes that other lights will join and together our radiant glow may become a beacon for others to see.
        </p>
        </div>
    </article>
@stop
@section('centerFooter')
    <div id = "centerFooter">
    <a href="https://duckduckgo.com/"><button type = "button" class = "interactButton">Not Interested</button></a>
    <a href="{{ url('/auth/register') }}"><button type = "button" class = "navButton">I'd like to join!</button></a>
    </div>
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
        <div class = "innerPhotos">
            <a href="/"><img src={{asset('img/idee.png')}} alt="idee" height = "95%" width = "80%"></a>
        </div>
    </div>
@stop
