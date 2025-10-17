<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strand Assessment Test</title>
    <link rel="stylesheet" href="css/styles_assessment.css">
    <link href="https://fonts.cdnfonts.com/css/garet" rel="stylesheet">  
    <style>
        /* Compact and Formal Design */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('/images/bglogin.jpg') no-repeat;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            color: #2b0f12;
        }

        /* Header - Compact */
        header {
            background: #551a25;
            color: white;
            padding: 15px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .header-container {
            max-width: 1000px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 0 20px;
        }

        .logo {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            background: white;
            padding: 5px;
        }

        .title-container h1 {
            font-size: 20px;
            font-weight: 600;
            margin: 0;
        }

        .title-container .subtitle {
            font-size: 12px;
            opacity: 0.9;
            margin: 0;
        }

        /* Email Modal - Compact */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 12px;
            text-align: center;
            max-width: 450px;
            width: 90%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border: 2px solid #551a25;
        }

        .modal-content h3 {
            color: #551a25;
            margin-bottom: 15px;
            font-size: 20px;
            font-weight: 600;
        }

        .modal-content p {
            color: #555;
            margin-bottom: 20px;
            font-size: 14px;
            line-height: 1.4;
        }

        .modal-content input[type="email"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            margin: 10px 0;
            transition: border-color 0.3s ease;
            background: #f9f9f9;
        }

        .modal-content input[type="email"]:focus {
            outline: none;
            border-color: #7a222b;
            background: white;
        }

        .modal-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 20px;
        }

        .modal-buttons .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.2s ease;
            min-width: 100px;
        }

        .modal-buttons .confirm-btn {
            background: #7a222b;
            color: white;
        }

        .modal-buttons .confirm-btn:hover:not(:disabled) {
            background: #551a25;
        }

        .modal-buttons .confirm-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
            opacity: 0.6;
        }

        .modal-buttons .cancel-btn {
            background: #6c757d;
            color: white;
        }

        .modal-buttons .cancel-btn:hover {
            background: #5a6268;
        }

        /* Assessment Container - Compact Layout */
        .assessment-container {
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            max-width: 800px;
            margin: 20px auto;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .assessment-container.visible {
            opacity: 1;
            visibility: visible;
        }

        /* Progress Bar - Compact */
        .progress-bar {
            width: 100%;
            height: 4px;
            background: #e9ecef;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #7a222b, #551a25);
            transition: width 0.3s ease;
        }

        /* Question Counter - Compact */
        .question-counter {
            text-align: center;
            padding: 15px;
            background: #f8f9fa;
            color: #6c757d;
            font-size: 13px;
            font-weight: 500;
            border-bottom: 1px solid #e9ecef;
        }

        /* Question - Compact */
        h2 {
            color: #2b0f12;
            text-align: center;
            margin: 0;
            padding: 25px 20px;
            font-size: 18px;
            font-weight: 600;
            line-height: 1.4;
            background: white;
        }

        /* Option Buttons - 3x3 Grid Design */
        .option-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            padding: 25px;
            width: 100%;
            margin: 0 auto;
        }

        .option {
            background: rgba(255, 255, 255, 0.95);
            border: 2px solid #d1d5db;
            border-radius: 8px;
            padding: 18px 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            min-height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            word-wrap: break-word;
            position: relative;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            width: 100%;
        }

        .option:hover {
            background: rgba(255, 255, 255, 1);
            border-color: #7a222b;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transform: translateY(-1px);
        }

        .option.selected {
            background: rgba(122, 34, 43, 0.1);
            border-color: #7a222b;
            color: #551a25;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(122, 34, 43, 0.2);
        }

        /* Navigation - Compact */
        .navigation {
            display: flex;
            justify-content: center;
            gap: 15px;
            padding: 20px;
            background: #f8f9fa;
            border-top: 1px solid #e9ecef;
        }

        .nav-btn {
            background: #6c757d;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .nav-btn:hover:not(:disabled) {
            background: #9a3a44;
        }

        .nav-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        /* Action Buttons - Compact */
        .button-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background: #f8f9fa;
            border-top: 1px solid #e9ecef;
        }

        .button-back {
            background: #6c757d;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .button-back:hover {
            background: #5a6268;
        }

        .submit-btn {
            background: #7a222b;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .submit-btn:hover {
            background: #551a25;
        }

        /* Confirmation Modal */
        #confirm-modal .modal-content {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            max-width: 400px;
            width: 90%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border: 2px solid #551a25;
        }

        #confirm-modal .modal-content p {
            margin-bottom: 20px;
            color: #2b0f12;
            font-size: 16px;
        }

        #confirm-modal .confirm-btn {
            background: #dc3545;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            margin: 0 5px;
        }

        #confirm-modal .confirm-btn:hover {
            background: #c82333;
        }

        #confirm-modal .cancel-btn {
            background: #6c757d;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            margin: 0 5px;
        }

        #confirm-modal .cancel-btn:hover {
            background: #5a6268;
        }

        /* Responsive Design */
        
        /* Tablet - 2x3 grid */
        @media (max-width: 1024px) {
            .option-container {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }
            
            .option {
                min-height: 75px;
                font-size: 13px;
                padding: 15px 12px;
            }
        }
        
        /* Mobile - 1 column */
        @media (max-width: 768px) {
            .header-container {
                padding: 0 15px;
            }
            
            .header-container h1 {
                font-size: 18px;
            }
            
            .option-container {
                grid-template-columns: 1fr;
                padding: 20px 15px;
                gap: 10px;
            }
            
            .option {
                padding: 15px 18px;
                font-size: 14px;
                min-height: 65px;
                text-align: center;
            }
            
            .modal-content {
                padding: 20px;
                margin: 15px;
            }
            
            .button-container {
                flex-direction: column;
                gap: 10px;
                padding: 15px;
            }
            
            .navigation {
                flex-direction: column;
                gap: 10px;
                padding: 15px;
            }
            
            h2 {
                font-size: 16px;
                padding: 20px 15px;
            }
        }
        
        /* Small Mobile - Compact */
        @media (max-width: 480px) {
            .option-container {
                padding: 15px 10px;
                gap: 8px;
            }
            
            .option {
                padding: 12px 15px;
                font-size: 13px;
                min-height: 60px;
            }
            
            .modal-content {
                padding: 15px;
                margin: 10px;
            }
            
            .assessment-container {
                margin: 10px;
            }
        }
    </style>                
</head>
<body>
    <header>
        <div class="header-container">
            <img src="{{ asset('images/logo.png') }}?v={{ time() }}" alt="School Logo" class="logo">
            <div class="title-container">
                <h1>STRAND ASSESSMENT TEST</h1>
                <p class="subtitle">MCA Montessori School</p>
            </div>
        </div>
    </header>
    
    
    <!-- Email Capture Modal -->
    <div id="email-modal" class="modal" style="display: flex;">
        <div class="modal-content">
            <h3>Before We Begin</h3>
            <p>Please enter your email address to save your assessment results:</p>
            <form id="email-form">
                @csrf
                <input type="email" id="user-email" name="email" placeholder="Enter your email address" required>
                <div class="modal-buttons">
                    <button type="button" class="btn cancel-btn" onclick="closeModalOnly()">Cancel</button>
                    <button type="submit" class="btn confirm-btn" id="start-assessment-btn" disabled>Start Assessment</button>
                </div>
            </form>
        </div>
    </div>
    
    <main>
        <div class="assessment-container">
            <!-- Progress Bar -->
            <div class="progress-bar">
                <div class="progress-fill" id="progress-fill"></div>
            </div>
            
            <!-- Question Counter -->
            <div class="question-counter">
                <span id="question-counter">Question 1 of 25</span>
            </div>
            
            <!-- Question -->
            <h2 id="question-text">1. Which quote resonates with you the most?</h2>
            
            <!-- Options -->
            <div class="option-container">
                <button class="option" data-index="0"></button>
                <button class="option" data-index="1"></button>
                <button class="option" data-index="2"></button>
                <button class="option" data-index="3"></button>
                <button class="option" data-index="4"></button>
                <button class="option" data-index="5"></button>
            </div>
            
            <!-- Navigation -->
            <div class="navigation">
                <button class="nav-btn" id="prev-btn">&lt; Previous</button>
                <button class="nav-btn" id="next-btn">Next &gt;</button>
            </div>
            
            <!-- Action Buttons -->
            <div class="button-container">
                <button class="button-back" onclick="confirmExit()" data-route="{{ route('login') }}">&#60; Back to Login</button>
                <button class="submit-btn" id="submit-btn" data-result-route="{{ route('assessment.result') }}">
                    Submit Assessment
                </button>
            </div>
        </div>
        
        <div id="confirm-modal" class="modal" style="display: none;">
            <div class="modal-content">
                <p>Are you sure you want to cancel your assessment?</p>
                <button class="confirm-btn" onclick="exitAssessment()">Yes, Cancel</button>
                <button class="cancel-btn" onclick="closeModal()">No, Continue</button>
            </div>
        </div>
    </main>

    <script src="{{ asset('js/script_assessment.js') }}?v={{ time() }}"></script>

</body>
</html>
