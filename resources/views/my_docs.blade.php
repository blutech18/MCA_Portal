<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Documents</title>
  <link rel="stylesheet" href="{{ asset('css/styles-docs.css') }}">
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
          <h3>Important Documents</h3>
        </div>
        <div class="profile">
          <img src="{{asset('images/me.jpg')}}" alt="User" class="user-img">
          <span class="name"><strong> {{ Auth::user()->name }} </strong></span>
          <span class="grade">Grade 12</span>
          <img src="{{asset('images/bell.png')}}" alt="Notifications" class="icon">
          <img src="{{asset('images/settings.png')}}" alt="Settings" class="icon">
        </div>
      </header>

      <!-- Document Section -->
      
      <section class="documents-section">
        <div class="docs-container">
            <div class="docs-card">
                <!-- You can conditionally display the image and status -->
                <img src="{{ asset('images/form-138.png') }}" alt="Form 138">
                @php
                    // Retrieve document record for this student and type 'Form 138'
                    $doc = \App\Models\Document::where('user_id', Auth::id())
                                               ->where('document_type', 'Form 138')
                                               ->first();
                @endphp
            
                @if($doc && $doc->submitted_online === 'yes')
                    <p style="color: green;">Submitted (Online)</p>
                @else
                    <p style="color: red;">Missing!</p>
                @endif
            
                <!-- Form to submit document online -->
                <form action="{{ route('documents.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="document_type" value="Form 138">
                    <input type="file" name="document_file" required>
                    <button type="submit">Submit Online</button>
                </form>
            
                @if($doc && $doc->document_file)
                    <a href="{{ route('documents.view', $doc->id) }}">See Document</a>
                @endif
            </div>
            
            <div class="docs-card">
                <img src="{{ asset('images/psa.png') }}" alt="PSA">
                @php
                    // Retrieve document record for this student and type 'Form 138'
                    $doc = \App\Models\Document::where('user_id', Auth::id())
                                               ->where('document_type', 'Form 138')
                                               ->first();
                @endphp
            
                @if($doc && $doc->submitted_online === 'yes')
                    <p style="color: green;">Submitted (Online)</p>
                @else
                    <p style="color: red;">Missing!</p>
                @endif
            
                <!-- Form to submit document online -->
                <form action="{{ route('documents.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="document_type" value="Form 138">
                    <input type="file" name="document_file" required>
                    <button type="submit">Submit Online</button>
                </form>
            
                @if($doc && $doc->document_file)
                    <a href="{{ route('documents.view', $doc->id) }}">See Document</a>
                @endif
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

  <script src="{{asset('js/logout.js')}}"></script>

</body>
</html>

