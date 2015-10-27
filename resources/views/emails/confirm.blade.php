<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset = "UTF-8">
    <title>Please Verify Email</title>
</head>
<body>
<h2>Thanks for signing up!</h2>
<p>
    Please click on the link to sign-in: <a href='{{ url("auth/confirm/{$user->emailToken}") }}'>confirm your email address</a>
</p>
</body>
</html>