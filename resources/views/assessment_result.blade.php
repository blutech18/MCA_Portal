<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Result</title>
    <link rel="stylesheet" href="css/styles_result.css">
    <link href="https://fonts.cdnfonts.com/css/garet" rel="stylesheet">
                
</head>
<body>

    <div class="result-container abm">
        <img src="{{ asset('images/logo.png') }}" alt="School Logo" class="logo">
        
        <h1 class="strand">ABM</h1>
        
        <p class="description">
            The Accountancy, Business, and Management (ABM) 
            Strand is perfect for those who aspire to be entrepreneurs, business leaders, 
            or financial experts. Develop your skills in business planning, financial management, 
            and marketing strategies.
        </p>

        <div class="btn-container">
            <a href="{{route ('enrollment_form') }}" class="btn go-back-btn">Go Enroll</a>
        </div>
    </div>

</body>
</html>
