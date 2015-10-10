<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset=""UTF-8">
    <title>Idee /-\ Welcome!</title>
    <link rel = "stylesheet" href = "{{ elixir('css/app.css') }}">
    <!--
       This code is maintained by the Tre-Uniti development ops
       Requests and feedback are administered at Bella.ninja
       Idee Repo: https://github.com/tre-uniti/belle-idee
    -->
</head>
<body>
<div class = "welcome">
    <h1>Welcome to Belle Idee</h1>
    <h4><u>The home for anonymously sharing ideas, inspiration, and influence</u></h4>
    <div class = "login">
        <button type = "button" class = "button_connector" onclick = "window.location.href = 'nymiLogin.php'">Nymi</button>
        <button type = "button" class = "button_connector" onclick = "window.location.href = 'passwordLogin.php'">Password</button>
        <hr>
        <button type = "button" class = "button_elevate" onclick = "window.location.href = 'tour.php'">Take our Tour!</button>
        <button type = "button" class = "button_elevate" onclick = "window.location.href = 'home.php'">Hack our Clone!</button>
    </div>
    <!--Question of the Week:-->
    <h2>This week's question:</h2>
    <p><u>How are we influenced by our emotions, what purpose do they play?</u></p>
    <!--Question of the Week:-->
</div>
</body>
</html>