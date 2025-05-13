<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Subject Management</title>
  <link rel="stylesheet" href="{{ asset('css/style_admin_subjects.css') }}">
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
            <a href="#" onclick="toggleSubMenu(event)" class="active">Instructors ▾</a>
            <ul class="submenu hidden">
              <li><a href="{{ route('admin.instructors') }}" class="{{ Route::currentRouteName() == 'admin.instructors' ? 'active' : '' }}">All Instructors</a></li>
              <li><a href="{{ route('admin.subjects') }}" class="{{ Route::currentRouteName() == 'admin.subjects' ? 'activee' : '' }}">Subjects</a></li>
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
          <h3>Manage Subjects</h3>
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

      <div class="container-subjects">
        <div class="search-bar-container">
          <h3>All Subjects</h3>
          <input
            type="text"
            id="instructor-search"
            class="search-bar2"
            placeholder="Search Subject"
            aria-label="Search Subject"
          >
        </div>
        <div class="subject-section">
          <div class="profile-header">
            <select name="sort" id="sort">
              <option value="">---Sort by---</option>
            </select>
            <!-- Add Subject Button -->
            <button class="btn add-subject" id="add-subject-btn">Add</button>
          </div>

          <!-- Display the existing subjects -->
          <ul class="subject-list">
            @foreach ($subjects as $subject)
              <li>{{ $subject->name }} ({{ $subject->code }}) 
                <form 
                  action="{{ route('admin.subjects.destroy', $subject) }}" 
                  method="POST"
                  style="display:inline"
                  onsubmit="return confirm('Delete this subject?')"
                >
                  @csrf
                  @method('DELETE')
                  <button class="btn delete-btn">Delete</button>
                </form>
              </li>
            @endforeach
          </ul>
          
        </div>
      </div>

      <!-- Overlay -->
      <div id="overlay"></div>

      <!-- Add Subject Form (Hidden by default) -->
      <div id="add-subject-form">
          <button type="button" id="close-modal-btn">&times;</button>
          <form action="{{ route('admin.subjects.store') }}" method="POST">
              @csrf
              <div>
                <label for="code">Subject Code:</label>
                <input type="text" name="code" id="code" required>
            </div>
              <div>
                  <label for="name">Subject Name:</label>
                  <input type="text" name="name" id="name" required>
              </div>
              <button type="submit" class="btn">Add Subject</button>
              <button type="button" id="cancel-btn" class="btn">Cancel</button>
          </form>
      </div>

      <div id="confirm-modal" class="modal">
        <div class="modal-content">
            <p>Are you sure you want to log out?</p>
            <button class="confirm-btn" onclick="logout(event)">Yes, Logout</button>
            <button class="cancel-btn" onclick="closeModal()">No</button>
        </div>
      </div>

    </main>
  </div>

  @if(session('success'))
      <div class="alert alert-success">
          {{ session('success') }}
      </div>
  @endif


  <script>
    function toggleSubMenu(event) {
        event.preventDefault();
        const submenu = event.target.nextElementSibling;
        submenu.classList.toggle('hidden');
      }
  </script>
  <script src="{{ asset('js/script_admin_subjects.js') }}"></script>
  <script src="{{asset('js/logout.js')}}"></script>
</body>
</html>
