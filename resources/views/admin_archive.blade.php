@extends('layouts.admin_base')

@section('title', 'Admin - Student Archive')
@section('header', 'Student Archive System')

@push('head')
  <link rel="stylesheet" href="{{ asset('css/styles_admin_archive.css') }}">
  <link rel="stylesheet" href="{{ asset('css/styles_admin_dashboard.css') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    .modal.large {
      max-width: 80%;
      max-height: 90%;
    }
    
    .student-details {
      padding: 20px;
    }
    
    .student-header {
      border-bottom: 2px solid #e0e0e0;
      padding-bottom: 15px;
      margin-bottom: 20px;
    }
    
    .student-info h4 {
      margin: 0 0 5px 0;
      color: #2c3e50;
      font-size: 1.5em;
    }
    
    .student-id, .lrn {
      margin: 3px 0;
      color: #7f8c8d;
      font-size: 0.9em;
    }
    
    .details-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 30px;
      margin-bottom: 20px;
    }
    
    .detail-section {
      background: #f8f9fa;
      padding: 15px;
      border-radius: 8px;
      border-left: 4px solid #3498db;
    }
    
    .detail-section h5 {
      margin: 0 0 15px 0;
      color: #2c3e50;
      font-size: 1.1em;
      border-bottom: 1px solid #dee2e6;
      padding-bottom: 8px;
    }
    
    .detail-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 10px;
      padding: 5px 0;
    }
    
    .detail-row .label {
      font-weight: 600;
      color: #495057;
      min-width: 120px;
    }
    
    .detail-row .value {
      color: #212529;
      text-align: right;
      flex: 1;
    }
    
    .grades-table {
      margin-top: 15px;
      overflow-x: auto;
    }
    
    .grades-table table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      border-radius: 5px;
      overflow: hidden;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .grades-table th {
      background: #34495e;
      color: white;
      padding: 10px;
      text-align: center;
      font-size: 0.9em;
    }
    
    .grades-table td {
      padding: 8px 10px;
      text-align: center;
      border-bottom: 1px solid #eee;
    }
    
    .grades-table tr:hover {
      background: #f8f9fa;
    }
    
    .loading {
      text-align: center;
      padding: 40px;
      font-size: 1.1em;
      color: #7f8c8d;
    }
    
    .error {
      text-align: center;
      padding: 40px;
      color: #e74c3c;
    }
    
    @media (max-width: 768px) {
      .details-grid {
        grid-template-columns: 1fr;
        gap: 20px;
      }
      
      .detail-row {
        flex-direction: column;
      }
      
      .detail-row .value {
        text-align: left;
        margin-top: 5px;
      }
    }
    
    /* Logout Modal Styling - Consistent with admin subjects */
    .modal {
      display: none;
      position: fixed;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      justify-content: center;
      align-items: center;
    }

    .modal-content {
      background: white;
      padding: 20px;
      border-radius: 8px;
      text-align: center;
    }

    .confirm-btn, .cancel-btn {
      padding: 10px 20px;
      border: none;
      cursor: pointer;
      margin: 10px;
      border-radius: 8px;
      transition: all 0.3s ease;
    }

    .confirm-btn {
      background: red;
      color: white;
    }

    .cancel-btn {
      background: gray;
      color: white;
    }
  </style>
@endpush

@section('content')
      <div class="container-archive">
        <!-- Archive Controls -->
        <section class="archive-controls">
          <div class="year-selector">
            <label for="year-select">Academic Year:</label>
            <select id="year-select" onchange="changeYear()">
              <option value="current" {{ $selectedYear === 'current' || ($currentAcademicYear && $selectedYear === $currentAcademicYear->year_name) ? 'selected' : '' }}>
                {{ $currentAcademicYear ? $currentAcademicYear->year_name : 'Current Year' }} (Current)
              </option>
              @foreach($academicYears as $year)
                @if(!$year->is_current)
                  <option value="{{ $year->year_name }}" {{ $selectedYear === $year->year_name ? 'selected' : '' }}>
                    {{ $year->year_name }}
                  </option>
                @endif
              @endforeach
            </select>
          </div>

          <div class="archive-actions">
            @if($isCurrentYear && $currentAcademicYear)
              <button class="btn btn-warning" onclick="showArchiveModal()">
                📁 Archive Current Year
              </button>
            @endif
            
            <button class="btn btn-info" onclick="exportYear()">
              📊 Export Data
            </button>
            
            <a href="{{ route('admin.archive.comparison') }}" class="btn btn-secondary">
              📈 Year Comparison
            </a>
            
            <a href="{{ route('admin.academic-years') }}" class="btn btn-outline">
              ⚙️ Academic Years
            </a>
          </div>
        </section>

        <!-- Statistics Cards -->
        <section class="statistics-section">
          <div class="stats-grid">
            <div class="stat-card">
              <div class="stat-icon">👥</div>
              <div class="stat-content">
                <h3>{{ $students->count() }}</h3>
                <p>Total Students</p>
              </div>
            </div>
            
            <div class="stat-card">
              <div class="stat-icon">📚</div>
              <div class="stat-content">
                <h3>{{ $students->groupBy('grade_level_id')->count() }}</h3>
                <p>Grade Levels</p>
              </div>
            </div>
            
            <div class="stat-card">
              <div class="stat-icon">🏫</div>
              <div class="stat-content">
                <h3>{{ $students->groupBy('section_id')->count() }}</h3>
                <p>Sections</p>
              </div>
            </div>
            
            <div class="stat-card">
              <div class="stat-icon">📅</div>
              <div class="stat-content">
                <h3>{{ $selectedYear ?? 'N/A' }}</h3>
                <p>Academic Year</p>
              </div>
            </div>
          </div>
        </section>

        <!-- Search and Filters -->
        <section class="search-section">
          <div class="search-container">
            <input type="text" id="search-input" placeholder="Search students by name, ID, or LRN..." onkeyup="searchStudents()">
            <button class="btn btn-search" onclick="searchStudents()">🔍</button>
          </div>
          
          <div class="filters-container">
            <select id="grade-filter" onchange="filterStudents()">
              <option value="">All Grade Levels</option>
              @if($isCurrentYear)
                @foreach($students->groupBy('grade_level_id') as $gradeLevelId => $gradeStudents)
                  <option value="{{ $gradeLevelId }}">{{ $gradeStudents->first()->gradeLevel->name ?? "Grade {$gradeLevelId}" }}</option>
                @endforeach
              @else
                @foreach($students->groupBy('grade_level_id') as $gradeLevelId => $gradeStudents)
                  <option value="{{ $gradeLevelId }}">{{ $gradeStudents->first()->grade_level_name ?? "Grade {$gradeLevelId}" }}</option>
                @endforeach
              @endif
            </select>
            
            <select id="section-filter" onchange="filterStudents()">
              <option value="">All Sections</option>
              @if($isCurrentYear)
                @foreach($students->groupBy('section_id') as $sectionId => $sectionStudents)
                  @if($sectionStudents->first()->section)
                    <option value="{{ $sectionId }}">{{ $sectionStudents->first()->section->section_name }}</option>
                  @endif
                @endforeach
              @else
                @foreach($students->groupBy('section_id') as $sectionId => $sectionStudents)
                  @if($sectionStudents->first()->section_name)
                    <option value="{{ $sectionId }}">{{ $sectionStudents->first()->section_name }}</option>
                  @endif
                @endforeach
              @endif
            </select>
          </div>
        </section>

        <!-- Students Table -->
        <section class="students-table-section">
          <div class="table-header">
            <h4>Students ({{ $selectedYear ?? 'Current Year' }})</h4>
            <span class="student-count">{{ $students->count() }} students found</span>
          </div>
          
          @if($students->count() > 0)
            <div class="table-container">
              <table id="students-table">
                <thead>
                  <tr>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Grade Level</th>
                    <th>Section</th>
                    <th>Strand</th>
                    <th>Status</th>
                    <th>Date Enrolled</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($students as $student)
                    <tr class="student-row" 
                        data-grade="{{ $isCurrentYear ? $student->grade_level_id : $student->grade_level_id }}"
                        data-section="{{ $isCurrentYear ? $student->section_id : $student->section_id }}"
                        data-search="{{ strtolower(($student->first_name ?? '') . ' ' . ($student->last_name ?? '') . ' ' . ($student->school_student_id ?? '') . ' ' . ($student->lrn ?? '')) }}">
                      <td>{{ $student->school_student_id ?? 'N/A' }}</td>
                      <td>
                        <div class="student-name">
                          <strong>{{ $isCurrentYear ? $student->full_name : $student->full_name }}</strong>
                          @if($student->lrn)
                            <small class="lrn">{{ $student->lrn }}</small>
                          @endif
                        </div>
                      </td>
                      <td>{{ $isCurrentYear ? ($student->gradeLevel->name ?? 'N/A') : ($student->grade_level_name ?? 'N/A') }}</td>
                      <td>{{ $isCurrentYear ? ($student->section->section_name ?? 'N/A') : ($student->section_name ?? 'N/A') }}</td>
                      <td>{{ $isCurrentYear ? ($student->strand->name ?? ($student->section->strand->name ?? 'N/A')) : ($student->strand_name ?? 'N/A') }}</td>
                      <td>
                        <span class="status-badge {{ strtolower($isCurrentYear ? ($student->status->name ?? 'unknown') : ($student->status ?? 'unknown')) }}">
                          {{ $isCurrentYear ? ($student->status->name ?? 'Unknown') : ($student->status ?? 'Unknown') }}
                        </span>
                      </td>
                      <td>{{ $student->date_enrolled ? \Carbon\Carbon::parse($student->date_enrolled)->format('M d, Y') : 'N/A' }}</td>
                      <td>
                        <div class="action-buttons">
                          <button class="btn btn-sm btn-info view-student-btn" 
                                  data-student-id="{{ $isCurrentYear ? $student->student_id : $student->id }}" 
                                  data-is-current="{{ $isCurrentYear ? 'true' : 'false' }}">
                            👁️ View
                          </button>
                          @if(!$isCurrentYear)
                            <button class="btn btn-sm btn-success restore-student-btn" 
                                    data-student-id="{{ $student->id }}">
                              ↩️ Restore
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
              <div class="no-data-icon">📭</div>
              <h4>No students found</h4>
              <p>No students available for the selected academic year.</p>
            </div>
          @endif
        </section>
      </div>
@endsection

  <!-- Archive Confirmation Modal -->
  <div id="archive-modal" class="modal" style="display: none;">
    <div class="modal-content">
      <div class="modal-header">
        <h3>Archive Current Academic Year</h3>
        <button class="close-btn" onclick="closeArchiveModal()">&times;</button>
      </div>
      <div class="modal-body">
        <div class="warning-message">
          <div class="warning-icon">⚠️</div>
          <div class="warning-content">
            <h4>This action cannot be undone!</h4>
            <p>You are about to archive the current academic year <strong>{{ $currentAcademicYear ? $currentAcademicYear->year_name : 'Current Year' }}</strong>.</p>
            <p>This will:</p>
            <ul>
              <li>Create snapshots of all {{ $students->count() }} students and their data</li>
              <li>Archive all grades and attendance records</li>
              <li>Mark the current year as archived</li>
              <li>Set the next academic year as current (if available)</li>
            </ul>
            <p><strong>Please type "yes" to confirm:</strong></p>
            <input type="text" id="confirmation-input" placeholder="Type 'yes' to confirm" class="confirmation-input">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" onclick="closeArchiveModal()">Cancel</button>
        <button class="btn btn-danger" onclick="confirmArchive()" id="confirm-archive-btn" disabled>
          📁 Archive Academic Year
        </button>
      </div>
    </div>
  </div>

  <!-- Student Details Modal -->
  <div id="student-details-modal" class="modal" style="display: none;">
    <div class="modal-content large">
      <div class="modal-header">
        <h3>Student Details</h3>
        <button class="close-btn" onclick="closeStudentModal()">&times;</button>
      </div>
      <div class="modal-body" id="student-details-content">
        <!-- Content loaded via AJAX -->
      </div>
    </div>
  </div>

@push('scripts')
  <script>
    // Global variables
    const currentYear = "{{ $currentAcademicYear ? $currentAcademicYear->year_name : 'current' }}";
    const isCurrentYear = {{ $isCurrentYear ? 'true' : 'false' }};
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Event listeners for action buttons
    document.addEventListener('DOMContentLoaded', function() {
      // View student buttons
      document.addEventListener('click', function(e) {
        if (e.target.classList.contains('view-student-btn')) {
          const studentId = e.target.getAttribute('data-student-id');
          const isCurrent = e.target.getAttribute('data-is-current') === 'true';
          viewStudentDetails(studentId, isCurrent);
        }
      });

      // Restore student buttons
      document.addEventListener('click', function(e) {
        if (e.target.classList.contains('restore-student-btn')) {
          const studentId = e.target.getAttribute('data-student-id');
          restoreStudent(studentId);
        }
      });
    });

    // Year selection
    function changeYear() {
      const selectedYear = document.getElementById('year-select').value;
      window.location.href = `{{ route('admin.archive.year', '') }}/${selectedYear}`;
    }

    // Search functionality
    function searchStudents() {
      const searchTerm = document.getElementById('search-input').value.toLowerCase();
      const rows = document.querySelectorAll('.student-row');
      
      rows.forEach(row => {
        const searchData = row.getAttribute('data-search');
        if (searchData.includes(searchTerm)) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
      
      updateStudentCount();
    }

    // Filter functionality
    function filterStudents() {
      const gradeFilter = document.getElementById('grade-filter').value;
      const sectionFilter = document.getElementById('section-filter').value;
      const rows = document.querySelectorAll('.student-row');
      
      rows.forEach(row => {
        const grade = row.getAttribute('data-grade');
        const section = row.getAttribute('data-section');
        
        const gradeMatch = !gradeFilter || grade === gradeFilter;
        const sectionMatch = !sectionFilter || section === sectionFilter;
        
        if (gradeMatch && sectionMatch) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
      
      updateStudentCount();
    }

    // Update student count
    function updateStudentCount() {
      const visibleRows = document.querySelectorAll('.student-row[style=""], .student-row:not([style])').length;
      document.querySelector('.student-count').textContent = `${visibleRows} students found`;
    }

    // Archive functionality
    function showArchiveModal() {
      document.getElementById('archive-modal').style.display = 'flex';
      document.getElementById('confirmation-input').focus();
    }

    function closeArchiveModal() {
      document.getElementById('archive-modal').style.display = 'none';
      document.getElementById('confirmation-input').value = '';
      document.getElementById('confirm-archive-btn').disabled = true;
    }

    // Enable/disable confirm button based on input
    document.getElementById('confirmation-input').addEventListener('input', function() {
      const confirmBtn = document.getElementById('confirm-archive-btn');
      confirmBtn.disabled = this.value.toLowerCase() !== 'yes';
    });

    function confirmArchive() {
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = '{{ route("admin.archive.current") }}';
      
      const csrfInput = document.createElement('input');
      csrfInput.type = 'hidden';
      csrfInput.name = '_token';
      csrfInput.value = csrfToken;
      
      const confirmationInput = document.createElement('input');
      confirmationInput.type = 'hidden';
      confirmationInput.name = 'confirmation';
      confirmationInput.value = 'yes';
      
      form.appendChild(csrfInput);
      form.appendChild(confirmationInput);
      document.body.appendChild(form);
      form.submit();
    }

    // Export functionality
    function exportYear() {
      const selectedYear = document.getElementById('year-select').value;
      window.location.href = `{{ route('admin.archive.export', '') }}/${selectedYear}`;
    }

    // Student details
    function viewStudentDetails(studentId, isCurrent) {
      console.log('Viewing student details:', { studentId, isCurrent });
      
      // Validate student ID
      if (!studentId || studentId === 'null' || studentId === 'undefined') {
        document.getElementById('student-details-modal').style.display = 'flex';
        document.getElementById('student-details-content').innerHTML = `
          <div class="error">
            <p>❌ Error: Invalid student ID</p>
          </div>
        `;
        return;
      }
      
      document.getElementById('student-details-modal').style.display = 'flex';
      document.getElementById('student-details-content').innerHTML = '<div class="loading">Loading student details...</div>';
      
      // Make AJAX call to get student details
      const baseUrl = "{{ url('/admin/archive/student') }}";
      const url = `${baseUrl}/${studentId}?current=${isCurrent}`;
      console.log('Fetching URL:', url);
      
      fetch(url, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken
        }
      })
      .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
      })
      .then(data => {
        console.log('Student data received:', data);
        displayStudentDetails(data, isCurrent);
      })
      .catch(error => {
        console.error('Error fetching student details:', error);
        document.getElementById('student-details-content').innerHTML = `
          <div class="error">
            <p>❌ Error loading student details: ${error.message}</p>
            <p>Please check the console for more details.</p>
          </div>
        `;
      });
    }

    function displayStudentDetails(student, isCurrent) {
      let gradesHtml = '';
      
      // Handle grades for current students
      if (isCurrent && student.grades && student.grades.length > 0) {
        gradesHtml += '<div class="detail-section"><h5>Grades</h5><div class="grades-table"><table><thead><tr><th>Subject</th><th>1st Q</th><th>2nd Q</th><th>3rd Q</th><th>4th Q</th><th>Final</th></tr></thead><tbody>';
        student.grades.forEach(grade => {
          gradesHtml += '<tr><td>' + (grade.subject_relation?.name || grade.subject || 'N/A') + '</td>';
          gradesHtml += '<td>' + (grade.first_quarter || '-') + '</td>';
          gradesHtml += '<td>' + (grade.second_quarter || '-') + '</td>';
          gradesHtml += '<td>' + (grade.third_quarter || '-') + '</td>';
          gradesHtml += '<td>' + (grade.fourth_quarter || '-') + '</td>';
          gradesHtml += '<td><strong>' + (grade.final_grade || '-') + '</strong></td></tr>';
        });
        gradesHtml += '</tbody></table></div></div>';
      }
      
      // Handle grades for archived students
      if (!isCurrent && student.grades && student.grades.length > 0) {
        gradesHtml += '<div class="detail-section"><h5>Archived Grades</h5><div class="grades-table"><table><thead><tr><th>Subject</th><th>1st Q</th><th>2nd Q</th><th>3rd Q</th><th>4th Q</th><th>Final</th></tr></thead><tbody>';
        student.grades.forEach(grade => {
          gradesHtml += '<tr><td>' + (grade.subject_name || 'N/A') + '</td>';
          gradesHtml += '<td>' + (grade.first_quarter || '-') + '</td>';
          gradesHtml += '<td>' + (grade.second_quarter || '-') + '</td>';
          gradesHtml += '<td>' + (grade.third_quarter || '-') + '</td>';
          gradesHtml += '<td>' + (grade.fourth_quarter || '-') + '</td>';
          gradesHtml += '<td><strong>' + (grade.final_grade || '-') + '</strong></td></tr>';
        });
        gradesHtml += '</tbody></table></div></div>';
      }
      
      const content = `
        <div class="student-details">
          <div class="student-header">
            <div class="student-info">
              <h4>${student.first_name} ${student.middle_name || ''} ${student.last_name} ${student.suffix || ''}</h4>
              <p class="student-id">Student ID: ${student.school_student_id || student.student_number || 'N/A'}</p>
              <p class="lrn">LRN: ${student.lrn || 'N/A'}</p>
            </div>
          </div>
          
          <div class="details-grid">
            <div class="detail-section">
              <h5>Personal Information</h5>
              <div class="detail-row">
                <span class="label">Gender:</span>
                <span class="value">${student.gender || 'N/A'}</span>
              </div>
              <div class="detail-row">
                <span class="label">Date of Birth:</span>
                <span class="value">${student.date_of_birth ? new Date(student.date_of_birth).toLocaleDateString() : 'N/A'}</span>
              </div>
              <div class="detail-row">
                <span class="label">Contact:</span>
                <span class="value">${student.contact_number || 'N/A'}</span>
              </div>
              <div class="detail-row">
                <span class="label">Email:</span>
                <span class="value">${student.email || 'N/A'}</span>
              </div>
              <div class="detail-row">
                <span class="label">Address:</span>
                <span class="value">${student.address || 'N/A'}</span>
              </div>
            </div>
            
            <div class="detail-section">
              <h5>Academic Information</h5>
              <div class="detail-row">
                <span class="label">Grade Level:</span>
                <span class="value">${isCurrent ? (student.grade_level?.name || 'N/A') : (student.grade_level_name || 'N/A')}</span>
              </div>
              <div class="detail-row">
                <span class="label">Section:</span>
                <span class="value">${isCurrent ? (student.section?.section_name || 'N/A') : (student.section_name || 'N/A')}</span>
              </div>
              <div class="detail-row">
                <span class="label">Strand:</span>
                <span class="value">${isCurrent ? (student.strand?.name || 'N/A') : (student.strand_name || 'N/A')}</span>
              </div>
              <div class="detail-row">
                <span class="label">Status:</span>
                <span class="value">${isCurrent ? (student.status?.name || 'N/A') : (student.status || 'N/A')}</span>
              </div>
              <div class="detail-row">
                <span class="label">Date Enrolled:</span>
                <span class="value">${student.date_enrolled ? new Date(student.date_enrolled).toLocaleDateString() : 'N/A'}</span>
              </div>
            </div>
          </div>
          
          ${gradesHtml}
        </div>
      `;
      
      document.getElementById('student-details-content').innerHTML = content;
    }

    function closeStudentModal() {
      document.getElementById('student-details-modal').style.display = 'none';
    }

    // Restore student
    function restoreStudent(studentId) {
      if (confirm('Are you sure you want to restore this student to the current academic year?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `{{ route('admin.archive.restore', '') }}/${studentId}`;
        
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;
        
        form.appendChild(csrfInput);
        document.body.appendChild(form);
        form.submit();
      }
    }

    // Close modals when clicking outside
    window.onclick = function(event) {
      const archiveModal = document.getElementById('archive-modal');
      const studentModal = document.getElementById('student-details-modal');
      
      if (event.target === archiveModal) {
        closeArchiveModal();
      }
      if (event.target === studentModal) {
        closeStudentModal();
      }
    }

    // Logout functionality - using modal instead of alert
    function confirmExit() {
      const modal = document.getElementById('confirm-modal');
      if (modal) {
        modal.style.display = 'flex';
      }
    }
  </script>

  <!-- Logout Confirmation Modal -->
  <div id="confirm-modal" class="modal" style="display: none;">
    <div class="modal-content">
      <p>Are you sure you want to log out?</p>
      <button class="confirm-btn" onclick="logout(event)">Yes, Logout</button>
      <button class="cancel-btn" onclick="closeModal()">No</button>
    </div>
  </div>

  <!-- Modal Functions -->
  <script>
    function closeModal() {
      const modal = document.getElementById('confirm-modal');
      if (modal) {
        modal.style.display = 'none';
      }
    }
  </script>
@endpush

@push('scripts')
  <script src="{{ asset('js/logout.js') }}?v={{ time() }}"></script>
@endpush
