<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MCA Montessori School Payment</title>
  <link rel="stylesheet" href="{{ asset('css/mobile-compatibility.css') }}">
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

/* Payment Method Selection */
.payment-method-section {
  background-color: #fff;
  border: 1px solid #bd8c91;
  border-radius: 8px;
  padding: 20px;
  margin-bottom: 20px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
}

.payment-method-options {
  display: flex;
  gap: 30px;
  justify-content: center;
  flex-wrap: wrap;
}

.payment-option {
  display: flex;
  align-items: center;
  gap: 8px;
}

.payment-option input[type="radio"] {
  margin: 0;
  transform: scale(1.2);
}

.payment-option label {
  font-weight: 500;
  color: #5a1a20;
  cursor: pointer;
  margin: 0;
}

/* Cash Payment Styles */
.cash-payment-info {
  padding: 20px 0;
}

.cash-instructions {
  margin-top: 20px;
  padding: 15px;
  background-color: #f9f1f2;
  border-radius: 5px;
  border-left: 4px solid #7a222b;
}

.cash-instructions p {
  margin-bottom: 10px;
  color: #5a1a20;
  font-weight: 600;
}

.cash-instructions ul {
  margin: 0;
  padding-left: 20px;
}

.cash-instructions li {
  margin-bottom: 8px;
  color: #5a1a20;
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

.readonly-field {
  background-color: #f8f9fa;
  color: #6c757d;
  cursor: not-allowed;
}

.form-text {
  font-size: 12px;
  margin-top: 2px;
}

.text-muted {
  color: #6c757d !important;
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
                <p>ONLINE ENROLLMENT FORM</p>
            </div>
        </div>
        
        
        <div class="progress-container">
            <div class="progress-bar step-3">
                <div class="progress-step completed">
                    <div class="step-circle">1</div>
                    <div class="step-title">Fill Out the Form</div>
                </div>
                <div class="progress-step completed">
                    <div class="step-circle">2</div>
                    <div class="step-title">Document Upload</div>
                </div>
                <div class="progress-step active">
                    <div class="step-circle">3</div>
                    <div class="step-title">Payment</div>
                </div>
                <div class="progress-step">
                    <div class="step-circle">4</div>
                    <div class="step-title">Confirmation</div>
                </div>
            </div>
        </div>
  
        <form id="paymentForm"
              action="{{ route('enroll.new.step3.post') }}"
              method="POST"
              enctype="multipart/form-data">
          @csrf
            <h2>STEP 3. PAYMENT</h2>
            
            <!-- Payment Method Selection -->
            <div class="payment-method-section">
                <h3>Select Payment Method</h3>
                <div class="payment-method-options">
                    <div class="payment-option">
                        <input type="radio" id="digitalPayment" name="paymentMethod" value="digital" checked>
                        <label for="digitalPayment">Digital Payment (GCash, PayMaya, etc.)</label>
                    </div>
                    <div class="payment-option">
                        <input type="radio" id="cashPayment" name="paymentMethod" value="cash">
                        <label for="cashPayment">Pay in Cash</label>
                    </div>
                </div>
            </div>
            
            <div class="payment-container">
               
                <div class="payment-section" id="digitalPaymentSection">
                    <h4 style="text-align: center; margin-bottom: 15px;">Scan to Pay Reservation Fee</h4>
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
                            <span>{{ $currentFee->formatted_amount }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="payment-section" id="cashPaymentSection" style="display: none;">
                    <h4 style="text-align: center; margin-bottom: 15px;">Cash Payment Information</h4>
                    <div class="cash-payment-info">
                        <div class="payment-info">
                            <div>
                                <span class="label">Payment Method:</span> 
                                <span>Cash Payment</span>
                            </div>
                            <div>
                                <span class="label">Amount:</span> 
                                <span>{{ $currentFee->formatted_amount }}</span>
                            </div>
                            <div>
                                <span class="label">Location:</span> 
                                <span>MCA Montessori School Office</span>
                            </div>
                        </div>
                        <div class="cash-instructions">
                            <p><strong>Instructions:</strong></p>
                            <ul>
                                <li>Visit the school office during business hours</li>
                                <li>Bring exact amount: {{ $currentFee->formatted_amount }}</li>
                                <li>Request for official receipt</li>
                                <li>Keep the receipt for your records</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="payment-section" id="uploadSection">
                    <h4 style="text-align: center; margin-bottom: 15px;">Upload Payment Receipt</h4>
                    <div class="upload-section">
                        <div class="form-group" id="fullNameGroup">
                            <label for="fullName">Full Name of Applicant <span class="required-mark"></span></label>
                            <input type="text" id="fullName" name="fullName" class="form-control readonly-field" placeholder="Enter full name (Legacy)" value="{{ $enrollee->display_name }}" readonly required>
                            <small class="form-text text-muted">Name automatically populated from enrollment form</small>
                            <div class="validation-message" id="fullNameValidation">Please enter the applicant's full name</div>
                        </div>
                        
                        <div class="form-group" id="paymentRefGroup">
                            <label for="paymentRef">Payment Reference Number <span class="required-mark"></span></label>
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
                <p>Please take note of the following enrollment payment instructions for new applicants:</p> <br>
                <ul class="reminder-list">
                    <li>Your enrollment application will <span class="highlight">only be processed</span> once the reservation fee has been paid and verified.</li>
                    <li>Make sure to <span class="highlight">save the payment reference number</span> from your GCash/payment transaction and enter it in the form above.</li>
                    <li>Enter your <span class="highlight">complete name</span> exactly as submitted in your application form.</li>
                    <li>After payment, upload your receipt and wait for confirmation via email within 1-2 business days.</li>
                    <li>Upon confirmation, you will receive your official Student ID and enrollment details.</li>
                    <li>For any payment issues, please contact our Admissions Office at <span class="highlight">adminoffice@mcams.edu.ph</span></li>
                </ul>
            </div>
            
            <div class="button-group">
                <button type="button" class="back-button" onclick="handleBackButton()">Back</button>
                <button type="submit" id="nextButton" disabled>Next</button>
            </div>
        </form>
    </div>

    <!-- Mobile Compatibility Script -->
    <script src="{{ asset('js/mobile-compatibility.js') }}"></script>
    
    <script>
        // File caching functions for Step 3
        function cacheFileData(inputId, file) {
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const fileData = {
                        name: file.name,
                        type: file.type,
                        size: file.size,
                        data: e.target.result,
                        lastModified: file.lastModified
                    };
                    localStorage.setItem(`new_step3_${inputId}`, JSON.stringify(fileData));
                    console.log(`Cached file data for ${inputId}:`, file.name);
                };
                reader.readAsDataURL(file);
            }
        }

        function restoreCachedFiles() {
            console.log('restoreCachedFiles() disabled by design - no restoration attempted');
            return 0;
        }

        function clearCachedFiles() {
            localStorage.removeItem(`new_step3_receiptUpload`);
            localStorage.removeItem('new_step3_form_data');
            localStorage.removeItem('new_step3_payment_method');
            // Clear ALL local storage
            localStorage.clear();
            console.log('Cleared ALL cached data including localStorage');
        }

        function showFilePreview(inputId, fileData) {
            const previewContainer = document.getElementById(`${inputId}Preview`);
            const validationMessage = document.getElementById(`${inputId}Validation`);
            
            if (previewContainer && validationMessage) {
                validationMessage.style.display = 'none';
                previewContainer.style.display = 'block';
                previewContainer.innerHTML = '';
                
                const fileExtension = fileData.name.split('.').pop().toLowerCase();
                
                if (['jpg', 'jpeg', 'png'].includes(fileExtension)) {
                    // Create image preview
                    const img = document.createElement('img');
                    img.src = fileData.data;
                    previewContainer.appendChild(img);
                } else {
                    // Document preview (PDF or other)
                    const docPreview = document.createElement('div');
                    docPreview.className = 'document-preview';
                    
                    const docIcon = document.createElement('div');
                    docIcon.className = 'doc-icon';
                    docIcon.innerHTML = '📄';
                    
                    const docName = document.createElement('div');
                    docName.className = 'doc-name';
                    docName.textContent = fileData.name;
                    
                    docPreview.appendChild(docIcon);
                    docPreview.appendChild(docName);
                    previewContainer.appendChild(docPreview);
                }
                
                // Add remove button
                const removeBtn = document.createElement('div');
                removeBtn.className = 'remove-receipt';
                removeBtn.textContent = 'Remove';
                removeBtn.addEventListener('click', function() {
                    const input = document.getElementById(inputId);
                    input.value = '';
                    previewContainer.style.display = 'none';
                    previewContainer.innerHTML = '';
                    validationMessage.style.display = 'block';
                    
                    // Clear cached file data
                    localStorage.removeItem(`new_step3_${inputId}`);
                    
                    checkAllFieldsFilled();
                });
                previewContainer.appendChild(removeBtn);
                
                console.log(`File preview displayed for ${inputId}: ${fileData.name}`);
            }
        }

        // Form data caching functions
        function cacheFormData() {
            const formData = {
                fullName: document.getElementById('fullName').value,
                paymentRef: document.getElementById('paymentRef').value
            };
            localStorage.setItem('new_step3_form_data', JSON.stringify(formData));
            console.log('Cached form data for Step 3:', formData);
        }

        function restoreCachedFormData() {
            console.log('restoreCachedFormData() disabled by design - no restoration attempted');
            return false;
        }

        function clearCachedData() {
            clearCachedFiles();
            localStorage.removeItem('new_step3_form_data');
            console.log('Cleared all cached data for Step 3');
        }

        // Global handleBackButton function
        window.handleBackButton = function() {
            // Check if there's a previous page in history
            if (window.history.length > 1) {
                window.history.back();
            } else {
                // Fallback to route navigation
                window.location.href = '{{ route('enroll.new.step2') }}';
            }
        };

        // Global function to check if all required fields are filled
        function checkAllFieldsFilled() {
            const digitalPaymentRadio = document.getElementById('digitalPayment');
            const cashPaymentRadio = document.getElementById('cashPayment');
            const fullNameInput = document.getElementById('fullName');
            const paymentRefInput = document.getElementById('paymentRef');
            const receiptInput = document.getElementById('receiptUpload');
            const nextButton = document.getElementById('nextButton');
            
            const isDigitalPayment = digitalPaymentRadio && digitalPaymentRadio.checked;
            
            const nameValid = isDigitalPayment ? 
                (fullNameInput && fullNameInput.value.trim() !== '') : 
                true; // Not required for cash payment
            const refValid = isDigitalPayment ? 
                (paymentRefInput && paymentRefInput.value.trim() !== '') : 
                true; // Not required for cash payment
            const receiptValid = receiptInput && receiptInput.files && receiptInput.files.length > 0;

            const allValid = nameValid && refValid && receiptValid;

            if (nextButton) {
                nextButton.disabled = !allValid;
            }
            return allValid;
        }

        document.addEventListener('DOMContentLoaded', function() {
            
            setProgress(3);
            
            const form = document.getElementById('paymentForm');
            const fullNameInput = document.getElementById('fullName');
            const paymentRefInput = document.getElementById('paymentRef');
            const receiptInput = document.getElementById('receiptUpload');
            const nextButton = document.getElementById('nextButton');
            
            // Payment method selection
            const digitalPaymentRadio = document.getElementById('digitalPayment');
            const cashPaymentRadio = document.getElementById('cashPayment');
            const digitalPaymentSection = document.getElementById('digitalPaymentSection');
            const cashPaymentSection = document.getElementById('cashPaymentSection');
            const fullNameGroup = document.getElementById('fullNameGroup');
            const paymentRefGroup = document.getElementById('paymentRefGroup');
            
            function updatePaymentMethodVisibility() {
                const isDigitalPayment = digitalPaymentRadio.checked;
                const isCashPayment = cashPaymentRadio.checked;
                
                // Show/hide payment sections
                if (digitalPaymentSection) {
                    digitalPaymentSection.style.display = isDigitalPayment ? 'block' : 'none';
                }
                if (cashPaymentSection) {
                    cashPaymentSection.style.display = isCashPayment ? 'block' : 'none';
                }
                
                // Show/hide form fields based on payment method
                if (fullNameGroup) {
                    fullNameGroup.style.display = isDigitalPayment ? 'block' : 'none';
                    fullNameInput.required = isDigitalPayment;
                    // Don't clear the readonly field value
                    // if (!isDigitalPayment) {
                    //     fullNameInput.value = '';
                    // }
                }
                
                if (paymentRefGroup) {
                    paymentRefGroup.style.display = isDigitalPayment ? 'block' : 'none';
                    paymentRefInput.required = isDigitalPayment;
                    if (!isDigitalPayment) {
                        paymentRefInput.value = '';
                    }
                }
                
                // Update validation
                checkAllFieldsFilled();
            }
            
            // Add event listeners for payment method selection
            if (digitalPaymentRadio) {
                digitalPaymentRadio.addEventListener('change', updatePaymentMethodVisibility);
            }
            if (cashPaymentRadio) {
                cashPaymentRadio.addEventListener('change', updatePaymentMethodVisibility);
            }
            
            // Initialize payment method visibility
            updatePaymentMethodVisibility();
            
            
            fullNameInput.addEventListener('input', function() {
                const validationMessage = document.getElementById('fullNameValidation');
                if (this.value.trim() === '') {
                    validationMessage.style.display = 'block';
                    this.classList.add('is-invalid');
                } else {
                    validationMessage.style.display = 'none';
                    this.classList.remove('is-invalid');
                }
                // Cache form data
                cacheFormData();
                checkAllFieldsFilled();
            });
            
            
            paymentRefInput.addEventListener('input', function() {
                const validationMessage = document.getElementById('paymentRefValidation');
                if (this.value.trim() === '') {
                    validationMessage.style.display = 'block';
                    this.classList.add('is-invalid');
                } else {
                    validationMessage.style.display = 'none';
                    this.classList.remove('is-invalid');
                }
                // Cache form data
                cacheFormData();
                checkAllFieldsFilled();
            });
            
            
            receiptInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                const previewContainer = document.getElementById('receiptPreview');
                const validationMessage = document.getElementById('receiptValidation');
                
                // Cache the file data
                if (file) {
                    cacheFileData('receiptUpload', file);
                }
                
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
                
                const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked')?.value;
                console.log('Attempting form submission:', {
                  paymentMethod: paymentMethod,
                  allValid: checkAllFieldsFilled(),
                  formAction: this.action
                });
                
                if (checkAllFieldsFilled()) {
                  alert(`Payment pending verification for ${paymentMethod} payment. Your application will be processed once payment is confirmed. Proceeding to confirmation page.`);
                  this.submit();   // actually POSTs the form now
                } else {
                  alert('Please fill in all required fields before submitting.');
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
                removeBtn.addEventListener('click', function() {
                    receiptInput.value = '';
                    container.style.display = 'none';
                    container.innerHTML = '';
                    document.getElementById('receiptValidation').style.display = 'block';
                    
                    // Clear cached file data
                    localStorage.removeItem(`new_step3_receiptUpload`);
                    
                    checkAllFieldsFilled();
                });
                container.appendChild(removeBtn);
            }
            
            // Helper function to check if all required fields are filled moved to global scope

            // Set progress bar step visually
            function setProgress(step) {
                const progressBar = document.querySelector('.progress-bar');
                progressBar.className = `progress-bar step-${step}`;
            }
            
            // FORCE CLEAR ALL CACHED DATA ON PAGE LOAD
            console.log('Force clearing all cached data on page load...');
            clearCachedFiles();
            
            // Optimized restoration system to prevent flickering
            let restorationInProgress = false;
            
            function performRestoration() {
                console.log('performRestoration() disabled by design - no restoration attempted');
                // Function disabled to prevent interference with form submission
                return;
            }
            
            // Disable automatic restoration to prevent interference
            console.log('Automatic form restoration disabled');
            
            // Disable aggressive caching that interferes with form submission
            console.log('File caching disabled to prevent form submission issues');
            
            // DISABLED: Navigation event listeners (cause form submission interference)
            console.log('Event listener restoration DISABLED by design');
            
            // Clear cached data on successful form submission
            form.addEventListener('submit', function(e) {
                if (checkAllFieldsFilled()) {
                    // Clear cache only after successful validation
                    setTimeout(clearCachedData, 1000);
                }
            });
        });
    </script>
</body>
</html>
