<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="{{ asset('css/styles_admin_users.css') }}">
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
          <li><a href="{{ route('admin.dashboard') }}" class="{{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}">Subjects</a></li>
          <li><a href="{{ route('admin.classes') }}" class="{{ Route::currentRouteName() == 'admin.classes' ? 'active' : '' }}">Sections</a></li>
          <li><a href="{{ route('admin.courses.index') }}" class="{{ Route::currentRouteName() == 'admin.courses.index' ? 'active' : '' }}">Courses</a></li>
          <li><a href="{{ route('admin.enrollees') }}" class="{{ Route::currentRouteName() == 'admin.enrollees' ? 'active' : '' }}">Enrollees</a></li>
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
          <h3> Manage Users</h3>
        </div>
        <div class="user-info">
          <img src="{{ asset('images/bell.png') }}" alt="Notifications" class="icon">
          <img src="{{asset('images/settings.png')}}" class="icon">
        </div>
      </header>

      @yield('content')

    </main>
  </div>

  <script src="{{asset('js/logout.js')}}"></script>

  @stack('scripts')
</body>
</html>
