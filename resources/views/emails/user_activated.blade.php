<html>
<body>
    <h2>Your Account Has Been Activated</h2>
    <p>Hello {{ $user->name }},</p>
    <p>Your account is now active. You can log in and start using the platform.</p>
    <p>Email: {{ $user->email }}</p>
    <p>Thank you!</p>
</body>
</html>
