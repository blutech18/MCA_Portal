<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCA Montessori School - Schedule</title>
    <link rel="stylesheet" href="{{ asset('css/ins_class_sched.css') }}?v={{ time() }}">
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
                        <a href="{{ route('instructor.schedule') }}" class="nav-item active">CLASSES</a>
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
                <h1>CLASS SCHEDULES</h1>
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
          
            <!-- Schedule Content -->
            <div class="content-section">
                <div class="page-header">
                    <h2><i class="fas fa-calendar-alt"></i> Class Schedules</h2>
                    <p>Manage and view your class schedules</p>
                </div>
                
                <div class="schedule-filters">
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
                            <label for="day-select"><i class="fas fa-calendar-day"></i> Select Day:</label>
                            <select id="day-select">
                                <option value="">All Days</option>
                                <option value="Monday">Monday</option>
                                <option value="Tuesday">Tuesday</option>
                                <option value="Wednesday">Wednesday</option>
                                <option value="Thursday">Thursday</option>
                                <option value="Friday">Friday</option>
                                <option value="Saturday">Saturday</option>
                            </select>
                        </div>
                        
                        <button class="search-button"><i class="fas fa-search"></i> Filter Schedule</button>
                    </div>
                </div>
                
                <div class="schedule-table">
                    <div class="table-header">
                        <h3><i class="fas fa-table"></i> Schedule Details</h3>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th><i class="fas fa-calendar-day"></i> Day</th>
                                <th><i class="fas fa-clock"></i> Time</th>
                                <th><i class="fas fa-book"></i> Subject</th>
                                <th><i class="fas fa-chalkboard-teacher"></i> Class</th>
                                <th><i class="fas fa-door-open"></i> Room</th>
                                <th><i class="fas fa-hourglass-half"></i> Duration</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($schedules) && $schedules->count() > 0)
                                @foreach($schedules as $schedule)
                                    <tr>
                                        <td>{{ $schedule->day ?? 'N/A' }}</td>
                                        <td>{{ $schedule->start_time ?? 'N/A' }} - {{ $schedule->end_time ?? 'N/A' }}</td>
                                        <td>{{ $schedule->subject_name ?? 'N/A' }}</td>
                                        <td>{{ $schedule->class_name ?? 'N/A' }}</td>
                                        <td>{{ $schedule->room ?? 'N/A' }}</td>
                                        <td>{{ $schedule->duration ?? 'N/A' }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="no-data">No schedule records found.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                
                @if(isset($schedules) && $schedules->count() > 0)
                    <div class="schedule-summary">
                        <div class="summary-header">
                            <h3><i class="fas fa-chart-bar"></i> Schedule Summary</h3>
                        </div>
                        <div class="summary-stats">
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                </div>
                                <div class="stat-content">
                                    <span class="stat-value">{{ $schedules->count() }}</span>
                                    <span class="stat-label">Total Classes</span>
                                </div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-book"></i>
                                </div>
                                <div class="stat-content">
                                    <span class="stat-value">{{ $schedules->pluck('subject.name')->unique()->count() }}</span>
                                    <span class="stat-label">Subjects</span>
                                </div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="stat-content">
                                    <span class="stat-value">{{ $schedules->pluck('class.name')->unique()->count() }}</span>
                                    <span class="stat-label">Classes</span>
                                </div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="stat-content">
                                    <span class="stat-value">{{ $schedules->sum('duration') ?? 'N/A' }}</span>
                                    <span class="stat-label">Total Hours</span>
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
        // scheduleData now contains exactly those 8 fields per entry
        const scheduleData = @json($schedules ?? []);
    </script>

    <script src="{{ asset('js/logout.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/script_instructor_schedule.js') }}?v={{ time() }}"></script>
</body>
</html>