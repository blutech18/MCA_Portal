<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCA Montessori School - Enrollment</title>
    <style>
        /* MCA Montessori School Enrollment Form Styling */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        * {
          margin: 0;
          padding: 0;
          box-sizing: border-box;
          font-family: 'Poppins', sans-serif;
        }

        html, body {
          margin: 0;
          padding: 0;
          min-height: 100%;
          width: 100%;
        }

        body {
          background-image: url('/images/bglogin.jpg');
          background-size: cover;
          background-position: center;
          background-attachment: fixed;
          color: #2b0f12;
          line-height: 1.6;
          display: flex;
          align-items: center;
          justify-content: center;
          min-height: 100vh;
        }

        .selection-container {
          max-width: 500px;
          width: 90%;
          padding: 20px;
          background-color: rgba(244, 233, 234, 0.95);
          border-radius: 8px;
          box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
          text-align: center;
        }

        
        .header {
          display: flex;
          align-items: center;
          justify-content: center;
          margin-bottom: 20px;
          padding: 15px;
          background-color: transparent;
          border-radius: 8px;
          color: #7a222b;
          text-align: center;
        }

.school-logo {
  margin-right: 10px;
}

.school-logo img {
    width: 70px;
    height: 70px;
    border-radius: 50%; 
    object-fit: cover; 
    margin-right: 12px;
}

.school-name {
    color: #440909;
}

.school-name h2 {
    font-size: 20px;
    margin: 0;
}

.school-name p {
    font-size: 13px;
    margin: 0;
    color: #550404;
}

        h3 {
          color: #5a1a20;
          margin: 15px 0 10px;
          padding-bottom: 6px;
          font-weight: 600;
          font-size: 16px;
        }

        .selection-title {
          margin-bottom: 20px;
        }

        .selection-title h3 {
          border-bottom: 2px solid #bd8c91;
          display: inline-block;
          padding: 0 8px 6px;
        }

        .button-container {
          display: flex;
          flex-direction: column;
          gap: 15px;
          max-width: 280px;
          margin: 0 auto;
        }

        .selection-btn {
          display: block;
          width: 100%;
          padding: 10px;
          background-color: #7a222b;
          color: #f4e9ea;
          border: none;
          border-radius: 25px;
          font-size: 15px;
          font-weight: 600;
          cursor: pointer;
          transition: background-color 0.3s, transform 0.2s;
          text-transform: uppercase;
          letter-spacing: 0.5px;
          box-shadow: 0 3px 5px rgba(0, 0, 0, 0.1);
        }

        .selection-btn:hover {
          background-color: #5a1a20;
          transform: translateY(-2px);
          box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }

        .selection-btn:active {
          transform: translateY(1px);
          box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .assessment-btn {
          background-color: #4CAF50;
          font-size: 16px;
          padding: 12px;
          margin-bottom: 15px;
        }

        .assessment-btn:hover {
          background-color: #45a049;
        }

        .back-btn {
          margin-top: 25px;
          background-color: #bd8c91;
          color: #fff;
        }

        .back-btn:hover {
          background-color: #a47a7e;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
          .selection-container {
            padding: 15px;
            margin: 10px;
            max-width: 400px;
          }
          
          .header {
            flex-direction: column;
            text-align: center;
            padding: 10px 5px;
            margin-bottom: 15px;
          }
          
          .school-logo {
            margin-right: 0;
            margin-bottom: 10px;
          }
          
          .school-logo img {
            width: 60px;
            height: 60px;
          }
          
          .school-name h2 {
            font-size: 18px;
          }
          
          .school-name p {
            font-size: 12px;
          }

          h3 {
            font-size: 15px;
            margin: 12px 0 8px;
          }

          .selection-title {
            margin-bottom: 15px;
          }

          .button-container {
            gap: 12px;
            max-width: 260px;
          }

          .selection-btn {
            padding: 8px;
            font-size: 14px;
          }

          .assessment-btn {
            font-size: 15px;
            padding: 10px;
            margin-bottom: 12px;
          }

          .back-btn {
            margin-top: 20px;
          }
        }

        
        .modal {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 12;
        }

        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }

        .confirm-btn, .cancel-btn {
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            margin: 10px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .confirm-btn {
            background: red;
            color: white;
        }

        .cancel-btn {
            background: gray;
            color: white;
        }
  

        /* Additional Breakpoint for Very Small Screens */
        @media (max-width: 480px) {
          .selection-container {
            padding: 12px;
            margin: 8px;
            max-width: 350px;
          }

          .header {
            padding: 8px 5px;
            margin-bottom: 12px;
          }

          .school-logo img {
            width: 50px;
            height: 50px;
          }

          .school-name h2 {
            font-size: 16px;
          }
          
          .school-name p {
            font-size: 11px;
          }
          
          .selection-btn {
            padding: 8px;
            font-size: 13px;
          }
          
          h3 {
            font-size: 14px;
            margin: 10px 0 6px;
          }

          .selection-title {
            margin-bottom: 12px;
          }

          .button-container {
            gap: 10px;
            max-width: 240px;
          }

          .assessment-btn {
            font-size: 14px;
            padding: 9px;
            margin-bottom: 10px;
          }

          .back-btn {
            margin-top: 15px;
          }
        }
    </style>
</head>
<body>
    <div class="selection-container">
        <div class="enrollment-form">
            <div class="header">
                <div class="school-logo">
                    <img src="{{asset ('images/logo.png')}}" alt="School Logo">
                </div>
                <div class="school-name">
                    <h2>MCA MONTESORRI SCHOOL</h2>
                    <p>ONLINE ENROLLMENT FORM</p>
                </div>
            </div>
        </div>

        <div class="selection-title">
            <h3>Take Assessment First (Recommended)</h3>
        </div>

        <div class="button-container">
            <button class="selection-btn assessment-btn" onclick="window.location.href='{{ route('strand.assessment') }}'">Take Strand Assessment</button>
        </div>

        <div class="selection-title">
            <h3>Or Apply Directly:</h3>
        </div>

        <div class="button-container">
            <button class="selection-btn" onclick="window.location.href='{{ route('enroll.new.step1') }}'">New Student</button>
            <button class="selection-btn" onclick="window.location.href='{{ route('enroll.old.step1') }}'">Old Student</button>
            <div>
              <form id="login-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
              </form>
              <button class="selection-btn back-btn" onclick="confirmExit()">Back to Login page</button>
            </div>
        </div>
    </div>

    <div id="confirm-modal" class="modal">
      <div class="modal-content">
          <p>Are you sure you want to cancel enrollment?</p>
          <button class="confirm-btn" onclick="logout(event)">Yes</button>
          <button class="cancel-btn" onclick="closeModal()">No</button>
      </div>
    </div>

    <script>
        
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Page loaded successfully');
            
            // Clear all cached data when user visits enrollment selection page
            function clearAllCachedData() {
                // Clear form data cache - use the correct cache key
                localStorage.removeItem('new_step1_form_cache_v1');
                localStorage.removeItem('new_step2_form_data');
                localStorage.removeItem('new_step3_form_data');
                localStorage.removeItem('old_step1_form_data');
                localStorage.removeItem('old_step2_form_data');
                localStorage.removeItem('old_step3_form_data');
                
                // Clear file caches
                const newFileInputs = ['reportCard', 'goodMoral', 'birthCertificate', 'idPicture'];
                newFileInputs.forEach(inputId => {
                    localStorage.removeItem(`new_step2_${inputId}`);
                });
                localStorage.removeItem(`new_step3_receiptUpload`);
                localStorage.removeItem(`old_step2_receiptUpload`);
                
                // Clear session data
                sessionStorage.removeItem('new_enrollee_id');
                sessionStorage.removeItem('old_enrollee_id');
                sessionStorage.removeItem('enrollment_in_progress');
                
                console.log('All cached data cleared - fresh start');
            }
            
            // Clear cached data when visiting selection page
            clearAllCachedData();
        });

        function confirmExit() {
            document.getElementById("confirm-modal").style.display = "flex";
        }
        function closeModal(){
            document.getElementById('confirm-modal').style.display = "none";
        }
        function logout(e){
            e.preventDefault();  
            document.getElementById('login-form').submit();
        }

    </script>
</body>
</html>