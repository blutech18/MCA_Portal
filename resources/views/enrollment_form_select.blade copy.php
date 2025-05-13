<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('css/styles_enrollment_form.css') }}" />
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond&display=swap" rel="stylesheet">
    <title>Enrollment Form</title>
  </head>
  <body>

    <div class="enrollment-form">
        <div class="header">
            <div class="school-logo">
            <img src="{{ asset('images/logo.png') }}" alt="School Logo">
            </div>
            <div class="school-name">
            <h2>MCA MONTESSORI SCHOOL</h2>
            <p>ONLINE ENROLLMENT FORM</p>
            </div>
        </div>

        <div class="enrollment-timeline">
          <div class="step active">
            <!--<div class="circle">✓</div>-->
            <div class="circle">1</div>
            <div class="label">Enrollment Type</div>
          </div>
          <div class="connector"></div>
          <div class="step ">
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

        <div class="form-step active" data-step="1">
            <div class="input-field">
                <label for="student_type">Enrollment Type:</label>
                <select id="student_type" name="student_type" required>
                    <option value="" disabled selected>Select enrollment type</option>
                    <option value="new">New Student</option>
                    <option value="existing">Existing Student</option>
                </select>
            </div>

            <div class="form-navigation">
                <button type="button" id="enrollNext" class="btn-next">Next &raquo;</button>
            </div>
            <div class="info-section">
                <p class="note">Note: Please ensure that the information you provide is accurate and complete. This will help us process your enrollment smoothly.</p>
                <p>For any inquiries, please contact us at 09XXXXXXXXX or email@xxxxx.com </p>
                <p>Thank you for choosing MCA Montessori School!</p>
                <p>We look forward to welcoming you!</p>

            </div>
        </div>

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

    <script>
      document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('enrollNext').addEventListener('click', () => {
        const type = document.getElementById('student_type').value;
        if (!type) {
            alert('Please select an enrollment type.');
            return;
        }

        if (type === 'new') {
            window.location.href = "{{ route('enrollment_form') }}";
        } else if (type === 'existing') {
            window.location.href = "#";
        }
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
