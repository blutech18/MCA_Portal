<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCA Montessori School - Grade Reports</title>
    <link rel="stylesheet" href="{{ asset('css/ins_reportcard.css') }}?v={{ time() }}">
    <link href="https://fonts.cdnfonts.com/css/garet" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css?v=1759179376">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo-container">
                <img src="{{ asset('images/logo.png') }}?v={{ time() }}" alt="MCA Montessori School" class="logo">
                <h2 class="school-name">MCA MONTESSORI SCHOOL</h2>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="{{ route('instructor.dashboard') }}" class="nav-item">DASHBOARD</a></li>
                    <li>
                        <a href="{{ route('instructor.schedule') }}" class="nav-item">CLASSES</a>
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
                <h1>GRADE REPORTS</h1>
                <div class="user-actions">
                    <div class="user-profile">
                        <img src="{{ asset('images/instructor_user.png') }}?v={{ time() }}" alt="User Profile" class="profile-pic">
                        <div class="user-info">
                            <p class="user-name">{{ $instructor->short_name }}</p>
                            <p class="user-grade">INSTRUCTOR</p>
                        </div>
                    </div>
                    <div class="icons">
                        <a href="#" class="icon-link"><img src="{{ asset('images/bell.png') }}?v={{ time() }}" alt="Notifications" class="icon"></a>
                        <a href="#" class="icon-link"><img src="{{ asset('images/settings.png') }}?v={{ time() }}" alt="Settings" class="icon"></a>
                    <a href="javascript:void(0)" class="icon-link logout-btn" onclick="confirmExit()" title="Logout">
                        <i class="fas fa-sign-out-alt" style="font-size: 20px; color: #1A2B49;"></i>
                    </a>
                    </div>
                </div>
            </div>
          
            <!-- Grade Reports Content -->
            <div class="content-section">
                <div class="page-header">
                    <h2><i class="fas fa-chart-line"></i> Grade Reports</h2>
                    <p>View and analyze student grades</p>
                    <a href="{{ route('instructor.grade.input') }}" class="grade-input-btn" style="background: #28a745; color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; font-weight: 600; transition: all 0.3s; margin-top: 10px;">
                        <i class="fas fa-edit"></i> Input Student Grades
                    </a>
                </div>
                
                <div class="reports-filters">
                    <div class="filters-container">
                        <div class="filter-group">
                            <label for="class-select"><i class="fas fa-chalkboard-teacher"></i> Select Class:</label>
                            <select id="class-select">
                                <option value="">All Classes</option>
                                @if(isset($classes) && $classes->count() > 0)
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label for="subject-select"><i class="fas fa-book"></i> Select Subject:</label>
                            <select id="subject-select">
                                <option value="">All Subjects</option>
                                @if(isset($subjects) && $subjects->count() > 0)
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label for="grading-period"><i class="fas fa-calendar-alt"></i> Grading Period:</label>
                            <select id="grading-period">
                                <option value="1">1st Quarter</option>
                                <option value="2">2nd Quarter</option>
                                <option value="3">3rd Quarter</option>
                                <option value="4">4th Quarter</option>
                            </select>
                        </div>
                        
                        <button class="search-button"><i class="fas fa-file-alt"></i> Generate Report</button>
                    </div>
                </div>
                
                <div class="grades-table">
                    <div class="table-header">
                        <h3><i class="fas fa-table"></i> Grade Records</h3>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th><i class="fas fa-user"></i> Student Name</th>
                                <th><i class="fas fa-chalkboard-teacher"></i> Class</th>
                                <th><i class="fas fa-book"></i> Subject</th>
                                <th><i class="fas fa-star"></i> 1st Q</th>
                                <th><i class="fas fa-star"></i> 2nd Q</th>
                                <th><i class="fas fa-star"></i> 3rd Q</th>
                                <th><i class="fas fa-star"></i> 4th Q</th>
                                <th><i class="fas fa-trophy"></i> Final Grade</th>
                                <th><i class="fas fa-info-circle"></i> Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($grades) && $grades->count() > 0)
                                @foreach($grades as $grade)
                                    <tr>
                                        <td>{{ $grade->student->first_name ?? 'N/A' }} {{ $grade->student->last_name ?? 'N/A' }}</td>
                                        <td>{{ $grade->class->name ?? 'N/A' }}</td>
                                        <td>{{ $grade->subject->name ?? 'N/A' }}</td>
                                        <td>{{ $grade->first_quarter ?? 'N/A' }}</td>
                                        <td>{{ $grade->second_quarter ?? 'N/A' }}</td>
                                        <td>{{ $grade->third_quarter ?? 'N/A' }}</td>
                                        <td>{{ $grade->fourth_quarter ?? 'N/A' }}</td>
                                        <td class="final-grade">{{ $grade->final_grade ?? 'N/A' }}</td>
                                        <td>
                                            <span class="remarks {{ ($grade->final_grade ?? 0) >= 75 ? 'passed' : 'failed' }}">
                                                {{ ($grade->final_grade ?? 0) >= 75 ? 'PASSED' : 'FAILED' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9" class="no-data">No grade records found.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                
                @if(isset($grades) && $grades->count() > 0)
                    <div class="grades-summary">
                        <div class="summary-header">
                            <h3><i class="fas fa-chart-bar"></i> Grade Summary</h3>
                        </div>
                        <div class="summary-stats">
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="stat-content">
                                    <span class="stat-value">{{ $grades->count() }}</span>
                                    <span class="stat-label">Total Students</span>
                                </div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="stat-content">
                                    <span class="stat-value">{{ $grades->where('final_grade', '>=', 75)->count() }}</span>
                                    <span class="stat-label">Passed</span>
                                </div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-times-circle"></i>
                                </div>
                                <div class="stat-content">
                                    <span class="stat-value">{{ $grades->where('final_grade', '<', 75)->count() }}</span>
                                    <span class="stat-label">Failed</span>
                                </div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <div class="stat-content">
                                    <span class="stat-value">{{ number_format($grades->avg('final_grade') ?? 0, 2) }}</span>
                                    <span class="stat-label">Average Grade</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
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
    
    <!-- Hidden logout form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            document.querySelector('.mobile-menu-btn').addEventListener('click', function() {
                document.querySelector('.sidebar').classList.toggle('active');
            });
            
            // Search/Report button functionality
            const searchButton = document.querySelector('.search-button');
            if (searchButton) {
                searchButton.addEventListener('click', function() {
                    const searchBar = document.querySelector('.search-bar');
                    if (searchBar) {
                        const searchValue = searchBar.value;
                        console.log('Searching for:', searchValue);
                        // Implement actual search functionality here
                    } else {
                        console.log('Generate Report button clicked');
                        // This is the "Generate Report" button - implement report generation
                    }
                });
            }

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
    
    <script src="{{ asset('js/logout.js') }}?v={{ time() }}"></script>
</body>
</html>