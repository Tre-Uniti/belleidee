<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
                width: 100%;
                max-width: 1920px; /* YOUR BG MAX SIZE */
                background:url("{{asset('logo/background1.jpg')}}") no-repeat;
                background-size: 100%;
            }
            .welcomeMain
            {
                width: 50%;
                height: auto;
                margin: 0 auto;
                background-color: white;
                display: inline-block;
                opacity:0.87;
                filter:alpha(opacity=87); /* For IE8 and earlier */
                border: 2px solid;
                border-radius: 25px;
                font-size: 100%;
                font-family: "Arial Black", Gadget, sans-serif;
                margin-top: 9.3%;
            }
            .login
            {
                width: 50%;
                height: auto;
                margin: 0 auto;
                background-color: black;
                display: inline-block;
                opacity:0.87;
                filter:alpha(opacity=87); /* For IE8 and earlier */
                border: 2px solid;
                border-radius: 25px;
                font-family: "Arial Black", Gadget, sans-serif;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="welcomeMain">


                <a href="http://belle-idee.dev"><img src={{asset('logo/idee.png')}} alt="idee" height = "200px" width = "200px"></a>
                    <br/>
                    <div class = "login">
                        <h3 style = "color: white;">Login Options:</h3>
                        <button type = "button" class = "button_connector" onclick = "window.location.href = 'nymiLogin.php'">Nymi</button>
                        <button type = "button" class = "button_connector" onclick = "window.location.href = 'passwordLogin.php'">Password</button>
                        <hr>
                        <h3 style = "color: white;">New members:</h3>
                        <button type = "button" class = "button_elevate" onclick = "window.location.href = 'tour.php'">Take our Tour!</button>
                        <button type = "button" class = "button_elevate" onclick = "window.location.href = 'home.php'">Hack our Clone!</button>
                    </div>
                    <br/>
                    <br/>
                    <!--Question of the Week:-->
                    <h2>This week's question:</h2>
                    <p><u>How are we influenced by our emotions, what purpose do they play?</u></p>
                    <!--Question of the Week:-->
                    <br/>
                </div>
            </div>
    </body>
</html>
