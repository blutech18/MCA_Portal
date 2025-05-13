<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MCA Montessori School Enrollment Confirmation</title>
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

.back-btn {
  display: flex;
  align-items: center;
  text-decoration: none;
  color: #333;
  font-size: 1rem;
  padding: 0.5rem;
  transition: color 0.2s;
}

/* the curved arrow shape */
.back-btn::before {
  content: '';
  display: inline-block;
  width: 0.6em;
  height: 0.6em;
  border: solid currentColor;
  border-width: 0 0.15em 0.15em 0;
  transform: rotate(135deg);
  margin-right: 0.5em;
}

/* hover state */
.back-btn:hover {
  color: #007bff;
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

fieldset {
  border: 1px solid #bd8c91;
  border-radius: 5px;
  padding: 15px;
  margin-bottom: 20px;
}

legend {
  color: #7a222b;
  font-weight: 600;
  padding: 0 10px;
}

/* Confirmation Container */
.confirmation-container {
  display: flex;
  flex-direction: column;
  gap: 20px;
  margin-bottom: 30px;
}

.confirmation-section {
  background-color: #fff;
  border: 1px solid #bd8c91;
  border-radius: 8px;
  padding: 20px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
}

.success-message {
  text-align: center;
  padding: 20px;
  background-color: #eaf7ea;
  border-left: 4px solid #4CAF50;
  border-radius: 5px;
  margin-bottom: 20px;
}

.success-message .icon {
  color: #4CAF50;
  font-size: 48px;
  margin-bottom: 10px;
}

.success-message h3 {
  color: #2e7d32;
  margin: 10px 0;
  border-bottom: none;
}

.success-message p {
  color: #2e7d32;
  font-weight: 500;
}

.student-id {
  font-size: 24px;
  font-weight: 700;
  color: #7a222b;
  text-align: center;
  margin: 20px 0;
  padding: 10px;
  background-color: #f9f1f2;
  border-radius: 5px;
  border: 2px dashed #bd8c91;
}

/* Info sections */
.info-section {
  margin-bottom: 15px;
}

.info-section h4 {
  color: #7a222b;
  font-weight: 600;
  margin-bottom: 10px;
  padding-bottom: 5px;
  border-bottom: 1px solid #bd8c91;
}

.info-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  grid-gap: 10px;
}

.info-item {
  display: flex;
  flex-direction: column;
  margin-bottom: 10px;
}

.info-label {
  font-weight: 500;
  color: #5a1a20;
  font-size: 14px;
}

.info-value {
  font-weight: 400;
  color: #2b0f12;
}

/* Contact Information */
.contact-info {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  margin-top: 15px;
}

.contact-item {
  display: flex;
  align-items: center;
  margin-bottom: 10px;
  flex: 1 0 280px;
}

.contact-icon {
  margin-right: 10px;
  color: #7a222b;
}

.contact-details {
  display: flex;
  flex-direction: column;
}

.contact-label {
  font-weight: 500;
  color: #5a1a20;
  font-size: 14px;
}

.contact-value {
  font-weight: 400;
  color: #2b0f12;
}

/* Buttons */
.button-group {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  gap: 15px;
  margin-top: 30px;
}

.btn {
  padding: 12px 24px;
  border-radius: 30px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  text-transform: uppercase;
  letter-spacing: 1px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  font-size: 14px;
  border: none;
  display: flex;
  align-items: center;
  justify-content: center;
}

.btn .icon {
  margin-right: 8px;
}

.btn-primary {
  background-color: #7a222b;
  color: #f4e9ea;
}

.btn-primary:hover {
  background-color: #5a1a20;
  transform: translateY(-2px);
  box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
}

.btn-secondary {
  background-color: #bd8c91;
  color: #fff;
}

.btn-secondary:hover {
  background-color: #a27a7e;
  transform: translateY(-2px);
  box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
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

/* Email Notification Section */
.email-notification {
  padding: 15px;
  background-color: #e8f4fd;
  border-left: 4px solid #2196F3;
  border-radius: 5px;
  margin-top: 20px;
}

.email-notification .icon {
  color: #2196F3;
  margin-right: 10px;
}

.email-notification h4 {
  display: flex;
  align-items: center;
  color: #0d47a1;
  margin-bottom: 10px;
  border-bottom: none;
}

.email-notification p {
  color: #0d47a1;
  font-size: 14px;
}

.highlight {
  font-weight: 600;
  color: #7a222b;
}

/* Responsive Design */
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
  
  .info-grid {
    grid-template-columns: 1fr;
  }
  
  .button-group {
    flex-direction: column;
    align-items: center;
  }
  
  .button-group .btn {
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
  
  .student-id {
    font-size: 20px;
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
    font-size: 14px;
  }
  
  .progress-container {
    padding: 10px;
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
  
  .student-id {
    font-size: 16px;
  }
}

/* Print styles */
@media print {
  body {
    background: none;
    color: black;
  }
  
  .enrollment-form {
    box-shadow: none;
    margin: 0;
    padding: 20px;
    background: white;
    max-width: 100%;
  }
  
  .button-group, 
  .progress-container {
    display: none;
  }
  
  .header {
    padding: 10px;
  }
  
  .school-logo img {
    width: 70px;
    height: 70px;
  }
  
  .school-name h2 {
    color: #000;
  }
  
  .school-name p {
    color: #000;
  }
  
  .print-header {
    display: block;
    text-align: center;
    margin-bottom: 20px;
  }
  
  .page-break {
    page-break-after: always;
  }
}

.print-header {
  display: none;
}

/* Animation for checkmark */
@keyframes scaleCheck {
  0% {
    transform: scale(0);
  }
  50% {
    transform: scale(1.2);
  }
  100% {
    transform: scale(1);
  }
}

.animate-check {
  animation: scaleCheck 0.5s ease-in-out;
}
  </style>
</head>

<body>
    <div class="enrollment-form">
      <a href="{{ route('login')}}" class="back-btn">Login</a>
        <div class="header">
            <div class="school-logo">
                <img src="{{asset ('images/logo.png')}}" alt="School Logo">
            </div>
            <div class="school-name">
                <h2>MCA MONTESSORI SCHOOL</h2>
                <p>ONLINE ENROLLMENT FORM</p>
            </div>
        </div>
        
        <!-- Print header that only shows when printing -->
        <div class="print-header">
            <h2>MCA MONTESSORI SCHOOL ENROLLMENT CONFIRMATION</h2>
            <p>Date: <span id="print-date"></span></p>
        </div>
        
        <div class="progress-container">
          <div class="progress-bar step-4">
            <div class="progress-step completed">
                <div class="step-circle">1</div>
                <div class="step-title">Fill Out the Form</div>
            </div>
            <div class="progress-step completed">
                <div class="step-circle">2</div>
                <div class="step-title">Document Upload</div>
            </div>
            <div class="progress-step completed">
                <div class="step-circle">3</div>
                <div class="step-title">Payment</div>
            </div>
            <div class="progress-step active">
                <div class="step-circle">4</div>
                <div class="step-title">Confirmation</div>
            </div>
          </div>
        </div>
  
        <div id="confirmationContent">
          <h2>STEP 4. ENROLLMENT CONFIRMATION</h2>
        
        <div class="confirmation-container">
          <div class="confirmation-section">
            <div class="success-message">
              <div class="icon">
                  <svg class="animate-check" width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M22 11.08V12C21.9988 14.1564 21.3005 16.2547 20.0093 17.9818C18.7182 19.709 16.9033 20.9725 14.8354 21.5839C12.7674 22.1953 10.5573 22.1219 8.53447 21.3746C6.51168 20.6273 4.78465 19.2461 3.61096 17.4371C2.43727 15.628 1.87979 13.4881 2.02168 11.3363C2.16356 9.18455 2.99721 7.13631 4.39828 5.49706C5.79935 3.85781 7.69279 2.71537 9.79619 2.24013C11.8996 1.7649 14.1003 1.98232 16.07 2.85999" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M22 4L12 14.01L9 11.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
              </div>
              <h3>Enrollment Complete!</h3>
              <p>Your application has been successfully submitted and received.</p>
            </div>
              
            <div class="student-id">
                Student ID: <span id="studentID">{{ $enrollee->application_number }}</span>
            </div>
              
            <div class="email-notification">
              <h4>
                <div class="icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 4H20C21.1 4 22 4.9 22 6V18C22 19.1 21.1 20 20 20H4C2.9 20 2 19.1 2 18V6C2 4.9 2.9 4 4 4Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M22 6L12 13L2 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                Important Email Notification
              </h4>
              <p>Your school account details will be sent to the email address you provided in your enrollment form. <span class="highlight">Please ensure that you have provided a correct email address {{ $enrollee->email }}</span> and check your inbox (and spam folder) regularly.</p>
            </div>
          </div>
            
        <div class="confirmation-section">
          <div class="info-section">
            <h4>Application Summary</h4>
            <div class="info-grid">
              <div class="info-item">
                  <span class="info-label">Full Name</span>
                  <span class="info-value" id="fullName">
                    {{ $enrollee->surname }}, {{ $enrollee->given_name }} {{ $enrollee->middle_name }}
                  </span>
              </div>
              <div class="info-item">
                  <span class="info-label">Grade Level</span>
                  <span class="info-value" id="gradeLevel">
                     {{ $enrollee->previous_grade }}
                  </span>
              </div>
              <div class="info-item">
                  <span class="info-label">Enrollment Type</span>
                  <span class="info-value" id="enrollmentType">New Student</span>
              </div>
              <div class="info-item">
                  <span class="info-label">School Year</span>
                  <span class="info-value" id="schoolYear">{{ now()->year }}–{{ now()->addYear()->year }}</span>
              </div>
              <div class="info-item">
                  <span class="info-label">Email Address</span>
                  <span class="info-value" id="emailAddress">{{ $enrollee->email }}</span>
              </div>
              <div class="info-item">
                  <span class="info-label">Contact Number</span>
                  <span class="info-value" id="contactNumber"> {{ $enrollee->contact_no }}</span>
              </div>
              <div class="info-item">
                  <span class="info-label">Payment Reference</span>
                  <span class="info-value" id="paymentRef">{{ $enrollee->payment_reference }}</span>
              </div>
              <div class="info-item">
                  <span class="info-label">Date Submitted</span>
                  <span class="info-value" id="dateSubmitted"> {{ $enrollee->created_at->format('F j, Y') }}</span>
              </div>
            </div>
          </div>
                
          <div class="info-section">
            <h4>School Contact Information</h4>
            <div class="contact-info">
              <div class="contact-item">
                <div class="contact-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 4H9L11 9L8.5 10.5C9.57096 12.6715 11.3285 14.429 13.5 15.5L15 13L20 15V19C20 19.5304 19.7893 20.0391 19.4142 20.4142C19.0391 20.7893 18.5304 21 18 21C14.0993 20.763 10.4202 19.1065 7.65683 16.3432C4.8935 13.5798 3.23705 9.90074 3 6C3 5.46957 3.21071 4.96086 3.58579 4.58579C3.96086 4.21071 4.46957 4 5 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="contact-details">
                    <span class="contact-label">Mobile Numbers</span>
                    <span class="contact-value">(0960) 374 1679</span>
                    <span class="contact-value">(0960) 374 1676</span>
                </div>
              </div>
                        
              <div class="contact-item">
                  <div class="contact-icon">
                      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M4 4H20C21.1 4 22 4.9 22 6V18C22 19.1 21.1 20 20 20H4C2.9 20 2 19.1 2 18V6C2 4.9 2.9 4 4 4Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                          <path d="M22 6L12 13L2 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                  </div>
                  <div class="contact-details">
                      <span class="contact-label">Email Address</span>
                      <span class="contact-value">adminoffice@mcams.edu.ph</span>
                  </div>
              </div>

              <div class="contact-item">
                  <div class="contact-icon">
                      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M12 2V6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                          <path d="M12 18V22" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                          <path d="M4.93 4.93L7.76 7.76" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                          <path d="M16.24 16.24L19.07 19.07" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                          <path d="M2 12H6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                          <path d="M18 12H22" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                          <path d="M4.93 19.07L7.76 16.24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                          <path d="M16.24 7.76L19.07 4.93" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                  </div>
                  <div class="contact-details">
                      <span class="contact-label">Business Hours</span>
                      <span class="contact-value">Monday - Friday</span>
                      <span class="contact-value">7:30 AM - 4:00 PM</span>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
        
        <div class="button-group">
          <button type="button" class="btn btn-secondary" id="downloadConfirmation">
              <div class="icon">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M21 15V19C21 19.5304 20.7893 20.0391 20.4142 20.4142C20.0391 20.7893 19.5304 21 19 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M7 10L12 15L17 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M12 15V3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
              </div>
              Download Confirmation
          </button>
          <button type="button" class="btn btn-primary" id="printConfirmation">
              <div class="icon">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M6 9V2H18V9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M6 18H4C3.46957 18 2.96086 17.7893 2.58579 17.4142C2.21071 17.0391 2 16.5304 2 16V11C2 10.4696 2.21071 9.96086 2.58579 9.58579C2.96086 9.21071 3.46957 9 4 9H20C20.5304 9 21.0391 9.21071 21.4142 9.58579C21.7893 9.96086 22 10.4696 22 11V16C22 16.5304 21.7893 17.0391 21.4142 17.4142C21.0391 17.7893 20.5304 18 20 18H18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M18 14H6V22H18V14Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
              </div>
              Print Confirmation
          </button>
        </div> 


<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Display print date
    document.getElementById('print-date').textContent = new Date().toLocaleDateString('en-US', {
      year: 'numeric', month: 'long', day: 'numeric'
    });

    
    const fieldMap = {
      fullName: 'fullName',
      gradeLevel: 'gradeLevel',
      enrollmentType: 'enrollmentType',
      schoolYear: 'schoolYear',
      emailAddress: 'email',
      contactNumber: 'contact',
      paymentRef: 'paymentRef',
      dateSubmitted: 'submissionDate',
      studentID: 'studentID'
    };

    Object.keys(fieldMap).forEach(id => {
      const value = localStorage.getItem(fieldMap[id]);
      if (value && document.getElementById(id)) {
        document.getElementById(id).textContent = value;
      }
    });

   
    document.getElementById('printConfirmation').addEventListener('click', function () {
      window.print();
    });

    
    document.getElementById('downloadConfirmation').addEventListener('click', function () {
      const element = document.getElementById('confirmationContent');
      const studentIdText = document.getElementById('studentID')?.textContent?.trim() || 'Confirmation';
      const fileName = `MCA_Confirmation_${studentIdText}.pdf`;

      const opt = {
        margin:       0.5,
        filename:     fileName,
        image:        { type: 'jpeg', quality: 0.98 },
        html2canvas:  { scale: 2 },
        jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
      };

      html2pdf().set(opt).from(element).save();
    });
  });
</script>
</body>
</html>