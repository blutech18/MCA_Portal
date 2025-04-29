<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strand Assessment Test</title>
    <link rel="stylesheet" href="css/styles_assessment.css">
    <link href="https://fonts.cdnfonts.com/css/garet" rel="stylesheet">  
                
</head>
<body>
    <header>
        <div class="header-container">
            <img src="{{ asset('images/logo.png') }}" alt="School Logo" class="logo">
            <div class="title-container">
                <h1>STRAND ASSESSMENT TEST</h1>
                <p class="subtitle">MCA Montessori School</p>
            </div>
        </div>
    </header>
    
    
    <main>
        <div class="assessment-container">
            <h2>1. Which quote resonates with you the most?</h2>
            <div class="option-container">
                <button class="option"></button>
                <button class="option"></button>
                <button class="option"></button>
                <button class="option"></button>
                <button class="option"></button>
                <button class="option"></button>
            </div>
            <div class="navigation">
                <button class="nav-btn">&lt;</button>
                <button class="nav-btn">&gt;</button>
            </div>
            <div class="button-container">
                <button class="button-back" onclick="confirmExit()" data-route="{{ route('login') }}">&#60 Login</button>
                <button class="submit-btn" onclick="goToResult()" data-result-route="{{ route('assessment.result') }}">
                    Submit Assessment
                </button>
            </div>
        </div>
        
        <div id="confirm-modal" class="modal">
            <div class="modal-content">
                <p>Are you sure you want to cancel your assessment?</p>
                <button class="confirm-btn" onclick="exitAssessment()">Yes, Cancel</button>
                <button class="cancel-btn" onclick="closeModal()">No, Continue</button>
            </div>
        </div>
    </main>

    <script src="{{ asset('js/script_assessment.js') }}"></script>

</body>
</html>
