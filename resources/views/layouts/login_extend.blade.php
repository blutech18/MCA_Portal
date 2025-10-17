
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Form MCA</title>
  <link rel="stylesheet" href="{{ secure_asset('css/styles_login.css') }}?v={{ time() }}">
</head>
<body>
  <div class = "bg-container">
    <div class="building">
      <img src="{{ secure_asset('images/bglogin.jpg') }}?v={{ time() }}" alt="Building" class="building-pic">
    </div>
    
    <div class="wrapper">
        <div class="reset-form">
            <img src="{{ secure_asset('images/logo.png') }}?v={{ time() }}" alt="Logo" class="logo">
            <h1>MCA MONTESORRI SCHOOL</h1>
        </div>
        
        @yield('content')

    </div>
  </div>
  
  <script src="{{ secure_asset('js/script.js') }}?v={{ time() }}"></script>

</body>
</html>