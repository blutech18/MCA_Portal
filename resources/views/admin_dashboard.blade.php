<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  @vite(['resources/js/app.js', 'resources/css/app.scss'])
  <link rel="stylesheet" href="{{ asset('css/styles_admin_dashboard.css') }}">
</head>
<body>
  <div class="dashboard-container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <img src="{{ asset('images/schoollogo.png') }}" alt="School Logo" class="logo">
      <h2>MCA Montessori School</h2>
      <nav class="menu">
        <ul>
          <li><a href="{{ route('admin.dashboard') }}" class="{{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}">Dashboard</a></li>
          <li><a href="{{ route('admin.users') }}" class="{{ Route::currentRouteName() == 'admin.users' ? 'active' : '' }}">Users</a></li>
          <li>
            <a href="#" onclick="toggleSubMenu(event)">Instructors ▾</a>
            <ul class="submenu hidden">
              <li><a href="{{ route('admin.instructors') }}" class="{{ Route::currentRouteName() == 'admin.instructors' ? 'active' : '' }}">All Instructors</a></li>
              <li><a href="{{ route('admin.subjects') }}" class="{{ Route::currentRouteName() == 'admin.subjects' ? 'active' : '' }}">Subjects</a></li>
              <li><a href="{{ route('admin.courses.index') }}" class="{{ Route::currentRouteName() == 'admin.courses.index' ? 'active' : '' }}">Courses</a></li>
            </ul>
          </li>
          <li><a href="{{ route('admin.classes') }}" class="{{ Route::currentRouteName() == 'admin.classes' ? 'active' : '' }}">Students & Sections</a></li>
          <li><a href="{{ route('admin.enrollees') }}" class="{{ Route::currentRouteName() == 'admin.enrollees' ? 'active' : '' }}">Enrollees</a></li>
        </ul>
        
      </nav>
      
    </aside>

    <!-- Main Content -->
    <main class="main-content">
      <header class="top-bar">
        <div class="welcome">
          <h3>Welcome, Administrator!</h3>
        </div>
        <div class="user-info">
          <img src="{{ asset('images/settings.png') }}" class="icon" id="settingsToggle">
          <div class="dropdown-menu" id="settingsMenu">
            <button class="dropdown-item" onclick="confirmExit()">
              <svg class="dropdown-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M16 13v-2H7V8l-5 4 5 4v-3zM20 3h-8v2h8v14h-8v2h8c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z"/>
              </svg>
              <span>Logout</span>
            </button>
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
              @csrf
            </form>
          </div>
        </div>
      </header>
      

      <!-- Banner -->
      <section class="banner">
        <!-- Student Users -->
        <div class="users-box">
          <div class="subject-box-title">
            <p>Student Users</p>
            <a href="{{ route('admin.users') }}">See more »</a>
          </div>
          <div class="logo-number">
            <img src="{{ asset('images/student_user.png') }}" alt="Students">
            <h2><strong>{{ $studentCount }}</strong></h2>
          </div>
        </div>

        <!-- Instructor Users -->
        <div class="users-box">
          <div class="subject-box-title">
            <p>Instructor Users</p>
            <a href="{{ route('admin.instructors') }}">See more »</a>
          </div>
          <div class="logo-number">
            <img src="{{ asset('images/instructor_user.png') }}" alt="Instructors">
            <h2><strong>{{ $instructorCount }}</strong></h2>
          </div>
        </div>

        <!-- Total Users -->
        <div class="users-box">
          <div class="subject-box-title">
            <p>Total Users</p>
            <a href="{{ route('admin.users') }}">See more »</a>
          </div>
          <div class="logo-number">
            <img src="{{ asset('images/all_user.png') }}" alt="All Users">
            <h2><strong>{{ $totalCount }}</strong></h2>
          </div>
        </div>
        
      </section>

      <!-- Content Sections -->
      <section class="banner-subjects">

        <div class="subjects-box">
          <div class="subject-box-title">
            <h3>All Subjects</h3>
            <a href="{{ route('admin.subjects') }}">See more &gt;&gt;</a>
          </div>
          <div class="subject-g11">
            <table>
              <thead>
                <tr>
                  <th>Subject Code</th>
                  <th>Subject Name</th>
                </tr>
              </thead>
              <tbody>
                @foreach($subjects as $subj)
                  <tr>
                    <td>{{ $subj->code }}</td>
                    <td>{{ $subj->name }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        
        <div class="subjects-box">
          <div class="subject-box-title">
            <h3>All courses</h3>
            <a href="{{ route('admin.courses.index') }}">See more >></a>
          </div>
          <div class="subject-g11">
            <table>
              <thead>
                <tr>
                  <th>Class Name</th>
                  <th>Class Code</th>
                  <th>Subject</th>
                </tr>
              </thead>
              <tbody>
                @foreach($classes as $class)
                  <tr>
                    <td>{{ $class->name }}</td>
                    <td>{{ $class->code }}</td>
                    <td>{{ $class->subject->name ?? 'N/A' }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        
      </section>

      <section class="banner-strands">
        <div class="subjects-box">
          <div class="subject-box-title">
            <p>Junior High Sections</p>
            <a href="{{ route('admin.classes') }}">See more &gt;&gt;</a>
          </div>
          <div class="logo-number">
            <canvas id="juniorChart"></canvas>
          </div>
        </div>
        <div class="subjects-box">
          <div class="subject-box-title">
            <p>Senior High Sections</p>
            <a href="{{ route('admin.classes') }}">See more &gt;&gt;</a>
          </div>
          <div class="logo-number">
            <canvas id="seniorChart"></canvas>
          </div>
        </div>
      </section>

      <div id="confirm-modal" class="modal">
        <div class="modal-content">
            <p>Are you sure you want to log out?</p>
            <button class="confirm-btn" onclick="logout(event)">Yes, Logout</button>
            <button class="cancel-btn" onclick="closeModal()">No</button>
        </div>
      </div>
    </main>
  </div>

  <script>
    const juniorLabels = @json($juniorLabels);
    const juniorData = @json($juniorData);
    const seniorLabels = @json($seniorLabels);
    const seniorData = @json($seniorData);

    console.log("juniorLabels:", juniorLabels);
    console.log("seniorLabels:", seniorLabels);
</script>
  
  <!-- 2) Then load Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1"></script>
  
  <!-- 3) Finally your dashboard script -->
  <script src="{{ asset('js/script_admin_dashboard.js') }}"></script>
  <script src="{{asset('js/logout.js')}}"></script>

</body>
</html>
