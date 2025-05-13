
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
    
    <div class="hero">
      <div class="building">
        <img src="{{ asset('images/bglogin.jpg') }}" alt="Building" class="building-pic">
        <div class="hero__panel panel--top">
          <h1>Welcome to MCA Montessori School Portal</h1>
          <p>Access grades, schedules, balances, and student records all in one place.</p>
        </div>
        <div class="hero__panel2 panel--middle">
          <h1>Enrollment Available Online</h1>
          <p>
            Register now and enjoy seamless access to all our resources.
            <a href="{{ route('enrollment_form') }}" class="btn btn--primary">Enroll Now</a>
          </p>
        </div>
        <div class="hero__panel3 panel--bottom">
          <h1>Take Strand Assessment</h1>
          <p>
            Not sure which strand suits you best?
            <a href="{{ route('strand.assessment') }}" class="btn btn--secondary">Start Assessment</a>
          </p>
        </div>
      </div>
      
    </div>
      
    
    <div class="wrapper">
      <!--<div class="close-button">
        <h1>&#10006;</h1>
      </div>-->
      <div class="form-container">
        <form action="{{ url('/login') }}" class="login-form" method="POST">
          @csrf
          <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
          <h1>MCA MONTESORRI SCHOOL</h1>
          <div class="login-title">
          </div>
          <div class="input-box">
            <!--<img src="{{ asset('images/email.png') }}" alt="email_picture" class="email">-->
            <input type="text" id = "username" name = "username"  placeholder ="Username" required>
          </div>
          <div class="input-box">
            <!--<img src="{{ asset('images/lock.png') }}" alt="Lock" class="lock">-->
            <input type="password" id="password" name="password" placeholder="Password" required>
          </div>
  
          @if (session('errors') && session('errors')->has('username'))
              <p class="error-message">{{ session('errors')->first('username') }}</p>
          @endif
  
          <div class="remember-forgot">
            <a href="{{ route('password.request') }}"><i>Forgot Password?</i></a>
          </div>
  
          <div class="login-title">
            <button type="submit" class="btn">Login</button>
          </div>
          
  
          <div class="divider">
            <hr>
            
        </form>
      </div>
    </div>
  </div>
  
  <script src="{{ asset('js/script.js') }}"></script>

</body>
</html>