<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if($student)
        <meta name="student-id" content="{{ $student->student_id }}">
    @endif
    <title>MCA Montessori School - My Attendance</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        :root {
            --sidebar-color: #5c0017;
            --accent-color: #9B2242;
            --highlight-color: #BC4863;
            --navy-blue: #1D3461;
            --bg-color: #F5F1E8;
            --text-dark: #3A3A3A;
            --text-light: #FFFFFF;
            --text-muted: #666666;
            --success-green: #2E8B57;
            --warning-amber: #D4A76A;
            --danger-red: #DC3545;
            --shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            --border-radius: 10px;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-dark);
            line-height: 1.6;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 280px;
            background-color: var(--sidebar-color);
            color: var(--text-light);
            padding: 20px;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-header h2 {
            font-size: 1.5rem;
            margin-bottom: 5px;
        }

        .sidebar-header p {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .sidebar-nav ul {
            list-style: none;
        }

        .sidebar-nav li {
            margin-bottom: 10px;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: var(--text-light);
            text-decoration: none;
            border-radius: 8px;
            transition: var(--transition);
        }

        .sidebar-nav a:hover,
        .sidebar-nav a.active {
            background-color: var(--accent-color);
            transform: translateX(5px);
        }

        .sidebar-nav i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
        }

        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 30px;
        }

        .page-header {
            background: linear-gradient(135deg, var(--accent-color), var(--highlight-color));
            color: white;
            padding: 30px;
            border-radius: var(--border-radius);
            margin-bottom: 30px;
            box-shadow: var(--shadow);
        }

        .page-header h1 {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .page-header p {
            opacity: 0.9;
            font-size: 1.1rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            text-align: center;
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .stat-card h3 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .stat-card.present h3 { color: var(--success-green); }
        .stat-card.absent h3 { color: var(--danger-red); }
        .stat-card.late h3 { color: var(--warning-amber); }
        .stat-card.rate h3 { color: var(--accent-color); }

        .stat-card p {
            color: var(--text-muted);
            font-weight: 500;
        }

        .filters {
            background: white;
            padding: 20px;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            margin-bottom: 30px;
        }

        .filters h3 {
            margin-bottom: 15px;
            color: var(--text-dark);
        }

        .filter-group {
            display: flex;
            gap: 20px;
            align-items: end;
        }

        .form-group {
            flex: 1;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: var(--text-dark);
        }

        .form-group input {
            width: 100%;
            padding: 10px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--accent-color);
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: var(--transition);
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background-color: var(--accent-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--highlight-color);
        }

        .attendance-table {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .table-header {
            background: var(--accent-color);
            color: white;
            padding: 20px;
        }

        .table-header h3 {
            margin: 0;
            display: flex;
            align-items: center;
        }

        .table-header i {
            margin-right: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }

        th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: var(--text-dark);
        }

        .status {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            text-transform: uppercase;
        }

        .status.present {
            background-color: #d4edda;
            color: #155724;
        }

        .status.absent {
            background-color: #f8d7da;
            color: #721c24;
        }

        .status.late {
            background-color: #fff3cd;
            color: #856404;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: var(--text-muted);
            font-style: italic;
        }

        .loading {
            text-align: center;
            padding: 20px;
            color: var(--text-muted);
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: var(--transition);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
            }

            .filter-group {
                flex-direction: column;
                gap: 15px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>MCA Montessori</h2>
                <p>Student Portal</p>
            </div>
            
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="{{ route('student.dashboard') }}"><i class="fas fa-th-large"></i><span>DASHBOARD</span></a></li>
                    <li><a href="{{ route('student.grades') }}"><i class="fas fa-chart-bar"></i><span>MY GRADES</span></a></li>
                    <li><a href="{{ route('student.attendance') }}" class="active"><i class="fas fa-calendar-check"></i><span>MY ATTENDANCE</span></a></li>
                    <li><a href="{{ route('student.subjects') }}"><i class="fas fa-book"></i><span>SUBJECTS</span></a></li>
                    <li><a href="{{ route('student.documents') }}"><i class="fas fa-file-alt"></i><span>MY DOCUMENTS</span></a></li>
                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i><span>LOGOUT</span></a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="page-header">
                <h1><i class="fas fa-calendar-check"></i> My Attendance</h1>
                <p>Track your daily attendance and punctuality</p>
            </div>

            @if($student)
                <!-- Statistics Cards -->
                <div class="stats-grid">
                    <div class="stat-card present">
                        <h3>{{ $presentDays }}</h3>
                        <p>Present Days</p>
                    </div>
                    <div class="stat-card absent">
                        <h3>{{ $absentDays }}</h3>
                        <p>Absent Days</p>
                    </div>
                    <div class="stat-card late">
                        <h3>{{ $lateDays }}</h3>
                        <p>Late Days</p>
                    </div>
                    <div class="stat-card rate">
                        <h3>{{ $attendanceRate }}%</h3>
                        <p>Attendance Rate</p>
                    </div>
                </div>

                <!-- Filters -->
                <div class="filters">
                    <h3><i class="fas fa-filter"></i> Filter Attendance</h3>
                    <form method="GET" action="{{ route('student.attendance') }}" class="filter-group">
                        <div class="form-group">
                            <label for="date_from">From Date:</label>
                            <input type="date" id="date_from" name="date_from" value="{{ $dateFrom }}">
                        </div>
                        <div class="form-group">
                            <label for="date_to">To Date:</label>
                            <input type="date" id="date_to" name="date_to" value="{{ $dateTo }}">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Filter
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Attendance Table -->
                <div class="attendance-table">
                    <div class="table-header">
                        <h3><i class="fas fa-table"></i> Attendance Records</h3>
                    </div>
                    
                    @if($attendances->count() > 0)
                        <table>
                            <thead>
                                <tr>
                                    <th><i class="fas fa-calendar-day"></i> Date</th>
                                    <th><i class="fas fa-book"></i> Subject</th>
                                    <th><i class="fas fa-info-circle"></i> Status</th>
                                    <th><i class="fas fa-sign-in-alt"></i> Time In</th>
                                    <th><i class="fas fa-sign-out-alt"></i> Time Out</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendances as $attendance)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($attendance->date)->format('M d, Y') }}</td>
                                        <td>{{ $attendance->instructorClass->class->subject->name ?? 'N/A' }}</td>
                                        <td>
                                            <span class="status {{ strtolower($attendance->status ?? 'present') }}">
                                                {{ ucfirst($attendance->status ?? 'Present') }}
                                            </span>
                                        </td>
                                        <td>{{ $attendance->time_in ?? 'N/A' }}</td>
                                        <td>{{ $attendance->time_out ?? 'N/A' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="no-data">
                            <i class="fas fa-calendar-times" style="font-size: 3rem; margin-bottom: 20px; opacity: 0.3;"></i>
                            <p>No attendance records found for the selected date range.</p>
                            <p>Your attendance will appear here once your instructors start marking it.</p>
                        </div>
                    @endif
                </div>
            @else
                <div class="no-data">
                    <i class="fas fa-exclamation-triangle" style="font-size: 3rem; margin-bottom: 20px; color: var(--warning-amber);"></i>
                    <p>Student profile not found. Please contact the administrator.</p>
                </div>
            @endif
        </main>
    </div>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script>
        // Real-time attendance updates
        const studentId = {{ $student->student_id ?? 'null' }};
        
        if (studentId) {
            async function fetchLatestAttendance() {
                try {
                    const response = await fetch(`{{ route('api.student.attendance') }}?student_id=${studentId}`, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                        }
                    });

                    if (response.ok) {
                        const data = await response.json();
                        if (data.success && data.statistics) {
                            updateAttendanceStats(data.statistics);
                            console.log('Attendance updated successfully at:', data.timestamp);
                        }
                    }
                } catch (error) {
                    console.error('Error fetching attendance:', error);
                }
            }

            function updateAttendanceStats(stats) {
                // Update the statistics cards with new data
                const presentCard = document.querySelector('.stat-card.present h3');
                const absentCard = document.querySelector('.stat-card.absent h3');
                const lateCard = document.querySelector('.stat-card.late h3');
                const rateCard = document.querySelector('.stat-card.rate h3');

                if (presentCard) presentCard.textContent = stats.present_days;
                if (absentCard) absentCard.textContent = stats.absent_days;
                if (lateCard) lateCard.textContent = stats.late_days;
                if (rateCard) rateCard.textContent = stats.attendance_rate + '%';
            }

            // Initial fetch and refresh every 30 seconds
            fetchLatestAttendance();
            setInterval(fetchLatestAttendance, 30000);
        }
    </script>
</body>
</html>
