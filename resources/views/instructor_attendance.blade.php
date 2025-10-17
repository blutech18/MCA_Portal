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
              <img src="{{ asset('images/logo.png') }}" alt="MCA Montessori School" class="logo">
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
                <li><a href="{{ route('instructor.attendance') }}" class="nav-item active">ATTENDANCE REPORTS</a></li>
                <li><a href="{{ route('instructor.attendance.mark.form') }}" class="nav-item">MARK ATTENDANCE</a></li>
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
                <h1>ATTENDANCE REPORTS</h1>
                <div class="user-actions">
                    <div class="user-profile">
                        <img src="{{ asset('images/instructor_user.png') }}" alt="User Profile" class="profile-pic">
                        <div class="user-info">
                            <p class="user-name">{{ $instructor->short_name }}</p>
                            <p class="user-grade">INSTRUCTOR</p>
                        </div>
                    </div>
                    <div class="icons">
                        <a href="#" class="icon-link"><img src="{{ asset('images/bell.png') }}" alt="Notifications" class="icon"></a>
                        <a href="#" class="icon-link"><img src="{{ asset('images/settings.png') }}" alt="Settings" class="icon"></a>
                    <a href="javascript:void(0)" class="icon-link logout-btn" onclick="confirmExit()" title="Logout">
                        <i class="fas fa-sign-out-alt" style="font-size: 20px; color: #1A2B49;"></i>
                    </a>
                    </div>
                </div>
            </div>
          
            <!-- Attendance Content -->
            <div class="content-section">
                <div class="page-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <h2><i class="fas fa-clipboard-check"></i> Attendance Reports</h2>
                            <p>Track and manage student attendance</p>
                            @if(isset($attendances) && $attendances->count() > 0)
                                <p style="color: #666; font-size: 12px;">Showing {{ $attendances->count() }} attendance records</p>
                            @endif
                        </div>
                        <div>
                            <a href="{{ route('instructor.attendance.mark.form') }}" class="btn" style="background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: 600;">
                                <i class="fas fa-plus"></i> Mark Attendance
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="attendance-filters">
                    <div class="filters-container">
                        <form method="GET" action="{{ route('instructor.attendance') }}" class="filters-form">
                            <div class="filter-group">
                                <label for="class-select"><i class="fas fa-chalkboard-teacher"></i> Select Class:</label>
                                <select id="class-select" name="class_id">
                                    <option value="">All Classes</option>
                                    @if(isset($classes) && count($classes) > 0)
                                        @foreach($classes as $class)
                                            <option value="{{ $class['id'] }}" {{ $selectedClassId == $class['id'] ? 'selected' : '' }}>
                                                {{ $class['name'] }} - {{ $class['section'] }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            
                            <div class="filter-group">
                                <label for="date-range"><i class="fas fa-calendar-alt"></i> Date Range:</label>
                                <div class="date-range">
                                    <input type="date" id="date-from" name="date_from" value="{{ $dateFrom }}">
                                    <span>to</span>
                                    <input type="date" id="date-to" name="date_to" value="{{ $dateTo }}">
                                </div>
                            </div>
                            
                            <button type="submit" class="search-button"><i class="fas fa-search"></i> Search</button>
                        </form>
                    </div>
                </div>
                
                <div class="attendance-table">
                    <div class="table-header">
                        <h3><i class="fas fa-table"></i> Attendance Records</h3>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th><i class="fas fa-user"></i> Student Name</th>
                                <th><i class="fas fa-chalkboard-teacher"></i> Class</th>
                                <th><i class="fas fa-calendar-day"></i> Date</th>
                                <th><i class="fas fa-info-circle"></i> Status</th>
                                <th><i class="fas fa-sign-in-alt"></i> Time In</th>
                                <th><i class="fas fa-sign-out-alt"></i> Time Out</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($attendances) && $attendances->count() > 0)
                                @foreach($attendances as $attendance)
                                    <tr>
                                        <td>
                                            @if($attendance->student)
                                                {{ $attendance->student->first_name }} {{ $attendance->student->last_name }}
                                            @else
                                                <span style="color: red;">Student not found (ID: {{ $attendance->student_id }})</span>
                                            @endif
                                        </td>
                                        <td>{{ $attendance->instructorClass->class->name ?? 'N/A' }}</td>
                                        <td>{{ $attendance->date ? \Carbon\Carbon::parse($attendance->date)->format('M d, Y') : 'N/A' }}</td>
                                        <td>
                                            <span class="status {{ strtolower($attendance->status ?? 'present') }}">
                                                {{ ucfirst($attendance->status ?? 'Present') }}
                                            </span>
                                        </td>
                                        <td>{{ $attendance->time_in ?? 'N/A' }}</td>
                                        <td>{{ $attendance->time_out ?? 'N/A' }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="no-data">No attendance records found for the selected criteria.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                
                @if(isset($attendances) && $attendances->count() > 0)
                    <div class="attendance-summary">
                        <div class="summary-header">
                            <h3><i class="fas fa-chart-bar"></i> Attendance Summary</h3>
                        </div>
                        <div class="summary-stats">
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-clipboard-list"></i>
                                </div>
                                <div class="stat-content">
                                    <span class="stat-value">{{ $totalRecords }}</span>
                                    <span class="stat-label">Total Records</span>
                                </div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="stat-content">
                                    <span class="stat-value">{{ $presentCount }}</span>
                                    <span class="stat-label">Present</span>
                                </div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-times-circle"></i>
                                </div>
                                <div class="stat-content">
                                    <span class="stat-value">{{ $absentCount }}</span>
                                    <span class="stat-label">Absent</span>
                                </div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="stat-content">
                                    <span class="stat-value">{{ $lateCount }}</span>
                                    <span class="stat-label">Late</span>
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
            const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
            if (mobileMenuBtn) {
                mobileMenuBtn.addEventListener('click', function() {
                    document.querySelector('.sidebar').classList.toggle('active');
                });
            }
            
            // Auto-submit form when filters change
            const classSelect = document.getElementById('class-select');
            const dateFrom = document.getElementById('date-from');
            const dateTo = document.getElementById('date-to');
            
            if (classSelect) {
                classSelect.addEventListener('change', function() {
                    this.form.submit();
                });
            }
            
            if (dateFrom) {
                dateFrom.addEventListener('change', function() {
                    this.form.submit();
                });
            }
            
            if (dateTo) {
                dateTo.addEventListener('change', function() {
                    this.form.submit();
                });
            }
        });
    </script>

    <script src="{{ asset('js/logout.js') }}"></script>
</body>
</html>