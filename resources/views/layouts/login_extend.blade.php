
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
        <div class="reset-form">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
            <h1>MCA MONTESORRI SCHOOL</h1>
        </div>
        
        @yield('content')

    </div>
  </div>
  
  <script src="{{ asset('js/script.js') }}"></script>

</body>
</html>