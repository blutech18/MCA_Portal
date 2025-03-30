<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="{{ asset('css/styles_student_dashboard.css') }}">
</head>
<body>

  <div class="dashboard-container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <img src="{{ asset('images/schoollogo.png') }}" alt="School Logo" class="logo">
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
        <div class="welcome">
          <h3>Welcome, {{ Auth::user()->name }}!</h3>
        </div>
        <div class="user-info">
          <img src="{{asset('images/me.jpg')}}" alt="User" class="user-img">
          <span>{{ Auth::user()->name }}</span>
          <div class="notification">
            <img src="{{ asset('images/bell.png') }}" alt="Notifications" class="icon">
            <!--@if($notificationCount > 0)
                <span class="badge">{{ $notificationCount }}</span>
            @endif!--->
          </div>
          <img src="{{asset('images/settings.png')}}" alt="Settings" class="icon">
        </div>
      </header>

      <!-- Banner -->
      <section class="banner">
        <h1>Enhance Your Skills – Join a Workshop Today!</h1>
        <p>Discover new talents and develop your skills by participating in our exciting workshops. From technology and art to leadership and personal development, there's something for everyone. Start your journey to growth!</p>
        <a href="#" class="cta-button">Sign Up Now →</a>
      </section>

      <!-- Content Sections -->
      <section class="dashboard-section">
        <div class="subjects">
          <h2>My Subjects</h2>
          <a href="#" class="see-all">See All</a>
          <div class="subjects-list">
            <div class="subject">
              <img src="study1.jpg" alt="Subject">
              <p>Subject Name</p>
              <p>Time</p>
            </div>
            <div class="subject">
              <img src="study2.jpg" alt="Subject">
              <p>Subject Name</p>
              <p>Time</p>
            </div>
          </div>
        </div>

        <div class="grades">
          <h2>Grades</h2>
          <a href="#" class="see-all">See All</a>
          <div class="grade-list">
            <div class="grade">
              <p>MATHEMATICS</p>
              <p>90.8</p>
            </div>
            <div class="grade">
              <p>SCIENCE</p>
              <p>88.3</p>
            </div>
            <div class="grade">
              <p>ENGLISH</p>
              <p>95.7</p>
            </div>
            <div class="grade">
              <p>FILIPINO</p>
              <p>79.6</p>
            </div>
          </div>
        </div>
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

  <script src="{{asset('js/script_student.js')}}"></script>
</body>
</html>
