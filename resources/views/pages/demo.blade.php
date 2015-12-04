<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Idee /-\ @yield('siteTitle')</title>
    <link rel = "stylesheet" href = "/css/normalize.css">
    <link rel = "stylesheet" href = "{{ elixir('css/app.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="/js/app.js"></script>
    <!--
       This code is maintained by the Tre-Uniti development ops
       Feature & Pull Requests decided at Belle-Creatori.org
       Idee Repo: https://github.com/tre-uniti/belle-idee
    -->
</head>
<body>
<div id = "container">

    <nav class = "topNav">
        <ul>
            <li><a href={{ url('/home') }}>Home</a></li>
            <li>
                <a href="{{ url('/posts') }}">Posts<span class="caret"></span></a>
                <div>
                    <ul>
                        <li><a href={{ url('/posts/create') }}>Create</a></li>
                        <li><a href={{ url('/posts') }}>Discover</a></li>
                        <li><a href="{{ url('/indev') }}">Your Posts</a></li>
                        <li><a href="{{ url('/indev') }}">Extensions</a></li>
                        <li><a href="{{ url('/indev') }}">Bookmarks</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <a href="{{ url('/indev') }}">Directory<span class="caret"></span></a>
                <div>
                    <ul>
                        <li><a href="{{ url('/posts') }}">Beliefs</a></li>
                        <li><a href="{{ url('/posts') }}">Questions</a></li>
                        <li><a href="{{ url('/posts') }}">Beacons</a></li>
                        <li><a href="{{ url('/posts') }}">Sponsors</a></li>
                        <li><a href="{{ url('/posts') }}">Legacy Posts</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <a href="{{ url('/settings') }}">Settings<span class="caret"></span></a>
                <div>
                    <ul>
                        <li><a href="{{ url('/settings') }}">View/Change</a></li>
                        <li><a href="{{ url('/posts') }}">Support</a></li>
                        <li><a href="{{ url('/posts') }}">Your Sponsor</a></li>
                        <li><a href="{{ url('/invites') }}">Invite Friends</a></li>
                        <li><a href="https://tre-uniti.org">Tre-Uniti</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </nav>
    <!-- Left --- --- -->
    <div id = "leftContainer">
        <div id = "leftSide">

                <h2>Your Handle</h2>

                <div class = "innerPhotos">
                    <a href="/"><img src={{asset('img/backgroundLandscape.jpg')}} alt="idee" height = "97%" width = "85%"></a>
                </div>
            <nav class = "profileNav">
                <ul>
                        <li>
                            <a href="{{ url('/auth/register') }}">Posts</a>
                            <div>
                                <ul>
                                    <li><a href={{ url('/auth/register') }}>Dec-4-2015</a></li>
                                </ul>
                            </div>
                        </li>

                        <li>
                            <a href="{{ url('/auth/register') }}">Extends</a>
                            <div>
                                <ul>
                                        <li><a href={{ url('/auth/register') }}>Dec-7-2015</a></li>
                                </ul>
                            </div>
                        </li>

                </ul>
            </nav>
        </div>
    </div>
    <!-- --- Center --- -->
    <div id = "centerContent">
        <article>
            <div id = "centerMenu">
                <header>

                </header>
            </div>
            <div id = "centerText">
                    <h2>The Commencement</h2>
                <div>
                    <table style="display: inline-block;">
                        <tr>
                            <td><a href="{{ url('/auth/register') }}">Belief</a>
                            </td>
                        </tr>
                    </table>

                    <table style="display: inline-block;">
                        <tr><td><a href="{{ url('/auth/register') }}">Beacon Tag</a></td>
                        </tr>
                    </table>

                    <table style="display: inline-block;">
                        <tr><td><a href="{{ url('/auth/register') }}">Type</a></td>
                        </tr>
                    </table>
                </div>

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
            </div>
        </article>
        <div id = "centerFooter">

                    <a href="{{ url('/auth/register') }}"><button type = "button" class = "navButton">Register</button></a>
                    <a href="{{ url('/auth/register') }}"><button type = "button" class = "navButton">Nav Guide</button></a>

            </div>
        </div>
    </div>
    <!-- --- --- Right -->
    <div id = "rightContainer">
        <div id = "rightSide">
            <h2>Hosted</h2>

            <div class = "innerPhotos">
                <a href="/"><img src={{asset('img/idee.png')}} alt="idee" height = "97%" width = "85%"></a>
            </div>

            <nav class = "profileNav">
                <ul>
                        <li>
                            <a href="{{url('/posts')}}">Beacons</a>
                            <div>
                                <ul>
                                    <li><a href="{{url('/posts')}}">US-SW-ACE</a></li>
                                    <li><a href="{{url('/posts')}}">Atheism</a></li>
                                    <li><a href="{{url('/posts')}}">Ba Gua</a></li>
                                    <li><a href="{{url('/posts')}}">Buddhism</a></li>
                                    <li><a href="{{url('/posts')}}">Christianity</a></li>
                                    <li><a href="{{url('/posts')}}">Druze</a></li>

                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href={{ url('/auth/register') }}>Legacy</a>
                            <div>
                                <ul>

                                        <li><a href={{ url('/auth/register') }}>Legacy</a></li>

                                </ul>
                            </div>
                        </li>
                </ul>
            </nav>

        </div>
    </div>
</div>
</body>
</html>
