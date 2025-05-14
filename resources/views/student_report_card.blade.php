<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCA Montessori School - View My Grades</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
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
    font-family: 'Poppins', sans-serif;
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

/* Term Selector */
.term-selector {
    display: flex;
    gap: 20px;
    margin-bottom: 30px;
}

.term-option {
    background-color: white;
    padding: 15px 30px;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    cursor: pointer;
    transition: var(--transition);
    border: 2px solid transparent;
    font-weight: 500;
    color: var(--text-dark);
    flex: 1;
    text-align: center;
}

.term-option:hover {
    transform: translateY(-2px);
}

.term-option.active {
    border-color: var(--accent-color);
    background-color: rgba(155, 34, 66, 0.05);
    color: var(--accent-color);
}

/* Grades Section */
.grades-section {
    background-color: white;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    padding: 25px;
    margin-bottom: 30px;
}

.section-title {
    font-size: 20px;
    font-weight: 600;
    color: var(--navy-blue);
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 1px solid #eaeaea;
}

.grades-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 15px;
}

.grades-table th, 
.grades-table td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #eaeaea;
}

.grades-table th {
    font-weight: 600;
    color: var(--navy-blue);
    background-color: rgba(29, 52, 97, 0.05);
}

.grades-table tr:last-child td {
    border-bottom: none;
}

.grades-table tr:hover td {
    background-color: rgba(245, 241, 232, 0.5);
}

.subject-name {
    font-weight: 500;
    color: var(--text-dark);
}

.excellent {
    color: var(--success-green);
    font-weight: 600;
}

.very-good {
    color: #4682B4;
    font-weight: 600;
}

.good {
    color: var(--alert-amber);
    font-weight: 600;
}

.poor {
    color: var(--accent-color);
    font-weight: 600;
}

.final-grade {
    background-color: rgba(29, 52, 97, 0.05);
    font-weight: 600;
}

/* Core Values Section */
.core-values-section {
    background-color: white;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    padding: 25px;
    margin-bottom: 30px;
}

.core-values-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.core-values-table th, 
.core-values-table td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #eaeaea;
}

.core-values-table th {
    font-weight: 600;
    color: var(--navy-blue);
    background-color: rgba(29, 52, 97, 0.05);
}

.core-values-table tr:last-child td {
    border-bottom: none;
}

.core-values-table tr:hover td {
    background-color: rgba(245, 241, 232, 0.5);
}

.core-value-name {
    font-weight: 500;
    color: var(--text-dark);
}

.legend {
    display: flex;
    gap: 20px;
    margin-top: 10px;
    flex-wrap: wrap;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 5px;
}

.legend-color {
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.legend-text {
    font-size: 13px;
    color: var(--text-muted);
}

.excellent-color {
    background-color: var(--success-green);
}

.very-good-color {
    background-color: #4682B4;
}

.good-color {
    background-color: var(--alert-amber);
}

.poor-color {
    background-color: var(--accent-color);
}

.attendance-link {
    display: inline-block;
    margin-top: 20px;
    color: var(--accent-color);
    text-decoration: none;
    font-weight: 500;
    transition: var(--transition);
}

.attendance-link:hover {
    color: var(--highlight-color);
    text-decoration: underline;
}

/* Notification Styles */
.notification-menu {
    width: 320px;
    padding: 0;
}

.notification-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px;
    border-bottom: 1px solid #eaeaea;
}

.notification-header h3 {
    margin: 0;
    font-size: 16px;
    color: var(--navy-blue);
}

.mark-all {
    font-size: 12px;
    color: var(--accent-color);
    text-decoration: none;
}

.mark-all:hover {
    text-decoration: underline;
}

.notification-list {
    max-height: 320px;
    overflow-y: auto;
}

.notification-item {
    display: flex;
    gap: 12px;
    padding: 12px 15px;
    border-bottom: 1px solid #f1f1f1;
    text-decoration: none;
    color: var(--text-dark);
    transition: var(--transition);
}

.notification-item:hover {
    background-color: #f8f8f8;
}

.notification-item.unread {
    background-color: rgba(155, 34, 66, 0.05);
}

.notification-item.unread:hover {
    background-color: rgba(155, 34, 66, 0.1);
}

.notification-icon {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.teacher-icon {
    background-color: rgba(29, 52, 97, 0.1);
    color: var(--navy-blue);
}

.event-icon {
    background-color: rgba(212, 167, 106, 0.1);
    color: var(--alert-amber);
}

.notification-text p {
    margin: 0 0 5px 0;
    font-size: 13px;
    line-height: 1.4;
}

.notification-time {
    font-size: 11px;
    color: var(--text-muted);
}

.notification-footer {
    padding: 12px;
    text-align: center;
    border-top: 1px solid #eaeaea;
}

.view-all {
    font-size: 13px;
    color: var(--accent-color);
    text-decoration: none;
    font-weight: 500;
}

.view-all:hover {
    text-decoration: underline;
}

.notifications {
    position: relative;
}

.notifications:hover .dropdown-content {
    display: block;
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
    max-width: 700px;
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
    max-height: 70vh;
    overflow-y: auto;
}

.modal-footer {
    padding: 15px 20px;
    border-top: 1px solid #eaeaea;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

/* Responsive Design */
@media (max-width: 1200px) {
    .dashboard-grid {
        grid-template-columns: 1fr;
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
    
    .term-selector {
        flex-direction: column;
        gap: 10px;
    }
    
    .term-option {
        width: 100%;
    }
    
    .grades-table {
        display: block;
        overflow-x: auto;
    }
    
    .top-bar {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }
    
    .user-menu {
        width: 100%;
        justify-content: flex-end;
    }
}

@media (max-width: 576px) {
    .main-content {
        padding: 15px;
    }
    
    .top-bar {
        margin-bottom: 20px;
    }
    
    .welcome-text h1 {
        font-size: 24px;
    }
    
    .user-menu {
        gap: 10px;
    }
    
    .user-info h3 {
        font-size: 14px;
    }
    
    .user-info p {
        font-size: 10px;
    }
}

.print-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 10px 15px;
    background-color: var(--accent-color);
    color: var(--text-light);
    border: none;
    border-radius: var(--border-radius);
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    margin-top: 20px;
}

.print-button:hover {
    background-color: #6b0001;
}

.print-button i {
    font-size: 16px;
}


@media print {
    .sidebar, .top-bar, .print-button {
        display: none !important;
    }

    .main-content {
        margin-left: 0 !important;
        padding: 20px;
        width: 100%;
    }

    .grades-section, .core-values-section {
        box-shadow: none;
        border: 1px solid #ddd;
        page-break-inside: avoid;
    }
}
@media print {
  body {
    font-family: 'Arial', sans-serif;
    color: #333;
    background: white;
  }

  .school-header-print {
    text-align: center;
    margin-bottom: 30px;
  }

  .grades-section table {
    border-collapse: collapse;
    width: 100%;
  }

  .grades-section th,
  .grades-section td {
    border-bottom: 1px solid #ccc;
    padding: 10px;
  }

  .grades-section tr:last-child td {
    border-bottom: none;
  }

  .core-values-section {
    margin-top: 40px;
  }
}
.school-year-display {
  font-size: 1.2rem;
  margin: 1rem 0;
}
.school-year-display strong {
  color: #2c7be5;
}


</style>
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <div class="logo-container">
                <img src="{{asset ('images/logo.png')}}" alt="MCA Montessori School Logo" class="logo">
                <div class="school-name">MCA Montessori School</div>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="{{ route('student.dashboard') }}"><i class="fas fa-th-large"></i><span>DASHBOARD</span></a></li>
                    <li class="active"><a href="#"><i class="fas fa-chart-bar"></i><span>VIEW MY GRADES</span></a></li>
                    <li><a href="{{ route('student.subjects') }}"><i class="fas fa-book"></i><span>SUBJECTS</span></a></li>
                    <li><a href="{{ route('student.documents') }}"><i class="fas fa-file-alt"></i><span>MY DOCUMENTS</span></a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <header class="top-bar">
                <div class="welcome-text">
                    <h1>My Academic Performance</h1>
                </div>
                <div class="user-menu">
                    <div class="notifications">
                        <img src="{{asset ('images/bell.png')}}" alt="Notifications" class="icon">
                        <span class="notification-badge">3</span>
                        <div class="dropdown-content notification-menu">
                            <div class="notification-header">
                                <h3>Notifications</h3>
                                <a href="#" class="mark-all">Mark all as read</a>
                            </div>
                            <div class="notification-list">
                                <a href="#" class="notification-item unread">
                                    <div class="notification-icon teacher-icon">
                                        <i class="fas fa-user-tie"></i>
                                    </div>
                                    <div class="notification-text">
                                        <p><strong>Ms. Garcia:</strong> Your English Literature essay received an A.</p>
                                        <span class="notification-time">2 hours ago</span>
                                    </div>
                                </a>
                                <a href="#" class="notification-item unread">
                                    <div class="notification-icon teacher-icon">
                                        <i class="fas fa-user-tie"></i>
                                    </div>
                                    <div class="notification-text">
                                        <p><strong>Mr. Santos:</strong> Please submit your Math homework by Friday.</p>
                                        <span class="notification-time">Yesterday</span>
                                    </div>
                                </a>
                                <a href="#" class="notification-item unread">
                                    <div class="notification-icon event-icon">
                                        <i class="fas fa-calendar-day"></i>
                                    </div>
                                    <div class="notification-text">
                                        <p><strong>School Event:</strong> Foundation Day preparations next week.</p>
                                        <span class="notification-time">2 days ago</span>
                                    </div>
                                </a>
                            </div>
                            <div class="notification-footer">
                                <a href="#" class="view-all">View All Notifications</a>
                            </div>
                        </div>
                    </div>
                    <div class="settings">
                        <img src="{{asset ('images/settings.png')}}" alt="Settings" class="icon">
                        <div class="dropdown-content">
                            <a href="#"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        </div>
                    </div>
                    <div class="user-profile">
                        <img src="{{asset ('images/student_user.png')}}" alt="Krystal Mendez" class="profile-pic">
                        <div class="user-info">
                            <h3>Krystal Mendez</h3>
                            <p>Grade 12</p>
                        </div>
                        <div class="mini-profile">
                            <div class="mini-profile-header">
                                <img src="{{asset ('images/student_user.png')}}" alt="Krystal Mendez" class="mini-profile-pic">
                                <h3 class="mini-profile-name">Krystal Mendez</h3>
                                <p>Student ID: STU-12-4875</p>
                            </div>
                            <div class="mini-profile-details">
                                <div class="detail-row">
                                    <div class="detail-label">Year Level:</div>
                                    <div class="detail-value">Grade 12</div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Section:</div>
                                    <div class="detail-value">Wisdom</div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Adviser:</div>
                                    <div class="detail-value">Ms. Christine Santos</div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Email:</div>
                                    <div class="detail-value">krystal.mendez@student.mca.edu</div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </header>

            @php
                // Get today’s month and year
                $today = \Carbon\Carbon::now();
                $month = $today->month;
                $year  = $today->year;

                // If current month is January–May, we’re in the *second half* of the AY that started the previous year
                if ($month >= 1 && $month <= 5) {
                    $start = $year - 1;
                    $end   = $year;
                }
                // Otherwise June–December, we’re in the *first half* of the AY that starts this year
                else {
                    $start = $year;
                    $end   = $year + 1;
                }
                $schoolYear = $start . '–' . $end;
            @endphp

            <div class="term-selector">
                <!--<div class="term-option active" data-term="first">1st Term</div>
                <div class="term-option" data-term="second">2nd Term</div>-->
                <div class="school-year-display">
                    Academic Year: <strong>{{ $schoolYear }}</strong>
                </div>
            </div>

            <section class="grades-section first-term-content">
                <h2 class="section-title">Academic Performance <!--- 1st Term--></h2>
                @php
                
                function gradeStatusClass($value) {
                    if ($value === null) {
                        return '';
                    } elseif ($value >= 90) {
                        return 'excellent';
                    } elseif ($value >= 85) {
                        return 'very-good';
                    } elseif ($value >= 80) {
                        return 'good';
                    } elseif ($value >= 75) {
                        return 'fair';
                    } else {
                        return 'poor';
                    }
                }
                @endphp

                <table class="grades-table">
                <thead>
                    <tr>
                    <th>Subject</th>
                    <th>1st Quarter</th>
                    <th>2nd Quarter</th>
                    <th>3rd Quarter</th>
                    <th>4th Quarter</th>
                    <th>Final Grade</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($grades as $grade)
                    @php
                        $g1 = $grade->first_quarter;
                        $g2 = $grade->second_quarter;
                        $g3 = $grade->third_quarter;
                        $g4 = $grade->fourth_quarter;
                        $gf = number_format($grade->final_grade, 1);
                    @endphp
                    <tr>
                        <td class="subject-name">{{ $grade->subject->name ?? 'Unknown Subject' }}</td>

                        <td class="{{ gradeStatusClass($g1) }}">
                        {{ $g1 ?? 'N/A' }}
                        </td>
                        <td class="{{ gradeStatusClass($g2) }}">
                        {{ $g2 ?? 'N/A' }}
                        </td>
                        <td class="{{ gradeStatusClass($g3) }}">
                        {{ $g3 ?? 'N/A' }}
                        </td>
                        <td class="{{ gradeStatusClass($g4) }}">
                        {{ $g4 ?? 'N/A' }}
                        </td>
                        <td class="final-grade {{ gradeStatusClass($gf) }}">
                        {{ $gf }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                </table>

            
                <!-- Print Button -->
                <button class="print-button" id="printReportCard">
                <i class="fas fa-print"></i> Print Report Card
                </button>

            </section>
            

            <section class="grades-section second-term-content" style="display: none;">
                <h2 class="section-title">Academic Performance - 2nd Term</h2>
                <table class="grades-table">
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>1st Quarter</th>
                            <th>2nd Quarter</th>
                            <th>3rd Quarter</th>
                            <th>4th Quarter</th>
                            <th>Final Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="subject-name">Mathematics</td>
                            <td class="very-good">88</td>
                            <td class="very-good">85</td>
                            <td class="very-good">87</td>
                            <td class="very-good">89</td>
                            <td class="final-grade very-good">87.3</td>
                        </tr>
                        <tr>
                            <td class="subject-name">English</td>
                            <td class="excellent">90</td>
                            <td class="excellent">92</td>
                            <td class="excellent">91</td>
                            <td class="excellent">93</td>
                            <td class="final-grade excellent">91.5</td>
                        </tr>
                        <tr>
                            <td class="subject-name">Science</td>
                            <td class="very-good">86</td>
                            <td class="very-good">88</td>
                            <td class="very-good">85</td>
                            <td class="very-good">87</td>
                            <td class="final-grade very-good">86.5</td>
                        </tr>
                        <tr>
                            <td class="subject-name">Filipino</td>
                            <td class="good">79</td>
                            <td class="good">77</td>
                            <td class="very-good">81</td>
                            <td class="very-good">83</td>
                            <td class="final-grade good">80.0</td>
                        </tr>
                        <tr>
                            <td class="subject-name">Social Studies</td>
                            <td class="excellent">90</td>
                            <td class="excellent">91</td>
                            <td class="excellent">92</td>
                            <td class="excellent">93</td>
                            <td class="final-grade excellent">91.5</td>
                        </tr>
                    </tbody>
                </table>

                <!-- Print Button -->
                <button class="print-button" id="printReportCard">
                    <i class="fas fa-print"></i> Print Report Card
                    </button>
            </section>
            
            <section class="core-values-section">
    <h2 class="section-title">Core Values Evaluation</h2>

    <table class="core-values-table">
        <thead>
            <tr>
                <th>Core Value</th>
                <th>Evaluation</th>
            </tr>
        </thead>
        <tbody>
            @forelse($evaluations as $eval)
                @php
                    $score = $eval->score;
                    $statusClass = $score >= 90 ? 'excellent'
                                  : ($score >= 80 ? 'very-good'
                                  : ($score >= 75 ? 'good' : 'poor'));
                @endphp
                <tr>
                    <td class="core-value-name">{{ $eval->coreValue->name }}</td>
                    <td class="{{ $statusClass }}">{{ number_format($score, 1) }}</td>
                </tr>
            @empty
                <tr><td colspan="2">No evaluations yet.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="legend">
        <div class="legend-item">
            <div class="legend-color excellent-color"></div>
            <span>100–90: Excellent</span>
        </div>
        <div class="legend-item">
            <div class="legend-color very-good-color"></div>
            <span>89–80: Very Good</span>
        </div>
        <div class="legend-item">
            <div class="legend-color good-color"></div>
            <span>79–75: Good</span>
        </div>
        <div class="legend-item">
            <div class="legend-color poor-color"></div>
            <span>Below 75: Poor</span>
        </div>
    </div>

</section>

<script>
document.querySelectorAll('.term-option').forEach(option => {
    option.addEventListener('click', () => {
        document.querySelectorAll('.term-option').forEach(o => o.classList.remove('active'));
        option.classList.add('active');

        const term = option.dataset.term;
        document.querySelector('.first-term-content').style.display = (term === 'first') ? 'block' : 'none';
        document.querySelector('.second-term-content').style.display = (term === 'second') ? 'block' : 'none';
    });
});
</script>

<script>
    const printButton = document.getElementById('printReportCard');
    if (printButton) {
        printButton.addEventListener('click', function () {
            window.print();
        });
    }
</script>

</body>    
</html>       