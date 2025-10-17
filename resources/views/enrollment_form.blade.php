<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="0">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ secure_asset('css/styles_enrollment_form.css') }}?v={{ time() }}" />
    <link rel="stylesheet" href="{{ secure_asset('css/mobile-compatibility.css') }}?v={{ time() }}">
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond&display=swap" rel="stylesheet">
    <title>Enrollment Form</title>
  </head>
  <body>

    <div class="enrollment-form">
      <div class="header">
        <div class="school-logo">
          <img src="{{ secure_asset('images/logo.png') }}?v={{ time() }}" alt="School Logo">
        </div>
        <div class="school-name">
          <h2>MCA MONTESSORI SCHOOL</h2>
          <p>ONLINE ENROLLMENT FORM</p>
        </div>
      </div>

      <div class="enrollment-timeline">
        <div class="step completed">
          <div class="circle">✓</div>
          <div class="label">Enrollment Type</div>
        </div>
        <div class="connector"></div>
        <div class="step active">
          <div class="circle">2</div>
          <div class="label">Personal Info</div>
        </div>
        <div class="connector"></div>
        <div class="step">
          <div class="circle">3</div>
          <div class="label">Validate Details</div>
        </div>
        <div class="connector"></div>
        <div class="step">
          <div class="circle">4</div>
          <div class="label">Finish</div>
        </div>
      </div>

      <hr>

      <form action="{{ route('enrollment.store') }}" method="POST" enctype="multipart/form-data" id="enrollForm">
        @csrf

        {{-- STEP 1: Semester --}}
        <div class="form-step active" data-step="1">
          <div class="input-field">
            <label for="semester">School Year (e.g. 2025–2026):</label>
            <input type="text" id="semester" name="semester" placeholder="20XX–20XX" required>
          </div>
          <div class="form-navigation">
            <button type="button" class="btn-next">Next &raquo;</button>
          </div>
          <div class="info-section">
            <p class="note">Note: Please ensure that the information you provide is accurate and complete. This will help us process your enrollment smoothly.</p>
            <p>For any inquiries, please contact us at 09XXXXXXXXX or email@xxxxx.com </p>
            <p>Thank you for choosing MCA Montessori School!</p>
            <p>We look forward to welcoming you!</p>

          </div>
        </div>

        {{-- STEP 2: Personal Information --}}
        <div class="form-step" data-step="2">
          <h3>Personal Information</h3>
          <div class="input-field">
            <label for="lrn">Learner Reference No. (LRN)</label>
            <input type="text" id="lrn" name="lrn" placeholder="(auto-generated if new)">
          </div>
          <label>Full Name</label>
          <div class="student-info">
            <input type="text" name="last_name" placeholder="Last Name" required>
            <input type="text" name="first_name" placeholder="First Name" required>
            <input type="text" name="middle_name" placeholder="Middle Name">
            <input type="text" name="extension_name" placeholder="Extension (Jr., III)">
          </div>
          <div class="other-info">
            <div class="dob">
              <label>Date of Birth</label>
              <input type="text" name="dob_month" placeholder="MM" maxlength="2" required>
              <input type="text" name="dob_day"   placeholder="DD" maxlength="2" required>
              <input type="text" name="dob_year"  placeholder="YYYY" maxlength="4" required>
            </div>
            <div class="gender">
              <label>Gender</label>
              <label><input type="radio" name="gender" value="Male"   required> Male</label>
              <label><input type="radio" name="gender" value="Female" required> Female</label>
              <label><input type="radio" name="gender" value="Other"  required> Other</label>
            </div>
            <div class="citizenship">
                <div class="input-field">
                    <label for="pob">Place of Birth</label>
                    <input type="text" id="pob" name="pob" placeholder="City/Municipality, Province" required>
                  </div>
                  <div class="input-field">
                    <label for="address">Permanent Address</label>
                    <input type="text" id="address" name="address" placeholder="Street, Barangay, City, ZIP" required>
                  </div>
            </div>
            <div class="citizenship">
                <div class="contact">
                    <label for="contact">Mobile Number</label>
                    <input type="text" id="contact" name="mobile" placeholder="09XXXXXXXXX" required>
                  </div>
                  <div class="email">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="you@example.com" required>
                  </div>
            </div>
          </div>
          <div class="form-navigation">
            <button type="button" class="btn-prev">&laquo; Back</button>
            <button type="button" class="btn-next">Next &raquo;</button>
          </div>
        </div>

        {{-- STEP 3: Family / Guardian Info --}}
        <div class="form-step" data-step="3">
          <h3>Family / Guardian Information</h3>
          <div class="input-field">
            <label for="mother_name">Mother’s Name</label>
            <input type="text" id="mother_name" name="mother_name" required>
          </div>
          <div class="input-field">
            <label for="father_name">Father’s Name</label>
            <input type="text" id="father_name" name="father_name" required>
          </div>
          <div class="input-field">
            <label for="guardian_name">Guardian’s Name (if applicable)</label>
            <input type="text" id="guardian_name" name="guardian_name">
          </div>
          <div class="input-field">
            <label for="relationship">Relationship to Learner</label>
            <input type="text" id="relationship" name="relationship">
          </div>
          <div class="input-field">
            <label for="guardian_contact">Guardian Contact #</label>
            <input type="text" id="guardian_contact" name="guardian_contact">
          </div>
          <div class="input-field">
            <label for="guardian_email">Guardian Email</label>
            <input type="email" id="guardian_email" name="guardian_email">
          </div>
          <div class="form-navigation">
            <button type="button" class="btn-prev">&laquo; Back</button>
            <button type="button" class="btn-next">Next &raquo;</button>
          </div>
        </div>

        {{-- STEP 4: Previous School Details --}}
        <div class="form-step" data-step="4">
          <h3>Previous School Details</h3>
          <div class="input-field">
            <label for="last_school">Name of Last School Attended</label>
            <input type="text" id="last_school" name="last_school" required>
          </div>
          <div class="input-field">
            <label for="school_address">School Address</label>
            <input type="text" id="school_address" name="school_address" required>
          </div>
          <div class="input-field">
            <label for="grade_completed">Grade Level Completed</label>
            <select id="grade_completed" name="grade_completed" required>
              <option value="">-- Select --</option>
              @for($g=1; $g<=12; $g++)
                <option value="{{ $g }}">{{ $g }}</option>
              @endfor
            </select>
          </div>
          <div class="input-field">
            <label for="sy_completed">School Year Completed</label>
            <input type="text" id="sy_completed" name="sy_completed" placeholder="20XX–20XX" required>
          </div>
          <div class="input-field">
            <label for="form138">Upload Form 138 (Final Grades)</label>
            <input type="file" id="form138" name="form138" accept=".pdf,.jpg,.png" required>
          </div>
          <div class="form-navigation">
            <button type="button" class="btn-prev">&laquo; Back</button>
            <button type="button" class="btn-next">Next &raquo;</button>
          </div>
        </div>

        {{-- STEP 5: Desired Enrollment --}}
        <div class="form-step" data-step="5">
          <h3>Desired Enrollment</h3>
          <div class="grade-level section-border">
            <label>Grade Level to Enroll</label><br>
            @foreach([7,8,9,10,11,12] as $level)
              <label>
                <input type="radio" name="desired_grade" value="{{ $level }}" required>
                {{ $level }}
              </label>
            @endforeach
          </div>
          <div class="strand section-border" id="strandSelection" style="display:none">
            <label>Preferred Strand</label><br>
            @foreach(['STEM','ABM','GAS','HUMSS','ICT','HE'] as $s)
              <label>
                <input type="radio" name="preferred_strand" value="{{ $s }}"> {{ $s }}
              </label>
            @endforeach
          </div>
          <div class="form-navigation">
            <button type="button" class="btn-prev">&laquo; Back</button>
            <button type="submit" class="submit-btn">Submit Application</button>
          </div>
        </div>
      </form>
      <div>
        <form id="login-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
        <button class="button-back"><a href="#" class="go-back" onclick="confirmExit()">&#60 Login</a></button>
      </div>
    </div>

    <div id="confirm-modal" class="modal">
      <div class="modal-content">
          <p>Are you sure you want to cancel enrollment?</p>
          <button class="confirm-btn" onclick="logout(event)">Yes</button>
          <button class="cancel-btn" onclick="closeModal()">No</button>
      </div>
    </div>

    <!-- Mobile Compatibility Script -->
    <script src="{{ secure_asset('js/mobile-compatibility.js') }}?v={{ time() }}"></script>
    
    <script>
      document.addEventListener('DOMContentLoaded', () => {
        const steps = Array.from(document.querySelectorAll('.form-step'));
        let current = 0;
    
        function showStep(i) {
          steps.forEach((s, idx) => {
            s.classList.toggle('active', idx === i);
          });
        }
    
        function validateStep(i) {
          const step = steps[i];
          let valid = true;
          step.querySelectorAll('input[required], select[required]').forEach(el => {
            if ((el.type === 'radio' && !step.querySelector(`input[name="${el.name}"]:checked`))
                || (el.type !== 'radio' && !el.value.trim())) {
              el.style.borderColor = 'red';
              valid = false;
            } else {
              el.style.borderColor = '';
            }
          });
          return valid;
        }
    
        document.querySelectorAll('.btn-next').forEach(btn => {
          btn.addEventListener('click', () => {
            if (validateStep(current)) {
              current = Math.min(current + 1, steps.length - 1);
              showStep(current);
            } else {
              alert('Please fill all required fields.');
            }
          });
        });
    
        document.querySelectorAll('.btn-prev').forEach(btn => {
          btn.addEventListener('click', () => {
            current = Math.max(current - 1, 0);
            showStep(current);
          });
        });
    
        // Strand show/hide on Grade 11–12
        document.querySelectorAll('input[name="desired_grade"]').forEach(r => {
          r.addEventListener('change', e => {
            const panel = document.getElementById('strandSelection');
            const show = parseInt(e.target.value) >= 11;
            panel.style.display = show ? 'block' : 'none';
            panel.querySelectorAll('input').forEach(inp => inp.required = show);
          });
        });

        
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
