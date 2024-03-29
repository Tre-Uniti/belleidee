<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Idee - Demo</title>
    <link rel = "stylesheet" href = "/css/normalize.css">
    <link rel = "stylesheet" href = "{{ elixir('css/app.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="/js/app.js"></script>
    <script src="/js/index.js"></script>
    <!--
       This code is maintained by the Tre-Uniti development ops
       Feature & Pull Requests decided at Belle-Creatori.org
       Idee Repo: https://github.com/tre-uniti/belle-idee
    -->
</head>
<body>
<div id = "container">
    <div id="fb-root"></div>
    <nav class = "topNav">
        <ul>
            <li><a href={{ url('/demo') }}>Home</a></li>
            <li>
                <p onclick="" class = "nav">Posts<span class="caret"></span></p>
                <div>
                    <ul>
                        <li><a href={{ url('/demo') }}>Create</a></li>
                        <li><a href={{ url('/demo') }}>Discover</a></li>
                        <li><a href="{{ url('/demo') }}">Drafts</a></li>
                        <li><a href="{{ url('/demo') }}">Extensions</a></li>
                        <li><a href="{{ url('/demo') }}">Questions</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <p onclick="" class = "nav">Directory<span class="caret"></span></p>
                <div>
                    <ul>
                        <li><a href="{{ url('/demo') }}">Users</a></li>
                        <li><a href="{{ url('/demo') }}">Beacons</a></li>
                        <li><a href="{{ url('/demo') }}">Beliefs</a></li>
                        <li><a href="{{ url('/demo') }}">Legacy</a></li>
                        <li><a href="{{ url('/demo') }}">Sponsors</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <p onclick="" class = "nav">Settings<span class="caret"></span></p>
                <div>
                    <ul>
                        <li><a href="{{ url('/demo') }}">Personal</a></li>
                        <li><a href="{{ url('/demo') }}">Support</a></li>
                        <li><a href="{{ url('/demo') }}">Invite Friends</a></li>
                        <li><a href="{{ url('/demo') }}">Logout</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </nav>
    <!-- Left --- --- -->
    <div id = "leftContainer">
        <div id = "leftSide">

                <h2>Handle (Username)</h2>

                <div class = "innerPhotos">
                    <a href="/demo"><img src={{asset('img/backgroundLandscape.jpg')}} alt="idee" height = "97%" width = "85%"></a>
                </div>
            <nav class = "profileNav">
                <ul>
                        <li>
                            <a href="{{ url('/demo') }}">Posts</a>
                            <div>
                                <ul>
                                    <li><a href={{ url('/demo') }}>Dec-4-2015</a></li>
                                </ul>
                            </div>
                        </li>

                        <li>
                            <a href="{{ url('/demo') }}">Extends</a>
                            <div>
                                <ul>
                                    <li><a href={{ url('/demo') }}>Jan-5-2016</a></li>
                                    <li><a href={{ url('/demo') }}>Dec-7-2015</a></li>
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
            <h2>Demo View</h2>
            <div id = "centerText">

                <div class = "indexNav">
                    <a href="{{ url('/demo') }}"><button type = "button" class = "indexButton">Belief</button></a>
                    <a href="{{ url('/demo') }}"><button type = "button" class = "indexButton">Beacon Tag</button></a>
                    <a href="{{ url('/demo') }}"><button type = "button" class = "indexButton">Source</button></a>
                </div>
                <button class = "interactButton" id = "hiddenIndex">More</button>
                <div class = "indexContent" id = "hiddenContent">
                    <button type = "button" class = "indexButton">Elevations</button>
                    <button type = "button" class = "indexButton">Creation Date</button>
                    <button type = "button" class = "indexButton">Extensions</button>
                    <div class = "indexNav">
                        <button type = "button" class = "indexButton">Report Intolerance</button>
                        <button type = "button" class = "indexButton">Location</button>
                    </div>
                    <div class = "indexNav">
                        <a href="http://www.facebook.com/share.php?u={{Request::url()}}&title=Belle Idee Demo" target="_blank">
                            <img src="{{ asset('img/facebook.png') }}" alt="Share on Facebook"/></a>
                        <a href="https://plus.google.com/share?url={{Request::url()}}" target="_blank">
                            <img src="{{ asset('img/gplus.png') }}" alt="Share on Google+"/></a>
                        <a href="http://twitter.com/intent/tweet?status=Belle Idee Demo - {{Request::url()}}" target="_blank">
                            <img src="{{ asset('img/twitter.png') }}" alt="Share on Twitter"/></a>
                    </div>
                </div>
                <div id = "centerTextContent">
                    <p>
                        Welcome to Belle-Idee, this is a demo view of posts and extensions.
                    </p>
                    <p>
                        Left side: Links to user activity including their profile picture and most recent posts and extensions.
                        <br/>
                        Center: Contains the main text content posted by the user
                        <br/>
                        Right side: Links to the user's beacon or sponsor picture and recently used beacon tags and legacy extensions.
                    </p>
                    <p>
                        These terms and features are more fully explained in the tutorials and posts of the Tre-Uniti user.
                    </p>
                </div>

                </div>
        </article>
        <div id = "centerFooter">
            <a href="{{ url('/auth/register') }}"><button type = "button" class = "navButton">Register</button></a>
            <a href="{{ url('/tour') }}"><button type = "button" class = "navButton">Tour</button></a>
        </div>
    </div>

    <!-- --- --- Right -->
    <div id = "rightContainer">
        <div id = "rightSide">
            <h2>Beacon or Sponsor</h2>

            <div class = "innerPhotos">
                <a href="/demo"><img src={{asset('img/background3.jpg')}} alt="idee" height = "97%" width = "85%"></a>
            </div>

            <nav class = "profileNav">
                <ul>
                    <li>
                        <a href="{{url('/demo')}}">Beacons</a>
                        <div>
                            <ul>
                                <li><a href="{{url('/demo')}}">US-SW-ACE</a></li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href={{ url('/demo') }}>Legacy</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
</body>
</html>
