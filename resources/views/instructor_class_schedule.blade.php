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
                <img src="{{ asset('images/logo.png') }}" alt="MCA Montessori School" class="logo">
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
                <div class="logout">
                    <a href="javascript:void(0)" class="nav-item" onclick="confirmExit()">LOGOUT</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>  
            </nav>
            
        </div>

        
        <div class="main-content">
            <div class="header">
                <h1>SCHEDULES</h1>
                <div class="user-actions">
                    <div class="user-profile">
                        <img src="{{ asset('images/instructor_user.png') }}" alt="User Profile" class="profile-pic">
                        <div class="user-info">
                            <p class="user-name">{{ $instructor->first_name }} {{ $instructor->last_name }}</p>
                            <p class="user-grade">INSTRUCTOR</p>
                        </div>
                    </div>
                    <div class="icons">
                        <a href="#" class="icon-link"><img src="{{ asset('images/bell.png') }}" alt="Notifications" class="icon"></a>
                        <a href="#" class="icon-link"><img src="{{ asset('images/settings.png') }}" alt="Settings" class="icon"></a>
                    </div>
                </div>
            </div>

            <div class="date-section">
                <p class="today-date">Today, <span id="current-date">March 29, 2025</span></p>
            </div>

            <div class="schedule-table-today">
                <h2>Today's Schedule</h2>
                <table class="schedule-table">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Subject</th>
                            <th>Grade</th>
                            <th>Section</th>
                            <th>Time</th>
                            <th>Room</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($schedulesToday as $s)
                            <tr>
                                <td>{{ $s->code }}</td>
                                <td>{{ $s->subject }}</td>
                                <td>{{ $s->grade }}</td>
                                <td>{{ $s->section }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($s->start)->format('h:i A') }}
                                    – {{ \Carbon\Carbon::parse($s->end)->format('h:i A') }}
                                </td>
                                <td>{{ $s->room }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No schedules for today.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="schedule-table">
                <h2>All Schedules</h2>
                <table class="schedule-table">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Subject</th>
                            <th>Grade</th>
                            <th>Section</th>
                            <th>Time</th>
                            <th>Day</th>
                            <th>Room</th>
                        </tr>
                    </thead>
                    <tbody id="schedule-body">
                        @forelse($schedules as $s)
                            <tr>
                                <td>{{ $s->code }}</td>
                                <td>{{ $s->subject }}</td>
                                <td>{{ $s->grade }}</td>
                                <td>{{ $s->section }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($s->start)->format('h:i A') }}
                                    – {{ \Carbon\Carbon::parse($s->end)->format('h:i A') }}
                                </td>
                                <td>{{ $s->day }}</td>
                                <td>{{ $s->room }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No schedules available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            

        </div>
    </div>

    <pre>{{ var_export($schedules->toArray(), true) }}</pre>

    <script>
        // scheduleData now contains exactly those 8 fields per entry
        const scheduleData = @json($schedules);
    </script>


    <script src="{{ asset('js/script_instructor_schedule.js') }}"></script>
</body>
</html>