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
          <li><a href="{{ route('admin.instructors') }}" class="{{ Route::currentRouteName() == 'admin.instructors' ? 'active' : '' }}">Instructors</a></li>
          <li><a href="{{ route('admin.subjects') }}" class="{{ Route::currentRouteName() == 'admin.subjects' ? 'active' : '' }}">Subjects</a></li>
          <li><a href="{{ route('admin.classes') }}" class="{{ Route::currentRouteName() == 'admin.classes' ? 'active' : '' }}">Sections</a></li>
          <li><a href="{{ route('admin.courses.index') }}" class="{{ Route::currentRouteName() == 'admin.courses.index' ? 'active' : '' }}">Courses</a></li>
        </ul>
      </nav>
      <a href="#" class="logout">Logout</a>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
      <header class="top-bar">
        <div class="welcome">
          <h3>Manage Subjects</h3>
        </div>
        <div class="user-info">
          <img src="{{ asset('images/bell.png') }}" alt="Notifications" class="icon">
          <img src="{{ asset('images/settings.png') }}" alt="Settings" class="icon">
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
                <button class="btn edit-btn">Edit</button> 
                <button class="btn delete-btn">Delete</button>
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
                  <label for="name">Subject Name:</label>
                  <input type="text" name="name" id="name" required>
              </div>
              <div>
                  <label for="code">Subject Code:</label>
                  <input type="text" name="code" id="code" required>
              </div>
              <button type="submit" class="btn">Add Subject</button>
              <button type="button" id="cancel-btn" class="btn">Cancel</button>
          </form>
      </div>

    </main>
  </div>

  @if(session('success'))
      <div class="alert alert-success">
          {{ session('success') }}
      </div>
  @endif

  <script src="{{ asset('js/script_admin_subjects.js') }}"></script>
</body>
</html>
