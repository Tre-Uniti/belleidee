@extends('app')
@section('siteTitle')
    Training
@stop
@section('centerText')
    <h2>Idee Training</h2>

    <h4>Starter:</h4>
    <iframe width="560" height="315" src="https://www.youtube.com/embed/jsHOJHLGruo" frameborder="0" allowfullscreen></iframe>
    <!--//How to create a draft and convert
    //How to extend a post and view extensions
    //How to elevate and view elevations (+rankings)
    //How to sort posts/extensions and your home
    //Platform support (mobile, tablet, computer)
    -->
    <h4>Intermediate:</h4>
    <!--Change user settings, types of users (user, mod, admin)
    //How to localize a post or extension to a beacon
    //Start a sponsorship, benefits of sponsorship
    //Bookmarking posts, extensions, users
    //How to do searching (local vs global)-->
    <h4>Advanced:</h4>
    <!--//Community question and answers/extensions
    //Legacy extension and users
    //Intolerance reporting
    //Create and manage support tickets-->
@stop
@section('centerFooter')
        <a href="{{ url('/workshops') }}"><button type = "button" class = "navButton">Workshops</button></a>
@stop
