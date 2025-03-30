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
          <h3> Manage Users</h3>
        </div>
        <div class="user-info">
          <img src="{{ asset('images/bell.png') }}" alt="Notifications" class="icon">
          <img src="{{asset('images/settings.png')}}" class="icon">
        </div>
      </header>

      <div class="container-users">
        <section class="banner-profile">
          <div class="users-box">
            <div class="user-box-title">
              <h2>Profile</h2>
            </div>
            <div class="profile-container">
              <div class="logo-number1">
                <img src="{{ asset('images/me.jpg') }}" alt="Profile Picture">
              </div>
              <div class="profile-info">
                <p><strong>Name:</strong> Krystal Amor</p>
                <p><strong>User Type:</strong> Student</p>
                <p><strong>Email:</strong> email@example.com</p>
                <p><strong>Password:</strong> $2y$12$4xeLgESEifrqt/sy2aecjuOKx6xF0YM0/cOd6yT.9fBP8keIELnL2</p>
                <div class="profile-buttons">
                  <button class="btn edit-btn">Edit</button>
                  <button class="btn delete-btn">Delete</button>
                </div>
              </div>
            </div>
          </div>
        </section>

        <section class="banner">
          <!-- Student Users Box -->
          <div class="users-box2">
            <div class="subject-box-title">
              <p>Student Users</p>
              <a href="#">See more &gt;&gt;</a>
            </div>
            <div class="search-container">
              <input type="text" placeholder="Search students..." class="search-bar">
            </div>
            <div class="table-container">
              <table>
                <thead>
                  <tr>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>Email</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1001</td>
                    <td>Jane Doe</td>
                    <td>jane@example.com</td>
                  </tr>
                  <tr>
                    <td>1002</td>
                    <td>John Smith</td>
                    <td>john@example.com</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        
          <!-- Instructor Users Box -->
          <div class="users-box2">
            <div class="subject-box-title">
              <p>Instructors</p>
              <a href="#">See more &gt;&gt;</a>
            </div>
            <div class="search-container">
              <input type="text" placeholder="Search instructors..." class="search-bar">
            </div>
            <div class="table-container">
              <table>
                <thead>
                  <tr>
                    <th>Instructor ID</th>
                    <th>Instructor Name</th>
                    <th>Email</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>2001</td>
                    <td>Dr. Emily Clark</td>
                    <td>emily@example.com</td>
                  </tr>
                  <tr>
                    <td>2002</td>
                    <td>Mr. Robert Lee</td>
                    <td>robert@example.com</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </section>
        
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

  <script src="{{asset('js/logout.js')}}"></script>
</body>
</html>
