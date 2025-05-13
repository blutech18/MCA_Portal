<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Instructors</title>
  <link rel="stylesheet" href="{{ asset('css/styles_admin_instructors.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
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
                <li><a href="{{ route('admin.instructors') }}" class="{{ Route::currentRouteName() == 'admin.instructors' ? 'activee' : '' }}">All Instructors</a></li>
                <li><a href="{{ route('admin.subjects') }}" class="{{ Route::currentRouteName() == 'admin.subjects' ? 'active' : '' }}">Subjects</a></li>
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
            <h3>Manage Instructors</h3>
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

        <div class="container-users">
          <!-- Profile Box Section (Top) -->
          <section class="profile-box">
            <div class="profile-header">
              <h3>Instructor Profile</h3>
              <div class="profile-actions">
                <button class="btn edit-btn">Edit</button>
              </div>
            </div>
            <div class="profile-content">
              <!--<div class="profile-image">
                <img id="profile-pic" alt="Instructor Profile">
              </div>-->
              <div class="profile-details">
                <div class="profile-info-grid">
                  <div class="row">
                    <p><span class="label">Full Name:</span> <span id="profile-fullname">-------</span></p>
                    <p><span class="label">Address:</span> <span id="profile-address">-------</span></p>
                    <p><span class="label">Employment Status:</span> <span id="profile-status">-----</span></p>
                  </div>
                  <div class="row">
                    <p><span class="label">Email:</span> <span id="profile-email">---------</span></p>
                    <p><span class="label">Date of Birth:</span> <span id="profile-dob">---------</span></p>
                    <p><span class="label">Hire Date:</span> <span id="profile-hiredate">---------</span></p>
                  </div>
                  <div class="row">
                    <p><span class="label">Phone Number:</span> <span id="profile-phone">---------</span></p>
                    <p><span class="label">Gender:</span> <span id="profile-gender">---------</span></p>
                  </div>
                </div>
                <!-- Additional Action Buttons -->
                <div class="profile-extra-actions">
                  <button onclick="triggerScheduleModal()" class="btn schedule-btn">Work / Schedules</button>
                  <button onclick="triggerAssignModal()" class="btn classes-btn">Classes</button>
                </div>
              </div>
            </div>
          </section>
          
          <!-- Instructors Table Section (Below Profile Box) -->
          <section class="instructors-table">
            <div class="subject-box-title">
              <p>Instructor List</p>
              <button class="add-instructor-btn" onclick="triggerAddInstructorModal()">+ Add Instructor</button>
            </div>
          
            <div class="search-container">
              <input
                type="text"
                id="instructor-search"
                class="search-bar2"
                placeholder="Search Instructor…"
              >
            </div>
          
            <div class="table-container">
              <table id="instructor-table">
                <thead>
                  <tr>
                    <th>Instructor ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Hire Date</th>
                  </tr>
                </thead>
                <tbody id="instructor-body">
                  @foreach($instructors as $instr)
                    @php
                      /*$fullname = $instr->first_name . ' ' . ($instr->middle_name ?? '') . ' ' . $instr->last_name . ($instr->suffix ? ', ' . $instr->suffix : '');*/
                      $first = $instr->first_name;
                      $middle= $instr->middle_name;
                      $last  = $instr->last_name;
                      $suf   = $instr->suffix;
                      $schedules = collect($instr->class_payload)
                        ->flatMap(fn($c) => $c['schedules'])
                        ->all();
                      
                    @endphp
                    <tr
                      onclick="populateProfile(this)"
                      data-instructor-id="{{ $instr->instructor_id }}"
                      data-first-name="{{ $first }}"
                      data-middle-name="{{ $middle }}"
                      data-last-name="{{ $last }}"
                      data-suffix="{{ $suf }}"
                      data-instructor-classes='@json($instr->class_payload)'
                      data-schedules='@json($schedules)'
                      data-email="{{ $instr->email }}"
                      data-status="{{ ucfirst($instr->status) }}"
                      data-hiredate="{{ $instr->job_start_date }}"
                      data-dob="{{ $instr->date_of_birth }}"
                      data-address="{{ $instr->address }}"
                      data-phone="{{ $instr->contact_number }}"
                      data-gender="{{ ucfirst($instr->gender) }}"
                      data-picture="{{ $instr->picture ? asset('storage/'.$instr->picture) : asset('images/default.png') }}"
                    >
                      <td>{{ $instr->schoolId->instructor_number }}</td>
                      <td>{{ $instr->first_name }}
                        @if($instr->middle_name) {{ $instr->middle_name }} @endif
                        {{ $instr->last_name }}
                        @if($instr->suffix) , {{ $instr->suffix }} @endif
                      </td>
                      <td>{{ $instr->email }}</td>
                      <td>{{ ucfirst($instr->status) }}</td>
                      <td>{{ \Carbon\Carbon::parse($instr->job_start_date)->toDateString() }}</td>
                    </tr>
                  @endforeach

                </tbody>
              </table>
            </div>
          </section>

        </div>
       
        <!-- Schedule Modal -->
        <div id="schedules-overlay" class="overlay">
          <div class="schedule-form">
            <h3>Assign Work Schedules</h3>

            <div class="instructor-info">
              <strong>Instructor:</strong> <span id="schedule-instructor-name">N/A</span>
            </div>

            <!-- List of existing schedules -->
            <div id="existing-schedules-list" class="assigned-classes">
              <strong>Current Schedules:</strong>
              <ul id="schedule-items">
                <!-- Populated by JavaScript -->
              </ul>
            </div>

            <!-- Form to add schedule -->
            <form id="schedule-form" method="POST" action="/admin/instructors/schedules">
              @csrf
              <input type="hidden" name="instructor_id" id="schedule-instructor-id">

              <div class="form-group">
                <label for="schedule-instructor-class-id">Class</label>
                <select
                  name="instructor_class_id"
                  id="schedule-instructor-class-id"
                  required
                ></select>
              </div>

              <div class="form-group">
                <label for="day_of_week">Day of the Week:</label>
                <select name="day_of_week" id="day_of_week" required>
                  <option value="">Select</option>
                  <option value="Monday">Monday</option>
                  <option value="Tuesday">Tuesday</option>
                  <option value="Wednesday">Wednesday</option>
                  <option value="Thursday">Thursday</option>
                  <option value="Friday">Friday</option>
                </select>
              </div>

              <div class="form-group">
                <label>Start Time:</label>
                <input type="time" name="start_time" required>
              </div>

              <div class="form-group">
                <label>End Time:</label>
                <input type="time" name="end_time" required>
              </div>

              <div class="form-group">
                <label>Room:</label>
                <input type="text" name="room" required>
              </div>

              <div class="button-group">
                <button type="submit" class="btn save-btn">Save Schedule</button>
                <button type="button" class="btn cancel-btn" id="cancel-schedule">Cancel</button>
              </div>
            </form>
          </div>
        </div>
        
        <div id="assign-classes-overlay" class="overlay" style="display:none">
          <div class="assign-classes-form">

            <h3>Assign Classes</h3>

            <div class="instructor-info">
              <strong>Instructor:</strong> <span id="instructor-name-display">N/A</span>
            </div>

            <div class="assigned-classes">
              <strong>Currently Assigned Classes:</strong>
              <ul id="assigned-classes-list">
                <li>None assigned.</li>
              </ul>
            </div>

            <form id="assign-classes-form" method="POST" action="{{ route('instructors.assign.classes') }}">
              @csrf
              <input type="hidden" name="instructor_id" id="modal-instructor-id">
        
              <div class="form-group">
                <label for="class_ids">Select Classes:</label>
                <select id="class_ids" name="class_ids[]" multiple style="width:100%">
                  @foreach(\App\Models\SchoolClass::with(['subject','gradeLevel','strand'])->get() as $course)
                    <option value="{{ $course->id }}">
                      {{ $course->name }} ({{ $course->section_name }} —
                      {{ $course->subject->code }} / {{ $course->gradeLevel->name }}
                      @if($course->strand) / {{ $course->strand->name }} @endif)
                    </option>
                  @endforeach
                </select>
              </div>
        
              <div class="button-group">
                <button type="submit" class="btn save-btn">Save</button>
                <button type="button" class="btn cancel-btn" id="cancel-assign-classes">Cancel</button>
              </div>

            </form>
          </div>
        </div>

        <div id="add-instructor-overlay" class="modal-overlay">
          <div class="modal-content add-instructor-form">
            <button type="button" class="close-btn" id="cancel-add-instructor">×</button>
            <h3>Add Instructor</h3>
            <form action="{{ route('admin_instructors.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
                <div class="student-info-container">
                  <!-- Section 1: Instructor Image & Name -->
                  <div class="section student-image">
                    <!--<img src="" alt="Profile Picture">
                    <button type="button" class="btn-add-picture">Select Image</button>-->

                    <div class="form-group1">
                        <label for="first_name">First Name:</label>
                        <input type="text" id="first_name" name="first_name" autocomplete="given-name">
                    </div>
                    <div class="form-group1">
                        <label for="middle_name">Middle Name:</label>
                        <input type="text" id="middle_name" name="middle_name" autocomplete="additional-name">
                    </div>
                    <div class="lname-suffix">
                        <div class="form-group1">
                            <label for="last_name">Last Name:</label>
                            <input type="text" id="last_name" name="last_name" autocomplete="family-name">
                        </div>
                        <div class="form-group1">
                            <label for="suffix">Suffix:</label>
                            <input type="text" id="suffix" name="suffix" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group1">
                      <label for="instructor_school_number">Instructor ID (School Number):</label>
                      <input type="text" name="instructor_school_number" id="instructor_school_number" class="form-control" required>
                      <small id="id-feedback"></small>
                    </div>

                  </div>

                  <!-- Section 2: Contact and Personal Info -->
                  <div class="section personal-info">

                    <div class="form-group">
                        <label for="email">Email Address:</label>
                        <input type="email" id="email" name="email" autocomplete="email">
                    </div>

                    <div class="form-group">
                        <label for="gender">Gender:</label>
                        <div class="gender-options">
                            <label><input type="radio" name="gender" value="male" required> Male</label>
                            <label><input type="radio" name="gender" value="female" required> Female</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="date_of_birth">Date of Birth:</label>
                        <input type="date" id="date_of_birth" name="date_of_birth" autocomplete="bday">
                    </div>

                    <div class="form-group">
                        <label for="contact_number">Contact No.:</label>
                        <input type="text" id="contact_number" name="contact_number" autocomplete="tel">
                    </div>
                      
                  </div>

                  <!-- Section 3: Employment Info -->
                  <div class="section student-details">
                    <div class="form-group">
                      <label for="address">Address:</label>
                      <input type="text" id="address" name="address" autocomplete="street-address">
                    </div>

                    <div class="form-group">
                        <label for="job_start_date">Job Start Date:</label>
                        <input type="date" id="job_start_date" name="job_start_date">
                    </div>

                    <div class="form-group">
                      <input type="hidden" name="status" value="active">
                    </div>
                  </div>
              </div>
              <button type="submit" class="add-btn">Add</button>
            </form>
          </div>
        </div>

        <div id="editInstructorOverlay" class="modal-overlay" style="display:none;">
          <div class="modal-content edit-instructor-form">
            <button type="button" class="close-btn" id="cancel-edit-instructor">&times;</button>
            <h3>Edit Instructor</h3>
            <form id="editInstructorForm" method="POST" action="">
              @csrf
              @method('PUT')

              {{-- we’ll set this value via JS --}}
              <input type="hidden" name="instructor_id" id="edit_instructor_id">

              <div class="edit-instructor-info-container">
                <div class="edit-info-container">
                  <div class="form-group1">
                    <label for="edit_first_name">First Name:</label>
                    <input type="text" id="edit_first_name" name="first_name" required>
                  </div>
                  <div class="form-group1">
                    <label for="edit_middle_name">Middle Name:</label>
                    <input type="text" id="edit_middle_name" name="middle_name">
                  </div>
                  <div class="form-group1">
                    <label for="edit_last_name">Last Name:</label>
                    <input type="text" id="edit_last_name" name="last_name" required>
                  </div>
                  <div class="form-group1">
                    <label for="edit_suffix">Suffix:</label>
                    <input type="text" id="edit_suffix" name="suffix">
                  </div>
    
                  <div class="form-group">
                    <label for="edit_email">Email:</label>
                    <input type="email" id="edit_email" name="email" required>
                  </div>
                  <div class="form-group">
                    <label for="edit_gender">Gender:</label>
                    <select id="edit_gender" name="gender" required>
                      <option value="male">Male</option>
                      <option value="female">Female</option>
                      <option value="other">Other</option>
                    </select>
                  </div>
                </div>
                <div class="edit-info-container">
                  <div class="form-group">
                    <label for="edit_dob">Date of Birth:</label>
                    <input type="date" id="edit_dob" name="date_of_birth" required>
                  </div>
                  <div class="form-group">
                    <label for="edit_contact">Contact #:</label>
                    <input type="text" id="edit_contact" name="contact_number" required>
                  </div>
                  <div class="form-group">
                    <label for="edit_address">Address:</label>
                    <input type="text" id="edit_address" name="address" required>
                  </div>
                  <div class="form-group">
                    <label for="edit_hiredate">Hire Date:</label>
                    <input type="date" id="edit_hiredate" name="job_start_date" required>
                  </div>
                  <div class="form-group">
                    <label for="edit_status">Status:</label>
                    <select id="edit_status" name="status" required>
                      <option value="active">Active</option>
                      <option value="on leave">On Leave</option>
                      <option value="retired">Retired</option>
                      <option value="terminated">Terminated</option>
                    </select>
                  </div>
                </div>
              </div>
              <button type="submit" class="btn update-btn">Save Changes</button>
            </form>
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
          document.getElementById("accountModal").style.display = "block";
        });
      </script>

      <div id="accountModal" 
          style="display:none;
                  position:fixed;
                  top:20%; left:50%;
                  transform:translate(-50%,-20%);
                  background:#fff; padding:1.5rem;
                  border-radius:8px; box-shadow:0 8px 20px rgba(0,0,0,0.2);
                  z-index:1000;">
        <h3>Instructor Account Created!</h3>
        <p><strong>Username:</strong> {{ request('new_username') }}</p>
        <p><strong>Password:</strong> {{ request('new_password') }}</p>
        <button onclick="document.getElementById('accountModal').style.display='none'">
          Close
        </button>
      </div>
    @endif


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
    <script>
      console.log('Instructor Classes:', @json($instr->instructorClasses));
      function toggleSubMenu(event) {
        event.preventDefault();
        const submenu = event.target.nextElementSibling;
        submenu.classList.toggle('hidden');
      }
    </script>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
      $(function () {
        $('#class_ids').select2({
          closeOnSelect: false,
          placeholder: "Select classes",
          width: '100%'
        });
      });

      window.deleteScheduleUrl = "{{ route('instructors.schedule.delete', ['schedule' => '##ID##']) }}";
      window.updateInstructorUrl = @json(
        route('admin.instructors.update', ['instructor' => '__ID__'])
      );
      console.log("📍 template URL:", window.updateInstructorUrl);
          </script>

    <script src="{{ asset('js/script_admin_instructors.js') }}"></script>
    <script src="{{asset('js/logout.js')}}"></script>
  </body>
</html>
