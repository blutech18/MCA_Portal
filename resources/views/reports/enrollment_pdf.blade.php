<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 12px;
      padding: 20px;
      margin: 0;
      color: #2b0f12;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }
    th, td {
      padding: 12px;
      text-align: left;
      border: 1px solid #bd8c91;
      background: white;
    }
    .student-table td {
      background: #f9f1f2;
    }
    th {
      background-color: #f9f1f2;
      font-weight: bold;
      color: #7a222b;
    }
    .header {
      text-align: center;
      margin-bottom: 30px;
      border-bottom: 3px solid #7a222b;
      padding: 15px;
      background: #f9f1f2;
    }
    .header img {
      height: 80px;
      width: auto;
      display: block;
      margin: 0 auto 15px;
      max-width: 150px;
    }
    .logo-text {
      width: 80px;
      height: 80px;
      background: #7a222b;
      color: white;
      font-weight: bold;
      font-size: 24px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 20px;
      border: 3px solid #7a222b;
    }
    .header h1 {
      margin: 0;
      font-size: 22px;
      color: #7a222b;
    }
    .header p {
      margin: 5px 0;
      color: #5a1a20;
      font-weight: bold;
    }
    .section {
      margin-bottom: 20px;
    }
    .student-table {
      background: #f9f1f2;
      border: 2px solid #bd8c91;
    }
    .footer {
      margin-top: 40px;
      text-align: center;
      font-size: 10px;
      color: #666;
      border-top: 1px solid #e5e7eb;
      padding-top: 15px;
    }
    .official-stamp {
      text-align: center;
      margin-top: 30px;
      padding: 20px;
      border: 2px dashed #7a222b;
      background: #f9f1f2;
    }
    .stamp-text {
      font-size: 13px;
      font-weight: bold;
      color: #7a222b;
      margin-bottom: 10px;
    }
    .stamp-line {
      width: 250px;
      height: 1px;
      background: #7a222b;
      margin: 15px auto;
    }
    .stamp-signature {
      font-size: 11px;
      color: #5a1a20;
      margin-top: 15px;
    }
  </style>
</head>
<body>
  <div class="header">
    <table style="width: 100%;">
      <tr>
        <td style="vertical-align: middle; text-align: left;">
          <h2 style="margin: 0; font-size: 18px; color: #7a222b; font-weight: bold;">MCA Montessori School</h2>
          <small style="color: #5a1a20; font-size: 11px; font-weight: 600;">Official Enrollment Form</small>
        </td>
      </tr>
    </table>
  </div>

  <div class="title" style="margin: 20px 0 15px; padding: 10px 0; text-align: center; font-size: 18px; color: #7a222b; border-bottom: 2px solid #bd8c91;">
    Enrollment Confirmation
  </div>

  <div class="section">
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
      <tr style="border-bottom: 1px solid #e5e7eb;">
        <td style="width: 50%; padding: 10px 5px; vertical-align: top;">
          <div style="font-size: 9px; font-weight: bold; color: #7a222b; margin-bottom: 5px;">Student ID</div>
          <div style="font-size: 12px; color: #333;">{{ $studentId ?? 'N/A' }}</div>
        </td>
        <td style="width: 50%; padding: 10px 5px; vertical-align: top;">
          <div style="font-size: 9px; font-weight: bold; color: #7a222b; margin-bottom: 5px;">LRN (Learner Reference Number)</div>
          <div style="font-size: 12px; color: #333;">{{ $lrn ?? 'N/A' }}</div>
        </td>
      </tr>
      <tr style="border-bottom: 1px solid #e5e7eb;">
        <td style="width: 50%; padding: 10px 5px; vertical-align: top;">
          <div style="font-size: 9px; font-weight: bold; color: #7a222b; margin-bottom: 5px;">Student Full Name</div>
          <div style="font-size: 12px; color: #333;">{{ $fullName ?? 'N/A' }}</div>
        </td>
        <td style="width: 50%; padding: 10px 5px; vertical-align: top;">
          <div style="font-size: 9px; font-weight: bold; color: #7a222b; margin-bottom: 5px;">Grade Level & Section</div>
          <div style="font-size: 12px; color: #333;">{{ ($gradeLevel ?? 'N/A') }}{{ $section ? ' - '.$section : '' }}</div>
        </td>
      </tr>
      <tr style="border-bottom: 1px solid #e5e7eb;">
        <td style="width: 50%; padding: 10px 5px; vertical-align: top;">
          <div style="font-size: 9px; font-weight: bold; color: #7a222b; margin-bottom: 5px;">Enrollment Date</div>
          <div style="font-size: 12px; color: #333;">
            @if($enrolledAt)
              @if($enrolledAt instanceof DateTime)
                {{ $enrolledAt->format('F j, Y') }}
              @elseif(is_string($enrolledAt))
                {{ $enrolledAt }}
              @else
                {{ now()->format('F j, Y') }}
              @endif
            @else
              {{ now()->format('F j, Y') }}
            @endif
          </div>
        </td>
        <td style="width: 50%; padding: 10px 5px; vertical-align: top;">
          <div style="font-size: 9px; font-weight: bold; color: #7a222b; margin-bottom: 5px;">School Year</div>
          <div style="font-size: 12px; color: #333;">{{ $schoolYear ?? 'N/A' }}</div>
        </td>
      </tr>
      <tr>
        <td colspan="2" style="padding: 10px 5px;">
          <div style="font-size: 9px; font-weight: bold; color: #7a222b; margin-bottom: 5px;">Payment Status</div>
          <div style="font-size: 12px; color: #333;">
            @if(isset($paymentStatus))
              @if(strtolower($paymentStatus) === 'verified' || strtolower($paymentStatus) === 'paid')
                <span style="background: #d4edda; color: #155724; padding: 3px 8px; display: inline-block;">Verified</span>
              @else
                <span style="background: #fff3cd; color: #856404; padding: 3px 8px; display: inline-block;">{{ $paymentStatus }}</span>
              @endif
            @else
              <span style="background: #fff3cd; color: #856404; padding: 3px 8px; display: inline-block;">N/A</span>
            @endif
          </div>
        </td>
      </tr>
    </table>
  </div>

  <div class="official-stamp">
    <div class="stamp-text">OFFICIAL ENROLLMENT CONFIRMATION</div>
    <div class="stamp-line"></div>
    <div class="stamp-signature">
      <div>Registrar's Signature</div>
      <div style="margin-top: 15px;">Date: _______________</div>
    </div>
  </div>

  <div class="footer">
    <div style="margin-bottom: 8px;">This document serves as official confirmation of enrollment at MCA Montessori School.</div>
    <div style="margin-bottom: 4px; font-weight: 600;">Generated on {{ now()->format('F j, Y g:i A') }}</div>
    <div style="font-size: 8px; color: #666;">
      For inquiries, contact: (0960) 374 1679 | adminoffice@mcams.edu.ph
    </div>
  </div>
</body>
</html>

