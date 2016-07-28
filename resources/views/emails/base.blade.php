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
            <table align="center" width="480px" style = "
                   border: 1px solid black;
                   border-radius: 7px;
                   -moz-border-radius: 7px;
                   padding: 3px;
                   background-color: #D8D8D8; ">
                <tr>
                    <td colspan="3" style="text-align:center">
                        <img src="https://belle-idee.org/img/ideeSocial.png" alt="idee" height="60%" width="50%">
                    </td>
                </tr>
                <tr>
                    @yield('emailContent')
                </tr>

                <tr>
                    <td colspan="3"><hr/></td>
                </tr>
                <tr>
                    <td>
                        <table align="center" style="text-align: center; border: 1px solid black;
                   border-radius: 7px;
                   -moz-border-radius: 7px;
                   padding: 3px;">
                            <tr><th>Tre-Uniti LLC</th></tr>
                            <tr><td>PO Box 888</td></tr>
                            <tr><td>Sedro-Woolley, WA</td></tr>
                            <tr><td>+1 (347) 897-5562</td></tr>
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
                            <tr><td>Change settings <a href ="http://belle-idee.org/frequency">here</a></td></tr>
                        </table>
                    </td>
                    <td>
                        <table align="center" style="text-align: center; border: 1px solid black;
                   border-radius: 7px;
                   -moz-border-radius: 7px;
                   padding: 3px;">
                            <tr><th>Message Type</th></tr>
                            @yield('messageType')
                        </table>
                    </td>
                </tr>
    </table>
    </td>
    </tr>
    </table>
</body>
</html>