<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCA Montessori School - Progress Report</title>
    <link rel="stylesheet" href="{{ asset('css/styles_student_report_card.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.cdnfonts.com/css/garet" rel="stylesheet">
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <div class="logo-container">
                <img src="{{ asset('images/schoollogo.png') }}" alt="MCA Montessori School Logo" class="logo">
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="{{ route('student.dashboard') }}"><i class="fas fa-th-large"></i> DASHBOARD</a></li>
                    <li class="active"><a href="#"><i class="fas fa-chart-bar"></i> VIEW MY GRADES</a></li>
                    <li><a href="{{ route('student.subjects') }}"><i class="fas fa-book"></i> SUBJECTS</a></li>
                    <!--<li><a href="#"><i class="fas fa-file-alt"></i> MY DOCUMENTS</a></li>
                    <li><a href="#"><i class="fas fa-calendar-alt"></i> CALENDAR</a></li>
                    <li><a href="#"><i class="fas fa-tasks"></i> ASSIGNMENTS</a></li>
                    <li><a href="#"><i class="fas fa-comment-alt"></i> MESSAGES</a></li>-->
                </ul>
            </nav>
            <div class="logout-container">
                <a href="#" class="logout-btn"><i class="fas fa-sign-out-alt"></i> LOGOUT</a>
            </div>
        </aside>

        <main class="main-content">
            <header class="top-bar">
                <div class="welcome-text">
                    <h1>Progress Report Card</h1>
                </div>
                <div class="user-menu">
                    <div class="notifications">
                        <img src="{{ asset('images/bell_student.png') }}" alt="Notifications" class="icon">
                        <span class="notification-badge">3</span>
                    </div>
                    <div class="settings">
                        <img src="{{asset('images/settings_student.png')}}" alt="Settings" class="icon">
                    </div>
                    <div class="user-profile">
                        <img src="" alt="Krystal Mendez" class="profile-pic">
                        <div class="user-info">
                            <h3>{{ Auth::user()->name }}</h3>
                            <p>Grade 7</p>
                        </div>
                    </div>
                </div>
            </header>

            <section class="welcome-banner">
                <div class="banner-content">
                    <h2>Welcome back, {{ Auth::user()->name }}!</h2>
                    <p>Here's your latest academic progress for School Year 2024-2025</p>
                </div>
                <div class="banner-image">
                    <img src="{{asset('images/school2.jpg')}}" alt="School Building" class="school-img">
                </div>
            </section>

            <section class="report-card">
                <div class="semester-selector">
                    <h3>School Year 2024-2025</h3>
                    <div class="semester-tabs">
                        <div class="semester-tab active" data-semester="1">1st Semester</div>
                        <div class="semester-tab" data-semester="2">2nd Semester</div>
                    </div>
                </div>

                <div class="report-card-content">
                    <div class="grade-section academic-section">
                        <h2>ACADEMICS</h2>
                        <div class="grade-table">
                            <div class="table-header">
                                <div class="subject-header">SUBJECTS</div>
                                <div class="grade-header">1ST</div>
                                <div class="grade-header">2ND</div>
                                <div class="grade-header">3RD</div>
                                <div class="grade-header">4TH</div>
                                <div class="grade-header">FINAL</div>
                            </div>
                            <div class="table-body">
                                @foreach($grades as $grade)
                                    <div class="subject-row">
                                        <div class="subject-name">{{ $grade->subject->name ?? 'Unknown Subject' }}</div>
                                        <div class="quarter-grade">{{ $grade->first_quarter ?? 'N/A' }}</div>
                                        <div class="quarter-grade">{{ $grade->second_quarter ?? 'N/A' }}</div>
                                        <div class="quarter-grade">{{ $grade->third_quarter ?? 'N/A' }}</div>
                                        <div class="quarter-grade">{{ $grade->fourth_quarter ?? 'N/A' }}</div>
                                        <div class="quarter-grade final">{{ number_format($grade->final_grade, 1) }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                
                        <div class="view-attendance">
                            <a href="#" class="attendance-link">CLICK HERE TO VIEW REPORTS ON ATTENDANCE</a>
                        </div>
                    </div>
                
                    <!-- Legends Section -->
                    <div class="grade-legends">
                        <h2>LEGENDS</h2>
                        <div class="legends-container">
                            <div class="legend-item">
                                <span class="legend-range">100-90</span>
                                <span class="legend-desc">- Excellent</span>
                            </div>
                            <div class="legend-item">
                                <span class="legend-range">89-80</span>
                                <span class="legend-desc">- Very Good</span>
                            </div>
                            <div class="legend-item">
                                <span class="legend-range">79-75</span>
                                <span class="legend-desc">- Good</span>
                            </div>
                            <div class="legend-item">
                                <span class="legend-range">75 BELOW</span>
                                <span class="legend-desc">- Poor</span>
                            </div>
                        </div>
                    </div>
                </div>
                
            </section>

            <!--<section class="my-subjects">
                <h2>MY CURRENT SUBJECTS</h2>
                <div class="subjects-container">
                    <div class="subject-card">
                        <div class="subject-image">
                            <img src="{{asset('images/study1.jpg')}}" alt="Math and Science" class="study-img">
                        </div>
                        <div class="subject-info">
                            <h3>Core Subjects</h3>
                            <ul>
                                <li>Mathematics</li>
                                <li>Science</li>
                                <li>English</li>
                                <li>Filipino</li>
                                <li>Hekasi</li>
                            </ul>
                            <a href="#" class="subject-details-btn">View Details</a>
                        </div>
                    </div>
                    <div class="subject-card">
                        <div class="subject-image">
                            <img src="{{asset('images/study2.jpg')}}" alt="Electives" class="study-img">
                        </div>
                        <div class="subject-info">
                            <h3>Elective Subjects</h3>
                            <ul>
                                <li>Computer Studies</li>
                                <li>Physical Education</li>
                                <li>Arts</li>
                                <li>Music</li>
                            </ul>
                            <a href="#" class="subject-details-btn">View Details</a>
                        </div>
                    </div>
                </div>
            </section>-->

        </main>
    </div>

    <div class="mobile-toggle">
        <i class="fas fa-bars"></i>
    </div>

    <script src="{{asset('js/script_student_report_card.js')}}"></script>
</body>
</html>