<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Official Student Portal Credentials - MCA Montessori School</title>
    <style>
        @page {
            margin: 8mm 12mm;
            size: A4 portrait;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            color: #2b0f12;
            line-height: 1.4;
            font-size: 10px;
            background: #ffffff;
        }
        
        .document-container {
            border: 2px solid #7a222b;
            padding: 0;
        }
        
        .header {
            background: #7a222b;
            color: white;
            padding: 15px 20px;
            margin-bottom: 0;
        }
        
        .school-name {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 3px;
            letter-spacing: 0.8px;
        }
        
        .document-title {
            font-size: 10px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-top: 3px;
        }
        
        .certificate-badge {
            text-align: center;
            padding: 10px 0;
            border-bottom: 2px solid #7a222b;
        }
        
        .certificate-badge h1 {
            color: #7a222b;
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 1px;
        }
        
        .content-section {
            padding: 15px 20px;
        }
        
        .intro-text {
            margin-bottom: 12px;
            font-size: 10px;
            line-height: 1.5;
            color: #2b0f12;
        }
        
        .student-info-box {
            border: 2px solid #7a222b;
            padding: 10px;
            margin-bottom: 12px;
            background: #f9f1f2;
        }
        
        .info-grid {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }
        
        .info-row {
            display: table-row;
            border-bottom: 1px solid #bd8c91;
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .info-label {
            display: table-cell;
            font-weight: 700;
            color: #5a1a20;
            padding: 5px 8px;
            width: 35%;
            background: #ffffff;
            border-right: 1px solid #bd8c91;
            font-size: 9px;
        }
        
        .info-value {
            display: table-cell;
            color: #2b0f12;
            padding: 5px 8px;
            font-size: 9px;
        }
        
        .credentials-section {
            margin: 15px 0;
            border: 3px double #7a222b;
            padding: 12px;
        }
        
        .credentials-title {
            text-align: center;
            color: #7a222b;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 12px;
            letter-spacing: 0.8px;
        }
        
        .credential-row {
            margin-bottom: 10px;
        }
        
        .credential-row:last-child {
            margin-bottom: 0;
        }
        
        .credential-label {
            font-size: 8px;
            font-weight: 700;
            color: #5a1a20;
            margin-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }
        
        .credential-box {
            border: 2px solid #7a222b;
            padding: 8px;
            background: #ffffff;
            text-align: center;
        }
        
        .credential-code {
            font-family: 'Courier New', monospace;
            font-size: 13px;
            font-weight: 700;
            color: #7a222b;
            letter-spacing: 1.5px;
        }
        
        .instructions-box {
            border: 1px solid #bd8c91;
            padding: 10px;
            margin: 12px 0;
            background: #f4e9ea;
        }
        
        .instructions-title {
            color: #7a222b;
            font-size: 10px;
            font-weight: 700;
            margin-bottom: 6px;
        }
        
        .instructions-list {
            margin-left: 18px;
            color: #2b0f12;
            font-size: 9px;
        }
        
        .instructions-list li {
            margin-bottom: 3px;
        }
        
        .login-section {
            border: 1px solid #bd8c91;
            padding: 10px;
            text-align: center;
            background: #ffffff;
            margin-bottom: 12px;
        }
        
        .login-title {
            color: #7a222b;
            font-size: 10px;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .login-url {
            font-family: 'Courier New', monospace;
            font-size: 9px;
            color: #5a1a20;
            font-weight: 600;
        }
        
        .security-warning {
            margin-top: 12px;
            border-top: 2px solid #dc2626;
            padding-top: 10px;
            text-align: center;
        }
        
        .security-text {
            color: #dc2626;
            font-weight: 700;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        
        .footer {
            margin-top: 15px;
            padding-top: 10px;
            border-top: 2px solid #7a222b;
            text-align: center;
        }
        
        .footer-school {
            font-weight: 700;
            color: #7a222b;
            font-size: 10px;
            margin-bottom: 3px;
        }
        
        .footer-generated {
            color: #5a1a20;
            font-size: 8px;
        }
    </style>
</head>
<body>
    <div class="document-container">
        <!-- Official Header -->
        <div class="header">
            <div class="school-name">MCA MONTESSORI SCHOOL</div>
            <div class="document-title">Official Student Portal Access</div>
        </div>

        <!-- Certificate Badge -->
        <div class="certificate-badge">
            <h1>CREDENTIALS CERTIFICATE</h1>
        </div>

        <!-- Main Content -->
        <div class="content-section">
            <div class="intro-text">
                This document contains the official login credentials for the student portal. 
                This is a confidential document and should be kept secure at all times.
            </div>

            <!-- Student Information -->
            <div class="student-info-box">
                <div class="info-grid">
                    <div class="info-row">
                        <div class="info-label">Student Name:</div>
                        <div class="info-value">{{ strtoupper($student->first_name . ' ' . $student->middle_name . ' ' . $student->last_name) }}</div>
                    </div>
                    @if($student->email)
                    <div class="info-row">
                        <div class="info-label">Email Address:</div>
                        <div class="info-value">{{ $student->email }}</div>
                    </div>
                    @endif
                    @if($student->studentNumber)
                    <div class="info-row">
                        <div class="info-label">Student ID Number:</div>
                        <div class="info-value">{{ $student->studentNumber }}</div>
                    </div>
                    @endif
                    @if($student->section_name)
                    <div class="info-row">
                        <div class="info-label">Grade & Section:</div>
                        <div class="info-value">{{ $student->section_name }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Credentials Section -->
            <div class="credentials-section">
                <div class="credentials-title">PORTAL ACCESS CREDENTIALS</div>
                
                <div class="credential-row">
                    <div class="credential-label">Username</div>
                    <div class="credential-box">
                        <span class="credential-code">{{ $username }}</span>
                    </div>
                </div>
                
                <div class="credential-row">
                    <div class="credential-label">Password</div>
                    <div class="credential-box">
                        <span class="credential-code">{{ $password }}</span>
                    </div>
                </div>
            </div>

            <!-- Instructions -->
            <div class="instructions-box">
                <div class="instructions-title">IMPORTANT INSTRUCTIONS</div>
                <ul class="instructions-list">
                    <li>Keep these credentials confidential and secure at all times</li>
                    <li>You are required to change your password immediately upon first login</li>
                    <li>Never share your login credentials with anyone</li>
                    <li>Contact the school registrar immediately if you suspect unauthorized access</li>
                </ul>
            </div>

            <!-- Login Information -->
            <div class="login-section">
                <div class="login-title">Portal Access URL</div>
                <div class="login-url">{{ config('app.url') }}/login</div>
            </div>

            <!-- Security Warning -->
            <div class="security-warning">
                <div class="security-text">
                    ⚠️ SECURITY NOTICE: This document contains sensitive information. 
                    Store it securely and destroy this document once credentials are memorized.
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-school">MCA Montessori School - Official Document</div>
            <div class="footer-generated">Generated: {{ now()->format('F j, Y \a\t h:i A') }}</div>
        </div>
    </div>
</body>
</html>
