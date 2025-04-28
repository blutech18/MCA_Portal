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

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <h1>ATTENDANCE</h1>
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
                
            <div class="controls">
                <form id="filterForm" method="GET" action="{{ route('instructor.attendance') }}">
                  @csrf
                  <!-- Section dropdown -->
                  <select name="class_id" onchange="document.getElementById('filterForm').submit()">
                    @foreach($instructor->instructorClasses as $ic)
                      <option value="{{ $ic->id }}"
                        {{ $ic->id == $iclass->id ? 'selected' : '' }}>
                        {{ $ic->class->name }} — {{ $ic->class->section->section_name }}
                      </option>
                    @endforeach
                  </select>
              
                  <!-- Date picker -->
                  <input type="date" name="date"
                         value="{{ old('date',$date) }}"
                         onchange="document.getElementById('filterForm').submit()">
                </form>
            </div>

            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-icon">                
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                    </div>
                  <div class="stat-info">
                    <h3>Present</h3>
                    <p>{{ $present }}</p>
                  </div>
                </div>
                <div class="stat-card">
                  <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                    </svg>
                  </div>
                  <div class="stat-info">
                    <h3>Absent</h3>
                    <p>{{ $absent }}</p>
                  </div>
                </div>
                <div class="stat-card">
                  <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                  </div>
                  <div class="stat-info">
                    <h3>Late</h3>
                    <p>{{ $late }}</p>
                  </div>
                </div>
                <div class="stat-card">
                  <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                  </div>
                  <div class="stat-info">
                    <h3>Total Classes</h3>
                    <p>{{ $total  }}</p>
                  </div>
                </div>
            </div>
              
            <div class="date-display">
                Today's Date: {{ Carbon\Carbon::now()->format('F j, Y') }}
            </div>
              
            <div class="table-container student-info-container">
                <h2>Class: {{ $iclass->class->name }} — {{ $iclass->class->section->section_name }}</h2>
            </div>
              
            <div class="table-container attendance-container">
                <table class="attendance-table">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($students as $student)
                      @php
                        $att = $existing->get($student->student_id);
                      @endphp
              
                      <form method="POST" action="{{ route('instructor.attendance.mark') }}">
                        @csrf
                        <input type="hidden" name="student_id"          value="{{ $student->student_id }}">
                        <input type="hidden" name="instructor_class_id" value="{{ $iclass->id }}">
                        <input type="hidden" name="date"                 value="{{ $date }}">
              
                        <tr>
                          <td>{{ $student->full_name }}</td>
                          <td>
                            <select name="status" onchange="this.form.submit()">
                              <option value=""    @if(!$att)    selected @endif>—</option>
                              <option value="present" @if($att?->status=='present') selected @endif>P</option>
                              <option value="absent"  @if($att?->status=='absent')  selected @endif>A</option>
                              <option value="late"    @if($att?->status=='late')    selected @endif>L</option>
                            </select>
                          </td>
                        </tr>
                      </form>
                    @endforeach
                  </tbody>
                </table>
            </div>
              
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

    
    <script>
        
        function updateDate() {
            const now = new Date();
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            const formattedDate = now.toLocaleDateString('en-US', options);
            document.getElementById('current-date').textContent = formattedDate;
        }

        
        document.addEventListener('DOMContentLoaded', function() {
            updateDate();
            
            
            document.getElementById('present-count').textContent = '25';
            document.getElementById('absent-count').textContent = '3';
            document.getElementById('late-count').textContent = '2';
            document.getElementById('total-classes').textContent = '45';
            
            
            document.querySelector('.search-button').addEventListener('click', function() {
                const searchValue = document.querySelector('.search-bar').value;
                console.log('Searching for:', searchValue);
            });
            
            
            document.querySelector('.update-button').addEventListener('click', function() {
                alert('Attendance records updated successfully!');
            });
        });
    </script>


</body>
</html>