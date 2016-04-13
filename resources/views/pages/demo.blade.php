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
    <script src="/js/social.js"></script>

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
                <p onclick="" style = "cursor:pointer">Posts<span class="caret"></span></p>
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
                <p onclick="" style = "cursor:pointer">Directory<span class="caret"></span></p>
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
                <p onclick="" style = "cursor:pointer">Settings<span class="caret"></span></p>
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

                <div>
                    <table style="display: inline-block;">
                        <tr>
                            <td><a href="{{ url('/demo') }}">Belief</a>
                            </td>
                        </tr>
                    </table>

                    <table style="display: inline-block;">
                        <tr><td><a href="{{ url('/demo') }}">Beacon Tag</a></td>
                        </tr>
                    </table>

                    <table style="display: inline-block;">
                        <tr><td><a href="{{ url('/demo') }}">Source</a></td>
                        </tr>
                    </table>
                </div>

                <div id = "centerTextContent">
                    <nav class = "infoNav">
                        <ul>
                            <li>
                                <p class = "extras">/-\</p>
                                <div>
                                    <table align = "center">
                                        <tr>
                                            <td><a href={{ url('/demo')}}>Elevations</a></td>
                                            <td> <a href = {{ url('/demo') }}>Creation Date</a></td>
                                            <td><a href={{ url('/demo')}}>Extensions</a></td>
                                        </tr>
                                        <tr>
                                            <td><!-- Your Facebook share button code -->
                                                <a href="http://www.facebook.com/share.php?u={{Request::url()}}&title=Demo"
                                                   onclick="return shareSocial(this.href);">
                                                    <img src="{{ asset('img/facebook.png') }}" alt="Share on Facebook"/></a>
                                            </td>
                                            <td>
                                                <!-- G+ share button code -->
                                                <a href="https://plus.google.com/share?url={{Request::url()}}"
                                                   onclick="return shareSocial(this.href);">
                                                    <img src="{{ asset('img/gplus.png') }}" alt="Share on Google+"/></a>
                                            </td>
                                            <td><!-- Twitter share button code -->
                                                <a href="http://twitter.com/intent/tweet?status= - {{Request::url()}}"
                                                   onclick="return shareSocial(this.href)">
                                                    <img src="{{ asset('img/twitter.png') }}" alt="Share on Twitter"/></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"><a href="{{ url('/demo') }}">Report Intolerance</a></td>
                                        </tr>
                                    </table>

                                </div>
                            </li>
                        </ul>
                    </nav>
                    <p>
                        Welcome to Belle-Idee!
                    </p>
                    <p>
                        This is a demo view of what posts and extensions look like within Idee.
                        <br/>
                        <br/>
                        Left side: Links to user activity including their profile picture and most recent posts and extensions.
                        <br/>
                        Center: Contains the main text content posted by the user
                        <br/>
                        Right side: Links to the user's sponsor as well as recently used beacon tags and legacy extensions.
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
            <h2>Hosted</h2>

            <div class = "innerPhotos">
                <a href="/demo"><img src={{asset('img/idee.png')}} alt="idee" height = "97%" width = "85%"></a>
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
                            <div>
                                <ul>
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
