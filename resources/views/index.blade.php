<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Form MCA</title>
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
  
  <div class="wrapper">
    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo" alt="MCA Montessori School Logo">
    
    <form action="{{ url('/login') }}" class="login-form" method="POST" id="loginForm">
      @csrf
      <h1>MCA MONTESSORI SCHOOL</h1>
      <div class="input-box">
        <input type="text" id = "username" name = "username"  placeholder ="Username" required autofocus>
        <i class='bx bxs-user'></i>
        <span class="input-feedback"></span>
      </div>
      <div class="input-box">
        <input type="password" id="password" name="password" placeholder="Password" required>
        <i class='bx bxs-lock-alt password-icon'></i>
        <i class='bx bx-hide toggle-password' id="togglePassword"></i>
        <span class="input-feedback"></span>
      </div> 
      <div class="remember-forgot">
        <a href="{{ route('password.request') }}" tabindex="0" aria-label="Reset your password">Forgot Username/Password</a>
      </div>
      <button type="submit" class="btn" id="loginButton">
        <span>Login</span>
        <div class="spinner" style="display: none;"></div>
      </button>
      <div class="divider">
        <hr>
      </div>
      <div class="action-buttons">
        <button type="button" class="enroll-btn" aria-label="Enroll Now"
          onclick="window.location.href='{{ route('enroll.select') }}'">
          Enroll Now
        </button>
        <button type="button" class="assessment-btn" aria-label="Take Assessment"
          onclick="window.location.href='{{ route('strand.assessment') }}'">
          Start Assessment
        </button>
      </div>
    </form>
    
    <div class="status-message error-message" role="alert" aria-live="assertive">
      @if (session('errors') && session('errors')->has('username'))
              <p class="error-message">{{ session('errors')->first('username') }}</p>
      @endif
    </div>

  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      
      const togglePassword = document.getElementById('togglePassword');
      const password = document.getElementById('password');
      
      togglePassword.addEventListener('click', function() {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('bx-hide');
        this.classList.toggle('bx-show');
      });

      
      const loginForm = document.getElementById('loginForm');
      const username = document.getElementById('username');
      const loginButton = document.getElementById('loginButton');
      const statusMessage = document.querySelector('.status-message');
      const spinner = document.querySelector('.spinner');
      
      
      const inputs = document.querySelectorAll('input[required]');
      inputs.forEach(input => {
        input.addEventListener('input', function() {
          const feedback = this.nextElementSibling.nextElementSibling;
          if (this.value.trim() === '') {
            this.classList.add('invalid');
            feedback.textContent = `${this.placeholder} is required`;
          } else {
            this.classList.remove('invalid');
            feedback.textContent = '';
          }
        });
      });
      
      
      loginForm.addEventListener('submit', function(e) {
        e.preventDefault();  // always prevent to control flow

        // Clear any previous status message
        statusMessage.textContent = '';
        statusMessage.classList.remove('success-message');
        statusMessage.classList.add('error-message');

        // Basic field validation
        let valid = true;
        inputs.forEach(input => {
          const feedback = input.nextElementSibling.nextElementSibling;
          if (input.value.trim() === '') {
            input.classList.add('invalid');
            feedback.textContent = `${input.placeholder} is required`;
            valid = false;
          } else {
            input.classList.remove('invalid');
            feedback.textContent = '';
          }
        });

        if (!valid) {
          // Don’t try to log in—just show the error
          statusMessage.textContent = 'Please fill in all required fields.';
          return;
        }

        // All fields are filled—show spinner then submit
        loginButton.querySelector('span').style.display = 'none';
        spinner.style.display = 'inline-block';
        loginButton.disabled = true;

        setTimeout(function() {
          loginForm.submit(); // actual form POST to your server
        }, 500);
      });

    });
  </script>
</body>
</html>