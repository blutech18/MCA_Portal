<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCA Montessori School - My Documents</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css?v=1759179376">
    <link rel="stylesheet" href="{{ asset('css/add-student-modal.css') }}">
    
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

:root {
    --sidebar-color: #5c0017;
    --accent-color: #9B2242;
    --highlight-color: #BC4863;
    --navy-blue: #1D3461;
    --bg-color: #F5F1E8;
    --text-dark: #3A3A3A;
    --text-light: #FFFFFF;
    --text-muted: #666666;
    --success-green: #2E8B57;
    --alert-amber: #D4A76A;
    --shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    --border-radius: 10px;
    --transition: all 0.3s ease;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'poppins', sans-serif;
    background-color: var(--bg-color);
    color: var(--text-dark);
    line-height: 1.6;
}

.container {
    display: flex;
    min-height: 100vh;
}


.sidebar {
    width: 300px;
    background-color: var(--sidebar-color);
    color: var(--text-light);
    display: flex;
    flex-direction: column;
    position: fixed;
    height: 100vh;
    left: 0;
    top: 0;
    padding: 30px 0;
    overflow-y: auto;
}

.logo-container {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 0 20px 20px;
}

.logo {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: contain;
    background-color: var(--text-light);
    padding: 10px;
    box-shadow: var(--shadow);
}

.school-name {
    margin-top: 15px;
    text-align: center;
    font-weight: 600;
    font-size: 18px;
    color: var(--text-light);
}

.sidebar-nav ul {
    list-style: none;
    padding: 0;
}

.sidebar-nav li {
    margin-bottom: 8px;
}

.sidebar-nav a {
    display: flex;
    align-items: center;
    padding: 15px 25px;
    color: var(--text-light);
    text-decoration: none;
    font-weight: 500;
    transition: var(--transition);
}

.sidebar-nav a i {
    margin-right: 15px;
    font-size: 18px;
}

.sidebar-nav li.active a, 
.sidebar-nav a:hover {
    background-color: rgba(255, 255, 255, 0.1);
    border-left: 4px solid var(--text-light);
}

.main-content {
    flex: 1;
    margin-left: 300px;
    padding: 20px 30px;
}

.top-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.welcome-text h1 {
    font-size: 28px;
    font-weight: 600;
    color: var(--sidebar-color);
}

.user-menu {
    display: flex;
    align-items: center;
    gap: 20px;
}

.notifications, .settings {
    position: relative;
    cursor: pointer;
}

.icon {
    width: 24px;
    height: 24px;
}

.notification-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background-color: var(--accent-color);
    color: var(--text-light);
    font-size: 10px;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.user-profile {
    display: flex;
    align-items: center;
    gap: 10px;
    position: relative;
    cursor: pointer;
}

.profile-pic {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid var(--accent-color);
    transition: var(--transition);
}

.profile-pic:hover {
    border: 2px solid var(--highlight-color);
    transform: scale(1.05);
}

.user-info h3 {
    font-size: 16px;
    margin-bottom: 0;
}

.user-info p {
    font-size: 12px;
    color: var(--text-muted);
    margin: 0;
}

.mini-profile {
    display: none;
    position: absolute;
    top: 100%;
    right: 0;
    width: 280px;
    background-color: white;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    z-index: 100;
    padding: 20px;
    margin-top: 12px;
}

.mini-profile-header {
    display: flex;
    flex-direction: column;
    align-items: center;
    border-bottom: 1px solid #eaeaea;
    padding-bottom: 15px;
    margin-bottom: 15px;
}

.mini-profile-pic {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid var(--accent-color);
    margin-bottom: 10px;
}

.mini-profile-name {
    font-size: 18px;
    font-weight: 600;
    color: var(--navy-blue);
    margin-bottom: 5px;
    text-align: center;
}

.mini-profile-details {
    margin-bottom: 15px;
}

.detail-row {
    display: flex;
    margin-bottom: 8px;
}

.detail-label {
    flex: 1;
    font-size: 13px;
    color: var(--text-muted);
}

.detail-value {
    flex: 2;
    font-size: 13px;
    font-weight: 500;
    color: var(--text-dark);
}

.mini-profile-footer {
    display: flex;
    justify-content: center;
}

.mini-profile-btn {
    display: inline-block;
    padding: 8px 15px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    text-decoration: none;
    text-align: center;
    color: var(--text-light);
    background-color: var(--accent-color);
    transition: var(--transition);
}

.mini-profile-btn:hover {
    background-color: var(--highlight-color);
    transform: translateY(-2px);
}

.user-profile:hover .mini-profile {
    display: block;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: white;
    min-width: 120px;
    box-shadow: var(--shadow);
    border-radius: var(--border-radius);
    z-index: 10;
    right: 0;
    top: 100%;
    margin-top: 5px;
    overflow: hidden;
}

.dropdown-content a {
    color: var(--text-dark);
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    font-size: 14px;
    transition: var(--transition);
}

.dropdown-content a:hover {
    background-color: #f1f1f1;
    color: var(--accent-color);
}

.settings:hover .dropdown-content {
    display: block;
}

/* Documents Page Specific Styles */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.page-title {
    font-size: 24px;
    font-weight: 600;
    color: var(--sidebar-color);
}

.upload-documents-btn {
    display: inline-flex;
    align-items: center;
    padding: 10px 20px;
    background-color: var(--accent-color);
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: var(--transition);
    gap: 8px;
}

.upload-documents-btn:hover {
    background-color: var(--highlight-color);
    transform: translateY(-2px);
}

.documents-filters {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 20px;
    padding: 15px;
    background-color: white;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
}

.filter-item {
    display: flex;
    align-items: center;
    gap: 8px;
}

.filter-item label {
    font-size: 14px;
    color: var(--text-dark);
    font-weight: 500;
}

.filter-select, .filter-search {
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
    font-family: inherit;
    transition: var(--transition);
}

.filter-select:focus, .filter-search:focus {
    border-color: var(--accent-color);
    outline: none;
    box-shadow: 0 0 0 2px rgba(155, 34, 66, 0.1);
}

.filter-search {
    flex: 1;
    min-width: 200px;
}

.documents-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.document-card {
    background-color: white;
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--shadow);
    transition: var(--transition);
    position: relative;
    display: flex;
    flex-direction: column;
}

.document-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
}

.document-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 30px 0;
    background-color: #f8f8f8;
}

.document-icon i {
    font-size: 48px;
    color: var(--accent-color);
}

.document-info {
    padding: 20px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.document-name {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 5px;
    color: var(--navy-blue);
}

.document-meta {
    font-size: 12px;
    color: var(--text-muted);
    margin-bottom: 15px;
}

.document-meta span {
    display: block;
    margin-bottom: 3px;
}

.document-actions {
    display: flex;
    gap: 8px;
    margin-top: auto;
}

.document-btn {
    flex: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    padding: 8px 0;
    font-size: 12px;
    font-weight: 500;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: var(--transition);
}

.view-btn {
    background-color: #e9ecef;
    color: var(--text-dark);
}

.view-btn:hover {
    background-color: #dee2e6;
}

.download-btn {
    background-color: var(--accent-color);
    color: white;
}

.download-btn:hover {
    background-color: var(--highlight-color);
}

.document-status {
    position: absolute;
    top: 10px;
    right: 10px;
    padding: 4px 10px;
    font-size: 10px;
    font-weight: 600;
    border-radius: 20px;
    text-transform: uppercase;
}

.status-verified {
    background-color: rgba(46, 139, 87, 0.15);
    color: var(--success-green);
}

.status-pending {
    background-color: rgba(212, 167, 106, 0.15);
    color: var(--alert-amber);
}

.pagination {
    display: flex;
    justify-content: center;
    gap: 5px;
    margin-top: 30px;
}

.page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 35px;
    height: 35px;
    border-radius: 5px;
    background-color: white;
    color: var(--text-dark);
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: var(--transition);
    box-shadow: var(--shadow);
}

.page-link:hover, .page-link.active {
    background-color: var(--accent-color);
    color: white;
}

/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
    background-color: white;
    margin: 5% auto;
    width: 80%;
    max-width: 600px;
    border-radius: var(--border-radius);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    animation: modalFadeIn 0.3s;
}

@keyframes modalFadeIn {
    from {opacity: 0; transform: translateY(-20px);}
    to {opacity: 1; transform: translateY(0);}
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    border-bottom: 1px solid #eaeaea;
}

.modal-header h2 {
    color: var(--navy-blue);
    margin: 0;
    font-size: 22px;
}

.close-modal {
    color: var(--text-muted);
    font-size: 28px;
    cursor: pointer;
    transition: var(--transition);
}

.close-modal:hover {
    color: var(--accent-color);
}

.modal-body {
    padding: 20px;
}

.upload-form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
    color: var(--text-dark);
    font-size: 14px;
}

.form-group select,
.form-group input[type="text"],
.form-group textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
    font-family: inherit;
    transition: var(--transition);
}

.form-group select:focus,
.form-group input[type="text"]:focus,
.form-group textarea:focus {
    border-color: var(--accent-color);
    outline: none;
    box-shadow: 0 0 0 2px rgba(155, 34, 66, 0.1);
}

.file-upload-container {
    position: relative;
    border: 2px dashed #ddd;
    border-radius: 8px;
    padding: 30px 20px;
    text-align: center;
    transition: var(--transition);
    cursor: pointer;
}

.file-upload-container:hover {
    border-color: var(--accent-color);
    background-color: rgba(155, 34, 66, 0.05);
}

.file-upload-icon {
    font-size: 36px;
    color: var(--accent-color);
    margin-bottom: 10px;
}

.file-upload-text {
    font-size: 16px;
    color: var(--text-dark);
    margin-bottom: 5px;
}

.file-upload-info {
    font-size: 12px;
    color: var(--text-muted);
}

.file-upload {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}

.selected-file {
    display: none;
    background-color: #f8f8f8;
    padding: 10px;
    border-radius: 5px;
    margin-top: 10px;
    font-size: 13px;
}

.modal-footer {
    padding: 15px 20px;
    border-top: 1px solid #eaeaea;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

.btn {
    padding: 10px 20px;
    border-radius: 5px;
    font-size: 14px;
    cursor: pointer;
    transition: var(--transition);
    border: none;
    font-weight: 500;
}

.btn-cancel {
    background-color: #f1f1f1;
    color: var(--text-dark);
}

.btn-cancel:hover {
    background-color: #e1e1e1;
}

.btn-upload {
    background-color: var(--accent-color);
    color: white;
}

.btn-upload:hover {
    background-color: var(--highlight-color);
}

/* Responsive Design */
@media (max-width: 1200px) {
    .documents-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    }
}

@media (max-width: 992px) {
    .sidebar {
        width: 80px;
        padding: 20px 0;
    }
    
    .logo {
        width: 60px;
        height: 60px;
    }
    
    .school-name {
        display: none;
    }
    
    .sidebar-nav a i {
        font-size: 20px;
    }
    
    .sidebar-nav a span {
        display: none;
    }
    
    .main-content {
        margin-left: 80px;
    }
}

@media (max-width: 768px) {
    .container {
        flex-direction: column;
    }
    
    .sidebar {
        width: 100%;
        height: auto;
        position: relative;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        padding: 10px 20px;
        overflow-x: auto;
    }
    
    .logo-container {
        padding: 0;
        margin-right: 15px;
        flex-direction: row;
    }
    
    .logo {
        width: 50px;
        height: 50px;
    }
    
    .school-name {
        display: block;
        margin-top: 0;
        margin-left: 10px;
        font-size: 14px;
    }
    
    .sidebar-nav {
        width: 100%;
    }
    
    .sidebar-nav ul {
        display: flex;
        flex-wrap: nowrap;
        overflow-x: auto;
        padding: 0 10px;
    }
    
    .sidebar-nav li {
        margin: 0 5px;
        white-space: nowrap;
    }
    
    .sidebar-nav a {
        padding: 10px 15px;
        font-size: 14px;
    }
    
    .sidebar-nav a i {
        margin-right: 5px;
    }
    
    .main-content {
        margin-left: 0;
        margin-top: 10px;
    }
    
    .documents-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 576px) {
    .main-content {
        padding: 15px;
    }
    
    .page-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }
    
    .documents-filters {
        flex-direction: column;
        gap: 10px;
    }
    
    .filter-item {
        width: 100%;
    }
    
    .filter-search {
        width: 100%;
    }
}
</style>
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <div class="logo-container">
                <img src="{{asset ('images/logo.png')}}" alt="ACA Montessori School Logo" class="logo">
                <div class="school-name">MCA Montessori School</div>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="{{ route('student.dashboard') }}"><i class="fas fa-th-large"></i><span>DASHBOARD</span></a></li>
                    <li><a href="{{ route('student.grades') }}"><i class="fas fa-chart-bar"></i><span>VIEW MY GRADES</span></a></li>
                    <li><a href="{{ route('student.subjects') }}"><i class="fas fa-book"></i><span>SUBJECTS</span></a></li>
                    <li class="active"><a href="#"><i class="fas fa-file-alt"></i><span>MY DOCUMENTS</span></a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <header class="top-bar">
                <div class="welcome-text">
                    <h1>Hello, {{ optional($student)->first_name ?? (Auth::user()->name ?? 'Student') }}!</h1>
                </div>
                <div class="user-menu">
                    <div class="notifications">
                        <img src="{{asset ('images/bell_student.png')}}" alt="Notifications" class="icon">
                        <span class="notification-badge">3</span>
                        <!-- Notification dropdown content here -->
                    </div>
                    <div class="settings">
                        <img src="{{asset ('images/settings_student.png')}}" alt="Settings" class="icon">
                        <div class="dropdown-content">
                            <a href="#"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        </div>
                    </div>
                    <div class="user-profile">
                        <img src="{{ asset(optional($student)->picture ? 'storage/'.optional($student)->picture : 'images/student_user.png') }}" alt="{{ optional($student)->short_name ?? (Auth::user()->name ?? 'Student') }}" class="profile-pic">
                        <div class="user-info">
                            <h3>{{ optional($student)->short_name ?? (Auth::user()->name ?? 'Student') }}</h3>
                            <p>{{ optional(optional($student)->gradeLevel)->name ?? '—' }}</p>
                        </div>
                        <div class="mini-profile">
                            <div class="mini-profile-header">
                                <img src="{{ asset(optional($student)->picture ? 'storage/'.optional($student)->picture : 'images/student_user.png') }}" alt="{{ optional($student)->short_name ?? (Auth::user()->name ?? 'Student') }}" class="mini-profile-pic">
                                <h3 class="mini-profile-name">{{ optional($student)->short_name ?? (Auth::user()->name ?? 'Student') }}</h3>
                                <p>Student ID: {{ optional(optional($student)->studentID)->student_number ?? (optional($student)->school_student_id ?? '—') }}</p>
                            </div>
                            <div class="mini-profile-details">
                                <div class="detail-row">
                                    <div class="detail-label">Grade Level:</div>
                                    <div class="detail-value">{{ optional(optional($student)->gradeLevel)->name ?? '—' }}</div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Section:</div>
                                    <div class="detail-value">{{ optional(optional($student)->section)->section_name ?? '—' }}</div>
                                </div>
                                    <div class="detail-row">
                                        <div class="detail-label">Adviser:</div>
                                        <div class="detail-value">{{ optional($student)->adviser_name ?? '—' }}</div>
                                    </div>
                                <div class="detail-row">
                                    <div class="detail-label">Email:</div>
                                    <div class="detail-value">{{ optional($student)->email ?? (Auth::user()->email ?? '—') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <section class="page-header">
                <h2 class="page-title">My Documents</h2>
                <div style="display: flex; gap: 10px;">
                    <button class="upload-documents-btn" id="uploadBtn">
                        <i class="fas fa-upload"></i> Upload Document
                    </button>
                    @if(config('app.debug'))
                    <button onclick="toggleDebugInfo()" style="padding: 10px 15px; background: #17a2b8; color: white; border: none; border-radius: 5px; cursor: pointer;">
                        <i class="fas fa-bug"></i> Debug Info
                    </button>
                    @endif
                </div>
            </section>
            
            @if(config('app.debug'))
            <div id="debugInfo" style="display: none; background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 8px; padding: 15px; margin-bottom: 20px; font-size: 13px;">
                <h3 style="margin-top: 0; color: #495057;"><i class="fas fa-info-circle"></i> Debug Information</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 10px;">
                    <div><strong>Student ID:</strong> {{ $student->student_id ?? 'N/A' }}</div>
                    <div><strong>User ID:</strong> {{ Auth::id() }}</div>
                    <div><strong>Application Number:</strong> {{ $student->school_student_id ?? 'N/A' }}</div>
                    <div><strong>Documents Found:</strong> {{ $documents->count() }}</div>
                    <div><strong>Student Email:</strong> {{ $student->email ?? 'N/A' }}</div>
                    <div><strong>LRN:</strong> {{ $student->lrn ?? 'N/A' }}</div>
                </div>
                @if($documents->count() > 0)
                <div style="margin-top: 15px;">
                    <strong>Document Paths:</strong>
                    <ul style="margin: 5px 0; padding-left: 20px;">
                        @foreach($documents as $doc)
                        <li>
                            <strong>{{ $doc['name'] }}:</strong> 
                            <code style="background: #e9ecef; padding: 2px 6px; border-radius: 3px;">{{ $doc['path'] ?? 'N/A' }}</code>
                            <span style="color: {{ $doc['exists'] ? '#28a745' : '#dc3545' }};">
                                ({{ $doc['exists'] ? 'EXISTS' : 'MISSING' }})
                            </span>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div style="margin-top: 10px; padding: 10px; background: #fff3cd; border-radius: 4px;">
                    <strong>Tip:</strong> If documents are missing, check that:
                    <ol style="margin: 5px 0; padding-left: 20px;">
                        <li>Files were uploaded during enrollment</li>
                        <li>The <code>storage/app/public</code> directory exists</li>
                        <li>Run <code>php artisan storage:link</code> to create symbolic link</li>
                        <li>File paths in database match actual file locations</li>
                    </ol>
                </div>
            </div>
            <script>
                function toggleDebugInfo() {
                    const debug = document.getElementById('debugInfo');
                    debug.style.display = debug.style.display === 'none' ? 'block' : 'none';
                }
            </script>
            @endif

            <section class="documents-filters">
                
                <div class="filter-item">
                    <label for="documentType">Document Category:</label>
                    <select id="documentType" class="filter-select">
                    <option value="all">All Documents</option>
                    <option value="academic">Academic Records</option>
                    <option value="administrative">Administrative Documents</option>
                    <option value="legal">Legal Documents</option>
                    <option value="identification">Identification</option>
                    <option value="payment">Payment Proof</option>
                    </select>
                </div>
                <div class="filter-item">
                    <label for="documentStatus">Status:</label>
                    <select id="documentStatus" class="filter-select">
                    <option value="all">All Status</option>
                    <option value="verified">Verified</option>
                    <option value="pending">Pending</option>
                    </select>
                </div>
                <div class="filter-item">
                    <label for="searchDocument">Search:</label>
                    <input type="text" id="searchDocument" class="filter-search" placeholder="Search documents...">
                </div>
            </section>


            <section class="documents-grid">
                @forelse($documents as $doc)
                    
                    <div
                    class="document-card"
                    data-type="{{ $doc['category'] ?? Str::slug($doc['type']) }}"
                    data-status="{{ Str::after($doc['status'], 'status-') }}"
                    data-name="{{ strtolower($doc['name']) }}"
                    data-category="{{ $doc['category'] ?? 'other' }}"
                    data-exists="{{ isset($doc['exists']) && $doc['exists'] ? '1' : '0' }}"
                    >
                    <div class="document-icon">
                        <i class="fas {{ $doc['icon'] }}"></i>
                    </div>

                    <span class="document-status {{ $doc['status'] }}">{{ isset($doc['exists']) && $doc['exists'] ? 'Verified' : 'Missing File' }}</span>
                    <div class="document-info">
                        <h3 class="document-name">{{ $doc['name'] }}</h3>
                        <div class="document-meta">
                        <span><strong>Type:</strong> {{ $doc['type'] }}</span>
                        <span><strong>Uploaded:</strong> {{ $doc['uploaded'] }}</span>
                        <span><strong>Size:</strong> {{ $doc['size'] }}</span>
                        @if(!isset($doc['exists']) || !$doc['exists'])
                        <span style="color: #dc3545;"><strong><i class="fas fa-exclamation-triangle"></i> File not found in storage</strong></span>
                        @endif
                        </div>
                        <div class="document-actions">
                        <button
                            class="document-btn view-btn"
                            onclick="safeOpenDocPreview(this, '{{ $doc['url'] }}')"
                        ><i class="fas fa-eye"></i> View</button>
                        <button
                            class="document-btn download-btn"
                            onclick="safeDownloadDoc(this, '{{ $doc['url'] }}')"
                        ><i class="fas fa-download"></i> Download</button>
                        </div>
                    </div>
                    </div>
                @empty
                    <div class="no-documents-container">
                        <div class="no-documents-icon">
                            <i class="fas fa-folder-open"></i>
                        </div>
                        <p class="no-documents">No documents have been uploaded yet.</p>
                        <p class="no-documents-hint">Documents uploaded during enrollment will appear here automatically.</p>
                    </div>
                @endforelse
            </section>




                <!-- Document Preview Modal -->
                <div id="doc-preview-overlay" class="overlay" style="display:none;">
                  <div class="add-student-modal" style="max-width:1000px;width:90vw;height:90vh;display:flex;flex-direction:column;overflow:hidden;">
                    <div class="modal-header">
                      <div class="header-content">
                        <div class="icon">
                          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="3" y1="9" x2="21" y2="9"></line>
                          </svg>
                        </div>
                        <div class="header-text">
                          <h2>Document Preview</h2>
                          <p>View your uploaded document</p>
                        </div>
                      </div>
                      <button type="button" class="close-btn" onclick="closeDocPreview()">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                          <line x1="18" y1="6" x2="6" y2="18"></line>
                          <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                      </button>
                    </div>
                    <div class="modal-body" style="flex:1;display:flex;align-items:center;justify-content:center;overflow:hidden;padding:0;background:#0f172a;">
                      <div id="doc-preview-wrapper" style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;padding:12px;">
                        <iframe id="doc-preview-frame" src="about:blank" style="display:none;width:100%;height:100%;border:none;background:#fff;border-radius:8px;"></iframe>
                        <img id="doc-preview-image" src="" alt="Document" style="display:none;max-width:100%;max-height:100%;object-fit:contain;border-radius:8px;background:#fff;box-shadow:0 10px 30px rgba(0,0,0,.35);">
                      </div>
                    </div>
                    <div class="modal-footer">
                      <div class="footer-info">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                          <circle cx="12" cy="12" r="10"></circle>
                          <path d="m9 12 2 2 4-4"></path>
                        </svg>
                        <span>If the preview fails, use Download to open the file.</span>
                      </div>
                      <div class="footer-actions">
                        <button id="doc-download-btn" type="button" class="btn btn-primary">
                          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                            <polyline points="7 10 12 15 17 10"/>
                            <line x1="12" y1="15" x2="12" y2="3"/>
                          </svg>
                          Download
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="closeDocPreview()">Close</button>
                      </div>
                    </div>
                  </div>
                </div>

                <script>
                  function safeOpenDocPreview(btn, url){
                    var card = btn.closest('.document-card');
                    if (card && card.dataset.exists === '0'){
                      alert('This document file is not available. Please re-upload or contact support.');
                      return;
                    }
                    openDocPreview(url);
                  }

                  function openDocPreview(url){
                    console.log('Opening document preview:', url);
                    var overlay = document.getElementById('doc-preview-overlay');
                    var frame   = document.getElementById('doc-preview-frame');
                    var img     = document.getElementById('doc-preview-image');
                    var dbtn    = document.getElementById('doc-download-btn');
                    dbtn.dataset.url = url;
                    
                    // decide viewer by extension
                    var lower = (url || '').toLowerCase();
                    var isImage = /(\.png|\.jpg|\.jpeg|\.gif|\.webp)(\?|$)/.test(lower);
                    
                    if (isImage){
                      frame.style.display = 'none';
                      img.style.display = 'block';
                      img.src = url;
                      
                      // Handle image load errors
                      img.onerror = function() {
                        console.error('Failed to load image:', url);
                        alert('Unable to load image. The file may be missing or inaccessible. Please try downloading instead.');
                        closeDocPreview();
                      };
                    } else {
                      img.style.display = 'none';
                      frame.style.display = 'block';
                      frame.src = url;
                      
                      // Handle iframe load errors
                      frame.onerror = function() {
                        console.error('Failed to load document:', url);
                        alert('Unable to preview this document. Please try downloading it instead.');
                        closeDocPreview();
                      };
                    }
                    
                    overlay.style.display = 'flex';
                    document.body.style.overflow = 'hidden';
                    overlay.onclick = function(e){ if(e.target === overlay){ closeDocPreview(); } };
                  }
                  function closeDocPreview(){
                    var overlay = document.getElementById('doc-preview-overlay');
                    var frame   = document.getElementById('doc-preview-frame');
                    var img     = document.getElementById('doc-preview-image');
                    overlay.style.display = 'none';
                    frame.src = 'about:blank';
                    img.src   = '';
                    document.body.style.overflow = '';
                  }

                  function safeDownloadDoc(btn, url){
                    var card = btn.closest('.document-card');
                    if (card && card.dataset.exists === '0'){
                      alert('This document file is not available.');
                      return;
                    }
                    downloadDoc(url);
                  }

                  async function downloadDoc(url){
                    try {
                      const res = await fetch(url, { credentials: 'same-origin' });
                      if (!res.ok) throw new Error('Download failed');
                      const blob = await res.blob();
                      const link = document.createElement('a');
                      const fname = (url.split('/').pop() || 'document').split('?')[0];
                      link.href = URL.createObjectURL(blob);
                      link.download = fname || 'document';
                      document.body.appendChild(link);
                      link.click();
                      URL.revokeObjectURL(link.href);
                      link.remove();
                    } catch (e) {
                      alert('Unable to download document.');
                    }
                  }

                  document.addEventListener('click', function(e){
                    if (e.target && e.target.id === 'doc-download-btn'){
                      const url = e.target.dataset.url;
                      if (url) downloadDoc(url);
                    }
                  });
                </script>

                <!--<div class="document-card">
                    <div class="document-icon">
                        <i class="fas fa-file-medical"></i>
                    </div>
                    <span class="document-status status-verified">Verified</span>
                    <div class="document-info">
                        <h3 class="document-name">Medical Certificate</h3>
                        <div class="document-meta">
                            <span><strong>Type:</strong> Medical Record</span>
                            <span><strong>Uploaded:</strong> January 10, 2025</span>
                            <span><strong>Size:</strong> 1.2 MB</span>
                        </div>
                        <div class="document-actions">
                            <button class="document-btn view-btn">
                                <i class="fas fa-eye"></i> View
                            </button>
                            <button class="document-btn download-btn">
                                <i class="fas fa-download"></i> Download
                            </button>
                        </div>
                    </div>
                </div>

                <div class="document-card">
                    <div class="document-icon">
                        <i class="fas fa-file-contract"></i>
                    </div>
                    <span class="document-status status-verified">Verified</span>
                    <div class="document-info">
                        <h3 class="document-name">Enrollment Form</h3>
                        <div class="document-meta">
                            <span><strong>Type:</strong> Administrative</span>
                            <span><strong>Uploaded:</strong> February 5, 2025</span>
                            <span><strong>Size:</strong> 567 KB</span>
                        </div>
                        <div class="document-actions">
                            <button class="document-btn view-btn">
                                <i class="fas fa-eye"></i> View
                            </button>
                            <button class="document-btn download-btn">
                                <i class="fas fa-download"></i> Download
                            </button>
                        </div>
                    </div>
                </div>

                <div class="document-card">
                    <div class="document-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <span class="document-status status-pending">Pending</span>
                    <div class="document-info">
                        <h3 class="document-name">Certificate of Attendance</h3>
                        <div class="document-meta">
                            <span><strong>Type:</strong> Certificate</span>
                            <span><strong>Uploaded:</strong> April 3, 2025</span>
                            <span><strong>Size:</strong> 342 KB</span>
                        </div>
                        <div class="document-actions">
                            <button class="document-btn view-btn">
                                <i class="fas fa-eye"></i> View
                            </button>
                            <button class="document-btn download-btn">
                                <i class="fas fa-download"></i> Download
                            </button>
                        </div>
                    </div>
                </div>-->

                <!-- Upload Modal -->
                <div id="uploadModal" class="modal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2>Upload Document</h2>
                            <span class="close-modal" id="closeModal">&times;</span>
                        </div>
                        <div class="modal-body">
                            <form id="uploadForm" class="upload-form">
                                <div class="form-group">
                                    <label for="docName">Document Name</label>
                                    <input type="text" id="docName" name="docName" required>
                                </div>
                                <div class="form-group">
                                    <label for="docFile">Select File</label>
                                    <div class="file-upload-container">
                                        <i class="fas fa-cloud-upload-alt file-upload-icon"></i>
                                        <p class="file-upload-text">Click or drag to upload</p>
                                        <p class="file-upload-info">Accepted file types: PDF, DOCX</p>
                                        <input type="file" id="docFile" class="file-upload" accept=".pdf,.doc,.docx" required>
                                    </div>
                                    <div class="selected-file" id="selectedFile"></div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-cancel" id="cancelUpload">Cancel</button>
                            <button class="btn btn-upload" id="submitUpload">Upload</button>
                        </div>
                    </div>
                </div>
<script>
    const uploadBtn = document.getElementById('uploadBtn');
    const uploadModal = document.getElementById('uploadModal');
    const closeModal = document.getElementById('closeModal');
    const cancelUpload = document.getElementById('cancelUpload');
    const docFile = document.getElementById('docFile');
    const selectedFile = document.getElementById('selectedFile');
    const submitUpload = document.getElementById('submitUpload');
    const uploadForm = document.getElementById('uploadForm');
    const documentsGrid = document.querySelector('.documents-grid');

    let uploadedDocs = []; // To store files in-memory for download/view

    uploadBtn.addEventListener('click', () => {
        uploadModal.style.display = 'block';
    });

    closeModal.addEventListener('click', () => {
        uploadModal.style.display = 'none';
        uploadForm.reset();
        selectedFile.style.display = 'none';
    });

    cancelUpload.addEventListener('click', () => {
        uploadModal.style.display = 'none';
        uploadForm.reset();
        selectedFile.style.display = 'none';
    });

    docFile.addEventListener('change', () => {
        if (docFile.files.length > 0) {
            selectedFile.innerText = `Selected: ${docFile.files[0].name}`;
            selectedFile.style.display = 'block';
        } else {
            selectedFile.style.display = 'none';
        }
    });

    submitUpload.addEventListener('click', () => {
        const name = document.getElementById('docName').value;
        const file = docFile.files[0];
        if (name && file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const fileURL = e.target.result;

                const card = document.createElement('div');
                card.className = 'document-card';
                card.innerHTML = `
                    <div class="document-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <span class="document-status status-pending">Pending</span>
                    <div class="document-info">
                        <h3 class="document-name">${name}</h3>
                        <div class="document-meta">
                            <span><strong>Type:</strong> Uploaded</span>
                            <span><strong>Uploaded:</strong> ${new Date().toLocaleDateString()}</span>
                            <span><strong>Size:</strong> ${(file.size / 1024).toFixed(1)} KB</span>
                        </div>
                        <div class="document-actions">
                            <a class="document-btn view-btn" href="${fileURL}" target="_blank">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <a class="document-btn download-btn" href="${fileURL}" download="${file.name}">
                                <i class="fas fa-download"></i> Download
                            </a>
                        </div>
                    </div>
                `;
                documentsGrid.prepend(card);
            };
            reader.readAsDataURL(file);

            uploadForm.reset();
            selectedFile.style.display = 'none';
            uploadModal.style.display = 'none';
        } else {
            alert("Please enter a document name and select a file.");
        }
    });

    window.addEventListener('click', (e) => {
        if (e.target === uploadModal) {
            uploadModal.style.display = 'none';
            uploadForm.reset();
            selectedFile.style.display = 'none';
        }
    });
</script>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const typeSelect   = document.getElementById('documentType');
    const statusSelect = document.getElementById('documentStatus');
    const searchInput  = document.getElementById('searchDocument');
    const cards        = Array.from(document.querySelectorAll('.document-card'));

    function filterDocuments() {
      const type   = typeSelect.value;
      const status = statusSelect.value;
      const query  = searchInput.value.trim().toLowerCase();

      cards.forEach(card => {
        const matchesType   = (type === 'all') || (card.dataset.category === type) || (card.dataset.type === type);
        const matchesStatus = (status === 'all') || (card.dataset.status === status);
        const matchesSearch = (!query) || card.dataset.name.includes(query);

        if (matchesType && matchesStatus && matchesSearch) {
          card.style.display = '';
        } else {
          card.style.display = 'none';
        }
      });
    }

    typeSelect.addEventListener('change', filterDocuments);
    statusSelect.addEventListener('change', filterDocuments);
    searchInput.addEventListener('input', filterDocuments);
  });
</script>


</body>
</html>
