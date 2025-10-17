<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>MCA Montessori - Enrollment Form</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
    
    * { margin: 0; padding: 0; box-sizing: border-box; }
    
    body { 
      font-family: 'Poppins', Arial, sans-serif; 
      color: #2b0f12; 
      margin: 0;
      padding: 20px;
      background: white;
      line-height: 1.6;
    }
    
    .page-container {
      max-width: 800px;
      margin: 0 auto;
      background: white;
      padding: 30px;
      border: 2px solid #7a222b;
      border-radius: 10px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    
    .letterhead { 
      display: flex; 
      align-items: center; 
      justify-content: space-between;
      border-bottom: 3px solid #7a222b; 
      padding-bottom: 20px; 
      margin-bottom: 30px; 
      background: linear-gradient(135deg, #f9f1f2 0%, #f4e9ea 100%);
      padding: 20px;
      border-radius: 8px;
    }
    
    .school-info {
      display: flex;
      align-items: center;
    }
    
    .letterhead img { 
      height: 80px; 
      margin-right: 20px; 
      border-radius: 50%;
      border: 3px solid #7a222b;
    }
    
    .school h2 { 
      margin: 0; 
      font-size: 24px; 
      color: #7a222b;
      font-weight: 700;
    }
    
    .school small { 
      color: #5a1a20; 
      font-size: 14px;
      font-weight: 500;
    }
    
    .print-actions {
      display: flex;
      gap: 10px;
    }
    
    .btn {
      padding: 8px 16px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-weight: 500;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 5px;
      transition: all 0.3s ease;
    }
    
    .btn-primary {
      background: #7a222b;
      color: white;
    }
    
    .btn-secondary {
      background: #bd8c91;
      color: white;
    }
    
    .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    
    .title { 
      text-align: center; 
      font-weight: 700; 
      margin: 30px 0; 
      font-size: 28px; 
      color: #7a222b;
      text-transform: uppercase;
      letter-spacing: 2px;
      border-bottom: 2px solid #bd8c91;
      padding-bottom: 15px;
    }
    
    .student-info {
      background: #f9f1f2;
      border: 2px solid #bd8c91;
      border-radius: 10px;
      padding: 25px;
      margin-bottom: 30px;
    }
    
    .grid { 
      display: grid; 
      grid-template-columns: 1fr 1fr; 
      gap: 20px 30px; 
    }
    
    .item { 
      padding: 12px 0; 
      border-bottom: 1px solid #e5e7eb; 
      display: flex;
      flex-direction: column;
    }
    
    .label { 
      color: #7a222b; 
      font-size: 12px; 
      text-transform: uppercase; 
      letter-spacing: 1px;
      font-weight: 600;
      margin-bottom: 5px;
    }
    
    .value { 
      font-size: 16px; 
      font-weight: 600; 
      color: #2b0f12;
      word-break: break-word;
    }
    
    .status-badge {
      display: inline-block;
      padding: 4px 12px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
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
      margin-top: 40px; 
      font-size: 12px; 
      color: #6b7280; 
      text-align: center;
      border-top: 1px solid #e5e7eb;
      padding-top: 20px;
    }
    
    .official-stamp {
      text-align: center;
      margin-top: 30px;
      padding: 20px;
      border: 2px dashed #bd8c91;
      border-radius: 10px;
      background: #f9f1f2;
    }
    
    .stamp-text {
      font-size: 14px;
      color: #7a222b;
      font-weight: 600;
      margin-bottom: 10px;
    }
    
    .stamp-line {
      width: 200px;
      height: 1px;
      background: #7a222b;
      margin: 10px auto;
    }
    
    .stamp-signature {
      font-size: 12px;
      color: #5a1a20;
    }
    
    @media print { 
      .no-print { display: none !important; } 
      body { 
        margin: 0;
        padding: 15px;
        background: white;
      }
      .page-container {
        border: none;
        box-shadow: none;
        padding: 20px;
      }
      .btn {
        display: none !important;
      }
    }
    
    @media (max-width: 768px) {
      .grid {
        grid-template-columns: 1fr;
        gap: 15px;
      }
      .letterhead {
        flex-direction: column;
        text-align: center;
      }
      .school-info {
        margin-bottom: 15px;
      }
      .print-actions {
        justify-content: center;
      }
    }
  </style>
  <script>
    function doPrint(){ 
      window.print(); 
    }
    
    function downloadPDF() {
      // This will be handled by the server-side PDF generation
      window.location.href = window.location.href + '?format=pdf';
    }
  </script>
</head>
<body>
  <div class="page-container">
    <div class="letterhead">
      <div class="school-info">
        <img src="{{ public_path('images/schoollogo.png') }}" onerror="this.src='{{ asset('images/schoollogo.png') }}'" alt="School Logo">
        <div class="school">
          <h2>MCA Montessori School</h2>
          <small>Official Enrollment Form</small>
        </div>
      </div>
      <div class="print-actions no-print">
        <button onclick="doPrint()" class="btn btn-primary">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M6 9V2H18V9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M6 18H4C3.46957 18 2.96086 17.7893 2.58579 17.4142C2.21071 17.0391 2 16.5304 2 16V11C2 10.4696 2.21071 9.96086 2.58579 9.58579C2.96086 9.21071 3.46957 9 4 9H20C20.5304 9 21.0391 9.21071 21.4142 9.58579C21.7893 9.96086 22 10.4696 22 11V16C22 16.5304 21.7893 17.0391 21.4142 17.4142C21.0391 17.7893 20.5304 18 20 18H18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M18 14H6V22H18V14Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          Print
        </button>
        <button onclick="downloadPDF()" class="btn btn-secondary">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M21 15V19C21 19.5304 20.7893 20.0391 20.4142 20.4142C20.0391 20.7893 19.5304 21 19 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M7 10L12 15L17 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M12 15V3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          Download PDF
        </button>
      </div>
    </div>

    <div class="title">Enrollment Confirmation</div>

    <div class="student-info">
      <div class="grid">
        <div class="item">
          <div class="label">Student ID</div>
          <div class="value">{{ $studentId ?? 'N/A' }}</div>
        </div>
        <div class="item">
          <div class="label">LRN (Learner Reference Number)</div>
          <div class="value">{{ $lrn ?? 'N/A' }}</div>
        </div>
        <div class="item">
          <div class="label">Student Full Name</div>
          <div class="value">{{ $fullName ?? 'N/A' }}</div>
        </div>
        <div class="item">
          <div class="label">Grade Level & Section</div>
          <div class="value">{{ ($gradeLevel ?? 'N/A') }}{{ $section ? ' - '.$section : '' }}</div>
        </div>
        <div class="item">
          <div class="label">Enrollment Date</div>
          <div class="value">{{ optional($enrolledAt)->format('F j, Y') ?? (is_string($enrolledAt)? $enrolledAt : 'N/A') }}</div>
        </div>
        <div class="item">
          <div class="label">School Year</div>
          <div class="value">{{ $schoolYear ?? 'N/A' }}</div>
        </div>
        <div class="item">
          <div class="label">Contact Number</div>
          <div class="value">{{ $contactNumber ?? 'N/A' }}</div>
        </div>
        <div class="item">
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
        </div>
      </div>
    </div>

    <div class="official-stamp">
      <div class="stamp-text">OFFICIAL ENROLLMENT CONFIRMATION</div>
      <div class="stamp-line"></div>
      <div class="stamp-signature">
        <div>Registrar's Signature</div>
        <div style="margin-top: 20px;">Date: _______________</div>
      </div>
    </div>

    <div class="footer">
      <div>This document serves as official confirmation of enrollment at MCA Montessori School.</div>
      <div style="margin-top: 10px; font-weight: 600;">Generated on {{ now()->format('F j, Y \a\t g:i A') }}</div>
      <div style="margin-top: 5px; font-size: 10px; color: #9ca3af;">
        For inquiries, contact: (0960) 374 1679 | adminoffice@mcams.edu.ph
      </div>
    </div>
  </div>
</body>
</html>


