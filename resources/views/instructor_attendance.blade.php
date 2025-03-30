<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCA Montessori School - Attendance</title>
    <link rel="stylesheet" href="{{ asset('css/ins_attendance.css') }}">
    <link href="https://fonts.cdnfonts.com/css/garet" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo-container">
                <img src="logo.png" alt="MCA Montessori School" class="logo">
                <h2 class="school-name">MCA MONTESSORI SCHOOL</h2>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="{{ route('instructor.dashboard') }}" class="nav-item">DASHBOARD</a></li>
                    <li>
                        <a href="{{ route('instructor.schedmore') }}" class="nav-item">CLASSES</a>
                        <ul class="sub-menu">
                            <li><a href="{{ route('instructor.schedule') }}" class="sub-item">SCHEDULES</a></li>
                            <li><a href="{{ route('instructor.student') }}" class="sub-item">STUDENTS</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ route('instructor.attendance') }}" class="nav-item active">ATTENDANCE REPORTS</a></li>
                    <li><a href="{{ route('instructor.report') }}" class="nav-item">GRADE REPORTS</a></li>
                    <li><a href="{{ route('instructor.announcement') }}" class="nav-item">ANNOUNCEMENTS</a></li>
                </ul>
            </nav>
            <div class="logout">
                <a href="#" class="nav-item">LOGOUT</a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <h1>ATTENDANCE</h1>
                <div class="user-actions">
                    <div class="user-profile">
                        <img src="examplepic.png" alt="User Profile" class="profile-pic">
                        <div class="user-info">
                            <p class="user-name">Krystal Mendez</p>
                            <p class="user-grade">INSTRUCTOR</p>
                        </div>
                    </div>
                    <div class="icons">
                        <a href="#" class="icon-link"><img src="bell.png" alt="Notifications" class="icon"></a>
                        <a href="#" class="icon-link"><img src="settings.png" alt="Settings" class="icon"></a>
                    </div>
                </div>
            </div>

            
            <div class="search-container">
                <input type="text" placeholder="Search" class="search-bar">
                <button class="search-button"><i class="fas fa-search"></i></button>
            </div>
                
<div class="stats-container">
    <div class="stat-card">
        <div class="stat-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
        </div>
        <div class="stat-info">
            <h3>Present</h3>
            <p>25</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
            </svg>
        </div>
        <div class="stat-info">
            <h3>Absent</h3>
            <p>3</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <polyline points="12 6 12 12 16 14"></polyline>
            </svg>
        </div>
        <div class="stat-info">
            <h3>Late</h3>
            <p>2</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
            </svg>
        </div>
        <div class="stat-info">
            <h3>Total Classes</h3>
            <p>45</p>
        </div>
    </div>
</div>


<div class="date-display">Today's Date: March 29, 2025</div>
            <!-- Student Info Table -->
            <div class="table-container student-info-container">
                <table class="student-info">
                    <thead>
                        <tr>
                            <th>NAME</th>
                            <th>SECTION</th>
                            <th>GRADES</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            
            <div class="table-container attendance-container">
                <table class="attendance-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>JUNE</th>
                            <th>JULY</th>
                            <th>AUG</th>
                            <th>SEPT</th>
                            <th>OCT</th>
                            <th>NOV</th>
                            <th>DEC</th>
                            <th>JAN</th>
                            <th>FEB</th>
                            <th>MAR</th>
                            <th>APR</th>
                            <th>MAY</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>

           
            <div class="button-container">
                <button class="update-button">UPDATE</button>
            
            </div>
        </div>
    </div>

    <script>
        
        function updateDate() {
            const now = new Date();
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            const formattedDate = now.toLocaleDateString('en-US', options);
            document.getElementById('current-date').textContent = formattedDate;
        }

        
        document.addEventListener('DOMContentLoaded', function() {
            updateDate();
            
            
            document.getElementById('present-count').textContent = '25';
            document.getElementById('absent-count').textContent = '3';
            document.getElementById('late-count').textContent = '2';
            document.getElementById('total-classes').textContent = '45';
            
            
            document.querySelector('.search-button').addEventListener('click', function() {
                const searchValue = document.querySelector('.search-bar').value;
                console.log('Searching for:', searchValue);
            });
            
            
            document.querySelector('.update-button').addEventListener('click', function() {
                alert('Attendance records updated successfully!');
            });
        });
    </script>
</body>
</html>