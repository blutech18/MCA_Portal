<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Result</title>
    <link rel="stylesheet" href="{{ asset('css/styles_result.css') }}">
    <link href="https://fonts.cdnfonts.com/css/garet" rel="stylesheet">
</head>
<body>
    <div class="result-container {{ strtolower($strand) }}">
        <img src="{{ asset('images/logo.png') }}" alt="School Logo" class="logo">
    
        <h1 class="strand">{{ $strand }}</h1>
    
        <p class="description">
            {{ $descriptions[$strand] }}
        </p>

        <div class="btn-container">
            <a href="{{ route('enrollment_form') }}" class="btn go-back-btn">Go Enroll</a>
        </div>
    </div>
</body>
</html>
