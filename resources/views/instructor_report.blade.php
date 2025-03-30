<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCA Montessori School - Report Card</title>
    <link rel="stylesheet" href="{{ asset('css/ins_reportcard.css') }}">
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
                    <li><a href="{{ route('instructor.attendance') }}" class="nav-item">ATTENDANCE REPORTS</a></li>
                    <li><a href="{{ route('instructor.report') }}" class="nav-item active">GRADE REPORTS</a></li>
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
                <h1>REPORT CARD</h1>
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

            
            <div class="report-card-content">
                
                <div class="student-list-container">
                    
                    <div class="student-card">
                        <span class="student-card-title">STUDENT CARD</span>
                        <img src="meme.jpg" alt="Student Photo" class="student-photo">
                        <div class="student-info">
                            <div class="student-info-row">
                                <span class="info-label">NAME:</span>
                                <span class="info-value">Kenneth Kassandra Xynthea A. Mananggit</span>
                            </div>
                            <div class="student-info-row">
                                <span class="info-label">SECTION:</span>
                                <span class="info-value">Section A</span>
                            </div>
                            <div class="student-info-row">
                                <span class="info-label">GRADE:</span>
                                <span class="info-value">10th Grade</span>
                            </div>
                        </div>
                    </div>
                    
                    <h2 class="section-title">STUDENT LIST</h2>
                    <div class="table-container">
                        <table class="student-table">
                            <thead>
                                <tr>
                                    <th>NAME</th>
                                    <th>ID</th>
                                    <th>SECTION</th>
                                    <th>GRADE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="active">
                                    <td>Maria Santos</td>
                                    <td>10023</td>
                                    <td>Section A</td>
                                    <td>10th Grade</td>
                                </tr>
                                <tr>
                                    <td>John Rivera</td>
                                    <td>10024</td>
                                    <td>Section A</td>
                                    <td>10th Grade</td>
                                </tr>
                                <tr>
                                    <td>Sofia Garcia</td>
                                    <td>10025</td>
                                    <td>Section B</td>
                                    <td>10th Grade</td>
                                </tr>
                                <tr>
                                    <td>Miguel Cruz</td>
                                    <td>10026</td>
                                    <td>Section B</td>
                                    <td>10th Grade</td>
                                </tr>
                                <tr>
                                    <td>Gabriela Ponce</td>
                                    <td>10027</td>
                                    <td>Section C</td>
                                    <td>10th Grade</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Grade Card and Generate Report - Right Side -->
                <div class="grade-actions-container">
                    <!-- Final Grade Card -->
                    <div class="grade-summary-card">
                        <h2>FINAL GRADE</h2>
                        <div class="grade-circle">
                            <span class="grade-value">A</span>
                        </div>
                        <p class="gpa">GPA: 3.85</p>
                    </div>
                    
                    <!-- Generate Report Button -->
                    <div class="button-container">
                        <button class="update-button">GENERATE REPORT</button>
                    </div>
                    
            
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality
            document.querySelector('.search-button').addEventListener('click', function() {
                const searchValue = document.querySelector('.search-bar').value;
                console.log('Searching for:', searchValue);
                // Implement actual search functionality here
            });

            // Handle row selection in student table
            const tableRows = document.querySelectorAll('.student-table tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('click', function() {
                    // Remove active class from all rows
                    tableRows.forEach(r => r.classList.remove('active'));
                    // Add active class to clicked row
                    this.classList.add('active');
                    
                    // Update student card info based on selected student
                    const name = this.cells[0].textContent;
                    const section = this.cells[2].textContent;
                    const grade = this.cells[3].textContent;
                    
                    document.querySelector('.student-info .info-value:nth-child(2)').textContent = name;
                    document.querySelector('.student-info .info-value:nth-child(4)').textContent = section;
                    document.querySelector('.student-info .info-value:nth-child(6)').textContent = grade;
                });
            });
        });
    </script>
</body>
</html>