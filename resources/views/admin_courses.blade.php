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
            <li>
              <a href="#" onclick="toggleSubMenu(event)" class="active">Instructors ▾</a>
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
                <h3>Manage Courses</h3>
                <button class="add-student-btn">+ Add Course</button>
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

            @if (session('success'))
                <div style="background: #d4edda; color: #155724; padding: 10px; border: 1px solid #c3e6cb; margin: 20px 0;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="container-classes">

                <div class="strand-box">
                  <div class = "courses-list">
                    <h2>Courses List</h2> 
                    <input
                      type="text"
                      id="instructor-search"
                      class="search-bar2"
                      placeholder="Search Course…"
                    >
                  </div>
                    <table>
                      <thead>
                          <tr>
                              <th>Class Name</th>
                              <th>Class Code</th>
                              <th>Subject</th>
                              <th>Grade Level</th>
                              <th>Strand</th>
                              <th>Section</th>
                              <th>Room</th>
                              <th>Actions</th> {{-- New Column --}}
                          </tr>
                      </thead>
                      <tbody>
                        @foreach($courses as $course)
                        <tr>
                          <td>{{ $course->name }}</td>
                          <td>{{ $course->code }}</td>
                          <td>{{ $course->subject->name }}</td>
                          <td>{{ $course->gradeLevel->name }}</td>
                          <td>{{ $course->strand ? $course->strand->name : '–' }}</td>
                          <td>{{ $course->section ? $course->section->section_name : '–' }}</td>
                          <td>{{ $course->room }}</td>
                          <td>
                            <button
                              class="edit-btn"
                              data-course='@json($course)'
                            >Edit</button>
                            <form action="{{ route('admin.courses.destroy', $course->id) }}"
                                  method="POST" style="display:inline">
                              @csrf @method('DELETE')
                              <button class="delete-btn" onclick="return confirm('Delete this course?')">
                                Delete
                              </button>
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

    <div id="addCourseModal" class="modal" style="display: none;">
      <div class="modal-content">
        <span class="close-btnn" onclick="closeModal()">&times;</span>
        <h2>Add Course</h2>
        <form id="addCourseForm" method="POST" action="{{ route('admin.courses.store') }}">
          @csrf
    
          <!-- Flex Row Layout: 2 Sections (Side by Side) -->
          <div class="form-row">
            <!-- First Section: Class Details -->
            <div class="form-section">
              <h3>Class Details</h3>
              <div class="form-group">
                <label for="name">Class Name</label>
                <input type="text" id="name" name="name" required>
              </div>
    
              <div class="form-group">
                <label for="code">Class Code</label>
                <input type="text" id="code" name="code">
              </div>
    
              <div class="form-group">
                <label for="subject_id">Subject</label>
                <select id="subject_id" name="subject_id">
                  @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                  @endforeach
                </select>
              </div>
    
              <div class="form-group">
                <label for="grade">Grade Level</label>
                <select id="grade" name="grade_level_id">
                  <option value="">-- Select Grade --</option>
                  @foreach($gradeLevels as $g)
                    <option value="{{ $g->grade_level_id }}" data-grade="{{ $g->name }}">{{ $g->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
    
            <!-- Second Section: Strand and Section -->
            <div class="form-section">
              <h3>Strand and Section</h3>
              <div class="form-group">
                <label for="strand">Strand (if Senior High):</label>
                <select id="strand" name="strand_id" disabled>
                  <option value="">-- Select Strand --</option>
                  @foreach($strands as $s)
                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                  @endforeach
                </select>
              </div>
    
              <div class="form-group">
                <label for="section">Section:</label>
                <select id="section" name="section_id" disabled>
                  <option value="">-- Select Section --</option>
                </select>
              </div>
    
              <div class="form-group">
                <label for="semester">Semester (if Senior High):</label>
                <select id="semester" name="semester" disabled>
                  <option value="">-- Select Semester --</option>
                  <option value="1st">1st</option>
                  <option value="2nd">2nd</option>
                </select>
              </div>
    
              <div class="form-group">
                <label for="room">Room</label>
                <input type="text" id="room" name="room">
              </div>
            </div>
          </div>
    
          <!-- Submit Button -->
          <div class="form-group submit-btn">
            <button type="submit" class="add-btn">Save Course</button>
          </div>
        </form>
      </div>
    </div>

    <div id="editCourseModal" class="modal" style="display: none;">
      <div class="modal-content-edit">
        <span class="close-btn" onclick="closeEditModal()">&times;</span>
        <h2>Edit Course</h2>
        <form id="editCourseForm" method="POST" action="">
          @csrf
          @method('PUT') {{-- This will be updated dynamically with course ID --}}
    
          <input type="hidden" id="edit_course_id">
    
          <div class="form-row">
            <div class="form-section">
              <h3>Class Details</h3>
              <div class="form-group">
                <label for="edit_name">Class Name</label>
                <input type="text" id="edit_name" name="name" required>
              </div>
              <div class="form-group">
                <label for="edit_code">Class Code</label>
                <input type="text" id="edit_code" name="code">
              </div>
              <div class="form-group">
                <label for="edit_subject_id">Subject</label>
                <select id="edit_subject_id" name="subject_id">
                  @foreach($subjects as $subject)
                  <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="edit_grade">Grade Level</label>
                <select id="edit_grade" name="grade_level_id">
                  @foreach($gradeLevels as $g)
                    <option 
                      value="{{ $g->grade_level_id }}" 
                      data-grade="{{ $g->name }}"
                    >{{ $g->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
    
            <div class="form-section">
              <h3>Strand and Section</h3>
              <div class="form-group">
                <label for="edit_strand">Strand</label>
                <select id="edit_strand" name="strand_id">
                  <option value="">-- Select Strand --</option>
                  @foreach($strands as $s)
                  <option value="{{ $s->id }}">{{ $s->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="edit_section">Section</label>
                  <select id="edit_section" name="section_id" disabled>
                  <option value="">-- Select Section --</option>
                  {{-- Will be populated via JS --}}
                </select>
              </div>
              <div class="form-group">
                <label for="edit_semester">Semester</label>
                <select id="edit_semester" name="semester">
                  <option value="">-- Select Semester --</option>
                  <option value="1st">1st</option>
                  <option value="2nd">2nd</option>
                </select>
              </div>
              <div class="form-group">
                <label for="edit_room">Room</label>
                <input type="text" id="edit_room" name="room">
              </div>
            </div>
          </div>
    
          <div class="form-group submit-btn">
            <button type="submit" class="add-btn">Update Course</button>
          </div>
        </form>
      </div>
    </div>

    <div id="confirm-modal" class="modall">
      <div class="modall-content">
          <p>Are you sure you want to log out?</p>
          <button class="confirm-btn" onclick="logout(event)">Yes, Logout</button>
          <button class="cancel-btn" onclick="closeModal()">No</button>
      </div>
    </div>
      
    <script src="{{ asset('js/script_admin_course.js') }}"></script>
    <script src="{{asset('js/logout.js')}}"></script>

    <script>
      function toggleSubMenu(event) {
          event.preventDefault();
          const submenu = event.target.nextElementSibling;
          submenu.classList.toggle('hidden');
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

</body>
</html>
