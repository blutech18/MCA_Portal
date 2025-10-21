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
          padding: 15px 10px;
          overflow-x: hidden;
        }

        .selection-container {
          max-width: 1100px;
          width: 100%;
          padding: 20px 15px;
          text-align: center;
        }

        
        .header {
          margin-bottom: 25px;
          color: white;
          text-align: center;
          background: rgba(139, 38, 53, 0.85);
          padding: 20px;
          border-radius: 12px;
          box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .header h1 {
          font-size: 30px;
          font-weight: 700;
          margin: 0 0 8px 0;
          letter-spacing: 1px;
        }

        .header h2 {
          font-size: 19px;
          font-weight: 500;
          margin: 0 0 6px 0;
        }

        .header p {
          font-size: 14px;
          font-weight: 300;
          margin: 0;
          opacity: 0.95;
        }

        .cards-container {
          display: grid;
          grid-template-columns: repeat(2, 1fr);
          gap: 20px;
          max-width: 1100px;
          margin: 0 auto;
        }

        .enrollment-card {
          background: white;
          border-radius: 12px;
          overflow: hidden;
          box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
          transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .enrollment-card:hover {
          transform: translateY(-5px);
          box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3);
        }

        .card-header {
          background: linear-gradient(135deg, #8B2635 0%, #6B1E2A 100%);
          padding: 20px;
          display: flex;
          align-items: center;
          justify-content: space-between;
          gap: 12px;
        }

        .card-header-left {
          display: flex;
          align-items: center;
          gap: 12px;
          flex: 1;
        }

        .assessment-btn {
          padding: 8px 16px;
          background: rgba(255, 255, 255, 0.2);
          color: white;
          border: 1.5px solid rgba(255, 255, 255, 0.5);
          border-radius: 6px;
          font-size: 13px;
          font-weight: 500;
          cursor: pointer;
          transition: all 0.3s ease;
          white-space: nowrap;
          display: flex;
          align-items: center;
          gap: 6px;
        }

        .assessment-btn:hover {
          background: rgba(255, 255, 255, 0.3);
          border-color: rgba(255, 255, 255, 0.7);
          transform: translateY(-1px);
        }

        .assessment-btn svg {
          width: 16px;
          height: 16px;
          stroke: white;
          fill: none;
        }

        .card-icon {
          width: 50px;
          height: 50px;
          background: rgba(255, 255, 255, 0.2);
          border-radius: 50%;
          display: flex;
          align-items: center;
          justify-content: center;
          flex-shrink: 0;
        }

        .card-icon svg {
          width: 28px;
          height: 28px;
          stroke: white;
          fill: none;
        }

        .card-title {
          text-align: left;
          color: white;
        }

        .card-title h3 {
          font-size: 24px;
          font-weight: 600;
          margin: 0 0 5px 0;
        }

        .card-title p {
          font-size: 14px;
          margin: 0;
          opacity: 0.9;
          font-weight: 300;
        }

        .card-body {
          padding: 20px;
        }

        .features-list {
          list-style: none;
          padding: 0;
          margin: 0 0 20px 0;
          text-align: left;
        }

        .features-list li {
          padding: 10px 0;
          display: flex;
          align-items: flex-start;
          gap: 10px;
          color: #333;
          font-size: 14px;
          border-bottom: 1px solid #f0f0f0;
        }

        .features-list li:last-child {
          border-bottom: none;
        }

        .check-icon {
          width: 20px;
          height: 20px;
          background: #10B981;
          border-radius: 50%;
          display: flex;
          align-items: center;
          justify-content: center;
          flex-shrink: 0;
          margin-top: 2px;
        }

        .check-icon svg {
          width: 12px;
          height: 12px;
          stroke: white;
          stroke-width: 3;
        }

        .enroll-btn {
          display: flex;
          align-items: center;
          justify-content: center;
          gap: 8px;
          width: 100%;
          padding: 12px 20px;
          background: linear-gradient(135deg, #8B2635 0%, #6B1E2A 100%);
          color: white;
          border: none;
          border-radius: 8px;
          font-size: 15px;
          font-weight: 600;
          cursor: pointer;
          transition: all 0.3s ease;
          box-shadow: 0 4px 12px rgba(139, 38, 53, 0.3);
        }

        .enroll-btn:hover {
          background: linear-gradient(135deg, #6B1E2A 0%, #5C1A23 100%);
          transform: translateY(-2px);
          box-shadow: 0 6px 16px rgba(139, 38, 53, 0.4);
        }

        .enroll-btn:active {
          transform: translateY(0);
        }

        .enroll-btn svg {
          width: 18px;
          height: 18px;
          stroke: white;
          fill: none;
        }

        .back-btn {
          margin-top: 20px;
          padding: 10px 25px;
          background: rgba(139, 38, 53, 0.85);
          color: white;
          border: 2px solid rgba(255, 255, 255, 0.4);
          border-radius: 8px;
          font-size: 14px;
          font-weight: 500;
          cursor: pointer;
          transition: all 0.3s ease;
          box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
        }

        .back-btn:hover {
          background: rgba(107, 30, 42, 0.9);
          border-color: rgba(255, 255, 255, 0.6);
          transform: translateY(-2px);
          box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        /* Responsive Design */
        @media (max-width: 968px) {
          .cards-container {
            grid-template-columns: 1fr;
            gap: 20px;
            max-width: 600px;
          }

          .header {
            padding: 18px;
            margin-bottom: 20px;
          }

          .header h1 {
            font-size: 26px;
          }

          .header h2 {
            font-size: 17px;
          }

          .header p {
            font-size: 13px;
          }
        }

        @media (max-width: 768px) {
          body {
            padding: 10px;
          }

          .selection-container {
            padding: 15px 10px;
          }

          .header {
            margin-bottom: 18px;
            padding: 15px;
          }

          .header h1 {
            font-size: 22px;
          }

          .header h2 {
            font-size: 16px;
          }

          .card-header {
            padding: 18px 15px;
            flex-wrap: wrap;
          }

          .assessment-btn {
            font-size: 12px;
            padding: 7px 14px;
          }

          .card-title h3 {
            font-size: 20px;
          }

          .card-body {
            padding: 18px 15px;
          }

          .features-list {
            margin-bottom: 18px;
          }

          .features-list li {
            font-size: 13px;
            padding: 8px 0;
          }

          .enroll-btn {
            padding: 11px 18px;
            font-size: 14px;
          }

          .back-btn {
            margin-top: 18px;
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
          body {
            padding: 8px;
          }

          .selection-container {
            padding: 12px 8px;
          }

          .header {
            padding: 12px;
            margin-bottom: 15px;
          }

          .header h1 {
            font-size: 19px;
          }

          .header h2 {
            font-size: 15px;
          }

          .header p {
            font-size: 12px;
          }

          .cards-container {
            gap: 15px;
          }

          .card-header {
            padding: 15px 12px;
            gap: 10px;
            flex-direction: column;
            align-items: flex-start;
          }

          .card-header-left {
            width: 100%;
          }

          .assessment-btn {
            width: 100%;
            justify-content: center;
            font-size: 12px;
            padding: 8px 12px;
          }

          .card-icon {
            width: 38px;
            height: 38px;
          }

          .card-icon svg {
            width: 20px;
            height: 20px;
          }

          .card-title h3 {
            font-size: 17px;
          }

          .card-title p {
            font-size: 12px;
          }

          .card-body {
            padding: 15px 12px;
          }

          .features-list {
            margin-bottom: 15px;
          }

          .features-list li {
            font-size: 12px;
            padding: 7px 0;
            gap: 8px;
          }

          .check-icon {
            width: 16px;
            height: 16px;
          }

          .check-icon svg {
            width: 10px;
            height: 10px;
          }

          .enroll-btn {
            padding: 10px 16px;
            font-size: 13px;
          }

          .back-btn {
            margin-top: 15px;
            padding: 9px 20px;
            font-size: 13px;
          }
        }
    </style>
</head>
<body>
    <div class="selection-container">
        <div class="header">
            <h1>MCA MONTESSORI SCHOOL</h1>
            <h2>Choose Your Enrollment Type</h2>
            <p>Select the enrollment option that applies to you</p>
        </div>

        <div class="cards-container">
            <!-- New Student Card -->
            <div class="enrollment-card">
                <div class="card-header">
                    <div class="card-header-left">
                        <div class="card-icon">
                            <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="8.5" cy="7" r="4"></circle>
                                <line x1="20" y1="8" x2="20" y2="14"></line>
                                <line x1="23" y1="11" x2="17" y2="11"></line>
                            </svg>
                        </div>
                        <div class="card-title">
                            <h3>New Student</h3>
                            <p>First time enrolling at MCA</p>
                        </div>
                    </div>
                    <button class="assessment-btn" onclick="window.location.href='{{ route('strand.assessment') }}'">
                        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 11l3 3L22 4"></path>
                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                        </svg>
                        Take Assessment
                    </button>
                </div>
                <div class="card-body">
                    <ul class="features-list">
                        <li>
                            <div class="check-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </div>
                            <span>Complete online enrollment form</span>
                        </li>
                        <li>
                            <div class="check-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </div>
                            <span>Upload required documents</span>
                        </li>
                        <li>
                            <div class="check-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </div>
                            <span>Receive enrollment confirmation</span>
                        </li>
                        <li>
                            <div class="check-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </div>
                            <span>Admin review and approval</span>
                        </li>
                    </ul>
                    <button class="enroll-btn" onclick="window.location.href='{{ route('enroll.new.step1') }}'">
                        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                        Start New Student Enrollment
                    </button>
                </div>
            </div>

            <!-- Old Student Card -->
            <div class="enrollment-card">
                <div class="card-header">
                    <div class="card-header-left">
                        <div class="card-icon">
                            <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                        <div class="card-title">
                            <h3>Old Student</h3>
                            <p>Returning student re-enrolling</p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="features-list">
                        <li>
                            <div class="check-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </div>
                            <span>Provide existing student ID</span>
                        </li>
                        <li>
                            <div class="check-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </div>
                            <span>Upload payment receipt</span>
                        </li>
                        <li>
                            <div class="check-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </div>
                            <span>Submit clearance documents</span>
                        </li>
                        <li>
                            <div class="check-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </div>
                            <span>Payment verification process</span>
                        </li>
                    </ul>
                    <button class="enroll-btn" onclick="window.location.href='{{ route('enroll.old.step1') }}'">
                        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                        Start Old Student Enrollment
                    </button>
                </div>
            </div>
        </div>

        <div>
            <form id="login-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <button class="back-btn" onclick="confirmExit()">Back to Login Page</button>
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