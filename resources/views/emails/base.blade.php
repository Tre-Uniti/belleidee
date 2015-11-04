<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset = "UTF-8">
    <title>Please Verify Email</title>
</head>
<body>
<table align = "center" width="100%" style = "text-align: center;">
    <tr>
        <td colspan="3">
            <table align="center" width="480px" style = "border: 1px solid black;
                   border-radius: 7px;
                   -moz-border-radius: 7px;
                   padding: 3px;">
                <tr>
                    <td colspan="3">
                        <img src="http://belle-idee.org/img/idee.png" alt="idee">
                    </td>
                </tr>

                @yield('emailContent')
                <tr>
                    <td>
                        <table align="center" style="text-align: center; border: 1px solid black;
                   border-radius: 7px;
                   -moz-border-radius: 7px;
                   padding: 3px;">
                            <tr><th>Tre-Uniti LLC</th></tr>
                            <tr><td>PO Box 888</td></tr>
                            <tr><td>Sedro-Woolley, Wa</td></tr>
                            <tr><td>360-333-8783</td></tr>
                        </table>
                    </td>
                    <td>
                        <table align="center" style="text-align: center; border: 1px solid black;
                   border-radius: 7px;
                   -moz-border-radius: 7px;
                   padding: 3px;">
                            <tr><th>Email Opt Out</th></tr>
                            <tr><td>Reply to this email</td></tr>
                            <tr><td>Or</td></tr>
                            <tr><td>Change your email settings<a href ="http://belle-idee.org/settings">here</a></td></tr>
                        </table>
                    </td>
                    <td>
                        <table align="center" style="text-align: center; border: 1px solid black;
                   border-radius: 7px;
                   -moz-border-radius: 7px;
                   padding: 3px;">
                            <tr><th>Message Type</th></tr>
                            <tr><td>This is a System Message</td></tr>
                            <tr><td>In reference to:</td></tr>
                            <tr><td>@yield('messageType')</td></tr>
                        </table>
                    </td>
                </tr>
    </table>
    </td>
    </tr>
    </table>
</body>
</html>