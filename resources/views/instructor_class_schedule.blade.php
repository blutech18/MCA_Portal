<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCA Montessori School - Schedule</title>
    <link rel="stylesheet" href="{{ asset('css/ins_class_sched.css') }}"">
    <link href="https://fonts.cdnfonts.com/css/garet" rel="stylesheet">
</head>
<body>
    <div class="container">
        
        <div class="sidebar">
            <div class="logo-container">
                <img src="logo.png" alt="MCA Montessori School" class="logo">
                <h2 class="school-name">MCA MONTESSORI SCHOOL</h2>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="{{ route('instructor.dashboard') }}" class="nav-item">DASHBOARD</a></li>
                    <li>
                        <a href="{{ route('instructor.schedmore') }}" class="nav-item active">CLASSES</a>
                        <ul class="sub-menu">
                            <li><a href="{{ route('instructor.schedule') }}" class="sub-item active">SCHEDULES</a></li>
                            <li><a href="{{ route('instructor.student') }}" class="sub-item">STUDENTS</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ route('instructor.attendance') }}" class="nav-item">ATTENDANCE REPORTS</a></li>
                    <li><a href="{{ route('instructor.report') }}" class="nav-item">GRADE REPORTS</a></li>
                    <li><a href="{{ route('instructor.announcement') }}" class="nav-item">ANNOUNCEMENTS</a></li>
                </ul>
            </nav>
            <div class="logout">
                <a href="#" class="nav-item">LOGOUT</a>
            </div>
        </div>

        
        <div class="main-content">
            <div class="header">
                <h1>SCHEDULES</h1>
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

            <div class="date-section">
                <p class="today-date">Today, <span id="current-date">March 29, 2025</span></p>
            </div>

            <div class="cards-container">
                <div class="schedule-card">
                    <div class="card-content">
                        <p class="card-label">GRADE:</p>
                        <p class="card-data" id="grade1"></p>
                        <p class="card-label">SECTION:</p>
                        <p class="card-data" id="section1"></p>
                        <p class="card-label">SUBJECT:</p>
                        <p class="card-data" id="subject1"></p>
                        <p class="card-label">TIME:</p>
                        <p class="card-data" id="time1"></p>
                    </div>
                </div>
                <div class="schedule-card">
                    <div class="card-content">
                        <p class="card-label">GRADE:</p>
                        <p class="card-data" id="grade2"></p>
                        <p class="card-label">SECTION:</p>
                        <p class="card-data" id="section2"></p>
                        <p class="card-label">SUBJECT:</p>
                        <p class="card-data" id="subject2"></p>
                        <p class="card-label">TIME:</p>
                        <p class="card-data" id="time2"></p>
                    </div>
                </div>
                <div class="schedule-card">
                    <div class="card-content">
                        <p class="card-label">GRADE:</p>
                        <p class="card-data" id="grade3"></p>
                        <p class="card-label">SECTION:</p>
                        <p class="card-data" id="section3"></p>
                        <p class="card-label">SUBJECT:</p>
                        <p class="card-data" id="subject3"></p>
                        <p class="card-label">TIME:</p>
                        <p class="card-data" id="time3"></p>
                    </div>
                </div>
                <div class="more-link">
                    <a href="#" class="more-button">>></a>
                    <span class="more-text">MORE</span>
                </div>
            </div>

            <div class="schedule-table">
                <table>
                    <thead>
                        <tr>
                            <th>CODE</th>
                            <th>SUBJECT</th>
                            <th>GRADE</th>
                            <th>SECTION</th>
                            <th>TIME</th>
                            <th>DAY</th>
                        </tr>
                    </thead>
                    <tbody id="schedule-body">
                    
                    </tbody>
                </table>
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

        
        const scheduleData = [
            { code: "MATH101", subject: "Mathematics", grade: "12", section: "A", time: "8:00 AM - 9:30 AM", day: "Monday" },
            { code: "SCI102", subject: "Physics", grade: "12", section: "A", time: "9:45 AM - 11:15 AM", day: "Monday" },
            { code: "ENG103", subject: "Literature", grade: "12", section: "A", time: "1:00 PM - 2:30 PM", day: "Monday" },
            { code: "HIS104", subject: "History", grade: "12", section: "A", time: "2:45 PM - 4:15 PM", day: "Monday" },
            { code: "ART105", subject: "Fine Arts", grade: "12", section: "B", time: "8:00 AM - 9:30 AM", day: "Tuesday" }
        ];

        
        function populateScheduleTable() {
            const tableBody = document.getElementById('schedule-body');
            tableBody.innerHTML = '';
            
            scheduleData.forEach(item => {
                const row = document.createElement('tr');
                
                const codeCell = document.createElement('td');
                codeCell.textContent = item.code;
                row.appendChild(codeCell);
                
                const subjectCell = document.createElement('td');
                subjectCell.textContent = item.subject;
                row.appendChild(subjectCell);
                
                const gradeCell = document.createElement('td');
                gradeCell.textContent = item.grade;
                row.appendChild(gradeCell);
                
                const sectionCell = document.createElement('td');
                sectionCell.textContent = item.section;
                row.appendChild(sectionCell);
                
                const timeCell = document.createElement('td');
                timeCell.textContent = item.time;
                row.appendChild(timeCell);
                
                const dayCell = document.createElement('td');
                dayCell.textContent = item.day;
                row.appendChild(dayCell);
                
                tableBody.appendChild(row);
            });
        }

        
        function populateScheduleCards() {
            
            if (scheduleData.length > 0) {
                document.getElementById('grade1').textContent = scheduleData[0].grade;
                document.getElementById('section1').textContent = scheduleData[0].section;
                document.getElementById('subject1').textContent = scheduleData[0].subject;
                document.getElementById('time1').textContent = scheduleData[0].time;
            }
            
           
            if (scheduleData.length > 1) {
                document.getElementById('grade2').textContent = scheduleData[1].grade;
                document.getElementById('section2').textContent = scheduleData[1].section;
                document.getElementById('subject2').textContent = scheduleData[1].subject;
                document.getElementById('time2').textContent = scheduleData[1].time;
            }
            
            
            if (scheduleData.length > 2) {
                document.getElementById('grade3').textContent = scheduleData[2].grade;
                document.getElementById('section3').textContent = scheduleData[2].section;
                document.getElementById('subject3').textContent = scheduleData[2].subject;
                document.getElementById('time3').textContent = scheduleData[2].time;
            }
        }

        
        document.addEventListener('DOMContentLoaded', function() {
            updateDate();
            populateScheduleTable();
            populateScheduleCards();
            
            
            setInterval(updateDate, 60000);
        });
    </script>
</body>
</html>