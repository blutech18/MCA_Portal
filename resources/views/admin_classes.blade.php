<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Classes</title>
  <link rel="stylesheet" href="{{ asset('css/style_admin_classes.css') }}">
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
            <li>
              <a href="#" onclick="toggleSubMenu(event)">Instructors ▾</a>
              <ul class="submenu hidden">
                <li><a href="{{ route('admin.instructors') }}" class="{{ Route::currentRouteName() == 'admin.instructors' ? 'active' : '' }}">All Instructors</a></li>
                <li><a href="{{ route('admin.subjects') }}" class="{{ Route::currentRouteName() == 'admin.subjects' ? 'activee' : '' }}">Subjects</a></li>
                <li><a href="{{ route('admin.courses.index') }}" class="{{ Route::currentRouteName() == 'admin.courses.index' ? 'active' : '' }}">Courses</a></li>
              </ul>
            </li>
            <li><a href="{{ route('admin.classes') }}" class="{{ Route::currentRouteName() == 'admin.classes' ? 'active' : '' }}">Students & Sections</a></li>
            <li><a href="{{ route('admin.enrollees') }}" class="{{ Route::currentRouteName() == 'admin.enrollees' ? 'active' : '' }}">Enrollees</a></li>
          </ul>
        </nav>
      </aside>

      <!-- Main Content -->
      <main class="main-content">
          <header class="top-bar">
              <div class="welcome">
              <h3>Manage Sections</h3>
              <div class section>
                <button class="add-student-btn">+ Add Student</button>
                <button class="add-section-btn">+ Add Section</button>
              </div>
              </div>
              <div class="user-info">
                <img src="{{ asset('images/settings.png') }}" class="icon" id="settingsToggle">
                <div class="dropdown-menu" id="settingsMenu">
                  <button class="dropdown-item" onclick="confirmExit()">
                    <svg class="dropdown-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                      <path d="M16 13v-2H7V8l-5 4 5 4v-3zM20 3h-8v2h8v14h-8v2h8c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z"/>
                    </svg>
                    <span>Logout</span>
                  </button>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                  </form>
                </div>
              </div>
          </header>

          <div class="content-container">

            <div class="sort-and-search">
              <div class="reset-enrollment">
                @php

                  $now = now(); // or Carbon::now()

                  if ($now->month >= 1 && $now->month <= 5) {
                      // January to May
                      $startYear = $now->year - 1;
                      $endYear = $now->year;
                  } else {
                      // June to December
                      $startYear = $now->year;
                      $endYear = $now->year + 1;
                  }

                  $schoolYear = "$startYear-$endYear";
                @endphp
               
                <h3>Enrollment Status Update for School Year: {{$schoolYear}} </h3>
              </div>
              <div class="reset-enrollment">
                <form action="{{ route('admin.students.resetEnrollment') }}" method="POST" onsubmit="return confirm('Are you sure you want to reset all student enrollment statuses?');">
                  @csrf
                  <button type="submit" class="btn btn-danger">Reset All to Not Enrolled</button>
                </form>
              </div>
            </div>

            <div class="sort-and-search1">
              <div class="sort-options">
                <label for="sort">Display Grade:</label>
                <select id="sort" name="sort">
                  <option value="">-- Select Grade --</option>
                  <option value="7">Grade 7</option>
                  <option value="8">Grade 8</option>
                  <option value="9">Grade 9</option>
                  <option value="10">Grade 10</option>
                  <option value="11">Grade 11</option>
                  <option value="12">Grade 12</option>
                </select>
              </div>

              <div class="search-bar">
                <input type="text" id="search" placeholder="Search student">
              </div>
            </div>
            

            <!-- only one container now! -->
            <div class="container-classes">
              @foreach($student_section as $section)
                <div
                  class="strand-box"
                  data-grade="{{ $section->gradeLevel->name }}"  {{-- THIS must be "7", "8", ... --}}
                >
                  @if(is_null($section->strand_id))
                    <h2>Grade {{ $section->gradeLevel->name }}</h2>
                    <h3>Section {{ $section->section_name }}</h3>
                  @else
                    <h2>Grade {{ $section->gradeLevel->name }}</h2>
                    <h3>
                      {{ $section->strand->name }} – Section {{ $section->section_name }}
                    </h3>
                  @endif
            
                  <table>
                    <thead>
                      <tr>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Date Enrolled</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php
                        $sectionStudents = $students->filter(fn($stu) =>
                          $stu->section_id == $section->id
                          && (is_null($section->strand_id)
                              ? is_null($stu->strand_id)
                              : $stu->strand_id == $section->strand_id
                            )
                        );
                      @endphp
            
                      @forelse($sectionStudents as $stu)
                        <tr>
                          <td>{{ optional($stu->studentId)->student_number ?? '—' }}</td>
                          <td>{{ $stu->full_name }}</td>
                          <td>{{ $stu->email }}</td>
                          <td>
                            @if($stu->is_enrolled)
                              <span class="text-green-600 font-semibold">Enrolled</span>
                            @else
                              <span class="text-red-600 font-semibold">Not Enrolled</span>
                            @endif
                          </td>
                          <td>{{ $stu->created_at->toDateString() }}</td>
                          <td>
                            
                            @if(! $stu->is_enrolled)
                              <form action="{{ route('admin.approveStudent', $stu->student_id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success">Approve</button>
                              </form>
                            @else
                              <button class="btn edit-btn">Edit</button>
                            @endif
                          </td>
                        </tr>
                      @empty
                        <tr><td colspan="6">No students found for this section.</td></tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              @endforeach
            </div>
            
            <form action="{{ route('admin_classes.student') }}" method="POST" enctype="multipart/form-data">
                @csrf

                @php $en = $enrollee ?? null; @endphp
                <div class="overlay" style="display: none;">
                    <div class="add-student-form">
                      <h3>Add Student</h3>
                      <div class="student-info-container">
                        <!-- Section 1: Student Image -->
                        <div class="section student-image">
                          <img 
                            id="student-photo"
                            src="{{ asset('images/student_user.png') }}"
                            alt="Profile Picture"
                          >
                          <button type="button" class="btn-add-picture">Select image</button>
    
                          <div class="form-group1">
                            <label for="student_school_id">ID:</label>
                               <input
                                  type="text"
                                  id="student_school_id"
                                  name="student_school_id"
                                  value="{{ old('student_school_id', optional($en)->application_number) }}"
                                  autocomplete="off"
                                >
                          </div>

                          <div class="form-group1">
                            <label for="fname">First Name:</label>
                            <input
                              type="text"
                              id="fname"
                              name="fname"
                              value="{{ old('fname', optional($en)->given_name) }}"
                            >
                          </div>
                          <div class="form-group1">
                            <label for="mname">Middle Name:</label>
                            <input type="text" 
                                    id="mname" 
                                    name="mname"
                                    
                                    autocomplete="mname">
                          </div>
                          <div class="lname-suffix">
                            <div class="form-group1">
                              <label for="lname">Last Name:</label>
                              <input 
                                type="text" 
                                id="lname" 
                                name="lname"
                                value="{{ old('lname', optional($en)->surname) }}"
                              >
                            </div>
                            <div class="form-group1">
                              <label for="suffix">Suffix:</label>
                              <input type="text" id="suffix" name="suffix" autocomplete="off">
                            </div>
                          </div>
                          
                        </div>
                        <!-- Section 2: Personal Info -->
                        <div class="section personal-info">
  
                          <div class="form-group">
                            <label for="email">Email Address:</label>
                            <input 
                              type="text" 
                              id="email" 
                              name="email" 
                              value="{{ old('email', optional($en)->email) }}" 
                              autocomplete="off">
                          </div>
                          
                          <div class="form-group">
                            <label for="gender">Gender:</label>
                            <div class="gender-options">
                                <label>
                                  <input type="radio" name="gender" value="Male" required>
                                  Male
                                </label>
                                <label>
                                  <input type="radio" name="gender" value="Female" required>
                                  Female
                                </label>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="dob">Date of Birth:</label>
                            <input type="date" id="dob" name="dob" autocomplete="off">
                          </div>
    
                          <div class="form-group">
                            <label for="contact">Contact No.:</label>
                            <input type="text" id="contact" name="contact" autocomplete="off">
                          </div>
                          
                          <div class="form-group">
                            <label for="address">Address:</label>
                            <input type="text" id="address" name="address" autocomplete="off">
                          </div>
                          
                        </div>
                        <!-- Section 3: Student Info -->
                        <div class="section student-details">
                            <div class="form-group">
                                <label for="grade">Grade:</label>
                                <select id="grade" name="grade_level_id">
                                    <option value="">-- Select Grade --</option>
                                    @foreach($gradeLevels as $g)
                                      <option
                                        value="{{ $g->grade_level_id }}"
                                        data-grade="{{ $g->name }}"
                                      >{{ $g->name }}</option>
                                    @endforeach
                                </select>
                                  
                            </div>
    
                          <div class="form-group">
                            <label for="strand">Strand (if Senior High):</label>
                            <select id="strand"   name="strand_id" disabled>
                                <option value="">-- Select Strand --</option>
                                @foreach($allStrands as $s)
                                  <option value="{{ $s->id }}">{{ $s->name }}</option>
                                @endforeach
                              </select>
                          </div>
                          <div class="form-group">
                            <label for="section">Section:</label>
                            <select id="section"  name="section_id" disabled>
                                <option value="">-- Select Section --</option>
                                <!-- filled by JS -->
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="status">Status:</label>
                            <select id="status" name="status_id">
                                <option value="">-- Select status --</option>
                                @foreach($student_status as $status)
                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                @endforeach
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="date_enrolled">Date Enrolled:</label>
                            <input type="date" id="date_enrolled" name="date_enrolled" autocomplete="off">
                          </div>
                          <div class="form-group">
                            <label for="semester">Semester (if Senior High):</label>
                            <select id="semester" name="semester" disabled>
                                <option value="">-- Select Semester --</option>
                                <option value="1st">1st</option>
                                <option value="2nd">2nd</option>
                              </select>
                          </div>
                        </div>
                      </div>
                      <button type="submit" class="add-btn">Add</button>
                    </div>
                </div>
            </form>

            <div class="overlay-section" style="display: none;">
              <div class="add-section-form">
                <h3>Add Section</h3>
                <form action="{{ route('admin_classes.section.store') }}" method="POST">
                  @csrf
                  <div class="form-group">
                    <label for="grade_level">Grade Level:</label>
                    <select id="section-grade-level" name="grade_level_id" required>
                      <option value="">-- Select Grade Level --</option>
                      @foreach($gradeLevels as $g)
                        <option value="{{ $g->grade_level_id }}" data-name="{{ $g->name }}">{{ $g->name }}</option>
                      @endforeach
                    </select>
                  </div>
            
                  <div class="form-group" id="strand-group" style="display: none;">
                    <label for="strand">Strand (For Senior High):</label>
                    <select name="strand_id" id="section-strand">
                      <option value="">-- Select Strand --</option>
                      @foreach($allStrands as $s)
                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                      @endforeach
                    </select>
                  </div>
            
                  <div class="form-group">
                    <label for="section_name">Section Name:</label>
                    <input type="text" name="section_name" required>
                  </div>
            
                  <button type="submit" class="add-to-section-btn">Add Section</button>
                </form>
              </div>
            </div>
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

    @if(request('new_username') && request('new_password'))
      <script>
          document.addEventListener("DOMContentLoaded", function () {
              const modal = document.getElementById("accountModal");
              if (modal) {
                  modal.style.display = "block";
              }
          });
      </script>

      <div id="accountModal" style="display:none; position:fixed; top:20%; left:50%; transform:translate(-50%, -20%);
          background:#fff; padding:20px; border:1px solid #ccc; border-radius:10px; box-shadow:0 0 15px rgba(0,0,0,0.3); z-index:1000;">
          <h3>Student Account Created</h3>
          <p><strong>Username:</strong> {{ request('new_username') }}</p>
          <p><strong>Password:</strong> {{ request('new_password') }}</p>
          <button onclick="document.getElementById('accountModal').style.display='none';">Close</button>
      </div>
    @endif

    <script>
      window.enrolleeApiBase = "{{ url('admin/api/enrollee') }}";
    </script>
    <script src="{{ asset('js/script_admin_sections.js') }}"></script>
    @if(session('success'))
        <script>
            alert('{{ session('success') }}');
        </script>
    @endif

    <script>
      function toggleSubMenu(event) {
          event.preventDefault();
          const submenu = event.target.nextElementSibling;
          submenu.classList.toggle('hidden');
        }
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{asset('js/logout.js')}}"></script>
</body>
</html>
