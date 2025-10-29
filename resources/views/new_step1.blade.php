<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>MCA Montessori School Enrollment Form</title>
  <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
  <link rel="icon" href="{{ asset('favicon.ico') }}">
  <link rel="stylesheet" href="{{ asset('css/styles_new_form.css') }}?v={{ time() }}">
  <link rel="stylesheet" href="{{ asset('css/mobile-compatibility.css') }}">
  <style>
    #email {
      transition: border-color 0.3s ease, border-width 0.3s ease;
    }

    /* Assessment Recommendation Card Styles - System Color Theme */
    .assessment-recommendation {
      margin: 20px 0;
    }

    .recommendation-card {
      background: linear-gradient(135deg, rgba(122, 34, 43, 0.05) 0%, rgba(85, 26, 37, 0.05) 100%);
      border: 2px solid #7a222b;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 4px 12px rgba(122, 34, 43, 0.15);
      position: relative;
      overflow: hidden;
    }

    .recommendation-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, #7a222b, #551a25, #7a222b);
    }

    .recommendation-card h4 {
      color: #7a222b;
      margin: 0 0 15px 0;
      font-size: 18px;
      font-weight: 600;
    }

    .recommendation-content {
      color: #2b0f12;
    }

    .recommendation-text {
      font-size: 16px;
      margin-bottom: 15px;
      line-height: 1.5;
    }

    .recommended-strand {
      color: #7a222b;
      font-weight: bold;
      font-size: 18px;
      background: rgba(122, 34, 43, 0.1);
      padding: 2px 8px;
      border-radius: 6px;
    }

    .assessment-details {
      background: rgba(255, 255, 255, 0.7);
      padding: 15px;
      border-radius: 8px;
      margin: 10px 0;
      border: 1px solid rgba(122, 34, 43, 0.2);
    }

    .assessment-details p {
      margin: 5px 0;
      font-size: 14px;
      color: #2b0f12;
    }

    .score-breakdown {
      margin-top: 10px;
    }

    .score-breakdown summary {
      cursor: pointer;
      font-weight: 600;
      color: #7a222b;
      padding: 8px;
      background: rgba(122, 34, 43, 0.1);
      border-radius: 4px;
      border: 1px solid rgba(122, 34, 43, 0.2);
      transition: background-color 0.3s ease;
    }

    .score-breakdown summary:hover {
      background: rgba(122, 34, 43, 0.2);
      border-color: #7a222b;
    }

    .score-breakdown ul {
      margin: 10px 0 0 20px;
      padding: 0;
    }

    .score-breakdown li {
      margin: 5px 0;
      font-size: 14px;
      color: #2b0f12;
    }

    .note {
      font-style: italic;
      color: #551a25;
      font-size: 14px;
      margin-top: 15px;
      padding: 10px;
      background: rgba(255, 255, 255, 0.5);
      border-radius: 6px;
      border-left: 4px solid #7a222b;
    }

    /* Modal styles for assessment email capture */
    .modal {
      display: none;
      position: fixed;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      justify-content: center;
      align-items: center;
      z-index: 1000;
    }

    .modal-content {
      background: white;
      padding: 30px;
      border-radius: 12px;
      text-align: center;
      max-width: 400px;
      width: 90%;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
    }

    .modal-content h3 {
      color: #2e7d32;
      margin-bottom: 15px;
    }

    .modal-content input[type="email"] {
      width: 100%;
      padding: 12px;
      border: 2px solid #ddd;
      border-radius: 8px;
      font-size: 16px;
      margin: 15px 0;
      box-sizing: border-box;
    }

    .modal-content input[type="email"]:focus {
      outline: none;
      border-color: #4CAF50;
    }

    .modal-buttons {
      display: flex;
      gap: 10px;
      justify-content: center;
      margin-top: 20px;
    }

    .modal-buttons .btn {
      padding: 10px 20px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .modal-buttons .confirm-btn {
      background: #4CAF50;
      color: white;
    }

    .modal-buttons .confirm-btn:hover {
      background: #45a049;
    }

    .modal-buttons .confirm-btn:disabled {
      background: #ccc;
      cursor: not-allowed;
    }

    .modal-buttons .cancel-btn {
      background: #f44336;
      color: white;
    }

    .modal-buttons .cancel-btn:hover {
      background: #da190b;
    }
  </style>
</head>
<body>
  
    <div class="enrollment-form">
      <a href="javascript:void(0)" class="back-btn" onclick="handleBackButton()">Back</a>
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
  
  <!-- 
    DEBUGGING MODE ENABLED:
    - Form submission is now ENABLED for testing database connection
    - Console logs only appear when clicking "Next" button (not continuously)
    - Check browser console for detailed validation logs on form submission
    - Form will now proceed to Step 2 if validation passes
  -->
  <form action="{{ route('enroll.new.step1.post') }}" method="POST">
    @csrf
    
    <h2>STEP 1. PLEASE FILL OUT FORM</h2>
    
    <!-- Move Grade Level Information to the top for better flow -->
    <h3>Grade Level Information</h3>
    <div>
      <label>Grade Level:</label>
      <input type="radio" id="jhs" name="gradeLevel" value="JHS">
      <label for="jhs">Junior High School (JHS)</label>
      
      <input type="radio" id="shs" name="gradeLevel" value="SHS">
      <label for="shs">Senior High School (SHS)</label>
      <span style="color: #9a3a44;">**Required - Please select one</span>
    </div>

    <!-- JHS Grade Selection (Grade 7, 8, 9, 10) -->
    <div id="jhsGradeSelection" style="display: none;">
      <h4>JHS Grade Level Selection</h4>
      <div>
        <label>Select your JHS Grade Level:</label>
        <input type="radio" id="grade7" name="jhsGrade" value="7">
        <label for="grade7">Grade 7</label>
        
        <input type="radio" id="grade8" name="jhsGrade" value="8">
        <label for="grade8">Grade 8</label>
        
        <input type="radio" id="grade9" name="jhsGrade" value="9">
        <label for="grade9">Grade 9</label>
        
        <input type="radio" id="grade10" name="jhsGrade" value="10">
        <label for="grade10">Grade 10</label>
        <span style="color: #9a3a44;">**Required for JHS students</span>
      </div>
    </div>

    <!-- SHS Grade Selection (Grade 11 or 12) -->
    <div id="shsGradeSelection" style="display: none;">
      <h4>SHS Grade Level Selection</h4>
      <div>
        <label>Select your SHS Grade Level:</label>
        <input type="radio" id="grade11" name="shsGrade" value="11">
        <label for="grade11">Grade 11</label>
        
        <input type="radio" id="grade12" name="shsGrade" value="12">
        <label for="grade12">Grade 12</label>
        <span style="color: #9a3a44;">**Required for SHS students</span>
      </div>
    </div>

    <!-- Assessment Recommendation Card (for SHS students) -->
    @if($assessmentResult && session('assessment_auto_fill'))
    <div id="assessment-recommendation" class="assessment-recommendation" style="display: none;">
      <div class="recommendation-card">
        <h4>🎯 Strand Assessment Recommendation</h4>
        <div class="recommendation-content">
          <p class="recommendation-text">
            <strong>Based on your assessment results, we recommend: <span class="recommended-strand">{{ $assessmentResult->recommended_strand }}</span></strong>
          </p>
          <div class="assessment-details">
            <p><strong>Assessment Score:</strong> {{ $assessmentResult->scores[$assessmentResult->recommended_strand] }}/25 ({{ number_format($assessmentResult->getScorePercentage(), 1) }}%)</p>
            <details class="score-breakdown">
              <summary>View Top 3 Strand Scores</summary>
              <ul>
                @foreach($assessmentResult->getTopThreeStrands() as $strandName => $score)
                <li><strong>{{ $strandName }}:</strong> {{ $score }}/25 ({{ number_format(($score/25)*100, 1) }}%)</li>
                @endforeach
              </ul>
            </details>
          </div>
          <p class="note"><em>💡 You can still choose a different strand below if you prefer.</em></p>
        </div>
      </div>
    </div>
    @endif

    <fieldset id="strandFieldset">
      <legend>STRAND (pick one if SHS):
        <button type="button" id="refreshStrandAvailability" style="margin-left:10px; padding:4px 8px; font-size:12px;">Refresh Availability</button>
      </legend>

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
            data-code="{{ $code }}"
          >
          <label for="strand_{{ $code }}">{{ $label }}
            <span id="availability_{{ $code }}" style="margin-left:6px; font-weight:600;">
              <!-- availability will be injected here -->
            </span>
          </label>
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

    <div id="semesterSection" style="display: none;">
      <span>SEMESTER (required for SHS only):</span>
      <label>
        <input
          type="radio"
          name="semester"
          value="1st"
        > 1ST SEM
      </label>
      <label>
        <input
          type="radio"
          name="semester"
          value="2nd"
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
      <input type="text" id="middleName" name="middleName">
      <span>*Optional</span>
    </div>
    
    <div>
      <label for="lrn">Learner Reference Number (LRN):</label>
      <input type="text" id="lrn" name="lrn" pattern="^[0-9]{12}$" maxlength="12" inputmode="numeric" required>
      <span>**Required - Exactly 12 digits</span>
      <div class="validation-message" id="lrnValidation" style="color: #9a3a44; font-size: 14px; margin-top: 5px; display: none;">LRN must be exactly 12 digits</div>
    </div>
    
    <div>
      <label for="contactNo">Contact NO:</label>
      <input type="tel" id="contactNo" name="contactNo" pattern="09[0-9]{9}" maxlength="11" placeholder="09XXXXXXXXX" required>
      <span>**Required - Format: 09XXXXXXXXX</span>
      <div class="validation-message" id="contactNoValidation" style="color: #9a3a44; font-size: 14px; margin-top: 5px; display: none;">Please enter a valid 11-digit mobile number starting with 09</div>
    </div>
    
    <div>
      <label for="email">Email Address:</label>
      <input type="email" id="email" name="email" placeholder="you@example.com" required>
      <span>**Required</span>
    </div>
    
    <h4>Home Address</h4>
    
    <div>
      <label for="address_house">House No. / Street Address:</label>
      <input type="text" id="address_house" name="address_house" required>
      <span>**Required</span>
    </div>
    
    <div>
      <label for="address_unit">Apt., Suite, Unit, etc.:</label>
      <input type="text" id="address_unit" name="address_unit">
      <span>*Optional</span>
    </div>
    
    <div>
      <label for="address_city">City:</label>
      <select id="address_city" name="address_city" required>
        <option value="">-- Select City --</option>
        <option value="Metro Manila" selected>Metro Manila</option>
        <option value="Quezon City">Quezon City</option>
        <option value="Manila">Manila</option>
        <option value="Makati">Makati</option>
        <option value="Pasig">Pasig</option>
        <option value="Taguig">Taguig</option>
        <option value="Las Pinas">Las Pinas</option>
        <option value="Muntinlupa">Muntinlupa</option>
        <option value="Paranaque">Parañaque</option>
        <option value="Pasay">Pasay</option>
        <option value="Marikina">Marikina</option>
        <option value="Mandaluyong">Mandaluyong</option>
        <option value="San Juan">San Juan</option>
        <option value="Valenzuela">Valenzuela</option>
        <option value="Malabon">Malabon</option>
        <option value="Caloocan">Caloocan</option>
        <option value="Navotas">Navotas</option>
        <option value="Calamba">Calamba</option>
        <option value="Antipolo">Antipolo</option>
        <option value="Batangas City">Batangas City</option>
        <option value="Cabuyao">Cabuyao</option>
        <option value="Laguna">Laguna</option>
        <option value="Los Baños">Los Baños</option>
        <option value="San Pedro">San Pedro</option>
        <option value="Santa Rosa">Santa Rosa</option>
        <option value="Angeles">Angeles</option>
        <option value="Olongapo">Olongapo</option>
        <option value="San Fernando (Pampanga)">San Fernando (Pampanga)</option>
        <option value="Baguio">Baguio</option>
        <option value="Dagupan">Dagupan</option>
        <option value="Baler">Baler</option>
        <option value="Ilagan">Ilagan</option>
        <option value="Tuguegarao">Tuguegarao</option>
        <option value="Naga">Naga</option>
        <option value="Iriga">Iriga</option>
        <option value="Legazpi">Legazpi</option>
        <option value="Sorsogon City">Sorsogon City</option>
        <option value="Lucena">Lucena</option>
        <option value="Tayabas">Tayabas</option>
        <option value="Calapan">Calapan</option>
        <option value="Puerto Princesa">Puerto Princesa</option>
      </select>
      <span>**Required</span>
      <div class="validation-message" id="addressCityValidation" style="color: #9a3a44; font-size: 14px; margin-top: 5px; display: none;">Please select a city</div>
    </div>
    
    <!-- Hidden field to store the combined address -->
    <input type="hidden" id="address" name="address">
    
    <!-- Removed Living with whom: relationship field per requirement -->
    
    <div>
      <label for="dob">Date of Birth:</label>
      <input type="date" id="dob" name="dob" min="1950-01-01" max="" required>
      <span>**Required</span>
      <div class="validation-message" id="dobValidation" style="color: #9a3a44; font-size: 14px; margin-top: 5px; display: none;">Student must be born before 2015 to enroll</div>
    </div>
    
    <div>
      <label for="birthplace">Birthplace:</label>
      <input type="text" id="birthplace" name="birthplace" required>
      <span>**Required</span>
    </div>
    
    <div>
      <label for="gender">Gender:</label>
      <select id="gender" name="gender" required>
        <option value="">-- Select Gender --</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Other">Other</option>
      </select>
      <span>**Required</span>
    </div>
    
    <div>
      <label for="religion">Religion:</label>
      <input type="text" id="religion" name="religion"  required>
      <span>**Required</span>
    </div>
    
    <div>
      <label for="nationality">Nationality:</label>
      <input type="text" id="nationality" name="nationality"  required>
      <span>**Required</span>
    </div>
    
    <h3>Former School Information</h3>
    
    <div>
      <label for="formerSchool">Name of Former School:</label>
      <input type="text" id="formerSchool" name="formerSchool"  required>
      <span>**Required</span>
    </div>
    
    
    <div>
      <label for="lastSchoolYear">School Year Last Attended:</label>
      <select id="lastSchoolYear" name="lastSchoolYear" required>
        <option value="">-- Select School Year --</option>
        <option value="2010-2011">2010-2011</option>
        <option value="2011-2012">2011-2012</option>
        <option value="2012-2013">2012-2013</option>
        <option value="2013-2014">2013-2014</option>
        <option value="2014-2015">2014-2015</option>
        <option value="2015-2016">2015-2016</option>
        <option value="2016-2017">2016-2017</option>
        <option value="2017-2018">2017-2018</option>
        <option value="2018-2019">2018-2019</option>
        <option value="2019-2020">2019-2020</option>
        <option value="2020-2021">2020-2021</option>
        <option value="2021-2022">2021-2022</option>
        <option value="2022-2023">2022-2023</option>
        <option value="2023-2024">2023-2024</option>
        <option value="2024-2025">2024-2025</option>
        <option value="2025-2026">2025-2026</option>
      </select>
      <span>**Required</span>
    </div>
    
    <div>
      <label>School Type:</label>
      <input type="radio" id="private" name="schoolType" value="Private"  required>
      <label for="private">Private</label>
      
      <input type="radio" id="public" name="schoolType" value="Public" >
      <label for="public">Public</label>
      
      <input type="radio" id="homeschool" name="schoolType" value="Homeschool" >
      <label for="homeschool">Homeschool</label>
      <span>**Required</span>
    </div>
    
    <div>
      <label for="schoolAddress">Address of Former School:</label>
      <input type="text" id="schoolAddress" name="schoolAddress"  required>
      <span>**Required</span>
    </div>
    
    <div>
      <label for="reasonTransfer">Reason for Transfer:</label>
      <input type="text" id="reasonTransfer" name="reasonTransfer"  required>
      <span>**Required</span>
    </div>
    
    <div id="shsOnlySection" style="display: none;">
      <h3 id="shsOnlyHeader">For SHS Student only</h3>
    
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
      <input type="number" id="siblings" name="siblings" min="0" max="20" pattern="[0-9]*" inputmode="numeric" placeholder="Enter number of siblings">
      <span>*Optional - Numbers only (0-20)</span>
    </div>
    
    <div>
      <label>Are you a member of any club/organizations/fraternity/sorority?</label>
      <input type="radio" id="clubYes" name="clubMember" value="Yes">
      <label for="clubYes">Yes</label>
      
      <input type="radio" id="clubNo" name="clubMember" value="No">
      <label for="clubNo">No</label>
    </div>
    
    <div id="clubNameSection" style="display: none;">
      <label for="clubName">If yes, what is the name of your club/organizations/fraternity/sorority?</label>
      <input type="text" id="clubName" name="clubName">
      <span style="color: #9a3a44;">**Required when Yes is selected</span>
    </div>
    
    </div> <!-- End of shsOnlySection -->
    
    <h3>Family Information</h3>
    
    
    <table>
      <tr>
        <td><label for="fatherName">Father Name:</label></td>
        <td><input type="text" id="fatherName" name="fatherName"  required></td>
      </tr>
      <tr>
        <td><label for="fatherOccupation">Father Occupation:</label></td>
        <td><input type="text" id="fatherOccupation" name="fatherOccupation"  required></td>
      </tr>
      <tr>
        <!-- Father contact removed per requirement -->
      </tr>
      <tr>
        <td><label for="motherName">Mother Name:</label></td>
        <td><input type="text" id="motherName" name="motherName"  required></td>
      </tr>
      <tr>
        <td><label for="motherOccupation">Mother Occupation:</label></td>
        <td><input type="text" id="motherOccupation" name="motherOccupation"  required></td>
      </tr>
      <tr>
        <!-- Mother contact removed per requirement -->
      </tr>
      <tr>
        <td><label for="guardianName">Guardian Name:</label></td>
        <td><input type="text" id="guardianName" name="guardianName"  required></td>
      </tr>
      <tr>
        <td><label for="guardianOccupation">Guardian Occupation:</label></td>
        <td><input type="text" id="guardianOccupation" name="guardianOccupation"  required></td>
      </tr>
      <tr>
        <td><label for="guardianContact">Guardian Contact No:</label></td>
        <td><input type="tel" id="guardianContact" name="guardianContact" pattern="^09[0-9]{9}$" maxlength="11" placeholder="09XXXXXXXXX"  required></td>
    </tr>
      <!-- Removed guardian email field per requirement -->
      </table>
      
      <h3>Medical History</h3>
      <p>(Please check the box/es of your recent medical findings)</p> <br>
      
      <div>
        <input type="checkbox" id="asthma" name="medicalHistory[]" value="Asthma">
        <label for="asthma">Asthma</label>
      </div>
      
      <div>
        <input type="checkbox" id="physicallyFit" name="medicalHistory[]" value="PhysicallyFit">
        <label for="physicallyFit">Physically Fit</label>
      </div>
      
      <div>
        <input type="checkbox" id="seizure" name="medicalHistory[]" value="SeizureDisorder">
        <label for="seizure">Seizure Disorder</label>
      </div>
      
      <div>
        <input type="checkbox" id="allergy" name="medicalHistory[]" value="Allergy">
        <label for="allergy">Allergy: Please Specify:</label>
        <input type="text" id="allergySpecify" name="allergySpecify">
      </div>
      
      <div>
        <input type="checkbox" id="heartCondition" name="medicalHistory[]" value="HeartCondition">
        <label for="heartCondition">Heart Condition</label>
      </div>
      
      <div>
        <input type="checkbox" id="othersCondition" name="medicalHistory[]" value="Others">
        <label for="othersCondition">Others: Please Specify:</label>
        <input type="text" id="othersSpecify" name="othersSpecify">
      </div>
      
      <h3>Terms and Condition:</h3>
      
      <div>
        <input type="checkbox" class="term" id="term1" name="terms[]" value="completeness"  required>
        <label for="term1">I hereby attest to the completeness and accuracy of all the information supplied in this form. I understand that withholding of information or giving false information will make me ineligible for admission, or or may jeopardize my continued stay after admission has been granted.</label>
      </div>
      
      <p>As a student of MCA Montessori School, Inc., I hereby agree to the following terms:</p>
      
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

      <div>
        <input type="checkbox" id="checkAllTerms" >
        <label for="checkAllTerms">Check All Terms and Conditions</label>
      </div>
    
    <button type="submit" id="submitBtn" disabled>Next</button>
  </form>
    <!-- Mobile Compatibility Script -->
    <script src="{{ asset('js/mobile-compatibility.js') }}"></script>
    
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
        
        // Validation functions
        function validateContactNumber(contactNo) {
            const pattern = /^09[0-9]{9}$/;
            return pattern.test(contactNo);
        }
        
        function validateEmail(email) {
            if (!email || email.trim() === '') {
                return false; // Email is required
            }
            
            // More robust email validation regex
            const pattern = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
            
            // Additional checks
            if (email.length > 254) return false; // RFC 5321 limit
            if (email.indexOf('..') !== -1) return false; // No consecutive dots
            if (email.startsWith('.') || email.endsWith('.')) return false; // No leading/trailing dots
            if (email.indexOf('@') !== email.lastIndexOf('@')) return false; // Only one @ symbol
            if (!pattern.test(email)) return false;

            // Enforce gmail.com domain only (case-insensitive)
            return /@gmail\.com$/i.test(email.trim());
        }
        
        function validateLastSchoolYear(value) {
            if (!value || value.trim() === '') {
                return false; // Empty value is invalid (required field)
            }
            
            // For dropdown, check if a valid school year option is selected
            const validSchoolYears = [
                '2010-2011', '2011-2012', '2012-2013', '2013-2014', '2014-2015', 
                '2015-2016', '2016-2017', '2017-2018', '2018-2019', '2019-2020', 
                '2020-2021', '2021-2022', '2022-2023', '2023-2024', '2024-2025', '2025-2026'
            ];
            return validSchoolYears.includes(value);
        }
        
        function validateDateOfBirth(dateValue) {
            if (!dateValue) {
                return false; // Empty value is invalid (required field)
            }
            
            const selectedDate = new Date(dateValue);
            
            // Check if it's a valid date
            if (isNaN(selectedDate.getTime())) {
                return false;
            }
            
            // Set year range limits
            const today = new Date();
            const currentYear = today.getFullYear();
            const minYear = 1950;
            const maxYear = 2014; // Reject students born from 2015 to present
            
            // Set min and max dates
            const minDate = new Date(minYear, 0, 1); // January 1, 1950
            const maxDate = new Date(maxYear, 11, 31); // December 31, 2014
            
            // Check if date is within acceptable range
            const isWithinRange = selectedDate >= minDate && selectedDate <= maxDate;
            
            // Also check birth year explicitly
            const birthYear = selectedDate.getFullYear();
            return isWithinRange && birthYear < 2015;
        }
        
        // Function to combine address fields
        function combineAddressFields() {
            const addressHouse = document.getElementById('address_house').value.trim();
            const addressUnit = document.getElementById('address_unit').value.trim();
            const addressCity = document.getElementById('address_city').value;
            const addressField = document.getElementById('address');
            
            let combinedAddress = '';
            
            if (addressHouse) {
                combinedAddress += addressHouse;
            }
            
            if (addressUnit) {
                combinedAddress += ', ' + addressUnit;
            }
            
            if (addressCity) {
                combinedAddress += ', ' + addressCity;
            }
            
            addressField.value = combinedAddress;
            console.log('Combined address:', combinedAddress);
        }
        
        // Global required fields array
            const requiredFields = [
            'surname', 'givenName', 'lrn', 'contactNo', 'email',
            'address_house', 'address_city', 'dob', 'birthplace', 'gender', 
                'religion', 'nationality', 'formerSchool',
                'lastSchoolYear', 'schoolAddress', 'reasonTransfer',
            'fatherName', 'fatherOccupation',
            'motherName', 'motherOccupation',
            'guardianName', 'guardianOccupation', 'guardianContact'
        ];

        function validateRequiredFields(showLogs = false) {
            if (showLogs) {
                console.log('=== VALIDATING REQUIRED FIELDS ===');
            }
            let allValid = true;
            let debugInfo = [];
            
            // Check required fields
            requiredFields.forEach(fieldName => {
                const field = document.getElementById(fieldName);
                if (field && !field.value.trim()) {
                    allValid = false;
                    debugInfo.push(`Missing: ${fieldName}`);
                    if (showLogs) console.log(`❌ Missing field: ${fieldName}`);
                } else if (field && showLogs) {
                    console.log(`✅ Field ${fieldName}: "${field.value}"`);
                } else if (!field && showLogs) {
                    console.log(`⚠️ Field not found: ${fieldName}`);
                }
            });
            
            // Check radio buttons
            const schoolType = document.querySelector('input[name="schoolType"]:checked');
            if (!schoolType) {
                allValid = false;
                debugInfo.push('Missing: schoolType');
                if (showLogs) console.log('❌ Missing: schoolType');
            } else if (showLogs) {
                console.log(`✅ School Type: ${schoolType.value}`);
            }
            
            // Check terms checkboxes: require all 6
            const terms = document.querySelectorAll('input[name="terms[]"]:checked');
            if (terms.length < 6) {
                allValid = false;
                debugInfo.push(`Terms: ${terms.length}/6 checked`);
                if (showLogs) console.log(`❌ Terms: ${terms.length}/6 checked`);
            } else if (showLogs) {
                console.log(`✅ Terms: ${terms.length}/6 checked`);
            }

            // Require semester only for SHS students
            const shsRadioCheck = document.getElementById('shs');
            if (shsRadioCheck && shsRadioCheck.checked) {
                const semesterChecked = document.querySelector('input[name="semester"]:checked');
                if (!semesterChecked) {
                    allValid = false;
                    debugInfo.push('Missing: semester (required for SHS)');
                    if (showLogs) console.log('❌ Missing: semester (required for SHS)');
                } else {
                    debugInfo.push(`Semester: ${semesterChecked.value}`);
                    if (showLogs) console.log(`✅ Semester: ${semesterChecked.value}`);
                }
            }
            
            // Validate contact number
            const contactNo = document.getElementById('contactNo').value;
            if (!validateContactNumber(contactNo)) {
                allValid = false;
                debugInfo.push('Invalid contact number');
            }
            
            // Validate email
            const email = document.getElementById('email').value;
            if (!validateEmail(email)) {
                allValid = false;
                debugInfo.push('Invalid email');
            }

            // Validate LRN
            const lrn = document.getElementById('lrn').value;
            if (!/^\d{12}$/.test(lrn)) {
                allValid = false;
                debugInfo.push('Invalid LRN');
            }
            
            // Validate last school year
            const lastSchoolYear = document.getElementById('lastSchoolYear').value;
            if (!validateLastSchoolYear(lastSchoolYear)) {
                allValid = false;
                debugInfo.push('Invalid last school year');
            }
            
            // Validate date of birth
            const dob = document.getElementById('dob').value;
            if (!validateDateOfBirth(dob)) {
                allValid = false;
                debugInfo.push('Invalid date of birth');
            }
            
            // Check SHS-specific fields if SHS is selected
            const shsCheckbox = document.getElementById('shs');
            if (shsCheckbox && shsCheckbox.checked) {
                if (showLogs) console.log('🔍 Checking SHS-specific fields...');
                
                // Check if SHS grade is selected
                const shsGradeSelected = document.querySelector('input[name="shsGrade"]:checked');
                if (!shsGradeSelected) {
                    allValid = false;
                    debugInfo.push('Missing: SHS Grade Level');
                    if (showLogs) console.log('❌ Missing: SHS Grade Level');
                } else if (showLogs) {
                    console.log(`✅ SHS Grade: ${shsGradeSelected.value}`);
                }
                
                // Check if strand is selected
                const strandSelected = document.querySelector('input[name="strand"]:checked');
                if (!strandSelected) {
                    allValid = false;
                    debugInfo.push('Missing: Strand');
                    if (showLogs) console.log('❌ Missing: Strand');
                } else if (showLogs) {
                    console.log(`✅ Strand: ${strandSelected.value}`);
                }
                
                // Check working student radio
                const workingStudentSelected = document.querySelector('input[name="workingStudent"]:checked');
                if (!workingStudentSelected) {
                    allValid = false;
                    debugInfo.push('Missing: Working Student selection');
                    if (showLogs) console.log('❌ Missing: Working Student selection');
                } else if (showLogs) {
                    console.log(`✅ Working Student: ${workingStudentSelected.value}`);
                }
                
                // Check intend working student radio
                const intendWorkingSelected = document.querySelector('input[name="intendWorkingStudent"]:checked');
                if (!intendWorkingSelected) {
                    allValid = false;
                    debugInfo.push('Missing: Intend Working Student selection');
                    if (showLogs) console.log('❌ Missing: Intend Working Student selection');
                } else if (showLogs) {
                    console.log(`✅ Intend Working Student: ${intendWorkingSelected.value}`);
                }
                
                // Check club member radio
                const clubMemberSelected = document.querySelector('input[name="clubMember"]:checked');
                if (!clubMemberSelected) {
                    allValid = false;
                    debugInfo.push('Missing: Club Member selection');
                    if (showLogs) console.log('❌ Missing: Club Member selection');
                } else {
                    if (showLogs) console.log(`✅ Club Member: ${clubMemberSelected.value}`);
                    if (clubMemberSelected.value === 'Yes') {
                        // If club member is Yes, check if club name is filled
                        const clubNameInput = document.getElementById('clubName');
                        if (!clubNameInput || !clubNameInput.value.trim()) {
                            allValid = false;
                            debugInfo.push('Missing: Club Name (required when Club Member is Yes)');
                            if (showLogs) console.log('❌ Missing: Club Name (required when Club Member is Yes)');
                        } else if (showLogs) {
                            console.log(`✅ Club Name: ${clubNameInput.value}`);
                        }
                    }
                }
            }
            
            // Check JHS-specific fields if JHS is selected
            const jhsCheckbox = document.getElementById('jhs');
            if (jhsCheckbox && jhsCheckbox.checked) {
                if (showLogs) console.log('🔍 Checking JHS-specific fields...');
                
                // Check if JHS grade is selected
                const jhsGradeSelected = document.querySelector('input[name="jhsGrade"]:checked');
                if (!jhsGradeSelected) {
                    allValid = false;
                    debugInfo.push('Missing: JHS Grade Level');
                    if (showLogs) console.log('❌ Missing: JHS Grade Level');
                } else if (showLogs) {
                    console.log(`✅ JHS Grade: ${jhsGradeSelected.value}`);
                }
            }
            
            // Check if at least one grade level (JHS or SHS) is selected
            const jhsChecked = jhsCheckbox && jhsCheckbox.checked;
            const shsChecked = shsCheckbox && shsCheckbox.checked;
            if (!jhsChecked && !shsChecked) {
                allValid = false;
                debugInfo.push('Missing: Grade Level (must select JHS or SHS)');
                if (showLogs) console.log('❌ Missing: Grade Level (must select JHS or SHS)');
            } else if (showLogs) {
                console.log(`✅ Grade Level selected: ${jhsChecked ? 'JHS' : ''}${shsChecked ? 'SHS' : ''}`);
            }
            
            // Validate siblings (optional but must be valid number if provided)
            const siblings = document.getElementById('siblings').value.trim();
            if (siblings && (isNaN(siblings) || siblings < 0 || siblings > 20)) {
                allValid = false;
                debugInfo.push('Invalid siblings number (must be 0-20)');
                if (showLogs) console.log('❌ Invalid siblings number (must be 0-20)');
            } else if (siblings && showLogs) {
                console.log(`✅ Siblings: ${siblings}`);
            } else if (showLogs && !siblings) {
                console.log('✅ Siblings: (empty - optional field)');
            }
            
            // Debug logging (only when showLogs is true)
            if (showLogs) {
                if (!allValid) {
                    console.log('❌ FORM VALIDATION FAILED:', debugInfo);
                    console.log('=== VALIDATION SUMMARY ===');
                    debugInfo.forEach(info => console.log(`- ${info}`));
                } else {
                    console.log('✅ FORM VALIDATION PASSED!');
                    console.log('=== VALIDATION SUMMARY ===');
                    console.log('All required fields are filled and valid');
                }
                console.log('=== END VALIDATION ===');
            }
            
            return allValid;
        }
        
        function updateSubmitButton() {
            const submitBtn = document.getElementById('submitBtn');
            const isValid = validateRequiredFields();
            submitBtn.disabled = !isValid;
            
            if (isValid) {
                submitBtn.style.backgroundColor = '#7a222b';
                submitBtn.style.cursor = 'pointer';
            } else {
                submitBtn.style.backgroundColor = '#d1a1a6';
                submitBtn.style.cursor = 'not-allowed';
            }
        }
        
        // Browser history handling
        function handleBackButton() {
            // Check if there's a previous page in history
            if (window.history.length > 1) {
                window.history.back();
            } else {
                // Fallback to route navigation
                window.location.href = '{{ route('enroll.select') }}';
            }
        }
        
        // Add event listeners for real-time validation
        // Function to clear all cached data for new student enrollment
        function clearAllCachedData() {
            // Clear form data cache - use the correct cache key
            localStorage.removeItem('new_step1_form_cache_v1');
            localStorage.removeItem('new_step2_form_data');
            localStorage.removeItem('new_step3_form_data');
            
            // Clear file caches
            const fileInputs = ['reportCard', 'goodMoral', 'birthCertificate', 'idPicture'];
            fileInputs.forEach(inputId => {
                localStorage.removeItem(`new_step2_${inputId}`);
            });
            localStorage.removeItem(`new_step3_receiptUpload`);
            
            console.log('All cached data cleared for new student enrollment');
        }

        document.addEventListener('DOMContentLoaded', function() {
            setProgress(1);
            
            // Clear cached data on fresh page load (when starting new enrollment)
            // Check if this is a fresh start (no session data indicating existing enrollment)
            let cacheCleared = false;
            if (!sessionStorage.getItem('new_enrollee_id') && !sessionStorage.getItem('enrollment_in_progress')) {
                clearAllCachedData();
                cacheCleared = true;
                console.log('Fresh enrollment started - cached data cleared');
            }
            // LRN validation
            const lrnInput = document.getElementById('lrn');
            lrnInput.addEventListener('input', function() {
                // strip non-digits and cap length
                this.value = this.value.replace(/\D/g, '').slice(0, 12);
                const validationMsg = document.getElementById('lrnValidation');
                if (this.value.length !== 12) {
                    validationMsg.style.display = 'block';
                    this.style.borderColor = '#9a3a44';
                } else {
                    validationMsg.style.display = 'none';
                    this.style.borderColor = '';
                }
                updateSubmitButton();
            });

            // Text-only fields: block numeric input (excluding address which allows alphanumeric)
            const textOnlyIds = ['surname','givenName','middleName','birthplace','religion','nationality','formerSchool','schoolAddress','reasonTransfer','fatherName','fatherOccupation','motherName','motherOccupation','guardianName','guardianOccupation'];
            textOnlyIds.forEach(id => {
                const el = document.getElementById(id);
                if (el) {
                    el.addEventListener('input', function() {
                        const original = this.value;
                        this.value = this.value.replace(/[0-9]/g, '');
                        if (this.value !== original) {
                            this.style.borderColor = '#9a3a44';
                        } else {
                            this.style.borderColor = '';
                        }
                        updateSubmitButton();
                    });
                }
            });
            
            // Address fields event listeners
            const addressHouse = document.getElementById('address_house');
            const addressUnit = document.getElementById('address_unit');
            const addressCity = document.getElementById('address_city');
            
            if (addressHouse) {
                addressHouse.addEventListener('input', function() {
                    updateSubmitButton();
                    cacheFormData();
                });
            }
            
            if (addressUnit) {
                addressUnit.addEventListener('input', function() {
                    updateSubmitButton();
                    cacheFormData();
                });
            }
            
            if (addressCity) {
                addressCity.addEventListener('change', function() {
                    const validationMsg = document.getElementById('addressCityValidation');
                    if (this.value === '') {
                        if (validationMsg) validationMsg.style.display = 'block';
                        this.style.borderColor = '#9a3a44';
                    } else {
                        if (validationMsg) validationMsg.style.display = 'none';
                        this.style.borderColor = '';
                    }
                    updateSubmitButton();
                    cacheFormData();
                });
            }

            // SHS-only fields visibility
            const shsRadio = document.getElementById('shs');
            const jhsRadio = document.getElementById('jhs');
            const shsOnlyHeader = document.getElementById('shsOnlyHeader');
            const shsOnlyBlocks = [
                document.getElementById('strandFieldset'),
                document.getElementById('shsOnlySection'),
            ];
            function updateShsVisibility() {
                const isShs = shsRadio && shsRadio.checked;
                const isJhs = jhsRadio && jhsRadio.checked;
                
                shsOnlyBlocks.forEach(block => { if (block) block.style.display = isShs ? '' : 'none'; });
                if (shsOnlyHeader) shsOnlyHeader.style.display = isShs ? '' : 'none';
                
                // Show/hide SHS grade selection
                const shsGradeSelection = document.getElementById('shsGradeSelection');
                if (shsGradeSelection) {
                    shsGradeSelection.style.display = isShs ? 'block' : 'none';
                }
                
                // Show/hide JHS grade selection
                const jhsGradeSelection = document.getElementById('jhsGradeSelection');
                if (jhsGradeSelection) {
                    jhsGradeSelection.style.display = isJhs ? 'block' : 'none';
                }
                
                // Show/hide semester field - only show for SHS, hide for JHS
                const semesterSection = document.getElementById('semesterSection');
                if (semesterSection) {
                    semesterSection.style.display = isShs ? 'block' : 'none';
                }
                
                // Make semester required only when SHS
                const semesterInputs = document.querySelectorAll('input[name="semester"]');
                semesterInputs.forEach(inp => { inp.required = !!isShs; });
                
                // Make strand and SHS grade required only when SHS
                const strandInputs = document.querySelectorAll('input[name="strand"]');
                strandInputs.forEach(inp => { inp.required = !!isShs; });
                
                const shsGradeInputs = document.querySelectorAll('input[name="shsGrade"]');
                shsGradeInputs.forEach(inp => { inp.required = !!isShs; });
                
                // Make JHS grade required only when JHS
                const jhsGradeInputs = document.querySelectorAll('input[name="jhsGrade"]');
                jhsGradeInputs.forEach(inp => { inp.required = !!isJhs; });
                
            }
            if (shsRadio) {
                shsRadio.addEventListener('change', updateShsVisibility);
            }
            if (jhsRadio) {
                jhsRadio.addEventListener('change', updateShsVisibility);
            }
            updateShsVisibility();

            // Club member conditional field
            const clubYesRadio = document.getElementById('clubYes');
            const clubNoRadio = document.getElementById('clubNo');
            const clubNameSection = document.getElementById('clubNameSection');
            const clubNameInput = document.getElementById('clubName');
            
            function updateClubNameVisibility() {
                const isClubMember = clubYesRadio && clubYesRadio.checked;
                
                if (clubNameSection) {
                    clubNameSection.style.display = isClubMember ? 'block' : 'none';
                }
                
                if (clubNameInput) {
                    clubNameInput.required = !!isClubMember;
                    if (!isClubMember) {
                        clubNameInput.value = ''; // Clear value when hidden
                    }
                }
            }
            
            if (clubYesRadio) {
                clubYesRadio.addEventListener('change', updateClubNameVisibility);
            }
            if (clubNoRadio) {
                clubNoRadio.addEventListener('change', updateClubNameVisibility);
            }
            updateClubNameVisibility();
            
            // Add event listeners for SHS fields to trigger validation
            if (clubYesRadio) {
                clubYesRadio.addEventListener('change', updateSubmitButton);
            }
            if (clubNoRadio) {
                clubNoRadio.addEventListener('change', updateSubmitButton);
            }
            if (clubNameInput) {
                clubNameInput.addEventListener('input', updateSubmitButton);
            }
            
            // Add listeners for working student fields
            const workingYes = document.getElementById('workingYes');
            const workingNo = document.getElementById('workingNo');
            const intendWorkingYes = document.getElementById('intendWorkingYes');
            const intendWorkingNo = document.getElementById('intendWorkingNo');
            
            if (workingYes) workingYes.addEventListener('change', updateSubmitButton);
            if (workingNo) workingNo.addEventListener('change', updateSubmitButton);
            if (intendWorkingYes) intendWorkingYes.addEventListener('change', updateSubmitButton);
            if (intendWorkingNo) intendWorkingNo.addEventListener('change', updateSubmitButton);
            
            // Add listeners for siblings input
            const siblingsInput = document.getElementById('siblings');
            if (siblingsInput) {
                siblingsInput.addEventListener('input', function() {
                    // Validate siblings input
                    const value = this.value;
                    const span = this.parentElement.querySelector('span');
                    
                    if (value && (isNaN(value) || value < 0 || value > 20)) {
                        this.style.borderColor = '#dc3545'; // Red border for invalid
                        if (span) {
                            span.style.color = '#dc3545';
                            span.textContent = '*Invalid - Please enter a number between 0-20';
                        }
                        console.log('❌ Invalid siblings number:', value);
                    } else if (value) {
                        this.style.borderColor = '#28a745'; // Green border for valid
                        if (span) {
                            span.style.color = '#28a745';
                            span.textContent = '*Valid - Numbers only (0-20)';
                        }
                        console.log('✅ Valid siblings number:', value);
                    } else {
                        this.style.borderColor = ''; // Default border for empty
                        if (span) {
                            span.style.color = '';
                            span.textContent = '*Optional - Numbers only (0-20)';
                        }
                    }
                    updateSubmitButton();
                });
                
                // Also validate on blur (when user leaves the field)
                siblingsInput.addEventListener('blur', function() {
                    const value = this.value;
                    const span = this.parentElement.querySelector('span');
                    
                    if (value && (isNaN(value) || value < 0 || value > 20)) {
                        this.style.borderColor = '#dc3545';
                        if (span) {
                            span.style.color = '#dc3545';
                            span.textContent = '*Invalid - Please enter a number between 0-20';
                        }
                    } else if (value) {
                        this.style.borderColor = '#28a745';
                        if (span) {
                            span.style.color = '#28a745';
                            span.textContent = '*Valid - Numbers only (0-20)';
                        }
                    } else {
                        this.style.borderColor = '';
                        if (span) {
                            span.style.color = '';
                            span.textContent = '*Optional - Numbers only (0-20)';
                        }
                    }
                });
            }
            
            // Add listeners for strand selection
            const strandInputs = document.querySelectorAll('input[name="strand"]');
            strandInputs.forEach(input => {
                input.addEventListener('change', updateSubmitButton);
            });
            
            // Add listeners for SHS/JHS grade selection
            const shsGradeInputs = document.querySelectorAll('input[name="shsGrade"]');
            shsGradeInputs.forEach(input => {
                input.addEventListener('change', updateSubmitButton);
            });
            
            const jhsGradeInputs = document.querySelectorAll('input[name="jhsGrade"]');
            jhsGradeInputs.forEach(input => {
                input.addEventListener('change', updateSubmitButton);
            });
            
            // Add listeners for grade level radio buttons
            const gradeLevelRadios = document.querySelectorAll('input[name="gradeLevel"]');
            gradeLevelRadios.forEach(input => {
                input.addEventListener('change', function() {
                    updateSubmitButton();
                    handleAssessmentRecommendation();
                });
            });

            // Assessment recommendation handling
            function handleAssessmentRecommendation() {
                const shsRadio = document.getElementById('shs');
                const assessmentRecommendation = document.getElementById('assessment-recommendation');
                
                if (shsRadio && assessmentRecommendation) {
                    if (shsRadio.checked) {
                        // Show assessment recommendation for SHS students
                        assessmentRecommendation.style.display = 'block';
                        preSelectRecommendedStrand();
                    } else {
                        // Hide recommendation for JHS students
                        assessmentRecommendation.style.display = 'none';
                    }
                }
            }

            // Auto-check SHS if assessment exists and auto-fill is enabled
            function autoCheckSHS() {
                @if($assessmentResult && session('assessment_auto_fill'))
                const shsRadio = document.getElementById('shs');
                if (shsRadio) {
                    shsRadio.checked = true;
                    console.log('Auto-checked SHS due to assessment result');
                    
                    // Trigger the change event to update UI
                    shsRadio.dispatchEvent(new Event('change'));
                    
                    // Update visibility and requirements
                    updateShsVisibility();
                }
                @endif
            }

            // Pre-select recommended strand if assessment exists and auto-fill is enabled
            function preSelectRecommendedStrand() {
                @if($assessmentResult && session('assessment_auto_fill'))
                const recommendedStrand = '{{ $assessmentResult->recommended_strand }}';
                const recommendedRadio = document.getElementById('strand_' + recommendedStrand);
                if (recommendedRadio) {
                    recommendedRadio.checked = true;
                    console.log('Pre-selected recommended strand:', recommendedStrand);
                }
                @endif
            }

            // Check for assessment email from session storage (from assessment page)
            const assessmentEmail = sessionStorage.getItem('assessment_email');
            if (assessmentEmail) {
                console.log('Assessment email found in session:', assessmentEmail);
                // Store in form session for server-side processing
                sessionStorage.setItem('assessment_email_for_enrollment', assessmentEmail);
            }

            // Terms: enable "check all" behavior by disabling submit until all are checked (already enforced), also add a convenience toggle
            const termBoxes = document.querySelectorAll('.term');
            termBoxes.forEach(box => {
                box.addEventListener('change', updateSubmitButton);
            });
            
            // Contact number validation
            const contactNoInput = document.getElementById('contactNo');
            contactNoInput.addEventListener('input', function() {
                // Limit to 11 digits and only allow numbers
                this.value = this.value.replace(/\D/g, '').slice(0, 11);
                
                const validationMsg = document.getElementById('contactNoValidation');
                if (this.value && !validateContactNumber(this.value)) {
                    validationMsg.style.display = 'block';
                    this.style.borderColor = '#9a3a44';
                } else {
                    validationMsg.style.display = 'none';
                    this.style.borderColor = '';
                }
                updateSubmitButton();
            });
            
            // Guardian contact number validation
            const guardianContactInput = document.getElementById('guardianContact');
            guardianContactInput.addEventListener('input', function() {
                // Limit to 11 digits and only allow numbers
                this.value = this.value.replace(/\D/g, '').slice(0, 11);
                updateSubmitButton();
            });
            
            // Email validation with real-time color feedback
            const emailInput = document.getElementById('email');
            
            function updateEmailValidation() {
                const email = emailInput.value.trim();
                
                if (!email) {
                    // Empty field - neutral state
                    emailInput.style.borderColor = '';
                    emailInput.style.borderWidth = '';
                } else if (validateEmail(email)) {
                    // Valid email - green border
                    emailInput.style.borderColor = '#28a745';
                    emailInput.style.borderWidth = '2px';
                } else {
                    // Invalid email - red border
                    emailInput.style.borderColor = '#dc3545';
                    emailInput.style.borderWidth = '2px';
                }
                
                updateSubmitButton();
            }
            
            // Check email uniqueness on blur
            emailInput.addEventListener('blur', function() {
                const email = this.value.trim();
                if (email && validateEmail(email)) {
                    // Check if email already exists
                    fetch('{{ route("enroll.new.check-email") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ email: email })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.available) {
                            // Email already exists - red border
                            emailInput.style.borderColor = '#dc3545';
                            emailInput.style.borderWidth = '2px';
                            // Show error message
                            let errorMsg = document.getElementById('emailUniquenessError');
                            if (!errorMsg) {
                                errorMsg = document.createElement('div');
                                errorMsg.id = 'emailUniquenessError';
                                errorMsg.style.color = '#dc3545';
                                errorMsg.style.fontSize = '14px';
                                errorMsg.style.marginTop = '5px';
                                emailInput.parentNode.appendChild(errorMsg);
                            }
                            errorMsg.textContent = 'This email address is already registered. Please use a different email.';
                        } else {
                            // Email is available - green border
                            emailInput.style.borderColor = '#28a745';
                            emailInput.style.borderWidth = '2px';
                            // Remove error message
                            const errorMsg = document.getElementById('emailUniquenessError');
                            if (errorMsg) {
                                errorMsg.remove();
                            }
                        }
                        updateSubmitButton();
                    })
                    .catch(error => {
                        console.error('Email check error:', error);
                    });
                }
            });
            
            emailInput.addEventListener('input', updateEmailValidation);
            emailInput.addEventListener('focus', updateEmailValidation);

            // Last school year validation (dropdown)
            const lastSchoolYearSelect = document.getElementById('lastSchoolYear');
            lastSchoolYearSelect.addEventListener('change', function() {
                // For dropdown, validation is handled by the form validation
                updateSubmitButton();
            });

            // Date of birth validation and setup
            const dobInput = document.getElementById('dob');
            
            // Set year range limits - reject students born from 2015 to present
            const today = new Date();
            const currentYear = today.getFullYear();
            const minYear = 1950;
            const maxYear = 2014; // Reject students born from 2015 to present
            
            // Set min and max dates
            const minDate = new Date(minYear, 0, 1); // January 1, 1950
            const maxDate = new Date(maxYear, 11, 31); // December 31, 2014
            
            dobInput.min = minDate.toISOString().split('T')[0];
            dobInput.max = maxDate.toISOString().split('T')[0];
            
            // validateDateOfBirth function is now defined globally above
            
            // Validate on input change
            dobInput.addEventListener('input', function() {
                const validationMsg = document.getElementById('dobValidation');
                const isValid = validateDateOfBirth(this.value);
                
                if (!isValid && this.value !== '') {
                    validationMsg.style.display = 'block';
                    this.style.borderColor = '#9a3a44';
                    this.style.borderWidth = '2px';
                } else {
                    validationMsg.style.display = 'none';
                    this.style.borderColor = '';
                    this.style.borderWidth = '';
                }
                updateSubmitButton();
            });
            
            // Validate on blur (when user leaves the field)
            dobInput.addEventListener('blur', function() {
                const validationMsg = document.getElementById('dobValidation');
                const isValid = validateDateOfBirth(this.value);
                
                if (!isValid && this.value !== '') {
                    validationMsg.style.display = 'block';
                    this.style.borderColor = '#9a3a44';
                    this.style.borderWidth = '2px';
                } else {
                    validationMsg.style.display = 'none';
                    this.style.borderColor = '';
                    this.style.borderWidth = '';
                }
                updateSubmitButton();
            });
            
            // Prevent manual typing of invalid years by intercepting keydown events
            dobInput.addEventListener('keydown', function(e) {
                // Allow navigation keys (arrow keys, tab, backspace, delete, etc.)
                if ([8, 9, 13, 27, 46, 37, 38, 39, 40].indexOf(e.keyCode) !== -1 ||
                    // Allow Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X, Ctrl+Z
                    (e.ctrlKey && [65, 67, 86, 88, 90].indexOf(e.keyCode) !== -1)) {
                    return;
                }
                
                // For date inputs, we'll let the browser handle the validation
                // The min/max attributes will prevent invalid dates from being selected
            });
            
            // Check All Terms functionality
            const checkAllTerms = document.getElementById('checkAllTerms');
            const termCheckboxes = document.querySelectorAll('.term');
            
            checkAllTerms.addEventListener('change', function() {
                termCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateSubmitButton();
            });
            
            // Update "Check All" when individual terms are changed
            termCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const allChecked = Array.from(termCheckboxes).every(cb => cb.checked);
                    const noneChecked = Array.from(termCheckboxes).every(cb => !cb.checked);
                    
                    if (allChecked) {
                        checkAllTerms.checked = true;
                        checkAllTerms.indeterminate = false;
                    } else if (noneChecked) {
                        checkAllTerms.checked = false;
                        checkAllTerms.indeterminate = false;
                    } else {
                        checkAllTerms.checked = false;
                        checkAllTerms.indeterminate = true;
                    }
                    
                    updateSubmitButton();
                });
            });

            // ---------- Form data persistence (localStorage) ----------
            const FORM_CACHE_KEY = 'new_step1_form_cache_v1';

            function cacheFormData() {
                try {
                    const form = document.querySelector('form');
                    if (!form) return;
                    const fields = form.querySelectorAll('input, select, textarea');
                    const data = {};
                    fields.forEach(el => {
                        if (!el.id && !el.name) return;
                        const key = el.name || el.id;
                        // Skip hidden address field (combined field, not individual fields)
                        if (key === 'address' && el.type === 'hidden') return;
                        if (el.type === 'checkbox') {
                            if (key.endsWith('[]')) {
                                // collect array checkbox values
                                if (!data[key]) data[key] = [];
                                if (el.checked) data[key].push(el.value || 'on');
                            } else {
                                data[key] = !!el.checked;
                            }
                        } else if (el.type === 'radio') {
                            if (el.checked) data[key] = el.value;
                        } else {
                            data[key] = el.value;
                        }
                    });
                    localStorage.setItem(FORM_CACHE_KEY, JSON.stringify(data));
                } catch (e) { /* no-op */ }
            }

            function restoreCachedFormData() {
                try {
                    // Don't restore if cache was cleared on fresh start
                    if (cacheCleared) return;
                    
                    const raw = localStorage.getItem(FORM_CACHE_KEY);
                    if (!raw) return;
                    const data = JSON.parse(raw || '{}');
                    const form = document.querySelector('form');
                    if (!form) return;
                    const fields = form.querySelectorAll('input, select, textarea');
                    fields.forEach(el => {
                        const key = el.name || el.id;
                        if (!key) return;
                        if (!(key in data)) return;
                        
                        // Skip hidden address field (combined field)
                        if (key === 'address' && el.type === 'hidden') return;

                        if (el.type === 'checkbox') {
                            if (key.endsWith('[]')) {
                                const arr = Array.isArray(data[key]) ? data[key] : [];
                                el.checked = arr.includes(el.value || 'on');
                            } else {
                                el.checked = !!data[key];
                            }
                        } else if (el.type === 'radio') {
                            el.checked = data[key] === el.value;
                        } else {
                            // Only set if empty to not override server old() values
                            // Special handling for previousGrade to preserve selection
                            if (key === 'previousGrade' && data[key]) {
                                el.value = data[key];
                            } else if (!el.value) {
                                el.value = data[key] ?? '';
                            }
                        }
                    });
                    
                    // Re-combine address fields after restoration
                    combineAddressFields();

                    // Re-apply dynamic visibility and validation after restoration
                    try { if (typeof updateShsVisibility === 'function') updateShsVisibility(); } catch (e) {}
                    try { if (typeof updateClubNameVisibility === 'function') updateClubNameVisibility(); } catch (e) {}
                    try { if (typeof updateSubmitButton === 'function') updateSubmitButton(); } catch (e) {}
                } catch (e) { /* no-op */ }
            }

            function clearCachedFormData() {
                try { localStorage.removeItem(FORM_CACHE_KEY); } catch (e) { /* no-op */ }
            }

            // Add listeners to all form fields (also cache on changes)
            const form = document.querySelector('form');
            const inputs = form.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    updateSubmitButton();
                    cacheFormData();
                });
                input.addEventListener('change', function() {
                    updateSubmitButton();
                    cacheFormData();
                });
            });

            // Restore cached data on load and after short delays (for dynamic UI)
            // Only restore if cache wasn't cleared
            if (!cacheCleared) {
                const restoreAndReapply = () => {
                    restoreCachedFormData();
                    try { if (typeof updateShsVisibility === 'function') updateShsVisibility(); } catch (e) {}
                    try { if (typeof updateClubNameVisibility === 'function') updateClubNameVisibility(); } catch (e) {}
                    try { if (typeof updateSubmitButton === 'function') updateSubmitButton(); } catch (e) {}
                };
                restoreAndReapply();
                setTimeout(restoreAndReapply, 150);
                setTimeout(restoreAndReapply, 400);
                setTimeout(restoreAndReapply, 800);
            }

            // Re-apply on visibility/focus changes (only if cache wasn't cleared)
            window.addEventListener('focus', function() {
                if (!cacheCleared) {
                    restoreCachedFormData();
                    try { if (typeof updateShsVisibility === 'function') updateShsVisibility(); } catch (e) {}
                    try { if (typeof updateClubNameVisibility === 'function') updateClubNameVisibility(); } catch (e) {}
                    try { if (typeof updateSubmitButton === 'function') updateSubmitButton(); } catch (e) {}
                }
            });
            document.addEventListener('visibilitychange', function() {
                if (!document.hidden && !cacheCleared) {
                    restoreCachedFormData();
                    try { if (typeof updateShsVisibility === 'function') updateShsVisibility(); } catch (e) {}
                    try { if (typeof updateClubNameVisibility === 'function') updateClubNameVisibility(); } catch (e) {}
                    try { if (typeof updateSubmitButton === 'function') updateSubmitButton(); } catch (e) {}
                }
            });

            // Expose clear function globally for future use (e.g., after successful Step 1)
            window.__clearNewStep1Cache = clearCachedFormData;
            
            // Initial validation
            updateSubmitButton();
            
            // Continuous validation check every 500ms to ensure button state is always correct
            setInterval(() => {
                updateSubmitButton();
            }, 500);
            
            // Form submission handler - PREVENT NAVIGATION FOR DEBUGGING
            const enrollmentForm = document.querySelector('form');
            if (enrollmentForm) {
                enrollmentForm.addEventListener('submit', function(e) {
                    console.log('=== FORM SUBMISSION DEBUG ===');
                    console.log('Form submission started...');
                    
                    // Combine address fields before submission
                    combineAddressFields();
                    
                    // ALWAYS prevent default submission for debugging
                    e.preventDefault();
                    console.log('Form submission prevented for debugging purposes');
                    
                    const isValid = validateRequiredFields(true); // Show logs only on form submission
                    console.log('Form validation result:', isValid);
                    
                    if (!isValid) {
                        console.log('Form validation failed');
                        showToast('Please fill in all required fields correctly before submitting.', 'warning');
                        return false;
                    }
                    
                    console.log('Form is valid!');
                    console.log('Form action:', this.action);
                    console.log('Form method:', this.method);
                    console.log('Form data being submitted...');
                    
                    // Show form data
                    const formData = new FormData(this);
                    console.log('=== FORM DATA BEING SUBMITTED ===');
                    for (let [key, value] of formData.entries()) {
                        console.log(`${key}: ${value}`);
                    }
                    console.log('=== END FORM DATA ===');
                    
                    // Set session marker to indicate enrollment is in progress
                    sessionStorage.setItem('enrollment_in_progress', 'true');
                    
                    console.log('=== FORM WOULD SUBMIT HERE ===');
                    console.log('To actually submit, uncomment the line below:');
                    console.log('// this.submit();');
                    
                    // Uncomment the line below to actually submit the form
                    this.submit();
                    
                    // alert('Form validation passed! Check console for details. Form submission is disabled for debugging.');
                    return false;
                });
            }
            
            // Debug: Check form state after a short delay
            setTimeout(() => {
                console.log('=== FORM VALIDATION DEBUG ===');
                console.log('All required fields:', requiredFields);
                requiredFields.forEach(fieldName => {
                    const field = document.getElementById(fieldName);
                    if (field) {
                        console.log(`${fieldName}: "${field.value}" (${field.value ? 'FILLED' : 'EMPTY'})`);
                    } else {
                        console.log(`${fieldName}: FIELD NOT FOUND`);
                    }
                });
                
                console.log('School Type:', document.querySelector('input[name="schoolType"]:checked')?.value || 'NOT SELECTED');
                console.log('Semester:', document.querySelector('input[name="semester"]:checked')?.value || 'NOT SELECTED');
                console.log('Terms checked:', document.querySelectorAll('input[name="terms[]"]:checked').length + '/6');
                console.log('Form valid:', validateRequiredFields());
                console.log('Submit button disabled:', document.getElementById('submitBtn').disabled);
                console.log('================================');
            }, 1000);
            
            // Handle browser back button
            window.addEventListener('popstate', function(event) {
                // Allow browser back button to work naturally
                if (event.state && event.state.step) {
                    // Handle step navigation if needed
                }
            });

            // Auto-check SHS if assessment result exists
            autoCheckSHS();
        });
    </script>
    
    {{-- Include Modern Notification System --}}
    @include('partials.modern_notifications')
    <script>
      window.__strandAvailabilityUrl = '{{ route('enroll.new.strand-availability') }}';
    </script>
    <script src="{{ asset('js/strand-availability.js') }}?v={{ time() }}"></script>
</body>
</html>