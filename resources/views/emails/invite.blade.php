<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset = "UTF-8">
    <title>An Invitation</title>
</head>
<div style = "font-family: Verdana, Geneva, sans-serif;">
<h3>Invitation to Belle-Idee</h3>

<h4>Greetings! My name is Zoko and I welcome you to join our community!</h4>

<p>One of your friends has invited you to join Belle-Idee.
    A community of fellow beings who respectfully discuss their beliefs.</p>
<p>If you are interested you can join the beta by copying the beta code below and taking our tour</p>
<p>BetaToken: {{$invite->betaToken}}</p>
<a href="{{ url('/auth/tour') }}"><button type = "button" style = "padding: 8px 13px;
  font-family: 'Comic Sans MS', cursive, sans-serif;
    font-size: 100%;
    border-radius: 4px;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    border: 1px solid #003300;
    text-shadow: 3px 3px 10px #000000;
    color: #FFFFFF;
    background: linear-gradient(#7dff23, #188BC0);"
    >Tour</button></a>
</div>