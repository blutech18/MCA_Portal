<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Progress Report Card</title>
  <link rel="stylesheet" href="{{ asset('css/styles-subjects.css') }}">
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
        <div class="user-info">
          <h3>My Subjects</h3>
        </div>
        <div class="profile">
          <img src="{{asset('images/me.jpg')}}" alt="User" class="user-img">
          <span class="name"><strong> {{ Auth::user()->name }} </strong></span>
          <span class="grade">Grade 12</span>
          <img src="{{asset('images/bell.png')}}" alt="Notifications" class="icon">
          <img src="{{asset('images/settings.png')}}" alt="Settings" class="icon">
        </div>
      </header>

      <!-- Report Section -->
      
      <section class="subjects-section">
        @if ($subjects->isEmpty())
            <p>No subjects available.</p>
        @else
          <div class="subjects-container">
              @foreach ($subjects as $subject)
                  <div class="subject-card">
                      {{-- Display the image if available --}}
                      @if ($subject->image)
                      <img src="{{ asset($subject->image) }}" alt="{{ $subject->subject }}">
                      @endif
                      <h3>{{ $subject->subject }}</h3>
                      <p>{{ $subject->day }} - {{ date('g:i A', strtotime($subject->time)) }}</p>
                      <p>Teacher: {{ $subject->teacher }}</p>
                  </div>
              @endforeach
          </div>
        @endif
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

  <script src="{{asset('js/logout.js')}}"></script>

</body>
</html>

