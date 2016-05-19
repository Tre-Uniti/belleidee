@extends('app')
@section('siteTitle')
    Tutorials
@stop
@section('centerText')
    <h2>Idee Tutorials</h2>

    <h4>Introduction:</h4>
    <iframe width="560" height="315" src="https://www.youtube.com/embed/f7y4XaKV4pc" frameborder="0" allowfullscreen></iframe>
    <!--//How to create a draft and convert
    //How to extend a post and view extensions
    //How to elevate and view elevations (+rankings)
    //How to sort posts/extensions and your home
    //Platform support (mobile, tablet, computer)
    -->
    <h4>Drafts:</h4>
    <iframe width="560" height="315" src="https://www.youtube.com/embed/In8p0IJJNTU" frameborder="0" allowfullscreen></iframe>
    <!--Change user settings, types of users (user, mod, admin)
    //How to localize a post or extension to a beacon
    //Start a sponsorship, benefits of sponsorship
    //Bookmarking posts, extensions, users
    //How to do searching (local vs global)-->
    <!--//Community question and answers/extensions
    //Legacy extension and users
    //Intolerance reporting
    //Create and manage support tickets-->
    <h4>Interactions:</h4>
    <iframe width="560" height="315" src="https://www.youtube.com/embed/LutPtWPsTdA" frameborder="0" allowfullscreen></iframe>

@stop
@section('centerFooter')

        <a href="{{ url('/gettingStarted') }}"><button type = "button" class = "navButton">Getting Started</button></a>
@stop
