<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCA Montessori School - Students</title>
    <link rel="stylesheet" href="{{ secure_asset('css/styles_instructor_dashboard.css') }}?v={{ time() }}">
    <link href="https://fonts.cdnfonts.com/css/garet" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css?v=1759179376">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo-container">
                <img src="{{ secure_asset('images/logo.png') }}?v={{ time() }}" alt="MCA Montessori School" class="logo">
                <h2 class="school-name">MCA MONTESSORI SCHOOL</h2>
            </div>
            <nav class="sidebar-nav">
                <ul>
                                      <li><a href="{{ route('instructor.dashboard') }}" class="nav-item">DASHBOARD</a></li>
                  <li class="has-submenu active">
                      <a href="#" class="nav-item" onclick="toggleSubmenu(event)">CLASSES</a>
                      <ul class="sub-menu" id="classes-submenu" style="display: block;">
                          <li><a href="{{ route('instructor.schedule') }}" class="sub-item">SCHEDULES</a></li>
                          <li><a href="{{ route('instructor.student') }}" class="sub-item active">STUDENTS</a></li>
                      </ul>
                  </li>
                    <li><a href="{{ route('instructor.attendance') }}" class="nav-item">ATTENDANCE REPORTS</a></li>
                    <li><a href="{{ route('instructor.report') }}" class="nav-item">GRADE REPORTS</a></li>
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
                <h1>STUDENTS</h1>
                <div class="user-actions">
                    <div class="user-profile">
                        <img src="{{ secure_asset('images/instructor_user.png') }}?v={{ time() }}" alt="User Profile" class="profile-pic">
                        <div class="user-info">
                            <p class="user-name">{{ $instructor->short_name }}</p>
                            <p class="user-grade">INSTRUCTOR</p>
                        </div>
                    </div>
                    <div class="icons">
                        <a href="#" class="icon-link"><img src="{{ secure_asset('images/bell.png') }}?v={{ time() }}" alt="Notifications" class="icon"></a>
                        <a href="#" class="icon-link"><img src="{{ secure_asset('images/settings.png') }}?v={{ time() }}" alt="Settings" class="icon"></a>
                    <a href="javascript:void(0)" class="icon-link logout-btn" onclick="confirmExit()" title="Logout">
                        <i class="fas fa-sign-out-alt" style="font-size: 20px; color: #1A2B49;"></i>
                    </a>
                    </div>
                </div>
            </div>
          
            <!-- Students Content -->
            <div class="content-section">
                <div class="page-header">
                    <h2><i class="fas fa-users"></i> Student Management</h2>
                    <p>View and manage your students</p>
                </div>
                
                <div class="students-filters">
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
                            <label for="section-select"><i class="fas fa-layer-group"></i> Select Section:</label>
                            <select id="section-select">
                                <option value="">All Sections</option>
                                @if(isset($sections) && $sections->count() > 0)
                                    @foreach($sections as $section)
                                        <option value="{{ $section->id }}">{{ $section->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label for="student-search"><i class="fas fa-search"></i> Search Students:</label>
                            <input type="text" id="student-search" placeholder="Search by name..." class="search-input">
                        </div>
                        
                        <button class="search-button"><i class="fas fa-filter"></i> Apply Filters</button>
                    </div>
                </div>
                
                <div class="students-table">
                    <div class="table-header">
                        <h3><i class="fas fa-table"></i> Student List</h3>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th><i class="fas fa-id-card"></i> Student ID</th>
                                <th><i class="fas fa-user"></i> Name</th>
                                <th><i class="fas fa-chalkboard-teacher"></i> Class</th>
                                <th><i class="fas fa-layer-group"></i> Section</th>
                                <th><i class="fas fa-graduation-cap"></i> Grade Level</th>
                                <th><i class="fas fa-info-circle"></i> Status</th>
                                <th><i class="fas fa-cogs"></i> Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($students) && $students->count() > 0)
                                @foreach($students as $student)
                                    <tr>
                                        <td>{{ $student->student_id ?? 'N/A' }}</td>
                                        <td>{{ $student->first_name ?? 'N/A' }} {{ $student->last_name ?? 'N/A' }}</td>
                                        <td>{{ $student->class->name ?? 'N/A' }}</td>
                                        <td>{{ $student->section->name ?? 'N/A' }}</td>
                                        <td>{{ $student->grade_level ?? 'N/A' }}</td>
                                        <td>
                                            <span class="status {{ strtolower($student->status ?? 'active') }}">
                                                {{ $student->status ?? 'Active' }}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn-view" onclick="viewStudent({{ $student->id ?? 0 }})"><i class="fas fa-eye"></i> View</button>
                                            <button class="btn-edit" onclick="editStudent({{ $student->id ?? 0 }})"><i class="fas fa-edit"></i> Edit</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="no-data">No students found.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                
                @if(isset($students) && $students->count() > 0)
                    <div class="students-summary">
                        <div class="summary-header">
                            <h3><i class="fas fa-chart-bar"></i> Students Summary</h3>
                        </div>
                        <div class="summary-stats">
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="stat-content">
                                    <span class="stat-value">{{ $students->count() }}</span>
                                    <span class="stat-label">Total Students</span>
                                </div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="stat-content">
                                    <span class="stat-value">{{ $students->where('status', 'Active')->count() }}</span>
                                    <span class="stat-label">Active</span>
                                </div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-times-circle"></i>
                                </div>
                                <div class="stat-content">
                                    <span class="stat-value">{{ $students->where('status', 'Inactive')->count() }}</span>
                                    <span class="stat-label">Inactive</span>
                                </div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                </div>
                                <div class="stat-content">
                                    <span class="stat-value">{{ $students->pluck('class.name')->unique()->count() }}</span>
                                    <span class="stat-label">Classes</span>
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
        // Add basic interactivity
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            document.querySelector('.mobile-menu-btn').addEventListener('click', function() {
                document.querySelector('.sidebar').classList.toggle('active');
            });
            
            // Search functionality
            const searchInput = document.getElementById('student-search');
            const tableRows = document.querySelectorAll('.students-table tbody tr');
            
            searchInput.addEventListener('input', function() {
                const searchTerm = searchInput.value.toLowerCase();
                
                tableRows.forEach(row => {
                    const name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                    if (name.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
            
            // Section filter functionality
            const sectionDropdown = document.getElementById('section-select');
            
            sectionDropdown.addEventListener('change', function() {
                const selectedSection = sectionDropdown.value;
                
                if (selectedSection === '') {
                    tableRows.forEach(row => {
                        row.style.display = '';
                    });
                } else {
                    tableRows.forEach(row => {
                        const section = row.querySelector('td:nth-child(4)').textContent;
                        if (section === selectedSection) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                }
            });
        });
        
        function viewStudent(studentId) {
            // Implement view student functionality
            console.log('Viewing student:', studentId);
        }
        
        function editStudent(studentId) {
            // Implement edit student functionality
            console.log('Editing student:', studentId);
        }
    </script>
    
    <script src="{{ secure_asset('js/logout.js') }}?v={{ time() }}"></script>
</body>
</html>
