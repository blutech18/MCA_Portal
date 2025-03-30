<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Form MCA</title>
  <link rel="stylesheet" href="{{ asset('css/styles_login.css') }}">
</head>
<body>
  <div class = "bg-container">
    <div class="building">
      <img src="{{ asset('images/bglogin.jpg') }}" alt="Building" class="building-pic">
    </div>
    
    <div class="wrapper">
      <form action="{{ url('/login') }}" class="login-form" method="POST">
        @csrf
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
        <h1>MCA MONTESORRI SCHOOL</h1>
        <div class="user-type">
          <input type="radio" id="student" name="user-type" value="student" checked>
          <label for="student">Student</label>
          <input type="radio" id="faculty" name="user-type" value="faculty">
          <label for="faculty">Faculty</label>
        </div>
        <div class="input-box">
          <img src="{{ asset('images/email.png') }}" alt="email_picture" class="email">
          <input type="text" id = "email" name = "email"  placeholder ="Enter your email address" required>
        </div>
        <div class="input-box">
          <img src="{{ asset('images/lock.png') }}" alt="Lock" class="lock">
          <input type="password" id="password" name="password" placeholder="Enter your password" required>
        </div>
        <div class="remember-forgot">
          <label><input type="checkbox">Remember Me</label>
          <a href="#">Forgot Password</a>
        </div>
        <button type="submit" class="btn">LOGIN</button>
        <div class="divider">
          <hr>
        <div class="register-link">
          <p>New Here? <a href="{{ route('enrollment_form') }}">Click here to enroll</a></p>
        </div>
      </form>
      <p class="error-message">Invalid username or password. Please try again.</p>
    </div>
  </div>
  
  <script src="{{ asset('js/script.js') }}"></script>

</body>
</html>