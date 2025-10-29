<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCA Montessori School - Schedule More</title>
    <link rel="stylesheet" href="{{ secure_asset('css/ins_class_schedmore.css') }}?v={{ time() }}">
    <link href="https://fonts.cdnfonts.com/css/garet" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css?v=1759179376">
                
    
</head>
<body>
    <div class="container">
        
        <div class="sidebar">
            <div class="logo-container">
                <img src="{{ asset('images/logo.png') }}?v={{ time() }}" alt="MCA Montessori School" class="logo">
                <h2 class="school-name">MCA MONTESSORI SCHOOL</h2>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="{{ route('instructor.dashboard') }}" class="nav-item">DASHBOARD</a></li>
                    <li>
                        <a href="{{ route('instructor.schedmore') }}" class="nav-item active">CLASSES</a>
                        <ul class="sub-menu">
                            <li><a href="{{ route('instructor.schedmore') }}" class="sub-item active">SCHEDULES</a></li>
                            <li><a href="{{ route('instructor.student') }}" class="sub-item">STUDENTS</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ route('instructor.attendance') }}" class="nav-item">ATTENDANCE REPORTS</a></li>
                    <li><a href="{{ route('instructor.report') }}" class="nav-item">GRADE REPORTS</a></li>
                    <li><a href="{{ route('instructor.announcement') }}" class="nav-item">ANNOUNCEMENTS</a></li>
                </ul>
            <div class="logout">
                <a href="#" class="nav-item">LOGOUT</a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <h1>Schedules</h1>
        
            <div class="cards-container">
                <div class="schedule-card">
                  <div id="grade1"></div>
                  <div id="section1"></div>
                  <div id="subject1"></div>
                  <div id="time1"></div>
                </div>
                <div class="schedule-card">
                  <div id="grade2"></div>
                  <div id="section2"></div>
                  <div id="subject2"></div>
                  <div id="time2"></div>
                </div>
                <div class="schedule-card">
                  <div id="grade3"></div>
                  <div id="section3"></div>
                  <div id="subject3"></div>
                  <div id="time3"></div>
                </div>
                <div class="more-link"></div>
            </div>
        
            <div class="schedule-table">
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
                            –{{ \Carbon\Carbon::parse($s->end)->format('h:i A') }}
                          </td>
                          <td>{{ $s->day }}</td>
                          <td>{{ $s->room }}</td>
                        </tr>
                      @empty
                        <tr>
                          <td colspan="7" class="text-center">No schedules for today.</td>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>
                  
            </div>

        </div>

    </div>

    {{-- right before your JS, to verify --}}
    <pre>{{ var_export($schedules->toArray(), true) }}</pre>

    <script>
        // scheduleData now contains exactly those 8 fields per entry
        const scheduleData = @json($schedules);
    </script>


    <script src="{{ secure_asset('js/script_instructor_schedule.js') }}?v={{ time() }}"></script>
    
</body>
</html>
