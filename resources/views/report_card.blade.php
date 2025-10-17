<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Progress Report Card</title>
  <link rel="stylesheet" href="{{ secure_asset('css/styles-report.css') }}?v={{ time() }}">
</head>
<body>
  <div class="dashboard-container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <img src="{{ secure_asset('images/schoollogo.png') }}?v={{ time() }}" alt="School Logo" class="logo">
      <h2>MCA Montessori School</h2>
      <nav class="menu">
        <ul>
          <li><a href="{{ route('student.dashboard') }}">Dashboard</a></li>
          <li><a href="{{ route('grades') }}">View My Grades</a></li>
          <li><a href="{{ route('subjects') }}">Subjects</a></li>
          <li><a href="{{ route('documents') }}">My Documents</a></li>
        </ul>
      </nav>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
      </form>
      <a href="#" class="logout" onclick="confirmExit()">
          Logout
      </a>
    </aside>
    
    <!-- Main Content -->
    <main class="main-content">
      <header class="top-bar">
        <div class="user-info">
          <h3>Progress Report Card</h3>
        </div>
        <div class="profile">
          <img src="{{ secure_asset('images/me.jpg') }}?v={{ time() }}" alt="User" class="user-img">
          <span class="name"><strong> {{ Auth::user()->name }} </strong></span>
          <span class="grade">Grade 12</span>
          <img src="{{ secure_asset('images/bell.png') }}?v={{ time() }}" alt="Notifications" class="icon">
          <img src="{{ secure_asset('images/settings.png') }}?v={{ time() }}" alt="Settings" class="icon">
        </div>
      </header>

      <!-- Report Section -->
      <section class="report-section" id="report-section">
        <div class="academics">
          <h2>Academics</h2>
          <table class="report-table">
            <thead>
              <tr>
                <th>SUBJECTS</th>
                <th>1ST</th>
                <th>2ND</th>
                <th>3RD</th>
                <th>4TH</th>
                <th>FINAL</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($grades as $grade)
                    <tr>
                        <td>{{ $grade->subject }}</td>
                        <td>{{ $grade->first_quarter }}</td>
                        <td>{{ $grade->second_quarter }}</td>
                        <td>{{ $grade->third_quarter }}</td>
                        <td>{{ $grade->fourth_quarter }}</td>
                        <td>{{ $grade->final_grade }}</td>
                    </tr>
                @endforeach
            </tbody>
          </table>
          <a href="#" onclick ="attendanceReport()" class="attendance-link">Click here to view reports on attendance</a>
        </div>

        <div class="core-values">
          <h2>Core Values</h2>
          <div class="core-values-list">
            <div class="core-value-bansa">
              <p>MAKA-BANSA</p>
              <span>VG</span>
            </div>
            <div class="core-value-diyos">
              <p>MAKA-DIYOS</p>
              <span>VG</span>
            </div>
            <div class="core-value-likas">
              <p>MAKA-KALIKASAN</p>
              <span>VG</span>
            </div>
            <div class="core-value-tao">
              <p>MAKATAO</p>
              <span>VG</span>
            </div>
          </div>
        </div>
      </section>

      <section id="report-attendance-section" class="report-attendance-section">
        <div>
          <h2>Attendance Reports</h2>
          <table class="report-attendance-table">
            <thead>
                <tr>
                    <th class = "empty-row"></th>
                    <th>June</th>
                    <th>July</th>
                    <th>August</th>
                    <th>September</th>
                    <th>October</th>
                    <th>November</th>
                    <th>December</th>
                    <th>January</th>
                    <th>February</th>
                    <th>March</th>
                    <th>April</th>
                    <th>May</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>No. of School Days</th>
                    <td>27</td> <td>27</td> <td>25</td> <td>25</td> <td>25</td> <td>20</td> <td>20</td>
                    <td>20</td> <td>20</td> <td>20</td> <td>20</td> <td>20</td> <td>20</td>
                </tr>
                <tr>
                    <th>No. of Days Present</th>
                    <td>20</td> <td>20</td> <td>20</td> <td>20</td> <td>20</td> <td>20</td> <td>20</td>
                    <td>20</td> <td>20</td> <td>20</td> <td>20</td> <td>20</td> <td>20</td>
                </tr>
                <tr>
                    <th>No. of Days Absent</th>
                    <td>2</td> <td>2</td> <td>2</td> <td>2</td> <td>2</td> <td>2</td> <td>2</td>
                    <td>2</td> <td>2</td> <td>2</td> <td>2</td> <td>2</td> <td>2</td>
                </tr>
            </tbody>
        </table>
        <a href="#" onclick ="gradeReport()" class="attendance-link">Click here to view grade reports</a>
        </div>
      </section>

      <!-- Legend Section -->
      <section class="legend" id="legend">
        <h2>Legends</h2>
        <ul>
          <li><strong>100-90:</strong> Excellent</li>
          <li><strong>89-80:</strong> Very Good</li>
          <li><strong>79-75:</strong> Good</li>
          <li><strong>75 BELOW:</strong> Poor</li>
        </ul>
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

  <script src="{{ secure_asset('js/script_student.js') }}?v={{ time() }}"></script>

</body>
</html>

