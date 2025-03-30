<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCA Montessori School - Announcements</title>
    <link rel="stylesheet" href="{{ asset('css/ins_announcement.css') }}">
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
                    <li><a href="{{ route('instructor.report') }}" class="nav-item">GRADE REPORTS</a></li>
                    <li><a href="{{ route('instructor.announcement') }}" class="nav-item active">ANNOUNCEMENTS</a></li>
                </ul>
            </nav>
            <div class="logout">
                <a href="#" class="nav-item">LOGOUT</a>
            </div>
        </div>

        
        <div class="main-content">
            <div class="header">
                <h1>ANNOUNCEMENTS</h1>
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

            
            <div class="announcement-creation">
                <div class="message-box">
                    <div class="message-header">
                        <h3>Attention!</h3>
                    </div>
                    <div class="message-content">
                        <textarea placeholder="Input your message here..."></textarea>
                    </div>
                </div>
                
                <div class="controls-container">
                    <div class="left-controls">
                        <button class="add-file-btn">Add File</button>
                    </div>
                    <div class="right-controls">
                        <div class="section-dropdown">
                            <select id="section-select">
                                <option value="" disabled selected>SECTION</option>
                                <option value="section-a">Section A</option>
                                <option value="section-b">Section B</option>
                                <option value="section-c">Section C</option>
                                <option value="section-gardenia">Section Gardenia</option>
                                <option value="all">All Sections</option>
                            </select>
                        </div>
                        <button class="announce-btn">ANNOUNCE</button>
                    </div>
                </div>
                
                
                <div class="announcement-preview">
                    <div class="preview-header">
                        <h3>Announcement</h3>
                        <span class="preview-recipient">To: Section Gardenia</span>
                    </div>
                    <div class="preview-content">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    </div>
                </div>
            </div>
            
            
            <div class="announcement-status">
                <div class="table-container">
                    <table class="status-table">
                        <thead>
                            <tr>
                                <th>STUDENT</th>
                                <th>STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Maria Santos</td>
                                <td>Viewed</td>
                            </tr>
                            <tr>
                                <td>John Rivera</td>
                                <td>Not Viewed</td>
                            </tr>
                            <tr>
                                <td>Sofia Garcia</td>
                                <td>Viewed</td>
                            </tr>
                            <tr>
                                <td>Miguel Cruz</td>
                                <td>Not Viewed</td>
                            </tr>
                            <tr>
                                <td>Gabriela Ponce</td>
                                <td>Viewed</td>
                            </tr>
                            <tr>
                                <td>Alex Reyes</td>
                                <td>Not Viewed</td>
                            </tr>
                            <tr>
                                <td>Isabella Lim</td>
                                <td>Viewed</td>
                            </tr>
                            <tr>
                                <td>Diego Tan</td>
                                <td>Not Viewed</td>
                            </tr>
                        </tbody>
                    </table>
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

            
            document.querySelector('.announce-btn').addEventListener('click', function() {
                const messageText = document.querySelector('.message-content textarea').value;
                const selectedSection = document.querySelector('#section-select').value;
                
                if (messageText.trim() === '') {
                    alert('Please enter a message before announcing.');
                    return;
                }
                
                if (selectedSection === '' || selectedSection === null) {
                    alert('Please select a section before announcing.');
                    return;
                }
                
                
                document.querySelector('.preview-content p').textContent = messageText;
                document.querySelector('.preview-recipient').textContent = 'To: ' + 
                    document.querySelector('#section-select option:checked').text;
                
                
                alert('Announcement sent successfully!');
                
                
                document.querySelector('.message-content textarea').value = '';
            });
            
            
            document.querySelector('.add-file-btn').addEventListener('click', function() {
                alert('File upload functionality would be implemented here.');
                
            });
        });
    </script>
</body>
</html>