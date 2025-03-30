<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/styles_enrollment_form.css" />
    <title>Enrollment Form</title>
</head>
<body>

<div class="enrollment-form">
    <div class="header">
        <div class="school-logo">
            <img src="{{ asset('images/logo.png') }}" alt="School Logo">
        </div>
        <div class="school-name">
            <h2>MCA MONTESORRI SCHOOL</h2>
            <p>ONLINE ENROLLMENT FORM</p>
        </div>
    </div>

    <form action="{{ route('enrollment.store') }}" method="POST">

        @csrf

        <div class="input-field">
        <label for="semester">School Year Semester :</label>
        <input type="text" id="semester" name="semester" placeholder ="20XX-20XX" required>
        </div>


        <div class="section-border">
        <div class="grade-level">
            <label>Grade Level:</label>
            <input type="radio" name="grade" value="junior"> Junior High School
            <input type="radio" name="grade" value="senior"> Senior High School
        </div>

        <!-- Status Moved Below -->
        <div class="status">
            <label>Status:</label>
            <input type="radio" name="status" value="new"> New Student
            <input type="radio" name="status" value="existing"> Existing Student
        </div>

        <div class="strand">
            <label>Strand:</label>
            <input type="radio" name="strand" value="hss"> Humanities and Social Sciences  
            <input type="radio" name="strand" value="stem"> Science, Technology, Engineering, and Mathematics  
            <input type="radio" name="strand" value="gas"> General Academic Strand  
            <input type="radio" name="strand" value="he"> Home Economics Track  
            <input type="radio" name="strand" value="ict"> Information Communication and Technology  
            <input type="radio" name="strand" value="abm"> Accountancy, Business and Management  
        </div>
        </div>

        <div><p>Not sure about your strand? <a href="{{ route('strand.assessment') }}" class="click-strand">Click here to take the assessment</a></p>
        </div>

        <div class="student-info">
        <h4>Student’s Name</h4>
        <input type="text" name="first_name" placeholder="First Name">
        <input type="text" name="middle_name" placeholder="Middle Name">
        <input type="text" name="last_name" placeholder="Last Name">
        </div>

        <div class="other-info">
        <div class="gender">
            <h4>Gender:</h4>
            <label><input type="radio" name="gender" value="male"> Male</label>
            <label><input type="radio" name="gender" value="female"> Female</label>
        </div>

        <div class="dob">
            <h4>Date of Birth:</h4>
            <input type="text" name="dob_month" placeholder="MM">
            <input type="text" name="dob_day" placeholder="DD">
            <input type="text" name="dob_year" placeholder="YYYY">
        </div>

        <div class="contact">
            <h4>Contact Number:</h4>
            <input type="text" name="contact" placeholder="Enter Contact Number">
        </div>

        <div class="email">
            <h4>Email Address:</h4>
            <input type="email" name="email" placeholder="Enter Email Address">
        </div>
        </div>

        <button type="submit" class="submit-btn">SUBMIT</button>

    </form>
    
    <a href="{{ route('home') }}" class="go-back">Go back</a>
</div>

</body>
</html>
