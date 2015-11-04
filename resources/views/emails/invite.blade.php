<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset = "UTF-8">
    <title>An Invitation to Belle-Idee</title>
</head>
<body>
<table align = "center" width="100%">
    <tr>
        <td>
            <table align="center" width="50%">
                <tr>
                    <td colspan="3"><img src="http://belle-idee.org/img/idee.png" alt="idee" height = "35%" width = "35%"></td>
                </tr>
                <tr>
                    <td colspan="3"><h3>Invitation to Belle-Idee</h3></td>
                </tr>
                <tr>
                    <td colspan="3"><h4>Greetings! My name is Zoko and I welcome you to join our community!</h4></td>
                    <td colspan="3"><p>One of your friends has invited you to join Belle-Idee.
                            A community of fellow beings who respectfully discuss their beliefs.</p></td>
                </tr>
                <tr>
                    <td><p>If you are interested you can join the beta by copying the beta code here:</p></td>
                    <td><p> {{$invite->betaToken}}</p></td>
                    <td>
                    <a href="{{ url('/auth/tour') }}"><button type = "button" style = "padding: 8px 13px;
    font-family: 'Comic Sans MS', cursive, sans-serif;
    font-size: 100%;
    border-radius: 4px;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    border: 1px solid #003300;
    text-shadow: 3px 3px 10px #000000;
    color: #FFFFFF;
    background: linear-gradient(#7dff23, #188BC0);">Check us out!</button></a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>