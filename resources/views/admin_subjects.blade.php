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
          <li><a href="{{ route('admin.classes') }}" class="{{ Route::currentRouteName() == 'admin.classes' ? 'active' : '' }}">Classes</a></li>
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
        <h3>Grade 11 Subjects</h3>
        
        <div class="subject-section">
          <div class="profile-header">STEM Subjects <button class="btn add-subject">Add</button></div>
          <ul class="subject-list">
            <li>Physics 1 <button class="btn edit-btn">Edit</button> <button class="btn delete-btn">Delete</button></li>
            <li>General Mathematics <button class="btn edit-btn">Edit</button> <button class="btn delete-btn">Delete</button></li>
          </ul>
        </div>
        
        <div class="subject-section">
          <div class="profile-header">GAS Subjects <button class="btn add-subject">Add</button></div>
          <ul class="subject-list">
            <li>Oral Communication <button class="btn edit-btn">Edit</button> <button class="btn delete-btn">Delete</button></li>
            <li>21st Century Literature <button class="btn edit-btn">Edit</button> <button class="btn delete-btn">Delete</button></li>
          </ul>
        </div>

        <h3>Grade 12 Subjects</h3>

        <div class="subject-section">
          <div class="profile-header">STEM Subjects <button class="btn add-subject">Add</button></div>
          <ul class="subject-list">
            <li>Physics 2 <button class="btn edit-btn">Edit</button> <button class="btn delete-btn">Delete</button></li>
            <li>Basic Calculus <button class="btn edit-btn">Edit</button> <button class="btn delete-btn">Delete</button></li>
          </ul>
        </div>
        
        <div class="subject-section">
          <div class="profile-header">GAS Subjects <button class="btn add-subject">Add</button></div>
          <ul class="subject-list">
            <li>Reading and Writing <button class="btn edit-btn">Edit</button> <button class="btn delete-btn">Delete</button></li>
            <li>Statistics and Probability <button class="btn edit-btn">Edit</button> <button class="btn delete-btn">Delete</button></li>
          </ul>
        </div>
      </div>
    </main>
  </div>
</body>
</html>
