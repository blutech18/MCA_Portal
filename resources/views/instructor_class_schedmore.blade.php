<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCA Montessori School - Schedule More</title>
    <link rel="stylesheet" href="{{ asset('css/ins_class_schedmore.css') }}">
    <link href="https://fonts.cdnfonts.com/css/garet" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
                
    
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
            <div class="logout">
                <a href="#" class="nav-item">LOGOUT</a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <h1>SCHEDULES</h1>
                <div class="user-actions">
                    <div class="user-profile">
                        <img src="examplepic.png" alt="User Profile" class="profile-pic">
                        <div class="user-info">
                            <p class="user-name">Krystal Mendez</p>
                            <p class="user-role">INSTRUCTOR</p>
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
                <!-- First row of cards -->
                <div class="cards-row">
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
                </div>
                
                <!-- Second row of cards -->
                <div class="cards-row">
                    <div class="schedule-card">
                        <div class="card-content">
                            <p class="card-label">GRADE:</p>
                            <p class="card-data" id="grade4"></p>
                            <p class="card-label">SECTION:</p>
                            <p class="card-data" id="section4"></p>
                            <p class="card-label">SUBJECT:</p>
                            <p class="card-data" id="subject4"></p>
                            <p class="card-label">TIME:</p>
                            <p class="card-data" id="time4"></p>
                        </div>
                    </div>
                    <div class="schedule-card">
                        <div class="card-content">
                            <p class="card-label">GRADE:</p>
                            <p class="card-data" id="grade5"></p>
                            <p class="card-label">SECTION:</p>
                            <p class="card-data" id="section5"></p>
                            <p class="card-label">SUBJECT:</p>
                            <p class="card-data" id="subject5"></p>
                            <p class="card-label">TIME:</p>
                            <p class="card-data" id="time5"></p>
                        </div>
                    </div>
                    <div class="schedule-card">
                        <div class="card-content">
                            <p class="card-label">GRADE:</p>
                            <p class="card-data" id="grade6"></p>
                            <p class="card-label">SECTION:</p>
                            <p class="card-data" id="section6"></p>
                            <p class="card-label">SUBJECT:</p>
                            <p class="card-data" id="subject6"></p>
                            <p class="card-label">TIME:</p>
                            <p class="card-data" id="time6"></p>
                        </div>
                    </div>
                </div>
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
            { code: "SCI102", subject: "Physics", grade: "11", section: "B", time: "9:45 AM - 11:15 AM", day: "Monday" },
            { code: "ENG103", subject: "Literature", grade: "10", section: "C", time: "1:00 PM - 2:30 PM", day: "Monday" },
            { code: "HIS104", subject: "History", grade: "9", section: "A", time: "2:45 PM - 4:15 PM", day: "Tuesday" },
            { code: "ART105", subject: "Fine Arts", grade: "8", section: "B", time: "8:00 AM - 9:30 AM", day: "Wednesday" },
            { code: "MUS106", subject: "Music", grade: "7", section: "C", time: "10:00 AM - 11:30 AM", day: "Thursday" }
        ];

        
        function populateScheduleCards() {
            for (let i = 0; i < scheduleData.length; i++) {
                const cardIndex = i + 1;
                const data = scheduleData[i];
                
                document.getElementById(`grade${cardIndex}`).textContent = data.grade;
                document.getElementById(`section${cardIndex}`).textContent = data.section;
                document.getElementById(`subject${cardIndex}`).textContent = data.subject;
                document.getElementById(`time${cardIndex}`).textContent = data.time;
            }
        }

     
        document.addEventListener('DOMContentLoaded', function() {
            updateDate();
            populateScheduleCards();
            
            // Update date every minute
            setInterval(updateDate, 60000);
            
            
            const cards = document.querySelectorAll('.schedule-card');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.classList.add('show');
                }, 100 * index);
            });
        });
    </script>
</body>
</html>