<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCA Montessori School - Instructor Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/maincss.css') }}">
    <link href="https://fonts.cdnfonts.com/css/garet" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo-container">
                <img src="{{ asset('images/logo.png') }}" alt="MCA Montessori School" class="logo">
                <h2 class="school-name">MCA MONTESSORI SCHOOL</h2>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="#" class="nav-item active">DASHBOARD</a></li>
                    <li>
                        <a href="{{ route('instructor.schedmore') }}" class="nav-item">CLASSES</a>
                        <ul class="sub-menu">
                            <li><a href="{{ route('instructor.schedule') }}" class="sub-item">SCHEDULES</a></li>
                            <li><a href="{{ route('instructor.student') }}" class="sub-item">STUDENTS</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ route('instructor.attendance') }}" class="nav-item">ATTENDANCE REPORTS</a></li>
                    <li><a href="{{ route('instructor.report') }}" class="nav-item">GRADE REPORTS</a></li>
                    <li><a href="{{ route('instructor.announcement') }}" class="nav-item">ANNOUNCEMENTS</a></li>
                </ul>
                <div class="logout">
                    <a href="javascript:void(0)" class="nav-item" onclick="confirmExit()">LOGOUT</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>    
                   
            </nav>
            
        </div>

        <!-- Mobile Menu Button -->
        <div class="mobile-menu-btn">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <h1>Welcome, Instructor!</h1>
                <div class="user-actions">
                    <div class="user-profile">
                        <img src="{{ asset('images/examplepic.png') }}" alt="Instructor Profile" class="profile-pic">
                        <div class="user-info">
                            <p class="user-name">Krystal Mendez</p>
                            <p class="user-grade">INSTRUCTOR</p>
                        </div>
                    </div>
                    <div class="icons">
                        <a href="#" class="icon-link"><img src="{{ asset('images/bell_blue.png') }}" alt="Notifications" class="icon"></a>
                        <a href="#" class="icon-link"><img src="{{ asset('images/settings_blue.png') }}" alt="Settings" class="icon"></a>
                        
                    </div>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="search-container">
                <input type="text" placeholder="Search" class="search-bar">
                <button class="search-button"><i class="fas fa-search"></i></button>
            </div>

            <!-- Dashboard Summary -->
            <div class="dashboard-summary">
                <div class="summary-card schedule">
                    <div class="card-content">
                        <img src="calendaricon.png" alt="Calendar" class="card-icon">
                        <div class="card-info">
                            <h2>SCHEDULE TODAY</h2>
                            <div class="card-data">
                                <span class="data-label">SUBJECTS</span>
                                <span class="data-value">4</span>
                            </div>
                            <div class="more-link">MORE</div>
                        </div>
                    </div>
                </div>
                <div class="summary-card students">
                    <div class="card-content">
                        <img src="studentlogo.png" alt="Students" class="card-icon">
                        <div class="card-info">
                            <h2>STUDENTS</h2>
                            <div class="data-value big">156</div>
                            <div class="more-link">MORE</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Class Attendance Section -->
            <div class="section">
                <div class="section-header">CLASS ATTENDANCE</div>
                <div class="attendance-grid">
                    <div class="grid-header"></div>
                    <div class="grid-header"></div>
                    <div class="grid-header"></div>
                    
                    <div class="grid-cell"></div>
                    <div class="grid-cell"></div>
                    <div class="grid-cell"></div>
                    
                    <div class="grid-cell"></div>
                    <div class="grid-cell"></div>
                    <div class="grid-cell"></div>
                    
                    <div class="grid-cell"></div>
                    <div class="grid-cell"></div>
                    <div class="grid-cell"></div>
                </div>
            </div>

            <!-- Class Sections -->
            <div class="section">
                <div class="section-header">CLASS SECTIONS</div>
                <div class="grade-cards">
                    <div class="grade-card">
                        <div class="grade-header">GRADE 11</div>
                        <div class="grade-content"></div>
                    </div>
                    <div class="grade-card">
                        <div class="grade-header">GRADE 12</div>
                        <div class="grade-content"></div>
                    </div>
                    
                </div>
                
            </div>

            <div id="confirm-modal" class="modal">
                <div class="modal-content">
                    <p>Are you sure you want to log out?</p>
                    <button class="confirm-btn" onclick="logout(event)">Yes, Logout</button>
                    <button class="cancel-btn" onclick="closeModal()">No</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            document.querySelector('.mobile-menu-btn').addEventListener('click', function() {
                document.querySelector('.sidebar').classList.toggle('active');
            });
            
            // Search functionality
            document.querySelector('.search-button').addEventListener('click', function() {
                const searchValue = document.querySelector('.search-bar').value;
                console.log('Searching for:', searchValue);
                // Implement actual search functionality here
            });
        });
    </script>
    
    <script src="{{asset('js/logout.js')}}"></script>

</body>
</html>