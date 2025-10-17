<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="0">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCA Montessori School - Student Dashboard</title>
    <link rel="stylesheet" href="{{ secure_asset('css/styles_student_dash.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css?v=1759179376">
    <link href="https://fonts.cdnfonts.com/css/garet" rel="stylesheet">

</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <div class="logo-container">
                <img src="{{ secure_asset('images/schoollogo.png') }}?v={{ time() }}" alt="ACA Montessori School Logo" class="logo">
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li class="active"><a href="#"><i class="fas fa-th-large"></i> DASHBOARD</a></li>
                    <li><a href="{{ route('student.grades') }}"><i class="fas fa-chart-bar"></i> VIEW MY GRADES</a></li>
                    <li><a href="{{ route('student.subjects') }}"><i class="fas fa-book"></i> SUBJECTS</a></li>
                    <!--<li><a href="#"><i class="fas fa-file-alt"></i> MY DOCUMENTS</a></li>
                    <li><a href="#"><i class="fas fa-calendar-alt"></i> CALENDAR</a></li>
                    <li><a href="#"><i class="fas fa-tasks"></i> ASSIGNMENTS</a></li>
                    <li><a href="#"><i class="fas fa-comment-alt"></i> MESSAGES</a></li>-->
                </ul>
            </nav>
            <div class="logout-container">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <a href="#" class="logout-btn" onclick="confirmExit()"><i class="fas fa-sign-out-alt"></i> LOGOUT</a>
            </div>
        </aside>

        <main class="main-content">
            <header class="top-bar">
                <div class="welcome-text">
                    <h1>Welcome, {{ Auth::user()->name }}!</h1>
                </div>
                <div class="user-menu">
                    <div class="notifications">
                        <img src="{{ secure_asset('images/bell_student.png') }}?v={{ time() }}" alt="Notifications" class="icon">
                        <span class="notification-badge">3</span>
                    </div>
                    <div class="settings">
                        <img src="{{ secure_asset('images/settings_student.png') }}?v={{ time() }}" alt="Settings" class="icon">
                    </div>
                    <div class="user-profile">
                        <img src="" alt="Krystal Mendez" class="profile-pic">
                        <div class="user-info">
                            <h3>{{ Auth::user()->name }}</h3>
                            <p>Grade 12</p>
                        </div>
                    </div>
                </div>
            </header>

            <section class="banner">
                <div class="banner-content">
                    <h2>Enhance Your Skills - Join a Workshop Today!</h2>
                    <p>Discover new talents and develop your skills by participating in our exciting workshops. From technology and art to leadership and personal development, there's something for everyone. Start your journey to growth!</p>
                    <a href="#" class="cta-button">Sign Up Now →</a>
                </div>
                <div class="banner-image">
                    <img src="{{ secure_asset('images/school2.jpg') }}?v={{ time() }}" alt="Workshop Image">
                </div>
            </section>

            <section class="content-section">
                <div class="section-header">
                    <h2>MY SUBJECTS</h2>
                    <a href="#" class="see-all">SEE ALL</a>
                </div>
                <div class="subjects-grid">
                    <div class="subject-list">
                        @foreach($classes as $class)
                            <div class="subject-card">
                                <img src="{{ secure_asset('images/study1.jpg') }}?v={{ time() }}" alt="{{ $class->subject->name ?? 'Subject' }}" class="subject-image">
                                <div class="subject-info">
                                    <h3>{{ $class->subject->name ?? 'Unknown Subject' }}</h3>
                                    
                                    @php
                                        // Prepare the schedule text
                                        $scheduleText = '';
                                        foreach($class->schedules as $schedule) {
                                            $scheduleText .= $schedule->day_of_week . ' • ' . date('g:i A', strtotime($schedule->start_time)) . ' - ' . date('g:i A', strtotime($schedule->end_time)) . ' | ';
                                        }
                                        $scheduleText = rtrim($scheduleText, '| ');
                                    @endphp
                    
                                    <p>{{ $scheduleText }}</p>
                    
                                    <div class="subject-progress">
                                        <div class="progress-bar">
                                            <div class="progress" style="width: 90.8%"></div> {{-- Hardcoded for now --}}
                                        </div>
                                        <span>90.8%</span> {{-- Hardcoded for now --}}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!--
                    <div class="subject-card">
                        <img src="{{ secure_asset('images/study2.jpg') }}?v={{ time() }}" alt="English Literature" class="subject-image">
                        <div class="subject-info">
                            <h3>English Literature</h3>
                            <p>Tuesday, Thursday • 10:00 AM - 11:30 AM</p>
                            <div class="subject-progress">
                                <div class="progress-bar">
                                    <div class="progress" style="width: 95.7%"></div>
                                </div>
                                <span>95.7%</span>
                            </div>
                        </div>
                    </div>
                    <div class="subject-card">
                        <img src="{{ secure_asset('images/study1.jpg') }}?v={{ time() }}" alt="Science" class="subject-image">
                        <div class="subject-info">
                            <h3>Science</h3>
                            <p>Monday, Wednesday • 1:00 PM - 2:30 PM</p>
                            <div class="subject-progress">
                                <div class="progress-bar">
                                    <div class="progress" style="width: 88.3%"></div>
                                </div>
                                <span>88.3%</span>
                            </div>
                        </div>
                    </div>
                    <div class="subject-card">
                        <img src="{{ secure_asset('images/study2.jpg') }}?v={{ time() }}" alt="Filipino" class="subject-image">
                        <div class="subject-info">
                            <h3>Filipino</h3>
                            <p>Tuesday, Friday • 2:30 PM - 4:00 PM</p>
                            <div class="subject-progress">
                                <div class="progress-bar">
                                    <div class="progress" style="width: 79.6%"></div>
                                </div>
                                <span>79.6%</span>
                            </div>
                        </div>
                    </div>
                    -->
                </div>
            </section>

            <!--<div class="dashboard-grid">
                <section class="grades-section">
                    <div class="section-header">
                        <h2>GRADES</h2>
                        <a href="#" class="see-all">SEE ALL</a>
                    </div>
                
                    <div class="grades-cards">
                        @foreach($grades as $grade)
                            <div class="grade-card">
                                <div class="grade-header">
                                    <h3>{{ $grade->subject->name ?? 'Unknown Subject' }}</h3>
                                    <span class="overall-grade">{{ number_format($grade->final_grade, 1) }}</span>
                                </div>
                                <div class="grade-details">
                                    <div class="quarter">
                                        <span>1st</span>
                                        <div class="quarter-grade">{{ $grade->first_quarter ?? 'N/A' }}</div>
                                    </div>
                                    <div class="quarter">
                                        <span>2nd</span>
                                        <div class="quarter-grade">{{ $grade->second_quarter ?? 'N/A' }}</div>
                                    </div>
                                    <div class="quarter">
                                        <span>3rd</span>
                                        <div class="quarter-grade">{{ $grade->third_quarter ?? 'N/A' }}</div>
                                    </div>
                                    <div class="quarter">
                                        <span>4th</span>
                                        <div class="quarter-grade">{{ $grade->fourth_quarter ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
                

                <!--<section class="upcoming-section">
                    <div class="section-header">
                        <h2>UPCOMING DEADLINES</h2>
                        <a href="#" class="see-all">SEE ALL</a>
                    </div>
                    <div class="deadlines-list">
                        <div class="deadline-item">
                            <div class="deadline-date">
                                <span class="date">25</span>
                                <span class="month">APR</span>
                            </div>
                            <div class="deadline-info">
                                <h4>Mathematics Assignment</h4>
                                <p>Linear Algebra Problem Set</p>
                            </div>
                            <div class="deadline-status ongoing">Ongoing</div>
                        </div>
                        <div class="deadline-item">
                            <div class="deadline-date">
                                <span class="date">28</span>
                                <span class="month">APR</span>
                            </div>
                            <div class="deadline-info">
                                <h4>English Literature Essay</h4>
                                <p>Shakespeare Analysis</p>
                            </div>
                            <div class="deadline-status pending">Pending</div>
                        </div>
                        <div class="deadline-item">
                            <div class="deadline-date">
                                <span class="date">30</span>
                                <span class="month">APR</span>
                            </div>
                            <div class="deadline-info">
                                <h4>Science Lab Report</h4>
                                <p>Chemical Reactions Experiment</p>
                            </div>
                            <div class="deadline-status pending">Pending</div>
                        </div>
                        <div class="deadline-item">
                            <div class="deadline-date">
                                <span class="date">02</span>
                                <span class="month">MAY</span>
                            </div>
                            <div class="deadline-info">
                                <h4>Filipino Presentation</h4>
                                <p>Cultural Heritage Project</p>
                            </div>
                            <div class="deadline-status pending">Pending</div>
                        </div>
                    </div>
                </section>-->
            </div>-->

            <section class="announcements-section">
                <div class="section-header">
                    <h2>SCHOOL ANNOUNCEMENTS</h2>
                    <a href="#" class="see-all">SEE ALL</a>
                </div>
            
                <div class="announcements-slider">
                    @forelse ($announcements as $announcement)
                        <div class="announcement-card">
                            <div class="announcement-icon">
                                <i class="fas fa-bullhorn"></i>
                            </div>
                            <div class="announcement-content">
                                <h3>{{ $announcement->title }}</h3>
                                <p>{{ $announcement->message }}</p>
                                <span class="announcement-date">{{ \Carbon\Carbon::parse($announcement->created_at)->format('F d, Y') }}</span>
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
            
                <div class="slider-controls">
                    <!-- Optional: You can add dynamic dots depending on announcements count -->
                </div>
            </section>
            

            <div id="confirm-modal" class="modal">
                <div class="modal-content">
                    <p>Are you sure you want to log out?</p>
                    <button class="confirm-btn" onclick="logout(event)">Yes, Logout</button>
                    <button class="cancel-btn" onclick="closeModal()">No</button>
                </div>
            </div>

        </main>
    </div>

    <script src="{{ secure_asset('js/script_student_dashboard.js') }}?v={{ time() }}"></script>
</body>
</html>