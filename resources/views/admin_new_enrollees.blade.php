<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Classes</title>
  <link rel="stylesheet" href="{{ asset('css/style_admin_courses.css') }}">
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
            <li><a href="{{ route('admin.enrollees') }}" class="{{ Route::currentRouteName() == 'admin.enrollees' ? 'active' : '' }}">Enrollees</a></li>
            </ul>
        </nav>
        <a href="#" class="logout">Logout</a>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
          <header class="top-bar">
            <div class="welcome"><h3>Manage Enrollees</h3></div>
            <div class="user-info">
              <img src="{{ asset('images/bell.png') }}" alt="Notifications" class="icon">
              <img src="{{ asset('images/settings.png') }}" alt="Settings" class="icon">
            </div>
          </header>
        
          <div class="container-classes">
            <div class="strand-box">
              <div class="courses-list">
                <h2>Enrollees List</h2>
                <input type="text"
                       id="instructor-search"
                       class="search-bar2"
                       placeholder="Search…">
              </div>
        
              <table class="enrollee-table">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>LRN No.</th>
                    <th>Gender</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Last School</th>
                    <th>Desired Grade</th>
                    <th>Preferred Strand</th>
                    <th colspan="2">Actions</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($enrollees as $e)
                  <tr>
                    <td>{{ $e->last_name }}, {{ $e->first_name }}
                        {{ $e->middle_name }} {{ $e->extension_name }}</td>
                    <td>{{ $e->lrn ?? '–' }}</td>
                    <td>{{ $e->gender }}</td>
                    <td>{{ $e->mobile }}</td>
                    <td>{{ $e->email }}</td>
                    <td>{{ $e->last_school }}</td>
                    <td>{{ $e->desired_grade }}</td>
                    <td>{{ $e->preferred_strand ?? '–' }}</td>
                    <td>
                      <a href="{{ route('admin.enrollees.show', $e) }}"
                         class="btn view-btn">Info</a>
                    </td>
                    <td>
                      <form action="{{ route('admin.enrollees.destroy', $e) }}"
                            method="POST"
                            onsubmit="return confirm('Delete this enrollee?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn delete-btn">Delete</button>
                      </form>
                    </td>
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div>
          </div>
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

    <script src="{{ asset('js/script_admin_course.js') }}"></script>
    

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

</body>
</html>
