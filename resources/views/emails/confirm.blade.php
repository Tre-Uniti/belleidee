<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset = "UTF-8">
    <title>Please Verify Email</title>
</head>
<body>
<h1>Thanks for signing up!</h1>
<p>
    <a href='{{ url("auth/confirm/{$user->emailToken}") }}'>confirm your email address</a>
</p>
</body>
</html>