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
          max-width: 600px;
          width: 90%;
          padding: 30px;
          background-color: rgba(244, 233, 234, 0.95);
          border-radius: 10px;
          box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
          text-align: center;
        }

        
        .header {
          display: flex;
          align-items: center;
          justify-content: center;
          margin-bottom: 30px;
          padding: 20px;
          background-color: transparent;
          border-radius: 10px;
          color: #7a222b;
          text-align: center;
        }

.school-logo {
  margin-right: 10px;
}

.school-logo img {
    width: 90px;
    height: 90px;
    border-radius: 50%; 
    object-fit: cover; 
    margin-right: 15px;
}

.school-name {
    color: #440909;
}

.school-name h2 {
    font-size: 24px;
    margin: 0;
}

.school-name p {
    font-size: 14px;
    margin: 0;
    color: #550404;
}

        h3 {
          color: #5a1a20;
          margin: 20px 0 15px;
          padding-bottom: 8px;
          font-weight: 600;
          font-size: 18px;
        }

        .selection-title {
          margin-bottom: 30px;
        }

        .selection-title h3 {
          border-bottom: 2px solid #bd8c91;
          display: inline-block;
          padding: 0 10px 8px;
        }

        .button-container {
          display: flex;
          flex-direction: column;
          gap: 20px;
          max-width: 300px;
          margin: 0 auto;
        }

        .selection-btn {
          display: block;
          width: 100%;
          padding: 12px;
          background-color: #7a222b;
          color: #f4e9ea;
          border: none;
          border-radius: 30px;
          font-size: 16px;
          font-weight: 600;
          cursor: pointer;
          transition: background-color 0.3s, transform 0.2s;
          text-transform: uppercase;
          letter-spacing: 1px;
          box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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

        .back-btn {
          margin-top: 40px;
          background-color: #bd8c91;
          color: #fff;
        }

        .back-btn:hover {
          background-color: #a47a7e;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
          .selection-container {
            padding: 20px;
            margin: 15px;
          }
          
          .header {
            flex-direction: column;
            text-align: center;
            padding: 15px 5px;
          }
          
          .school-logo {
            margin-right: 0;
            margin-bottom: 15px;
          }
          
          .school-logo img {
            max-width: 60px;
          }
          
          .school-name h2 {
            font-size: 20px;
          }
          
          .school-name p {
            font-size: 14px;
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
          .school-name h2 {
            font-size: 18px;
          }
          
          .school-name p {
            font-size: 12px;
          }
          
          .selection-btn {
            padding: 10px;
            font-size: 14px;
          }
          
          h3 {
            font-size: 16px;
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
            <h3>Applying as:</h3>
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