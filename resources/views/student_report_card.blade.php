<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MCA Montessori School - View My Grades</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css?v=1759179376">
    
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
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <h2 class="section-title" style="margin: 0;">Academic Performance <!--- 1st Term--></h2>
                    <button onclick="fetchLatestGrades()" style="background: #28a745; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; font-weight: 500; transition: all 0.3s;">
                        <i class="fas fa-sync-alt"></i> Refresh Grades
                    </button>
                </div>
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
                    @forelse($grades as $grade)
                    @php
                        $g1 = $grade->first_quarter;
                        $g2 = $grade->second_quarter;
                        $g3 = $grade->third_quarter;
                        $g4 = $grade->fourth_quarter;
                        $gf = $grade->final_grade ? number_format($grade->final_grade, 1) : 'N/A';
                    @endphp
                    <tr>
                        <td class="subject-name">{{ $grade->subjectModel->name ?? 'Unknown Subject' }}</td>

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
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: #666;">
                            <i class="fas fa-info-circle" style="font-size: 48px; color: #ccc; margin-bottom: 15px; display: block;"></i>
                            <strong style="font-size: 16px; display: block; margin-bottom: 10px;">No Grades Available Yet</strong>
                            <p style="font-size: 14px; margin: 0;">Your instructors haven't posted any grades yet. Please check back later or click the "Refresh Grades" button above.</p>
                        </td>
                    </tr>
                    @endforelse
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

<script>
    // Real-time grade fetching functionality
    const studentId = {{ $student->student_id ?? 'null' }};
    
    if (studentId) {
        // Function to fetch and update grades in real-time
        async function fetchLatestGrades() {
            console.log('fetchLatestGrades called, manual refresh:', window.manualRefresh);
            try {
                const response = await fetch(`{{ route('api.student.grades') }}?student_id=${studentId}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                });
                
                if (response.ok) {
                    const data = await response.json();
                    console.log('API Response:', data);
                    
                    if (data.success && data.grades) {
                        const hasGrades = data.grades.length > 0;
                        console.log('About to update grades table with', data.grades.length, 'grades');
                        updateGradesTable(data.grades);
                        console.log('Grades updated successfully at:', data.timestamp);
                        
                        // Show notification only on manual refresh (not on auto-refresh)
                        if (window.manualRefresh) {
                            showNotification(hasGrades ? 
                                `Successfully refreshed! Found ${data.grades.length} subject(s).` : 
                                'No grades available yet. Your instructors haven\'t posted any grades.', 
                                hasGrades ? 'success' : 'info'
                            );
                            window.manualRefresh = false;
                        }
                    } else {
                        console.warn('No grades data in response');
                        if (window.manualRefresh) {
                            showNotification('Unable to fetch grades. Please try again.', 'error');
                            window.manualRefresh = false;
                        }
                    }
                } else {
                    console.error('Response not OK:', response.status);
                    if (window.manualRefresh) {
                        showNotification('Failed to refresh grades. Please try again.', 'error');
                        window.manualRefresh = false;
                    }
                }
            } catch (error) {
                console.error('Error fetching grades:', error);
                if (window.manualRefresh) {
                    showNotification('Network error. Please check your connection.', 'error');
                    window.manualRefresh = false;
                }
            }
        }
        
        // Show notification function
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = 'grade-notification';
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${type === 'success' ? '#28a745' : type === 'info' ? '#17a2b8' : '#dc3545'};
                color: white;
                padding: 15px 20px;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
                z-index: 9999;
                animation: slideIn 0.3s ease;
                max-width: 350px;
            `;
            notification.innerHTML = `<i class="fas fa-${type === 'success' ? 'check-circle' : type === 'info' ? 'info-circle' : 'exclamation-circle'}"></i> ${message}`;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => notification.remove(), 300);
            }, 4000);
        }
        
        // Add manual refresh flag
        window.manualRefresh = false;
        
        // Update the refresh button to set the flag
        const refreshBtn = document.querySelector('[onclick="fetchLatestGrades()"]');
        if (refreshBtn) {
            refreshBtn.onclick = function() {
                window.manualRefresh = true;
                fetchLatestGrades();
            };
        }

        // Function to update the grades table with new data
        function updateGradesTable(grades) {
            console.log('updateGradesTable called with:', grades.length, 'grades');
            const tbody = document.querySelector('.grades-table tbody');
            if (!tbody) {
                console.log('No tbody found');
                return;
            }

            // If no grades, show empty message (but only if we don't already have grades displayed)
            if (grades.length === 0) {
                const existingRows = tbody.querySelectorAll('tr');
                const hasGradeRows = existingRows.length > 0 && existingRows[0].querySelector('.subject-name');
                
                // Only show "no grades" message if we don't already have grades
                if (!hasGradeRows) {
                    console.log('Showing no grades message');
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 40px; color: #666;">
                                <i class="fas fa-info-circle" style="font-size: 48px; color: #ccc; margin-bottom: 15px; display: block;"></i>
                                <strong style="font-size: 16px; display: block; margin-bottom: 10px;">No Grades Available Yet</strong>
                                <p style="font-size: 14px; margin: 0;">Your instructors haven't posted any grades yet. Please check back later or click the "Refresh Grades" button above.</p>
                            </td>
                        </tr>
                    `;
                } else {
                    console.log('Keeping existing grades, ignoring empty response');
                }
                return;
            }

            // Check if we have existing grade rows (not the "No Grades Available" message)
            const existingRows = tbody.querySelectorAll('tr');
            const hasGradeRows = existingRows.length > 0 && existingRows[0].querySelector('.subject-name');
            
            console.log('Existing rows:', existingRows.length);
            console.log('Has grade rows:', hasGradeRows);
            console.log('First row HTML:', existingRows[0]?.innerHTML);

            // Force recreation of rows to ensure fresh data
            console.log('Force recreating all rows to ensure fresh data');
            if (false && hasGradeRows) {
                console.log('Updating existing rows (disabled for debugging)');
                // Update existing rows
                const gradesMap = {};
                grades.forEach(grade => {
                    gradesMap[grade.subject_name] = grade;
                    console.log('API Grade subject:', grade.subject_name);
                });
                
                console.log('Grades map keys:', Object.keys(gradesMap));

                existingRows.forEach((row, index) => {
                    const subjectCell = row.querySelector('.subject-name');
                    if (subjectCell) {
                        const subjectName = subjectCell.textContent.trim();
                        const grade = gradesMap[subjectName];
                        
                        console.log(`Row ${index + 1}: "${subjectName}" -> Grade found:`, !!grade);
                        
                        if (grade) {
                            console.log(`Updating row ${index + 1} with grade:`, grade);
                            const cells = row.querySelectorAll('td');
                            
                            // Update quarter grades with animation
                            updateCell(cells[1], grade.first_quarter, gradeStatusClass(grade.first_quarter));
                            updateCell(cells[2], grade.second_quarter, gradeStatusClass(grade.second_quarter));
                            updateCell(cells[3], grade.third_quarter, gradeStatusClass(grade.third_quarter));
                            updateCell(cells[4], grade.fourth_quarter, gradeStatusClass(grade.fourth_quarter));
                            
                            // Update final grade
                            const finalCell = cells[5];
                            if (finalCell && grade.final_grade !== null) {
                                const displayValue = parseFloat(grade.final_grade).toFixed(1);
                                if (finalCell.textContent.trim() !== displayValue) {
                                    finalCell.classList.add('grade-updated');
                                    finalCell.textContent = displayValue;
                                    finalCell.className = 'final-grade ' + gradeStatusClass(grade.final_grade);
                                    
                                    setTimeout(() => {
                                        finalCell.classList.remove('grade-updated');
                                    }, 2000);
                                }
                            }
                        }
                    }
                });
            } else {
                console.log('Creating new rows from scratch');
                // Create new rows from scratch
                tbody.innerHTML = '';
                console.log('Cleared tbody, now creating', grades.length, 'rows');
                
                grades.forEach((grade, index) => {
                    console.log(`Creating row ${index + 1}:`, grade.subject_name, 'Final:', grade.final_grade);
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="subject-name">${grade.subject_name || 'Unknown Subject'}</td>
                        <td class="${gradeStatusClass(grade.first_quarter)}">${grade.first_quarter ?? 'N/A'}</td>
                        <td class="${gradeStatusClass(grade.second_quarter)}">${grade.second_quarter ?? 'N/A'}</td>
                        <td class="${gradeStatusClass(grade.third_quarter)}">${grade.third_quarter ?? 'N/A'}</td>
                        <td class="${gradeStatusClass(grade.fourth_quarter)}">${grade.fourth_quarter ?? 'N/A'}</td>
                        <td class="final-grade ${gradeStatusClass(grade.final_grade)}">${grade.final_grade ? parseFloat(grade.final_grade).toFixed(1) : 'N/A'}</td>
                    `;
                    tbody.appendChild(row);
                    console.log(`Row ${index + 1} added to tbody`);
                });
                
                console.log('All rows created. Final tbody children count:', tbody.children.length);
                
                // Add animation to new rows
                const newRows = tbody.querySelectorAll('tr');
                console.log('Found', newRows.length, 'new rows for animation');
                newRows.forEach((row, index) => {
                    row.style.opacity = '0';
                    row.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        row.style.transition = 'all 0.3s ease';
                        row.style.opacity = '1';
                        row.style.transform = 'translateY(0)';
                        console.log(`Row ${index + 1} animated`);
                    }, index * 100);
                });
            }
        }

        // Helper function to update individual cell
        function updateCell(cell, value, statusClass) {
            if (!cell) {
                console.log('updateCell: No cell provided');
                return;
            }
            
            const displayValue = value !== null && value !== undefined ? value : 'N/A';
            console.log('updateCell:', 'value:', value, 'displayValue:', displayValue, 'statusClass:', statusClass);
            
            if (cell.textContent.trim() !== displayValue.toString()) {
                console.log('Updating cell from', cell.textContent.trim(), 'to', displayValue);
                cell.classList.add('grade-updated');
                cell.textContent = displayValue;
                cell.className = statusClass;
                
                setTimeout(() => {
                    cell.classList.remove('grade-updated');
                }, 2000);
            }
        }

        // Helper function to determine grade status class
        function gradeStatusClass(value) {
            if (value === null || value === undefined) {
                return '';
            }
            value = parseFloat(value);
            if (value >= 90) {
                return 'excellent';
            } else if (value >= 85) {
                return 'very-good';
            } else if (value >= 80) {
                return 'good';
            } else if (value >= 75) {
                return 'fair';
            } else {
                return 'poor';
            }
        }

        // Fetch grades immediately on page load
        fetchLatestGrades();

        // Set up periodic fetching (every 30 seconds) - temporarily disabled for debugging
        // setInterval(fetchLatestGrades, 30000);
        console.log('Periodic refresh disabled for debugging');

        // Add visual feedback for grade updates
        const style = document.createElement('style');
        style.textContent = `
            .grade-updated {
                animation: gradeHighlight 2s ease;
            }
            
            @keyframes gradeHighlight {
                0% {
                    background-color: #fff3cd;
                    transform: scale(1);
                }
                50% {
                    background-color: #ffc107;
                    transform: scale(1.05);
                }
                100% {
                    background-color: transparent;
                    transform: scale(1);
                }
            }
            
            .new-grade-notification {
                position: fixed;
                top: 20px;
                right: 20px;
                background: #28a745;
                color: white;
                padding: 15px 20px;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
                z-index: 9999;
                animation: slideIn 0.3s ease;
            }
            
            @keyframes slideIn {
                from {
                    transform: translateX(400px);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            
            @keyframes slideOut {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(400px);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    }
</script>

</body>    
</html>       