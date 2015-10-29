<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset = "UTF-8">
    <title>Please Verify Email</title>
</head>
<body>
<h3>Thank you for signing up!</h3>
<p>
    Please click on the link to sign-in: <a href='{{ url("auth/confirm/{$user->emailToken}") }}'>confirm your email address</a>
</p>
<p>We are honored to have you along for the journey and look forward to reading your beliefs and inspirations</p>
</body>
</html>