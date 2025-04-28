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
                <img src="{{ asset('images/logo.png') }}" alt="MCA Montessori School Logo" class="logo">
                <h2 class="school-name">MCA MONTESSORI SCHOOL</h2>
            </div>
            
            <nav class="navigation">
                <ul>
                    <li><a href="{{ route('instructor.dashboard') }}" class="nav-item">DASHBOARD</a></li>
                    <li>
                        <a href="{{ route('instructor.schedule') }}" class="nav-item active">CLASSES</a>
                        <ul class="sub-menu">
                            <li><a href="{{ route('instructor.schedule') }}" class="sub-item">SCHEDULES</a></li>
                            <li><a href="{{ route('instructor.student') }}" class="sub-item active">STUDENTS</a></li>
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
        </aside>

        <!-- Main Content Area -->
        <main class="main-content">
            <header class="header">
                <h1 class="page-title">STUDENTS</h1>
                <div class="user-controls">
                    <div class="instructor-profile">
                        <img src="{{ asset('images/instructor_user.png') }}" alt="Instructor Profile" class="instructor-img">
                        <div class="instructor-info">
                            <p class="instructor-name">{{ $instructor->first_name }} {{ $instructor->last_name }}</p>
                            <p class="instructor-title">INSTRUCTOR</p>
                        </div>
                    </div>
                    <div class="icons">
                        <a href="#" class="icon-link"><img src="{{ asset('images/bell.png') }}" alt="Notifications" class="icon"></a>
                        <a href="#" class="icon-link"><img src="{{ asset('images/settings.png') }}" alt="Settings" class="icon"></a>
                    </div>
                </div>
            </header>

            <div class="content-divider"></div>

            <section class="filters">
                <div class="filter-container">
                    <div class="filter-group section-filter">
                        <select id="section-dropdown" class="section-dropdown">
                            <option value="">SECTION</option>
                            @foreach($students->pluck('section.section_name')->unique()->filter() as $section)
                                <option value="{{ $section }}">{{ $section }}</option>
                            @endforeach
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
                        <p class="count">{{ $students->count() }}</p>
                    </div>
                    
                    @php
                        $firstStudent = $students->first();
                    @endphp

                    <!--@if($firstStudent)
                        <div class="student-profile-card">
                            <img src="{{asset('images/') }}" alt="Student Profile" class="student-img">
                            <div class="student-info">
                                <p><strong>Name:</strong> {{ $firstStudent->full_name }}</p>
                                <p><strong>Section:</strong> {{ $firstStudent->section->section_name ?? 'N/A' }}</p>
                            </div>
                        </div>
                    @endif-->

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
                            @forelse ($students as $student)
                                <tr>
                                    <td>{{ $student->full_name }}</td>
                                    <td>{{ $student->section->section_name ?? 'No Section' }}</td>
                                    <td>{{ $student->status->name ?? 'No Status' }}</td>
                                    <td>
                                        <a href="{{ route('instructor.report') }}" class="btn btn-primary btn-sm">View Grades</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No students found.</td>
                                </tr>
                            @endforelse
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