<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset = "UTF-8">
    <title>Please Verify Email</title>
</head>
<body>
<h3>Thank you for signing up!</h3>
<p>
    Please click on the link to sign-in:<a href="{{ url("auth/confirm/{$user->emailToken}") }}"><button type = "button" style = "padding: 8px 13px;
    font-family: 'Comic Sans MS', cursive, sans-serif;
    font-size: 100%;
    border-radius: 4px;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    border: 1px solid #003300;
    text-shadow: 3px 3px 10px #000000;
    color: #FFFFFF;
    background: linear-gradient(#7dff23, #188BC0);"
                >Register</button></a>
</p>
<p>We are honored to have you along for the journey and look forward to reading your beliefs and inspirations</p>
</body>
</html>