<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment Confirmation</title>
    <link rel="stylesheet" href="css/styles_enrollment_success.css">
    <link href="https://fonts.cdnfonts.com/css/garet" rel="stylesheet">
</head>
<body onload="startConfetti()">

    <div class="confirmation-container">
        <div class="header">
            <img src="{{ asset('images/logo.png') }}" alt="MCA Montessori School Logo" class="logo">
            <div class="header-text">
                <h1>MCA MONTESSORI SCHOOL</h1>
                <h2>ONLINE ENROLLMENT FORM</h2>
            </div>
        </div>

        <h1 class="fade-in">Enrollment Successful!</h1>
        <p class="fade-in">
            Your enrollment form has been successfully submitted. Please allow 1-2 business days for us to review your application. You will receive an email with your enrollment status shortly.
            <br><br>If you have any questions, feel free to contact us at <strong>adminoffice@mcams.edu.ph</strong><br><br>
        </p>
        <a href="{{route('home')}}" class="btn">Return to Main Page</a>
    </div>

    <script src="js/script_enrollment_success.js"></script>
</body>
</html>
