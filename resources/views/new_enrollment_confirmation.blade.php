<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Your MCA Montessori Enrollment Confirmation</title>
  <style>
    body { font-family: Arial, sans-serif; color: #333; line-height: 1.5; }
    .header { text-align: center; padding: 20px 0; }
    .content { max-width: 600px; margin: 0 auto; }
    .summary { background: #f9f9f9; padding: 15px; border-radius: 5px; }
    .summary h4 { margin-top: 0; }
    .summary dt { font-weight: bold; }
    .summary dd { margin: 0 0 10px 0; }
    .footer { text-align: center; font-size: 0.9em; color: #666; margin-top: 30px; }
  </style>
</head>
<body>
  <div class="header">
    <h1>MCA Montessori School</h1>
    <p><em>Enrollment Confirmation</em></p>
  </div>

  <div class="content">
    <p>Hi {{ $enrollee->given_name }},</p>

    <p>Thank you for submitting your online enrollment application. Below are your details and your new Student ID.</p>

    <p><strong>Your Student ID:</strong> {{ $studentNumber ?? $enrollee->application_number }}</p>

    <div class="summary">
      <h4>Application Summary</h4>
      <dl>
        <dt>Full Name</dt>
        <dd>{{ $enrollee->surname }}, {{ $enrollee->given_name }} {{ $enrollee->middle_name }}</dd>

        <dt>Strand / Track</dt>
        <dd>{{ $enrollee->strand ?? 'N/A' }}</dd>

        <dt>Semester</dt>
        <dd>{{ $enrollee->semester }}</dd>

        <dt>Learner Reference Number (LRN)</dt>
        <dd>{{ $enrollee->lrn }}</dd>

        <dt>Grade Level</dt>
        <dd>
            @if($enrollee->shs_grade)
                {{ $enrollee->shs_grade }}
            @else
                {{ $enrollee->previous_grade }}
            @endif
        </dd>

        <dt>School Year</dt>
        <dd>{{ now()->year }} – {{ now()->addYear()->year }}</dd>

        <dt>Contact Number</dt>
        <dd>{{ $enrollee->contact_no }}</dd>

        <dt>Email Address</dt>
        <dd>{{ $enrollee->email }}</dd>

        <dt>Payment Reference</dt>
        <dd>{{ $enrollee->payment_reference ?? 'CASH' }}</dd>

        <dt>Date Submitted</dt>
        <dd>{{ $enrollee->created_at->format('F j, Y') }}</dd>
      </dl>
    </div>

    <p>Please keep this email for your records.  If you have any questions, reply to this message or contact our Admissions Office at <a href="mailto:adminoffice@mcams.edu.ph">adminoffice@mcams.edu.ph</a>.</p>

    <p>We look forward to seeing you on campus!</p>

    <p>— MCA Montessori School Admissions Team</p>
  </div>

  <div class="footer">
    <p>MCA Montessori School, 123 Learning Ave, City</p>
  </div>
</body>
</html>