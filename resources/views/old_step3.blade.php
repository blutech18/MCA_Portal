<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MCA Montessori School Clearances - Existing Students</title>
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

/* Clearance Section */
.clearance-container {
  background-color: #fff;
  border: 1px solid #bd8c91;
  border-radius: 8px;
  padding: 20px;
  margin-bottom: 30px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
}

.clearance-item {
  display: flex;
  align-items: center;
  padding: 15px;
  border-bottom: 1px solid #f4e9ea;
  transition: background-color 0.3s ease;
}

.clearance-item:last-child {
  border-bottom: none;
}

.clearance-item:hover {
  background-color: #f9f1f2;
}

.clearance-checkbox {
  flex: 0 0 24px;
  margin-right: 15px;
}

.custom-checkbox {
  display: block;
  position: relative;
  cursor: pointer;
  user-select: none;
  width: 24px;
  height: 24px;
}

.custom-checkbox input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 24px;
  width: 24px;
  background-color: #f4e9ea;
  border: 2px solid #bd8c91;
  border-radius: 4px;
  transition: all 0.3s ease;
}

.custom-checkbox:hover input ~ .checkmark {
  background-color: #efd9db;
}

.custom-checkbox input:checked ~ .checkmark {
  background-color: #7a222b;
  border-color: #7a222b;
}

.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

.custom-checkbox input:checked ~ .checkmark:after {
  display: block;
  left: 8px;
  top: 4px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 2px 2px 0;
  transform: rotate(45deg);
}

.clearance-details {
  flex-grow: 1;
}

.clearance-title {
  font-weight: 600;
  color: #5a1a20;
  margin-bottom: 5px;
}

.clearance-description {
  font-size: 14px;
  color: #666;
}

.clearance-status {
  flex: 0 0 100px;
  text-align: center;
  font-weight: 600;
  font-size: 14px;
  border-radius: 20px;
  padding: 5px 10px;
}

.status-pending {
  color: #c17017;
  background-color: #fff3e0;
}

.status-cleared {
  color: #2e7d32;
  background-color: #e8f5e9;
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

/* Submission Section */
.submission-section {
  margin-top: 30px;
  text-align: center;
}

.submission-message {
  margin-bottom: 20px;
  padding: 15px;
  border-radius: 5px;
  background-color: #e8f5e9;
  border-left: 4px solid #2e7d32;
  display: none;
}

.submission-message.error {
  background-color: #ffebee;
  border-left-color: #c62828;
}

/* Submit Button */
button[type="submit"], 
button[type="button"] {
  display: block;
  width: 200px;
  margin: 30px auto;
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

button[type="submit"]:hover, 
button[type="button"]:hover {
  background-color: #5a1a20;
  transform: translateY(-2px);
  box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
}

button[type="submit"]:active, 
button[type="button"]:active {
  transform: translateY(1px);
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

button[disabled] {
  background-color: #d1a1a6;
  cursor: not-allowed;
  transform: none;
}

.back-button {
  background-color: #bd8c91 !important;
}

.back-button:hover {
  background-color: #a27a7e !important;
}

.button-group {
  display: flex;
  justify-content: space-between;
  margin-top: 30px;
  padding: 0 20px;
}

.button-group button {
  margin: 0;
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
  
  .button-group {
    flex-direction: column;
    gap: 15px;
    padding: 0;
  }
  
  .button-group button {
    width: 100%;
    margin: 0;
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
  
  .clearance-item {
    flex-direction: column;
    align-items: flex-start;
  }
  
  .clearance-checkbox {
    margin-bottom: 10px;
  }
  
  .clearance-status {
    margin-top: 10px;
    align-self: flex-start;
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
    font-size: 14px;
  }
  
  label {
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
}
  </style>
</head>
<body>
    <div class="enrollment-form">
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
            <div class="progress-bar step-3">
                <div class="progress-step completed">
                    <div class="step-circle">1</div>
                    <div class="step-title">Pre-Registration</div>
                </div>
                <div class="progress-step completed">
                    <div class="step-circle">2</div>
                    <div class="step-title">Payment</div>
                </div>
                <div class="progress-step active">
                    <div class="step-circle">3</div>
                    <div class="step-title">Clearances</div>
                </div>
                <div class="progress-step">
                    <div class="step-circle">4</div>
                    <div class="step-title">Confirmation</div>
                </div>
            </div>
        </div>
  
        <form id="clearanceForm" action="#" method="post">
            <h2>STEP 3. CLEARANCES</h2>
            
            <div class="message-section">
                <div class="message-title">
                    <div class="icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12 16V12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12 8H12.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    CLEARANCE VERIFICATION
                </div>
                <div class="message-content">
                    <p>Complete the clearance checklist below. Your enrollment will only be finalized once all required clearances are verified by the Registrar.</p>
                    <p> <span class="highlight">All clearances must be completed before proceeding to the Confirmation step.</span></p>
                </div>
            </div>
            
            <div class="clearance-container">
                <!-- Registrar's Office -->
                <div class="clearance-item">
                    <div class="clearance-checkbox">
                        <label class="custom-checkbox">
                            <input type="checkbox" name="registrar" id="registrar" required>
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="clearance-details">
                        <div class="clearance-title">Registrar's Office</div>
                        <div class="clearance-description">Academic records, Form 137/138, birth certificate, and other required documents</div>
                    </div>
                    <div class="clearance-status status-pending" id="registrarStatus">Pending</div>
                </div>
                
                <!-- Accounting -->
                <div class="clearance-item">
                    <div class="clearance-checkbox">
                        <label class="custom-checkbox">
                            <input type="checkbox" name="accounting" id="accounting" required>
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="clearance-details">
                        <div class="clearance-title">Accounting</div>
                        <div class="clearance-description">Outstanding balance from previous year, enrollment fee verification</div>
                    </div>
                    <div class="clearance-status status-pending" id="accountingStatus">Pending</div>
                </div>
                
                <!-- Library -->
                <div class="clearance-item">
                    <div class="clearance-checkbox">
                        <label class="custom-checkbox">
                            <input type="checkbox" name="library" id="library" required>
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="clearance-details">
                        <div class="clearance-title">Library</div>
                        <div class="clearance-description">Borrowed books, unpaid penalties, library ID clearance</div>
                    </div>
                    <div class="clearance-status status-pending" id="libraryStatus">Pending</div>
                </div>
                
                <!-- Guidance Office -->
                <div class="clearance-item">
                    <div class="clearance-checkbox">
                        <label class="custom-checkbox">
                            <input type="checkbox" name="guidance" id="guidance">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="clearance-details">
                        <div class="clearance-title">Guidance Office (if applicable)</div>
                        <div class="clearance-description">Counseling records, special assessment requirements</div>
                    </div>
                    <div class="clearance-status status-pending" id="guidanceStatus">Pending</div>
                </div>
                
                <!-- Discipline Office -->
                <div class="clearance-item">
                    <div class="clearance-checkbox">
                        <label class="custom-checkbox">
                            <input type="checkbox" name="discipline" id="discipline" required>
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="clearance-details">
                        <div class="clearance-title">Discipline / Student Affairs Office</div>
                        <div class="clearance-description">Behavioral record, compliance with school regulations</div>
                    </div>
                    <div class="clearance-status status-pending" id="disciplineStatus">Pending</div>
                </div>
            </div>
            
            <div class="submission-section">
                <div class="submission-message" id="submissionMessage">
                    All clearances have been verified. You may proceed to the final step.
                </div>
            </div>
            
            <div class="button-group">
                <button type="button" class="back-button" onclick="window.location.href='{{ url()->previous() }}'">Back</button>
                <button type="submit" id="nextButton" disabled>Next</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Set progress indicator to step 3
            setProgress(3);
            
            const form = document.getElementById('clearanceForm');
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            const nextButton = document.getElementById('nextButton');
            const submissionMessage = document.getElementById('submissionMessage');
            
            // Add event listeners to all checkboxes
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    // Update the status indicator when checkbox is checked
                    const statusElement = document.getElementById(this.id + 'Status');
                    
                    if (this.checked) {
                        statusElement.textContent = 'Cleared';
                        statusElement.classList.remove('status-pending');
                        statusElement.classList.add('status-cleared');
                    } else {
                        statusElement.textContent = 'Pending';
                        statusElement.classList.remove('status-cleared');
                        statusElement.classList.add('status-pending');
                    }
                    
                    // Check if all required clearances are completed
                    checkAllClearances();
                });
            });
            
            // Form submission handler
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                if (areAllRequiredCheckboxesChecked()) {
                    // Simulate form submission success
                    submissionMessage.style.display = 'block';
                    submissionMessage.textContent = 'All clearances have been verified. Proceeding to final step...';
                    submissionMessage.classList.remove('error');
                    
                    // Redirect to confirmation page after a short delay
                    setTimeout(() => {
                        window.location.href =  '{{ route('enroll.old.step4') }}';
                    }, 1500);
                } else {
                    // Show error message
                    submissionMessage.style.display = 'block';
                    submissionMessage.textContent = 'Please complete all required clearances before proceeding.';
                    submissionMessage.classList.add('error');
                }
            });
            
            // Check if all required checkboxes are checked
            function areAllRequiredCheckboxesChecked() {
                const requiredCheckboxes = document.querySelectorAll('input[type="checkbox"][required]');
                return Array.from(requiredCheckboxes).every(checkbox => checkbox.checked);
            }
            
            // Enable/disable the Next button based on clearance status
            function checkAllClearances() {
                if (areAllRequiredCheckboxesChecked()) {
                    nextButton.disabled = false;
                } else {
                    nextButton.disabled = true;
                }
            }
            
            // Set progress indicator
            function setProgress(stepNumber) {
                const progressBar = document.querySelector('.progress-bar');
                progressBar.classList.remove('step-1', 'step-2', 'step-3', 'step-4');
                progressBar.classList.add(`step-${stepNumber}`);
            }
            
            // Simulate some clearances being pre-filled (you can remove this for production)
            // This is just for demonstration purposes
            setTimeout(() => {
                // Simulate accounting being automatically cleared (e.g., from payment step)
                const accountingCheckbox = document.getElementById('accounting');
                if (accountingCheckbox) {
                    accountingCheckbox.checked = true;
                    accountingCheckbox.dispatchEvent(new Event('change'));
                }
            }, 1000);
        });
    </script>
</body>
</html>