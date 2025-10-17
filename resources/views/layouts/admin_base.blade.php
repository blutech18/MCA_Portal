<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Admin')</title>
  <link rel="stylesheet" href="{{ asset('css/styles_admin_dashboard.css') }}?v={{ time() }}">
  <link rel="stylesheet" href="{{ asset('css/styles_admin_users.css') }}?v={{ time() }}">
  <link rel="stylesheet" href="{{ asset('css/styles_enrollees.css') }}?v={{ time() }}">
  @stack('head')
  <style>
    html, body { margin: 0; padding: 0; overflow-x: hidden; background: #f8fafc; }
    *, *::before, *::after { box-sizing: border-box; }
    .dashboard-container{display:flex;min-height:100vh}
    .sidebar{width:260px;background:#1f2937;color:#fff;padding:20px 16px}
    .sidebar .logo{width:64px;height:64px;border-radius:8px;margin-bottom:10px}
    .sidebar h2{font-size:18px;margin:6px 0 20px 0}
    .menu ul{list-style:none;margin:0;padding:0}
    .menu a{display:block;color:#cbd5e1;text-decoration:none;padding:10px 12px;border-radius:6px;margin-bottom:6px}
    .menu a.active,.menu a:hover{background:#374151;color:#fff}
    .submenu{margin-left:8px}
    .submenu.hidden{display:none}
    .top-bar{display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1px solid #e5e7eb;background:#fff}
    .main-content{flex:1;background:#f8fafc;display:flex;flex-direction:column;min-width:0}
    .welcome h3{margin:0}
    .user-info{display:flex;align-items:center;gap:12px;position:relative}
    .user-info .icon{width:24px;height:24px;cursor:pointer}
    .dropdown-menu{position:absolute;top:36px;right:0;background:#fff;border:1px solid #e5e7eb;border-radius:8px;box-shadow:0 8px 24px rgba(0,0,0,.08);display:none;min-width:160px;z-index:50}
    .dropdown-item{display:flex;align-items:center;gap:8px;width:100%;background:transparent;border:none;padding:10px 12px;text-align:left;cursor:pointer}
    .dropdown-item:hover{background:#f3f4f6}
  </style>
</head>
<body>
  <div class="dashboard-container">
    <aside class="sidebar">
      <img src="{{ asset('images/schoollogo.png') }}?v={{ time() }}" alt="School Logo" class="logo">
      <h2>MCA Montessori School</h2>
      <nav class="menu">
        <ul>
          <li><a href="{{ route('admin.dashboard') }}" class="{{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}">Dashboard</a></li>
          <li><a href="{{ route('admin.users') }}" class="{{ Route::currentRouteName() == 'admin.users' ? 'active' : '' }}">Users</a></li>
          <li>
            <a href="#" onclick="toggleSubMenu(event)" class="{{ str_starts_with(Route::currentRouteName(), 'admin.instructors') || str_starts_with(Route::currentRouteName(), 'admin.subjects') ? 'active' : '' }}">Instructors ▾</a>
            <ul class="submenu hidden">
              <li><a href="{{ route('admin.instructors') }}" class="{{ Route::currentRouteName() == 'admin.instructors' ? 'active' : '' }}">All Instructors</a></li>
              <li><a href="{{ route('admin.subjects') }}" class="{{ Route::currentRouteName() == 'admin.subjects' ? 'active' : '' }}">Subjects</a></li>
            </ul>
          </li>
          <li><a href="{{ route('admin.classes') }}" class="{{ Route::currentRouteName() == 'admin.classes' ? 'active' : '' }}">Students & Sections</a></li>
          <li><a href="{{ route('sections.index') }}" class="{{ str_starts_with(Route::currentRouteName(), 'sections') ? 'active' : '' }}">Section Management</a></li>
          <li><a href="{{ route('admin.enrollees') }}" class="{{ Route::currentRouteName() == 'admin.enrollees' ? 'active' : '' }}">Enrollees</a></li>
          <li><a href="{{ route('admin.declined.enrollees') }}" class="{{ Route::currentRouteName() == 'admin.declined.enrollees' ? 'active' : '' }}">Declined Enrollees</a></li>
          <li><a href="{{ route('admin.fees') }}" class="{{ str_starts_with(Route::currentRouteName(), 'admin.fees') ? 'active' : '' }}">Fee Management</a></li>
          <li><a href="{{ route('admin.archive') }}" class="{{ Route::currentRouteName() == 'admin.archive' ? 'active' : '' }}">Archive</a></li>
        </ul>
      </nav>
    </aside>
    <main class="main-content">
      <header class="top-bar">
        <div class="welcome">
          <h3>@yield('header', 'Admin Panel')</h3>
        </div>
        <div class="user-info">
          <button type="button" title="Logout" aria-label="Logout" onclick="confirmExit()" style="background:none;border:none;padding:0;cursor:pointer;display:flex;align-items:center;">
            <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
              <path d="M10 3a1 1 0 0 0-1 1v4a1 1 0 1 0 2 0V5h7v14h-7v-3a1 1 0 1 0-2 0v4a1 1 0 0 0 1 1h9a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2h-9z"/>
              <path d="M13.293 8.293a1 1 0 0 1 1.414 0L18 11.586a2 2 0 0 1 0 2.828l-3.293 3.293a1 1 0 1 1-1.414-1.414L15.586 14H4a1 1 0 1 1 0-2h11.586l-2.293-2.293a1 1 0 0 1 0-1.414z"/>
            </svg>
          </button>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
            @csrf
          </form>
        </div>
      </header>
      @yield('content')
    </main>
  </div>

  <script>
    function toggleSubMenu(event){event.preventDefault();const submenu=event.target.nextElementSibling;if(submenu)submenu.classList.toggle('hidden')}
  </script>
  <script src="{{ asset('js/logout.js') }}"></script>
  @stack('scripts')
</body>
</html>


