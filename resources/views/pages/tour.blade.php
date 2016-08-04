<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="canonical" href="https://belle-idee.org/">
    <meta name="title" content="Belle Idee">
    <meta name="description" content="Belle Idee - A place to share ideas, inspirations and influences.">
    <title>Belle Idee Tour</title>
    <link rel = "stylesheet" href = "{{ elixir('css/app.css') }}">
    <!--
       This code is maintained by the Tre-Uniti development ops
       Feature & Pull Requests decided at Belle-Creatori.org
       Idee Repo: https://github.com/tre-uniti/belle-idee
    -->
    <script src="/js/googleAnalytics.js"></script>
</head>
<body>
<div id = "welcome">
    <a href="/"><img src={{secure_asset('img/idee.png')}} alt="idee" height = "35%" width = "35%"></a>
    <div id = "tour">
        <p>
            <a href="/img/tour.png" target="_blank"><img id = "tourImage" src = "/img/tour.png" alt="tour" width="100%" height="100%"></a>
        </p>
    </div>
    <a href="{{ url('/auth/register') }}"><button type = "button" class = "navButton">Register</button></a>
    <a href="{{ url('/demo') }}"><button type = "button" class = "navButton">View Demo Page</button></a>
    <hr/>
        <a href="https://duckduckgo.com/"><button type = "button" class = "interactButton">Not Interested</button></a>
</div>
</body>
</html>
