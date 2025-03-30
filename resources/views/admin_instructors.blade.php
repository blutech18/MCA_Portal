<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Instructors</title>
  <link rel="stylesheet" href="{{ asset('css/styles_admin_instructors.css') }}">
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
          <h3>Manage Instructors</h3>
        </div>
        <div class="user-info">
          <img src="{{ asset('images/bell.png') }}" alt="Notifications" class="icon">
          <img src="{{ asset('images/settings.png') }}" alt="Settings" class="icon">
        </div>
      </header>

      <div class="container-users">
        <!-- Profile Box Section (Top) -->
        <section class="profile-box">
            <div class="profile-header">
              <h3>Instructor Profile</h3>
              <div class="profile-actions">
                <input type="text" class="search-bar" placeholder="Search Instructor...">
                <button class="btn edit-btn">Edit</button>
                <button class="btn delete-btn">Delete</button>
              </div>
            </div>
            <div class="profile-content">
              <div class="profile-image">
                <img id="profile-pic" src="{{ asset('images/me.jpg') }}" alt="Instructor Profile">
              </div>
              <div class="profile-details">
                <div class="profile-info-grid">
                  <div class="row">
                    <p><span class="label">Full Name:</span> <span id="profile-fullname">Krystal Amor</span></p>
                    <p><span class="label">Address:</span> <span id="profile-address">123 Main St</span></p>
                    <p><span class="label">Employment Status:</span> <span id="profile-status">Active</span></p>
                  </div>
                  <div class="row">
                    <p><span class="label">Email:</span> <span id="profile-email">email@example.com</span></p>
                    <p><span class="label">Date of Birth:</span> <span id="profile-dob">1995-08-15</span></p>
                    <p><span class="label">Hire Date:</span> <span id="profile-hiredate">2015-09-20</span></p>
                  </div>
                  <div class="row">
                    <p><span class="label">Phone Number:</span> <span id="profile-phone">123-456-7890</span></p>
                    <p><span class="label">Gender:</span> <span id="profile-gender">Female</span></p>
                    <p><span class="label">Specialization:</span> <span id="profile-specialization">Science</span></p>
                  </div>
                </div>
                <!-- Additional Action Buttons -->
                <div class="profile-extra-actions">
                  <button class="btn schedule-btn">Work / Schedules</button>
                  <button class="btn classes-btn">Classes</button>
                </div>
              </div>
            </div>
          </section>
          

        <!-- Instructors Table Section (Below Profile Box) -->
        <section class="instructors-table">
          <div class="subject-box-title">
            <p>Instructor List</p>
            <a href="#">Add New Instructor &gt;&gt;</a>
          </div>
          <div class="search-container">
            <input type="text" placeholder="Search instructors..." class="search-bar">
          </div>
          <div class="table-container">
            <table>
              <thead>
                <tr>
                  <th>Full Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Address</th>
                  <th>DOB</th>
                  <th>Gender</th>
                  <th>Status</th>
                  <th>Hire Date</th>
                  <th>Specialization</th>
                </tr>
              </thead>
              <tbody>
                <tr onclick="displayInstructor('Dr. Emily Clark', 'emily@example.com', '123-456-7890', '123 Main St', '1980-05-14', 'Female', 'Active', '2010-08-12', 'Science', '{{ asset('images/emily.jpg') }}')">
                  <td>Dr. Emily Clark</td>
                  <td>emily@example.com</td>
                  <td>123-456-7890</td>
                  <td>123 Main St</td>
                  <td>1980-05-14</td>
                  <td>Female</td>
                  <td>Active</td>
                  <td>2010-08-12</td>
                  <td>Science</td>
                </tr>
                <tr onclick="displayInstructor('Mr. Robert Lee', 'robert@example.com', '987-654-3210', '456 Elm St', '1985-11-22', 'Male', 'Inactive', '2015-09-20', 'Math', '{{ asset('images/robert.jpg') }}')">
                  <td>Mr. Robert Lee</td>
                  <td>robert@example.com</td>
                  <td>987-654-3210</td>
                  <td>456 Elm St</td>
                  <td>1985-11-22</td>
                  <td>Male</td>
                  <td>Inactive</td>
                  <td>2015-09-20</td>
                  <td>Math</td>
                </tr>
                <!-- Additional rows can be added dynamically -->
              </tbody>
            </table>
          </div>
        </section>
      </div>
    </main>
  </div>

  <script>
    function displayInstructor(name, email, phone, address, dob, gender, status, hiredate, specialization, profilePic) {
      document.getElementById("profile-name").textContent = name;
      document.getElementById("profile-email").textContent = email;
      document.getElementById("profile-phone").textContent = phone;
      document.getElementById("profile-address").textContent = address;
      document.getElementById("profile-dob").textContent = dob;
      document.getElementById("profile-gender").textContent = gender;
      document.getElementById("profile-status").textContent = status;
      document.getElementById("profile-hiredate").textContent = hiredate;
      document.getElementById("profile-specialization").textContent = specialization;
      document.getElementById("profile-pic").src = profilePic;
    }
  </script>
</body>
</html>
