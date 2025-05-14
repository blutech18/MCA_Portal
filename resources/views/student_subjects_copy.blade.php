<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCA Montessori School - Student Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/styles_student_subjects.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.cdnfonts.com/css/garet" rel="stylesheet">

</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <div class="logo-container">
                <img src="{{ asset('images/schoollogo.png') }}" alt="ACA Montessori School Logo" class="logo">
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="{{ route('student.dashboard') }}"><i class="fas fa-th-large"></i> DASHBOARD</a></li>
                    <li><a href="{{ route('student.grades') }}"><i class="fas fa-chart-bar"></i> VIEW MY GRADES</a></li>
                    <li class="active"><a href="{{ route('student.subjects') }}"><i class="fas fa-book"></i> SUBJECTS</a></li>
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
                        <img src="{{ asset('images/bell_student.png') }}" alt="Notifications" class="icon">
                        <span class="notification-badge">3</span>
                    </div>
                    <div class="settings">
                        <img src="{{asset('images/settings_student.png')}}" alt="Settings" class="icon">
                    </div>
                    <div class="user-profile">
                        <img src="" alt="Krystal Mendez" class="profile-pic">
                        <div class="user-info">
                            <h3>Krystal Mendez</h3>
                            <p>Grade 12</p>
                        </div>
                    </div>
                </div>
            </header>

            <section class="content-section">
                <div class="section-header">
                    <h2>MY SUBJECTS</h2>
                    <a href="#" class="see-all">SEE ALL</a>
                </div>
                <div class="subjects-grid">
                    <div class="subject-list">
                        @foreach($classes as $class)
                            <div class="subject-card">
                                <img src="{{ asset('images/study1.jpg') }}" alt="{{ $class->subject->name ?? 'Subject' }}" class="subject-image">
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
                        <img src="{{asset('images/study2.jpg')}}" alt="English Literature" class="subject-image">
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
                        <img src="{{asset('images/study1.jpg')}}" alt="Science" class="subject-image">
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
                        <img src="{{asset('images/study2.jpg')}}" alt="Filipino" class="subject-image">
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

            

            <div id="confirm-modal" class="modal">
                <div class="modal-content">
                    <p>Are you sure you want to log out?</p>
                    <button class="confirm-btn" onclick="logout(event)">Yes, Logout</button>
                    <button class="cancel-btn" onclick="closeModal()">No</button>
                </div>
            </div>

        </main>
    </div>

    <script src="{{asset('js/script_student_dashboard.js')}}"></script>
</body>
</html>