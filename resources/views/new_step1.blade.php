<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MCA Montessori School Enrollment Form</title>
  <link rel="stylesheet" href="{{ asset('css/styles_new_form.css') }}">
</head>
<body>
  
    <div class="enrollment-form">
      <a href="{{ url()->previous() }}" class="back-btn">Back</a>
        <div class="header">
          <div class="school-logo">
              <img src="{{asset('images/logo.png')}}" alt="School Logo">
          </div>
          <div class="school-name">
              <h2>MCA MONTESORRI SCHOOL</h2>
              <p>ONLINE ENROLLMENT FORM</p>
          </div>
        </div>
        
        <!-- Progress Bar Integration -->
        <div class="progress-container">
            <div class="progress-bar step-1">
                <div class="progress-step active">
                    <div class="step-circle">1</div>
                    <div class="step-title">Fill Out the Form</div>
                </div>
                <div class="progress-step">
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
  
  <form action="{{ route('enroll.new.step1.post') }}" method="POST">
    @csrf
    
    <h2>STEP 1. PLEASE FILL OUT FORM</h2>
    
    <fieldset>
      <legend>STRAND (pick one if SHS):</legend>

      @foreach([
        'ABM'   => 'ACCOUNTANCY AND BUSINESS MANAGEMENT (ABM)',
        'GAS'   => 'GENERAL ACADEMIC STRAND (GAS)',
        'STEM'  => 'SCIENCE, TECHNOLOGY, ENGINEERING & MATHEMATICS (STEM)',
        'HUMSS' => 'HUMANITIES AND SOCIAL SCIENCES (HUMSS)',
        'HE'    => 'HOME ECONOMICS (HE)',
        'ICT'   => 'INFORMATION & COMMUNICATIONS TECHNOLOGY (ICT)',
      ] as $code => $label)
        <div>
          <input
            type="radio"
            id="strand_{{ $code }}"
            name="strand"
            value="{{ $code }}"
            {{ old('strand') === $code ? 'checked' : '' }}
          >
          <label for="strand_{{ $code }}">{{ $label }}</label>
        </div>
      @endforeach

      @inject('errors', 'Illuminate\Support\ViewErrorBag')

      @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $err)
              <li>{{ $err }}</li>
            @endforeach
          </ul>
        </div>
      @endif
    </fieldset>

    <div>
      <span>SEMESTER (optional):</span>
      <label>
        <input
          type="radio"
          name="semester"
          value="1st"
          {{ old('semester') === '1st' ? 'checked' : '' }}
        > 1ST SEM
      </label>
      <label>
        <input
          type="radio"
          name="semester"
          value="2nd"
          {{ old('semester') === '2nd' ? 'checked' : '' }}
        > 2ND SEM
      </label>
      @error('semester')
        <div class="error">{{ $message }}</div>
      @enderror
    </div>
    
    <h3>Student's Profile</h3>
    
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
      <label for="contactNo">Contact NO:</label>
      <input type="tel" id="contactNo" name="contactNo" required>
      <span>**Required</span>
    </div>
    
    <div>
      <label for="email">Email Address:</label>
      <input type="email" id="email" name="email">
      <span>*Not Required</span>
    </div>
    
    <div>
      <label for="address">Home Address:</label>
      <input type="text" id="address" name="address" required>
      <span>**Required</span>
    </div>
    
    <div>
      <label for="livingWith">Living with whom: Relationship:</label>
      <input type="text" id="livingWith" name="livingWith" required>
      <span>**Required</span>
    </div>
    
    <div>
      <label for="dob">Date of Birth:</label>
      <input type="date" id="dob" name="dob" required>
      <span>**Required</span>
    </div>
    
    <div>
      <label for="birthplace">Birthplace:</label>
      <input type="text" id="birthplace" name="birthplace" required>
      <span>**Required</span>
    </div>
    
    <div>
      <label for="gender">Gender:</label>
      <input type="text" id="gender" name="gender" required>
      <span>**Required</span>
    </div>
    
    <div>
      <label for="religion">Religion:</label>
      <input type="text" id="religion" name="religion" required>
      <span>**Required</span>
    </div>
    
    <div>
      <label for="nationality">Nationality:</label>
      <input type="text" id="nationality" name="nationality" required>
      <span>**Required</span>
    </div>
    
    <h3>Former School Information</h3>
    
    <div>
      <label for="formerSchool">Name of Former School:</label>
      <input type="text" id="formerSchool" name="formerSchool" required>
      <span>**Required</span>
    </div>
    
    <div>
      <label for="previousGrade">Previous Grade:</label>
      <input type="text" id="previousGrade" name="previousGrade" required>
      <span>**Required</span>
    </div>
    
    <div>
      <label for="lastSchoolYear">School Year Last Attended:</label>
      <input type="text" id="lastSchoolYear" name="lastSchoolYear" required>
      <span>**Required</span>
    </div>
    
    <div>
      <label>School Type:</label>
      <input type="radio" id="private" name="schoolType" value="Private" required>
      <label for="private">Private</label>
      
      <input type="radio" id="public" name="schoolType" value="Public">
      <label for="public">Public</label>
      
      <input type="radio" id="homeschool" name="schoolType" value="Homeschool">
      <label for="homeschool">Homeschool</label>
      <span>**Required</span>
    </div>
    
    <div>
      <label for="schoolAddress">Address of Former School:</label>
      <input type="text" id="schoolAddress" name="schoolAddress" required>
      <span>**Required</span>
    </div>
    
    <div>
      <label for="reasonTransfer">Reason for Transfer:</label>
      <input type="text" id="reasonTransfer" name="reasonTransfer" required>
      <span>**Required</span>
    </div>
    
    <h3>For SHS Student only</h3>
    
    
    <div>
      <label>Are you a working student?</label>
      <input type="radio" id="workingYes" name="workingStudent" value="Yes">
      <label for="workingYes">Yes</label>
      
      <input type="radio" id="workingNo" name="workingStudent" value="No">
      <label for="workingNo">No</label>
    </div>
    
    <div>
      <label>Do you intend to be a working student?</label>
      <input type="radio" id="intendWorkingYes" name="intendWorkingStudent" value="Yes">
      <label for="intendWorkingYes">Yes</label>
      
      <input type="radio" id="intendWorkingNo" name="intendWorkingStudent" value="No">
      <label for="intendWorkingNo">No</label>
    </div>
    
    <div>
      <label for="siblings">How many siblings do you have?</label>
      <input type="text" id="siblings" name="siblings">
    </div>
    
    <div>
      <label>Are you a member of any club/organizations/fraternity/sorority?</label>
      <input type="radio" id="clubYes" name="clubMember" value="Yes">
      <label for="clubYes">Yes</label>
      
      <input type="radio" id="clubNo" name="clubMember" value="No">
      <label for="clubNo">No</label>
    </div>
    
    <div>
      <label for="clubName">If yes, what is the name of your club/organizations/fraternity/sorority?</label>
      <input type="text" id="clubName" name="clubName">
    </div>
    
    <h3>Family Information</h3>
    
    
    <table>
      <tr>
        <td><label for="fatherName">Father Name:</label></td>
        <td><input type="text" id="fatherName" name="fatherName" required></td>
      </tr>
      <tr>
        <td><label for="fatherOccupation">Father Occupation:</label></td>
        <td><input type="text" id="fatherOccupation" name="fatherOccupation" required></td>
      </tr>
      <tr>
        <td><label for="fatherContact">Father Contact No:</label></td>
        <td><input type="tel" id="fatherContact" name="fatherContact" required></td>
      </tr>
      <tr>
        <td><label for="fatherEmail">Father Email Add:</label></td>
        <td><input type="email" id="fatherEmail" name="fatherEmail" required></td>
      </tr>
      <tr>
        <td><label for="motherName">Mother Name:</label></td>
        <td><input type="text" id="motherName" name="motherName" required></td>
      </tr>
      <tr>
        <td><label for="motherOccupation">Mother Occupation:</label></td>
        <td><input type="text" id="motherOccupation" name="motherOccupation" required></td>
      </tr>
      <tr>
        <td><label for="motherContact">Mother Contact No:</label></td>
        <td><input type="tel" id="motherContact" name="motherContact" required></td>
      </tr>
      <tr>
        <td><label for="motherEmail">Mother Email Add:</label></td>
        <td><input type="email" id="motherEmail" name="motherEmail" required></td>
      </tr>
      <tr>
        <td><label for="guardianName">Guardian Name:</label></td>
        <td><input type="text" id="guardianName" name="guardianName" required></td>
      </tr>
      <tr>
        <td><label for="guardianOccupation">Guardian Occupation:</label></td>
        <td><input type="text" id="guardianOccupation" name="guardianOccupation" required></td>
      </tr>
      <tr>
        <td><label for="guardianContact">Guardian Contact No:</label></td>
        <td><input type="tel" id="guardianContact" name="guardianContact" required>
    </tr>
        <tr>
          <td><label for="guardianEmail">Guardian Email Add:</label></td>
          <td><input type="email" id="guardianEmail" name="guardianEmail" required></td>
        </tr>
      </table>
      
      <h3>Medical History</h3>
      <p>(Please check the box/es of your recent medical findings)</p> <br>
      
      <div>
        <input type="checkbox" id="asthma" name="medicalHistory" value="Asthma">
        <label for="asthma">Asthma</label>
      </div>
      
      <div>
        <input type="checkbox" id="physicallyFit" name="medicalHistory" value="PhysicallyFit">
        <label for="physicallyFit">Physically Fit</label>
      </div>
      
      <div>
        <input type="checkbox" id="seizure" name="medicalHistory" value="SeizureDisorder">
        <label for="seizure">Seizure Disorder</label>
      </div>
      
      <div>
        <input type="checkbox" id="allergy" name="medicalHistory" value="Allergy">
        <label for="allergy">Allergy: Please Specify:</label>
        <input type="text" id="allergySpecify" name="allergySpecify">
      </div>
      
      <div>
        <input type="checkbox" id="heartCondition" name="medicalHistory" value="HeartCondition">
        <label for="heartCondition">Heart Condition</label>
      </div>
      
      <div>
        <input type="checkbox" id="othersCondition" name="medicalHistory" value="Others">
        <label for="othersCondition">Others: Please Specify:</label>
        <input type="text" id="othersSpecify" name="othersSpecify">
      </div>
      
      <h3>Terms and Condition:</h3>
      
      
      <div>
        <input type="checkbox" id="term1" name="terms[]" value="completeness" required>
        <label for="term1">I hereby attest to the completeness and accuracy of all the information supplied in this form. I understand that withholding of information or giving false information will make me ineligible for admission, or or may jeopardize my continued stay after admission has been granted.</label>
      </div>
      
      <p>As a student of MCA Montessori School, Inc., I hereby agree to the following terms:</p>
      
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
    
    <button type="submit">Next</button>
  </form>
<script>
        
        function setProgress(step) {
            const progressBar = document.querySelector('.progress-bar');
            const steps = document.querySelectorAll('.progress-step');
            
            
            steps.forEach((stepEl, idx) => {
                stepEl.classList.remove('active', 'completed');
            });
            
            
            for (let i = 0; i < steps.length; i++) {
                if (i < step - 1) {
                    steps[i].classList.add('completed');
                } else if (i === step - 1) {
                    steps[i].classList.add('active');
                }
            }
            
            
            progressBar.className = 'progress-bar';
            progressBar.classList.add('step-' + step);
        }
        
        
        document.addEventListener('DOMContentLoaded', function() {
            setProgress(1);
        });
    </script>
</body>
</html>