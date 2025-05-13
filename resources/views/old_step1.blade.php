<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MCA Montessori School Enrollment Form - Pre-Registration</title>
  <link rel="stylesheet" href="{{ asset('css/styles_old_form.css') }}">
</head>
<body>
  <div class="enrollment-form">
    <a href="{{ url()->previous() }}" class="back-btn">Back</a>
    <div class="header">
      <div class="school-logo">
        <img src="{{asset ('images/logo.png')}}" alt="School Logo">
      </div>
      <div class="school-name">
        <h2>MCA MONTESSORI SCHOOL</h2>
        <p>ONLINE ENROLLMENT FORM</p>
      </div>
    </div>
    
    <!-- Updated Progress Bar -->
    <div class="progress-container">
      <div class="progress-bar step-1">
        <div class="progress-step active">
          <div class="step-circle">1</div>
          <div class="step-title">Pre-Registration</div>
        </div>
        <div class="progress-step">
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
  
    <form action="{{ route('enroll.old.step1.post') }}"
          method="POST">
      @csrf 
      <h2>STEP 1. PRE-REGISTRATION FOR EXISTING STUDENTS</h2>
      
      <!-- Semester Selection with Radio Buttons -->
      <div class="radio-group">
        <div class="radio-container">
          <input type="radio" id="firstSem" name="semester" value="1st" required>
          <label for="firstSem">1ST SEM</label>
        </div>
        
        <div class="radio-container">
          <input type="radio" id="secondSem" name="semester" value="2nd" required>
          <label for="secondSem">2ND SEM</label>
        </div>
      </div>
      
      <!-- Student Information Fields -->
      <div>
        <label for="surname">Surname:</label>
        <input type="text" id="surname" name="surname" required>
        <span>**Required</span>
      </div>
      
      <div>
        <label for="givenName">Given Name:</label>
        <input type="text" id="givenName" name="givenName" required>
        <span>**Required</span>
      </div>
      
      <div>
        <label for="middleName">Middle Name:</label>
        <input type="text" id="middleName" name="middleName" required>
        <span>**Required</span>
      </div>
      
      <div>
        <label for="lrn">Learner Reference Number (LRN):</label>
        <input type="text" id="lrn" name="lrn" required>
        <span>**Required</span>
      </div>
      
      <div>
        <label for="studentId">Student ID:</label>
        <input type="text" id="studentId" name="studentId" required>
        <span>**Required</span>
      </div>
      
      <div>
        <label for="applyingYear">Applying Year:</label>
        <input type="text" id="applyingYear" name="gradeLevelApplying" required>
        <span>**Required</span>
      </div>
      
      <h3>Terms and Conditions:</h3>
      
      <div>
        <input type="checkbox" id="term1" name="terms[]" value="completeness" required>
        <label for="term1">I hereby attest to the completeness and accuracy of all the information supplied in this form. I understand that withholding of information or giving false information will make me ineligible for admission, or may jeopardize my continued stay after admission has been granted.</label>
      </div>
      
      <p>As a student of MCA Montessori School, Inc., I hereby agree to the following terms:</p> <br>
      
      <div>
        <input type="checkbox" id="term2" name="terms[]" value="abide" required>
        <label for="term2">I will abide the MCA Montessori School's Policies and Regulations at all times</label>
      </div>
      
      <div>
        <input type="checkbox" id="term3" name="terms[]" value="consequences" required>
        <label for="term3">I am fully aware of the consequences in any case a violation shall be committed by me</label>
      </div>
      
      <div>
        <input type="checkbox" id="term4" name="terms[]" value="responsible" required>
        <label for="term4">I will be responsible in my academic and behavioral performance in school and at the same time be prompt in reading all communications from the school through the diary/SMS(Electronic Message)</label>
      </div>
      
      <div>
        <input type="checkbox" id="term5" name="terms[]" value="updated" required>
        <label for="term5">I will always keep the school updated of my cellphone number and my Parents cellphone number. In any case that the school needs the presence of my parents/guardians I will always make sure that they are available.</label>
      </div>
      
      <div>
        <input type="checkbox" id="term6" name="terms[]" value="aware" required>
        <label for="term6">I am fully aware that I am only given a maximum of fifteen(15) working days(from date of enrollment) to retract my enrollment, otherwise the school will automatically register me to the DepEd Learner's Information Systems(LIS) to formalize my enrollment.</label>
      </div>
      
      <!-- Next Button -->
      <button type="submit">Next</button>
    </form>
  </div>

  <script>
    function setProgress(step) {
      const progressBar = document.querySelector('.progress-bar');
      const steps = document.querySelectorAll('.progress-step');
      
      // Remove all active and completed classes
      steps.forEach((stepEl, idx) => {
        stepEl.classList.remove('active', 'completed');
      });
      
      // Add the appropriate classes based on current step
      for (let i = 0; i < steps.length; i++) {
        if (i < step - 1) {
          steps[i].classList.add('completed');
        } else if (i === step - 1) {
          steps[i].classList.add('active');
        }
      }
      
      // Update the progress bar class
      progressBar.className = 'progress-bar';
      progressBar.classList.add('step-' + step);
    }
    
    // Initialize progress on page load
    document.addEventListener('DOMContentLoaded', function() {
      setProgress(1);
    });
  </script>
</body>
</html>