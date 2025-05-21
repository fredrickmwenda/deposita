<html>
<body>
    <h2>Welcome to the Platform!</h2>
    <p>Hello {{ $user->name }},</p>
    <p>Your account has been registered. Please wait for your station administrator to activate your account if you are a client user.</p>
    <p>If you are a station admin, you can now log in and manage your users.</p>
    <p>Email: {{ $user->email }}</p>
    @if(isset($user->plain_password))
    <p>Password: {{ $user->plain_password }}</p>
    @endif
    <p>Thank you!</p>
</body>
</html>
