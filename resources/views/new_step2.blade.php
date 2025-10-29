<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MCA Montessori School Document Upload</title>
  <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
  <link rel="icon" href="{{ asset('favicon.ico') }}">
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

/* Form Controls */
div {
  margin-bottom: 15px;
}

label {
  display: inline-block;
  margin-bottom: 5px;
  font-weight: 500;
  color: #5a1a20;
}

/* Document Upload Styling */
.document-upload {
  background-color: #fff;
  border: 1px solid #bd8c91;
  border-radius: 8px;
  padding: 20px;
  margin-bottom: 20px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
}

.upload-group {
  margin-bottom: 25px;
  position: relative;
}

.upload-group label {
  display: block;
  margin-bottom: 8px;
  font-weight: 500;
}

.upload-input-container {
  position: relative;
  display: flex;
  align-items: center;
}

.file-input {
  position: absolute;
  left: 0;
  top: 0;
  opacity: 0;
  width: 100%;
  height: 100%;
  cursor: pointer;
  z-index: 2;
}

.file-upload-btn {
  background-color: #f4e9ea;
  border: 1px dashed #bd8c91;
  border-radius: 4px;
  padding: 12px 20px;
  display: flex;
  align-items: center;
  width: 100%;
  cursor: pointer;
  transition: all 0.3s ease;
}

.file-upload-btn:hover {
  background-color: #efd9db;
  border-color: #7a222b;
}

.file-name {
  margin-left: 10px;
  font-size: 14px;
  color: #666;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  max-width: 70%;
}

.upload-icon {
  margin-right: 10px;
  color: #7a222b;
}

.required-mark {
  color: #9a3a44;
  margin-left: 5px;
  font-style: italic;
}

/* Submit Button */
button[type="submit"], button[type="button"] {
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

button[type="submit"]:hover, button[type="button"]:hover {
  background-color: #5a1a20;
  transform: translateY(-2px);
  box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
}

button[type="submit"]:active, button[type="button"]:active {
  transform: translateY(1px);
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

button[disabled] {
  background-color: #d1a1a6;
  cursor: not-allowed;
  transform: none;
}

.validation-message {
  color: #9a3a44;
  font-size: 14px;
  margin-top: 8px;
  display: none;
  font-weight: 500;
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

/* Preview image style */
.preview-container {
  margin-top: 10px;
  max-width: 100%;
  display: none;
}

.preview-image {
  max-width: 200px;
  max-height: 150px;
  border: 1px solid #bd8c91;
  border-radius: 4px;
  padding: 3px;
}

.preview-document {
  display: flex;
  align-items: center;
  background-color: #f9f1f2;
  padding: 5px 10px;
  border-radius: 4px;
  border: 1px solid #dfc2c5;
  margin-top: 8px;
}

.document-icon {
  margin-right: 10px;
  color: #7a222b;
  font-size: 18px;
}

.document-name {
  font-size: 14px;
  color: #5a1a20;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  max-width: 80%;
}

.remove-file {
  margin-left: auto;
  color: #9a3a44;
  cursor: pointer;
  font-size: 18px;
  padding: 5px;
}

.remove-file:hover {
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
  
  form {
    padding: 10px;
  }
  
  h2 {
    font-size: 20px;
  }
  
  h3 {
    font-size: 16px;
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
                <h2>MCA MONTESORRI SCHOOL</h2>
                <p>ONLINE ENROLLMENT FORM</p>
            </div>
        </div>
        
        <!-- Progress Bar Integration -->
        <div class="progress-container">
            <div class="progress-bar step-2">
                <div class="progress-step completed">
                    <div class="step-circle">1</div>
                    <div class="step-title">Fill Out the Form</div>
                </div>
                <div class="progress-step active">
                    <div class="step-circle">2</div>
                    <div class="step-title">Document Upload</div>
                </div>
                <div class="progress-step">
                    <div class="step-circle">3</div>
                    <div class="step-title">Payment</div>
                </div>
                <div class="progress-step">
                    <div class="step-circle">4</div>
                    <div class="step-title">Confirmation</div>
                </div>
            </div>
        </div>
  
        <form id="documentUploadForm"
              action="{{ route('enroll.new.step2.post') }}"
              method="POST"
              enctype="multipart/form-data">
          @csrf
            <h2>STEP 2. DOCUMENT UPLOAD</h2>
            <p style="text-align: center; margin-bottom: 20px;">Please upload the following required documents</p>
            
            <div class="document-upload">
                <!-- Report Card Upload -->
                <div class="upload-group">
                    <label for="reportCard">Digital copy of report card (Form 138)<span class="required-mark">*Required</span></label>
                    <div class="upload-input-container">
                        <div class="file-upload-btn">
                            <svg class="upload-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11 14.9861C11 15.5384 11.4477 15.9861 12 15.9861C12.5523 15.9861 13 15.5384 13 14.9861V7.82831L16.2428 11.0711L17.657 9.65685L12.0001 4L6.34326 9.65685L7.75748 11.0711L11 7.82854V14.9861Z" fill="#7a222b"/>
                                <path d="M4 14H6V18H18V14H20V18C20 19.1046 19.1046 20 18 20H6C4.89543 20 4 19.1046 4 18V14Z" fill="#7a222b"/>
                            </svg>
                            <span>Choose file or drag here</span>
                            <span class="file-name"></span>
                        </div>
                        <input type="file" id="reportCard" name="reportCard" class="file-input" accept=".pdf,.jpg,.jpeg,.png" required>
                    </div>
                    <div class="validation-message" id="reportCardValidation">Please upload your report card (Form 138)</div>
                    <div class="preview-container" id="reportCardPreview"></div>
                </div>
                
                <!-- Good Moral Upload -->
                <div class="upload-group">
                    <label for="goodMoral">Digital copy of Certificate of Good Moral Character<span class="required-mark">*Required</span></label>
                    <div class="upload-input-container">
                        <div class="file-upload-btn">
                            <svg class="upload-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11 14.9861C11 15.5384 11.4477 15.9861 12 15.9861C12.5523 15.9861 13 15.5384 13 14.9861V7.82831L16.2428 11.0711L17.657 9.65685L12.0001 4L6.34326 9.65685L7.75748 11.0711L11 7.82854V14.9861Z" fill="#7a222b"/>
                                <path d="M4 14H6V18H18V14H20V18C20 19.1046 19.1046 20 18 20H6C4.89543 20 4 19.1046 4 18V14Z" fill="#7a222b"/>
                            </svg>
                            <span>Choose file or drag here</span>
                            <span class="file-name"></span>
                        </div>
                        <input type="file" id="goodMoral" name="goodMoral" class="file-input" accept=".pdf,.jpg,.jpeg,.png" required>
                    </div>
                    <div class="validation-message" id="goodMoralValidation">Please upload your Certificate of Good Moral Character</div>
                    <div class="preview-container" id="goodMoralPreview"></div>
                </div>
                
                <!-- Birth Certificate Upload -->
                <div class="upload-group">
                    <label for="birthCertificate">Digital copy of PSA Birth Certificate<span class="required-mark">*Required</span></label>
                    <div class="upload-input-container">
                        <div class="file-upload-btn">
                            <svg class="upload-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11 14.9861C11 15.5384 11.4477 15.9861 12 15.9861C12.5523 15.9861 13 15.5384 13 14.9861V7.82831L16.2428 11.0711L17.657 9.65685L12.0001 4L6.34326 9.65685L7.75748 11.0711L11 7.82854V14.9861Z" fill="#7a222b"/>
                                <path d="M4 14H6V18H18V14H20V18C20 19.1046 19.1046 20 18 20H6C4.89543 20 4 19.1046 4 18V14Z" fill="#7a222b"/>
                            </svg>
                            <span>Choose file or drag here</span>
                            <span class="file-name"></span>
                        </div>
                        <input type="file" id="birthCertificate" name="birthCertificate" class="file-input" accept=".pdf,.jpg,.jpeg,.png" required>
                    </div>
                    <div class="validation-message" id="birthCertificateValidation">Please upload your PSA Birth Certificate</div>
                    <div class="preview-container" id="birthCertificatePreview"></div>
                </div>
                
                <!-- ID Picture Upload -->
                <div class="upload-group">
                    <label for="idPicture">2×2 ID picture (with white or blue background) with full name<span class="required-mark">*Required</span></label>
                    <div class="upload-input-container">
                        <div class="file-upload-btn">
                            <svg class="upload-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11 14.9861C11 15.5384 11.4477 15.9861 12 15.9861C12.5523 15.9861 13 15.5384 13 14.9861V7.82831L16.2428 11.0711L17.657 9.65685L12.0001 4L6.34326 9.65685L7.75748 11.0711L11 7.82854V14.9861Z" fill="#7a222b"/>
                                <path d="M4 14H6V18H18V14H20V18C20 19.1046 19.1046 20 18 20H6C4.89543 20 4 19.1046 4 18V14Z" fill="#7a222b"/>
                            </svg>
                            <span>Choose file or drag here</span>
                            <span class="file-name"></span>
                        </div>
                        <input type="file" id="idPicture" name="idPicture" class="file-input" accept=".jpg,.jpeg,.png" required>
                    </div>
                    <div class="validation-message" id="idPictureValidation">Please upload your 2x2 ID picture</div>
                    <div class="preview-container" id="idPicturePreview"></div>
                </div>
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
        // File caching functions
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
                    localStorage.setItem(`new_step2_${inputId}`, JSON.stringify(fileData));
                    console.log(`Cached file data for ${inputId}:`, file.name);
                };
                reader.readAsDataURL(file);
            }
        }

        function restoreCachedFiles() {
            console.log('Attempting to restore cached files...');
            const fileInputs = ['reportCard', 'goodMoral', 'birthCertificate', 'idPicture'];
            let restoredCount = 0;
            
            fileInputs.forEach(inputId => {
                const input = document.getElementById(inputId);
                const cachedData = localStorage.getItem(`new_step2_${inputId}`);
                
                if (!input) {
                    console.log(`Input element not found for ${inputId}`);
                    return;
                }
                
                if (!cachedData) {
                    console.log(`No cached data found for ${inputId}`);
                    return;
                }
                
                // Check if input has files - more robust check
                const hasFiles = input.files && input.files.length > 0;
                const hasValue = input.value && input.value.length > 0;
                
                console.log(`Checking ${inputId} - hasFiles: ${hasFiles}, hasValue: ${hasValue}`);
                
                // ALWAYS restore if cached data exists - don't skip even if files appear to exist
                // This fixes the issue where browser back/forward cache creates fake file entries
                // that prevent restoration
                if (true) { // Always restore to fix bfcache issues
                    console.log(`✅ Proceeding with restoration for ${inputId}`);
                    try {
                        const fileData = JSON.parse(cachedData);
                        console.log(`Restoring cached file for ${inputId}:`, fileData.name);
                        
                        // Convert base64 data back to file
                        const byteCharacters = atob(fileData.data.split(',')[1]);
                        const byteNumbers = new Array(byteCharacters.length);
                        for (let i = 0; i < byteCharacters.length; i++) {
                            byteNumbers[i] = byteCharacters.charCodeAt(i);
                        }
                        const byteArray = new Uint8Array(byteNumbers);
                        const blob = new Blob([byteArray], { type: fileData.type });
                        const file = new File([blob], fileData.name, { 
                            type: fileData.type,
                            lastModified: fileData.lastModified 
                        });
                        
                        // Set the file to the input using DataTransfer
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);
                        input.files = dataTransfer.files;
                        
                        // Manually trigger UI update instead of relying on event
                        // This ensures the preview is always shown
                        setTimeout(() => {
                            console.log(`Attempting to show preview for ${inputId}`);
                            try {
                                const fileNameElement = input.parentElement ? input.parentElement.querySelector('.file-name') : null;
                                const previewContainer = document.getElementById(`${inputId}Preview`);
                                const validationMessage = document.getElementById(`${inputId}Validation`);
                                
                                if (fileNameElement) {
                                    fileNameElement.textContent = fileData.name;
                                    console.log(`Updated filename for ${inputId}: ${fileData.name}`);
                                } else {
                                    console.warn(`Could not find file name element for ${inputId}`);
                                }
                                
                                if (validationMessage) {
                                    validationMessage.style.display = 'none';
                                }
                                
                                // Show preview
                                if (previewContainer) {
                                    console.log(`Showing preview for ${inputId}`);
                                    showFilePreview(inputId, fileData);
                                } else {
                                    console.warn(`Could not find preview container for ${inputId}`);
                                }
                            } catch (error) {
                                console.error(`Error showing preview for ${inputId}:`, error);
                            }
                        }, 150);
                        
                        restoredCount++;
                        console.log(`Successfully restored file for ${inputId}: ${fileData.name}`);
                    } catch (error) {
                        console.error(`Error restoring cached file for ${inputId}:`, error);
                        localStorage.removeItem(`new_step2_${inputId}`);
                    }
                }
            });
            
            if (restoredCount > 0) {
                console.log(`File restoration completed: ${restoredCount} files restored`);
            }
            
            return restoredCount;
        }

        function clearCachedFiles() {
            const fileInputs = ['reportCard', 'goodMoral', 'birthCertificate', 'idPicture'];
            fileInputs.forEach(inputId => {
                localStorage.removeItem(`new_step2_${inputId}`);
            });
            console.log('Cleared all cached file data');
        }

        // Helper function to add remove option (moved to global scope)
        function addRemoveOption(container, input, fileNameElement) {
            const removeBtn = document.createElement('div');
            removeBtn.className = 'remove-file';
            removeBtn.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18 6L6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
            removeBtn.addEventListener('click', function() {
                // Clear file input and preview when remove is clicked
                input.value = '';
                fileNameElement.textContent = '';
                container.innerHTML = '';
                container.style.display = 'none';
                
                // Clear cached file data
                localStorage.removeItem(`new_step2_${input.id}`);

                // Re-check required files
                checkAllFilesUploaded();
            });
            container.appendChild(removeBtn);
        }

        function showFilePreview(inputId, fileData) {
            console.log(`showFilePreview called for ${inputId}`);
            const input = document.getElementById(inputId);
            if (!input) {
                console.error(`Input element not found for ${inputId}`);
                return;
            }
            
            const parentElement = input.parentElement;
            const fileNameElement = parentElement ? parentElement.querySelector('.file-name') : null;
            const previewContainer = document.getElementById(`${inputId}Preview`);
            const validationMessage = document.getElementById(`${inputId}Validation`);
            
            console.log(`Elements found - fileNameElement: ${!!fileNameElement}, previewContainer: ${!!previewContainer}, validationMessage: ${!!validationMessage}`);
            
            if (!fileNameElement || !previewContainer) {
                console.warn(`Missing required elements for ${inputId}. fileNameElement: ${!!fileNameElement}, previewContainer: ${!!previewContainer}`);
                return;
            }
            
            try {
                // Show filename
                fileNameElement.textContent = fileData.name;
                
                if (validationMessage) {
                    validationMessage.style.display = 'none';
                }
                
                previewContainer.style.display = 'block';
                previewContainer.innerHTML = '';
                
                const fileExtension = fileData.name.split('.').pop().toLowerCase();
                
                if (['jpg', 'jpeg', 'png'].includes(fileExtension)) {
                    // Create image preview
                    const img = document.createElement('img');
                    img.src = fileData.data;
                    img.className = 'preview-image';
                    previewContainer.appendChild(img);
                    
                    // Add remove option
                    addRemoveOption(previewContainer, input, fileNameElement);
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
                    
                    // Add remove option
                    addRemoveOption(previewContainer, input, fileNameElement);
                }
                
                console.log(`✅ File preview successfully displayed for ${inputId}: ${fileData.name}`);
            } catch (error) {
                console.error(`Error in showFilePreview for ${inputId}:`, error);
            }
        }

        // Global handleBackButton function
        window.handleBackButton = function() {
            // Check if there's a previous page in history
            if (window.history.length > 1) {
                window.history.back();
            } else {
                // Fallback to route navigation
                window.location.href = '{{ route('enroll.new.step1') }}';
            }
        };

        // Function to check if all required files are uploaded (from input, cache, or database)
        // This function will be defined inside DOMContentLoaded to access existingDocuments

        document.addEventListener('DOMContentLoaded', function() {
            // Set the active progress step
            setProgress(2);
            
            // Load existing documents from database
            @if(isset($existingDocs) && $existingDocs->count() > 0)
            const existingDocuments = {
                @foreach($existingDocs as $docType => $doc)
                '{{ $docType }}': {
                    name: '{{ $doc->original_filename }}',
                    mime: '{{ $doc->mime_type }}',
                    size: {{ $doc->file_size }},
                    data: '{{ $doc->file_data }}'
                }{{ !$loop->last ? ',' : '' }}
                @endforeach
            };
            
            // Restore existing documents to file inputs
            console.log('Loading existing documents:', existingDocuments);
            @else
            const existingDocuments = {};
            @endif
            
            // Define function to check if all required files are uploaded (needs access to existingDocuments)
            function checkAllFilesUploaded() {
                const fileInputMap = {
                    'reportCard': 'report_card',
                    'goodMoral': 'good_moral',
                    'birthCertificate': 'birth_certificate',
                    'idPicture': 'id_picture'
                };
                
                const nextButton = document.getElementById('nextButton');
                let allFilled = true;
                
                // Check each required file
                for (const [inputId, docType] of Object.entries(fileInputMap)) {
                    const input = document.getElementById(inputId);
                    const validationMessage = document.getElementById(`${inputId}Validation`);
                    
                    let hasFile = false;
                    
                    // Check if file exists in input
                    if (input.files && input.files.length > 0) {
                        hasFile = true;
                    }
                    // Check if file exists in localStorage cache
                    else if (localStorage.getItem(`new_step2_${inputId}`)) {
                        hasFile = true;
                    }
                    // Check if file exists in database (existingDocuments)
                    else if (existingDocuments && existingDocuments[docType]) {
                        hasFile = true;
                    }
                    
                    if (!hasFile) {
                        if (validationMessage) {
                            validationMessage.style.display = 'block';
                        }
                        allFilled = false;
                        console.log(`❌ Missing file: ${inputId}`);
                    } else {
                        if (validationMessage) {
                            validationMessage.style.display = 'none';
                        }
                        console.log(`✅ File present: ${inputId}`);
                    }
                }

                if (nextButton) {
                    nextButton.disabled = !allFilled;
                }
                
                console.log(`All files uploaded: ${allFilled}, Next button disabled: ${!allFilled}`);
                return allFilled;
            }
            
            // Function to remove required attributes from file inputs when files exist in database
            function updateRequiredAttributes() {
                const fileInputMap = {
                    'reportCard': 'report_card',
                    'goodMoral': 'good_moral',
                    'birthCertificate': 'birth_certificate',
                    'idPicture': 'id_picture'
                };
                
                for (const [inputId, docType] of Object.entries(fileInputMap)) {
                    const input = document.getElementById(inputId);
                    if (!input) continue;
                    
                    let hasFile = false;
                    
                    // Check if file exists in input
                    if (input.files && input.files.length > 0) {
                        hasFile = true;
                    }
                    // Check if file exists in localStorage cache
                    else if (localStorage.getItem(`new_step2_${inputId}`)) {
                        hasFile = true;
                    }
                    // Check if file exists in database
                    else if (existingDocuments && existingDocuments[docType]) {
                        hasFile = true;
                    }
                    
                    // Remove or add required attribute based on file existence
                    if (hasFile) {
                        input.removeAttribute('required');
                        console.log(`Removed required attribute from ${inputId}`);
                    } else {
                        input.setAttribute('required', 'required');
                        console.log(`Added required attribute to ${inputId}`);
                    }
                }
            }
            
            // CRITICAL: Check if files exist in inputs OR in cache OR in database, and update UI immediately
            function updateFileIndicators() {
                console.log('=== updateFileIndicators called ===');
                const fileInputs = {
                    'reportCard': 'report_card',
                    'goodMoral': 'good_moral',
                    'birthCertificate': 'birth_certificate',
                    'idPicture': 'id_picture'
                };
                
                for (const [inputId, docType] of Object.entries(fileInputs)) {
                    console.log(`Checking ${inputId}...`);
                    const input = document.getElementById(inputId);
                    if (!input) {
                        console.log(`❌ Input element not found for ${inputId}`);
                        continue;
                    }
                    
                    // Check input, localStorage cache, AND database
                    const hasFilesInInput = input.files && input.files.length > 0;
                    const cachedData = localStorage.getItem(`new_step2_${inputId}`);
                    const hasCachedData = !!cachedData;
                    const hasDbDoc = existingDocuments && existingDocuments[docType];
                    
                    console.log(`${inputId} - Input: ${hasFilesInInput}, Cache: ${hasCachedData}, DB: ${!!hasDbDoc}`);
                    
                    let fileName = null;
                    
                    // Get filename from input, cache, or database (in that order)
                    if (hasFilesInInput) {
                        fileName = input.files[0].name;
                    } else if (hasCachedData) {
                        try {
                            const fileData = JSON.parse(cachedData);
                            fileName = fileData.name;
                            console.log(`✅ Found file in cache for ${inputId}: ${fileName}`);
                        } catch (e) {
                            console.error(`Error parsing cache for ${inputId}:`, e);
                        }
                    } else if (hasDbDoc) {
                        fileName = existingDocuments[docType].name;
                        console.log(`✅ Found file in database for ${inputId}: ${fileName}`);
                    }
                    
                    // Update UI if we have a file
                    if (fileName) {
                        const fileNameElement = input.parentElement ? input.parentElement.querySelector('.file-name') : null;
                        const previewContainer = document.getElementById(`${inputId}Preview`);
                        const validationMessage = document.getElementById(`${inputId}Validation`);
                        
                        if (fileNameElement) {
                            fileNameElement.textContent = '✓ ' + fileName;
                            fileNameElement.style.color = '#10b981';
                            fileNameElement.style.fontWeight = '600';
                        }
                        
                        if (validationMessage) {
                            validationMessage.style.display = 'none';
                        }
                        
                        // Show simple indicator in preview container
                        if (previewContainer) {
                            previewContainer.style.display = 'block';
                            if (hasFilesInInput) {
                                // Full preview if file exists in input
                                previewContainer.innerHTML = '<div style="background: #d1fae5; border: 2px solid #10b981; padding: 12px; border-radius: 8px; color: #065f46; font-weight: 600;">✓ File Uploaded</div>';
                            } else if (hasCachedData) {
                                // Show that file is cached
                                previewContainer.innerHTML = '<div style="background: #fef3c7; border: 2px solid #f59e0b; padding: 12px; border-radius: 8px; color: #92400e; font-weight: 600;">⚠️ File cached (restored automatically on submission)</div>';
                            } else if (hasDbDoc) {
                                // Show that file is stored in database
                                previewContainer.innerHTML = '<div style="background: #dbeafe; border: 2px solid #3b82f6; padding: 12px; border-radius: 8px; color: #1e40af; font-weight: 600;">✓ File stored in database</div>';
                            }
                        }
                        
                        console.log(`✅ Updated indicator for ${inputId}: ${fileName}`);
                    } else {
                        console.log(`❌ No files found for ${inputId} (input, cache, or database)`);
                    }
                }
                console.log('=== updateFileIndicators done ===');
            }
            
            // Update indicators and required attributes immediately
            updateFileIndicators();
            updateRequiredAttributes(); // Remove required attributes if files exist in database
            checkAllFilesUploaded(); // Check button state after initial update
            
            // Also update after a short delay
            setTimeout(() => {
                updateFileIndicators();
                updateRequiredAttributes();
                checkAllFilesUploaded();
            }, 100);
            setTimeout(() => {
                updateFileIndicators();
                updateRequiredAttributes();
                checkAllFilesUploaded();
            }, 500);
            setTimeout(() => {
                updateFileIndicators();
                updateRequiredAttributes();
                checkAllFilesUploaded();
            }, 1000);
            
            // Get all file inputs
            const fileInputs = document.querySelectorAll('.file-input');
            const nextButton = document.getElementById('nextButton');
            
            // Add event listeners to all file inputs
            fileInputs.forEach(input => {
                input.addEventListener('change', function(e) {
                    const fileName = e.target.files[0]?.name || '';
                    const fileNameElement = this.parentElement.querySelector('.file-name');
                    const previewContainer = document.getElementById(`${this.id}Preview`);
                    const validationMessage = document.getElementById(`${this.id}Validation`);
                    
                    // Cache the file data
                    if (e.target.files[0]) {
                        cacheFileData(this.id, e.target.files[0]);
                        // Remove required attribute since file is selected
                        this.removeAttribute('required');
                    }
                    
                    if (fileName) {
                        // Show filename
                        fileNameElement.textContent = fileName;
                        validationMessage.style.display = 'none';
                        
                        // Clear previous preview
                        previewContainer.innerHTML = '';
                        previewContainer.style.display = 'block';
                        
                        // Create preview element
                        const file = e.target.files[0];
                        const fileExtension = fileName.split('.').pop().toLowerCase();
                        
                        if (['jpg', 'jpeg', 'png'].includes(fileExtension)) {
                            // Image preview
                            const reader = new FileReader();
                            reader.onload = function(event) {
                                const img = document.createElement('img');
                                img.src = event.target.result;
                                img.className = 'preview-image';
                                previewContainer.appendChild(img);
                                
                                // Add remove option
                                addRemoveOption(previewContainer, input, fileNameElement);
                            };
                            reader.readAsDataURL(file);
                        } else {
                            // Document preview (PDF or other)
                            const docPreview = document.createElement('div');
                            docPreview.className = 'preview-document';
                            
                            // Document icon
                            const docIcon = document.createElement('div');
                            docIcon.className = 'document-icon';
                            docIcon.innerHTML = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14 2H6C4.89543 2 4 2.89543 4 4V20C4 21.1046 4.89543 22 6 22H18C19.1046 22 20 21.1046 20 20V8L14 2Z" stroke="#7a222b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M14 2V8H20" stroke="#7a222b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M16 13H8" stroke="#7a222b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M16 17H8" stroke="#7a222b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M10 9H9H8" stroke="#7a222b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
                            
                            // Document name
                            const docName = document.createElement('div');
                            docName.className = 'document-name';
                            docName.textContent = fileName;
                            
                            docPreview.appendChild(docIcon);
                            docPreview.appendChild(docName);
                            previewContainer.appendChild(docPreview);
                            
                            // Add remove option
                            addRemoveOption(previewContainer, input, fileNameElement);
                        }
                    } else {
                        fileNameElement.textContent = '';
                        previewContainer.style.display = 'none';
                        previewContainer.innerHTML = '';
                    }
                    
                    // Check if all required files are uploaded
                    checkAllFilesUploaded();
                });
                
                // Setup drag and drop functionality
                const uploadContainer = input.parentElement;
                
                uploadContainer.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    this.querySelector('.file-upload-btn').style.backgroundColor = '#efd9db';
                    this.querySelector('.file-upload-btn').style.borderColor = '#7a222b';
                });
                
                uploadContainer.addEventListener('dragleave', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    this.querySelector('.file-upload-btn').style.backgroundColor = '#f4e9ea';
                    this.querySelector('.file-upload-btn').style.borderColor = '#bd8c91';
                });
                
                uploadContainer.addEventListener('drop', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    this.querySelector('.file-upload-btn').style.backgroundColor = '#f4e9ea';
                    this.querySelector('.file-upload-btn').style.borderColor = '#bd8c91';
                    
                    const dt = e.dataTransfer;
                    const files = dt.files;
                    
                    if (files.length) {
                        input.files = files;
                        // Trigger change event
                        const event = new Event('change', { bubbles: true });
                        input.dispatchEvent(event);
                    }
                });
            });
            
            // Form validation
            document.getElementById('documentUploadForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                if (checkAllFilesUploaded()) {
                  showToast('All documents uploaded successfully! Proceeding to payment page.', 'success');
                  this.submit();   // ← now the form will actually submit
                }
            });
            
            // Optimized navigation event listeners (single restoration to prevent flickering)
            window.addEventListener('popstate', function(event) {
                setTimeout(performFileRestoration, 200);
            });
            
            document.addEventListener('visibilitychange', function() {
                if (!document.hidden) {
                    setTimeout(performFileRestoration, 200);
                }
            });
            
            window.addEventListener('focus', function() {
                setTimeout(performFileRestoration, 200);
            });
            
            // Clear cached files on successful form submission
            document.getElementById('documentUploadForm').addEventListener('submit', function(e) {
                if (checkAllFilesUploaded()) {
                    // Clear cache only after successful validation
                    setTimeout(clearCachedFiles, 1000);
                }
            });
            
            // Optimized restoration system to prevent flickering
            let restorationInProgress = false;
            
            function performFileRestoration() {
                if (restorationInProgress) {
                    console.log('Restoration already in progress, skipping...');
                    return;
                }
                
                restorationInProgress = true;
                console.log('Starting file restoration...');
                
                // Show subtle loading indicator (optional)
                const restoredCount = restoreCachedFiles();
                checkAllFilesUploaded();
                
                // Reset flag after restoration
                setTimeout(() => {
                    restorationInProgress = false;
                    if (restoredCount > 0) {
                        console.log(`File restoration completed: ${restoredCount} files restored`);
                    }
                }, 100);
            }
            
            // Multiple restoration attempts for reliability with increasing delays to ensure DOM is ready
            setTimeout(() => {
                console.log('First restoration attempt after 300ms');
                performFileRestoration();
            }, 300);
            setTimeout(() => {
                console.log('Second restoration attempt after 800ms');
                performFileRestoration();
            }, 800);
            setTimeout(() => {
                console.log('Third restoration attempt after 1500ms');
                performFileRestoration();
            }, 1500);
            
            // Monitor for file restoration needs (every 2 seconds) 
            // Check if files in inputs match cached data
            setInterval(function() {
                if (restorationInProgress) return;
                
                const fileInputs = ['reportCard', 'goodMoral', 'birthCertificate', 'idPicture'];
                let needsRestoration = false;
                
                fileInputs.forEach(inputId => {
                    const input = document.getElementById(inputId);
                    const cachedData = localStorage.getItem(`new_step2_${inputId}`);
                    
                    if (!input || !cachedData) return;
                    
                    // Check if input has files
                    const hasFiles = input.files && input.files.length > 0;
                    
                    // If there's cached data but no file in input, restore it
                    if (!hasFiles) {
                        needsRestoration = true;
                        console.log(`File missing for ${inputId}, will restore`);
                    }
                });
                
                if (needsRestoration) {
                    console.log('Performing automatic file restoration...');
                    performFileRestoration();
                }
            }, 3000); // Increased to 3 seconds to reduce frequency
            
            // Update indicators when page becomes visible (for back navigation)
            document.addEventListener('visibilitychange', function() {
                if (!document.hidden) {
                    console.log('Page became visible, updating file indicators...');
                    updateFileIndicators();
                    performFileRestoration();
                }
            });
            
            // Update indicators when window regains focus (for back navigation)
            window.addEventListener('focus', function() {
                console.log('Window focused, updating file indicators...');
                updateFileIndicators();
                performFileRestoration();
            });
            
            // Expose updateFileIndicators globally for debugging
            window.updateFileIndicators = updateFileIndicators;

            // Helper function to check if all required files are uploaded moved to global scope

            // Set progress step (for visual bar)
            function setProgress(step) {
                const progressBar = document.querySelector('.progress-bar');
                progressBar.classList.remove('step-1', 'step-2', 'step-3', 'step-4');
                progressBar.classList.add(`step-${step}`);
            }
            
            // Browser history handling (expose globally for onclick)
            window.handleBackButton = function() {
                // Check if there's a previous page in history
                if (window.history.length > 1) {
                    window.history.back();
                } else {
                    // Fallback to route navigation
                    window.location.href = '{{ route('enroll.new.step1') }}';
                }
            }
            
            // Handle browser back button
            window.addEventListener('popstate', function(event) {
                // Allow browser back button to work naturally
                if (event.state && event.state.step) {
                    // Handle step navigation if needed
                }
            });
        });
    </script>
    
    {{-- Include Modern Notification System --}}
    @include('partials.modern_notifications')
</body>
</html>

                    