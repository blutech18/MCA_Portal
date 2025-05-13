<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MCA Montessori School Payment - Existing Students</title>
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

/* Payment Layout */
.payment-container {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  margin-bottom: 30px;
}

.payment-section {
  flex: 1;
  min-width: 300px;
  background-color: #fff;
  border: 1px solid #bd8c91;
  border-radius: 8px;
  padding: 20px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
}

.qr-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 20px 0;
}

.qr-code {
  width: 200px;
  height: 200px;
  border: 1px solid #bd8c91;
  border-radius: 5px;
  margin-bottom: 20px;
}

.payment-info {
  text-align: center;
  margin-top: 10px;
}

.payment-info div {
  margin-bottom: 10px;
}

.payment-info .label {
  font-weight: 600;
  color: #5a1a20;
}

/* Upload Payment Receipt */
.upload-section {
  padding: 20px;
}

.form-group {
  margin-bottom: 20px;
}

.form-group label {
  display: block;
  margin-bottom: 5px;
  font-weight: 500;
  color: #5a1a20;
}

.form-control {
  width: 100%;
  padding: 10px;
  border: 1px solid #bd8c91;
  border-radius: 4px;
  font-size: 14px;
}

.form-control:focus {
  border-color: #7a222b;
  outline: none;
  box-shadow: 0 0 0 2px rgba(122, 34, 43, 0.2);
}

.form-control.is-invalid {
  border-color: #9a3a44;
}

.validation-message {
  color: #9a3a44;
  font-size: 14px;
  margin-top: 5px;
  display: none;
  font-weight: 500;
}

/* Receipt Upload Styling */
.receipt-upload-container {
  border: 2px dashed #bd8c91;
  border-radius: 8px;
  padding: 30px 20px;
  text-align: center;
  position: relative;
  margin-top: 10px;
  background-color: #f9f1f2;
  cursor: pointer;
  transition: all 0.3s ease;
}

.receipt-upload-container:hover {
  background-color: #f4e9ea;
  border-color: #7a222b;
}

.receipt-upload-container .file-icon {
  font-size: 40px;
  color: #7a222b;
  margin-bottom: 15px;
}

.receipt-upload-container p {
  margin: 0;
  color: #5a1a20;
}

.receipt-upload-container small {
  display: block;
  color: #7a222b;
  margin-top: 10px;
}

.receipt-upload-container input[type="file"] {
  position: absolute;
  left: 0;
  top: 0;
  opacity: 0;
  width: 100%;
  height: 100%;
  cursor: pointer;
}

.receipt-preview {
  margin-top: 15px;
  text-align: center;
  display: none;
}

.receipt-preview img {
  max-width: 100%;
  max-height: 200px;
  border: 1px solid #bd8c91;
  border-radius: 5px;
  margin-bottom: 10px;
}

.receipt-filename {
  font-weight: 500;
  color: #5a1a20;
  margin-bottom: 10px;
  word-break: break-all;
}

.remove-receipt {
  color: #9a3a44;
  cursor: pointer;
  font-weight: 500;
  display: inline-block;
  padding: 5px 10px;
  border: 1px solid #9a3a44;
  border-radius: 4px;
  transition: all 0.3s ease;
}

.remove-receipt:hover {
  background-color: #9a3a44;
  color: #fff;
}

/* Reminder Section */
.reminder-section {
  background-color: #f9f1f2;
  border-left: 4px solid #7a222b;
  padding: 15px;
  margin: 20px 0;
  border-radius: 5px;
}

.reminder-title {
  display: flex;
  align-items: center;
  font-weight: 600;
  margin-bottom: 10px;
  color: #5a1a20;
}

.reminder-title .icon {
  margin-right: 10px;
  color: #7a222b;
}

.reminder-list {
  list-style-type: disc;
  padding-left: 20px;
}

.reminder-list li {
  margin-bottom: 8px;
}

.highlight {
  font-weight: 600;
  color: #7a222b;
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
  
  .payment-container {
    flex-direction: column;
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
            <div class="progress-bar step-2">
                <div class="progress-step completed">
                    <div class="step-circle">1</div>
                    <div class="step-title">Pre-Registration</div>
                </div>
                <div class="progress-step active">
                    <div class="step-circle">2</div>
                    <div class="step-title">Payment</div>
                </div>
                <div class="progress-step">
                    <div class="step-circle">3</div>
                    <div class="step-title">Clearances</div>
                </div>
                <div class="progress-step">
                    <div class="step-circle">4</div>
                    <div class="step-title">Confirmation</div>
                </div>
            </div>
        </div>
  
        <form id="paymentForm"
              action="{{ route('enroll.old.step2.post') }}"
              method="POST"
              enctype="multipart/form-data">
          @csrf
            <h2>STEP 2. PAYMENT</h2>
            
            
            <div class="payment-container">
               
                <div class="payment-section">
                    <h4 style="text-align: center; margin-bottom: 15px;">Scan to Pay Enrollment Fee</h4>
                    <div class="qr-container">
                        <img src="{{asset ('images/qr.png')}}" alt="Payment QR Code" class="qr-code">
                    </div>
                    <div class="payment-info">
                        <div>
                            <span class="label">Account Name:</span> 
                            <span>MCAMs</span>
                        </div>
                        <div>
                            <span class="label">Amount:</span> 
                            <span>PHP 1,000.00</span>
                        </div>
                    </div>
                </div>
                
                
                <div class="payment-section">
                    <h4 style="text-align: center; margin-bottom: 15px;">Upload Payment Receipt</h4>
                    <div class="upload-section">
                        <div class="form-group">
                            <label for="studentId">Student ID <span class="required-mark">*Required</span></label>
                            <input type="text" 
                                  id="studentId" 
                                  name="studentId" 
                                  class="form-control" 
                                  value="{{ old('studentId', $enrollee->student_id) }}"
                                  required>
                            <div class="validation-message" id="studentIdValidation">Please enter your student ID</div>
                        </div>
                        
                        <div class="form-group">
                            <label for="fullName">Full Name <span class="required-mark">*Required</span></label>
                            <input type="text" 
                                  id="fullName" 
                                  name="fullName" 
                                  class="form-control" 
                                  value="{{ old('fullName', $enrollee->surname . ', ' . $enrollee->given_name) }}" 
                                  required>
                            <div class="validation-message" id="fullNameValidation">Please enter your full name</div>
                        </div>
                        
                        <div class="form-group">
                            <label for="paymentRef">Payment Reference Number <span class="required-mark">*Required</span></label>
                            <input type="text" id="paymentRef" name="paymentRef" class="form-control" placeholder="Enter payment reference number" required>
                            <div class="validation-message" id="paymentRefValidation">Please enter the payment reference number</div>
                        </div>
                        
                        <div class="form-group">
                            <label for="receiptUpload">Payment Receipt <span class="required-mark">*Required</span></label>
                            <div class="receipt-upload-container">
                                <div class="file-icon">
                                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14 2H6C4.89543 2 4 2.89543 4 4V20C4 21.1046 4.89543 22 6 22H18C19.1046 22 20 21.1046 20 20V8L14 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M14 2V8H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M12 18V12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M9 15L12 12L15 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <p>Choose file or drag here</p>
                                <small>Supported formats: JPG, PNG, PDF</small>
                                <input type="file" id="receiptUpload" name="receiptUpload" accept=".jpg,.jpeg,.png,.pdf" required>
                            </div>
                            <div class="validation-message" id="receiptValidation">Please upload your payment receipt</div>
                            <div class="receipt-preview" id="receiptPreview"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            
            <div class="reminder-section">
                <div class="reminder-title">
                    <div class="icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12 8V12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12 16H12.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    IMPORTANT REMINDER
                </div>
                <p>Please take note of the following enrollment payment instructions for existing students:</p> <br>
                <ul class="reminder-list">
                    <li>Your enrollment renewal will <span class="highlight">only be processed</span> once the enrollment fee has been paid and verified.</li>
                    <li>Make sure to enter your correct <span class="highlight">Student ID</span> as it appears on your school records.</li>
                    <li>You must <span class="highlight">save the payment reference number</span> from your GCash/payment transaction and enter it in the form above.</li>
                    <li>After payment verification, you will be directed to complete any necessary clearances.</li>
                    <li>Students with outstanding balances from the previous year must settle them before proceeding with enrollment.</li>
                    <li>For any payment issues or balance inquiries, please contact our Accounting Office at <span class="highlight">adminoffice@mcams.edu.ph</span></li>
                </ul>
            </div>
            
            <div class="button-group">
                <button type="button" class="back-button" onclick="window.location.href='{{ url()->previous() }}'">Back</button>
                <button type="submit" id="nextButton" disabled>Next</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            setProgress(2);
            
            const form = document.getElementById('paymentForm');
            const studentIdInput = document.getElementById('studentId');
            const fullNameInput = document.getElementById('fullName');
            const paymentRefInput = document.getElementById('paymentRef');
            const receiptInput = document.getElementById('receiptUpload');
            const nextButton = document.getElementById('nextButton');
            
            // Student ID validation
            studentIdInput.addEventListener('input', function() {
                const validationMessage = document.getElementById('studentIdValidation');
                if (this.value.trim() === '') {
                    validationMessage.style.display = 'block';
                    this.classList.add('is-invalid');
                } else {
                    validationMessage.style.display = 'none';
                    this.classList.remove('is-invalid');
                }
                checkAllFieldsFilled();
            });
            
            // Full name validation
            fullNameInput.addEventListener('input', function() {
                const validationMessage = document.getElementById('fullNameValidation');
                if (this.value.trim() === '') {
                    validationMessage.style.display = 'block';
                    this.classList.add('is-invalid');
                } else {
                    validationMessage.style.display = 'none';
                    this.classList.remove('is-invalid');
                }
                checkAllFieldsFilled();
            });
            
            // Payment reference validation
            paymentRefInput.addEventListener('input', function() {
                const validationMessage = document.getElementById('paymentRefValidation');
                if (this.value.trim() === '') {
                    validationMessage.style.display = 'block';
                    this.classList.add('is-invalid');
                } else {
                    validationMessage.style.display = 'none';
                    this.classList.remove('is-invalid');
                }
                checkAllFieldsFilled();
            });
            
            // Receipt upload validation
            receiptInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                const previewContainer = document.getElementById('receiptPreview');
                const validationMessage = document.getElementById('receiptValidation');
                
                if (file) {
                    validationMessage.style.display = 'none';
                    previewContainer.style.display = 'block';
                    previewContainer.innerHTML = '';
                    
                    const fileExtension = file.name.split('.').pop().toLowerCase();
                    
                    if (['jpg', 'jpeg', 'png'].includes(fileExtension)) {
                        // Create image preview
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            const img = document.createElement('img');
                            img.src = event.target.result;
                            previewContainer.appendChild(img);
                            
                            // Add filename and remove button
                            addFileDetails(previewContainer, file.name);
                        };
                        reader.readAsDataURL(file);
                    } else if (fileExtension === 'pdf') {
                        // PDF Document preview
                        const pdfIcon = document.createElement('div');
                        pdfIcon.innerHTML = '<svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14 2H6C4.89543 2 4 2.89543 4 4V20C4 21.1046 4.89543 22 6 22H18C19.1046 22 20 21.1046 20 20V8L14 2Z" stroke="#7a222b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M14 2V8H20" stroke="#7a222b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 10V18" stroke="#7a222b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M16 14H8" stroke="#7a222b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
                        previewContainer.appendChild(pdfIcon);
                        
                        // Add filename and remove button
                        addFileDetails(previewContainer, file.name);
                    }
                } else {
                    validationMessage.style.display = 'block';
                    previewContainer.style.display = 'none';
                    previewContainer.innerHTML = '';
                }
                
                checkAllFieldsFilled();
            });
            
            // Handle form submission
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                if (checkAllFieldsFilled()) {
                  alert('All documents uploaded successfully! Proceeding to payment page.');
                  this.submit(); 
                }
            });
            
            // Setup drag and drop for receipt upload
            const uploadContainer = document.querySelector('.receipt-upload-container');
            
            uploadContainer.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.style.backgroundColor = '#efd9db';
                this.style.borderColor = '#7a222b';
            });
            
            uploadContainer.addEventListener('dragleave', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.style.backgroundColor = '#f9f1f2';
                this.style.borderColor = '#bd8c91';
            });
            
            uploadContainer.addEventListener('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.style.backgroundColor = '#f9f1f2';
                this.style.borderColor = '#bd8c91';
                
                const dt = e.dataTransfer;
                const files = dt.files;
                
                if (files.length) {
                    receiptInput.files = files;
                    // Trigger change event
                    const event = new Event('change', { bubbles: true });
                    receiptInput.dispatchEvent(event);
                }
            });
            
            // Helper function to add file details after preview
            function addFileDetails(container, fileName) {
                // Add filename
                const fileNameDiv = document.createElement('div');
                fileNameDiv.className = 'receipt-filename';
                fileNameDiv.textContent = fileName;
                container.appendChild(fileNameDiv);
                
                                // Add remove button
                const removeBtn = document.createElement('div');
                removeBtn.className = 'remove-receipt';
                removeBtn.textContent = 'Remove';

                removeBtn.addEventListener('click', () => {
                    receiptInput.value = ''; // Clear the file input
                    container.innerHTML = '';
                    container.style.display = 'none';
                    checkAllFieldsFilled();
                });

                container.appendChild(removeBtn);
            }

            // Check if all fields are filled to enable the "Next" button
            function checkAllFieldsFilled() {
                const isStudentIdFilled = studentIdInput.value.trim() !== '';
                const isFullNameFilled = fullNameInput.value.trim() !== '';
                const isPaymentRefFilled = paymentRefInput.value.trim() !== '';
                const isReceiptUploaded = receiptInput.files.length > 0;

                const allValid = isStudentIdFilled && isFullNameFilled && isPaymentRefFilled && isReceiptUploaded;
                nextButton.disabled = !allValid;

                return allValid;
            }

            // Set progress indicator
            function setProgress(stepNumber) {
                const progressBar = document.querySelector('.progress-bar');
                progressBar.classList.remove('step-1', 'step-2', 'step-3', 'step-4');
                progressBar.classList.add(`step-${stepNumber}`);
            }

        }); // DOMContentLoaded
    </script>
</body>
</html>
