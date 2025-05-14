<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCA Montessori School - My Subjects</title>
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

/* Page Header */
.page-header {
    padding: 20px;
    margin-bottom: 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.page-header h2 {
    font-size: 24px;
    color: var(--navy-blue);
    margin: 0;
}

.page-subheader {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.page-subheader p {
    color: var(--text-muted);
    font-size: 14px;
}

.view-controls {
    display: flex;
    gap: 15px;
    align-items: center;
}

.view-controls .control-btn {
    background-color: white;
    border: 1px solid #ddd;
    color: var(--text-muted);
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: var(--transition);
}

.view-controls .control-btn:hover {
    border-color: var(--accent-color);
    color: var(--accent-color);
}

.view-controls .control-btn.active {
    background-color: var(--accent-color);
    border-color: var(--accent-color);
    color: var(--text-light);
}

.search-filter {
    display: flex;
    gap: 15px;
    align-items: center;
}

.search-filter input {
    padding: 10px 15px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 14px;
    width: 250px;
    transition: var(--transition);
}

.search-filter input:focus {
    border-color: var(--accent-color);
    outline: none;
    box-shadow: 0 0 0 2px rgba(155, 34, 66, 0.1);
}

.filter-dropdown {
    position: relative;
}

.filter-btn {
    background-color: white;
    border: 1px solid #ddd;
    padding: 10px 15px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    font-size: 14px;
    transition: var(--transition);
}

.filter-btn:hover {
    border-color: var(--accent-color);
}

.filter-btn i {
    font-size: 12px;
}

.filter-menu {
    display: none;
    position: absolute;
    top: 100%;
    right: 0;
    background-color: white;
    border-radius: 8px;
    box-shadow: var(--shadow);
    width: 200px;
    margin-top: 5px;
    z-index: 10;
}

.filter-menu a {
    display: block;
    padding: 12px 15px;
    text-decoration: none;
    color: var(--text-dark);
    font-size: 14px;
    transition: var(--transition);
}

.filter-menu a:hover {
    background-color: #f8f8f8;
    color: var(--accent-color);
}

.filter-dropdown:hover .filter-menu {
    display: block;
}

/* Subjects Grid View */
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

.subject-metadata {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.subject-teacher {
    display: flex;
    align-items: center;
    gap: 8px;
}

.teacher-pic {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    object-fit: cover;
}

.teacher-name {
    font-size: 12px;
    color: var(--text-dark);
}

.subject-units {
    font-size: 12px;
    color: var(--text-muted);
    background-color: #f8f8f8;
    padding: 4px 8px;
    border-radius: 20px;
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

/* Subjects List View */
.subjects-list {
    display: none;
    flex-direction: column;
    gap: 15px;
}

.subject-list-item {
    background-color: white;
    border-radius: var(--border-radius);
    padding: 15px 20px;
    display: flex;
    align-items: center;
    gap: 20px;
    box-shadow: var(--shadow);
    transition: var(--transition);
}

.subject-list-item:hover {
    transform: translateX(5px);
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
}

.subject-list-image {
    width: 80px;
    height: 80px;
    border-radius: 8px;
    object-fit: cover;
}

.subject-list-content {
    flex: 1;
}

.subject-list-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 5px;
}

.subject-list-title {
    font-size: 18px;
    color: var(--navy-blue);
    margin: 0;
}

.subject-list-meta {
    display: flex;
    flex-direction: column;
    margin-bottom: 10px;
}

.subject-list-schedule {
    color: var(--text-muted);
    font-size: 12px;
}
.instructor {
    font-size: 12px;
    color: var(--text-muted);
}

.subject-list-teacher {
    display: flex;
    align-items: center;
    gap: 8px;
}

.subject-list-progress {
    display: flex;
    align-items: center;
    gap: 10px;
}

.subject-list-progress .progress-bar {
    flex: 1;
    max-width: 200px;
}

.subject-list-actions {
    display: flex;
    gap: 10px;
}

.subject-action-btn {
    background-color: transparent;
    border: 1px solid #ddd;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 14px;
    color: var(--text-muted);
    transition: var(--transition);
}

.subject-action-btn:hover {
    background-color: var(--accent-color);
    border-color: var(--accent-color);
    color: white;
}

/* Show/Hide Based on Active View */
.grid-view .subjects-grid {
    display: grid;
}

.grid-view .subjects-list {
    display: none;
}

.list-view .subjects-grid {
    display: none;
}

.list-view .subjects-list {
    display: flex;
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
    
    .search-filter input {
        width: 180px;
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
    
    .sidebar-nav a span {
        display: inline;
    }
    
    .main-content {
        margin-left: 0;
        margin-top: 10px;
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
    
    .page-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    
    .search-filter {
        width: 100%;
        flex-direction: column;
        align-items: stretch;
    }
    
    .search-filter input {
        width: 100%;
    }
    
    .filter-dropdown {
        width: 100%;
    }
    
    .filter-btn {
        width: 100%;
        justify-content: space-between;
    }
    
    .subject-list-item {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .subject-list-image {
        width: 100%;
        height: 120px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 10px;
    }
    
    .subject-list-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
    }
    
    .subject-list-meta {
        flex-direction: column;
        gap: 5px;
    }
    
    .subject-list-actions {
        width: 100%;
        justify-content: flex-end;
        margin-top: 10px;
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
    
    .page-header h2 {
        font-size: 20px;
    }
    
    .view-controls {
        gap: 8px;
    }
    
    .view-controls .control-btn {
        width: 35px;
        height: 35px;
    }
}

/* Notification Menu */
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

/* Pagination */
.pagination {
    display: flex;
    justify-content: center;
    margin-top: 30px;
    gap: 5px;
}

.pagination a {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 8px;
    background-color: white;
    border: 1px solid #ddd;
    text-decoration: none;
    color: var(--text-dark);
    font-size: 14px;
    transition: var(--transition);
}

.pagination a:hover {
    border-color: var(--accent-color);
    color: var(--accent-color);
}

.pagination a.active {
    background-color: var(--accent-color);
    border-color: var(--accent-color);
    color: white;
}

.pagination a.disabled {
    color: #ccc;
    cursor: not-allowed;
}

.pagination a.disabled:hover {
    border-color: #ddd;
    color: #ccc;
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
                    <li class="active"><a href="#"><i class="fas fa-book"></i><span>SUBJECTS</span></a></li>
                    <li><a href="{{ route('student.documents') }}"><i class="fas fa-file-alt"></i><span>MY DOCUMENTS</span></a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <header class="top-bar">
                <div class="welcome-text">
                    <h1>My Subjects</h1>
                </div>
                <div class="user-menu">
                    <div class="notifications">
                        <img src="{{asset ('images/bell_student.png')}}" alt="Notifications" class="icon">
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
                            <div class="mini-profile-footer">
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <section class="page-header">
                <div class="view-controls">
                    <button class="control-btn active" id="gridView"><i class="fas fa-th"></i></button>
                    <button class="control-btn" id="listView"><i class="fas fa-bars"></i></button>
                </div>
            </section>

            <div class="subjects-container grid-view">
                {{-- GRID MODE --}}
                <div class="subjects-grid">
                    @foreach($classes as $class)
                        @php
                            $fileNum     = ($loop->index % 4) + 1;
                            $scheduleText = $class->schedules
                                ->map(fn($s) => "{$s->day_of_week} • "
                                . date('g:i A', strtotime($s->start_time))
                                . " - "
                                . date('g:i A', strtotime($s->end_time))
                                )
                                ->implode(' | ');
                            // Prepare instructor list
                            $instructors = $class->instructors
                                ->map(fn($i) => "{$i->first_name} {$i->last_name}")
                                ->implode(', ');
                        @endphp

                        <div class="subject-card">
                            <img
                            src="{{ asset('images/study' . $fileNum . '.jpg') }}"
                            alt="{{ $class->subject->name }}"
                            class="subject-image"
                            >
                            <div class="subject-info">
                            <h3>{{ $class->subject->name }}</h3>
                            @if($instructors)
                                <p class="instructor">Instructor: {{ $instructors }}</p>
                            @endif
                            <p>{{ $scheduleText }}</p>
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

                {{-- LIST MODE --}}
                <div class="subjects-list">
                    @foreach($classes as $class)
                        @php
                            $fileNum     = ($loop->index % 4) + 1;
                            $scheduleText = $class->schedules
                                ->map(fn($s) => "{$s->day_of_week} • "
                                . date('g:i A', strtotime($s->start_time))
                                . " - "
                                . date('g:i A', strtotime($s->end_time))
                                )
                                ->implode(' | ');
                            $instructors = $class->instructors
                                ->map(fn($i) => "{$i->first_name} {$i->last_name}")
                                ->implode(', ');
                        @endphp
                        <div class="subject-list-item">
                            <img
                            src="{{ asset('images/study' . $fileNum . '.jpg') }}"
                            alt="{{ $class->subject->name }}"
                            class="subject-list-image"
                            >
                            <div class="subject-list-content">
                            <div class="subject-list-header">
                                <h3 class="subject-list-title">{{ $class->subject->name }}</h3>
                            </div>
                            <div class="subject-list-meta">
                                @if($instructors)
                                    <p class="instructor">Instructor: {{ $instructors }}</p>
                                @endif
                                <span class="subject-list-schedule">{{ $scheduleText }}</span>
                            </div>
                            <div class="subject-list-progress">
                                <div class="progress-bar">
                                <div class="progress" style="width: 90.8%"></div>
                                </div>
                                <span>90.8%</span>
                            </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

<script>
    const gridView = document.getElementById('gridView');
    const listView = document.getElementById('listView');
    const container = document.querySelector('.subjects-container');

    gridView.addEventListener('click', () => {
        container.classList.add('grid-view');
        container.classList.remove('list-view');
        gridView.classList.add('active');
        listView.classList.remove('active');
    });

    listView.addEventListener('click', () => {
        container.classList.add('list-view');
        container.classList.remove('grid-view');
        listView.classList.add('active');
        gridView.classList.remove('active');
    });
</script>
</body>
</html>