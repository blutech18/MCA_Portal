<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
</head>
<body>
    <h2>Forgot Your Password?</h2>
    
    @if (session('status'))
        <p style="color: green;">{{ session('status') }}</p>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <label for="email">Enter your email:</label><br>
        <input type="email" name="email" id="email" required><br>

        @error('email')
            <p style="color: red;">{{ $message }}</p>
        @enderror

        <button type="submit">Send Password Reset Link</button>
    </form>
</body>
</html>
