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
          <li><a href="{{ route('admin.instructors') }}" class="{{ Route::currentRouteName() == 'admin.instructors' ? 'active' : '' }}">Instructors</a></li>
          <li><a href="{{ route('admin.subjects') }}" class="{{ Route::currentRouteName() == 'admin.subjects' ? 'active' : '' }}">Subjects</a></li>
          <li><a href="{{ route('admin.classes') }}" class="{{ Route::currentRouteName() == 'admin.classes' ? 'active' : '' }}">Classes</a></li>
          
        </ul>
      </nav>
      <a href="#" class="logout" onclick="confirmExit()">Logout</a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
      </form>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
      <header class="top-bar">
        <div class="welcome">
          <h3>Welcome, Administrator!</h3>
        </div>
        <div class="user-info">
          <img src="{{ asset('images/bell.png') }}" alt="Notifications" class="icon">
          <img src="{{asset('images/settings.png')}}" class="icon">
        </div>
      </header>
      

      <!-- Banner -->
      <section class="banner">
        <div class="users-box">
          <div class="subject-box-title">
            <p>Student Users:</p>
            <a href="#">See more &gt;&gt;</a>
          </div>
          <div class="logo-number">
            <img src="{{ asset('images/student_user.png') }}" alt="Logo">
            <h2><strong>932</strong></h2>
          </div>
        </div>
        <div class="users-box">
          <div class="subject-box-title">
            <p>Instructor Users:</p>
            <a href="#">See more &gt;&gt;</a>
          </div>
          <div class="logo-number">
            <img src="{{ asset('images/instructor_user.png') }}" alt="Logo">
            <h2><strong>932</strong></h2>
          </div>
        </div>
        <div class="users-box">
          <div class="subject-box-title">
            <p>Total Users:</p>
            <a href="#">See more &gt;&gt;</a>
          </div>
          <div class="logo-number">
            <img src="{{ asset('images/all_user.png') }}" alt="Logo">
            <h2><strong>932</strong></h2>
          </div>
        </div>
        
      </section>

      <!-- Content Sections -->
      <section class="banner-subjects">
        <div class="subjects-box">
          <div class="subject-box-title">
            <h3>Grade 11 Subjects</h3>
            <a href="#">See more &gt;&gt;</a>
          </div>
          <div class="subject-g11">
            <table>
              <thead>
                <tr>
                  <th>Subject Code</th>
                  <th>Subject Name</th>
                  <th>No. of Students Enrolled</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>CS101</td>
                  <td>Introduction to Programming</td>
                  <td>30</td>
                </tr>
                <tr>
                  <td>MATH102</td>
                  <td>Calculus I</td>
                  <td>25</td>
                </tr>
                <tr>
                  <td>ENG103</td>
                  <td>English Composition</td>
                  <td>28</td>
                </tr>
                <tr>
                  <td>PHYS104</td>
                  <td>Physics I</td>
                  <td>22</td>
                </tr>
                <tr>
                  <td>HIST105</td>
                  <td>World History</td>
                  <td>27</td>
                </tr>
                <tr>
                  <td>CHEM106</td>
                  <td>Chemistry</td>
                  <td>20</td>
                </tr>
                <tr>
                  <td>IT107</td>
                  <td>Database Management</td>
                  <td>18</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="subjects-box">
          <div class="subject-box-title">
            <h3>Grade 12 Subjects</h3>
            <a href="#">See more>></a>
          </div>
          <div class="subject-g11">
            <table>
              <thead>
                <tr>
                  <th>Subject Code</th>
                  <th>Subject Name</th>
                  <th>No. of Students Enrolled</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>CS101</td>
                  <td>Introduction to Programming</td>
                  <td>30</td>
                </tr>
                <tr>
                  <td>MATH102</td>
                  <td>Calculus I</td>
                  <td>25</td>
                </tr>
                <tr>
                  <td>ENG103</td>
                  <td>English Composition</td>
                  <td>28</td>
                </tr>
                <tr>
                  <td>PHYS104</td>
                  <td>Physics I</td>
                  <td>22</td>
                </tr>
                <tr>
                  <td>HIST105</td>
                  <td>World History</td>
                  <td>27</td>
                </tr>
                <tr>
                  <td>CHEM106</td>
                  <td>Chemistry</td>
                  <td>20</td>
                </tr>
                <tr>
                  <td>IT107</td>
                  <td>Database Management</td>
                  <td>18</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        
      </section>

      <section class="banner-strands">
        <div class="subjects-box">
          <p>Grade 11 Subjects</p>
          <div class="logo-number">
            <canvas id="strandChart"></canvas>
          </div>
        </div>
        <div class="subjects-box">
          <p>Grade 12 Subjects</p>
          <div class="logo-number">
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
    var strandLabels = @json($labels);
    var strandSections = @json($sections);
    console.log("Labels:", strandLabels, "Sections:", strandSections);
  </script>
  <script src="{{ asset('js/script_admin_dashboard.js') }}"></script>
  <script src="{{asset('js/logout.js')}}"></script>

</body>
</html>
