<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if($student)
        <meta name="student-id" content="{{ $student->student_id }}">
    @endif
    <title>MCA Montessori School - Student Dashboard</title>
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
    margin-top: 2px;
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

.banner {
    background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('{{ asset('images/school2.jpg') }}');
    background-size: cover;
    background-position: center;
    border-radius: var(--border-radius);
    position: relative;
    height: 250px;
    box-shadow: var(--shadow);
    overflow: hidden;
    margin-bottom: 30px;
}

.banner-content {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 40px;
    color: var(--text-light);
    z-index: 2;
    text-align: center;
}

.banner-content h2 {
    font-size: 28px;
    margin-bottom: 15px;
}

.banner-content p {
    margin-bottom: 25px;
    font-size: 16px;
    max-width: 80%;
    line-height: 1.7;
    margin-left: auto;
    margin-right: auto;
}

.cta-button {
    display: inline-block;
    padding: 12px 24px;
    background-color: var(--text-light);
    color: var(--accent-color);
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    transition: var(--transition);
}

.cta-button:hover {
    background-color: rgba(255, 255, 255, 0.9);
    transform: translateY(-2px);
}

/* Section Header Styles */
.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.section-header h2 {
    font-size: 20px;
    font-weight: 600;
    color: var(--sidebar-color);
}

.see-all {
    color: var(--accent-color);
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
}

/* Subjects Grid Styles */
.subjects-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.subject-card {
    background-color: white;
    border-radius: var(--border-radius);
    overflow: hidden;
    box-shadow: var(--shadow);
    transition: var(--transition);
}

.subject-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
}

.subject-image {
    width: 100%;
    height: 150px;
    object-fit: cover;
}

.subject-info {
    padding: 20px;
}

.subject-info h3 {
    margin-bottom: 5px;
    font-size: 18px;
    color: var(--navy-blue);
}

.subject-info p {
    color: var(--text-muted);
    font-size: 12px;
    margin-bottom: 15px;
}

.subject-progress {
    display: flex;
    align-items: center;
    gap: 10px;
}

.progress-bar {
    flex: 1;
    height: 8px;
    background-color: #e9ecef;
    border-radius: 4px;
    overflow: hidden;
}

.progress {
    height: 100%;
    background-color: var(--accent-color);
}

.subject-progress span {
    font-size: 12px;
    font-weight: 600;
    color: var(--accent-color);
}

/* Announcements Section */
.announcements-slider {
    display: flex;
    overflow-x: auto;
    gap: 20px;
    padding: 5px 0;
    margin-bottom: 15px;
    scrollbar-width: none; /* For Firefox */
}

.announcements-slider::-webkit-scrollbar {
    display: none; /* For Chrome, Safari, and Opera */
}

.announcement-card {
    background-color: white;
    border-radius: var(--border-radius);
    padding: 20px;
    box-shadow: var(--shadow);
    min-width: 300px;
    max-width: 350px;
    display: flex;
    gap: 15px;
}

.announcement-icon {
    width: 40px;
    height: 40px;
    background-color: rgba(155, 34, 66, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--accent-color);
}

.announcement-content h3 {
    font-size: 16px;
    margin-bottom: 5px;
    color: var(--navy-blue);
}

.announcement-content p {
    font-size: 13px;
    color: var(--text-dark);
    margin-bottom: 10px;
}

.announcement-date {
    font-size: 12px;
    color: var(--text-muted);
}

.slider-controls {
    display: flex;
    justify-content: center;
    gap: 8px;
}

.slider-dot {
    width: 10px;
    height: 10px;
    background-color: #ddd;
    border-radius: 50%;
    cursor: pointer;
    transition: var(--transition);
}

.slider-dot.active {
    background-color: var(--accent-color);
    width: 20px;
    border-radius: 5px;
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
    
    .banner-content p {
        max-width: 100%;
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
    
    .subjects-grid {
        grid-template-columns: 1fr;
    }
    
    .banner {
        height: auto;
    }
    
    .banner-content {
        padding: 20px;
    }
    
    .banner-content h2 {
        font-size: 24px;
    }
    
    .banner-content p {
        font-size: 14px;
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
    
    .announcements-slider {
        flex-direction: column;
    }
    
    .announcement-card {
        min-width: 100%;
        max-width: 100%;
        margin-bottom: 15px;
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
    
    .banner-content h2 {
        font-size: 20px;
    }
    
    .banner-content p {
        font-size: 12px;
    }
    
    .cta-button {
        padding: 8px 16px;
        font-size: 14px;
    }
    
    .section-header h2 {
        font-size: 18px;
    }
}
        .modals {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modals-content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }

        .confirm-btn, .cancel-btn {
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            margin: 10px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .confirm-btn {
            background: red;
            color: white;
        }

        .cancel-btn {
            background: gray;
            color: white;
        }

        /* Assessment History Section Styles */
        .assessment-section {
            margin-bottom: 30px;
        }

        .assessment-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: 2px solid #7a222b;
        }

        .assessment-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .assessment-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #7a222b, #551a25);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }

        .assessment-icon i {
            color: white;
            font-size: 20px;
        }

        .assessment-info {
            flex: 1;
        }

        .assessment-info h3 {
            margin: 0 0 5px 0;
            color: #2b0f12;
            font-size: 18px;
            font-weight: 600;
        }

        .assessment-date {
            color: #666;
            font-size: 14px;
            margin: 0;
        }

        .assessment-status {
            margin-left: 15px;
        }

        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            color: white;
        }

        .status-badge.stem { background: #28a745; }
        .status-badge.abm { background: #007bff; }
        .status-badge.gas { background: #6f42c1; }
        .status-badge.humss { background: #fd7e14; }
        .status-badge.ict { background: #20c997; }
        .status-badge.he { background: #e83e8c; }

        .assessment-details {
            margin-bottom: 20px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #f8f9fa;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 600;
            color: #2b0f12;
            font-size: 14px;
        }

        .detail-value {
            font-size: 14px;
            color: #495057;
        }

        .detail-value.recommended {
            color: #7a222b;
            font-weight: 600;
        }

        .detail-value.score {
            color: #28a745;
            font-weight: 600;
        }

        .detail-value.current {
            font-weight: 600;
        }

        .match-indicator {
            background: #28a745;
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 12px;
            margin-left: 8px;
        }

        .override-indicator {
            background: #ffc107;
            color: #212529;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 12px;
            margin-left: 8px;
        }

        .assessment-scores {
            margin-top: 20px;
        }

        .scores-breakdown summary {
            background: #f8f9fa;
            padding: 12px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            color: #7a222b;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .scores-breakdown summary:hover {
            background: #e9ecef;
            border-color: #7a222b;
        }

        .scores-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 12px;
            margin-top: 15px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .score-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 12px;
            background: white;
            border-radius: 6px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .score-item:hover {
            border-color: #7a222b;
            box-shadow: 0 2px 8px rgba(122, 34, 43, 0.1);
        }

        .score-item.stem { border-left: 4px solid #28a745; }
        .score-item.abm { border-left: 4px solid #007bff; }
        .score-item.gas { border-left: 4px solid #6f42c1; }
        .score-item.humss { border-left: 4px solid #fd7e14; }
        .score-item.ict { border-left: 4px solid #20c997; }
        .score-item.he { border-left: 4px solid #e83e8c; }

        .strand-name {
            font-weight: 600;
            color: #2b0f12;
            font-size: 13px;
        }

        .strand-percentage {
            font-weight: 700;
            color: #7a222b;
            font-size: 14px;
        }

        /* Responsive Design for Assessment Section */
        @media (max-width: 768px) {
            .assessment-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .assessment-status {
                margin-left: 0;
                align-self: flex-end;
            }

            .detail-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }

            .scores-grid {
                grid-template-columns: 1fr;
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
                    <li class="active"><a href="#"><i class="fas fa-th-large"></i><span>DASHBOARD</span></a></li>
                    <li><a href="{{ route('student.grades') }}"><i class="fas fa-chart-bar"></i><span>VIEW MY GRADES</span></a></li>
                    <li><a href="{{ route('student.subjects') }}"><i class="fas fa-book"></i><span>SUBJECTS</span></a></li>
                    <li><a href="{{ route('student.documents') }}"><i class="fas fa-file-alt"></i><span>MY DOCUMENTS</span></a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <header class="top-bar">
                <div class="welcome-text">
                    <h1>Welcome, {{ optional($student)->short_name ?? (Auth::user()->name ?? 'Student') }}!</h1>
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
                        <img src="{{asset ('images/settings_student.png')}}" alt="Settings" class="icon">
                        <div class="dropdown-content">
                            <a href="#" id="profileSettingsBtn"><i class="fas fa-user-cog"></i> Profile Settings</a>
                            <div class="logout-container">
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                                <a href="#" class="logout-btn" onclick="confirmExit()"><i class="fas fa-sign-out-alt"></i> Logout</a>
                            </div>
                            
                        </div>
                    </div>

                    <div class="user-profile">
                        <!-- Profile Picture -->
                        <img 
                        src="{{ asset(optional($student)->picture ? 'storage/'.optional($student)->picture : 'images/student_user.png') }}"
                        alt="{{ optional($student)->short_name ?? (Auth::user()->name ?? 'Student') }}"
                        class="profile-pic"
                        >

                        <!-- Basic Info -->
                        <div class="user-info">
                            <h3>{{ optional($student)->short_name ?? (Auth::user()->name ?? 'Student') }}</h3>
                            <p>{{ optional(optional($student)->gradeLevel)->name ?? '—' }}</p>
                        </div>

                        <!-- Expanded Mini Profile -->
                        <div class="mini-profile">
                            <div class="mini-profile-header">
                            <img
                                src="{{ asset(optional($student)->picture ? 'storage/'.optional($student)->picture : 'images/student_user.png') }}"
                                alt="{{ optional($student)->short_name ?? (Auth::user()->name ?? 'Student') }}"
                                class="mini-profile-pic"
                            >
                            <h3 class="mini-profile-name">{{ optional($student)->short_name ?? (Auth::user()->name ?? 'Student') }}</h3>
                            <p>
                                Student ID: 
                                {{ optional(optional($student)->studentID)->student_number ?? '—' }}
                            </p>
                            </div>

                            <div class="mini-profile-details">
                            <div class="detail-row">
                                <div class="detail-label">Grade Level:</div>
                                <div class="detail-value"> {{ optional(optional($student)->gradeLevel)->name ?? '—' }}</div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">Section:</div>
                                <div class="detail-value">{{ optional(optional($student)->section)->section_name ?? '—' }}</div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">Email:</div>
                                <div class="detail-value">{{ optional($student)->email ?? '—' }}</div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
            </header>

            <section class="banner">
                <div class="banner-content">
                    <h2>Join Us for an Exciting Day of Fun and Sports!</h2>
                    <p>To celebrate our Foundation Day, we invite all students, parents, and faculty to a special event filled with games, sports, and community spirit!</p>
                    <a href="https://mcams.edu.ph/?page_id=2545" class="cta-button" target="_blank" rel="noopener noreferrer">More Information →</a>
                </div>
            </section>

            <section class="content-section">
            <div class="section-header">
                <h2>MY SUBJECTS</h2>
                <a href="{{ route('student.subjects') }}" class="see-all">SEE ALL</a>
            </div>

            <div class="subjects-grid">
                @foreach($classes as $class)
                @php
                    // pick an image based on loop index
                    $imgCount = 4;
                    $fileNum  = ($loop->index % $imgCount) + 1;

                    // format schedule text
                    $scheduleText = $class->schedules
                    ->map(fn($s) =>
                        "{$s->day_of_week} • " .
                        date('g:i A', strtotime($s->start_time)) .
                        " - " .
                        date('g:i A', strtotime($s->end_time))
                    )
                    ->implode(' | ');
                @endphp

                <div class="subject-card">
                    <img
                    src="{{ asset('images/study' . $fileNum . '.jpg') }}"
                    alt="{{ $class->subject->name ?? 'Unknown Subject' }}"
                    class="subject-image"
                    >

                    <div class="subject-info">
                    <h3>{{ $class->subject->name ?? 'Unknown Subject' }}</h3>

                    {{-- Instructors --}}
                    @if($class->instructors->isNotEmpty())
                        <p class="instructor">
                        <strong>Instructor{{ $class->instructors->count() > 1 ? 's' : '' }}:</strong>
                        {{ $class->instructors
                            ->map(fn($i) => $i->short_name)
                            ->implode(', ')
                        }}
                        </p>
                    @else
                        <p class="instructor"><em>No instructor assigned yet</em></p>
                    @endif

                    {{-- Schedule --}}
                    <p>{{ $scheduleText }}</p>

                    {{-- Progress (hardcoded for now) --}}
                    <div class="subject-progress">
                        <div class="progress-bar">
                        <div class="progress" style="width: 90.8%"></div>
                        </div>
                        <span>90.8%</span>
                    </div>
                    </div>
                </div>
                @endforeach
            </div>
            </section>

            {{-- Assessment History Section --}}
            @if($assessmentResult)
            <section class="assessment-section">
                <div class="section-header">
                    <h2>STRAND ASSESSMENT HISTORY</h2>
                </div>
                
                <div class="assessment-card">
                    <div class="assessment-header">
                        <div class="assessment-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="assessment-info">
                            <h3>Assessment Results</h3>
                            <p class="assessment-date">
                                Completed: {{ $assessmentResult->completed_at->format('F d, Y') }}
                            </p>
                        </div>
                        <div class="assessment-status">
                            <span class="status-badge {{ strtolower($assessmentResult->recommended_strand) }}">
                                {{ $assessmentResult->recommended_strand }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="assessment-details">
                        <div class="detail-row">
                            <span class="detail-label">Recommended Strand:</span>
                            <span class="detail-value recommended">{{ $assessmentResult->recommended_strand }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Assessment Score:</span>
                            <span class="detail-value score">
                                {{ $assessmentResult->scores[$assessmentResult->recommended_strand] }}/25 
                                ({{ number_format($assessmentResult->getScorePercentage(), 1) }}%)
                            </span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Academic Year:</span>
                            <span class="detail-value">{{ $assessmentResult->academicYear?->year_name ?? 'Unknown' }}</span>
                        </div>
                        @if($student && $student->strand)
                        <div class="detail-row">
                            <span class="detail-label">Your Current Strand:</span>
                            <span class="detail-value current {{ strtolower($student->strand->strand_name) }}">
                                {{ $student->strand->strand_name }}
                                @if($student->strand->strand_name === $assessmentResult->recommended_strand)
                                    <span class="match-indicator">✓ Followed Recommendation</span>
                                @else
                                    <span class="override-indicator">⚠ Different Choice</span>
                                @endif
                            </span>
                        </div>
                        @endif
                    </div>
                    
                    <div class="assessment-scores">
                        <details class="scores-breakdown">
                            <summary>View All Strand Scores</summary>
                            <div class="scores-grid">
                                @foreach($assessmentResult->getAllScorePercentages() as $strandName => $percentage)
                                <div class="score-item {{ strtolower($strandName) }}">
                                    <span class="strand-name">{{ $strandName }}</span>
                                    <span class="strand-percentage">{{ number_format($percentage, 1) }}%</span>
                                </div>
                                @endforeach
                            </div>
                        </details>
                    </div>
                </div>
            </section>
            @endif

            <section class="announcements-section">
                <div class="section-header">
                    <h2>SCHOOL ANNOUNCEMENTS</h2>
                    <!--<a href="#" class="see-all">SEE ALL</a>-->
                </div>

                {{-- Slider --}}
                <div class="announcements-slider">
                    @forelse ($announcements as $announcement)
                    <div class="announcement-card">
                        <div class="announcement-icon">
                        <i class="fas fa-bullhorn"></i>
                        </div>
                        <div class="announcement-content">
                        <h3>{{ $announcement->title }}</h3>
                        <p>{{ $announcement->message }}</p>
                        <span class="announcement-date">
                            {{ \Carbon\Carbon::parse($announcement->created_at)->format('F d, Y') }}
                        </span>
                        </div>
                    </div>
                    @empty
                    <div class="announcement-card">
                        <div class="announcement-content">
                        <h3>No Announcements</h3>
                        <p>There are currently no announcements for your section.</p>
                        </div>
                    </div>
                    @endforelse
                </div>

                {{-- Slider dots --}}
                <div class="slider-controls">
                    @forelse ($announcements as $announcement)
                    <span class="slider-dot{{ $loop->first ? ' active' : '' }}"></span>
                    @empty
                    <span class="slider-dot active"></span>
                    @endforelse
                </div>
            </section>

            <div id="confirm-modals" class="modals">
                <div class="modals-content">
                    <p>Are you sure you want to log out?</p>
                    <button class="confirm-btn" onclick="logouts(event)">Yes, Logout</button>
                    <button class="cancel-btn" onclick="closeModals()">No</button>
                </div>
            </div>
        </main>
    </div>

    
    <!-- Profile Settings Modal -->
    <div id="profileSettingsModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Profile Settings</h2>
                <span class="close-modal">&times;</span>
            </div>
            <div class="modal-body">
                <div class="settings-section">
                    <h3>Profile Picture</h3>
                    <div class="profile-picture-settings">
                        <div class="current-picture">
                            <img src="{{asset ('images/student_user.png')}}" alt="Current Profile Picture" id="currentProfilePic">
                        </div>
                        <div class="picture-options">
                            <button class="upload-btn" id="uploadPhotoBtn">
                                <i class="fas fa-upload"></i> Upload New Photo
                            </button>
                            <input type="file" id="photoUpload" accept="image/*" style="display: none;">
                            <p class="photo-tip">Recommended: Square image, at least 200x200 pixels</p>
                            <div class="preset-photos">
                                <h4>Choose from preset avatars:</h4>
                                <div class="avatar-options">
                                    <img src="{{asset ('images/avatar1.jpg')}}" class="preset-avatar" alt="Avatar Option 1">
                                    <img src="{{asset ('images/avatar2.jpg')}}" class="preset-avatar" alt="Avatar Option 2">
                                    <img src="{{asset ('images/avatar3.jpg')}}" class="preset-avatar" alt="Avatar Option 3">
                                    <img src="{{asset ('images/avatar4.jpg')}}" class="preset-avatar" alt="Avatar Option 4">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="settings-section">
                    <h3>Personal Information</h3>
                    <form id="personalInfoForm">
                        <div class="form-group">
                            <label for="displayName">Display Name</label>
                            <input type="text" id="displayName" value="{{ optional($student)->short_name ?? (Auth::user()->name ?? '') }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="emailAddress">Email Address</label>
                            <input type="email" id="emailAddress" value="{{ optional($student)->email ?? (Auth::user()->email ?? '') }}" disabled>
                            <p class="field-note">Email cannot be changed. Contact administration for updates.</p>
                        </div>
                        <div class="form-group">
                            <label for="bio">Bio / About Me</label>
                            <textarea id="bio" rows="3" placeholder="Write a short bio..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="settings-section">
                    <h3>Password</h3>
                    <form id="passwordForm">
                        <div class="form-group">
                            <label for="currentPassword">Current Password</label>
                            <input type="password" id="currentPassword">
                        </div>
                        <div class="form-group">
                            <label for="newPassword">New Password</label>
                            <input type="password" id="newPassword">
                        </div>
                        <div class="form-group">
                            <label for="confirmPassword">Confirm New Password</label>
                            <input type="password" id="confirmPassword">
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button class="cancel-btn">Cancel</button>
                <button class="save-btn">Save Changes</button>
            </div>
        </div>
    </div>

    <style>
        

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

        /* Settings Sections */
        .settings-section {
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eaeaea;
        }

        .settings-section h3 {
            font-size: 18px;
            color: var(--navy-blue);
            margin-bottom: 15px;
        }

        /* Profile Picture Settings */
        .profile-picture-settings {
            display: flex;
            gap: 20px;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .current-picture {
            flex: 0 0 120px;
        }

        .current-picture img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--accent-color);
        }

        .picture-options {
            flex: 1;
        }

        .upload-btn {
            background-color: var(--accent-color);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .upload-btn:hover {
            background-color: var(--highlight-color);
        }

        .photo-tip {
            font-size: 12px;
            color: var(--text-muted);
            margin: 10px 0;
        }

        .preset-photos {
            margin-top: 15px;
        }

        .preset-photos h4 {
            font-size: 14px;
            margin-bottom: 10px;
            color: var(--text-dark);
        }

        .avatar-options {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .preset-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            cursor: pointer;
            border: 2px solid transparent;
            transition: var(--transition);
        }

        .preset-avatar:hover {
            border-color: var(--accent-color);
            transform: scale(1.05);
        }

        /* Form Styles */
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

        .form-group input, 
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            font-family: inherit;
            transition: var(--transition);
        }

        .form-group input:focus, 
        .form-group textarea:focus {
            border-color: var(--accent-color);
            outline: none;
            box-shadow: 0 0 0 2px rgba(155, 34, 66, 0.1);
        }

        .field-note {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 5px;
        }

        /* Button Styles */
        .cancel-btn, .save-btn {
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: var(--transition);
            border: none;
            font-weight: 500;
        }

        .cancel-btn {
            background-color: #f1f1f1;
            color: var(--text-dark);
        }

        .cancel-btn:hover {
            background-color: #e1e1e1;
        }

        .save-btn {
            background-color: var(--accent-color);
            color: white;
        }

        .save-btn:hover {
            background-color: var(--highlight-color);
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
    </style>

    <script>
        // Profile settings modal functionality - only initialize if modal exists
        const profileSettingsModal = document.getElementById("profileSettingsModal");
        
        if (profileSettingsModal) {
            const profileSettingsBtn = document.getElementById("profileSettingsBtn");
            const closeModal = document.querySelector(".close-modal");
            const cancelBtn = document.querySelector(".cancel-btn");
            const saveBtn = document.querySelector(".save-btn");
            const uploadBtn = document.getElementById("uploadPhotoBtn");
            const photoUpload = document.getElementById("photoUpload");
            const currentProfilePic = document.getElementById("currentProfilePic");
            const presetAvatars = document.querySelectorAll(".preset-avatar");
            const viewProfileBtn = document.getElementById("viewProfileBtn");

            
            // Check if elements exist before adding event listeners
            if (profileSettingsBtn) {
                profileSettingsBtn.addEventListener("click", function(e) {
                    e.preventDefault();
                    profileSettingsModal.style.display = "block";
                    document.body.style.overflow = "hidden"; // Prevent scrolling behind modal
                });
            }
        
            
            function closeProfileModal() {
                if (profileSettingsModal) {
                    profileSettingsModal.style.display = "none";
                    document.body.style.overflow = "auto"; // Re-enable scrolling
                }
            }

            if (closeModal) {
                closeModal.addEventListener("click", closeProfileModal);
            }
            if (cancelBtn) {
                cancelBtn.addEventListener("click", closeProfileModal);
            }

            
            window.addEventListener("click", function(e) {
                if (e.target === profileSettingsModal) {
                    closeProfileModal();
                }
            });

           
            if (uploadBtn && photoUpload) {
                uploadBtn.addEventListener("click", function() {
                    photoUpload.click();
                });

                photoUpload.addEventListener("change", function() {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        
                        reader.onload = function(e) {
                            if (currentProfilePic) {
                                currentProfilePic.src = e.target.result;
                            }
                            
                            const profilePic = document.querySelector(".profile-pic");
                            const miniProfilePic = document.querySelector(".mini-profile-pic");
                            if (profilePic) profilePic.src = e.target.result;
                            if (miniProfilePic) miniProfilePic.src = e.target.result;
                        }
                        
                        reader.readAsDataURL(this.files[0]);
                    }
                });
            }

            
            if (presetAvatars) {
                presetAvatars.forEach(avatar => {
                    avatar.addEventListener("click", function() {
                        const avatarSrc = this.src;
                        if (currentProfilePic) {
                            currentProfilePic.src = avatarSrc;
                        }
                        
                        const profilePic = document.querySelector(".profile-pic");
                        const miniProfilePic = document.querySelector(".mini-profile-pic");
                        if (profilePic) profilePic.src = avatarSrc;
                        if (miniProfilePic) miniProfilePic.src = avatarSrc;
                    });
                });
            }

           
            if (saveBtn) {
                saveBtn.addEventListener("click", function() {
                    alert("Profile settings saved successfully!");
                    closeProfileModal();
                });
            }

            
            if (viewProfileBtn) {
                viewProfileBtn.addEventListener("click", function(e) {
                    e.preventDefault();
                    alert("Navigate to full profile page");
                });
            }
        } // End of profileSettingsModal check
        function confirmExit() {
            document.getElementById("confirm-modals").style.display = "flex";
        }
        function closeModals(){
            document.getElementById('confirm-modals').style.display = "none";
        }
        function logouts(e){
            e.preventDefault();  
            document.getElementById('logout-form').submit();
        }
        
    </script>

    {{-- <script src="{{ asset('js/db.js') }}"></script> --}}
</body>
</html>