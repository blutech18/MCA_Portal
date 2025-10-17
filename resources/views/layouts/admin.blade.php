<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Classes</title>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
        <img src="{{ secure_asset('images/schoollogo.png') }}?v={{ time() }}" alt="School Logo" class="logo">
        <h2>MCA Montessori School</h2>
        <nav class="menu">
          <ul>
            <li><a href="{{ route('admin.dashboard') }}" class="{{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}">Dashboard</a></li>
            <li><a href="{{ route('admin.users') }}" class="{{ Route::currentRouteName() == 'admin.users' ? 'active' : '' }}">Users</a></li>
            <li>
              <a href="#" onclick="toggleSubMenu(event)">Instructors ▾</a>
              <ul class="submenu hidden">
                <li><a href="{{ route('admin.instructors') }}" class="{{ Route::currentRouteName() == 'admin.instructors' ? 'active' : '' }}">All Instructors</a></li>
                <li><a href="{{ route('admin.subjects') }}" class="{{ Route::currentRouteName() == 'admin.subjects' ? 'activee' : '' }}">Subjects</a></li>
              </ul>
            </li>
            <li><a href="{{ route('admin.classes') }}" class="{{ Route::currentRouteName() == 'admin.classes' ? 'active' : '' }}">Students & Sections</a></li>
            <li><a href="{{ route('admin.enrollees') }}" class="{{ Route::currentRouteName() == 'admin.enrollees' ? 'active' : '' }}">Enrollees</a></li>
            <li><a href="{{ route('admin.declined.enrollees') }}" class="{{ Route::currentRouteName() == 'admin.declined.enrollees' ? 'active' : '' }}">Declined Enrollees</a></li>
            <li><a href="{{ route('admin.archive') }}" class="{{ Route::currentRouteName() == 'admin.archive' ? 'active' : '' }}">Archive</a></li>
          </ul>
        </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
          <header class="top-bar">
            <div class="welcome"><h3>Manage Enrollees</h3></div>
            <div class="user-info">
              <img src="{{ secure_asset('images/bell.png') }}?v={{ time() }}" alt="Notifications" class="icon">
              <img src="{{ secure_asset('images/settings.png') }}?v={{ time() }}" alt="Settings" class="icon">
            </div>
          </header> 
        
          @yield('content')
        </main>
        
    </div>


    <script>
      document.getElementById('instructor-search').addEventListener('keyup', function(){
        const term = this.value.toLowerCase();
        document.querySelectorAll('.enrollee-table tbody tr').forEach(row => {
          row.style.display = row.textContent.toLowerCase().includes(term)
                              ? '' : 'none';
        });
      });
    </script>

    
    
    <script>
      function toggleSubMenu(event) {
          event.preventDefault();
          const submenu = event.target.nextElementSibling;
          submenu.classList.toggle('hidden');
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js?v=1759179376"></script>

</body>
</html>
