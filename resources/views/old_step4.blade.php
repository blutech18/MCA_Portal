<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MCA Montessori School Confirmation - Existing Students</title>
  <style>
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
}

.enrollment-form {
  max-width: 1000px;
  width: 95%;
  margin: 20px auto;
  padding: 30px;
  background-color: rgba(244, 233, 234, 0.95);
  border-radius: 10px;
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
}

/* Header Section with Logo and School Name */
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
  margin-right: 20px;
}

.school-logo img {
    width: 90px;
    height: 90px;
    border-radius: 50%; 
    object-fit: cover; 
    margin-right: 15px;
}

.school-name {
    color: #fff;
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

/* Form Styles */
form {
  padding: 20px;
  border-radius: 8px;
}

h2, h3 {
  color: #5a1a20;
  margin: 20px 0 15px;
  border-bottom: 2px solid #bd8c91;
  padding-bottom: 8px;
  font-weight: 600;
}

h2 {
  font-size: 22px;
  text-align: center;
  margin-top: 0;
}

h3 {
  font-size: 18px;
  text-align: center;
  margin-bottom: 20px;
}

/* Summary Sections */
.summary-container {
  background-color: #fff;
  border: 1px solid #bd8c91;
  border-radius: 8px;
  padding: 20px;
  margin-bottom: 30px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
}

.summary-section {
  border-bottom: 1px solid #f4e9ea;
  padding-bottom: 15px;
  margin-bottom: 15px;
}

.summary-section:last-child {
  border-bottom: none;
  margin-bottom: 0;
}

.summary-title {
  font-weight: 600;
  color: #5a1a20;
  margin-bottom: 10px;
  font-size: 16px;
}

.summary-item {
  display: flex;
  justify-content: space-between;
  margin-bottom: 8px;
  font-size: 14px;
}

.summary-label {
  font-weight: 500;
  color: #666;
}

.summary-value {
  text-align: right;
  color: #333;
}

/* Clearance Status */
.clearance-status-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 15px;
  margin-top: 10px;
}

.clearance-status-item {
  display: flex;
  align-items: center;
}

.status-indicator {
  width: 16px;
  height: 16px;
  border-radius: 50%;
  margin-right: 10px;
}

.status-cleared {
  background-color: #2e7d32;
}

.status-label {
  font-size: 14px;
  color: #333;
}

/* Message Section */
.message-section {
  background-color: #f9f1f2;
  border-left: 4px solid #7a222b;
  padding: 15px;
  margin: 20px 0;
  border-radius: 5px;
}

.message-title {
  display: flex;
  align-items: center;
  font-weight: 600;
  margin-bottom: 10px;
  color: #5a1a20;
}

.message-title .icon {
  margin-right: 10px;
  color: #7a222b;
}

.message-content {
  margin: 10px 0;
}

.highlight {
  font-weight: 600;
  color: #7a222b;
}

/* Success Message */
.success-message {
  text-align: center;
  margin: 25px 0;
  padding: 15px;
  background-color: #e8f5e9;
  border-radius: 5px;
  border-left: 4px solid #2e7d32;
  color: #2e7d32;
  font-weight: 500;
}

/* Buttons */
.action-buttons {
  display: flex;
  justify-content: center;
  gap: 20px;
  margin-top: 30px;
}

button {
  padding: 12px 20px;
  background-color: #7a222b;
  color: #f4e9ea;
  border: none;
  border-radius: 30px;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  transition: background-color 0.3s, transform 0.2s;
  text-transform: uppercase;
  letter-spacing: 1px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
}

button:hover {
  background-color: #5a1a20;
  transform: translateY(-2px);
  box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
}

button:active {
  transform: translateY(1px);
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.button-home {
  background-color: #bd8c91;
}

.button-home:hover {
  background-color: #a27a7e;
}

/* Progress Container */
.progress-container {
  max-width: 900px;
  width: 100%;
  padding: 25px;
  border-radius: 10px;
  margin: 0 auto 20px;
}

.progress-bar {
  display: flex;
  justify-content: space-between;
  position: relative;
  margin-bottom: 30px;
  counter-reset: step;
  z-index: 1;
}

.progress-bar::before {
  content: '';
  position: absolute;
  top: 25px;
  left: 0;
  width: 100%;
  height: 4px;
  background-color: #bd8c91;
  z-index: -1;
}

.progress-bar::after {
  content: '';
  position: absolute;
  top: 25px;
  left: 0;
  width: 0%;
  height: 4px;
  background-color: #7a222b;
  z-index: -1;
  transition: width 0.5s ease;
}

.progress-bar.step-1::after {
  width: 0%;
}

.progress-bar.step-2::after {
  width: 33%;
}

.progress-bar.step-3::after {
  width: 66%;
}

.progress-bar.step-4::after {
  width: 100%;
}

.progress-step {
  width: 50px;
  text-align: center;
  position: relative;
}

.step-circle {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  background-color: #f4e9ea;
  border: 4px solid #bd8c91;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #7a222b;
  font-weight: 600;
  font-size: 18px;
  margin: 0 auto;
  position: relative;
  z-index: 2;
  transition: all 0.3s ease;
}

.step-title {
  position: absolute;
  top: 60px;
  left: 50%;
  transform: translateX(-50%);
  width: 140px;
  text-align: center;
  font-size: 14px;
  color: #5a1a20;
  font-weight: 500;
}

/* Active and completed step styling */
.progress-step.active .step-circle {
  background-color: #7a222b;
  color: #f4e9ea;
  border-color: #7a222b;
}

.progress-step.completed .step-circle {
  background-color: #7a222b;
  color: #f4e9ea;
  border-color: #7a222b;
}

/* Print styles */
@media print {
  body {
    background: none;
    color: #000;
  }
  
  .enrollment-form {
    box-shadow: none;
    margin: 0;
    padding: 15px;
    width: 100%;
    max-width: 100%;
    background-color: #fff;
  }

  .action-buttons, .button-home {
    display: none;
  }

  .header {
    padding: 10px;
    margin-bottom: 15px;
  }

  .school-logo img {
    width: 70px;
    height: 70px;
  }

  .school-name h2 {
    color: #000;
  }

  .school-name p {
    color: #333;
  }

  .progress-container {
    display: none;
  }

  .summary-container {
    border: 1px solid #ccc;
    box-shadow: none;
    page-break-inside: avoid;
  }

  h2, h3 {
    color: #000;
  }
  
  @page {
    margin: 1cm;
  }
}

/* Responsible Design */
@media (max-width: 768px) {
  .enrollment-form {
    padding: 15px;
    margin: 10px;
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
  
  .action-buttons {
    flex-direction: column;
    gap: 15px;
  }
  
  .action-buttons button {
    width: 100%;
  }
  
  .progress-container {
    padding: 15px;
  }

  .step-circle {
    width: 40px;
    height: 40px;
    font-size: 16px;
  }

  .progress-bar::before,
  .progress-bar::after {
    top: 20px;
  }

  .step-title {
    font-size: 12px;
    width: 100px;
    top: 50px;
  }
  
  .clearance-status-grid {
    grid-template-columns: 1fr;
  }
}

/* Additional Breakpoint for Very Small Screens */
@media (max-width: 600px) {
  .step-circle {
    width: 35px;
    height: 35px;
    font-size: 14px;
    border-width: 3px;
  }

  .progress-bar::before,
  .progress-bar::after {
    top: 17px;
    height: 3px;
  }

  .step-title {
    font-size: 11px;
    width: 80px;
    top: 45px;
  }
}

@media (max-width: 480px) {
  .school-name h2 {
    font-size: 18px;
  }
  
  .school-name p {
    font-size: 12px;
  }
  
  h2 {
    font-size: 18px;
  }
  
  h3 {
    font-size: 16px;
  }
  
  .step-circle {
    width: 30px;
    height: 30px;
    font-size: 12px;
    border-width: 2px;
  }

  .progress-bar::before,
  .progress-bar::after {
    top: 15px;
    height: 2px;
  }

  .step-title {
    font-size: 9px;
    width: 60px;
    top: 40px;
  }
}
  </style>
</head>
<body>
    <div class="enrollment-form" id="enrollmentSummary">
        <div class="header">
            <div class="school-logo">
                <img src="{{asset ('images/logo.png')}}" alt="School Logo">
            </div>
            <div class="school-name">
                <h2>MCA MONTESSORI SCHOOL</h2>
                <p>ONLINE ENROLLMENT FORM - EXISTING STUDENTS</p>
            </div>
        </div>
        
        <div class="progress-container">
            <div class="progress-bar step-4">
                <div class="progress-step completed">
                    <div class="step-circle">1</div>
                    <div class="step-title">Pre-Registration</div>
                </div>
                <div class="progress-step completed">
                    <div class="step-circle">2</div>
                    <div class="step-title">Payment</div>
                </div>
                <div class="progress-step completed">
                    <div class="step-circle">3</div>
                    <div class="step-title">Clearances</div>
                </div>
                <div class="progress-step active">
                    <div class="step-circle">4</div>
                    <div class="step-title">Confirmation</div>
                </div>
            </div>
        </div>
  
        <h2>STEP 4. CONFIRMATION</h2>
        
        <div class="success-message">
            <p>Your enrollment application has been successfully submitted!</p>
        </div>
        
        <div class="message-section">
            <div class="message-title">
                <div class="icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 16V12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 8H12.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                IMPORTANT: FINAL VERIFICATION REQUIRED
            </div>
            <div class="message-content">
                <p>Please note that <span class="highlight">final approval for enrollment requires in-person verification</span> of all clearances by the Registrar at the school campus. Kindly bring this printed confirmation along with your original documents during your scheduled verification visit.</p>
                <p>Schedule your verification visit within <span class="highlight">5 business days</span> to complete your enrollment process. You will receive an email with further instructions.</p>
            </div>
        </div>
        
        <h3>ENROLLMENT SUMMARY</h3>
        
        <!-- Student Information Summary -->
        <div class="summary-container">
            <div class="summary-section">
                <div class="summary-title">STUDENT INFORMATION</div>
                <div class="summary-item">
                    <div class="summary-label">Full Name:</div>
                    <div class="summary-value">
                      {{ $enrollee->surname }}, {{ $enrollee->given_name }} {{ $enrollee->middle_name }}
                    </div>
                </div>
                <div class="summary-item">
                    <div class="summary-label">LRN:</div>
                    <div class="summary-value">{{ $enrollee->lrn }}</div>
                </div>
                <div class="summary-item">
                    <div class="summary-label">Intended Grade Level:</div>
                    <div class="summary-value">Grade {{ $enrollee->grade_level_applying }}</div>
                </div>
                <!--<div class="summary-item">
                    <div class="summary-label">School Year:</div>
                    <div class="summary-value">2025-2026</div>
                </div>-->
                <div class="summary-item">
                    <div class="summary-label">Student ID:</div>
                    <div class="summary-value">{{ $enrollee->application_number ?? $enrollee->student_id }}</div>
                </div>
            </div>
            

            
            <!-- Clearance Status Summary -->
            <div class="summary-section">
                <div class="summary-title">CLEARANCE STATUS</div>
                <div class="clearance-status-grid">
                    <div class="clearance-status-item">
                        <div class="status-indicator status-cleared"></div>
                        <div class="status-label">Registrar's Office</div>
                    </div>
                    <div class="clearance-status-item">
                        <div class="status-indicator status-cleared"></div>
                        <div class="status-label">Accounting</div>
                    </div>
                    <div class="clearance-status-item">
                        <div class="status-indicator status-cleared"></div>
                        <div class="status-label">Library</div>
                    </div>
                    <div class="clearance-status-item">
                        <div class="status-indicator status-cleared"></div>
                        <div class="status-label">Discipline Office</div>
                    </div>
                </div>
                <div class="summary-item" style="margin-top: 15px;">
                    <div class="summary-label">Submission Date:</div>
                    <div class="summary-value"> {{ $enrollee->created_at->format('F j, Y') }}</div>
                </div>
                <div class="summary-item">
                    <div class="summary-label">Application Status:</div>
                    <div class="summary-value highlight">Pending Final Verification</div>
                </div>
            </div>
        </div>
        
        <div class="action-buttons">
            <button id="printButton" type="button">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6 9V2H18V9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M6 18H4C3.46957 18 2.96086 17.7893 2.58579 17.4142C2.21071 17.0391 2 16.5304 2 16V11C2 10.4696 2.21071 9.96086 2.58579 9.58579C2.96086 9.21071 3.46957 9 4 9H20C20.5304 9 21.0391 9.21071 21.4142 9.58579C21.7893 9.96086 22 10.4696 22 11V16C22 16.5304 21.7893 17.0391 21.4142 17.4142C21.0391 17.7893 20.5304 18 20 18H18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M18 14H6V22H18V14Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                
                Print Summary
            </button>
            <button id="downloadButton" type="button">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M21 15V19C21 19.5304 20.7893 20.0391 20.4142 20.4142C20.0391 20.7893 19.5304 21 19 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M7 10L12 15L17 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12 15V3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Download PDF
            </button>
            <button id="homeButton" type="button" class="button-home">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M9 22V12H15V22" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Go to Home
            </button>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Set progress indicator to step 4
            setProgress(4);
            
            // Print functionality
            document.getElementById('printButton').addEventListener('click', function() {
                window.print();
            });
            
            // Download as PDF functionality
            document.getElementById('downloadButton').addEventListener('click', function() {
                // Configure pdf options
                const element = document.getElementById('enrollmentSummary');
                const options = {
                    margin: 10,
                    filename: 'MCA_Enrollment_Confirmation.pdf',
                    image: { type: 'jpeg', quality: 0.98 },
                    html2canvas: { scale: 2 },
                    jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
                };
                
                // Generate the PDF
                html2pdf().from(element).set(options).save();
            });
            
            // Home button functionality
            document.getElementById('homeButton').addEventListener('click', function() {
                // Redirect to home page
                window.location.href = '{{ route('login') }}';
            });
            
            // Set progress indicator
            function setProgress(stepNumber) {
                const progressBar = document.querySelector('.progress-bar');
                progressBar.classList.remove('step-1', 'step-2', 'step-3', 'step-4');
                progressBar.classList.add(`step-${stepNumber}`);
            }
            
            // Format current date for display
            function formatDate(date) {
                const options = { year: 'numeric', month: 'long', day: 'numeric' };
                return date.toLocaleDateString('en-US', options);
            }
            
            // Display current date in the summary
            const today = new Date();
            const submissionDateElements = document.querySelectorAll('.summary-value:contains("May 12, 2025")');
            submissionDateElements.forEach(element => {
                element.textContent = formatDate(today);
            });
        });
        
        // Helper function to find elements containing specific text
        jQuery.expr[':'].contains = function(a, i, m) {
            return jQuery(a).text().indexOf(m[3]) >= 0;
        };
    </script>
</body>
</html>