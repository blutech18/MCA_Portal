<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCA Montessori School - Instructor Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/styles_instructor_dashboard.css') }}">
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
                  <li><a href="{{ route('instructor.dashboard') }}" class="nav-item active">DASHBOARD</a></li>
                  <li>
                      <a href="{{ route('instructor.schedule') }}" class="nav-item">CLASSES</a>
                      <ul class="sub-menu">
                          <li><a href="{{ route('instructor.schedule') }}" class="sub-item">SCHEDULES</a></li>
                          <li><a href="{{ route('instructor.student') }}" class="sub-item">STUDENTS</a></li>
                      </ul>
                  </li>
                  <li><a href="{{ route('instructor.attendance') }}" class="nav-item">ATTENDANCE REPORTS</a></li>
                  <li><a href="{{ route('instructor.report') }}" class="nav-item">GRADE REPORTS</a></li>
                  <li><a href="{{ route('instructor.announcement') }}" class="nav-item">ANNOUNCEMENTS</a></li>
              </ul>
              <!-- Logout moved to header -->  
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
              <h1>Welcome, {{ $instructor->first_name }}!</h1>
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
          
            <!-- Dashboard Summary -->
            <div class="dashboard-summary">
                {{-- Today’s Schedule --}}
                <div class="summary-card">
                  <h2>Schedule Today</h2>
                  <span class="data-value">{{ $todaySchedules->count() }}</span>
                  <div class="summary-details">
                    <h3><a href="{{ route('instructor.schedule') }}" class = "nav-item">See more</a></h3>
                  </div>
                </div>
                              
                {{-- Total Students --}}
                <div class="summary-card">
                  <h2>My Students</h2>
                  <span class="data-value">{{ $totalStudents }}</span>
                  <div class="summary-details">
                    <h3><a href="{{ route('instructor.student') }}" class = "nav-item">See more</a></h3>
                  </div>
                </div>

            </div>
              
              {{-- Class Sections & their students --}}
              <div class="section">
                <div class="summary-card">
                  <div class="class-section-header">
                    <h3>Class Sections</h3>
                    <div class="summary-details-bottom">
                      <h3><a href="{{ route('instructor.student') }}" class = "nav-item-sub">See more &#11166;</a></h3>
                    </div>
                  </div>
                  
                  <div class="sections-grid">
                    @forelse ($instructor->instructorClasses as $iclass)
                      @php
                        $class = $iclass->class;
                        $section = $class->section;
                        $students = $studentsBySection->get($class->section_id);
                      @endphp
                
                      @if ($section && $students)
                        <div class="section-card">
                          <h4>
                            {{ $class->name }} —
                            {{ $section?->section_name ?? 'No Section Assigned' }}
                          </h4>
                        
                          @if ($students && $students->count())
                            <div class="student-list">
                              @foreach ($students as $student)
                                <span class="student-badge">{{ $student->short_name }}</span>
                              @endforeach
                            </div>
                          @else
                            <p><em>No students in this section.</em></p>
                          @endif
                        </div>
                      
                      @endif
                    @empty
                      <p><em>No assigned classes or sections found.</em></p>
                    @endforelse
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
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            document.querySelector('.mobile-menu-btn').addEventListener('click', function() {
                document.querySelector('.sidebar').classList.toggle('active');
            });
            
            // Search functionality
            document.querySelector('.search-button').addEventListener('click', function() {
                const searchValue = document.querySelector('.search-bar').value;
                console.log('Searching for:', searchValue);
                // Implement actual search functionality here
            });
        });
    </script>
    
    <script src="{{asset('js/logout.js')}}"></script>

</body>
</html>