<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MCA Montessori School Enrollment Form - Pre-Registration</title>
  <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
  <link rel="icon" href="{{ asset('favicon.ico') }}">
  <link rel="stylesheet" href="{{ asset('css/styles_old_form.css') }}">
  <link rel="stylesheet" href="{{ asset('css/mobile-compatibility.css') }}">
</head>
<body>
  <div class="enrollment-form">
    <a href="{{ route('enroll.select') }}" class="back-btn" onclick="return handleBackButton(event)">Back</a>
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
      
      @if ($errors->any())
        <div style="background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
          <h4>Please fix the following errors:</h4>
          <ul style="margin: 0; padding-left: 20px;">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
      
      @if (session('error'))
        <div style="background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
          {{ session('error') }}
        </div>
      @endif
      
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
      
      <!-- LRN Input Field -->
      <div>
        <label for="lrn">Learner Reference Number (LRN):</label>
        <div style="display: flex; gap: 10px; align-items: center; margin: 10px 0;">
          <input type="text" id="lrn" name="lrn" required 
                 style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px;">
          <button type="button" id="lookupBtn" onclick="lookupStudent()" 
                  style="background-color: #007bff; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-size: 16px; font-weight: bold; transition: all 0.3s; box-shadow: 0 2px 4px rgba(0,0,0,0.1);"
                  onmouseover="this.style.backgroundColor='#0056b3'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(0,0,0,0.2)'"
                  onmouseout="this.style.backgroundColor='#007bff'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0,0,0,0.1)'">
            🔍 Find My Info
          </button>
        </div>
        <span>**Required - Enter your LRN to automatically retrieve your student information</span>
      </div>
      
      <!-- Student Information Display (populated by AJAX) -->
      <div id="studentInfo" style="display: none; background-color: #f0f8ff; padding: 15px; border-radius: 5px; margin: 15px 0;">
        <h3>Student Information</h3>
        <div id="studentDetails"></div>
      </div>
      
      <!-- Hidden fields for form submission -->
      <input type="hidden" id="surname" name="surname">
      <input type="hidden" id="givenName" name="givenName">
      <input type="hidden" id="middleName" name="middleName">
      <input type="hidden" id="studentId" name="studentId">
      <input type="hidden" id="gradeLevelApplying" name="gradeLevelApplying">
      
      <h3>Terms and Conditions:</h3>
      
      <div>
        <input type="checkbox" class="term" id="term1" name="terms[]" value="completeness"  required>
        <label for="term1">I hereby attest to the completeness and accuracy of all the information supplied in this form. I understand that withholding of information or giving false information will make me ineligible for admission, or may jeopardize my continued stay after admission has been granted.</label>
      </div>
      
      <p>As a student of MCA Montessori School, Inc., I hereby agree to the following terms:</p> <br>
      
      <div>
        <input type="checkbox" class="term" id="term2" name="terms[]" value="abide"  required>
        <label for="term2">I will abide the MCA Montessori School's Policies and Regulations at all times</label>
      </div>
      
      <div>
        <input type="checkbox" class="term" id="term3" name="terms[]" value="consequences"  required>
        <label for="term3">I am fully aware of the consequences in any case a violation shall be committed by me</label>
      </div>
      
      <div>
        <input type="checkbox" class="term" id="term4" name="terms[]" value="responsible"  required>
        <label for="term4">I will be responsible in my academic and behavioral performance in school and at the same time be prompt in reading all communications from the school through the diary/SMS(Electronic Message)</label>
      </div>
      
      <div>
        <input type="checkbox" class="term" id="term5" name="terms[]" value="updated"  required>
        <label for="term5">I will always keep the school updated of my cellphone number and my Parents cellphone number. In any case that the school needs the presence of my parents/guardians I will always make sure that they are available.</label>
      </div>
      
      <div>
        <input type="checkbox" class="term" id="term6" name="terms[]" value="aware"  required>
        <label for="term6">I am fully aware that I am only given a maximum of fifteen(15) working days(from date of enrollment) to retract my enrollment, otherwise the school will automatically register me to the DepEd Learner's Information Systems(LIS) to formalize my enrollment.</label>
      </div>
      
      <!-- Check All Terms and Conditions -->
      <div>
        <input type="checkbox" id="checkAllTerms">
        <label for="checkAllTerms">Check All Terms and Conditions</label>
      </div>
      
      <!-- Next Button -->
      <button type="submit" id="submitBtn" disabled>Next</button>
    </form>
  </div>

  <script>
    // Global back button function
    function handleBackButton(event) {
        // Prevent default link behavior
        if (event) {
            event.preventDefault();
        }
        
        // Check if there's a previous page in history and it's not the current page
        if (window.history.length > 1 && document.referrer && document.referrer !== window.location.href) {
            window.history.back();
        } else {
            // Fallback to route navigation
            window.location.href = '{{ route('enroll.select') }}';
        }
        return false;
    }

    // Global terms validation function
    function validateTerms() {
        const terms = document.querySelectorAll('input[name="terms[]"]:checked');
        const submitBtn = document.getElementById('submitBtn');
        
        if (submitBtn) {
            if (terms.length === 6) {
                submitBtn.disabled = false;
                submitBtn.style.backgroundColor = '#007bff';
                submitBtn.style.cursor = 'pointer';
            } else {
                submitBtn.disabled = true;
                submitBtn.style.backgroundColor = '#6c757d';
                submitBtn.style.cursor = 'not-allowed';
            }
        }
    }

    // Function to ensure validation runs when elements are ready
    function ensureValidation() {
        const submitBtn = document.getElementById('submitBtn');
        if (submitBtn) {
            validateTerms();
        } else {
            // If elements aren't ready yet, try again in a short time
            setTimeout(ensureValidation, 50);
        }
    }

    // Try to validate immediately when script loads
    ensureValidation();

    // Real-time refresh to auto-enable button after back navigation
    setInterval(function() {
        const submitBtn = document.getElementById('submitBtn');
        const terms = document.querySelectorAll('input[name="terms[]"]:checked');
        const semester = document.querySelector('input[name="semester"]:checked');
        const lrn = document.getElementById('lrn').value.trim();
        const studentId = document.getElementById('studentId').value.trim();
        
        if (submitBtn && terms.length === 6 && semester && lrn && studentId) {
            submitBtn.disabled = false;
            submitBtn.style.backgroundColor = '#007bff';
            submitBtn.style.cursor = 'pointer';
        } else if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.style.backgroundColor = '#6c757d';
            submitBtn.style.cursor = 'not-allowed';
        }
    }, 100);

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
      
      // Clear cached data on fresh page load (when starting new enrollment)
      // Check if this is a fresh start (no session data indicating existing enrollment)
      let cacheCleared = false;
      if (!sessionStorage.getItem('old_enrollee_id') && !sessionStorage.getItem('enrollment_in_progress')) {
        // Clear old student enrollment cache
        sessionStorage.removeItem('old_enroll_step1');
        cacheCleared = true;
        console.log('Fresh old student enrollment started - cached data cleared');
      }
      
      // Add event listeners to all term checkboxes
      const termBoxes = document.querySelectorAll('.term');
      termBoxes.forEach(box => {
        box.addEventListener('change', validateTerms);
      });

      // Check All Terms and Conditions functionality
      const checkAllTerms = document.getElementById('checkAllTerms');
      if (checkAllTerms) {
        checkAllTerms.addEventListener('change', function() {
          const allTerms = document.querySelectorAll('.term');
          allTerms.forEach(term => {
            term.checked = this.checked;
          });
          validateTerms();
        });

        // Update check all state when individual terms change
        termBoxes.forEach(box => {
          box.addEventListener('change', function() {
            const allTerms = document.querySelectorAll('.term');
            const checkedTerms = document.querySelectorAll('.term:checked');
            
            if (checkedTerms.length === 0) {
              checkAllTerms.checked = false;
              checkAllTerms.indeterminate = false;
            } else if (checkedTerms.length === allTerms.length) {
              checkAllTerms.checked = true;
              checkAllTerms.indeterminate = false;
            } else {
              checkAllTerms.checked = false;
              checkAllTerms.indeterminate = true;
            }
          });
        });
      }

      // Restore looked-up data from sessionStorage (instant enable on return)
      // Only restore if cache wasn't cleared
      if (!cacheCleared) {
        try {
          const cached = JSON.parse(sessionStorage.getItem('old_enroll_step1') || '{}');
          if (cached && cached.studentId) {
            document.getElementById('surname').value = cached.surname || '';
            document.getElementById('givenName').value = cached.givenName || '';
            document.getElementById('middleName').value = cached.middleName || '';
            document.getElementById('studentId').value = cached.studentId || '';
            document.getElementById('gradeLevelApplying').value = cached.gradeLevelApplying || '';
            // also restore UI block if present
            const studentInfo = document.getElementById('studentInfo');
            const studentDetails = document.getElementById('studentDetails');
            if (studentInfo && studentDetails && cached.studentHTML) {
              studentDetails.innerHTML = cached.studentHTML;
              studentInfo.style.display = 'block';
            }
          }
        } catch (e) {}
      }

      // Initial validation
      validateTerms();

      // Re-validate on page focus (handles back button navigation)
      window.addEventListener('focus', function() {
          ensureValidation();
      });

      // Re-validate immediately when page becomes visible
      document.addEventListener('visibilitychange', function() {
          if (!document.hidden) {
              ensureValidation();
          }
      });
      
      // Handle browser back button
      window.addEventListener('popstate', function(event) {
          // Allow browser back button to work naturally
          if (event.state && event.state.step) {
              // Handle step navigation if needed
          }
          // Re-validate immediately after navigation
          ensureValidation();
      });
    });

    // AJAX function to lookup student by LRN
    function lookupStudent() {
      const lrn = document.getElementById('lrn').value.trim();
      const lookupBtn = document.getElementById('lookupBtn');
      const studentInfo = document.getElementById('studentInfo');
      const studentDetails = document.getElementById('studentDetails');

      if (!lrn) {
        showToast('Please enter your LRN', 'warning');
        return;
      }

      // Show loading state
      lookupBtn.disabled = true;
      lookupBtn.textContent = '🔍 Searching...';
      lookupBtn.style.backgroundColor = '#6c757d';
      studentInfo.style.display = 'none';

      // Make AJAX request
      fetch('{{ route("enroll.old.lookup.lrn") }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ lrn: lrn })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          // Populate hidden fields
          document.getElementById('surname').value = data.student.last_name;
          document.getElementById('givenName').value = data.student.first_name;
          document.getElementById('middleName').value = data.student.middle_name || '';
          document.getElementById('studentId').value = data.student.student_id;
          document.getElementById('gradeLevelApplying').value = data.student.grade_level_id;

          // Display student information
          const sourceText = data.student.source === 'old_enrollee' ? 'Previous Enrollment' : 'Current Student';
          const html = `
            <p><strong>Name:</strong> ${data.student.full_name}</p>
            <p><strong>Grade Level:</strong> ${data.student.grade_level_name || 'N/A'}</p>
            <p><strong>Strand:</strong> ${data.student.strand_name || 'N/A'}</p>
            <p><strong>Section:</strong> ${data.student.section_name || 'N/A'}</p>
            <p><strong>Status:</strong> ${data.student.status_name || 'N/A'}</p>
            <p><strong>Source:</strong> ${sourceText}</p>
          `;
          studentDetails.innerHTML = html;
          studentInfo.style.display = 'block';

          // Cache for instant restore when navigating back
          sessionStorage.setItem('old_enroll_step1', JSON.stringify({
            surname: data.student.last_name,
            givenName: data.student.first_name,
            middleName: data.student.middle_name || '',
            studentId: data.student.student_id,
            gradeLevelApplying: data.student.grade_level_id,
            studentHTML: html
          }));

          // ensure terms validation reflects current state
          validateTerms();
        } else {
          showToast('Student not found with the provided LRN. Please check your LRN and try again.', 'error');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        showToast('An error occurred while looking up the student. Please try again.', 'error');
      })
      .finally(() => {
        // Reset button state
        lookupBtn.disabled = false;
        lookupBtn.textContent = '🔍 Find My Info';
        lookupBtn.style.backgroundColor = '#007bff';
      });
    }

    // Allow Enter key to trigger lookup
    document.getElementById('lrn').addEventListener('keypress', function(e) {
      if (e.key === 'Enter') {
        e.preventDefault();
        lookupStudent();
      }
    });
  </script>
  
  <!-- Mobile Compatibility Script -->
  <script src="{{ asset('js/mobile-compatibility.js') }}"></script>
  
  {{-- Include Modern Notification System --}}
  @include('partials.modern_notifications')
</body>
</html>