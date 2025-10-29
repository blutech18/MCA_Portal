<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>MCA Montessori - Enrollment Form</title>
  <style>
    body { 
      font-family: Arial, sans-serif; 
      color: #2b0f12; 
      margin: 0;
      padding: 20px;
      line-height: 1.6;
    }
    
    .page-container {
      max-width: 800px;
      margin: 0 auto;
    }
    
    .letterhead { 
      border-bottom: 3px solid #7a222b; 
      padding-bottom: 20px; 
      margin-bottom: 20px; 
      background: #f9f1f2;
      padding: 20px;
      border-radius: 8px;
    }
    
    .letterhead img { 
      height: 80px; 
      width: 80px;
      object-fit: contain;
      display: block;
    }
    
    .school h2 { 
      margin: 0; 
      font-size: 20px; 
      color: #7a222b;
      font-weight: bold;
    }
    
    .school small { 
      color: #5a1a20; 
      font-size: 13px;
      font-weight: 600;
    }
    
    .title { 
      text-align: center; 
      font-weight: bold; 
      margin: 20px 0; 
      font-size: 18px; 
      text-transform: uppercase;
      color: #7a222b;
      border-bottom: 2px solid #bd8c91;
      padding-bottom: 10px;
    }
    
    .student-info {
      background: #f9f1f2;
      border: 2px solid #bd8c91;
      padding: 20px;
      margin-bottom: 20px;
      border-radius: 8px;
    }
    
    .grid { 
      width: 100%;
      border-collapse: collapse;
    }
    
    .grid td {
      padding: 12px;
      vertical-align: top;
      border: 1px solid #e5e7eb;
    }
    
    .label { 
      color: #7a222b; 
      font-size: 10px; 
      text-transform: uppercase; 
      font-weight: bold;
      letter-spacing: 1px;
      margin-bottom: 5px;
    }
    
    .value { 
      font-size: 14px; 
      font-weight: bold; 
      color: #2b0f12;
    }
    
    .status-badge {
      padding: 4px 12px;
      font-size: 11px;
      font-weight: bold;
      text-transform: uppercase;
      border-radius: 4px;
    }
    
    .status-verified {
      background: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
    }
    
    .status-pending {
      background: #fff3cd;
      color: #856404;
      border: 1px solid #ffeaa7;
    }
    
    .footer { 
      margin-top: 30px; 
      font-size: 10px; 
      color: #666; 
      text-align: center;
      border-top: 1px solid #e5e7eb;
      padding-top: 15px;
    }
    
    .official-stamp {
      text-align: center;
      margin-top: 40px;
      padding: 20px;
      border: 2px dashed #7a222b;
      background: #f9f1f2;
      border-radius: 8px;
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
  @if(!request()->has('format') || request()->get('format') !== 'pdf')
  <script>
    function doPrint(){ 
      window.print(); 
    }
    
    function downloadPDF() {
      // This will be handled by the server-side PDF generation
      window.location.href = window.location.href + '?format=pdf';
    }
  </script>
  @endif
</head>
<body>
  <div class="page-container">
    <div class="letterhead">
      <table style="width: 100%;">
        <tr>
          <td style="width: 80px; vertical-align: middle;">
            @php
              $logoPath = public_path('images/logo1.png');
              $logoExists = file_exists($logoPath);
              $logoUrl = null;
              if ($logoExists) {
                // Convert to base64 for PDF generation
                if (request()->has('format') && request()->get('format') === 'pdf') {
                  $imageData = base64_encode(file_get_contents($logoPath));
                  $logoUrl = 'data:image/png;base64,' . $imageData;
                } else {
                  $logoUrl = asset('images/logo1.png');
                }
              }
            @endphp
            @if($logoUrl)
              <img src="{{ $logoUrl }}" alt="School Logo" style="height: 80px;">
            @else
              <div style="width: 60px; height: 60px; background: #7a222b; border-radius: 50%; border: 3px solid #7a222b;"></div>
            @endif
          </td>
          <td style="vertical-align: middle; padding-left: 20px;">
            <h2 style="margin: 0; font-size: 20px; color: #7a222b; font-weight: bold;">MCA Montessori School</h2>
            <small style="color: #5a1a20; font-size: 13px; font-weight: 600;">Official Enrollment Form</small>
          </td>
        </tr>
      </table>
    </div>

    <div class="title">Enrollment Confirmation</div>

    <div class="student-info">
      <table class="grid">
        <tr class="item">
          <td>
            <div class="label">Student ID</div>
            <div class="value">{{ $studentId ?? 'N/A' }}</div>
          </td>
          <td>
            <div class="label">LRN (Learner Reference Number)</div>
            <div class="value">{{ $lrn ?? 'N/A' }}</div>
          </td>
        </tr>
        <tr class="item">
          <td>
            <div class="label">Student Full Name</div>
            <div class="value">{{ $fullName ?? 'N/A' }}</div>
          </td>
          <td>
            <div class="label">Grade Level & Section</div>
            <div class="value">{{ ($gradeLevel ?? 'N/A') }}{{ $section ? ' - '.$section : '' }}</div>
          </td>
        </tr>
        <tr class="item">
          <td>
            <div class="label">Enrollment Date</div>
            <div class="value">
              @if($enrolledAt instanceof DateTime)
                {{ $enrolledAt->format('F j, Y') }}
              @elseif(is_string($enrolledAt))
                {{ $enrolledAt }}
              @else
                {{ now()->format('F j, Y') }}
              @endif
            </div>
          </td>
          <td>
            <div class="label" style="font-size: 10px;">School Year</div>
            <div class="value" style="font-size: 12px;">{{ $schoolYear ?? 'N/A' }}</div>
          </td>
        </tr>
        <tr class="item">
          <td colspan="2">
            <div class="label">Payment Status</div>
            <div class="value">
              @if(isset($paymentStatus))
                @if(strtolower($paymentStatus) === 'verified' || strtolower($paymentStatus) === 'paid')
                  <span class="status-badge status-verified">Verified</span>
                @else
                  <span class="status-badge status-pending">{{ $paymentStatus }}</span>
                @endif
              @else
                <span class="status-badge status-pending">N/A</span>
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
      <div>This document serves as official confirmation of enrollment at MCA Montessori School.</div>
      <div style="margin-top: 8px; font-weight: 600;">Generated on {{ now()->format('F j, Y g:i A') }}</div>
      <div style="margin-top: 4px; font-size: 8px; color: #666;">
        For inquiries, contact: (0960) 374 1679 | adminoffice@mcams.edu.ph
      </div>
    </div>
  </div>
</body>
</html>


