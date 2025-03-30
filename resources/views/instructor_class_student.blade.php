<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCA Montessori School - Instructor Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/ins_class_students.css') }}">
    <link href="https://fonts.cdnfonts.com/css/garet" rel="stylesheet">
                
</head>
<body>
    <div class="container">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <div class="logo-container">
                <img src="logo.png" alt="MCA Montessori School Logo" class="logo">
                <h2 class="school-name">MCA MONTESSORI SCHOOL</h2>
            </div>
            
            <nav class="navigation">
                <ul>
                    <li><a href="{{ route('instructor.dashboard') }}">DASHBOARD</a></li>
                    <li class="active">
                        <a href="{{ route('instructor.schedmore') }}">CLASSES</a>
                        <ul class="submenu">
                            <li><a href="{{ route('instructor.schedule') }}">SCHEDULES</a></li>
                            <li class="active"><a href="{{ route('instructor.student') }}">STUDENTS</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ route('instructor.attendance') }}">ATTENDANCE REPORTS</a></li>
                    <li><a href="{{ route('instructor.report') }}">GRADE REPORTS</a></li>
                    <li><a href="{{ route('instructor.announcement') }}">ANNOUNCEMENTS</a></li>
                </ul>
            </nav>
            
            <div class="logout-container">
                <a href="#logout" class="logout-btn">LOGOUT</a>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="main-content">
            <header class="header">
                <h1 class="page-title">STUDENTS</h1>
                <div class="user-controls">
                    <div class="instructor-profile">
                        <img src="examplepic.png" alt="Instructor Profile" class="instructor-img">
                        <div class="instructor-info">
                            <p class="instructor-name">Krystal Mendez</p>
                            <p class="instructor-title">INSTRUCTOR</p>
                        </div>
                    </div>
                    <div class="notification">
                        <img src="bell.png" alt="Notifications" class="bell-icon">
                    </div>
                    <div class="settings">
                        <img src="settings.png" alt="Settings" class="settings-icon">
                    </div>
                </div>
            </header>

            <div class="content-divider"></div>

            <section class="filters">
                <div class="filter-container">
                    <div class="filter-group section-filter">
                        <select id="section-dropdown" class="section-dropdown">
                            <option value="">SECTION</option>
                            <option value="A">Section A</option>
                            <option value="B">Section B</option>
                            <option value="C">Section C</option>
                            <option value="D">Section D</option>
                        </select>
                    </div>
                    <div class="filter-group search-filter">
                        <input type="text" id="student-search" class="student-search" placeholder="Name of Student">
                        <button type="button" class="search-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        </button>
                    </div>
                </div>
            </section>

            <div class="dashboard-container">
                <div class="dashboard-cards">
                    <div class="student-count-card">
                        <h3>MY STUDENTS</h3>
                        <p class="count">99</p>
                    </div>
                    
                    <div class="student-profile-card">
                        <img src="meme.jpg" alt="Student Profile" class="student-img">
                        <div class="student-info">
                            <p><strong>Name:</strong> Jane Doe</p>
                            <p><strong>Section:</strong> A</p>
                        </div>
                    </div>
                </div>

                <div class="students-table-container">
                    <table class="students-table">
                        <thead>
                            <tr>
                                <th>NAME</th>
                                <th>SECTION</th>
                                <th>STATUS</th>
                                <th>GRADES</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Jane Doe</td>
                                <td>A</td>
                                <td>Active</td>
                                <td>A</td>
                            </tr>
                            <tr>
                                <td>John Smith</td>
                                <td>A</td>
                                <td>Active</td>
                                <td>B+</td>
                            </tr>
                            <tr>
                                <td>Maria Garcia</td>
                                <td>B</td>
                                <td>Active</td>
                                <td>A-</td>
                            </tr>
                            <tr>
                                <td>Kevin Johnson</td>
                                <td>C</td>
                                <td>Inactive</td>
                                <td>C</td>
                            </tr>
                            <tr>
                                <td>Emily Chen</td>
                                <td>A</td>
                                <td>Active</td>
                                <td>A+</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="update-container">
                    <button class="update-btn">UPDATE</button>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Add basic interactivity
        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality
            const searchInput = document.getElementById('student-search');
            const tableRows = document.querySelectorAll('.students-table tbody tr');
            
            searchInput.addEventListener('input', function() {
                const searchTerm = searchInput.value.toLowerCase();
                
                tableRows.forEach(row => {
                    const name = row.querySelector('td:first-child').textContent.toLowerCase();
                    if (name.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
            
            // Section filter functionality
            const sectionDropdown = document.getElementById('section-dropdown');
            
            sectionDropdown.addEventListener('change', function() {
                const selectedSection = sectionDropdown.value;
                
                if (selectedSection === '') {
                    tableRows.forEach(row => {
                        row.style.display = '';
                    });
                } else {
                    tableRows.forEach(row => {
                        const section = row.querySelector('td:nth-child(2)').textContent;
                        if (section === selectedSection) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>