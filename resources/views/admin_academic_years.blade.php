<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Academic Years</title>
  <link rel="stylesheet" href="{{ asset('css/styles_admin_archive.css') }}">
  <link rel="stylesheet" href="{{ asset('css/styles_admin_dashboard.css') }}">
  <link rel="stylesheet" href="{{ asset('css/styles_academic_years.css') }}">
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
            <a href="#" onclick="toggleSubMenu(event)">Instructors ▾</a>
            <ul class="submenu hidden">
              <li><a href="{{ route('admin.instructors') }}" class="{{ Route::currentRouteName() == 'admin.instructors' ? 'active' : '' }}">All Instructors</a></li>
              <li><a href="{{ route('admin.subjects') }}" class="{{ Route::currentRouteName() == 'admin.subjects' ? 'active' : '' }}">Subjects</a></li>
            </ul>
          </li>
          <li><a href="{{ route('admin.classes') }}" class="{{ Route::currentRouteName() == 'admin.classes' ? 'active' : '' }}">Students & Sections</a></li>
          <li><a href="{{ route('admin.enrollees') }}" class="{{ Route::currentRouteName() == 'admin.enrollees' ? 'active' : '' }}">Enrollees</a></li>
          <li><a href="{{ route('admin.declined.enrollees') }}" class="{{ Route::currentRouteName() == 'admin.declined.enrollees' ? 'active' : '' }}">Declined Enrollees</a></li>
          <li><a href="{{ route('admin.archive') }}" class="{{ Route::currentRouteName() == 'admin.archive' ? 'active' : '' }}">Archive</a></li>
        </ul>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
      <header class="top-bar">
        <div class="welcome">
          <h3>Academic Year Management</h3>
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

      <div class="container-archive">
        <!-- Success/Error Messages -->
        @if(session('success'))
          <div class="alert alert-success">
            <span class="alert-icon">✅</span>
            <span class="alert-message">{{ session('success') }}</span>
            <button class="alert-close" onclick="this.parentElement.remove()">&times;</button>
          </div>
        @endif
        
        @if(session('error'))
          <div class="alert alert-error">
            <span class="alert-icon">❌</span>
            <span class="alert-message">{{ session('error') }}</span>
            <button class="alert-close" onclick="this.parentElement.remove()">&times;</button>
          </div>
        @endif

        @if(isset($errors) && $errors->any())
          <div class="alert alert-error">
            <span class="alert-icon">❌</span>
            <div class="alert-message">
              <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            <button class="alert-close" onclick="this.parentElement.remove()">&times;</button>
          </div>
        @endif

        <!-- Navigation -->
        <section class="archive-controls">
          <div class="year-selector">
            <a href="{{ route('admin.archive') }}" class="btn btn-outline">← Back to Archive</a>
          </div>
          <div class="archive-actions">
            <button class="btn btn-primary" onclick="openAddYearModal()">
              ➕ Add New Academic Year
            </button>
          </div>
        </section>

        <!-- Current Academic Year -->
        @if($currentAcademicYear)
          <section class="current-year-section">
            <div class="current-year-card">
              <div class="current-year-header">
                <h4>Current Academic Year</h4>
                <span class="current-badge">Active</span>
              </div>
              <div class="current-year-info">
                <div class="year-details">
                  <h3>{{ $currentAcademicYear->year_name }}</h3>
                  <p><strong>Duration:</strong> {{ $currentAcademicYear->start_date->format('M d, Y') }} - {{ $currentAcademicYear->end_date->format('M d, Y') }}</p>
                  <p><strong>Days Remaining:</strong> {{ max(0, $currentAcademicYear->end_date->diffInDays(now())) }} days</p>
                </div>
                <div class="year-actions">
                  <button class="btn btn-outline btn-sm" onclick="editAcademicYear({{ $currentAcademicYear->id }})">
                    ✏️ Edit
                  </button>
                </div>
              </div>
            </div>
          </section>
        @endif

        <!-- Academic Years List -->
        <section class="academic-years-section">
          <div class="section-header">
            <h4>All Academic Years</h4>
            <p>Manage academic year settings and transitions</p>
          </div>

          @if($academicYears->count() > 0)
            <div class="table-container">
              <table id="academic-years-table">
                <thead>
                  <tr>
                    <th>Academic Year</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Duration</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($academicYears as $year)
                    <tr class="{{ $year->is_current ? 'current-row' : '' }}">
                      <td>
                        <div class="year-info">
                          <strong>{{ $year->year_name }}</strong>
                          @if($year->is_current)
                            <span class="current-badge">Current</span>
                          @endif
                        </div>
                      </td>
                      <td>{{ $year->start_date->format('M d, Y') }}</td>
                      <td>{{ $year->end_date->format('M d, Y') }}</td>
                      <td>{{ $year->start_date->diffInDays($year->end_date) }} days</td>
                      <td>
                        @if($year->is_current)
                          <span class="status-badge active">Active</span>
                        @else
                          <span class="status-badge inactive">Inactive</span>
                        @endif
                      </td>
                      <td>
                        <div class="action-buttons">
                          @if(!$year->is_current)
                            <button class="btn btn-sm btn-success" onclick="setCurrentYear({{ $year->id }})">
                              🎯 Set as Current
                            </button>
                          @endif
                          <button class="btn btn-sm btn-info" onclick="editAcademicYear({{ $year->id }})">
                            ✏️ Edit
                          </button>
                          @if(!$year->is_current)
                            <button class="btn btn-sm btn-danger" onclick="deleteAcademicYear({{ $year->id }})">
                              🗑️ Delete
                            </button>
                          @endif
                        </div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @else
            <div class="no-data">
              <div class="no-data-icon">📅</div>
              <h4>No academic years found</h4>
              <p>Create your first academic year to get started.</p>
            </div>
          @endif
        </section>
      </div>
    </main>
  </div>

  <!-- Add Academic Year Modal -->
  <div id="addYearModal" class="modal">
    <div class="modal-content">
      <div class="modal-header">
        <h3>Add New Academic Year</h3>
        <span class="close" onclick="closeAddYearModal()">&times;</span>
      </div>
      <form id="addYearForm" method="POST" action="{{ route('admin.academic-years.store') }}">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="year_name">Academic Year Name</label>
            <input type="text" id="year_name" name="year_name" placeholder="e.g., 2025-2026" required>
            <small class="form-help">Format: YYYY-YYYY (e.g., 2025-2026)</small>
          </div>
          
          <div class="form-group">
            <label for="start_date">Start Date</label>
            <input type="date" id="start_date" name="start_date" required>
          </div>
          
          <div class="form-group">
            <label for="end_date">End Date</label>
            <input type="date" id="end_date" name="end_date" required>
          </div>
          
          <div class="form-group">
            <label>
              <input type="checkbox" id="is_current" name="is_current" value="1">
              Set as current academic year
            </label>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline" onclick="closeAddYearModal()">Cancel</button>
          <button type="submit" class="btn btn-primary">Add Academic Year</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Edit Academic Year Modal -->
  <div id="editYearModal" class="modal">
    <div class="modal-content">
      <div class="modal-header">
        <h3>Edit Academic Year</h3>
        <span class="close" onclick="closeEditYearModal()">&times;</span>
      </div>
      <form id="editYearForm" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="form-group">
            <label for="edit_year_name">Academic Year Name</label>
            <input type="text" id="edit_year_name" name="year_name" required>
            <small class="form-help">Format: YYYY-YYYY (e.g., 2025-2026)</small>
          </div>
          
          <div class="form-group">
            <label for="edit_start_date">Start Date</label>
            <input type="date" id="edit_start_date" name="start_date" required>
          </div>
          
          <div class="form-group">
            <label for="edit_end_date">End Date</label>
            <input type="date" id="edit_end_date" name="end_date" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline" onclick="closeEditYearModal()">Cancel</button>
          <button type="submit" class="btn btn-primary">Update Academic Year</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    // Global variables
    let currentEditingYearId = null;

    // Modal functions
    function openAddYearModal() {
      document.getElementById('addYearModal').style.display = 'block';
      document.body.style.overflow = 'hidden';
    }

    function closeAddYearModal() {
      document.getElementById('addYearModal').style.display = 'none';
      document.getElementById('addYearForm').reset();
      document.body.style.overflow = 'auto';
    }

    function openEditYearModal() {
      document.getElementById('editYearModal').style.display = 'block';
      document.body.style.overflow = 'hidden';
    }

    function closeEditYearModal() {
      document.getElementById('editYearModal').style.display = 'none';
      document.getElementById('editYearForm').reset();
      currentEditingYearId = null;
      document.body.style.overflow = 'auto';
    }

    // Academic year functions
    function setCurrentYear(yearId) {
      if (confirm('Are you sure you want to set this as the current academic year? This will change the current year setting.')) {
        fetch(`/admin/academic-years/${yearId}/set-current`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          }
        })
        .then(response => {
          if (response.ok) {
            location.reload();
          } else {
            throw new Error('Failed to set current academic year');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Failed to set current academic year. Please try again.');
        });
      }
    }

    function editAcademicYear(yearId) {
      // Fetch academic year data
      fetch(`/admin/academic-years/${yearId}`)
        .then(response => response.json())
        .then(data => {
          // Populate edit form
          document.getElementById('edit_year_name').value = data.year_name;
          document.getElementById('edit_start_date').value = data.start_date;
          document.getElementById('edit_end_date').value = data.end_date;
          
          // Set form action
          document.getElementById('editYearForm').action = `/admin/academic-years/${yearId}`;
          currentEditingYearId = yearId;
          
          // Open modal
          openEditYearModal();
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Failed to load academic year data. Please try again.');
        });
    }

    function deleteAcademicYear(yearId) {
      if (confirm('Are you sure you want to delete this academic year? This action cannot be undone.')) {
        // Create a form to submit DELETE request
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/academic-years/${yearId}`;
        
        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        form.appendChild(csrfToken);
        
        // Add method override for DELETE
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        form.appendChild(methodField);
        
        // Submit form
        document.body.appendChild(form);
        form.submit();
      }
    }

    // Logout functionality
    function confirmExit() {
      if (confirm('Are you sure you want to logout?')) {
        document.getElementById('logout-form').submit();
      }
    }

    // Date validation for add form
    document.getElementById('end_date').addEventListener('change', function() {
      const startDate = new Date(document.getElementById('start_date').value);
      const endDate = new Date(this.value);
      
      if (endDate <= startDate) {
        alert('End date must be after start date');
        this.value = '';
      }
    });

    document.getElementById('start_date').addEventListener('change', function() {
      const startDate = new Date(this.value);
      const endDate = new Date(document.getElementById('end_date').value);
      
      if (endDate && endDate <= startDate) {
        document.getElementById('end_date').value = '';
        alert('Please select a new end date after the start date');
      }
    });

    // Date validation for edit form
    document.getElementById('edit_end_date').addEventListener('change', function() {
      const startDate = new Date(document.getElementById('edit_start_date').value);
      const endDate = new Date(this.value);
      
      if (endDate <= startDate) {
        alert('End date must be after start date');
        this.value = '';
      }
    });

    document.getElementById('edit_start_date').addEventListener('change', function() {
      const startDate = new Date(this.value);
      const endDate = new Date(document.getElementById('edit_end_date').value);
      
      if (endDate && endDate <= startDate) {
        document.getElementById('edit_end_date').value = '';
        alert('Please select a new end date after the start date');
      }
    });

    // Close modals when clicking outside
    window.onclick = function(event) {
      const addModal = document.getElementById('addYearModal');
      const editModal = document.getElementById('editYearModal');
      
      if (event.target == addModal) {
        closeAddYearModal();
      }
      if (event.target == editModal) {
        closeEditYearModal();
      }
    }

    // Close modals with Escape key
    document.addEventListener('keydown', function(event) {
      if (event.key === 'Escape') {
        closeAddYearModal();
        closeEditYearModal();
      }
    });

    // Auto-close success/error messages after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
      const alerts = document.querySelectorAll('.alert');
      alerts.forEach(alert => {
        setTimeout(() => {
          if (alert.parentNode) {
            alert.remove();
          }
        }, 5000);
      });
    });
  </script>
</body>
</html>
